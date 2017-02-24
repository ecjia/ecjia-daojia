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
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 后台微信公众平台
 * @author royalwang
 */
class wechat_platform_response_api extends Component_Event_Api
{

    public function call(&$options)
    {
        define('WECHAT_LOG_FILE', SITE_LOG_PATH . 'wechat_' . date('Y-m-d') . '.log');

        RC_Loader::load_app_class('wechat_action', 'wechat', false);
        
        $config = array(
            'token'     => $options['token'],
            'appid'     => $options['appid'],
            'appsecret' => $options['appsecret'],
            'aeskey'    => $options['aeskey'],
        );
        $wechat = new Component_WeChat_WeChat($config);
        
        $wechat
            //回复文本消息
            ->on('Text', array('wechat_action', 'Text_action'))
            //回复图片消息
            ->on('Image', array('wechat_action', 'Image_action'))
            //回复语音消息
            ->on('Voice', array('wechat_action', 'Voice_action'))
            //回复视频消息
            ->on('Video', array('wechat_action', 'Video_action'))
            //回复音乐消息
            ->on('Music', array('wechat_action', 'Music_action'))
            //回复图文消息
            ->on('Articles', array('wechat_action', 'Articles_action'))
            
            //普通消息-小视频
            ->on('Shortvideo', array('wechat_action', 'Shortvideo_action'))
            //普通消息-地理位置
            ->on('Location', array('wechat_action', 'Location_action'))
            //普通消息-链接
            ->on('Link', array('wechat_action', 'Link_action'))
            //上报地理位置事件
            ->on('ReportLocation', array('wechat_action', 'ReportLocation_action'))
            //关注时
            ->on('Subscribe', array('wechat_action', 'Subscribe_action'))
            //用户已关注时的事件
            ->on('Scan', array('wechat_action', 'Scan_action'))
            //取消关注时
            ->on('Unsubscribe', array('wechat_action', 'Unsubscribe_action'))
            //自定义菜单点击事件
            ->on('Click', array('wechat_action', 'Click_action'))
            //自定义菜单跳转链接时的事件
            ->on('View', array('wechat_action', 'View_action'))
            //扫码推事件的事件
            ->on('Scancode_Push', array('wechat_action', 'Scancode_Push_action'))
            //扫码推事件且弹出“消息接收中”提示框的事件
            ->on('Scancode_WaitMsg', array('wechat_action', 'Scancode_WaitMsg_action'))
            //弹出系统拍照发图的事件
            ->on('Pic_SysPhoto', array('wechat_action', 'Pic_SysPhoto_action'))
            //弹出拍照或者相册发图的事件
            ->on('Pic_photo_or_album', array('wechat_action', 'pic_photo_or_album_action'))
            //弹出微信相册发图器的事件
            ->on('Pic_Weixin', array('wechat_action', 'Pic_Weixin_action'))
            //弹出地理位置选择器的事件
            ->on('Location_Select', array('wechat_action', 'Location_Select_action'))
            //模板消息发送成功
            ->on('TemplateSendJobFinish', array('wechat_action', 'TemplateSendJobFinish_action'))
            //客服消息接入会话的事件
            ->on('Kf_Create_Session', array('wechat_action', 'Kf_Create_Session_action'))
            //客服消息关闭会话的事件
            ->on('Kf_Close_Session', array('wechat_action', 'Kf_Close_Session_action'))
            //客服消息转接会话的事件
            ->on('Kf_Switch_Session', array('wechat_action', 'Kf_Switch_Session_action'))
            //群发发送成功
            ->on('MassSendJobFinish', array('wechat_action', 'MassSendJobFinish_action'));
        
        $request  = Component_WeChat_Request::createFromGlobals();
        
        RC_Logger::getLogger('wechat')->debug('REQUEST: ' . json_encode($request->getParameters()));
        
        $response = $wechat->handle($request);
        $response->send();
    }
}

// end