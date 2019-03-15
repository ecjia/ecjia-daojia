<?php
/**
 * ECJIA 友情链接管理
 */
defined('IN_ECJIA') or exit('No permission resources.');

class admin extends ecjia_admin
{
    public function __construct()
    {
        parent::__construct();

        RC_Script::enqueue_script('jquery-validate');
        RC_Script::enqueue_script('jquery-form');
        RC_Script::enqueue_script('bootstrap-placeholder');
        RC_Script::enqueue_script('smoke');
        RC_Script::enqueue_script('bootstrap-editable.min', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js'), array(), false, false);
        RC_Style::enqueue_style('bootstrap-editable', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'), array(), false, false);
        RC_Script::enqueue_script('jquery-uniform');
        RC_Style::enqueue_style('uniform-aristo');
        RC_Script::enqueue_script('jquery-chosen');
        RC_Script::enqueue_script('friendlink', RC_App::apps_url('statics/js/friendlink.js', __FILE__), array(), false, 1);

        RC_Script::localize_script('friendlink', 'js_lang', config('app-friendlink::jslang.friendlink_page'));

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here( __('链接列表', 'friendlink'), RC_Uri::url('friendlink/admin/init')));
    }

    /**
     * 友情链接列表页面
     */
    public function init()
    {
        $this->admin_priv('friendlink_manage');

        ecjia_screen::get_current_screen()->remove_last_nav_here();
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here( __('链接列表', 'friendlink')));
        
        $this->assign('ur_here',  __('链接列表', 'friendlink'));
        $this->assign('action_link', array('text' =>  __('添加链接', 'friendlink'), 'href' => RC_Uri::url('friendlink/admin/add')));

        $links_list = $this->get_friendlink_list($_GET);
        $this->assign('list', $links_list);
        $this->assign('form_action', RC_Uri::url('friendlink/admin/batch'));
        $this->assign('search_action', RC_Uri::url('friendlink/admin/init'));

        $this->display('link_list.dwt');
    }

    /**
     * 添加新链接页面
     */
    public function add()
    {
        $this->admin_priv('friendlink_update');
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here( __('添加链接', 'friendlink')));
        
        $this->assign('ur_here',  __('添加链接', 'friendlink'));
        $this->assign('action_link', array('href' => RC_Uri::url('friendlink/admin/init'), 'text' =>  __('链接列表', 'friendlink')));
        $this->assign('form_action', RC_Uri::url('friendlink/admin/insert'));

