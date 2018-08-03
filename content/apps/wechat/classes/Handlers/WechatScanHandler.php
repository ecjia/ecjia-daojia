<?php

namespace Ecjia\App\Wechat\Handlers;

use Ecjia\App\Wechat\WechatUUID;
use Ecjia\App\Wechat\WechatRecord;
use Ecjia\App\Wechat\WechatCommand;
use Ecjia\App\Wechat\Models\WechatQrcodeModel;
use Ecjia\App\Wechat\Models\WechatReplyModel;
use Ecjia\App\Wechat\Models\WechatMediaReply;
use RC_Time;
use RC_Hook;

class WechatScanHandler
{
    protected $message;
    
    protected $wechatUUID;
    
    protected $eventType;
    
    protected $eventKey;
    
    protected $ticket;
    
    const EVENT_TYPE_SUBSCRIBE = 'subscribe';
    
    const EVENT_TYPE_SCAN = 'scan';
    
    public function __construct($message)
    {
        
        $this->message = $message;
        
        $this->wechatUUID = new WechatUUID();
        
        if ($this->message->get('Event') == 'subscribe') {
            $this->eventType = self::EVENT_TYPE_SUBSCRIBE;
            $this->eventKey = str_replace('qrscene_', '', $this->message->get('EventKey'));
            
        } else {
            $this->eventType = self::EVENT_TYPE_SCAN;
            $this->eventKey = $this->message->get('EventKey');
        }
        
        $this->ticket = $this->message->get('Ticket');
    }
    
    /**
     * 根据$this->eventKey参数决定做什么
     */
    public function getScanEventHandler()
    {
        $time = RC_Time::gmtime();
        $wechatUUID = new WechatUUID();
        $wechat_id = $wechatUUID->getWechatID();

        $model = WechatQrcodeModel::where('status', 1)
            ->where('wechat_id', $wechat_id)
            ->where('scene_id', $this->eventKey)
            ->orderBy('sort', 'ASC')
            ->first();

        if (! empty($model) ) {
            $model->scan_num = $model->scan_num + 1;
            $model->save();

            //临时二维码，并且未过期
            //永久二维码，不需要判断过期时间
            if ((intval($model->type) === 0 && $model->endtime > $time) ||
                (intval($model->type) === 1)
            ) {
                $function = $model->function;

                //如果自定义功能为空，直接返回交与后续逻辑处理
                if (empty($function)) {
                    return null;
                }

                RC_Hook::add_filter('wechat_scan_response', array(__CLASS__, 'Command_reply'), 10, 4);
                RC_Hook::add_filter('wechat_scan_response', array(__CLASS__, 'Keyword_reply'), 90, 4);

                $response = RC_Hook::apply_filters('wechat_scan_response', null, $this->message, $function, $wechatUUID);

                return $response;
            }

            return null;
        }
    }


    /**
     * 命令回复
     * @param \Royalcms\Component\WeChat\Message\AbstractMessage $content
     * @param \Royalcms\Component\Support\Collection $message
     * @param string $function
     * @param \Ecjia\App\Wechat\WechatUUID $wechatUUID
     * @return \Royalcms\Component\WeChat\Message\AbstractMessage
     */
    public static function Command_reply($content, $message, $function, $wechatUUID)
    {
        if (!is_null($content)) {
            return $content;
        }

        $content = with(new WechatCommand($message, $wechatUUID))->runCommand($function);

        //内容为空，返回null
        if (empty($content)) {
            return null;
        }

        if (is_string($content)) {
            $content = WechatRecord::Text_reply($message, $content);
        }

        return $content;
    }


    /**
     * 关键字回复
     * @param \Royalcms\Component\WeChat\Message\AbstractMessage $content
     * @param \Royalcms\Component\Support\Collection $message
     * @param string $function
     * @param \Ecjia\App\Wechat\WechatUUID $wechatUUID
     * @return \Royalcms\Component\WeChat\Message\AbstractMessage
     */
    public static function Keyword_reply($content, $message, $function, $wechatUUID) {
        if (!is_null($content)) {
            return $content;
        }

        $wechat_id = $wechatUUID->getWechatID();
        $rule_keywords  = $function;

        //用户输入信息记录
        WechatRecord::inputMsg($message->get('FromUserName'), $rule_keywords);

        $model = WechatReplyModel::leftJoin('wechat_rule_keywords', 'wechat_rule_keywords.rid', '=', 'wechat_reply.id')
            ->select('wechat_reply.content', 'wechat_reply.media_id', 'wechat_reply.reply_type')
            ->where('wechat_reply.wechat_id', $wechat_id)
            ->where('wechat_rule_keywords.rule_keywords', $rule_keywords)->first();

        if (! empty($model)) {
            if ($model->media_id) {
                $content = with(new WechatMediaReply($wechat_id, $model->media_id))->replyContent($message);
            } else {
                $content = WechatRecord::Text_reply($message, $model->content);
            }

            return $content;
        }

        //内容为空，返回null
        return null;
    }
}