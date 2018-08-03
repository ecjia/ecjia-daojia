<?php

namespace Ecjia\App\Wechat\Handlers;

use RC_Hook;
use Ecjia\App\Wechat\Models\WechatReplyModel;
use Ecjia\App\Wechat\WechatRecord;
use Ecjia\App\Wechat\WechatUUID;
use Ecjia\App\Wechat\WechatMediaReply;
use Ecjia\App\Wechat\WechatCommand;

class WechatMessageHandler
{
    /**
     * 消息请求
     * @param \Royalcms\Component\Support\Collection $message
     * @return \Royalcms\Component\WeChat\Message\AbstractMessage
     */
    public static function getMessageHandler($message)
    {
        //微信请求日志
        \RC_Logger::getLogger('wechat')->info('Accept Message: ' . json_encode($message->all()));
        
        switch ($message->MsgType) {
            case 'event':
                return WechatEventHandler::getEventHandler($message);
                break;
                
                //回复文本消息
            case 'text':
                return self::Text_action($message);
                break;
                
                //回复图片消息
            case 'image':
                return self::Image_action($message);
                break;
                
                //回复语音消息
            case 'voice':
                return self::Voice_action($message);
                break;
                
                //回复视频消息
            case 'video':
                return self::Video_action($message);
                break;
                
            case 'music':
                return self::Music_action($message);
                break;
                
                //普通消息-地理位置
            case 'location':
                return self::Location_action($message);
                break;
                
                //普通消息-链接
            case 'link':
                return self::Link_action($message);
                break;
                
            case 'transfer_customer_service':
                
                break;
                
                // ... 其它消息
            default:
                return self::Default_action($message);
                break;
        }
        
        // ...
    }
    
    /**
     * 文本回复
     * @param \Royalcms\Component\Support\Collection $message
     * @return \Royalcms\Component\WeChat\Message\AbstractMessage
     */
    public static function Default_action($message) 
    {
        return self::Text_action($message);
    }
    
    
    /**
     * 文本请求
     * @param \Royalcms\Component\Support\Collection $message
     * @return \Royalcms\Component\WeChat\Message\AbstractMessage
     */
    public static function Text_action($message) 
    {
        
        RC_Hook::add_filter('wechat_text_response', array(__CLASS__, 'Command_reply'), 10, 2);
        RC_Hook::add_filter('wechat_text_response', array(__CLASS__, 'Keyword_reply'), 90, 2);
        RC_Hook::add_filter('wechat_text_response', array(__CLASS__, 'Empty_reply'), 100, 2);
        
        $response = RC_Hook::apply_filters('wechat_text_response', null, $message);
        
        return $response;
    }
    
    
    /**
     * 消息为空情况下回复
     * @param \Royalcms\Component\WeChat\Message\AbstractMessage $content
     * @param \Royalcms\Component\Support\Collection $message
     * @return \Royalcms\Component\WeChat\Message\AbstractMessage 
     */
    public static function Empty_reply($content, $message) 
    {
        if (!is_null($content)) {
            return $content;
        }
        
        $wechat_id = with(new WechatUUID())->getWechatID();
        
        $data = WechatReplyModel::select('reply_type', 'content', 'media_id')
                                ->where('wechat_id', $wechat_id)->where('type', 'msg')->first();
                                
        if ( ! empty($data)) {
            if ($data->reply_type == 'text') {
                $content = WechatRecord::Text_reply($message, $data['content']);
            } else {
                $content = with(new WechatMediaReply($wechat_id, $data->media_id))->replyContent($message);
            }
        }
        
        return $content;
    }
    
    /**
     * 关键字回复
     * @param \Royalcms\Component\WeChat\Message\AbstractMessage $content
     * @param \Royalcms\Component\Support\Collection $message
     * @return \Royalcms\Component\WeChat\Message\AbstractMessage
     */
    public static function Keyword_reply($content, $message) {
        if (!is_null($content)) {
            return $content;
        }
        
        $wechat_id = with(new WechatUUID())->getWechatID();
        $rule_keywords  = $message->get('Content');
        
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
    public static function Command_reply($content, $message) 
    {
        if (!is_null($content)) {
            return $content;
        }
        
        $content = with(new WechatCommand($message, new WechatUUID()))->runCommand($message->get('Content'));
        
        if (is_string($content)) {
            $content = WechatRecord::Text_reply($message, $content);
        }
        
        return $content;
    }
    
    /**
     * 图片请求
     * @param \Royalcms\Component\Support\Collection $message
     * @return \Royalcms\Component\WeChat\Message\AbstractMessage
     */
    public static function Image_action($message) 
    {
        $content = WechatRecord::Image_reply($message, $message->get('MediaId'));
        return $content;
    }
    
    /**
     * 语音请求
     * @param \Royalcms\Component\Support\Collection $message
     * @return \Royalcms\Component\WeChat\Message\AbstractMessage
     */
    public static function Voice_action($message) 
    {
        $content = WechatRecord::Voice_reply($message, $message->get('MediaId'));
        return $content;
    }
    
    /**
     * 视频请求
     * @param \Royalcms\Component\Support\Collection $message
     * @return \Royalcms\Component\WeChat\Message\AbstractMessage
     */
    public static function Video_action($message) 
    {
        return WechatRecord::Text_reply($message, '视频消息已经收到');
    }
    
    /**
     * 音乐请求
     * @param \Royalcms\Component\Support\Collection $message
     * @return \Royalcms\Component\WeChat\Message\AbstractMessage
     */
    public static function Music_action($message) 
    {
        $content = WechatRecord::Music_reply($message, 'test', 'testcontent', '', '', '');
        return $content;
    }
    
    /**
     * 普通消息-小视频
     * @param \Royalcms\Component\Support\Collection $message
     */
    public static function Shortvideo_action($message)
    {
        return WechatRecord::Text_reply($message, '小视频消息已经收到');
    }
    
    /**
     * 普通消息-地理位置
     * @param \Royalcms\Component\Support\Collection $message
     */
    public static function Location_action($message)
    {
        return WechatRecord::Text_reply($message, '地理位置已经收到');
    }
    
    /**
     * 普通消息-链接
     * @param \Royalcms\Component\Support\Collection $message
     */
    public static function Link_action($message)
    {
        return WechatRecord::Text_reply($message, '链接消息已经收到');
    }
    
    
}