        $this->display('link_edit.dwt');
    }

    /**
     * 处理添加的链接
     */
    public function insert()
    {
        $this->admin_priv('friendlink_update', ecjia::MSGTYPE_JSON);

        $show_order = !empty($_POST['show_order']) ? intval($_POST['show_order']) : 0;
        $link_name = !empty($_POST['link_name']) ? RC_String::sub_str(trim($_POST['link_name']), 250, false) : '';
        $link_url = !empty($_POST['link_url']) ? trim($_POST['link_url']) : '';

        if (empty($link_name)) {
            return $this->showmessage( __('友情链接名称不能为空', 'friendlink'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        /* 处理url */
        if (!empty($link_url)) {
            if (strpos($link_url, 'http://') === false && strpos($link_url, 'https://') === false) {
                $link_url = 'http://' . $link_url;
            } else {
                $link_url = trim($link_url);
            }
        }
	
        /* 查看名称是否有重复 */
        $query = RC_DB::table('friend_link')->where('link_name', $link_name)->count();
        if ($query != 0) {
            return $this->showmessage( __('此链接名称已经存在', 'friendlink'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        if ((isset($_FILES['link_img']['error']) && $_FILES['link_img']['error'] == 0) || (!isset($_FILES['link_img']['error']) && isset($_FILES['link_img']['tmp_name']) && $_FILES['link_img']['tmp_name'] != 'none')) {
            $upload = RC_Upload::uploader('image', array('save_path' => 'data/friendlink', 'auto_sub_dirs' => false));
            $image_info = $upload->upload($_FILES['link_img']);
            if (!empty($image_info)) {
                $link_logo = $upload->get_position($image_info);
            } else {
                return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
        } else {
            $link_logo = '';
        }

        $data = array(
            'link_name' => $link_name,
            'link_url' => $link_url,
            'link_logo' => $link_logo,
            'show_order' => $show_order,
        );
        $id = RC_DB::table('friend_link')->insertGetId($data);
        ecjia_admin::admin_log($link_name, 'add', 'friendlink');

        $links[] = array('text' =>  __('继续添加链接', 'friendlink'), 'href' => RC_Uri::url('friendlink/admin/add'));
        return $this->showmessage( __('添加成功', 'friendlink'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links, 'pjaxurl' => RC_Uri::url('friendlink/admin/edit', array('id' => $id))));
    }

    /**
     * 友情链接编辑页面
     */
    public function edit()
    {
        $this->admin_priv('friendlink_update');

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here( __('编辑链接名称', 'friendlink')));
        $this->assign('ur_here',  __('编辑链接名称', 'friendlink'));
        $this->assign('action_link', array('href' => RC_Uri::url('friendlink/admin/init'), 'text' =>  __('链接列表', 'friendlink')));

        $link_arr = RC_DB::table('friend_link')->where('link_id', intval($_GET['id']))->first();
        /* 标记为图片链接还是文字链接 */
        if (!empty($link_arr['link_logo'])) {
            if (strpos($link_arr['link_logo'], 'http://') === false) {
                $link_arr['type'] = 1;
                $link_arr['url'] = RC_Upload::upload_url($link_arr['link_logo']);
            } else {
                $link_arr['type'] = 0;
                $link_arr['url'] = $link_arr['link_logo'];
            }
        } else {
            $link_arr['type'] = 0;
        }
        if (!empty($link_arr['add_time'])) {
            $link_arr['add_time'] = RC_Time::local_date('Y-m-d H:i:s', $link_arr['add_time']);
        }
        $this->assign('link', $link_arr);
        $this->assign('form_action', RC_Uri::url('friendlink/admin/update'));

        $this->display('link_edit.dwt');
    }

    /**
     * 编辑链接的处理页面
     */
    public function update()
    {
        $this->admin_priv('friendlink_update', ecjia::MSGTYPE_JSON);

        $id = !empty($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
        $show_order = !empty($_POST['show_order']) ? intval($_POST['show_order']) : 0;
        $link_name = !empty($_POST['link_name']) ? trim($_POST['link_name']) : '';
        $link_url = !empty($_POST['link_url']) ? trim($_POST['link_url']) : '';

        $count = RC_DB::table('friend_link')->where('link_id', '!=', $id)->where('link_name', $link_name)->count();
        if ($count != 0) {
            return $this->showmessage( __('此链接名称已经存在', 'friendlink'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        /* 处理url */
        if (!empty($link_url)) {
        	if (strpos($link_url, 'http://') === false && strpos($link_url, 'https://') === false) {
                $link_url = 'http://' . $link_url;
            } else {
                $link_url = trim($link_url);
            }
        }

        $row = RC_DB::table('friend_link')->where('link_id', $id)->first();
        if ((isset($_FILES['link_img']['error']) && $_FILES['link_img']['error'] == 0) || (!isset($_FILES['link_img']['error']) && isset($_FILES['link_img']['tmp_name']) && $_FILES['link_img']['tmp_name'] != 'none')) {
            $upload = RC_Upload::uploader('image', array('save_path' => 'data/friendlink', 'auto_sub_dirs' => false));
            $image_info = $upload->upload($_FILES['link_img']);
            if (!empty($image_info)) {
                if (!empty($row['link_logo'])) {
                    $disk = RC_Filesystem::disk();
                    $disk->delete(RC_Upload::upload_path() . $row['link_logo']);
                }
                $link_logo = $upload->get_position($image_info);
            } else {
                return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
        } else {
            $link_logo = $row['link_logo'];
        }
        $data = array(
            'link_name' => $link_name,
            'link_url' => $link_url,
            'link_logo' => $link_logo,
            'show_order' => $show_order,
        );
        RC_DB::table('friend_link')->where('link_id', $id)->update($data);

        ecjia_admin::admin_log($link_name, 'edit', 'friendlink');
        return $this->showmessage( __('编辑成功', 'friendlink'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('friendlink/admin/edit', array('id' => $id))));
    }
    /**
     * 批量操作
     */
    public function batch()
    {
        $this->admin_priv('friendlink_delete', ecjia::MSGTYPE_JSON);

        $ids = !empty($_POST['checkboxes']) ? $_POST['checkboxes'] : 0;
        $type = !empty($_GET['type']) ? $_GET['type'] : '';
        $ids = !empty($ids) ? explode(',', $ids) : '';

        if (!empty($ids)) {
            if ($type == 'remove') {
                $info = RC_DB::table('friend_link')->whereIn('link_id', $ids)->select('link_name', 'link_logo')->get();
                RC_DB::table('friend_link')->whereIn('link_id', $ids)->delete();

                //删除logo
                $disk = RC_Filesystem::disk();
                foreach ($info as $v) {
                    if (!empty($v['link_logo'])) {
                        $disk->delete(RC_Upload::upload_path() . $v['link_logo']);
                    }
                    ecjia_admin::admin_log($v['link_name'], 'batch_remove', 'friendlink');
                }
                return $this->showmessage( __('删除成功', 'friendlink'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('friendlink/admin/init')));
            }
        } else {
            return $this->showmessage(__('您没有选择需要执行的操作！', 'friendlink'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }
    /**
     * 删除友情链接
     */
    public function remove()
    {
        $this->admin_priv('friendlink_delete', ecjia::MSGTYPE_JSON);

        $id = intval($_GET['id']);
        $row = RC_DB::table('friend_link')->where('link_id', $id)->first();

        if (!empty($row['link_logo'])) {
            if ((strpos($row['link_logo'], 'http://') === false) && (strpos($row['link_logo'], 'https://') === false)) {
                $disk = RC_Filesystem::disk();
                $disk->delete(RC_Upload::upload_path() . $row['link_logo']);
            }
        }
        RC_DB::table('friend_link')->where('link_id', $id)->delete();

        ecjia_admin::admin_log($row['link_name'], 'remove', 'friendlink');
        return $this->showmessage( __('删除成功', 'friendlink'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
    }

    /**
     * 删除链接logo
     */
    public function remove_logo()
    {
        $this->admin_priv('friendlink_delete', ecjia::MSGTYPE_JSON);

        $id = intval($_GET['id']);
        $link_logo = RC_DB::table('friend_link')->where('link_id', $id)->pluck('link_logo');
        if (!empty($link_logo)) {
            if ((strpos($link_logo, 'http://') === false) && (strpos($link_logo, 'https://') === false)) {
                $disk = RC_Filesystem::disk();
                $disk->delete(RC_Upload::upload_path() . $link_logo);
            }
            $data = array(
                'link_logo' => '',
            );
            RC_DB::table('friend_link')->where('link_id', $id)->update($data);

            return $this->showmessage( __('删除成功', 'friendlink'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('href' => RC_Uri::url('friendlink/admin/edit', array('id' => $id))));
        } else {
            return $this->showmessage( __('删除失败', 'friendlink'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    /**
     * 编辑链接名称
     */
    public function edit_link_name()
    {
        $this->admin_priv('friendlink_update', ecjia::MSGTYPE_JSON);

        $id = intval($_POST['pk']);
        $link_name = trim($_POST['value']);

        if (empty($link_name)) {
            return $this->showmessage( __('友情链接名称不能为空', 'friendlink'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        } else {
            /* 检查链接名称是否重复 */
            $count = RC_DB::table('friend_link')->where('link_id', '!=', $id)->where('link_name', $link_name)->count();
            if ($count != 0) {
                return $this->showmessage( __('此链接名称已经存在', 'friendlink'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            } else {
                $data = array(
                    'link_name' => $link_name,
                );
                RC_DB::table('friend_link')->where('link_id', $id)->update($data);

                ecjia_admin::admin_log($link_name, 'edit', 'friendlink');
                return $this->showmessage( __('编辑成功', 'friendlink'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
            }
        }
    }

    /**
     * 编辑排序
     */
    public function edit_show_order()
    {
        $this->admin_priv('friendlink_update');

        $id = intval($_POST['pk']);
        $order = intval($_POST['value']);

        /* 检查输入的值是否合法 */
        if (empty($order)) {
            return $this->showmessage( __('排序不能为空', 'friendlink'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        } elseif (!preg_match("/^[0-9]+$/", $order)) {
            return $this->showmessage( __('显示顺序的类型必须为数字', 'friendlink'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        } else {
            $data = array(
                'show_order' => $order,
            );
            RC_DB::table('friend_link')->where('link_id', $id)->update($data);
            return $this->showmessage( __('编辑成功', 'friendlink'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('friendlink/admin/init')));
        }
    }

    /**
     * 获取友情链接列表
     */
    private function get_friendlink_list($args = array())
    {
        $db_friendlink = RC_DB::table('friend_link');
        $filter['keywords'] = empty($_GET['keywords']) ? '' : trim($_GET['keywords']);

        if (!empty($filter['keywords'])) {
            $db_friendlink->where('link_name', 'like', '%' . mysql_like_quote($filter['keywords']) . '%');
        }

        $count = $db_friendlink->count();
        $page = new ecjia_page($count, 10, 5);
        $data = $db_friendlink->orderBy('show_order', 'asc')->orderBy('link_id', 'desc')->take(10)->skip($page->start_id - 1)->get();

        $list = array();
        if (!empty($data)) {
            foreach ($data as $rows) {
                if (empty($rows['link_logo'])) {
                    $no_picture = RC_Uri::admin_url('statics/images/nopic.png');
                    $rows['link_logo_html'] = "<img src='" . $no_picture . "' style='width:120px;height:70px;' />";
                } else {
                    $logo_url = RC_Upload::upload_url($rows['link_logo']);
                    $rows['link_logo_html'] = "<img src='" . $logo_url . "' style='width:120px;height:70px;' />";
                }
                if (!empty($rows['add_time'])) {
                    $rows['add_time'] = RC_Time::local_date(ecjia::config('date_format'), $rows['add_time']);
                }
                $list[] = $rows;
            }
        }
        return array('list' => $list, 'filter' => $filter, 'page' => $page->show(5), 'desc' => $page->page_desc());
    }
}

// end
