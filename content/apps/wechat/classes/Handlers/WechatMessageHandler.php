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
        $rule_keywords  = $message->get('Content');

        //用户输入信息记录
        WechatRecord::inputMsg($message->get('FromUserName'), $rule_keywords);
        
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