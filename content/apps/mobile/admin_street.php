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


class admin_street extends ecjia_admin
{
    
    public function __construct()
    {
        parent::__construct();
        
        RC_Style::enqueue_style('mobile_street', RC_App::apps_url('statics/css/mobile_street.css', __FILE__));
        RC_Script::enqueue_script('mobile_street', RC_App::apps_url('statics/js/mobile_street.js', __FILE__), array(), false, true);
    }
    
    
    public function init()
    {
    	$this->admin_priv('mobile_street');
    	$this->assign('ur_here', '云店铺');
        ecjia_screen::$current_screen->add_nav_here(new admin_nav_here(__('云店铺')));
        ecjia_screen::get_current_screen()->add_help_tab(array(
        	'id'		=> 'dianpujie',
        	'title'		=> '店铺街',
        	'content'	=>
        	'<p>' . RC_Lang::get('mobile::mobile.dianpujie_pub_list') . '</p>'
        ));
        ecjia_screen::get_current_screen()->add_help_tab(array(
        'id'		=> 'zhangggui',
        'title'		=> '掌柜',
        'content'	=>
        '<p>' . RC_Lang::get('mobile::mobile.zhanggui_pub_list') . '</p>'
        ));
        ecjia_screen::get_current_screen()->add_help_tab(array(
        'id'		=> 'peisongyuan',
        'title'		=> '配送员',
        'content'	=>
        '<p>' . RC_Lang::get('mobile::mobile.peisong_pub_list') . '</p>'
        ));
        ecjia_screen::get_current_screen()->set_help_sidebar(
        	'<p><strong>' . RC_Lang::get('platform::platform.more_info') . '</strong></p>' .
        	'<p>' . __('<a href="https://ecjia.com/wiki/常见问题:ECJia到家:ECJia店铺街APP免费下载使用" target="_blank">'.RC_Lang::get('mobile::mobile.help_about_dianpujie').'</a>') . '</p>'.
        	'<p>' . __('<a href="https://ecjia.com/wiki/常见问题:ECJia到家:ECJia掌柜APP免费下载使用" target="_blank">'.RC_Lang::get('mobile::mobile.help_about_zhanggui').'</a>') . '</p>'.
        	'<p>' . __('<a href="https://ecjia.com/wiki/常见问题:ECJia到家:ECJia配送员APP免费下载使用" target="_blank">'.RC_Lang::get('mobile::mobile.help_about_peisong').'</a>') . '</p>'
        );
        
        $app_url =  RC_App::apps_url('statics/images', __FILE__);
        
        $api_url = Ecjia\App\Mobile\Qrcode\GenerateStreet::getApiUrl();
        $small_qrcode = Ecjia\App\Mobile\Qrcode\GenerateStreet::singleton()->getQrcodeUrl();
        
        $this->assign('api_url', $api_url);
        $this->assign('small_qrcode', $small_qrcode);
        $this->assign('app_url', $app_url);
        $this->assign('refresh_action', RC_Uri::url('mobile/admin_street/refresh'));
        
        $this->display('mobile_street.dwt');
    }
    
    
    public function refresh() {
    	$allow 		= !empty($_POST['check']) 	? $_POST['check']			: '';
	    if ($allow == 'allow') {
			$sizes = Ecjia\App\Mobile\Qrcode\GenerateStreet::QrSizeCmToPx();
	        
	        collect(array_values($sizes))->each(function ($item) {
	            Ecjia\App\Mobile\Qrcode\GenerateStreet::singleton()->removeQrcode($item);
	        });
        
		}
        //提示操作成功
        return $this->showmessage('刷新成功！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('mobile/admin_street/init')));
    }
    
    
    public function download() {

        $sizeCM = royalcms('request')->input('size', '12cm');
        
        $sizes = Ecjia\App\Mobile\Qrcode\GenerateStreet::QrSizeCmToPx();
        
        $sizePX = array_get($sizes, $sizeCM);
        
        $file = Ecjia\App\Mobile\Qrcode\GenerateStreet::singleton()->createQrcode($sizePX)->getQrcodePath($sizePX);
        
        //文件的类型
        header('Content-type: application/octet-stream');
        //下载显示的名字
        header('Content-Disposition: attachment; filename="ecjia_street_qrcode_'.$sizeCM.'.png"');
        readfile($file);
        exit();
    }
}

// end