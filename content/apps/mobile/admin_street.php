<?php

defined('IN_ECJIA') or exit('No permission resources.');


class admin_street extends ecjia_admin
{
    
    public function __construct()
    {
        parent::__construct();
        
        RC_Loader::load_app_class('mobile_qrcode', 'mobile', false);
        RC_Style::enqueue_style('mobile_street', RC_App::apps_url('statics/css/mobile_street.css', __FILE__));
    }
    
    
    public function init()
    {
    	//$this->admin_priv('mobile_street');
    	$this->assign('ur_here', '店铺街介绍');
        ecjia_screen::$current_screen->add_nav_here(new admin_nav_here(__('店铺街APP')));
        $mobile_img = RC_App::apps_url('statics/images/mobile_img.png', __FILE__);
        $ec_icon    = RC_App::apps_url('statics/images/ec_icon.png', __FILE__);
        $dianpujie = RC_App::apps_url('statics/images/dianpujie.png', __FILE__);
        
        $api_url = mobile_qrcode::getApiUrl();
        $small_qrcode = mobile_qrcode::getDefaultQrcodeUrl();
        
        $this->assign('api_url', $api_url);
        $this->assign('mobile_img', $mobile_img);
        $this->assign('ec_icon', $ec_icon);
        $this->assign('street_qrcode', $street_qrcode);
        $this->assign('small_qrcode', $small_qrcode);
        $this->assign('dianpujie', $dianpujie);
        
        $this->display('mobile_street.dwt');
    }
    
    public function download() {
        
        $get_size = empty($_GET['size']) ? '12cm' : $_GET['size'];
       
        $size = mobile_qrcode::QrSizeCmToPx($get_size);
        $file_url = mobile_qrcode::getStreetQrcodeUrl($size);
        //文件的类型
        header('Content-type: application/image/pjpeg');
        //下载显示的名字
        header('Content-Disposition: attachment; filename="ecjia_street_qrcode_'.$get_size.'.png"');
        readfile($file_url);
        exit();
    }
}

// end