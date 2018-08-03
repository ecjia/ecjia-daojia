<?php

namespace Ecjia\App\Wechat\Handlers;

use RC_Hook;
use Ecjia\App\Wechat\Models\WechatReplyModel;
use Ecjia\App\Wechat\WechatRecord;
use Ecjia\App\Wechat\WechatUUID;
use Ecjia\App\Wechat\WechatMediaReply;
use Ecjia\App\Wechat\WechatCommand;
use Ecjia\App\Wechat\Models\WechatMassHistoryModel;
use Ecjia\App\Wechat\Models\WechatUserModel;

class WechatEventHandler
{
    /**
     * 事件消息请求
     * @param \Royalcms\Component\Support\Collection $message
     * @return \Royalcms\Component\WeChat\Message\AbstractMessage
     */
    public static function getEventHandler($message)
    {
        switch ($message->Event) {
            case 'subscribe':
                return self::Subscribe_event($message);
                break;
                
            case 'unsubscribe':
                return self::Unsubscribe_event($message);
                break;
                
            case 'SCAN':
                return self::Scan_event($message);
                break;
                
            case 'CLICK':
                return self::Click_event($message);
                break;
                
            case 'VIEW':
                return self::View_event($message);
                break;
                
            case 'LOCATION':
                return self::Location_event($message);
                break;
                
            case 'scancode_push':
                return self::Scancode_Push_event($message);
                break;
                
            case 'scancode_waitmsg':
                return self::Scancode_WaitMsg_event($message);
                break;
                
            case 'pic_sysphoto':
                return self::Pic_SysPhoto_event($message);
                break;
                
            case 'pic_photo_or_album':
                return self::Pic_PhotoOrAlbum_event($message);
                break;
                
            case 'pic_weixin':
                return self::Pic_Weixin_event($message);
                break;
                
            case 'location_select':
                return self::Location_event($message);
                break;
                
            case 'TEMPLATESENDJOBFINISH':
                return self::TemplateSendJobFinish_event($message);
                break;
                
            case 'MASSSENDJOBFINISH':
                self::MassSendJobFinish_event($message);
                break;
                
            default:
                return self::Default_event($message);
                break;
        }
        
        // ...
    }
    
    /**
     * 文本回复
     * @param \Royalcms\Component\Support\Collection $message
     * @return \Royalcms\Component\WeChat\Message\AbstractMessage
     */
    public static function Default_event($message) 
    {
        
    }
    
    /**
     * 点击菜单拉取消息时的事件推送
     * @param \Royalcms\Component\Support\Collection $message
     * @return \Royalcms\Component\WeChat\Message\AbstractMessage 
     */
    public static function Click_event($message) {
        RC_Hook::add_filter('wechat_event_response', array(__CLASS__, 'Command_event'), 10, 2);
        RC_Hook::add_filter('wechat_event_response', array(__CLASS__, 'Keyword_event'), 90, 2);
        RC_Hook::add_filter('wechat_event_response', array('\Ecjia\App\Wechat\Handlers\WechatMessageHandler', 'Empty_reply'), 100, 2);
        
        $response = RC_Hook::apply_filters('wechat_event_response', null, $message);
        
        return $response;
    }
    
    /**
     * 点击菜单跳转链接时的事件推送
     * @param \Royalcms\Component\Support\Collection $message
     * @return \Royalcms\Component\WeChat\Message\AbstractMessage
     */
    public static function View_event($message) 
    {
        
    }
    
    /**
     * 上报地理位置事件
     * @param \Royalcms\Component\Support\Collection $message
     */
    public static function Location_event($message)
    {
        $openid = $message->get('FromUserName');

        $data = [
            'location_latitude' => $message->get('Latitude'),
            'location_longitude' => $message->get('Longitude'),
            'location_precision' => $message->get('Precision'),
            'location_updatetime' => \RC_Time::gmtime(),
        ];

        WechatUserModel::where('openid', $openid)->update($data);
        
    }
    
    
    /**
     * 关键字回复
     * @param \Royalcms\Component\WeChat\Message\AbstractMessage $content
     * @param \Royalcms\Component\Support\Collection $message
     * @return \Royalcms\Component\WeChat\Message\AbstractMessage
     */
    public static function Keyword_event($content, $message) {
        if (!is_null($content)) {
            return $content;
        }
        
        $wechat_id = with(new WechatUUID())->getWechatID();
        $rule_keywords  = $message->get('EventKey');
        
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
        }
        
