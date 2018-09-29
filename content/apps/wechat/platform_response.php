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
 * ECJIA自动回复
 */
class platform_response extends ecjia_platform
{
    public function __construct()
    {
        parent::__construct();

        RC_Loader::load_app_class('platform_account', 'platform', false);
        RC_Loader::load_app_func('global');
        Ecjia\App\Wechat\Helper::assign_adminlog_content();

        /* 加载所有全局 js/css */
        RC_Script::enqueue_script('bootstrap-placeholder');
        RC_Script::enqueue_script('jquery-validate');
        RC_Script::enqueue_script('jquery-form');

        RC_Script::enqueue_script('admin_response', RC_App::apps_url('statics/platform-js/admin_response.js', __FILE__), array(), false, true);
        RC_Script::enqueue_script('choose_material', RC_App::apps_url('statics/platform-js/choose_material.js', __FILE__), array(), false, true);

        RC_Style::enqueue_style('admin_material', RC_App::apps_url('statics/platform-css/admin_material.css', __FILE__));
        RC_Script::localize_script('admin_response', 'js_lang', RC_Lang::get('wechat::wechat.js_lang'));

        ecjia_platform_screen::get_current_screen()->set_subject('自动回复');
    }

    /**
     * 关注自动回复
     */
    public function reply_subscribe()
    {
        $this->admin_priv('wechat_response_manage');

        ecjia_platform_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.attention_auto_reply')));
        $this->assign('ur_here', RC_Lang::get('wechat::wechat.auto_reply'));

        ecjia_platform_screen::get_current_screen()->add_help_tab(array(
            'id' => 'overview',
            'title' => RC_Lang::get('wechat::wechat.overview'),
            'content' =>
            '<p>' . RC_Lang::get('wechat::wechat.auto_reply_operation') . '</p>',
        ));

        ecjia_platform_screen::get_current_screen()->set_help_sidebar(
            '<p><strong>' . RC_Lang::get('wechat::wechat.lable_more_info') . '</strong></p>' .
            '<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia公众平台:自动回复#.E5.85.B3.E6.B3.A8.E8.87.AA.E5.8A.A8.E5.9B.9E.E5.A4.8D" target="_blank">' . RC_Lang::get('wechat::wechat.auto_reply_document') . '</a>') . '</p>'
        );

        $this->assign('form_action', RC_Uri::url('wechat/platform_response/reply_subscribe_insert'));
        $this->assign('add_material_action', RC_Uri::url('wechat/platform_response/add_material'));

        //自动回复数据
        $wechat_id = $this->platformAccount->getAccountID();
        if (is_ecjia_error($wechat_id)) {
            $this->assign('errormsg', RC_Lang::get('wechat::wechat.add_platform_first'));
        } else {
            $subscribe = RC_DB::table('wechat_reply')->where('wechat_id', $wechat_id)->where('type', 'subscribe')->first();
            if (!empty($subscribe['media_id'])) {
                $subscribe['media'] = RC_DB::table('wechat_media')->select('file', 'type', 'file_name')->where('wechat_id', $wechat_id)->where('id', $subscribe['media_id'])->first();
            }
            if ($subscribe['reply_type'] == 'news') {
                $data = RC_DB::table('wechat_media')->where('wechat_id', $wechat_id)->where('parent_id', $subscribe['media_id'])->orderBy('id', 'asc')->get();
                if (!empty($data)) {
                    foreach ($data as $k => $v) {
                        if (!empty($v['file'])) {
                            $subscribe['child'][$k]['title'] = strip_tags(Ecjia\App\Wechat\Helper::html_out($v['title']));
                            $subscribe['child'][$k]['file'] = RC_Upload::upload_url($v['file']);
                            $subscribe['child'][$k]['add_time'] = RC_Time::local_date(RC_Lang::get('wechat::wechat.date_ymd'), $v['add_time']);
                        } else {
                            $subscribe['child'][$k]['file'] = RC_Uri::admin_url('statics/images/nopic.png');
                        }
                    }
                }
            }

            if (!empty($subscribe)) {
                foreach ($subscribe as $key => $val) {
                    if (isset($val['type'])) {
                        if ($val['type'] == 'image' || $val['type'] == 'news') {
                            $subscribe['media']['file'] = RC_Upload::upload_url($val['file']);
                        } elseif ($val['type'] == 'voice') {
                            $subscribe['media']['file'] = RC_Uri::admin_url('statics/images/voice.png');
                        } elseif ($val['type'] == 'video') {
                            $subscribe['media']['file'] = RC_Uri::admin_url('statics/images/video.png');
                        }
                    }
                }
            } else {
                $subscribe['reply_type'] = 'text';
            }
            $this->assign('subscribe', $subscribe);
        }

