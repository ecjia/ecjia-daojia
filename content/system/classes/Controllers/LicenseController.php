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
namespace Ecjia\System\Controllers;

use ecjia_admin;
use ecjia_admin_log;
use ecjia_config;
use ecjia_license;
use RC_Script;
use RC_Storage;
use RC_Upload;
use RC_Uri;
use ecjia_screen;
use ecjia;
use admin_nav_here;
use RC_Response;

/**
 * ECJIA 授权证书控制器
 */
class LicenseController extends ecjia_admin
{

	public function __construct()
    {
		parent::__construct();

	}

    /**
     * 证书编辑页
     */
    public function license()
    {
        $this->admin_priv('shop_authorized');

        //js语言包调用
        RC_Script::enqueue_script('smoke');
        RC_Script::enqueue_script('jquery-dropper', RC_Uri::admin_url() . '/statics/lib/dropper-upload/jquery.fs.dropper.js', array(), false, true);
        RC_Script::enqueue_script('ecjia-admin_license');
        RC_Script::localize_script('ecjia-admin_license', 'admin_license_lang', config('system::jslang.license_page'));

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('授权证书')));
        $this->assign('ur_here', __('授权证书'));

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
            $certificate_file = RC_Upload::local_upload_path() . str_replace('/', DS, $license['certificate_file']);
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

        $this->assign('is_download', $is_download);

        return $this->display('license.dwt');
    }



    /**
     * 证书上传
     */
    public function license_upload()
    {
        $this->admin_priv('shop_authorized');

        /* 接收上传文件 */
        $upload = RC_Upload::uploader('file', array('save_path' => 'data/certificate', 'auto_sub_dirs' => false));
        $upload->allowed_type('cer,pem');
        $upload->allowed_mime('application/x-x509-ca-cert,application/octet-stream');

        if (!$upload->check_upload_file($_FILES['license'])) {
            return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        $info = $upload->upload($_FILES['license']);
        $license_file = $upload->get_position($info);
        $license_full_file = RC_Upload::local_upload_path(str_replace('/', DS, $license_file));

        /* 取出证书内容 */
        $license_arr = ecjia_license::instance()->parse_certificate($license_full_file);

        /* 恢复证书 */
        if (empty($license_arr)) {
            return $this->showmessage(__('证书内容不全。请先确定证书是否正确然后重新上传！'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        } else {
            // 证书在线验证
            $isLicense = with(new ecjia_license($license_arr['serialNumber'], $license_file))->license_online_check();
            if ($isLicense) {
                ecjia_config::instance()->write_config('certificate_sn', $license_arr['serialNumber']);
                ecjia_config::instance()->write_config('certificate_file', $license_file);

                /* 记录日志 */
                ecjia_admin::admin_log($license_file, 'add', 'license');

                return $this->showmessage(__('授权证书上传成功。'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('@license/license')));
            } else {
                /* 证书验证失败，删除错误的证书文件 */
                RC_Storage::disk('local')->delete($license_full_file);

                return $this->showmessage(__('授权证书连接服务器校验失败，请检查授权证书的合法性。'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('pjaxurl' => RC_Uri::url('@license/license')));
            }
        }
    }

    /**
     * 证书下载
     */
    public function license_download()
    {
        $this->admin_priv('shop_authorized');

        $license = ecjia_license::get_shop_license();

        $certificate_file = RC_Upload::local_upload_path($license['certificate_file']);

        $cert_data = ecjia_license::instance()->parse_certificate($certificate_file);

        $download_filename = $cert_data['subject']['commonName'] . '-certificate.cer';

        /* 记录日志 */
        ecjia_admin_log::instance()->add_action('download', __('下载'));
        ecjia_admin::admin_log($license['certificate_file'], 'download', 'license');

        /* 文件下载 */
        $headers = [
            'Content-Type' => 'application/x-x509-ca-cert',
            'Accept-Ranges' => 'bytes',
        ];
        return RC_Response::download($certificate_file, $download_filename, $headers);
    }

    /**
     * 证书删除
     */
    public function license_delete()
    {
        $this->admin_priv('shop_authorized');

        $license = ecjia_license::get_shop_license();

        $certificate_file = RC_Upload::local_upload_path($license['certificate_file']);

        if (file_exists($certificate_file)) {
            $disk = RC_Storage::disk('local');
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