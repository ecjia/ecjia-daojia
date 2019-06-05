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
 * ECJIA平台、公众号配置
 */
class merchant extends ecjia_merchant
{
    public function __construct()
    {
        parent::__construct();

        Ecjia\App\Platform\Helper::assign_adminlog_content();

        /* 加载全局 js/css */
        RC_Script::enqueue_script('jquery-validate');
        RC_Script::enqueue_script('jquery-form');
        RC_Script::enqueue_script('smoke');
        RC_Style::enqueue_style('uniform-aristo');
        RC_Script::enqueue_script('bootstrap-fileupload-script', dirname(RC_App::app_dir_url(__FILE__)) . '/merchant/statics/assets/bootstrap-fileupload/bootstrap-fileupload.js', array());
        RC_Style::enqueue_style('bootstrap-fileupload', dirname(RC_App::app_dir_url(__FILE__)) . '/merchant/statics/assets/bootstrap-fileupload/bootstrap-fileupload.css', array(), false, false);

        RC_Script::enqueue_script('ecjia-mh-editable-js');
        RC_Style::enqueue_style('ecjia-mh-editable-css');

        RC_Script::enqueue_script('clipboard', RC_App::apps_url('statics/js/clipboard.min.js', __FILE__));
        RC_Script::enqueue_script('platform', RC_App::apps_url('statics/mh-js/platform.js', __FILE__), array(), false, true);
        RC_Script::localize_script('platform', 'js_lang', config('app-platform::jslang.merchant_page'));

        RC_Style::enqueue_style('wechat_extend', RC_App::apps_url('statics/css/wechat_extend.css', __FILE__));

        ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('公众号列表', 'platform'), RC_Uri::url('platform/merchant/init')));
        ecjia_merchant_screen::get_current_screen()->set_parentage('store', 'store/merchant.php');
    }

    /**
     * 公众号列表
     */
    public function init()
    {
        $this->admin_priv('platform_config_manage');

        ecjia_merchant_screen::get_current_screen()->remove_last_nav_here();
        ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('公众号列表', 'platform')));
        ecjia_merchant_screen::get_current_screen()->add_help_tab(array(
            'id'      => 'overview',
            'title'   => __('概述', 'platform'),
            'content' =>
                '<p>' . __('欢迎访问ECJia智能后台公众号列表页面，系统中所有的公众号都会显示在此列表中。', 'platform') . '</p>',
        ));

        ecjia_merchant_screen::get_current_screen()->set_help_sidebar(
            '<p><strong>' . __('更多信息：', 'platform') . '</strong></p>' .
            '<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia公众平台:管理公众号" target="_blank">' . __('关于公众号列表帮助文档', 'platform') . '</a>') . '</p>'
        );

        $this->assign('ur_here', __('公众号列表', 'platform'));

        $wechat_list = $this->wechat_list();
        $this->assign('wechat_list', $wechat_list);
        $this->assign('search_action', RC_Uri::url('platform/merchant/init'));

        if ($wechat_list['count'] == 0) {
            $this->assign('action_link', array('text' => __('添加公众号', 'platform'), 'href' => RC_Uri::url('platform/merchant/add')));
        }

        return $this->display('wechat_list.dwt');
    }

    /**
     * 添加公众号页面
     */
    public function add()
    {
        $this->admin_priv('platform_config_add');

        ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('公众号列表', 'platform')));
        ecjia_merchant_screen::get_current_screen()->add_help_tab(array(
            'id'      => 'overview',
            'title'   => __('概述', 'platform'),
            'content' => '<p>' . __('欢迎访问ECJia智能后台添加公众号页面，在此页面可以进行添加公众号操作。', 'platform') . '</p>',
        ));

        ecjia_merchant_screen::get_current_screen()->set_help_sidebar(
            '<p><strong>' . __('更多信息：', 'platform') . '</strong></p>' .
            '<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia公众平台:管理公众号#.E6.B7.BB.E5.8A.A0.E5.85.AC.E4.BC.97.E5.8F.B7" target="_blank">' . __('关于添加公众号帮助文档', 'platform') . '</a>') . '</p>'
        );

        $count = RC_DB::table('platform_account')->where('shop_id', $_SESSION['store_id'])->where('platform', '!=', 'weapp')->count();
        if ($count != 0) {
            return $this->showmessage(__('每个商家只能添加一个公众号', 'platform'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR);
        }

        $this->assign('ur_here', __('添加公众号', 'platform'));
        $this->assign('action_link', array('text' => __('公众号列表', 'platform'), 'href' => RC_Uri::url('platform/merchant/init')));
        $this->assign('form_action', RC_Uri::url('platform/merchant/insert'));
        $this->assign('wechat', array('status' => 1));

        return $this->display('wechat_edit.dwt');
    }

    /**
     * 添加公众号处理
     */
    public function insert()
    {
        $this->admin_priv('platform_config_add', ecjia::MSGTYPE_JSON);

        $platform  = !empty($_POST['platform']) ? trim($_POST['platform']) : '';
        $type      = !empty($_POST['type']) ? intval($_POST['type']) : 0;
        $name      = !empty($_POST['name']) ? trim($_POST['name']) : '';
        $token     = !empty($_POST['token']) ? trim($_POST['token']) : '';
        $appid     = !empty($_POST['appid']) ? trim($_POST['appid']) : '';
        $appsecret = !empty($_POST['appsecret']) ? trim($_POST['appsecret']) : '';
        $aeskey    = !empty($_POST['aeskey']) ? trim($_POST['aeskey']) : '';

        $count = RC_DB::table('platform_account')->where('shop_id', $_SESSION['store_id'])->where('platform', '!=', 'weapp')->count();
        if ($count != 0) {
            return $this->showmessage(__('每个商家只能添加一个公众号', 'platform'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        if (empty($platform)) {
            return $this->showmessage(__('请选择平台', 'platform'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        if (empty($name)) {
            return $this->showmessage(__('请输入公众号名称', 'platform'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        if (empty($token)) {
            return $this->showmessage(__('请输入Token', 'platform'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        if (empty($appid)) {
            return $this->showmessage(__('请输入AppID', 'platform'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        if (empty($appsecret)) {
            return $this->showmessage(__('请输入AppSecret', 'platform'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $uuid = Royalcms\Component\Uuid\Uuid::generate();
        $uuid = str_replace("-", "", $uuid);

        if ((isset($_FILES['platform_logo']['error']) && $_FILES['platform_logo']['error'] == 0) || (!isset($_FILES['platform_logo']['error']) && isset($_FILES['platform_logo']['tmp_name']) && $_FILES['platform_logo']['tmp_name'] != 'none')) {
            $upload     = RC_Upload::uploader('image', array('save_path' => 'data/platform', 'auto_sub_dirs' => false));
            $image_info = $upload->upload($_FILES['platform_logo']);
            if (!empty($image_info)) {
                $platform_logo = $upload->get_position($image_info);
            } else {
                return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
        } else {
            $platform_logo = '';
        }

        $data = array(
            'uuid'      => $uuid,
            'platform'  => $platform,
            'logo'      => $platform_logo,
            'type'      => $type,
            'name'      => $name,
            'token'     => $token,
            'appid'     => $appid,
            'appsecret' => $appsecret,
            'aeskey'    => $aeskey,
            'add_time'  => RC_Time::gmtime(),
            'sort'      => intval($_POST['sort']),
            'status'    => intval($_POST['status']),
            'shop_id'   => $_SESSION['store_id'],
        );
        $id   = RC_DB::table('platform_account')->insertGetId($data);

        ecjia_merchant::admin_log($_POST['name'], 'add', 'wechat');
        return $this->showmessage(__('添加公众号成功！', 'platform'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('platform/merchant/edit', array('id' => $id))));
    }

    /**
     * 编辑公众号页面
     */
    public function edit()
    {
        $this->admin_priv('platform_config_update');

        $this->assign('ur_here', __('编辑公众号', 'platform'));
        $this->assign('action_link', array('text' => __('公众号列表', 'platform'), 'href' => RC_Uri::url('platform/merchant/init')));
        ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('编辑公众号', 'platform')));

        ecjia_merchant_screen::get_current_screen()->add_help_tab(array(
            'id'      => 'overview',
            'title'   => __('概述', 'platform'),
            'content' =>
                '<p>' . __('欢迎访问ECJia智能后台编辑公众号页面，在此页面可以进行编辑公众号操作。', 'platform') . '</p>',
        ));

        ecjia_merchant_screen::get_current_screen()->set_help_sidebar(
            '<p><strong>' . __('更多信息：', 'platform') . '</strong></p>' .
            '<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia公众平台:管理公众号#.E7.BC.96.E8.BE.91.E5.85.AC.E4.BC.97.E5.8F.B7" target="_blank">' . __('关于编辑公众号帮助文档', 'platform') . '</a>') . '</p>'
        );

        $wechat = RC_DB::table('platform_account')->where('shop_id', $_SESSION['store_id'])->where('id', intval($_GET['id']))->first();
        if (!empty($wechat['logo'])) {
            $wechat['logo'] = RC_Upload::upload_url($wechat['logo']);
        }
        $url = RC_Uri::home_url() . '/sites/platform/?uuid=' . $wechat['uuid'];
        $this->assign('wechat', $wechat);
        $this->assign('url', $url);

        $this->assign('form_action', RC_Uri::url('platform/merchant/update'));

        return $this->display('wechat_edit.dwt');
    }

    /**
     * 编辑公众号处理
     */
    public function update()
    {
        $this->admin_priv('platform_config_update', ecjia::MSGTYPE_JSON);

        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;

        $platform  = !empty($_POST['platform']) ? trim($_POST['platform']) : '';
        $type      = !empty($_POST['type']) ? intval($_POST['type']) : 0;
        $name      = !empty($_POST['name']) ? trim($_POST['name']) : '';
        $token     = !empty($_POST['token']) ? trim($_POST['token']) : '';
        $appid     = !empty($_POST['appid']) ? trim($_POST['appid']) : '';
        $appsecret = !empty($_POST['appsecret']) ? trim($_POST['appsecret']) : '';
        $aeskey    = !empty($_POST['aeskey']) ? trim($_POST['aeskey']) : '';

        if (empty($platform)) {
            return $this->showmessage(__('请选择平台', 'platform'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        if (empty($name)) {
            return $this->showmessage(__('请输入公众号名称', 'platform'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        if (empty($token)) {
            return $this->showmessage(__('请输入Token', 'platform'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        if (empty($appid)) {
            return $this->showmessage(__('请输入AppID', 'platform'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        if (empty($appsecret)) {
            return $this->showmessage(__('请输入AppSecret', 'platform'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        //获取旧的logo
        $old_logo = RC_DB::table('platform_account')->where('shop_id', $_SESSION['store_id'])->where('id', $id)->pluck('logo');

        if ((isset($_FILES['platform_logo']['error']) && $_FILES['platform_logo']['error'] == 0) || (!isset($_FILES['platform_logo']['error']) && isset($_FILES['platform_logo']['tmp_name']) && $_FILES['platform_logo']['tmp_name'] != 'none')) {
            $upload     = RC_Upload::uploader('image', array('save_path' => 'data/platform', 'auto_sub_dirs' => false));
            $image_info = $upload->upload($_FILES['platform_logo']);

            if (!empty($image_info)) {
                //删除原来的logo
                if (!empty($old_logo)) {
                    $upload->remove($old_logo);
                }
                $platform_logo = $upload->get_position($image_info);
            } else {
                return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
        } else {
            $platform_logo = $old_logo;
        }
        $data = array(
            'platform'  => $platform,
            'type'      => $type,
            'name'      => $name,
            'logo'      => $platform_logo,
            'token'     => $token,
            'appid'     => $appid,
            'appsecret' => $appsecret,
            'aeskey'    => $aeskey,
            'sort'      => intval($_POST['sort']),
            'status'    => intval($_POST['status']),
        );
        RC_DB::table('platform_account')->where('shop_id', $_SESSION['store_id'])->where('id', $id)->update($data);

        ecjia_merchant::admin_log($_POST['name'], 'edit', 'wechat');
        return $this->showmessage(__('编辑公众号成功！', 'platform'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('platform/merchant/edit', array('id' => $id))));
    }

    /**
     * 删除公众号
     */
    public function remove()
    {
        $this->admin_priv('platform_config_delete', ecjia::MSGTYPE_JSON);

        $id   = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $info = RC_DB::table('platform_account')->where('shop_id', $_SESSION['store_id'])->where('id', $id)->select('name', 'logo')->first();

        if (!empty($info['logo'])) {
            $disk = RC_Filesystem::disk();
            $disk->delete(RC_Upload::upload_path() . $info['logo']);
        }
        $success = RC_DB::table('platform_account')->where('shop_id', $_SESSION['store_id'])->where('id', $id)->delete();
        if ($success) {
            //删除公众号扩展及扩展命令
            RC_DB::table('platform_config')->where('account_id', $id)->delete();
            RC_DB::table('platform_command')->where('account_id', $id)->delete();
            RC_DB::table('wechat_oauth')->where('wechat_id', $id)->delete();

            ecjia_merchant::admin_log($info['name'], 'remove', 'wechat');
            return $this->showmessage(__('删除公众号成功！', 'platform'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('platform/merchant/init')));
        } else {
            return $this->showmessage(__('删除公众号失败！', 'platform'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    /**
     * 批量删除
     */
    public function batch_remove()
    {
        $this->admin_priv('platform_config_delete', ecjia::MSGTYPE_JSON);

        $idArr = explode(',', $_POST['id']);

        $info = RC_DB::table('platform_account')->where('shop_id', $_SESSION['store_id'])->whereIn('id', $idArr)->select('name')->get();
        foreach ($info as $v) {
            ecjia_merchant::admin_log($v['name'], 'batch_remove', 'wechat');
        }
        RC_DB::table('platform_account')->where('shop_id', $_SESSION['store_id'])->whereIn('id', $idArr)->delete();
        return $this->showmessage(__('批量删除成功', 'platform'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('platform/merchant/init')));
    }

    /**
     * 删除logo
     */
    public function remove_logo()
    {
        $this->admin_priv('platform_config_update', ecjia::MSGTYPE_JSON);

        $id   = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $info = RC_DB::table('platform_account')->where('shop_id', $_SESSION['store_id'])->where('id', $id)->select('name', 'logo')->first();

        if (!empty($info['logo'])) {
            $disk = RC_Filesystem::disk();
            $disk->delete(RC_Upload::upload_path() . $info['logo']);
        }
        $data = array('logo' => '');
        RC_DB::table('platform_account')->where('shop_id', $_SESSION['store_id'])->where('id', $id)->update($data);

        ecjia_merchant::admin_log(sprintf(__('公众号名称为%s', 'platform'), $info['name']), 'remove', 'platform_logo');
        return $this->showmessage(__('删除成功', 'platform'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
    }

    /**
     * 切换状态
     */
    public function toggle_show()
    {
        $this->admin_priv('platform_config_update', ecjia::MSGTYPE_JSON);

        $id  = intval($_POST['id']);
        $val = intval($_POST['val']);
        RC_DB::table('platform_account')->where('shop_id', $_SESSION['store_id'])->where('id', $id)->update(array('status' => $val));

        $name = RC_DB::table('platform_account')->where('shop_id', $_SESSION['store_id'])->where('id', $id)->pluck('name');
        if ($val == 1) {
            ecjia_merchant::admin_log($name, 'use', 'wechat');
        } else {
            ecjia_merchant::admin_log($name, 'stop', 'wechat');
        }

        return $this->showmessage(__('切换状态成功！', 'platform'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $val, 'pjaxurl' => RC_Uri::url('platform/merchant/init')));
    }

    /**
     * 手动排序
     */
    public function edit_sort()
    {
        $this->admin_priv('platform_config_update', ecjia::MSGTYPE_JSON);

        $id   = intval($_POST['pk']);
        $sort = trim($_POST['value']);

        if (!empty($sort)) {
            if (!is_numeric($sort)) {
                return $this->showmessage(__('请输入数值！', 'platform'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            } else {
                RC_DB::table('platform_account')->where('shop_id', $_SESSION['store_id'])->where('id', $id)->update(array('sort' => $sort));

                return $this->showmessage(__('编辑排序成功！', 'platform'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_uri::url('platform/merchant/init')));
            }
        } else {
            return $this->showmessage(__('公众号排序不能为空！', 'platform'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    public function autologin()
    {
        $id = $this->request->input('id');

        $uuid = RC_DB::table('platform_account')->where('shop_id', $_SESSION['store_id'])->where('id', $id)->pluck('uuid');
        if (empty($uuid)) {
            return $this->showmessage(__('该公众号不存在', 'platform'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR);
        }

        //公众平台的超管权限同商家店长的权限
        if (session('action_list') == all) {
            $user = new Ecjia\App\Merchant\Frameworks\Users\StaffUser(session('staff_id'), session('store_id'), '\Ecjia\App\Platform\Frameworks\Users\StaffUserAllotPurview');
            if ($user->getActionList() != 'all') {
                $user->setActionList('all');
            }
        }

        $authcode_array = [
            'uuid'      => $uuid,
            'user_id'   => session('staff_id'),
            'user_type' => 'merchant',
            'time'      => RC_Time::gmtime(),
        ];

        $authcode_str = http_build_query($authcode_array);
        $authcode     = RC_Crypt::encrypt($authcode_str);
        $url          = str_replace("sites/merchant/index.php", "sites/platform/index.php", RC_Uri::url('platform/privilege/autologin')) . '&authcode=' . $authcode;
        return $this->redirect($url);
    }

    /**
     * 生成token
     */
    public function generate_token()
    {
        $key = rc_random(16, 'abcdefghijklmnopqrstuvwxyz0123456789');
        $key = 'ecjia' . $key;
        return $this->showmessage(__('生成token成功', 'platform'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('token' => $key));
    }

    /**
     * 公众号列表
     */
    private function wechat_list()
    {
        $db_platform_account = RC_DB::table('platform_account')->where('shop_id', $_SESSION['store_id']);

        $filter             = array();
        $filter['keywords'] = empty($_GET['keywords']) ? '' : trim($_GET['keywords']);

        if ($filter['keywords']) {
            $db_platform_account->where('name', 'like', '%" . mysql_like_quote("' . $filter['keywords'] . '") . "%');
        }
        $db_platform_account->where('platform', '!=', 'weapp');

        $platform = !empty($_GET['platform']) ? $_GET['platform'] : '';
        if (!empty($platform)) {
            $db_platform_account->where('platform', $platform);
        }

        $count                  = $db_platform_account->count();
        $filter['record_count'] = $count;
        $page                   = new ecjia_merchant_page($count, 10, 5);

        $arr  = array();
        $data = $db_platform_account->orderBy('sort', 'asc')->orderBy('add_time', 'desc')->take(10)->skip($page->start_id - 1)->get();
        if (isset($data)) {
            foreach ($data as $rows) {
                $rows['add_time'] = RC_Time::local_date(ecjia::config('time_format'), $rows['add_time']);
                if (empty($rows['logo'])) {
                    $rows['logo'] = RC_Uri::admin_url('statics/images/nopic.png');
                } else {
                    $rows['logo'] = RC_Upload::upload_url($rows['logo']);
                }
                $arr[] = $rows;
            }
        }
        return array('item' => $arr, 'filter' => $filter, 'page' => $page->show(5), 'desc' => $page->page_desc(), 'count' => $count);
    }

}

//end
