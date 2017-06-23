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
/**
 * ECJIA 控制台首页
 */
defined('IN_ECJIA') or exit('No permission resources.');

class index extends ecjia_admin {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 后台控制面板首页
     */
    public function init() {
        RC_Script::enqueue_script('ecjia-admin_dashboard');
        RC_Script::enqueue_script('ecjia-chart', RC_Uri::admin_url() . '/statics/lib/Chart/Chart.min.js', array('ecjia-admin'), false, true);
        
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('仪表盘')));
        $this->assign('ur_here', __('仪表盘'));
        
        if (! ecjia_license::instance()->license_check()) {
            $license_url = RC_Uri::url('@index/license');
            $empower_info = sprintf(__('授权提示：您的站点还未经过授权许可！请上传您的证书，前往<a href="%s">授权证书管理</a> 。'), $license_url);
            ecjia_screen::get_current_screen()->add_admin_notice(new admin_notice($empower_info));
        }
        
        if (file_exists(RC_APP_PATH . 'installer')) {
            $warning = __('您还没有删除 installer 文件夹，出于安全的考虑，我们建议您删除 content/apps/installer 文件夹。');
            ecjia_screen::get_current_screen()->add_admin_notice(new admin_notice($warning));
        }

        if (version_compare(ecjia::config('ecjia_version'), RC_Config::get('release.version'), '<')) {
            $upgrade_url = RC_Uri::url('upgrade/index/init');
            $warning = sprintf(__('您当前已经覆盖了最新版的v%s程序，建议您立即升级数据库结构，升级前做好备份，前往<a href="%s">升级中心</a>。'), RC_Config::get('release.version'), $upgrade_url);
            ecjia_screen::get_current_screen()->add_admin_notice(new admin_notice($warning));
        }

        ecjia_screen::get_current_screen()->add_help_tab( array(
        'id'        => 'overview',
        'title'     => __('概述'),
        'content'   =>
            '<p>' . __('欢迎访问ECJia智能后台仪表盘！在您每次登录站点后，您都会看到本页面。您可以在这里访问ECJia智能后台的各种管理页面。点击任何页面右上角的“帮助”选项卡可阅读相应帮助信息。') . '</p>'
        ) );

        ecjia_screen::get_current_screen()->set_help_sidebar(
        '<p><strong>' . __('更多信息：') . '</strong></p>' .
        '<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台操作指南" target="_blank">关于ECJia智能后台的帮助文档</a>') . '</p>'
        );

        ecjia_cloud::instance()->api('product/analysis/record')->data(ecjia_utility::get_site_info())->cacheTime(86400)->run();

        $admin_notices = ecjia_utility::site_admin_notice();
        if (! empty($admin_notices)) {
            foreach ($admin_notices as $admin_notice) {
            	$notice_info = $admin_notice['content'] . sprintf(__('<a target="_blank" href="%s">点击查看</a>。'), $admin_notice['url']);
                ecjia_screen::get_current_screen()->add_admin_notice(new admin_notice($notice_info));
            }
        }
        $this->assign('ecjia_version', VERSION);

        $this->display('index.dwt');
    }

    /**
     * 关于 ECJIA
     */
    public function about_us() {
    	RC_Script::enqueue_script('ecjia-admin_team');
    	
    	ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('关于'), RC_Uri::url('@index/about_us')));
    	ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('关于 ECJIA')));
    	$this->assign('ur_here',       __('关于 ECJIA'));
    	
    	ecjia_screen::get_current_screen()->add_help_tab( array(
    	'id'        => 'overview',
    	'title'     => __('概述'),
    	'content'   =>
    	'<p>' . __('欢迎访问ECJia智能后台关于页面，可以更加了解ECJia。') . '</p>'
    	) );
    	
    	ecjia_screen::get_current_screen()->set_help_sidebar(
    	'<p><strong>' . __('更多信息：') . '</strong></p>' .
    	'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:关于" target="_blank">关于ECJia帮助文档</a>') . '</p>'
    	);
    	
    	RC_Hook::add_action('admin_about_welcome', array('ecjia_admin', 'display_admin_about_welcome'));
    	
        $this->display('about_us.dwt');
    }
    
    /**
     * ECJIA团队
     */
    public function about_team() {
    	RC_Script::enqueue_script('ecjia-admin_team');
    	
    	ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('关于'), RC_Uri::url('@index/about_us')));
    	ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('ECJIA团队')));
    	$this->assign('ur_here',       __('ECJIA团队'));
    	 
    	ecjia_screen::get_current_screen()->add_help_tab( array(
    	'id'        => 'overview',
    	'title'     => __('概述'),
    	'content'   =>
    	'<p>' . __('欢迎访问ECJia智能后台关于页面，可以更加了解ECJia。') . '</p>'
    	) );
    	 
    	ecjia_screen::get_current_screen()->set_help_sidebar(
    	'<p><strong>' . __('更多信息：') . '</strong></p>' .
    	'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:关于" target="_blank">关于ECJia帮助文档</a>') . '</p>'
    	);
    	
    	RC_Hook::add_action('admin_about_welcome', array('ecjia_admin', 'display_admin_about_welcome'));
    	
    	$this->display('about_team.dwt');
    }
    
    /**
     * ECJIA团队
     */
    public function about_system() {
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('关于'), RC_Uri::url('@index/about_us')));
    	ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('系统信息')));
    	$this->assign('ur_here',       __('系统信息'));
    
    	ecjia_screen::get_current_screen()->add_help_tab( array(
    	'id'        => 'overview',
    	'title'     => __('概述'),
    	'content'   =>
    	'<p>' . __('欢迎访问ECJia智能后台关于页面，可以更加了解ECJia。') . '</p>'
    			) );
    
    	ecjia_screen::get_current_screen()->set_help_sidebar(
    	'<p><strong>' . __('更多信息：') . '</strong></p>' .
    	'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:关于" target="_blank">关于ECJia帮助文档</a>') . '</p>'
    			);
    	
    	RC_Hook::add_action('admin_about_welcome', array('ecjia_admin', 'display_admin_about_welcome'));
    	
    	/* 系统信息 */
    	$sys_info['os']                 = PHP_OS;
    	$sys_info['ip']                 = $_SERVER['SERVER_ADDR'];
    	$sys_info['web_server']         = $_SERVER['SERVER_SOFTWARE'];
    	$sys_info['php_ver']            = PHP_VERSION;
    	$sys_info['mysql_ver']          = RC_Model::make()->database_version();
    	$sys_info['zlib']               = function_exists('gzclose') ? __('是'):__('否');
    	$sys_info['safe_mode']          = (boolean) ini_get('safe_mode') ?  __('是'):__('否');
    	$sys_info['safe_mode_gid']      = (boolean) ini_get('safe_mode_gid') ? __('是'):__('否');
    	$sys_info['timezone']           = function_exists("date_default_timezone_get") ? date_default_timezone_get() : __('无需设置');
    	$sys_info['socket']             = function_exists('fsockopen') ? __('是'):__('否');
    	
    	$gd = RC_ENV::gd_version();
    	if ($gd == 0) {
    		$sys_info['gd'] = 'N/A';
    	} else {
    		if ($gd == 1) {
    			$sys_info['gd'] = 'GD1';
    		} else {
    			$sys_info['gd'] = 'GD2';
    		}
    		$sys_info['gd'] .= ' (';
    		/* 检查系统支持的图片类型 */
    		if ($gd && (imagetypes() & IMG_JPG) > 0) {
    			$sys_info['gd'] .= ' JPEG';
    		}
    	
    		if ($gd && (imagetypes() & IMG_GIF) > 0) {
    			$sys_info['gd'] .= ' GIF';
    		}
    	
    		if ($gd && (imagetypes() & IMG_PNG) > 0) {
    			$sys_info['gd'] .= ' PNG';
    		}
    		$sys_info['gd'] .= ')';
    	}
    	
    	$sys_info['royalcms_version'] = Royalcms\Component\Foundation\Royalcms::VERSION;
    	$sys_info['royalcms_release'] = Royalcms\Component\Foundation\Royalcms::RELEASE;
    	
    	/* 允许上传的最大文件大小 */
    	$sys_info['max_filesize'] = ini_get('upload_max_filesize');
    	$this->assign('ecjia_version', VERSION);
    	$this->assign('ecjia_release', RELEASE);
    	$this->assign('sys_info',      $sys_info);
    	$this->assign('install_date',  date(ecjia::config('date_format'), ecjia::config('install_date')));
    	
    
    	$this->display('about_system.dwt');
    }


    /**
     * 更新缓存
     */
    public function update_cache() {
        RC_Style::enqueue_style('jquery-stepy');
        RC_Style::enqueue_style('uniform-aristo');
        RC_Script::enqueue_script('jquery-uniform');
        RC_Script::enqueue_script('jquery-stepy');
        RC_Script::enqueue_script('smoke');

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('更新缓存')));

        ecjia_screen::get_current_screen()->add_help_tab( array(
        'id'        => 'overview',
        'title'     => __('概述'),
        'content'   =>
        '<p>' . __('欢迎访问ECJia智能后台更新缓存页面，可以在此页面进行清除系统中缓存的操作。') . '</p>'
        ) );
         
        ecjia_screen::get_current_screen()->set_help_sidebar(
        '<p><strong>' . __('更多信息：') . '</strong></p>' .
        '<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:更新缓存" target="_blank">关于清除缓存帮助文档</a>') . '</p>'
        );
         
        
        if (IS_POST) {
            $cachekey = $_POST['cachekey'];
            ecjia_update_cache::make()->clean($cachekey);
        } else {
            RC_Script::enqueue_script('ecjia-admin_cache');
            RC_Style::enqueue_style('chosen');
            RC_Script::enqueue_script('jquery-chosen');

            $res = ecjia_cache::make()->load_cache();

            $this->assign('ur_here',    __('更新缓存'));
            
            $admin_cache_jslang = array(
            	'start'				=> __('开始'),
            	'retreat'			=> __('后退'),
            	'pls_type_check'	=> __('请选择要清除的缓存类型！'),
            	'clear'				=> __('清除：'),
            );
            RC_Script::localize_script('ecjia-admin_cache', 'admin_cache_lang', $admin_cache_jslang );
           
            $this->assign('cache_list', $res);
            $this->display('admin_cache.dwt');
        }
    }


    /**
     * 证书编辑页
     */
    public function license() {
        $this->admin_priv('shop_authorized');
        
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('授权证书')));
        $this->assign('ur_here', __('授权证书'));
        
        $admin_license_jslang = array(
        		'upload_msg'		=> __('将证书文件拖动至此处上传'),
        		'delete_check'		=> __('您确定要删除这个证书吗？'),
        		'ok'				=> __('确定'),
        		'cancel'			=> __('取消'),
        );
        RC_Script::localize_script('ecjia-admin_license', 'admin_license_lang', $admin_license_jslang );
        
        ecjia_screen::get_current_screen()->add_help_tab( array(
        'id'        => 'overview',
        'title'     => __('概述'),
        'content'   =>
        '<p>' . __('欢迎访问ECJia智能后台授权证书管理页面，可以在此对证书进行授权操作。') . '</p>'
        ) );
        
        ecjia_screen::get_current_screen()->set_help_sidebar(
        '<p><strong>' . __('更多信息：') . '</strong></p>' .
        '<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:授权证书" target="_blank">关于授权证书管理帮助文档</a>') . '</p>'
        );
        
        $license = ecjia_license::get_shop_license();
        $is_download = 0;
        if ($license['certificate_sn'] && $license['certificate_file']) {
            $is_download = 1;
        }
        if (!empty($license['certificate_file'])) {
            $certificate_file = RC_Upload::upload_path() . str_replace('/', DS, $license['certificate_file']);
            $cert_data = ecjia_license::instance()->parse_certificate($certificate_file);
            if (!$cert_data) {
            	$is_download = 0;
            } else {
            	$subject = $cert_data['subject'];
            	$issuer = $cert_data['issuer'];
            
            	$license_info = array(
            			'company_name'      => $subject['organizationName'],
            			'license_level'     => $subject['organizationalUnitName'],
            			'license_domain'    => $subject['commonName'],
            			'license_time'      => date('Y-m-d', $cert_data['validFrom_time_t']) . ' ~ ' . date('Y-m-d', $cert_data['validTo_time_t'])
            	);
            
            	$this->assign('license_info', $license_info);
            }
        }


        RC_Script::enqueue_script('smoke');
        RC_Script::enqueue_script('jquery-dropper', RC_Uri::admin_url() . '/statics/lib/dropper-upload/jquery.fs.dropper.js', array(), false, true);
        RC_Script::enqueue_script('ecjia-admin_license');
        $this->assign('is_download', $is_download);

        $this->display('license.dwt');
    }



    /**
     * 证书上传
     */
    public function license_upload() {
        $this->admin_priv('shop_authorized');

        /* 接收上传文件 */
        $upload = RC_Upload::uploader('file', array('save_path' => 'data/certificate', 'auto_sub_dirs' => false));
        $upload->allowed_type('cer,pem');
        $upload->allowed_mime('application/x-x509-ca-cert,application/octet-stream');

        if (!$upload->check_upload_file($_FILES['license'])) {
            return $this->showmessage($upload->error(), ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
        }
        $info = $upload->upload($_FILES['license']);
        $license_file = $upload->get_position($info);

        /* 取出证书内容 */
        $license_arr = ecjia_license::instance()->parse_certificate(RC_Upload::upload_path() . str_replace('/', DS, $license_file));

        /* 恢复证书 */
        if (empty($license_arr)) {
            return $this->showmessage(__('证书内容不全。请先确定证书是否正确然后重新上传！'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        } else {
            // TODO 证书在线验证
            ecjia_config::instance()->write_config('certificate_sn', $license_arr['serialNumber']);
            ecjia_config::instance()->write_config('certificate_file', $license_file);

            /* 记录日志 */
            ecjia_admin::admin_log($license_file, 'add', 'license');

            return $this->showmessage(__('证书上传成功。'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('@index/license')));
        }
    }

    /**
     * 证书下载
     */
    public function license_download() {
        $this->admin_priv('shop_authorized');

        $license = ecjia_license::get_shop_license();

        $certificate_file = RC_Upload::upload_path() . str_replace('/', DS, $license['certificate_file']);

        $cert_data = ecjia_license::instance()->parse_certificate($certificate_file);

        $download_filename = $cert_data['subject']['commonName'] . '-certificate.cer';

        /* 记录日志 */
        ecjia_admin_log::instance()->add_action('download', __('下载'));
        ecjia_admin::admin_log($license['certificate_file'], 'download', 'license');

        /* 文件下载 */
        $this->header("Content-Type", "application/x-x509-ca-cert");
        $this->header("Accept-Ranges", "bytes");
        $this->header("Content-Disposition", "attachment; filename=$download_filename");
        readfile($certificate_file);
    }

    /**
     * 证书删除
     */
    public function license_delete() {
        $this->admin_priv('shop_authorized');

        $license = ecjia_license::get_shop_license();

        $certificate_file = RC_Upload::upload_path() . str_replace('/', DS, $license['certificate_file']);

        if (file_exists($certificate_file)) {
            $disk = RC_Filesystem::disk();
            $disk->delete($certificate_file);
        }

        ecjia_config::instance()->write_config('certificate_sn', '');
        ecjia_config::instance()->write_config('certificate_file', '');

        /* 记录日志 */
        ecjia_admin::admin_log($license['certificate_file'], 'remove', 'license');

        return $this->showmessage(__('证书已删除。'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
    }

}

// end
