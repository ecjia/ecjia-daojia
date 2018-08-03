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
