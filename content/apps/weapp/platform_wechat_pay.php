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
 * ECJIA微信支付配置
 */
class platform_wechat_pay extends ecjia_platform
{
    public function __construct()
    {
        parent::__construct();

        RC_Script::enqueue_script('jquery-validate');
        RC_Script::enqueue_script('jquery-form');
        RC_Style::enqueue_style('bootstrap-responsive');

        RC_Script::enqueue_script('ecjia-platform-bootstrap-fileupload-js');
        RC_Style::enqueue_style('ecjia-platform-bootstrap-fileupload-css');

        RC_Script::enqueue_script('clipboard', RC_App::apps_url('statics/platform-js/clipboard.min.js', __FILE__));
        RC_Script::enqueue_script('platform_config', RC_App::apps_url('statics/platform-js/platform_config.js', __FILE__), array(), false, true);
        RC_Script::localize_script('platform_config', 'js_lang', config('app-weapp::jslang.platform_config_page'));

        RC_Style::enqueue_style('platform_wechat_pay', RC_App::apps_url('statics/platform-css/platform_wechat_pay.css', __FILE__));

        ecjia_platform_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('微信支付配置', 'weapp'), RC_Uri::url('weapp/platform_wechat_pay/init')));
        ecjia_platform_screen::get_current_screen()->set_subject(__('微信支付配置', 'weapp'));
    }

    public function init()
    {
        $this->admin_priv('weapp_config_manage');

        ecjia_platform_screen::get_current_screen()->remove_last_nav_here();
        ecjia_platform_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('微信支付配置', 'weapp')));

        $account = $this->platformAccount->getAccount(true);

        $account['url'] = RC_Uri::home_url() . '/sites/platform/?uuid=' . $this->platformAccount->getUUID();

        $this->assign('account', $account);

        $enabled = false;
        $result  = RC_DB::table('wechat_options')->where('wechat_id', $account['id'])->where('option_name', 'pay_wxpay_weapp')->first();
        if (!empty($result)) {
            $option_value = unserialize($result['option_value']);
            if ($option_value['enabled'] == 1) {
                $enabled = true;
            }
            $result['wxpay_mchid']       = $option_value['wxpay_mchid'];
            $result['wxpay_apipwd']      = $option_value['wxpay_apipwd'];
            $result['pay_fee']           = $option_value['pay_fee'];
            $result['wxpay_cert_client'] = $option_value['wxpay_cert_client'];
            $result['wxpay_cert_key']    = $option_value['wxpay_cert_key'];
        }
        $this->assign('result', $result);
        $this->assign('enabled', $enabled);

        $this->assign('ur_here', __('微信支付配置', 'weapp'));
        $this->assign('form_action', RC_Uri::url('weapp/platform_wechat_pay/update'));

        $this->assign('images_url', RC_App::apps_url('statics/images/', __FILE__));

        $help_url = __("https://www.ecjia.com/wiki/常见问题:ECJia到家门店小程序:ECJia到家门店小程序的配置使用#.E5.B0.8F.E7.A8.8B.E5.BA.8F.E5.BE.AE.E4.BF.A1.E6.94.AF.E4.BB.98.E6.8F.92.E4.BB.B6.E9.85.8D.E7.BD.AE", 'weapp');
        $this->assign('help_url', $help_url);

        $this->display('weapp_wechat_pay_config.dwt');
    }

    public function update()
    {
        $this->admin_priv('weapp_config_update', ecjia::MSGTYPE_JSON);

        $wxpay_mchid  = trim($_POST['wxpay_mchid']);
        $wxpay_apipwd = trim($_POST['wxpay_apipwd']);
        $pay_fee      = floatval($_POST['pay_fee']);

        $account = $this->platformAccount->getAccount(true);

        $result = RC_DB::table('wechat_options')->where('wechat_id', $account['id'])->where('option_name', 'pay_wxpay_weapp')->first();
        if (empty($result)) {
            $option_value = array('enabled' => 1);

            $data = array(
                'wechat_id'    => $account['id'],
                'option_name'  => 'pay_wxpay_weapp',
                'option_type'  => 'serialize',
                'option_value' => serialize($option_value)
            );
            RC_DB::table('wechat_options')->insert($data);
        } else {
            $option_value = unserialize($result['option_value']);

            $option_value['enabled']       = 1;
            $option_value['wxpay_mchid']  = $wxpay_mchid;
            $option_value['wxpay_apipwd'] = $wxpay_apipwd;
            $option_value['pay_fee']      = $pay_fee;

            if (!empty($_FILES['wxpay_cert_client']) || !empty($_FILES['wxpay_cert_key'])) {

                $old_option_value = unserialize($result['option_value']);

                if (!empty($_FILES['wxpay_cert_client'])) {
                    $upload = RC_Upload::uploader('image', array('save_path' => 'data/weapp/cert/pay_wxpay_weapp', 'auto_sub_dirs' => false));
                    $upload->allowed_type(['cer', 'pem']);
                    $upload->allowed_mime(['application/x-x509-ca-cert', 'application/octet-stream']);
                    $upload->setStorageDisk(RC_Storage::disk('local'));

                    $image_info = $upload->upload($_FILES['wxpay_cert_client']);

                    if (!empty($image_info)) {
                        $image_url = $upload->get_position($image_info);

                        //删除旧的证书
                        if (!empty($old_option_value['wxpay_cert_client'])) {
                            $disk = RC_Storage::disk('local');
                            $disk->delete(RC_Upload::local_upload_path($old_option_value['wxpay_cert_client']));
                        }
                    } else {
                        return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                    }
                    $option_value['wxpay_cert_client'] = $image_url;
                }

                if (!empty($_FILES['wxpay_cert_key'])) {
                    $upload = RC_Upload::uploader('image', array('save_path' => 'data/weapp/cert/pay_wxpay_weapp', 'auto_sub_dirs' => false));
                    $upload->allowed_type(['cer', 'pem']);
                    $upload->allowed_mime(['application/x-x509-ca-cert', 'application/octet-stream']);
                    $upload->setStorageDisk(RC_Storage::disk('local'));

                    $image_info = $upload->upload($_FILES['wxpay_cert_key']);

                    if (!empty($image_info)) {
                        $image_url = $upload->get_position($image_info);
                        //删除旧的证书
                        if (!empty($old_option_value['wxpay_cert_key'])) {
                            $disk = RC_Storage::disk('local');
                            $disk->delete(RC_Upload::local_upload_path($old_option_value['wxpay_cert_key']));
                        }
                    } else {
                        return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                    }
                    $option_value['wxpay_cert_key'] = $image_url;
                }
            }

            $data = array(
                'option_value' => serialize($option_value)
            );
            RC_DB::table('wechat_options')->where('wechat_id', $account['id'])->where('option_name', 'pay_wxpay_weapp')->update($data);
        }

        return $this->showmessage(__('保存成功', 'weapp'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('weapp/platform_wechat_pay/init')));
    }

    public function enable()
    {
        $this->admin_priv('weapp_config_update', ecjia::MSGTYPE_JSON);

        $account = $this->platformAccount->getAccount(true);

        $result = RC_DB::table('wechat_options')->where('wechat_id', $account['id'])->where('option_name', 'pay_wxpay_weapp')->first();
        if (empty($result)) {
            $option_value = array('enabled' => 1);

            $data = array(
                'wechat_id'    => $account['id'],
                'option_name'  => 'pay_wxpay_weapp',
                'option_type'  => 'serialize',
                'option_value' => serialize($option_value)
            );
            RC_DB::table('wechat_options')->insert($data);
        } else {
            $option_value = unserialize($result['option_value']);

            $option_value['enabled'] = 1;

            $data = array(
                'option_value' => serialize($option_value)
            );
            RC_DB::table('wechat_options')->where('wechat_id', $account['id'])->where('option_name', 'pay_wxpay_weapp')->update($data);
        }

        return $this->showmessage(__('开启成功', 'weapp'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('weapp/platform_wechat_pay/init')));
    }

    public function disable()
    {
        $this->admin_priv('weapp_config_update', ecjia::MSGTYPE_JSON);

        $account = $this->platformAccount->getAccount(true);

        $result = RC_DB::table('wechat_options')->where('wechat_id', $account['id'])->where('option_name', 'pay_wxpay_weapp')->first();

        $option_value = unserialize($result['option_value']);

        $option_value['enabled'] = 0;

        $data = array(
            'option_value' => serialize($option_value)
        );
        RC_DB::table('wechat_options')->where('wechat_id', $account['id'])->where('option_name', 'pay_wxpay_weapp')->update($data);

        return $this->showmessage(__('关闭成功', 'weapp'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('weapp/platform_wechat_pay/init')));
    }

    public function delete_file()
    {
        $this->admin_priv('weapp_config_update', ecjia::MSGTYPE_JSON);

        $type = trim($_GET['type']);

        $account = $this->platformAccount->getAccount(true);

        $result = RC_DB::table('wechat_options')->where('wechat_id', $account['id'])->where('option_name', 'pay_wxpay_weapp')->first();

        $option_value = unserialize($result['option_value']);

        if (!empty($option_value[$type])) {
            $disk = RC_Storage::disk('local');
            $disk->delete(RC_Upload::local_upload_path($option_value[$type]));
        }

        $option_value[$type] = '';

        $data = array(
            'option_value' => serialize($option_value)
        );
        RC_DB::table('wechat_options')->where('wechat_id', $account['id'])->where('option_name', 'pay_wxpay_weapp')->update($data);

        return $this->showmessage(__('删除成功', 'weapp'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('weapp/platform_wechat_pay/init')));
    }

}

//end
