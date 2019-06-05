<?php
/**
 * ECJIA 专题管理程序
 * @author songqian
 */
defined('IN_ECJIA') or exit('No permission resources.');

class admin extends ecjia_admin
{
    public function __construct()
    {
        parent::__construct();

        Ecjia\App\Topic\Helper::assign_adminlog_content();

        RC_Loader::load_app_func('common', 'goods');
        RC_Loader::load_app_func('category', 'goods');

        /* 加载全局 js/css */
        RC_Script::enqueue_script('jquery-validate');
        RC_Script::enqueue_script('jquery-form');
        RC_Script::enqueue_script('smoke');
        RC_Script::enqueue_script('bootstrap-editable.min', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js'), array(), false, false);
        RC_Style::enqueue_style('bootstrap-editable', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'), array(), false, false);
        // RC_Script::enqueue_script('media-editor', RC_Uri::vendor_url('tinymce/tinymce.min.js'), array(), false, true);
        RC_Style::enqueue_style('chosen');
        RC_Style::enqueue_style('uniform-aristo');
        RC_Style::enqueue_style('datepicker', RC_Uri::admin_url('statics/lib/datepicker/datepicker.css'));
        RC_Style::enqueue_style('colorpicker', RC_Uri::admin_url('statics/lib/colorpicker/css/colorpicker.css'));
        RC_Script::enqueue_script('jquery-uniform');
        RC_Script::enqueue_script('jquery-chosen');
        RC_Script::enqueue_script('topic', RC_App::apps_url('statics/js/topic.js', __FILE__), array(), false, true);
        RC_Script::enqueue_script('bootstrap-datepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datepicker.min.js'));
        RC_Script::enqueue_script('bootstrap-colorpicker', RC_Uri::admin_url('statics/lib/colorpicker/bootstrap-colorpicker.js'));
        RC_Script::enqueue_script('bootstrap-placeholder', RC_Uri::admin_url('statics/lib/dropper-upload/bootstrap-placeholder.js'), array(), false, true);
;
        RC_Script::localize_script('topic', 'js_lang', config('app-topic::jslang.topic_page'));

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('专题列表', 'topic'), RC_Uri::url('topic/admin/init')));
    }

    /**
     * 专题列表页面
     */
    public function init()
    {
        $this->admin_priv('topic_manage', ecjia::MSGTYPE_JSON);

        ecjia_screen::get_current_screen()->remove_last_nav_here();
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('专题列表', 'topic')));
        $this->assign('ur_here', __('专题列表', 'topic'));
        $this->assign('action_link', array('text' => __('添加专题', 'topic'), 'href' => RC_Uri::url('topic/admin/add')));

        $topic_list = $this->get_topic_list();
        $this->assign('topic_list', $topic_list);
        $this->assign('search_action', RC_Uri::url('topic/admin/init'));

        return $this->display('topic_list.dwt');
    }

    /**
     * 添加页面
     */
    public function add()
    {
        $this->admin_priv('topic_update', ecjia::MSGTYPE_JSON);

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('添加专题', 'topic')));
        $this->assign('ur_here', __('添加专题', 'topic'));
        $this->assign('action_link', array('href' => RC_Uri::url('topic/admin/init'), 'text' => __('专题列表', 'topic')));
        $this->assign('action', 'insert');

        $topic = array(
            'title'      => '',
            'topic_type' => 0,
            'url'        => 'http://',
        );
        $this->assign('topic', $topic);
        $this->assign('form_action', RC_Uri::url('topic/admin/insert'));

        return $this->display('topic_edit.dwt');
    }

    /**
     * 添加处理
     */
    public function insert()
    {
        $this->admin_priv('topic_update', ecjia::MSGTYPE_JSON);

        $topic_type     = empty($_POST['topic_type']) ? 0 : intval($_POST['topic_type']);
        $topic_img_type = empty($_POST['topic_img_type']) ? 0 : intval($_POST['topic_img_type']);
        $topic_pic_type = empty($_POST['title_pic_type']) ? 0 : intval($_POST['title_pic_type']);

        /* 图片*/
        if ($topic_type == 0) {
            //本地上传
            if ($topic_img_type == 1) {
                if ((isset($_FILES['topic_img']['error']) && $_FILES['topic_img']['error'] == 0) || (!isset($_FILES['topic_img']['error']) && isset($_FILES['topic_img']['tmp_name']) && $_FILES['topic_img']['tmp_name'] != 'none')) {
                    $upload     = RC_Upload::uploader('image', array('save_path' => 'data/topicimg', 'auto_sub_dirs' => false));
                    $image_info = $upload->upload($_FILES['topic_img']);
                    if (!empty($image_info)) {
                        $all_img = $upload->get_position($image_info);
                    } else {
                        return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                    }
                } else {
                    $all_img = '';
                }
                //远程链接
            } else {
                if (!empty($_POST['url_logo'])) {
                    if (strpos($_POST['url_logo'], 'http://') === false && strpos($_POST['url_logo'], 'https://') === false) {
                        $all_img = 'http://' . trim($_POST['url_logo']);
                    } else {
                        $all_img = trim($_POST['url_logo']);
                    }
                } else {
                    $all_img = 'http://' . trim($_POST['url_logo']);
                }
            }
            $htmls = '';
        }
        /* Flash */
        elseif ($topic_type == 1) {
            if ((isset($_FILES['upfile_flash']['error']) && $_FILES['upfile_flash']['error'] == 0) || (!isset($_FILES['upfile_flash']['error']) && isset($_FILES['upfile_flash']['tmp_name']) && $_FILES['upfile_flash']['tmp_name'] != 'none')) {
                $upload = RC_Upload::uploader('file', array('save_path' => 'data/topicimg', 'auto_sub_dirs' => false));
                $upload->allowed_type('swf,fla');
                $upload->allowed_mime('application/octet-stream,application/x-shockwave-flash');

                if (!$upload->check_upload_file($_FILES['upfile_flash'])) {
                    return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                }
                $image_info = $upload->upload($_FILES['upfile_flash']);
                if (!empty($image_info)) {
                    $all_img = $upload->get_position($image_info);
                } else {
                    return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                }
            } else {
                $all_img = '';
            }
            $htmls = '';
            /* 代码 */
        } else {
            if (empty($_POST['htmls'])) {
                return $this->showmessage(__('代码内容不能为空', 'topic'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            $all_img = '';
            $htmls   = !empty($_POST['htmls']) ? $_POST['htmls'] : '';
        }

        if ($topic_pic_type == 1) {
            if ((isset($_FILES['title_pic']['error']) && $_FILES['title_pic']['error'] == 0) || (!isset($_FILES['title_pic']['error']) && isset($_FILES['title_pic']['tmp_name']) && $_FILES['title_pic']['tmp_name'] != 'none')) {
                $upload     = RC_Upload::uploader('image', array('save_path' => 'data/topicimg', 'auto_sub_dirs' => false));
                $image_info = $upload->upload($_FILES['title_pic']);
                if (!empty($image_info)) {
                    $title_pic = $upload->get_position($image_info);
                } else {
                    return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                }
            } else {
                $title_pic = '';
            }
        } else {
            /* 使用远程的LOGO图片 */
            if (!empty($_POST['url_logo2'])) {
                if (strpos($_POST['url_logo2'], 'http://') === false && strpos($_POST['url_logo2'], 'https://') === false) {
                    $title_pic = 'http://' . trim($_POST['url_logo2']);
                } else {
                    $title_pic = trim($_POST['url_logo2']);
                }
            } else {
                $title_pic = 'http://' . trim($_POST['url_logo2']);
            }
        }

        //其他字段
        $base_style  = !empty($_POST['base_style']) ? substr($_POST['base_style'], 1) : '';
        $keywords    = !empty($_POST['keywords']) ? trim($_POST['keywords']) : '';
        $description = !empty($_POST['description']) ? trim($_POST['description']) : '';
        $start_time  = !empty($_POST['start_time']) ? RC_Time::local_strtotime($_POST['start_time']) : '';
        $end_time    = !empty($_POST['end_time']) ? RC_Time::local_strtotime($_POST['end_time']) : '';
        $topic_name  = !empty($_POST['topic_name']) ? trim($_POST['topic_name']) : '';
        $intro       = !empty($_POST['intro']) ? $_POST['intro'] : '';
        $template    = !empty($_POST['template']) ? $_POST['template'] : '';
        $topic_css   = !empty($_POST['topic_css']) ? $_POST['topic_css'] : '';

        if ($start_time >= $end_time) {
            return $this->showmessage(__('专题开始时间不能大于或等于结束时间', 'topic'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        if (empty($_POST['topic_data'])) {
            $tmp_data = array('default' => array());
            $tmp_data = serialize((object) ($tmp_data));
        }

        $data = array(
            'title'       => $topic_name,
            'start_time'  => $start_time,
            'end_time'    => $end_time,
            'topic_img'   => $all_img, //专题图片
            'title_pic'   => $title_pic, //商品分类标题图片
            'base_style'  => $base_style,
            'htmls'       => $htmls,
            'keywords'    => $keywords,
            'description' => $description,
            'data'        => $tmp_data, //专题商品
            'intro'       => $_POST['intro'], //专题介绍
            'template'    => $template, //高级选项
            'css'         => $topic_css,
        );
        $topicid = RC_DB::table('topic')->insertGetId($data);

        ecjia_admin::admin_log($topic_name, 'add', 'topic');
        $links[] = array('text' => __('返回专题列表', 'topic'), 'href' => RC_Uri::url('topic/admin/init'));
        $links[] = array('text' => __('继续添加专题', 'topic'), 'href' => RC_Uri::url('topic/admin/add'));
        return $this->showmessage(__('添加专题成功', 'topic'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links, 'pjaxurl' => RC_Uri::url('topic/admin/edit', array('id' => $topicid))));
    }

    /**
     * 编辑页面
     */
    public function edit()
    {
        $this->admin_priv('topic_update', ecjia::MSGTYPE_JSON);

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('编辑专题', 'topic')));
        $this->assign('ur_here', __('编辑专题', 'topic'));
        $this->assign('action_link', array('href' => RC_Uri::url('topic/admin/init'), 'text' => __('专题列表', 'topic')));

        $topic = RC_DB::table('topic')->where('topic_id', intval($_GET['id']))->first();

        $topic['start_time'] = RC_Time::local_date('Y-m-d', $topic['start_time']);
        $topic['end_time']   = RC_Time::local_date('Y-m-d', $topic['end_time']);
        if ($topic['base_style'] != "") {
            $topic['base_style'] = "#" . $topic['base_style'];
        }

        if (!empty($topic['intro'])) {
            $topic['intro'] = stripslashes($topic['intro']);
        }

        if (empty($topic['topic_img']) && empty($topic['htmls'])) {
            $topic['topic_type'] = 0;
        } elseif ($topic['htmls'] != '') {
            $topic['topic_type'] = 2;
        } elseif (preg_match('/.fla$/i', $topic['topic_img']) || preg_match('/.swf$/i', $topic['topic_img'])) {
            $topic['topic_type'] = 1;
        } else {
            $topic['topic_type'] = '';
        }

        /* 标记为图片链接还是文字链接 (专题图片)*/
        if (!empty($topic['topic_img'])) {
            if (strpos($topic['topic_img'], 'http://') === false) {
                $topic['type'] = 1;
                $topic['url']  = RC_Upload::upload_url($topic['topic_img']);
            } else {
                $topic['type'] = 0;
                $topic['url']  = $topic['topic_img'];
            }
        } else {
            $topic['type'] = 0;
        }

        /* 标记为图片链接还是文字链接 (logo图片)*/
        if (!empty($topic['title_pic'])) {
            if (strpos($topic['title_pic'], 'http://') === false) {
                $topic['type2'] = 1;
                $topic['url2']  = RC_Upload::upload_url($topic['title_pic']);
            } else {
                $topic['type2'] = 0;
                $topic['url2']  = $topic['title_pic'];
            }
        } else {
            $topic['type2'] = 0;
        }

        $this->assign('topic', $topic);
        $this->assign('form_action', RC_Uri::url('topic/admin/update'));

        return $this->display('topic_edit.dwt');
    }

    /**
     * 编辑处理
     */
    public function update()
    {
        $this->admin_priv('topic_update', ecjia::MSGTYPE_JSON);

        $topic_id       = empty($_POST['topic_id']) ? 0 : intval($_POST['topic_id']);
        $topic_type     = empty($_POST['topic_type']) ? 0 : intval($_POST['topic_type']);
        $topic_img_type = empty($_POST['topic_img_type']) ? 0 : intval($_POST['topic_img_type']);
        $topic_pic_type = empty($_POST['title_pic_type']) ? 0 : intval($_POST['title_pic_type']);
        /* 获取旧的图片地址,并删除 */
        $ad_logo = RC_DB::table('topic')->where('topic_id', $topic_id)->pluck('topic_img');

        $upload = RC_Upload::uploader('image', array('save_path' => 'data/topicimg', 'auto_sub_dirs' => false));

        if ($topic_type == 0) {
            if ($topic_img_type == 1) {
                if ((isset($_FILES['topic_img']['error']) && $_FILES['topic_img']['error'] == 0) || (!isset($_FILES['topic_img']['error']) && isset($_FILES['topic_img']['tmp_name']) && $_FILES['topic_img']['tmp_name'] != 'none')) {
                    $image_info = $upload->upload($_FILES['topic_img']);
                    /* 如果要修改链接图片, 删除原来的图片 */
                    if (!empty($image_info)) {
                        if ((strpos($ad_logo, 'http://') === false) && (strpos($ad_logo, 'https://') === false)) {
                            $upload->remove($ad_logo);
                        }
                        /* 获取新上传的LOGO的链接地址 */
                        $all_img = $upload->get_position($image_info);

                    } else {
                        return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                    }
                } else {
                    $all_img = $ad_logo;
                }
            } else {
                if ((strpos($ad_logo, 'http://') === false) && (strpos($ad_logo, 'https://') === false)) {
                    $upload->remove($ad_logo);
                }

                if (strpos($_POST['url_logo'], 'http://') === false && strpos($_POST['url_logo'], 'https://') === false) {
                    $all_img = 'http://' . $_POST['url_logo'];
                } else {
                    $all_img = trim($_POST['url_logo']);
                }
            }
            $htmls = '';
        }
        /* 如果是编辑Flash */
        elseif ($topic_type == 1) {
            if ((isset($_FILES['upfile_flash']['error']) && $_FILES['upfile_flash']['error'] == 0) || (!isset($_FILES['upfile_flash']['error']) && isset($_FILES['upfile_flash']['tmp_name']) && $_FILES['upfile_flash']['tmp_name'] != 'none')) {
                $upload = RC_Upload::uploader('file', array('save_path' => 'data/topicimg', 'auto_sub_dirs' => false));
                $upload->allowed_type('swf,fla');
                $upload->allowed_mime('application/octet-stream,application/x-shockwave-flash');

                if (!$upload->check_upload_file($_FILES['upfile_flash'])) {
                    return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                }

                $image_info = $upload->upload($_FILES['upfile_flash']);

                if (!empty($image_info)) {
                    if ((strpos($ad_logo, 'http://') === false) && (strpos($ad_logo, 'https://') === false)) {
                        $upload->remove($ad_logo);
                    }
                    $all_img = $upload->get_position($image_info);
                } else {
                    return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                }
            } else {
                $all_img = $ad_logo;
            }
            $htmls = '';
        }
        /* 编辑代码类型 */
        elseif ($topic_type == 2) {
            if (empty($_POST['htmls'])) {
                return $this->showmessage(__('代码内容不能为空', 'topic'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            if ((strpos($ad_logo, 'http://') === false) && (strpos($ad_logo, 'https://') === false)) {
                $upload->remove($ad_logo);
            }
            $all_img = '';
            $htmls   = !empty($_POST['htmls']) ? $_POST['htmls'] : '';
        }

        /* 获取旧的LOGO地址,并删除 */
        $old_title_pic = RC_DB::table('topic')->where('topic_id', $topic_id)->pluck('title_pic');

        if ($topic_pic_type == 1) {
            if ((isset($_FILES['title_pic']['error']) && $_FILES['title_pic']['error'] == 0) ||
                (!isset($_FILES['title_pic']['error']) && isset($_FILES['title_pic']['tmp_name']) && $_FILES['title_pic']['tmp_name'] != 'none')) {
                $upload     = RC_Upload::uploader('image', array('save_path' => 'data/topicimg', 'auto_sub_dirs' => false));
                $image_info = $upload->upload($_FILES['title_pic']);
                /* 如果要修改链接图片, 删除原来的图片 */
                if (!empty($image_info)) {
                    if ((strpos($old_title_pic, 'http://') === false) && (strpos($old_title_pic, 'https://') === false)) {
                        $upload->remove($old_title_pic);
                    }
                    /* 获取新上传的LOGO的链接地址 */
                    $title_pic = $upload->get_position($image_info);
                } else {
                    return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                }
            } else {
                $title_pic = $old_title_pic;
            }
        } else {
            if ((strpos($old_title_pic, 'http://') === false) && (strpos($old_title_pic, 'https://') === false)) {
                $upload->remove($old_title_pic);
            }
            if (strpos($_POST['url_logo2'], 'http://') === false && strpos($_POST['url_logo2'], 'https://') === false) {
                $title_pic = 'http://' . $_POST['url_logo2'];
            } else {
                $title_pic = trim($_POST['url_logo2']);
            }
        }

        //其他字段
        $base_style  = !empty($_POST['base_style']) ? substr($_POST['base_style'], 1) : '';
        $keywords    = !empty($_POST['keywords']) ? trim($_POST['keywords']) : '';
        $description = !empty($_POST['description']) ? trim($_POST['description']) : '';
        $start_time  = !empty($_POST['start_time']) ? RC_Time::local_strtotime($_POST['start_time']) : '';
        $end_time    = !empty($_POST['end_time']) ? RC_Time::local_strtotime($_POST['end_time']) : '';
        $topic_name  = !empty($_POST['topic_name']) ? trim($_POST['topic_name']) : '';
        $intro       = !empty($_POST['intro']) ? $_POST['intro'] : '';
        $template    = !empty($_POST['template']) ? $_POST['template'] : '';
        $topic_css   = !empty($_POST['topic_css']) ? $_POST['topic_css'] : '';

        if ($start_time >= $end_time) {
            return $this->showmessage(__('专题开始时间不能大于或等于结束时间', 'topic'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $data = array(
            'title'       => $topic_name,
            'start_time'  => $start_time,
            'end_time'    => $end_time,
            'topic_img'   => $all_img, //专题图片
            'title_pic'   => $title_pic, //商品分类标题图片
            'base_style'  => $base_style,
            'htmls'       => $htmls,
            'keywords'    => $keywords,
            'description' => $description,
            'intro'       => $intro, //专题介绍
            'template'    => $template, //高级选项
            'css'         => $topic_css,
        );
        RC_DB::table('topic')->where('topic_id', $topic_id)->update($data);

        ecjia_admin::admin_log($topic_name, 'edit', 'topic');

        return $this->showmessage(__('编辑专题成功', 'topic'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('topic/admin/edit', array('id' => $topic_id))));
    }

    public function title_picdel()
    {
        $this->admin_priv('topic_delete', ecjia::MSGTYPE_JSON);

        $id      = intval($_GET['id']);
        $old_url = RC_DB::table('topic')->where('topic_id', $id)->pluck('title_pic');

        $disk = RC_Filesystem::disk();
        $disk->delete(RC_Upload::upload_path() . $old_url);

        $data = array('title_pic' => '');
        RC_DB::table('topic')->where('topic_id', $id)->update($data);

        return $this->showmessage(__('删除商品分类标题图片成功', 'topic'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('topic/admin/edit', array('id' => $id))));
    }

    public function delflash()
    {
        $this->admin_priv('topic_delete', ecjia::MSGTYPE_JSON);

        $id      = intval($_GET['id']);
        $old_url = RC_DB::table('topic')->where('topic_id', $id)->pluck('topic_img');

        $disk = RC_Filesystem::disk();
        $disk->delete(RC_Upload::upload_path() . $old_url);

        $data = array('topic_img' => '');
        RC_DB::table('topic')->where('topic_id', $id)->update($data);

        return $this->showmessage(__('删除Flash文件成功', 'topic'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('topic/admin/edit', array('id' => $id))));

    }

    public function delfile()
    {
        $this->admin_priv('topic_delete', ecjia::MSGTYPE_JSON);

        $id      = intval($_GET['id']);
        $old_url = RC_DB::table('topic')->where('topic_id', $id)->pluck('topic_img');

        $disk = RC_Filesystem::disk();
        $disk->delete(RC_Upload::upload_path() . $old_url);

        $data = array('topic_img' => '');
        RC_DB::table('topic')->where('topic_id', $id)->update($data);

        return $this->showmessage(__('删除专题图片成功', 'topic'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('topic/admin/edit', array('id' => $id))));
    }

    /**
     * 编辑专题名称
     */
    public function edit_title()
    {
        $this->admin_priv('topic_update', ecjia::MSGTYPE_JSON);

        $id    = intval($_POST['pk']);
        $title = trim($_POST['value']);

        $data = array('title' => $title);
        RC_DB::table('topic')->where('topic_id', $id)->update($data);

        ecjia_admin::admin_log($title, 'edit', 'topic');

        return $this->showmessage(__('编辑专题名称成功', 'topic'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
    }

    /**
     * 批量操作
     */
    public function batch()
    {
        $this->admin_priv('topic_delete', ecjia::MSGTYPE_JSON);

        $topic_id   = $_POST['topic_id'];
        $topic_id   = explode(',', $topic_id);
        $title_list = RC_DB::table('topic')->whereIn('topic_id', $topic_id)->lists('title');

        if (!empty($topic_id)) {
            RC_DB::table('topic')->whereIn('topic_id', $topic_id)->delete();

            foreach ($title_list as $v) {
                ecjia_admin::admin_log($v, 'batch_remove', 'topic');
            }
            return $this->showmessage(__('批量删除专题操作成功', 'topic'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('topic/admin/init')));
        }
    }

    /**
     * 专题预览页面
     */
    public function preview()
    {
        $this->admin_priv('topic_manage', ecjia::MSGTYPE_JSON);

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('专题预览', 'topic')));
        $id = intval($_GET['id']);
        $this->assign('ur_here', __('专题预览', 'topic'));
        $this->assign('action_linkedit', array('text' => __('编辑专题', 'topic'), 'href' => RC_Uri::url('topic/admin/edit', array('id' => $id))));
        $this->assign('action_link', array('text' => __('专题列表', 'topic'), 'href' => RC_Uri::url('topic/admin/init')));

        $topic = RC_DB::table('topic')->where('topic_id', $id)->first();
        if (!file_exists(RC_Upload::upload_path($topic['topic_img'])) || empty($topic['topic_img'])) {
            $topic['topic_img'] = RC_Uri::admin_url('statics/images/nopic.png');
        } else {
            $topic['topic_img'] = RC_Upload::upload_url($topic['topic_img']);
        }

        $topic['now'] = RC_Time::gmtime();
        $this->assign('topic', $topic);

        $topic['topic_cat_name'] = unserialize($topic['data']);
        if (is_object($topic['topic_cat_name'])) {
            $topic['topic_cat_name'] = (array) $topic['topic_cat_name'];
        }
        $topic_cats = array();
        foreach ($topic['topic_cat_name'] as $k => $v) {
            foreach ($v as $vv) {
                $tmp        = explode('|', $vv);
                $goods_id   = $tmp[1];
                $goods_info = RC_DB::table('goods')->where('goods_id', $goods_id)->select('goods_thumb', 'shop_price')->first();

                if (!file_exists(RC_Upload::upload_path($goods_info['goods_thumb'])) || empty($goods_info['goods_thumb'])) {
                    $goods_info['goods_thumb'] = RC_Uri::admin_url('statics/images/nopic.png');
                    $goods_info['goods_img']   = RC_Uri::admin_url('statics/images/nopic.png');
                } else {
                    $goods_info['goods_thumb'] = RC_Upload::upload_url($goods_info['goods_thumb']);
                    $goods_info['goods_img']   = RC_Upload::upload_url($goods_info['goods_img']);
                }
                $topic_cats[$k][$tmp[1]] = array(
                    'name'        => $tmp[0],
                    'goods_thumb' => $goods_info['goods_thumb'],
                    'price'       => !empty($goods_info['shop_price']) ? $goods_info['shop_price'] : 0,
                );
            }
        }
        $cat_name = $topic['topic_cat_name'];
        $this->assign('topic_cat', $cat_name);
        $this->assign('topic_cats', $topic_cats);

        return $this->display('preview.dwt');
    }

    /**
     * 删除专题
     */
    public function remove()
    {
        $this->admin_priv('topic_delete', ecjia::MSGTYPE_JSON);

        $id = intval($_GET['id']);

        $topic = RC_DB::table('topic')->where('topic_id', $id)->select('topic_img', 'title_pic', 'title')->first();

        $disk = RC_Filesystem::disk();
        $disk->delete(RC_Upload::upload_path() . $topic['topic_img']);
        $disk->delete(RC_Upload::upload_path() . $topic['title_pic']);

        RC_DB::table('topic')->where('topic_id', $id)->delete();

        ecjia_admin::admin_log(addslashes($topic['title']), 'remove', 'topic');

        return $this->showmessage(__('删除专题操作成功', 'topic'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
    }

    /**
     * 添加专题分类页面
     */
    public function topic_cat()
    {
        $this->admin_priv('topic_update', ecjia::MSGTYPE_JSON);

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('专题分类', 'topic')));
        $this->assign('action_link', array('href' => RC_Uri::url('topic/admin/init'), 'text' => __('专题列表', 'topic')));
        $this->assign('ur_here', __('专题分类', 'topic'));

        $topic_id = $_GET['id'];
        $topic    = RC_DB::table('topic')->where('topic_id', $topic_id)->first();

        $topic['topic_cat_name'] = unserialize(($topic['data']));
        if (is_object($topic['topic_cat_name'])) {
            $topic['topic_cat_name'] = (array) ($topic['topic_cat_name']);
        }

        foreach ($topic['topic_cat_name'] as $k => $v) {
            if ($k != 'default') {
                $this->assign('topic_cat', $topic['topic_cat_name']);
            }
        }

        $this->assign('topic_id', $topic_id);
        $this->assign('form_action', RC_Uri::url('topic/admin/insert_topic_cat', array('id' => $topic_id)));

        return $this->display('topic_cat.dwt');
    }

    /**
     * 添加专题分类处理
     */
    public function insert_topic_cat()
    {
        $this->admin_priv('topic_manage', ecjia::MSGTYPE_JSON);

        $topic_id = $_GET['id'];
        $topic    = RC_DB::table('topic')->where('topic_id', $topic_id)->first();

        $topic['topic_cat_name'] = unserialize($topic['data']);
        if (is_object($topic['topic_cat_name'])) {
            $topic['topic_cat_name'] = (array) $topic['topic_cat_name'];
        }

        //专题分类名称
        if (!empty($_POST['topic_cat_name'])) {
            $topic_cat_name = $_POST['topic_cat_name'];
        } else {
            return $this->showmessage(__('请输入专题分类名称', 'topic'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $one = array_keys($topic['topic_cat_name']);
        $key = $one[0];
        if ($key == 'default') {
            $catone = array();
            foreach ($topic['topic_cat_name'] as $val) {
                $catone[$topic_cat_name] = $val;
            }
            $topic_cat = serialize((object) $catone);
        } else {
            $topic['topic_cat_name'][$topic_cat_name] = array();
            $topic_cat                                = serialize((object) $topic['topic_cat_name']);
        }

        //其他字段
        $data = array('data' => $topic_cat);
        RC_DB::table('topic')->where('topic_id', $topic_id)->update($data);

        ecjia_admin::admin_log($topic_cat_name . '，' . __('专题名称为', 'topic'). $topic['title'], 'add', 'topic_cat');
        return $this->showmessage(__('添加专题成功', 'topic'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('topic/admin/topic_cat', array('id' => $topic_id))));
    }

    /**
     * 添加专题商品页面
     */
    public function topic_goods()
    {
        $this->admin_priv('topic_update', ecjia::MSGTYPE_JSON);

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('编辑专题商品', 'topic')));
        $this->assign('ur_here', __('编辑专题商品', 'topic'));
        $this->assign('action_link', array('href' => RC_Uri::url('topic/admin/init'), 'text' => __('专题列表', 'topic')));

        $topic_id = $_GET['id'];
        $topic    = RC_DB::table('topic')->where('topic_id', intval($_GET['id']))->first();

        $topic['topic_cat_name'] = unserialize($topic['data']);

        if (is_object($topic['topic_cat_name'])) {
            $topic['topic_cat_name'] = (array) $topic['topic_cat_name'];
        }

        $one = array_keys($topic['topic_cat_name']);
        $key = $one[0];

        $topic_cats = array();
        foreach ($topic['topic_cat_name'] as $k => $v) {
            foreach ($v as $vv) {
                $tmp                     = explode('|', $vv);
                $topic_cats[$k][$tmp[1]] = $tmp[0];
            }
        }

        $this->assign('topic_cat', $topic['topic_cat_name']);
        $this->assign('topic_cats', $topic_cats);

        $this->assign('cat_list', RC_Api::api('goods', 'get_goods_category'));
        $this->assign('brand_list', RC_Api::api('goods', 'get_goods_brand'));
        $this->assign('topic_id', $topic_id);
        $this->assign('keys', $key);

        $this->assign('form_action', RC_Uri::url('topic/admin/insert_topic_goods', array('id' => $topic_id)));
        $this->assign('select_action', RC_Uri::url('topic/admin/topic_goods'));

        return $this->display('topic_goods.dwt');
    }

    /**
     * 添加专题商品处理
     */
    public function insert_topic_goods()
    {
        $this->admin_priv('topic_manage', ecjia::MSGTYPE_JSON);

        $topic_id = $_GET['id'];
        $topic    = RC_DB::table('topic')->where('topic_id', intval($_GET['id']))->first();

        $topic['topic_cat_name'] = unserialize($topic['data']);

        if (is_object($topic['topic_cat_name'])) {
            $topic['topic_cat_name'] = (array) $topic['topic_cat_name'];
        }
        $topic_cat = array();
        foreach ($topic['topic_cat_name'] as $key => $val) {
            array_push($topic_cat, $key);
        }
        //商品
        $goods_info      = !empty($_POST['goods_id']) ? $_POST['goods_id'] : '';
        $data_goods_info = array();
        if (!empty($topic_cat)) {
            foreach ($topic_cat as $val) {
                $data_goods_info[$val] = array();
                if (!empty($goods_info)) {
                    foreach ($goods_info as $k => $v) {
                        $tmp = explode('_', $k);
                        if ($tmp[0] == $val) {
                            $data_goods_info[$tmp[0]][] = $v;
                        }
                    }
                }
            }
        }
        //转密
        $goods = serialize((object) $data_goods_info);
        $data  = array('data' => $goods);
        RC_DB::table('topic')->where('topic_id', $topic_id)->update($data);

        ecjia_admin::admin_log(__('专题名称为', 'topic'). $topic['title'], 'add', 'topic_goods');

        return $this->showmessage(__('成功修改专题商品', 'topic'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('topic/admin/topic_goods', array('id' => $topic_id))));
    }

    /**
     * 删除专题分类
     */
    public function remove_catname()
    {
        $this->admin_priv('topic_delete', ecjia::MSGTYPE_JSON);

        $key      = $_GET['key'];
        $topic_id = $_GET['id'];

        if (!preg_match('/^.*$/u', $key)) {
            $key = iconv('GB2312', 'UTF-8', $key);
        }

        $topic                   = RC_DB::table('topic')->where('topic_id', $topic_id)->first();
        $topic['topic_cat_name'] = unserialize($topic['data']);

        if (is_object($topic['topic_cat_name'])) {
            $topic['topic_cat_name'] = (array) $topic['topic_cat_name'];
        }

        $tmp_data = array();
        foreach ($topic['topic_cat_name'] as $k => $val) {
            if ($k == $key) {
                unset($topic['topic_cat_name'][$k]);
            } else {
                $tmp_data[$k] = $val;
            }
        }

        if (count($tmp_data) == 0) {
            $tmp_data = array('default' => array());
        }

        $goods = serialize((object) ($tmp_data));
        $data  = array('data' => $goods);
        RC_DB::table('topic')->where('topic_id', $topic_id)->update($data);

        ecjia_admin::admin_log($key . '，' . __('专题名称为', 'topic'). $topic['title'], 'remove', 'topic_cat');

        return $this->showmessage(__('删除专题分类成功', 'topic'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
    }

    /**
     * 搜索商品，仅返回名称及ID
     */
    public function get_goods_list()
    {
        $filter = $_GET['JSON'];
        $arr    = RC_Api::api('goods', 'get_goods_list', $filter);
        $opt    = array();
        if (!empty($arr)) {
            foreach ($arr as $key => $val) {
                $opt[] = array(
                    'value' => $val['goods_id'],
                    'text'  => $val['goods_name'],
                    'data'  => $val['shop_price'],
                );
            }
        }
        return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $opt));
    }

    /**
     * 获取专题列表
     * @access  public
     * @return void
     */
    private function get_topic_list()
    {
        $db_topics = RC_DB::table('topic');

        $filter             = array();
        $filter['keywords'] = empty($_GET['keywords']) ? '' : trim($_GET['keywords']);

        if ($filter['keywords']) {
            $db_topics->where('title', 'LIKE', '%' . mysql_like_quote($filter['keywords']) . '%');
        }
        $count = $db_topics->count();

        $filter['record_count'] = $count;
        $page                   = new ecjia_page($count, 10, 5);

        $data = $db_topics
            ->orderBy('topic_id', 'desc')
            ->take(10)
            ->skip($page->start_id - 1)
            ->get();

        $res = array();
        if (!empty($data)) {
            foreach ($data as $topic) {
                $topic['start_time'] = RC_Time::local_date('Y-m-d', $topic['start_time']);
                $topic['end_time']   = RC_Time::local_date('Y-m-d', $topic['end_time']);
                $res[]               = $topic;
            }
        }
        return array('topic' => $res, 'filter' => $filter, 'page' => $page->show(5), 'desc' => $page->page_desc());
    }
}
//end
