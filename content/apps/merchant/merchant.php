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
 * 店铺基本信息
 */
class merchant extends ecjia_merchant
{
    public function __construct()
    {
        parent::__construct();
        RC_Script::enqueue_script('jquery-form');
        RC_Script::enqueue_script('smoke');
        RC_Style::enqueue_style('uniform-aristo');
        RC_Style::enqueue_style('jquery-stepy');
        // 自定义JS
        RC_Script::enqueue_script('photoswipe', RC_App::apps_url('statics/lib/photoswipe/js/photoswipe.min.js', __FILE__), array(), false, 1);
        RC_Script::enqueue_script('photoswipe-ui', RC_App::apps_url('statics/lib/photoswipe/js/photoswipe-ui-default.min.js', __FILE__), array(), false, 1);
        RC_Style::enqueue_style('photoswipe', RC_App::apps_url('statics/lib/photoswipe/css/photoswipe.css', __FILE__), array());
        RC_Style::enqueue_style('default-skin', RC_App::apps_url('statics/lib/photoswipe/css/default-skin/default-skin.css', __FILE__), array());
        // 页面css样式
        RC_Style::enqueue_style('merchant', RC_App::apps_url('statics/css/merchant.css', __FILE__), array());

        RC_Style::enqueue_style('merchant_template', RC_App::apps_url('statics/css/merchant_template.css', __FILE__), array());
        // input file 长传
        RC_Style::enqueue_style('bootstrap-fileupload', RC_App::apps_url('statics/assets/bootstrap-fileupload/bootstrap-fileupload.css', __FILE__), array());
        RC_Script::enqueue_script('bootstrap-fileupload', RC_App::apps_url('statics/assets/bootstrap-fileupload/bootstrap-fileupload.js', __FILE__), array(), false, 1);

        RC_Script::enqueue_script('yomi', RC_App::apps_url('statics/js/jquery.yomi.js', __FILE__), array(), false, 1);

        // 时间区间
        RC_Style::enqueue_style('range', RC_App::apps_url('statics/css/range.css', __FILE__), array());
        RC_Script::enqueue_script('jquery-range', RC_App::apps_url('statics/js/jquery.range.js', __FILE__), array(), false, 1);

        RC_Script::enqueue_script('jquery.toggle.buttons', RC_Uri::admin_url('statics/lib/toggle_buttons/jquery.toggle.buttons.js'));
        RC_Style::enqueue_style('bootstrap-toggle-buttons', RC_Uri::admin_url('statics/lib/toggle_buttons/bootstrap-toggle-buttons.css'));
        RC_Script::enqueue_script('migrate', RC_App::apps_url('statics/js/migrate.js', __FILE__), array(), false, 1);

        RC_Loader::load_app_func('merchant');
        Ecjia\App\Merchant\Helper::assign_adminlog_content();

        RC_Script::enqueue_script('merchant_info', RC_App::apps_url('statics/js/merchant_info.js', __FILE__), array(), false, 1);
        RC_Script::localize_script('merchant_info', 'js_lang', config('app-merchant::jslang.merchant_page'));

        ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('我的店铺', 'merchant'), RC_Uri::url('merchant/merchant/init')));
        ecjia_merchant_screen::get_current_screen()->set_parentage('store', 'store/merchant.php');
    }

    /**
     * 店铺基本信息
     */
    public function init()
    {
        $this->admin_priv('merchant_manage');

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('店铺设置', 'merchant')));
        $this->assign('app_url', RC_App::apps_url('statics', __FILE__));

        $this->assign('ur_here', __('设置店铺信息', 'merchant'));
        $merchant_info = get_merchant_info($_SESSION['store_id']);
        //店铺最小购物金额设置
        $has_min_goods_amount = array_key_exists('min_goods_amount', $merchant_info);
        if ($has_min_goods_amount == false) {
            $db   = RC_DB::table('merchants_config');
            $data = array('store_id' => $_SESSION['store_id'], 'group' => 0, 'code' => 'min_goods_amount', 'type' => 'text', 'store_range' => '', 'store_dir' => '', 'value' => 0, 'sort_order' => 1);
            $db->insert($data);
        }

        //接单类型
        $has_orders_auto_confirm = array_key_exists('orders_auto_confirm', $merchant_info);
        if ($has_orders_auto_confirm == false) {
            $db   = RC_DB::table('merchants_config');
            $data = array('store_id' => $_SESSION['store_id'], 'group' => 0, 'code' => 'orders_auto_confirm', 'type' => '', 'store_range' => '', 'store_dir' => '', 'value' => 0, 'sort_order' => 1);
            $db->insert($data);
        }

        //拒绝接单时间
        $has_orders_auto_rejection_time = array_key_exists('orders_auto_rejection_time', $merchant_info);
        if ($has_orders_auto_rejection_time == false) {
            $db   = RC_DB::table('merchants_config');
            $data = array('store_id' => $_SESSION['store_id'], 'group' => 0, 'code' => 'orders_auto_rejection_time', 'type' => '', 'store_range' => '', 'store_dir' => '', 'value' => 0, 'sort_order' => 1);
            $db->insert($data);
        }

        //小票离线打印
        $has_printer_offline_send = array_key_exists('printer_offline_send', $merchant_info);
        if ($has_printer_offline_send == false) {
            $db   = RC_DB::table('merchants_config');
            $data = array('store_id' => $_SESSION['store_id'], 'group' => 0, 'code' => 'printer_offline_send', 'type' => '', 'store_range' => '', 'store_dir' => '', 'value' => 0, 'sort_order' => 1);
            $db->insert($data);
        }

        $merchant_info['merchants_name'] = RC_DB::table('store_franchisee')->where('store_id', $_SESSION['store_id'])->pluck('merchants_name');

        $disk         = RC_Filesystem::disk();
        $store_qrcode = 'data/qrcodes/merchants/merchant_' . $_SESSION['store_id'] . '.png';
        if ($disk->exists(RC_Upload::upload_path($store_qrcode))) {
            $merchant_info['store_qrcode'] = RC_Upload::upload_url($store_qrcode) . '?' . time();
        }

        $this->assign('data', $merchant_info);
        $this->assign('form_action', RC_Uri::url('merchant/merchant/update'));
        $this->assign('store_id', $_SESSION['store_id']);
        $this->assign('make_thumb_url', RC_Uri::url('merchant/merchant/make_thumb'));

        $banner = (new \Ecjia\App\Merchant\StoreComponents\Banner\BannerThumb($merchant_info['shop_banner_pic']));
        if (!empty($banner->getStoreBannerThumbPath())) {
            $banner_url = $banner->getStoreBannerThumbUrl();
            $this->assign('banner_thumb_url', $banner_url);
            $this->assign('banner_thumb_exists', $banner->hasStoreBannerThumbPath());
        }

        if ($_SESSION['action_list'] == 'all') {
            $this->assign('action_link', array('href' => RC_Uri::url('merchant/merchant/cancel_store'), 'text' => __('注销店铺', 'merchant')));
        }

        $this->display('merchant_basic_info.dwt');
    }

    /**
     * 店铺基本信息
     */
    public function update()
    {
        $this->admin_priv('merchant_manage', ecjia::MSGTYPE_JSON);

        $store_id                   = $_SESSION['store_id'];
        $shop_kf_mobile             = ($_POST['shop_kf_mobile'] == get_merchant_config('shop_kf_mobile')) ? '' : htmlspecialchars($_POST['shop_kf_mobile']);
        $shop_description           = ($_POST['shop_description'] == get_merchant_config('shop_description')) ? '' : htmlspecialchars($_POST['shop_description']);
        $shop_trade_time            = empty($_POST['shop_trade_time']) ? '' : htmlspecialchars($_POST['shop_trade_time']);
        $shop_notice                = ($_POST['shop_notice'] == get_merchant_config('shop_notice')) ? '' : htmlspecialchars($_POST['shop_notice']);
        $express_assign_auto        = isset($_POST['express_assign_auto']) ? intval($_POST['express_assign_auto']) : 0;
        $min_goods_amount           = isset($_POST['min_goods_amount']) ? intval($_POST['min_goods_amount']) : 0;
        $orders_auto_confirm        = isset($_POST['orders_auto_confirm']) ? intval($_POST['orders_auto_confirm']) : 0;
        $orders_auto_rejection_time = isset($_POST['orders_auto_rejection_time']) ? intval($_POST['orders_auto_rejection_time']) : 0;
        $printer_offline_send       = isset($_POST['printer_offline_send']) ? intval($_POST['printer_offline_send']) : 0;

        $merchants_config                         = array();
        $merchants_config['express_assign_auto']  = $express_assign_auto;
        $merchants_config['min_goods_amount']     = $min_goods_amount;
        $merchants_config['orders_auto_confirm']  = $orders_auto_confirm;
        $merchants_config['printer_offline_send'] = $printer_offline_send;

        if (empty($orders_auto_confirm)) {
            $merchants_config['orders_auto_rejection_time'] = $orders_auto_rejection_time;
        }
        $shop_nav_background = get_merchant_config('shop_nav_background');
        $shop_logo           = get_merchant_config('shop_logo');
        $shop_thumb_logo     = get_merchant_config('shop_thumb_logo');
        $shop_banner_pic     = get_merchant_config('shop_banner_pic');
        $shop_front_logo     = get_merchant_config('shop_front_logo');

        // 店铺导航背景图
        if (!empty($_FILES['shop_nav_background']) && empty($_FILES['error']) && !empty($_FILES['shop_nav_background']['name'])) {
            $merchants_config['shop_nav_background'] = merchant_file_upload_info('shop_nav_background', '', $shop_nav_background);
        }
        // 默认店铺页头部LOGO
        if (!empty($_FILES['shop_logo']) && empty($_FILES['error']) && !empty($_FILES['shop_logo']['name'])) {
            $merchants_config['shop_logo'] = merchant_file_upload_info('shop_logo', '', $shop_logo);
        }

        $edit_app_banner = false;
        // APPbanner图
        if (!empty($_FILES['shop_banner_pic']) && empty($_FILES['error']) && !empty($_FILES['shop_banner_pic']['name'])) {
            $merchants_config['shop_banner_pic'] = merchant_file_upload_info('shop_banner', 'shop_banner_pic', $shop_banner_pic);
            $edit_app_banner                     = true;
        }
        // 如果没有上传店铺LOGO 提示上传店铺LOGO
        $shop_logo = get_merchant_config('shop_logo');
        if (empty($shop_logo) && empty($merchants_config['shop_logo'])) {
            return $this->showmessage(__('请上传店铺LOGO', 'merchant'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        if (!empty($shop_description)) {
            $merchants_config['shop_description'] = $shop_description; // 店铺描述
        }
        $time = array();
        if (!empty($shop_trade_time)) {
            $shop_time = explode(',', $shop_trade_time);
            //营业时间验证
            if ($shop_time[0] >= 1440) {
                return $this->showmessage(__('营业开始时间不能为次日', 'merchant'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            if ($shop_time[1] - $shop_time[0] > 1440) {
                return $this->showmessage(__('营业时间最多为24小时', 'merchant'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            if (($shop_time[1] - $shop_time[0] == 1440) && ($shop_time[0] != 0)) {
                return $this->showmessage(__('24小时营业请选择0-24', 'merchant'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

            $s_h             = ($shop_time[0] / 60);
            $s_i             = ($shop_time[0] % 60);
            $e_h             = ($shop_time[1] / 60);
            $e_i             = ($shop_time[1] % 60);
            $start_h         = empty($s_h) ? '00' : intval($s_h);
            $start_i         = empty($s_i) ? '00' : intval($s_i);
            $end_h           = empty($e_h) ? '00' : intval($e_h);
            $end_i           = empty($e_i) ? '00' : intval($e_i);
            $start_time      = $shop_time[0] == 0 ? '00:00' : $start_h . ":" . $start_i;
            $end_time        = $end_h . ":" . $end_i;
            $time['start']   = $start_time;
            $time['end']     = $end_time;
            $shop_trade_time = serialize($time);
            if ($shop_trade_time != get_merchant_config('shop_trade_time')) {
                $merchants_config['shop_trade_time'] = $shop_trade_time; // 营业时间
            }
        }
        if (!empty($shop_notice)) {
            $merchants_config['shop_notice'] = $shop_notice; // 店铺公告
        }
        if (!empty($shop_kf_mobile)) {
            $merchants_config['shop_kf_mobile'] = $shop_kf_mobile; // 客服电话
        }
        if (!empty($merchants_config)) {
            $merchant = set_merchant_config('', '', $merchants_config);
        } else {
            return $this->showmessage(__('请编辑要修改的内容', 'merchant'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        if ($edit_app_banner) {
            $banner = (new \Ecjia\App\Merchant\StoreComponents\Banner\BannerThumb($merchants_config['shop_banner_pic']));
            $banner->createBannerThumbFile();
        }

        if (!empty($merchant)) {
            // 记录日志
            ecjia_merchant::admin_log(__('修改店铺基本信息', 'merchant'), 'edit', 'merchant');
            return $this->showmessage(__('编辑成功', 'merchant'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('merchant/merchant/init')));
        }
    }

    /**
     * 店铺基本信息
     */
    public function drop_file()
    {
        $code     = $_GET['code'];
        $img      = get_merchant_config($code);
        $merchant = set_merchant_config($code, '');
        $file     = !empty($img) ? RC_Upload::upload_path($img) : '';
        $disk     = RC_Filesystem::disk();
        $disk->delete($file);
        if ($code == 'shop_nav_background') {
            $msg = __('店铺导航背景图', 'merchant');
        } elseif ($code == 'shop_logo') {
            $msg = __('店铺LOGO', 'merchant');
        } elseif ($code == 'shop_banner_pic') {
            $msg = __('店铺顶部Banner图', 'merchant');

            $banner = (new \Ecjia\App\Merchant\StoreComponents\Banner\BannerThumb($img));
            $banner->removeBannerThumbFile();
        }
        // 记录日志
        ecjia_merchant::admin_log(__('删除', 'merchant') . $msg, 'edit', 'merchant');
        return $this->showmessage(__('成功删除', 'merchant'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('merchant/merchant/init')));
    }

    /**
     * 底部链接详情页
     */
    public function shopinfo()
    {
        ecjia_screen::get_current_screen()->remove_last_nav_here();
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('网店信息', 'merchant')));

        $this->assign('ur_here', __('网店信息', 'merchant'));
        $this->assign('shop_title', __('网店信息', 'merchant'));

        $id        = !empty($_GET['id']) ? intval($_GET['id']) : 0;
        $shop_info = RC_DB::table('article')->where('cat_id', 0)->where('article_id', $id)->first();

        if (empty($shop_info)) {
            return $this->showmessage(__('该网店信息不存在', 'merchant'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR);
        }
        $shopinfo_list = RC_DB::table('article')
            ->select('article_id', 'title', 'content', 'file_url')
            ->where('cat_id', 0)
            ->where('article_type', 'shop_info')
            ->orderby('article_id', 'asc')
            ->get();

        if (!empty($shopinfo_list)) {
            $disk = RC_Filesystem::disk();
            foreach ($shopinfo_list as $k => $v) {
                if (!empty($v['file_url']) && $disk->exists(RC_Upload::upload_path($v['file_url']))) {
                    $file_url                      = RC_Upload::upload_url($v['file_url']);
                    $shopinfo_list[$k]['file_url'] = '<img src=' . $file_url . ' / style="width:12px;height:14px;">';
                } else {
                    $shopinfo_list[$k]['file_url'] = '<i class="fa fa-info-circle"></i>';
                }
            }
        }
        $shop_info['content'] = stripslashes($shop_info['content']);
        $this->assign('id', $id);
        $this->assign('shop_info', $shop_info);
        $this->assign('info_list', $shopinfo_list);
        $this->display('merchant_shopinfo.dwt');
    }

    /**
     * 商店公告
     */
    public function shop_notice()
    {
        ecjia_screen::get_current_screen()->remove_last_nav_here();
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('公告通知', 'merchant')));

        $this->assign('ur_here', __('公告通知', 'merchant'));

        $id                     = !empty($_GET['id']) ? intval($_GET['id']) : 0;
        $shop_notice            = RC_DB::table('article')->where('article_id', $id)->first();
        $shop_notice['content'] = stripslashes($shop_notice['content']);

        $shop_notice_list = RC_DB::table('article as a')
            ->orderBy(RC_DB::raw('a.add_time'), 'desc')
            ->take(5)
            ->where(RC_DB::raw('a.article_type'), 'merchant_notice')
            ->get();

        if (!empty($shop_notice_list)) {
            $disk = RC_Filesystem::disk();
            foreach ($shop_notice_list as $k => $v) {
                if (!empty($v['file_url']) && $disk->exists(RC_Upload::upload_path($v['file_url']))) {
                    $file_url                         = RC_Upload::upload_url($v['file_url']);
                    $shop_notice_list[$k]['file_url'] = '<img src=' . $file_url . ' / style="width:12px;height:14px;">';
                } else {
                    $shop_notice_list[$k]['file_url'] = '<i class="fa fa-info-circle"></i>';
                }
            }
        }

        $this->assign('id', $id);
        $this->assign('shop_notice', $shop_notice);
        $this->assign('list', $shop_notice_list);
        $this->display('merchant_shop_notice.dwt');
    }

    /**
     * 店铺开关
     */
    public function mh_switch()
    {
        $this->admin_priv('merchant_switch');

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('店铺开关', 'merchant')));
        $this->assign('app_url', RC_App::apps_url('statics', __FILE__));

        $this->assign('ur_here', __('店铺打烊', 'merchant'));
        $merchant_info           = RC_DB::table('store_franchisee')->where('store_id', $_SESSION['store_id'])->first();
        $merchant_info['mobile'] = RC_DB::table('staff_user')->where('store_id', $_SESSION['store_id'])->where('parent_id', 0)->pluck('mobile');

        //判断营业时间
        $merchant_info['shop_trade_time'] = get_store_trade_time($_SESSION['store_id']);

        $shop_trade_time = get_merchant_config('shop_trade_time', '', $_SESSION['store_id']);
        $shop_closed     = get_shop_close($merchant_info['shop_close'], $shop_trade_time);
        //1为不营业，0为营业

        $this->assign('shop_closed', $shop_closed);
        $this->assign('merchant_info', $merchant_info);
        $this->assign('form_action', RC_Uri::url('merchant/merchant/mh_switch_update'));

        if ($merchant_info['shop_close'] == 1 && $merchant_info['identity_status'] != 2 && ecjia::config('store_identity_certification') == 1) {
            $this->assign('tips', __('您还未完成信息认证，暂无法上线店铺。您可以先完善资质信息，等待审核，等待的同时可以更新您的商品和其他信息。<a href="' . RC_Uri::url('merchant/mh_franchisee/request_edit') . '">完善资质信息</a>', 'merchant'));
        }

        $this->display('mh_switch.dwt');

    }

    /**
     * 店铺开关
     */
    public function mh_switch_update()
    {
        $this->admin_priv('merchant_switch', ecjia::MSGTYPE_JSON);

        $code   = !empty($_POST['code']) ? $_POST['code'] : '';
        $mobile = !empty($_POST['mobile']) ? trim($_POST['mobile']) : '';

        $shop_close    = 0;
        $merchant_info = RC_DB::table('store_franchisee')->where('store_id', $_SESSION['store_id'])->first();
        if (empty($merchant_info['shop_close'])) {
            $shop_close = 1;
        }
        $type = 'shop_close';

        $past_time    = RC_Time::gmtime() - 1800;
        $staff_mobile = RC_DB::table('staff_user')->where('store_id', $_SESSION['store_id'])->where('parent_id', 0)->pluck('mobile');
        if (empty($code) || $code != $_SESSION[$type]['temp_code'] || $past_time >= $_SESSION[$type]['temp_code_time'] || $mobile != $_SESSION[$type]['temp_mobile'] || $staff_mobile != $_SESSION[$type]['temp_mobile']) {
            return $this->showmessage(__('请输入正确的手机验证码', 'merchant'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $switch_update = RC_DB::table('store_franchisee')->where('store_id', $_SESSION['store_id'])->update(array('shop_close' => $shop_close));

        /* 释放app缓存*/
        $store_franchisee_db = RC_Model::model('merchant/orm_store_franchisee_model');
        $store_cache_array   = $store_franchisee_db->get_cache_item('store_list_cache_key_array');
        if (!empty($store_cache_array)) {
            foreach ($store_cache_array as $val) {
                $store_franchisee_db->delete_cache_item($val);
            }
            $store_franchisee_db->delete_cache_item('store_list_cache_key_array');
        }

        if ($shop_close == '1') {
            clear_cart_list($_SESSION['store_id']);
        }
        if ($switch_update) {
            $_SESSION[$type]['temp_mobile']    = '';
            $_SESSION[$type]['temp_code']      = '';
            $_SESSION[$type]['temp_code_time'] = '';
            // 记录日志
            if ($shop_close == 0) {
                ecjia_merchant::admin_log(__('店铺营业', 'merchant'), 'edit', 'merchant');
            } else if ($shop_close == 1) {
                ecjia_merchant::admin_log(__('店铺打烊', 'merchant'), 'edit', 'merchant');
            }
            return $this->showmessage(__('编辑成功', 'merchant'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('merchant/merchant/mh_switch')));
        } else if ($switch_update == 0) {
            return $this->showmessage(__('您未做任何修改', 'merchant'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        } else {
            return $this->showmessage(__('修改失败，请重试！', 'merchant'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

    }

    public function get_code_value()
    {
        $mobile = isset($_GET['mobile']) ? $_GET['mobile'] : '';
        $type   = trim($_GET['type']);
        if (empty($mobile)) {
            return $this->showmessage(__('请输入手机号码', 'merchant'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('type' => $type));
        }
        $code     = rand(100000, 999999);
        $options  = array(
            'mobile' => $mobile,
            'event'  => 'sms_get_validate',
            'value'  => array(
                'code'          => $code,
                'service_phone' => ecjia::config('service_phone'),
            ),
        );
        $response = RC_Api::api('sms', 'send_event_sms', $options);

        $_SESSION[$type]['temp_mobile']    = $mobile;
        $_SESSION[$type]['temp_code']      = $code;
        $_SESSION[$type]['temp_code_time'] = RC_Time::gmtime();

        if (is_ecjia_error($response)) {
            return $this->showmessage($response->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('type' => $type));
        } else {
            return $this->showmessage(__('手机验证码发送成功，请注意查收', 'merchant'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('type' => $type));
        }
    }

    /**
     * 刷新店铺二维码
     */
    public function refresh_qrcode()
    {
        $store_id = $_SESSION['store_id'];
        //删除生成的店铺二维码
        $disk         = RC_Filesystem::disk();
        $store_qrcode = 'data/qrcodes/merchants/merchant_' . $store_id . '.png';
        if ($disk->exists(RC_Upload::upload_path($store_qrcode))) {
            $disk->delete(RC_Upload::upload_path() . $store_qrcode);
        }
        ecjia_merchant::admin_log(__('刷新店铺二维码', 'merchant'), 'edit', 'merchant');

        $merchant_info = get_merchant_info($_SESSION['store_id']);
        if (!empty($merchant_info['shop_logo'])) {
            with(new Ecjia\App\Mobile\Qrcode\GenerateMerchant($_SESSION['store_id'], $merchant_info['shop_logo']))->getQrcodeUrl();
        }
        return $this->showmessage(__('刷新成功', 'merchant'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('merchant/merchant/init')));
    }

    /**
     * 刷新店铺小程序二维码
     */
    public function refresh_weapp_qrcode()
    {
        $store_id = $_SESSION['store_id'];
        //删除生成的店铺小程序二维码
        $disk               = RC_Filesystem::disk();
        $store_weapp_qrcode = 'data/qrcodes/merchants/merchant_weapp_' . $store_id . '.png';
        if ($disk->exists(RC_Upload::upload_path($store_weapp_qrcode))) {
            $disk->delete(RC_Upload::upload_path() . $store_weapp_qrcode);
        }
        ecjia_merchant::admin_log(__('刷新店铺小程序二维码', 'merchant'), 'edit', 'merchant');

        $merchant_info = get_merchant_info($_SESSION['store_id']);
        if (!empty($merchant_info['shop_logo'])) {
            // with(new Ecjia\App\Mobile\Qrcode\GenerateMerchant($_SESSION['store_id'],  $merchant_info['shop_logo']))->getQrcodeUrl();
        }
        return $this->showmessage(__('刷新成功', 'merchant'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('merchant/merchant/init')));
    }

    /**
     * 下载二维码
     */
    public function download()
    {
        $type = trim($_GET['type']);
        $file = '';

        $disk = RC_Filesystem::disk();
        if ($type == 'merchant_qrcode') {
            $store_qrcode = 'data/qrcodes/merchants/merchant_' . $_SESSION['store_id'] . '.png';
            if ($disk->exists(RC_Upload::upload_path($store_qrcode))) {
                $file = RC_Upload::upload_url($store_qrcode) . '?' . time();
            }
            $filename = 'merchant_qrcode.png';
        } else if ($type == 'merchant_weapp_qrcode') {
            $file     = RC_Uri::url('weapp/wxacode/init', array('storeid' => $_SESSION['store_id']));
            $filename = 'merchant_weapp_qrcode.png';
        }

        if (empty($file)) {
            return false;
        }
        //文件的类型
        header('Content-type: application/octet-stream');
        //下载显示的名字
        header('Content-Disposition: attachment; filename=' . $filename);
        readfile($file);

        exit();
    }

    /**
     * 小程序模板
     */
    public function template()
    {
        $this->admin_priv('merchant_template');

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('小程序模板', 'merchant')));
        $this->assign('app_url', RC_App::apps_url('statics/img/template/', __FILE__));

        $shop_template_info = RC_DB::table('merchants_config')->where('store_id', $_SESSION['store_id'])->where('code', 'shop_template')->first();
        if (empty($shop_template_info)) {
            RC_DB::table('merchants_config')->where('store_id', $_SESSION['store_id'])->insert(array('code' => 'shop_template', 'value' => 'default1', 'store_id' => $_SESSION['store_id']));
            $this->assign('shop_template', 'default1');
        } else {
            $this->assign('shop_template', $shop_template_info['value']);
        }
        $this->assign('ur_here', __('小程序模板', 'merchant'));
        $this->assign('form_action', RC_Uri::url('merchant/merchant/template_update'));

        $this->display('merchant_template.dwt');
    }

    public function template_update()
    {
        $this->admin_priv('merchant_template', ecjia::MSGTYPE_JSON);

        $shop_template = trim($_POST['shop_template']);
        RC_DB::table('merchants_config')->where('store_id', $_SESSION['store_id'])->where('code', 'shop_template')->update(array('value' => $shop_template));
        return $this->showmessage(__('保存成功', 'merchant'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
    }

    public function make_thumb()
    {
        $merchant_info = get_merchant_info($_SESSION['store_id']);

        $type = trim($_POST['type']);
        if ($type == 'make') {
            $message = __('生成APP Banner缩略图成功', 'merchant');
        } elseif ($type == 'refresh') {
            $message = __('重新生成APP Banner缩略图成功', 'merchant');
        }

        $banner = (new \Ecjia\App\Merchant\StoreComponents\Banner\BannerThumb($merchant_info['shop_banner_pic']));
        $banner->createBannerThumbFile();

        return $this->showmessage($message, ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $this->request->header('referer')));
    }

    /**
     * PC首页模板
     */
    public function store_template()
    {
        $this->admin_priv('merchant_template');

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('PC店铺首页模板', 'merchant')));
        $this->assign('app_url', RC_App::apps_url('statics/img/store_index_template/', __FILE__));

        $shop_template_info = RC_DB::table('merchants_config')->where('store_id', $_SESSION['store_id'])->where('code', 'store_index_category_template')->first();
        if (empty($shop_template_info)) {
            RC_DB::table('merchants_config')->where('store_id', $_SESSION['store_id'])->insert(array('code' => 'store_index_category_template', 'value' => 'default1', 'store_id' => $_SESSION['store_id']));
            $this->assign('store_index_template', 'default1');
        } else {
            $this->assign('store_index_template', $shop_template_info['value']);
        }
        $this->assign('ur_here', __('PC店铺首页模板', 'merchant'));
        $this->assign('form_action', RC_Uri::url('merchant/merchant/store_template_update'));

        $preview_url = RC_Uri::url('main/merchants_store/home', array('merchant_id' => $_SESSION['store_id']));
        $preview_url = str_replace(RC_Uri::site_url(), RC_Uri::home_url(), $preview_url);

        $this->assign('action_link', array('href' => $preview_url, 'text' => __('预览效果', 'merchant')));

        $this->display('merchant_index_template.dwt');
    }

    public function store_template_update()
    {
        $this->admin_priv('merchant_template', ecjia::MSGTYPE_JSON);

        $store_index_template = trim($_POST['store_index_template']);
        RC_DB::table('merchants_config')->where('store_id', $_SESSION['store_id'])->where('code', 'store_index_category_template')->update(array('value' => $store_index_template));

        return $this->showmessage(__('保存成功', 'merchant'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
    }

    //注销店铺
    public function cancel_store()
    {
        $this->admin_priv('merchant_manage');

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('店铺设置', 'merchant'), RC_Uri::url('merchant/merchant/init')));
        $this->assign('action_link', array('href' => RC_Uri::url('merchant/merchant/init'), 'text' => __('店铺设置', 'merchant')));
        $this->assign('cancel_png', RC_App::apps_url('statics/img/cancel.png', __FILE__));

        $merchant_info = get_merchant_info($_SESSION['store_id']);
        $data          = get_store_info($_SESSION['store_id']);

        $shop_trade_time      = get_merchant_config('shop_trade_time', '', $_SESSION['store_id']);
        $data['shop_closed']  = get_shop_close($data['shop_close'], $shop_trade_time);
        $data['confirm_time'] = RC_Time::local_date('Y-m-d H:i:s', $data['confirm_time']);
        $data['shop_logo']    = !empty($merchant_info['shop_logo']) ? $merchant_info['shop_logo'] : RC_App::apps_url('statics/img/merchant_logo.jpg', __FILE__);

        $step = intval($_GET['step']);
        if (empty($step)) {
            $step = 1;
        }

        $ur_here = __('注销店铺', 'merchant');
        //已申请注销
        if (!empty($data['delete_time'])) {
            $ur_here             = __('激活店铺', 'merchant');
            $data['delete_time'] = RC_Time::local_date('Y/m/d H:i:s O', $data['delete_time'] + 30 * 24 * 3600);
            $this->assign('wait_delete', 1); //显示激活页面
            $step = 3;
            unset($_SESSION['cancel_store_temp']);
        } else {
            $temp_step = $_SESSION['cancel_store_temp']['step'];
            if ((empty($temp_step) && $step != 1) || (!empty($temp_step) && $temp_step < 2)) {
                return $this->redirect(RC_Uri::url('merchant/merchant/cancel_store'));
            }
        }
        $this->assign('store_info', $data);
        $this->assign('step', $step);

        //当前时间
        $time = RC_Time::local_date('Y-m-d H:i:s', RC_Time::gmtime());
        if(empty($data['confirm_time'])) {
            $data['confirm_time'] = empty($data['apply_time']) ? 0 : RC_Time::local_date('Y-m-d H:i:s', $data['apply_time']);
        }
        $diff = $this->diffDate($data['confirm_time'], $time);
        $this->assign('diff', $diff); //开店时长

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here($ur_here));
        $this->assign('ur_here', $ur_here);

        //店铺注销须知
        $article_info            = RC_DB::table('article')->where('title', '店铺注销须知')->where('article_approved', 1)->where('article_type', 'system')->first();
        $base                    = sprintf('<base href="%s/" />', dirname(SITE_URL));
        $article_info['content'] = preg_replace('/\\\"/', '"', $article_info['content']);
        $content                 = '<!DOCTYPE html><html><head><title>' . $article_info['title'] . '</title><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><meta name="viewport" content="initial-scale=1.0"><meta name="viewport" content="initial-scale = 1.0 , minimum-scale = 1.0 , maximum-scale = 1.0" /><style>img {width: auto\9;height: auto;vertical-align: middle;border: 0;-ms-interpolation-mode: bicubic;max-width: 100%; }html { font-size:100%; }p{word-wrap : break-word ;word-break:break-all;} </style>' . $base . '</head><body>' . $article_info['content'] . '</body></html>';

        $article_detail = array(
            'article_id' => intval($article_info['article_id']),
            'title'      => empty($article_info['title']) ? '' : trim($article_info['title']),
            'add_time'   => !empty($article_info['add_time']) ? RC_Time::local_date(ecjia::config('time_format'), $article_info['add_time']) : '',
            'content'    => $content,
        );
        $this->assign('article_detail', $article_detail);

        $this->display('merchant_cancel_store.dwt');
    }

    public function cancel_store_notice()
    {
        $this->admin_priv('merchant_manage');

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('店铺设置', 'merchant'), RC_Uri::url('merchant/merchant/init')));
        $this->assign('action_link', array('href' => RC_Uri::url('merchant/merchant/init'), 'text' => __('店铺设置', 'merchant')));
        $this->assign('cancel_png', RC_App::apps_url('statics/img/cancel.png', __FILE__));

        $ur_here = __('激活店铺', 'merchant');
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here($ur_here));
        $this->assign('ur_here', $ur_here);

        $data = get_store_info($_SESSION['store_id']);
        //已申请注销
        if (!empty($data['delete_time'])) {
            return $this->redirect(RC_Uri::url('merchant/merchant/cancel_store'));
        }

        $this->display('merchant_cancel_store_notice.dwt');
    }

    public function cancel_store_confirm()
    {
        $this->admin_priv('merchant_manage', ecjia::MSGTYPE_JSON);

        //检查是否满足注销条件
        $goods_count = RC_DB::table('goods')->where('store_id', $_SESSION['store_id'])->count();
        if (!empty($goods_count)) {
            return $this->showmessage(__('您店铺内还有商品，请将店内商品删除后再注销，避免出现新的交易！', 'merchant'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $order_count = RC_DB::table('order_info')
            ->where('store_id', $_SESSION['store_id'])
            ->where(function ($query) {
                $query->where('order_status', OS_UNCONFIRMED)
                    ->orWhere('shipping_status', array(SS_UNSHIPPED, SS_SHIPPED))
                    ->orWhere('pay_status', PS_UNPAYED);
            })
            ->count();

        $confirm_time = RC_DB::table('order_info')
            ->where('store_id', $_SESSION['store_id'])
            ->whereIn('order_status', array(OS_CONFIRMED, OS_SPLITED))
            ->where('shipping_status', SS_RECEIVED)
            ->where('pay_status', array(PS_PAYED, PS_PAYING))
            ->pluck('confirm_time');

        if (!empty($order_count) || (!empty($confirm_time) && $confirm_time - RC_Time::gmtime() < 15 * 3600 * 24)) {
            return $this->showmessage(__('您店铺内还有正在交易的订单，请等待订单完成15天后再来注销！', 'merchant'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $refund_count = RC_DB::table('refund_order')
            ->where('store_id', $_SESSION['store_id'])
            ->where(function ($query) {
                $query->where('status', 0)
                    ->orWhere('refund_status', 1);
            })
            ->count();
        if (!empty($refund_count)) {
            return $this->showmessage(__('您的店铺还有未完成的售后订单，请等待售后流程完成后再来注销！', 'merchant'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $data = RC_DB::table('store_account')->where('store_id', $_SESSION['store_id'])->first();
        if (empty($data)) {
            $amount_available = 0;
        } else {
            $amount_available = $data['money'] - $data['deposit']; //可用余额=money-保证金
        }
        if ($amount_available < 0) {
            return $this->showmessage(__('当前您的店铺资金还没有结清，请您结清后再来注销！', 'merchant'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        if ($amount_available > 0) {
            return $this->showmessage(__('当前您的店铺资金还没有全部取出，请您将资金全部取出后再来注销！', 'merchant'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $_SESSION['cancel_store_temp']['step'] = 2;
        return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('merchant/merchant/cancel_store', array('step' => 2))));
    }

    public function check_cancel_sms()
    {
        $this->admin_priv('merchant_manage', ecjia::MSGTYPE_JSON);

        $code   = !empty($_POST['code']) ? $_POST['code'] : '';
        $mobile = !empty($_POST['mobile']) ? trim($_POST['mobile']) : '';
        $type   = !empty($_POST['type']) ? trim($_POST['type']) : '';

        $past_time = RC_Time::gmtime() - 1800;
        $data      = get_store_info($_SESSION['store_id']);

        if (empty($code) || $code != $_SESSION[$type]['temp_code'] || $past_time >= $_SESSION[$type]['temp_code_time'] || $mobile != $_SESSION[$type]['temp_mobile'] || $data['contact_mobile'] != $_SESSION[$type]['temp_mobile']) {
            return $this->showmessage(__('请输入正确的手机验证码', 'merchant'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('type' => $type));
        }

        $_SESSION[$type]['temp_mobile']    = '';
        $_SESSION[$type]['temp_code']      = '';
        $_SESSION[$type]['temp_code_time'] = '';

        $url = RC_Uri::url('merchant/merchant/cancel_store', array('step' => 3));

        if ($type == 'cancel_store') {
            $data = array('account_status' => 'wait_delete', 'delete_time' => RC_Time::gmtime(), 'shop_close' => 1);
        } elseif ($type == 'active_store') {
            $data = array('account_status' => 'normal', 'delete_time' => 0, 'activate_time' => RC_Time::gmtime(), 'shop_close' => 0);
            $url  = RC_Uri::url('merchant/merchant/cancel_store_notice');
        }
        RC_DB::table('store_franchisee')->where('store_id', $_SESSION['store_id'])->update($data);

        return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $url));
    }

    private function diffDate($date1, $date2)
    {
        if(empty($date1)) {
            return 0;
        }
        $datetime1 = new \DateTime($date1);
        $datetime2 = new \DateTime($date2);
        $interval  = $datetime1->diff($datetime2);
        $time['y'] = $interval->format('%Y');
        $time['m'] = $interval->format('%m');
        $time['d'] = $interval->format('%d');

        $time_str = '';
        $year     = intval($time['y']);
        if (!empty($year)) {
            $time_str .= $year . __('年', 'merchant');
        }
        $month = intval($time['m']);
        if (!empty($month)) {
            $time_str .= $month . __('个月', 'merchant');
        }
        $day = intval($time['d']);
        if (!empty($day)) {
            $time_str .= $day . __('天', 'merchant');
        }
        return $time_str;
    }
}

//end
