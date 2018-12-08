<?php
//
//    ______         ______           __         __         ______
//   /\  ___\       /\  ___\         /\_\       /\_\       /\  __ \
//   \/\  __\       \/\ \____        \/\_\      \/\_\      \/\ \_\ \
//    \/\_____\      \/\_____\     /\_\/\_\      \/\_\      \/\_\ \_\
//     \/_____/       \/_____/     \/__\/_/       \/_/       \/_/ /_/
//
//   上海商创网络科技有限公司
//
//  ---------------------------------------------------------------------------------
//
//   一、协议的许可和权利
//
//    1. 您可以在完全遵守本协议的基础上，将本软件应用于商业用途；
//    2. 您可以在协议规定的约束和限制范围内修改本产品源代码或界面风格以适应您的要求；
//    3. 您拥有使用本产品中的全部内容资料、商品信息及其他信息的所有权，并独立承担与其内容相关的
//       法律义务；
//    4. 获得商业授权之后，您可以将本软件应用于商业用途，自授权时刻起，在技术支持期限内拥有通过
//       指定的方式获得指定范围内的技术支持服务；
//
//   二、协议的约束和限制
//
//    1. 未获商业授权之前，禁止将本软件用于商业用途（包括但不限于企业法人经营的产品、经营性产品
//       以及以盈利为目的或实现盈利产品）；
//    2. 未获商业授权之前，禁止在本产品的整体或在任何部分基础上发展任何派生版本、修改版本或第三
//       方版本用于重新开发；
//    3. 如果您未能遵守本协议的条款，您的授权将被终止，所被许可的权利将被收回并承担相应法律责任；
//
//   三、有限担保和免责声明
//
//    1. 本软件及所附带的文件是作为不提供任何明确的或隐含的赔偿或担保的形式提供的；
//    2. 用户出于自愿而使用本软件，您必须了解使用本软件的风险，在尚未获得商业授权之前，我们不承
//       诺提供任何形式的技术支持、使用担保，也不承担任何因使用本软件而产生问题的相关责任；
//    3. 上海商创网络科技有限公司不对使用本产品构建的商城中的内容信息承担责任，但在不侵犯用户隐
//       私信息的前提下，保留以任何方式获取用户信息及商品信息的权利；
//
//   有关本产品最终用户授权协议、商业授权与技术服务的详细内容，均由上海商创网络科技有限公司独家
//   提供。上海商创网络科技有限公司拥有在不事先通知的情况下，修改授权协议的权力，修改后的协议对
//   改变之日起的新授权用户生效。电子文本形式的授权协议如同双方书面签署的协议一样，具有完全的和
//   等同的法律效力。您一旦开始修改、安装或使用本产品，即被视为完全理解并接受本协议的各项条款，
//   在享有上述条款授予的权力的同时，受到相关的约束和限制。协议许可范围以外的行为，将直接违反本
//   授权协议并构成侵权，我们有权随时终止授权，责令停止损害，并保留追究相关责任的权力。
//
//  ---------------------------------------------------------------------------------
//
namespace Ecjia\App\Wechat\Handlers;

use Ecjia\App\Wechat\WechatUUID;
use Ecjia\App\Wechat\WechatRecord;
use Ecjia\App\Wechat\WechatCommand;
use Ecjia\App\Wechat\Models\WechatQrcodeModel;
use Ecjia\App\Wechat\Models\WechatReplyModel;
use Ecjia\App\Wechat\WechatMediaReply;
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