        return $content;
    }
    
    
    /**
     * 命令回复
     * @param \Royalcms\Component\WeChat\Message\AbstractMessage $content
     * @param \Royalcms\Component\Support\Collection $message
     * @return \Royalcms\Component\WeChat\Message\AbstractMessage
     */
    public static function Command_event($content, $message)
    {
        if (!is_null($content)) {
            return $content;
        }
        
        $content = with(new WechatCommand($message, new WechatUUID()))->runCommand($message->get('EventKey'));
        
        if (is_string($content)) {
            $content = WechatRecord::Text_reply($message, $content);
        }
        
        return $content;
    }
    
    /**
     * 扫码推事件的事件
     * @param \Royalcms\Component\Support\Collection $message
     */
    public static function Scancode_Push_event($message)
    {
        
    }
    
    /**
     * 扫码推事件且弹出“消息接收中”提示框的事件
     * @param \Royalcms\Component\Support\Collection $message
     */
    public static function Scancode_WaitMsg_event($message)
    {
        
    }
    
    /**
     * 弹出系统拍照发图的事件
     * @param \Royalcms\Component\Support\Collection $message
     */
    public static function Pic_SysPhoto_event($message)
    {
        
    }
    
    /**
     * 弹出拍照或者相册发图的事件
     * @param \Royalcms\Component\Support\Collection $message
     */
    public static function Pic_PhotoOrAlbum_event($message)
    {
        
    }
    
    /**
     * 弹出微信相册发图器的事件
     * @param \Royalcms\Component\Support\Collection $message
     */
    public static function Pic_Weixin_event($message)
    {
        
    }
    
    /**
     * 弹出地理位置选择器的事件
     * @param \Royalcms\Component\Support\Collection $message
     */
    public static function Location_Select_event($message)
    {


    }
    
    /**
     * 模板消息发送成功
     * @param \Royalcms\Component\Support\Collection $message
     */
    public static function TemplateSendJobFinish_event($message)
    {
        
    }
    
    /**
     * 关注时的事件
     * @param \Royalcms\Component\Support\Collection $message
     */
    public static function Subscribe_event($message)
    {
        return with(new WechatSubscribeHandler($message))->subscribe();
    }
    
    /**
     * 取消关注时的事件
     * @param \Royalcms\Component\Support\Collection $message
     */
    public static function Unsubscribe_event($message)
    {
        return with(new WechatSubscribeHandler($message))->unsubscribe();
    }
    
    /**
     * 用户已关注时的事件
     * @param \Royalcms\Component\Support\Collection $message
     */
    public static function Scan_event($message)
    {
        return with(new WechatScanHandler($message))->getScanEventHandler();
    }
    
    /**
     * 群发发送成功之后推送的事件
     * @param \Royalcms\Component\Support\Collection $message
     */
    public static function MassSendJobFinish_event($message)
    {
        $wechatUUID = new WechatUUID();
        $wechat_id = $wechatUUID->getWechatId();

        $data = [
            'status'                => $message->get('Status'),
            'totalcount'            => $message->get('TotalCount'),
            'filtercount'           => $message->get('FilterCount'),
            'sentcount'             => $message->get('SentCount'),
            'errorcount'            => $message->get('ErrorCount'),
            'copyright_check_result' => serialize($message->get('CopyrightCheckResult')),
            'check_state'            => array_get($message->get('CopyrightCheckResult'), 'CheckState'),
        ];
        
        WechatMassHistoryModel::where('wechat_id', $wechat_id)->where('msg_id', $message->get('MsgID'))->update($data);

        return;
    }
}
