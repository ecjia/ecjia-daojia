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

class merchant extends ecjia_merchant
{
    public function __construct()
    {
        parent::__construct();

        Ecjia\App\Toutiao\Helper::assign_adminlog_content();

        /* 加载全局 js/css */
        RC_Script::enqueue_script('smoke');
        RC_Script::enqueue_script('jquery-validate');
        RC_Script::enqueue_script('jquery-form');
        RC_Script::enqueue_script('jquery-dropper', RC_App::apps_url('statics/js/dropper-upload/jquery.fs.dropper.js', __FILE__), array(), false, 1);

        RC_Script::enqueue_script('bootstrap-fileupload-script', dirname(RC_App::app_dir_url(__FILE__)) . '/merchant/statics/assets/bootstrap-fileupload/bootstrap-fileupload.js', array());
        RC_Style::enqueue_style('bootstrap-fileupload', dirname(RC_App::app_dir_url(__FILE__)) . '/merchant/statics/assets/bootstrap-fileupload/bootstrap-fileupload.css', array(), false, false);

        RC_Script::enqueue_script('mh_menu_js', RC_App::apps_url('statics/js/mh_menu.js', __FILE__), array(), false, 1);

        RC_Script::enqueue_script('mh_toutiao_js', RC_App::apps_url('statics/js/mh_toutiao.js', __FILE__), array(), false, 1);
        RC_Style::enqueue_style('mh_material_css', RC_App::apps_url('statics/css/mh_material.css', __FILE__));
        RC_Script::localize_script('mh_toutiao_js', 'js_lang', config('app-toutiao::jslang.toutiao_page'));

        ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('头条', 'toutiao'), RC_Uri::url('toutiao/mh_menu/init')));
        ecjia_merchant_screen::get_current_screen()->set_parentage('toutiao', 'toutiao/mh_menu.php');
    }

    public function init()
    {
        $this->admin_priv('toutiao_manage');

        ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('今日热点', 'toutiao')));
        $this->assign('ur_here', __('今日热点列表', 'toutiao'));
        $this->assign('action_link', array('href' => RC_Uri::url('toutiao/merchant/add'), 'text' => __('添加图文素材', 'toutiao')));

        $type = isset($_GET['type']) ? remove_xss($_GET['type']) : '';
        $this->assign('type', $type);

        $list = $this->get_toutiao_list();
        $this->assign('list', $list);
        $this->assign('type_count', $list['count']);

        $limit          = RC_Loader::load_app_config('send_limit', 'toutiao');
        $send_limit     = $limit['send_limit'];
        $residue_degree = $send_limit - $list['count']['send'] < 0 ? 0 : $send_limit - $list['count']['send'];
        $this->assign('residue_degree', $residue_degree);

        $this->display('toutiao_list.dwt');
    }

    public function add()
    {
        $this->admin_priv('toutiao_update');
        ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('今日热点', 'toutiao'), RC_Uri::url('toutiao/merchant/init', array('type' => 'media'))));
        ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('添加图文素材', 'toutiao')));

        $this->assign('ur_here', __('添加图文素材', 'toutiao'));
        $this->assign('action_link', array('href' => RC_Uri::url('toutiao/merchant/init', array('type' => 'media')), 'text' => __('今日热点列表', 'toutiao')));
        $this->assign('form_action', RC_Uri::url('toutiao/merchant/insert'));

        $this->display('toutiao_add.dwt');
    }

    /**
     * 图文添加数据插入
     */
    public function insert()
    {
        $this->admin_priv('toutiao_update', ecjia::MSGTYPE_JSON);

        $id = intval($this->request->query('id', 0));

        $title       = !empty($_POST['title']) ? remove_xss($_POST['title']) : '';
        $description = !empty($_POST['description']) ? remove_xss($_POST['description']) : '';
        $content_url = !empty($_POST['content_url']) ? remove_xss($_POST['content_url']) : '';
        $sort        = !empty($_POST['sort']) ? intval($_POST['sort']) : 0;
        $content     = !empty($_POST['content']) ? stripslashes($_POST['content']) : '';

        $thumb_media_id = $this->request->input('thumb_media_id');

        if (empty($title)) {
            return $this->showmessage(__('请输入标题', 'toutiao'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $result = $this->get_file_name($_FILES);
        if ($result['type'] == 'error') {
            return $this->showmessage($result['message'], ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $data = array(
            'store_id'    => $_SESSION['store_id'],
            'title'       => $title,
            'description' => $description,
            'image'       => $result,
            'content_url' => $content_url,
            'content'     => $content,
            'sort'        => $sort,
            'create_time' => RC_Time::gmtime(),
        );

        if ($id) {
            $data['group_id'] = $id;
        } else {
            $data['group_id'] = 0;
        }

        $id = RC_DB::table('merchant_news')->insertGetId($data);
        ecjia_merchant::admin_log($title, 'add', 'news');

        $links[] = array('text' => __('今日热点列表', 'toutiao'), 'href' => RC_Uri::url('toutiao/merchant/init'));
        $links[] = array('text' => __('继续添加素材', 'toutiao'), 'href' => RC_Uri::url('toutiao/merchant/add'));
        return $this->showmessage(__('添加成功', 'toutiao'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links, 'pjaxurl' => RC_Uri::url('toutiao/merchant/edit', array('id' => $id))));

    }

    /**
     * 素材编辑
     */
    public function edit()
    {
        $this->admin_priv('wechat_material_update');

        $id = intval($_GET['id']);

        $article = RC_DB::table('merchant_news')->where('store_id', $_SESSION['store_id'])->where('id', $id)->first();
        if (empty($article)) {
            return $this->showmessage(__('该素材不存在', 'toutiao'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR);
        }

        if ($article['group_id'] > 0) {
            $group_id = $article['group_id'];
        } else {
            $group_id = $id;
        }

        ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('今日热点', 'toutiao'), RC_Uri::url('toutiao/merchant/init', array('type' => 'media'))));
        ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('图文编辑', 'toutiao')));
        ecjia_merchant_screen::get_current_screen()->set_sidebar_display(false);

        $this->assign('ur_here', __('图文编辑', 'toutiao'));
        $this->assign('form_action', RC_Uri::url('toutiao/merchant/update', array('id' => $id)));
        $this->assign('action_link', array('href' => RC_Uri::url('toutiao/merchant/init', array('type' => 'media')), 'text' => __('今日热点列表', 'toutiao')));

        $media_data               = RC_DB::table('merchant_news')->where('store_id', $_SESSION['store_id'])->where('id', $group_id)->first();
        $media_data['real_image'] = !empty($media_data['image']) ? 1 : 0;
        $media_data['image']      = !empty($media_data['image']) ? RC_Upload::upload_url($media_data['image']) : RC_Uri::admin_url('statics/images/nopic.png');
        $article['articles'][0]   = $media_data;

        $db_merchant_news = RC_DB::table('merchant_news')->where('store_id', $_SESSION['store_id']);

        $data = $db_merchant_news->where('group_id', $group_id)->orderBy('sort', 'asc')->orderBy('id', 'asc')->get();
        if (!empty($data)) {
            foreach ($data as $k => $v) {
                $v['real_image']             = $v['image'];
                $v['image']                  = !empty($v['image']) ? RC_Upload::upload_url($v['image']) : RC_Uri::admin_url('statics/images/nopic.png');
                $article['articles'][$k + 1] = $v;
            }
        }

        $this->assign('media_data', $media_data);
        $this->assign('article', $article);
        $this->assign('group_id', $group_id);
        $this->assign('id', $id);

        $type_count = $this->get_type_count();
        $limit      = RC_Loader::load_app_config('send_limit', 'toutiao');

        $residue_degree = $limit['send_limit'] - $type_count['send'] < 0 ? 0 : $limit['send_limit'] - $type_count['send'];
        $this->assign('residue_degree', $residue_degree);

        $this->display('toutiao_edit.dwt');
    }

    /**
     * 更新单篇图文素材
     */
    public function update()
    {
        $this->admin_priv('toutiao_update', ecjia::MSGTYPE_JSON);

        $id          = !empty($_GET['id']) ? intval($_GET['id']) : 0;
        $title       = !empty($_POST['title']) ? remove_xss($_POST['title']) : '';
        $description = !empty($_POST['description']) ? remove_xss($_POST['description']) : '';
        $content_url = !empty($_POST['content_url']) ? remove_xss($_POST['content_url']) : '';
        $sort        = !empty($_POST['sort']) ? intval($_POST['sort']) : 0;
        $content     = !empty($_POST['content']) ? stripslashes($_POST['content']) : '';

        if (empty($id)) {
            return $this->showmessage(__('图文素材ID不存在。', 'toutiao'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        if (empty($title)) {
            return $this->showmessage(__('请输入图文标题', 'toutiao'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $result = $this->get_file_name($_FILES, $id);
        if ($result['type'] == 'error') {
            return $this->showmessage($result['message'], ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $data = array(
            'store_id'    => $_SESSION['store_id'],
            'title'       => $title,
            'description' => $description,
            'image'       => $result,
            'content_url' => $content_url,
            'content'     => $content,
            'sort'        => $sort,
            'create_time' => RC_Time::gmtime(),
        );

        RC_DB::table('merchant_news')->where('store_id', $_SESSION['store_id'])->where('id', $id)->update($data);

        ecjia_merchant::admin_log($title, 'edit', 'news');

        return $this->showmessage(__('编辑成功', 'toutiao'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('toutiao/merchant/edit', array('id' => $id))));
    }

    /**
     * 添加子图文
     */
    public function add_child_article()
    {
        $this->admin_priv('toutiao_update', ecjia::MSGTYPE_JSON);

        $group_id    = !empty($_GET['group_id']) ? intval($_GET['group_id']) : 0;
        $title       = !empty($_POST['title']) ? remove_xss($_POST['title']) : '';
        $description = !empty($_POST['description']) ? remove_xss($_POST['description']) : '';
        $content_url = !empty($_POST['content_url']) ? remove_xss($_POST['content_url']) : '';
        $sort        = !empty($_POST['sort']) ? intval($_POST['sort']) : 0;
        $content     = !empty($_POST['content']) ? stripslashes($_POST['content']) : '';

        if (empty($title)) {
            return $this->showmessage(__('请输入图文标题', 'toutiao'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $result = $this->get_file_name($_FILES);
        if ($result['type'] == 'error') {
            return $this->showmessage($result['message'], ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $data = array(
            'store_id'    => $_SESSION['store_id'],
            'title'       => $title,
            'description' => $description,
            'image'       => $result,
            'content_url' => $content_url,
            'content'     => $content,
            'sort'        => $sort,
            'create_time' => RC_Time::gmtime(),
            'group_id'    => $group_id,
        );

        //添加多图文素材
        $id = RC_DB::table('merchant_news')->insertGetId($data);
        ecjia_merchant::admin_log($title, 'add', 'news');

        return $this->showmessage(__('添加成功', 'toutiao'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('toutiao/merchant/edit', array('id' => $id))));
    }

    /**
     * 移除子图文
     */
    public function remove_child_article()
    {
        $this->admin_priv('toutiao_update', ecjia::MSGTYPE_JSON);

        $id = !empty($_GET['id']) ? intval($_GET['id']) : 0;
        if (empty($id)) {
            return $this->showmessage(__('图文素材ID不存在。', 'toutiao'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $info = RC_DB::table('merchant_news')->where('store_id', $_SESSION['store_id'])->where('id', $id)->first();

        RC_DB::table('merchant_news')->where('store_id', $_SESSION['store_id'])->where('id', $id)->delete();
        ecjia_merchant::admin_log($info['title'], 'remove', 'news');

        return $this->showmessage(sprintf(__("移除%s图文素材成功", 'toutiao'), $info['title']), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('toutiao/merchant/edit', array('id' => $info['group_id']))));
    }

    /**
     * 删除图文素材
     */
    public function remove()
    {
        $this->admin_priv('toutiao_delete', ecjia::MSGTYPE_JSON);

        $id = !empty($_GET['id']) ? intval($_GET['id']) : 0;

        $info = RC_DB::table('merchant_news')->where('store_id', $_SESSION['store_id'])->where('id', $id)->first();
        RC_DB::table('merchant_news')->where('store_id', $_SESSION['store_id'])->where('id', $id)->orWhere('group_id', $id)->delete();

        ecjia_merchant::admin_log($info['title'], 'remove', 'news');
        return $this->showmessage(__('删除成功', 'toutiao'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
    }

    /**
     * 删除封面
     */
    public function remove_file()
    {
        $this->admin_priv('toutiao_delete', ecjia::MSGTYPE_JSON);

        $id   = !empty($_GET['id']) ? intval($_GET['id']) : 0;
        $info = RC_DB::table('merchant_news')->where('store_id', $_SESSION['store_id'])->where('id', $id)->first();
        if (!empty($info['image'])) {
            $disk = RC_Filesystem::disk();
            $disk->delete(RC_Upload::upload_path() . $info['image']);
        }

        RC_DB::table('merchant_news')->where('store_id', $_SESSION['store_id'])->where('id', $id)->update(array('image' => ''));

        return $this->showmessage(__('删除成功', 'toutiao'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
    }

    /**
     * 获取选中素材信息
     */
    public function get_material_info()
    {
        $id                 = intval($_GET['id']);
        $info               = RC_DB::table('merchant_news')->where('store_id', $_SESSION['store_id'])->where('id', $id)->first();
        $info['real_image'] = $info['image'];
        $info['image']      = empty($info['image']) ? RC_Uri::admin_url('statics/images/nopic.png') : RC_Upload::upload_url($info['image']);
        $info['href']       = RC_Uri::url('toutiao/merchant/remove_file', array('id' => $id));

        return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $info));
    }

    /**
     * 上传封面
     */
    private function get_file_name($files = [], $id = 0)
    {
        if (empty($files) && empty($id)) {
            return array('type' => 'error', 'message' => __('请上传封面', 'toutiao'));
        }
        $_FILES = $files;

        $info      = RC_DB::table('merchant_news')->where('store_id', $_SESSION['store_id'])->where('id', $id)->first();
        $file_name = '';
        if ((isset($_FILES['image']['error']) && $_FILES['image']['error'] == 0) || (!isset($_FILES['image']['error']) && isset($_FILES['image']['tmp_name']) && $_FILES['image']['tmp_name'] != 'none')) {
            $size = $_FILES['image']['size'];
            // if ($size / 1000 > 40) {
            //     return array('type' => 'error', 'message' => '图片大小不能超过40kb');
            // }
            $upload     = RC_Upload::uploader('image', array('save_path' => 'data/toutiao', 'auto_sub_dirs' => false));
            $image_info = $upload->upload($_FILES['image']);

            if (!empty($image_info)) {
                $file_name = $upload->get_position($image_info);
                //删除原图片
                if (!empty($info['image'])) {
                    $disk = RC_Filesystem::disk();
                    $disk->delete(RC_Upload::upload_path() . $info['image']);
                }
                return $file_name;
            } else {
                return array('type' => 'error', 'message' => $upload->error());
            }
        } else {
            $file_name = $info['image'];
            return $file_name;
        }
    }

    /**
     * 发送素材
     */
    public function send()
    {
        $id = intval($_GET['id']);

        $info = RC_DB::table('merchant_news')->where('store_id', $_SESSION['store_id'])->where('id', $id)->first();
        if (empty($info)) {
            return $this->showmessage(__('该素材不存在', 'toutiao'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
        }

        RC_DB::table('merchant_news')
            ->where('store_id', $_SESSION['store_id'])
            ->where('id', $id)
            ->orWhere('group_id', $id)
            ->update(array('status' => 1, 'send_time' => RC_Time::gmtime()));

        ecjia_merchant::admin_log($info['title'], 'send', 'news');
        return $this->showmessage(__('发送成功', 'toutiao'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('toutiao/merchant/init', array('type' => 'media'))));
    }

    private function get_toutiao_list()
    {
        $db = RC_DB::table('merchant_news')->where('store_id', $_SESSION['store_id'])->where('group_id', 0);

        $type = isset($_GET['type']) ? remove_xss($_GET['type']) : '';

        $type_count = $this->get_type_count();

        $start_time = RC_Time::local_mktime(0, 0, 0, RC_Time::local_date('m'), RC_Time::local_date('d'), RC_Time::local_date('Y'));
        $end_time   = RC_Time::local_mktime(0, 0, 0, RC_Time::local_date('m'), RC_Time::local_date('d') + 1, RC_Time::local_date('Y')) - 1;

        if (empty($type)) {
            $db->where('send_time', '>', $start_time)->where('send_time', '<', $end_time)->where('status', 1);
        } elseif ($type == 'history') {
            $db->where('send_time', '<', $start_time)->where('status', 1);
        } elseif ($type == 'media') {
            $db->where('status', 0);
        }

        $count = $db->count();
        $size  = 10;
        $page  = new ecjia_merchant_page($count, $size, 5);

        $result = $db->select('*')->take($size)->skip($page->start_id - 1)->orderBy('id', 'desc')->get();

        if (!empty($result)) {
            foreach ($result as $k => $v) {
                $result[$k]['image']    = !empty($v['image']) ? RC_Upload::upload_url($v['image']) : RC_Uri::admin_url('statics/images/nopic.png');
                $result[$k]['children'] = RC_DB::table('merchant_news')
                    ->where('store_id', $_SESSION['store_id'])
                    ->where('group_id', $v['id'])
                    ->orderBy('sort', 'asc')
                    ->orderBy('id', 'asc')
                    ->get();
            }
        }

        return array('item' => $result, 'page' => $page->show(2), 'desc' => $page->page_desc(), 'count' => $type_count);
    }

    private function get_type_count()
    {
        $db = RC_DB::table('merchant_news')->where('store_id', $_SESSION['store_id'])->where('group_id', 0);

        $start_time = RC_Time::local_mktime(0, 0, 0, RC_Time::local_date('m'), RC_Time::local_date('d'), RC_Time::local_date('Y'));
        $end_time   = RC_Time::local_mktime(0, 0, 0, RC_Time::local_date('m'), RC_Time::local_date('d') + 1, RC_Time::local_date('Y')) - 1;

        $type_count = $db->select(
            RC_DB::raw('SUM(IF(send_time >' . $start_time . ' and send_time < ' . $end_time . ' and status = 1, 1, 0)) as send'),
            RC_DB::raw('SUM(IF(send_time < ' . $start_time . ' and status = 1, 1, 0)) as history'),
            RC_DB::raw('SUM(IF(status = 0, 1, 0)) as media'))->first();

        $type_count['send']    = !empty($type_count['send']) ? intval($type_count['send']) : 0;
        $type_count['history'] = !empty($type_count['history']) ? intval($type_count['history']) : 0;
        $type_count['media']   = !empty($type_count['media']) ? intval($type_count['media']) : 0;

        return $type_count;
    }
}

//end