        $this->display('wechat_reply_subscribe.dwt');
    }

    public function reply_subscribe_insert()
    {
        $id = !empty($_POST['id']) ? intval($_POST['id']) : 0;
        $media_id = !empty($_POST['media_id']) ? intval($_POST['media_id']) : 0;
        $reply_type = $_POST['content_type'];

        if ($reply_type != 'text') {
            $content = '';
        } else {
            $content = !empty($_POST['content']) ? $_POST['content'] : '';
            $media_id = 0;
        }

        $wechat_id = $this->platformAccount->getAccountID();
        $data = array(
            'wechat_id' => $wechat_id,
            'media_id' => $media_id,
            'type' => 'subscribe',
            'content' => $content,
            'reply_type' => $reply_type,
        );
        if (empty($id)) {
            $this->admin_priv('wechat_response_add', ecjia::MSGTYPE_JSON);

            //添加
            $id = RC_DB::table('wechat_reply')->insertGetId($data);

            $media_id = RC_DB::table('wechat_reply')->where('wechat_id', $wechat_id)->where('id', $id)->pluck('media_id');
            $file = RC_DB::table('wechat_media')->where('wechat_id', $wechat_id)->where('id', $media_id)->pluck('file');

            if ($reply_type == 'text') {
                ecjia_admin::admin_log($content . '，' . RC_Lang::get('wechat::wechat.reply_type_character'), 'add', 'reply_subscribe');
            } elseif ($reply_type == 'image') {
                ecjia_admin::admin_log($file . '，' . RC_Lang::get('wechat::wechat.reply_type_picture'), 'add', 'reply_subscribe');
            } elseif ($reply_type == 'voice') {
                ecjia_admin::admin_log($file . '，' . RC_Lang::get('wechat::wechat.reply_type_voice'), 'add', 'reply_subscribe');
            } elseif ($reply_type == 'video') {
                ecjia_admin::admin_log($file . '，' . RC_Lang::get('wechat::wechat.reply_type_video'), 'add', 'reply_subscribe');
            }
            if ($id) {
                return $this->showmessage(RC_Lang::get('wechat::wechat.add_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('wechat/platform_response/reply_subscribe')));
            } else {
                return $this->showmessage(RC_Lang::get('wechat::wechat.add_failed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
        } else {
            $this->admin_priv('wechat_response_update', ecjia::MSGTYPE_JSON);
            //更新
            RC_DB::table('wechat_reply')->where('wechat_id', $wechat_id)->where('id', $id)->update($data);

            $media_id = RC_DB::table('wechat_reply')->where('wechat_id', $wechat_id)->where('id', $id)->pluck('media_id');
            $file = RC_DB::table('wechat_media')->where('wechat_id', $wechat_id)->where('id', $media_id)->pluck('file');

            if ($reply_type == 'text') {
                ecjia_admin::admin_log($content . '，' . RC_Lang::get('wechat::wechat.reply_type_character'), 'edit', 'reply_subscribe');
            } elseif ($reply_type == 'image') {
                ecjia_admin::admin_log($file . '，' . RC_Lang::get('wechat::wechat.reply_type_picture'), 'edit', 'reply_subscribe');
            } elseif ($reply_type == 'voice') {
                ecjia_admin::admin_log($file . '，' . RC_Lang::get('wechat::wechat.reply_type_voice'), 'edit', 'reply_subscribe');
            } elseif ($reply_type == 'video') {
                ecjia_admin::admin_log($file . '，' . RC_Lang::get('wechat::wechat.reply_type_video'), 'edit', 'reply_subscribe');
            }

            if ($id) {
                return $this->showmessage(RC_Lang::get('wechat::wechat.edit_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('wechat/platform_response/reply_subscribe')));
            } else {
                return $this->showmessage(RC_Lang::get('wechat::wechat.add_failed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
        }
    }

    /**
     * 消息自动回复
     */
    public function reply_msg()
    {
        $this->admin_priv('wechat_response_manage');

        ecjia_platform_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.message_auto_reply')));
        $this->assign('ur_here', RC_Lang::get('wechat::wechat.auto_reply'));

        ecjia_platform_screen::get_current_screen()->add_help_tab(array(
            'id' => 'overview',
            'title' => RC_Lang::get('wechat::wechat.overview'),
            'content' =>
            '<p>' . RC_Lang::get('wechat::wechat.message_reply_operation') . '</p>',
        ));

        ecjia_platform_screen::get_current_screen()->set_help_sidebar(
            '<p><strong>' . RC_Lang::get('wechat::wechat.lable_more_info') . '</strong></p>' .
            '<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia公众平台:自动回复#.E6.B6.88.E6.81.AF.E8.87.AA.E5.8A.A8.E5.9B.9E.E5.A4.8D" target="_blank">' . RC_Lang::get('wechat::wechat.auto_reply_help') . '</a>') . '</p>'
        );

        $this->assign('form_action', RC_Uri::url('wechat/platform_response/reply_msg_insert'));
        $this->assign('add_material_action', RC_Uri::url('wechat/platform_response/add_material'));

        //自动回复数据
        $wechat_id = $this->platformAccount->getAccountID();

        if (is_ecjia_error($wechat_id)) {
            $this->assign('errormsg', RC_Lang::get('wechat::wechat.add_platform_first'));
        } else {
            $subscribe = RC_DB::table('wechat_reply')->where('wechat_id', $wechat_id)->where('type', 'msg')->first();
            if (!empty($subscribe['media_id'])) {
                $subscribe['media'] = RC_DB::table('wechat_media')->select('file', 'type', 'file_name')->where('wechat_id', $wechat_id)->where('id', $subscribe['media_id'])->first();
            }
            if ($subscribe['reply_type'] == 'news') {
                $data = RC_DB::table('wechat_media')->where('wechat_id', $wechat_id)->where('parent_id', $subscribe['media_id'])->orderBy('id', 'asc')->get();
                if (!empty($data)) {
                    foreach ($data as $k => $v) {
                        if (!empty($v['file'])) {
                            $subscribe['child'][$k]['title'] = strip_tags(Ecjia\App\Wechat\Helper::html_out($v['title']));
                            $subscribe['child'][$k]['file'] = RC_Upload::upload_url($v['file']);
                            $subscribe['child'][$k]['add_time'] = RC_Time::local_date(RC_Lang::get('wechat::wechat.date_ymd'), $v['add_time']);
                        } else {
                            $subscribe['child'][$k]['file'] = RC_Uri::admin_url('statics/images/nopic.png');
                        }
                    }
                }
            }

            if (!empty($subscribe)) {
                foreach ($subscribe as $key => $val) {
                    if (isset($val['type'])) {
                        if ($val['type'] == 'image' || $val['type'] == 'news') {
                            $subscribe['media']['file'] = RC_Upload::upload_url($val['file']);
                        } elseif ($val['type'] == 'voice') {
                            $subscribe['media']['file'] = RC_Uri::admin_url('statics/images/voice.png');
                        } elseif ($val['type'] == 'video') {
                            $subscribe['media']['file'] = RC_Uri::admin_url('statics/images/video.png');
                        }
                    }
                }
            } else {
                $subscribe['reply_type'] = 'text';
            }
            $this->assign('subscribe', $subscribe);
        }

        $this->display('wechat_reply_msg.dwt');
    }

    public function reply_msg_insert()
    {
        $id = !empty($_POST['id']) ? intval($_POST['id']) : 0;
        $media_id = !empty($_POST['media_id']) ? intval($_POST['media_id']) : 0;
        $reply_type = $_POST['content_type'];

        if ($_POST['content_type'] != 'text') {
            $content = '';
        } else {
            $content = !empty($_POST['content']) ? $_POST['content'] : '';
            $media_id = 0;
        }

        $wechat_id = $this->platformAccount->getAccountID();

        $data = array(
            'wechat_id' => $wechat_id,
            'media_id' => $media_id,
            'type' => 'msg',
            'content' => $content,
            'reply_type' => $reply_type,
        );
        if (empty($id)) {
            $this->admin_priv('wechat_response_add', ecjia::MSGTYPE_JSON);
            //添加
            $id = RC_DB::table('wechat_reply')->insertGetId($data);

            $media_id = RC_DB::table('wechat_reply')->where('wechat_id', $wechat_id)->where('id', $id)->pluck('media_id');
            $info = RC_DB::table('wechat_media')->select('file', 'type')->where('wechat_id', $wechat_id)->where('id', $media_id)->first();

            if (!empty($content)) {
                ecjia_admin::admin_log($content . '，' . RC_Lang::get('wechat::wechat.reply_type_character'), 'add', 'reply_msg');
            } else {
                if ($info['type'] == 'image') {
                    ecjia_admin::admin_log($info['file'] . '，' . RC_Lang::get('wechat::wechat.reply_type_picture'), 'add', 'reply_msg');
                } elseif ($info['type'] == 'voice') {
                    ecjia_admin::admin_log($info['file'] . '，' . RC_Lang::get('wechat::wechat.reply_type_voice'), 'add', 'reply_msg');
                } elseif ($info['type'] == 'video') {
                    ecjia_admin::admin_log($info['file'] . '，' . RC_Lang::get('wechat::wechat.reply_type_video'), 'add', 'reply_msg');
                }
            }
            if ($id) {
                return $this->showmessage(RC_Lang::get('wechat::wechat.add_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('wechat/platform_response/reply_msg')));
            } else {
                return $this->showmessage(RC_Lang::get('wechat::wechat.add_failed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
        } else {
            $this->admin_priv('wechat_response_update', ecjia::MSGTYPE_JSON);

            //更新
            RC_DB::table('wechat_reply')->where('wechat_id', $wechat_id)->where('id', $id)->update($data);

            $media_id = RC_DB::table('wechat_reply')->where('wechat_id', $wechat_id)->where('id', $id)->pluck('media_id');
            $info = RC_DB::table('wechat_media')->select('file', 'type')->where('wechat_id', $wechat_id)->where('id', $media_id)->first();

            if (!empty($content)) {
                ecjia_admin::admin_log($content . '，' . RC_Lang::get('wechat::wechat.reply_type_character'), 'edit', 'reply_msg');
            } else {
                if ($info['type'] == 'image') {
                    ecjia_admin::admin_log($info['file'] . '，' . RC_Lang::get('wechat::wechat.reply_type_picture'), 'edit', 'reply_msg');
                } elseif ($info['type'] == 'voice') {
                    ecjia_admin::admin_log($info['file'] . '，' . RC_Lang::get('wechat::wechat.reply_type_voice'), 'edit', 'reply_msg');
                } elseif ($info['type'] == 'video') {
                    ecjia_admin::admin_log($info['file'] . '，' . RC_Lang::get('wechat::wechat.reply_type_video'), 'edit', 'reply_msg');
                }
            }
            if ($id) {
                return $this->showmessage(RC_Lang::get('wechat::wechat.edit_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('wechat/platform_response/reply_msg')));
            } else {
                return $this->showmessage(RC_Lang::get('wechat::wechat.edit_failed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
        }
    }

    /**
     * 关键词自动回复
     */
    public function reply_keywords()
    {
        ecjia_platform_screen::get_current_screen()->set_subject('关键词回复');

        $this->admin_priv('wechat_response_manage');

        $this->assign('ur_here', RC_Lang::get('wechat::wechat.reply_keyword'));
        ecjia_platform_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.reply_keyword')));

        ecjia_platform_screen::get_current_screen()->add_help_tab(array(
            'id' => 'overview',
            'title' => RC_Lang::get('wechat::wechat.overview'),
            'content' =>
            '<p>' . RC_Lang::get('wechat::wechat.keyword_reply_operation') . '</p>',
        ));

        ecjia_platform_screen::get_current_screen()->set_help_sidebar(
            '<p><strong>' . RC_Lang::get('wechat::wechat.more_info') . '</strong></p>' .
            '<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia公众平台:关键词回复#.E5.85.B3.E9.94.AE.E8.AF.8D.E5.9B.9E.E5.A4.8D" target="_blank">' . RC_Lang::get('wechat::wechat.auto_keywords_help') . '</a>') . '</p>'
        );

        $wechat_id = $this->platformAccount->getAccountID();
        $this->assign('form_action', RC_Uri::url('wechat/platform_response/reply_keywords'));
        $this->assign('action_link', array('text' => RC_Lang::get('wechat::wechat.add_rule'), 'href' => RC_Uri::url('wechat/platform_response/reply_keywords_add')));

        if (is_ecjia_error($wechat_id)) {
            $this->assign('errormsg', RC_Lang::get('wechat::wechat.add_platform_first'));
        } else {
            $list = $this->get_rule_list();
            $this->assign('list', $list);
        }

        $this->display('wechat_reply_keywords.dwt');
    }

    public function reply_keywords_add()
    {
        $this->admin_priv('wechat_response_add');

        ecjia_platform_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.reply_keyword'), RC_Uri::url('wechat/platform_response/reply_keywords')));
        $this->assign('action_link', array('href' => RC_Uri::url('wechat/platform_response/reply_keywords'), 'text' => RC_Lang::get('wechat::wechat.reply_keyword')));

        $this->assign('form_action', RC_Uri::url('wechat/platform_response/reply_keywords_insert'));
        $this->assign('add_material_action', RC_Uri::url('wechat/platform_response/add_material'));

        $wechat_id = $this->platformAccount->getAccountID();
        if (is_ecjia_error($wechat_id)) {
            $this->assign('errormsg', RC_Lang::get('wechat::wechat.add_platform_first'));
        }

        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        if (!empty($id)) {
            $this->assign('ur_here', RC_Lang::get('wechat::wechat.edit_rule'));
            ecjia_platform_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.edit_rule')));
            ecjia_platform_screen::get_current_screen()->add_help_tab(array(
                'id' => 'overview',
                'title' => RC_Lang::get('wechat::wechat.overview'),
                'content' =>
                '<p>' . RC_Lang::get('wechat::wechat.edit_rule_operation') . '</p>',
            ));

            ecjia_platform_screen::get_current_screen()->set_help_sidebar(
                '<p><strong>' . RC_Lang::get('wechat::wechat.lable_more_info') . '</strong></p>' .
                '<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia公众平台:关键词回复#.E7.BC.96.E8.BE.91.E8.A7.84.E5.88.99" target="_blank">' . RC_Lang::get('wechat::wechat.edit_rule_help') . '</a>') . '</p>'
            );

            $this->assign('id', $id);
            $data = $this->get_rule_info($id);
            $this->assign('data', $data);
        } else {
            $this->assign('ur_here', RC_Lang::get('wechat::wechat.add_rule'));
            ecjia_platform_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.add_rule')));
            ecjia_platform_screen::get_current_screen()->add_help_tab(array(
                'id' => 'overview',
                'title' => RC_Lang::get('wechat::wechat.overview'),
                'content' =>
                '<p>' . RC_Lang::get('wechat::wechat.add_rule_operation') . '</p>',
            ));

            ecjia_platform_screen::get_current_screen()->set_help_sidebar(
                '<p><strong>' . RC_Lang::get('wechat::wechat.lable_more_info') . '</strong></p>' .
                '<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia公众平台:关键词回复#.E6.B7.BB.E5.8A.A0.E8.A7.84.E5.88.99" target="_blank">' . RC_Lang::get('wechat::wechat.add_rule_help') . '</a>') . '</p>'
            );
            $data['reply_type'] = 'text';
            $this->assign('data', $data);
        }
        $this->display('wechat_reply_keywords_edit.dwt');
    }

    public function reply_keywords_insert()
    {

        $wechat_id = $this->platformAccount->getAccountID();

        if (is_ecjia_error($wechat_id)) {
            return $this->showmessage(RC_Lang::get('wechat::wechat.add_accounts_again'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
        $content_type = isset($_POST['content_type']) ? $_POST['content_type'] : '';
        $rule_keywords = isset($_POST['rule_keywords']) ? trim($_POST['rule_keywords']) : '';
        $data['rule_name'] = isset($_POST['rule_name']) ? trim($_POST['rule_name']) : '';
        $data['media_id'] = !empty($_POST['media_id']) ? intval($_POST['media_id']) : '';
        $data['content'] = isset($_POST['content']) ? trim($_POST['content']) : '';
        $data['wechat_id'] = $wechat_id;
        $data['reply_type'] = $content_type;

        if ($content_type == 'text') {
            $data['media_id'] = 0;
        } else {
            $data['content'] = '';
        }

        if ($data['rule_name'] == '') {
            return $this->showmessage(RC_Lang::get('wechat::wechat.rule_name_required'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        if ($rule_keywords == '') {
            return $this->showmessage(RC_Lang::get('wechat::wechat.rule_keywords_required'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        if ($data['content'] == '' && empty($data['media_id'])) {
            return $this->showmessage(RC_Lang::get('wechat::wechat.input_select_info'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        $data['type'] = 'keywords';

        if (!empty($id)) {
            $is_only = RC_DB::table('wechat_reply')->where('wechat_id', $wechat_id)->where('id', '!=', $id)->where('rule_name', $data['rule_name'])->count();
            if ($is_only != 0) {
                return $this->showmessage(sprintf(RC_Lang::get('wechat::wechat.rule_name_exists'), $data['rule_name']), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
        } else {
            $is_only = RC_DB::table('wechat_reply')->where('wechat_id', $wechat_id)->where('rule_name', $data['rule_name'])->count();
            if ($is_only != 0) {
                return $this->showmessage(sprintf(RC_Lang::get('wechat::wechat.rule_name_exists'), $data['rule_name']), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
        }
        // 编辑关键词
        $rule_keywords = explode(',', $rule_keywords);
        $rule_keywords_list = RC_DB::table('wechat_reply as wr')
            ->leftJoin('wechat_rule_keywords as wrk', RC_DB::raw('wrk.rid'), '=', RC_DB::raw('wr.id'))
            ->where(RC_DB::raw('wr.wechat_id'), $wechat_id)
            ->where(RC_DB::raw('wr.id'), '!=', $id)
            ->select(RC_DB::raw('wrk.rule_keywords'))
            ->get();

        if (!empty($rule_keywords_list)) {
            foreach ($rule_keywords_list as $v) {
                if (in_array($v['rule_keywords'], $rule_keywords, true)) {
                    return $this->showmessage(sprintf(RC_Lang::get('wechat::wechat.keyword_exists'), $v['rule_keywords']), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                }
            }
        }

        $count = array_count_values($rule_keywords);
        foreach ($count as $k => $c) {
            if ($c > 1) {
                return $this->showmessage(sprintf(RC_Lang::get('wechat::wechat.keyword_repeat'), $k), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
        }
        if (!empty($id)) {
            $this->admin_priv('wechat_response_update', ecjia::MSGTYPE_JSON);
            $this->admin_priv('wechat_response_delete', ecjia::MSGTYPE_JSON);

            $update = 1;
            RC_DB::table('wechat_reply')->where('wechat_id', $wechat_id)->where('id', $id)->update($data);
            RC_DB::table('wechat_rule_keywords')->where('rid', $id)->delete();

            ecjia_admin::admin_log($data['rule_name'], 'edit', 'reply_keywords_rule');
        } else {
            $this->admin_priv('wechat_response_add', ecjia::MSGTYPE_JSON);

            $data['add_time'] = RC_Time::gmtime();
            $id = RC_DB::table('wechat_reply')->insertGetId($data);

            ecjia_admin::admin_log($data['rule_name'], 'add', 'reply_keywords_rule');
        }
        foreach ($rule_keywords as $val) {
            $kdata['rid'] = $id;
            $kdata['rule_keywords'] = $val;
            RC_DB::table('wechat_rule_keywords')->insert($kdata);
        }

        $update = isset($update) ? $update : '';
        if ($update) {
            return $this->showmessage('编辑成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('wechat/platform_response/reply_keywords_add', array('id' => $id))));
        } else {
            $links[] = array('text' => RC_Lang::get('wechat::wechat.keyword_reply'), 'href' => RC_Uri::url('wechat/platform_response/reply_keywords'));
            $links[] = array('text' => RC_Lang::get('wechat::wechat.add_keyword'), 'href' => RC_Uri::url('wechat/platform_response/reply_keywords_add'));
            return $this->showmessage(RC_Lang::get('wechat::wechat.add_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links, 'pjaxurl' => RC_Uri::url('wechat/platform_response/reply_keywords_add', array('id' => $id))));
        }
    }

    /**
     * 删除规则
     */
    public function remove_rule()
    {
        $this->admin_priv('wechat_response_delete', ecjia::MSGTYPE_JSON);

        $wechat_id = $this->platformAccount->getAccountID();

        if (is_ecjia_error($wechat_id)) {
            return $this->showmessage(RC_Lang::get('wechat::wechat.del_accounts_again'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $id = !empty($_GET['id']) ? intval($_GET['id']) : 0;
        //获取该公众号下的id数组
        $id_list = RC_DB::table('wechat_reply')->where('wechat_id', $wechat_id)->where('type', 'keywords')->lists('id');
        $rule_name = RC_DB::table('wechat_reply')->where('wechat_id', $wechat_id)->where('id', $id)->pluck('rule_name');
        //获取该条规则的关键词
        $rule_keywords = RC_DB::table('wechat_rule_keywords')->where('rid', $id)->lists('rule_keywords');

        RC_DB::table('wechat_reply')->where('wechat_id', $wechat_id)->where('id', $id)->delete();
        RC_DB::table('wechat_rule_keywords')->whereRaw('rule_keywords' . ecjia_db_create_in($rule_keywords))->whereRaw('rid' . ecjia_db_create_in($id_list))->delete();

        if (!empty($id_list)) {
            foreach ($id_list as $v) {
                $count = RC_DB::table('wechat_rule_keywords')->where('rid', $v)->count();
                if ($count == 0) {
                    RC_DB::table('wechat_reply')->where('wechat_id', $wechat_id)->where('id', $v)->where('type', 'keywords')->delete();
                }
            }
        }
        ecjia_admin::admin_log($rule_name, 'remove', 'reply_keywords_rule');

        return $this->showmessage(RC_Lang::get('wechat::wechat.remove_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
    }

    /**
     * 获取规则列表
     */
    private function get_rule_list()
    {
        $wechat_id = $this->platformAccount->getAccountID();

        $db = RC_DB::table('wechat_reply')->where('wechat_id', $wechat_id)->where('type', 'keywords');
        $search_keywords = isset($_GET['keywords']) ? trim($_GET['keywords']) : '';

        if ($search_keywords != '') {
            $rid_list = RC_DB::table('wechat_rule_keywords')->where('rule_keywords', 'like', "%" . mysql_like_quote($search_keywords) . "%")->lists('rid');
            $db->whereRaw('id' . ecjia_db_create_in($rid_list));
        }

        $count = $db->count();
        $page = new ecjia_page($count, 10, 5);
        $list = $db->select('id', 'rule_name', 'content', 'media_id', 'reply_type')->take(10)->skip($page->start_id - 1)->orderBy('add_time', 'desc')->get();

        if (!empty($list)) {
            foreach ($list as $key => $val) {
                // 内容不是文本
                if (!empty($val['media_id'])) {
                    $media = RC_DB::table('wechat_media')->where('wechat_id', $wechat_id)->where('id', $val['media_id'])->first();

                    if (!empty($media)) {
                        $media['add_time'] = RC_Time::local_date(RC_Lang::get('wechat::wechat.date_nj'), $media['add_time']);
                        $media['file'] = RC_Upload::upload_url($media['file']);

                        $media['content'] = empty($media['digest']) ? $media['content'] : $media['digest'];
                        $content = strip_tags(Ecjia\App\Wechat\Helper::html_out($media['content']));
                        if (strlen($content) > 100) {
                            $media['content'] = Ecjia\App\Wechat\Helper::msubstr($content, 100);
                        } else {
                            $media['content'] = $content;
                        }
                    }
                    $media_id = $val['media_id'];

                    $is_articles = RC_DB::table('wechat_media')->where('wechat_id', $wechat_id)->where('parent_id', $media_id)->count();

                    if ($val['reply_type'] == 'news' && $is_articles != 0) {
                        $info = RC_DB::table('wechat_media')->where('wechat_id', $wechat_id)->where('id', $media_id)->orWhere('parent_id', $media_id)->orderBy('id', 'asc')->get();

                        foreach ($info as $k => $v) {
                            if (!empty($v['file'])) {
                                $list[$key]['medias'][$k]['title'] = strip_tags(Ecjia\App\Wechat\Helper::html_out($v['title']));
                                $list[$key]['medias'][$k]['file'] = RC_Upload::upload_url($v['file']);
                                $list[$key]['medias'][$k]['add_time'] = RC_Time::local_date(RC_Lang::get('wechat::wechat.date_ymd'), $v['add_time']);
                            } else {
                                $list[$key]['medias'][$k]['file'] = RC_Uri::admin_url('statics/images/nopic.png');
                            }
                        }
                    } else {
                        if (isset($media['type'])) {
                            if ($media['type'] == 'voice') {
                                $media['file'] = RC_App::apps_url('statics/images/voice.png', __FILE__);
                            } elseif ($media['type'] == 'video') {
                                $media['file'] = RC_App::apps_url('statics/images/video.png', __FILE__);
                            }
                        }
                        $list[$key]['media'] = $media;
                    }
                }
                $keywords = RC_DB::table('wechat_rule_keywords')->where('rid', $val['id'])->orderBy('id', 'asc')->lists('rule_keywords');
                $list[$key]['rule_keywords'] = $keywords;
            }
        }
        return array('item' => $list, 'page' => $page->show(5), 'desc' => $page->page_desc());
    }

    /**
     * 获取规则详情
     */
    private function get_rule_info($id)
    {
        $wechat_id = $this->platformAccount->getAccountID();
        $db = RC_DB::table('wechat_reply')->where('wechat_id', $wechat_id);
        if ($id) {
            $db->where('id', $id);
        }
        $list = $db->where('type', 'keywords')->orderBy('add_time', 'desc')->first();

        // 内容不是文本
        if (!empty($list['media_id'])) {
            $media = RC_DB::table('wechat_media')->where('wechat_id', $wechat_id)->where('id', $list['media_id'])->first();
            if (!empty($media)) {
                if ($media['type'] == 'voice' || $media['type'] == 'video') {
                    if ($media['type'] == 'voice') {
                        $media['file'] = RC_App::apps_url('statics/images/voice.png', __FILE__);
                    } elseif ($media['type'] == 'video') {
                        $media['file'] = RC_App::apps_url('statics/images/video.png', __FILE__);
                    }
                } else {
                    if (!empty($media['file'])) {
                        $media['file'] = RC_Upload::upload_url($media['file']);
                    } else {
                        $media['file'] = RC_Uri::admin_url('statics/images/nopic.png');
                    }
                }
                $media['add_time'] = RC_Time::local_date(RC_Lang::get('wechat::wechat.date_nj'), $media['add_time']);
                $media['content'] = empty($media['digest']) ? $media['content'] : $media['digest'];
                $content = strip_tags(Ecjia\App\Wechat\Helper::html_out($media['content']));
                if (strlen($content) > 100) {
                    $media['content'] = Ecjia\App\Wechat\Helper::msubstr($content, 100);
                } else {
                    $media['content'] = $content;
                }
            }
            $media_id = $list['media_id'];

            $list['media'] = $media;
            if ($list['reply_type'] == 'news') {
                $data = RC_DB::table('wechat_media')->where('wechat_id', $wechat_id)->where('parent_id', $media_id)->orderBy('id', 'asc')->get();
                if (!empty($data)) {
                    foreach ($data as $k => $v) {
                        if (!empty($v['file'])) {
                            $list['child'][$k]['title'] = strip_tags(Ecjia\App\Wechat\Helper::html_out($v['title']));
                            $list['child'][$k]['file'] = RC_Upload::upload_url($v['file']);
                            $list['child'][$k]['add_time'] = RC_Time::local_date(RC_Lang::get('wechat::wechat.date_ymd'), $v['add_time']);
                        } else {
                            $list['child'][$k]['file'] = RC_Uri::admin_url('statics/images/nopic.png');
                        }
                    }
                }
            }
        }
        if (!empty($list['id'])) {
            $keywords = RC_DB::table('wechat_rule_keywords')->select('rule_keywords')->where('rid', $list['id'])->orderBy('id', 'asc')->get();
        }

        $list['rule_keywords'] = $keywords;
        // 编辑关键词时显示
        if (!empty($keywords)) {
            $rule_keywords = array();
            foreach ($keywords as $k => $v) {
                $rule_keywords[] = $v['rule_keywords'];
            }
            $rule_keywords = implode(',', $rule_keywords);
            $list['rule_keywords_string'] = $rule_keywords;
        }
        return $list;
    }

    /**
     * 获取多图文信息
     */
    private function get_article_list($id, $type)
    {
        $filter['type'] = empty($_GET['type']) ? '' : trim($_GET['type']);

        $db = RC_DB::table('wechat_media')->where('type', $type);
        if ($id) {
            $db->where('parent_id', $id)->orWhere('id', $id);
        }
        $data = $db->orderBy('id', 'asc')->get();
        $article['id'] = $id;

        if (!empty($data)) {
            foreach ($data as $k => $v) {
                $article['ids'][$k] = $v['id'];

                if (!empty($v['file'])) {
                    $article['file'][$k]['file'] = RC_Upload::upload_url($v['file']);
                } else {
                    $article['file'][$k]['file'] = RC_Uri::admin_url('statics/images/nopic.png');
                }
                $article['file'][$k]['add_time'] = RC_Time::local_date(RC_Lang::get('wechat::wechat.date_ymd'), $v['add_time']);
                $article['file'][$k]['title'] = strip_tags(Ecjia\App\Wechat\Helper::html_out($v['title']));
                $article['file'][$k]['id'] = $v['id'];
                if (!empty($v['size'])) {
                    if ($v['size'] > (1024 * 1024)) {
                        $article['file'][$k]['size'] = round(($v['size'] / (1024 * 1024)), 1) . 'MB';
                    } else {
                        $article['file'][$k]['size'] = round(($v['size'] / 1024), 1) . 'KB';
                    }
                } else {
                    $article['file'][$k]['size'] = '';
                }
            }
        }
        return $article;
    }
}

//end
