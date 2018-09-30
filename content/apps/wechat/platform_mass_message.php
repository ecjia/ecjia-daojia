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
 * ECJIA群发消息
 */
class platform_mass_message extends ecjia_platform
{
    public function __construct()
    {
        parent::__construct();


        RC_Loader::load_app_func('global');
        Ecjia\App\Wechat\Helper::assign_adminlog_content();

        RC_Script::enqueue_script('jquery-validate');
        RC_Script::enqueue_script('jquery-form');

        RC_Script::enqueue_script('admin_mass_message', RC_App::apps_url('statics/platform-js/admin_mass_message.js', __FILE__), array(), false, true);
        RC_Script::enqueue_script('choose_material', RC_App::apps_url('statics/platform-js/choose_material.js', __FILE__), array(), false, true);

        RC_Style::enqueue_style('admin_material', RC_App::apps_url('statics/platform-css/admin_material.css', __FILE__));

        RC_Script::localize_script('admin_mass_message', 'js_lang', RC_Lang::get('wechat::wechat.js_lang'));
        ecjia_platform_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.mass_message')));

        ecjia_platform_screen::get_current_screen()->set_subject('群发消息');
    }

    public function init()
    {
        $this->admin_priv('wechat_message_manage');

        ecjia_platform_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.send_message')));
        $this->assign('ur_here', RC_Lang::get('wechat::wechat.send_message'));

        $wechat_id = $this->platformAccount->getAccountID();

        if (is_ecjia_error($wechat_id)) {
            $this->assign('errormsg', RC_Lang::get('wechat::wechat.add_platform_first'));
        } else {
            $this->assign('warn', 'warn');
            $type = RC_DB::table('platform_account')->where('id', $wechat_id)->pluck('type');
            $this->assign('type', $type);
            $this->assign('type_error', sprintf(RC_Lang::get('wechat::wechat.notice_certification_info'), RC_Lang::get('wechat::wechat.wechat_type.' . $type)));

            //查找所有标签 不包括黑名单
            $list = RC_DB::table('wechat_tag')->where('wechat_id', $wechat_id)->where('tag_id', '!=', 1)->orderBy('tag_id', 'asc')->get();
            $this->assign('list', $list);
            $this->assign('form_action', RC_Uri::url('wechat/platform_mass_message/mass_message'));
        }

        $this->display('wechat_mass_message.dwt');
    }

    /**
     * 群发消息处理
     */
    public function mass_message()
    {
        $this->admin_priv('wechat_message_manage');

        $tag_id = $this->request->input('tag_id', null);
        $mass_type = $this->request->input('mass_type');
        $media_id = $this->request->input('media_id', 0);
        $content_type = $this->request->input('content_type');
        $content = $this->request->input('content');

        //发送文本
        if ($content_type == 'text') {
            if (empty($content)) {
                return $this->showmessage(RC_Lang::get('wechat::wechat.text_must_info'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
        } else {
            if (empty($media_id)) {
                return $this->showmessage(RC_Lang::get('wechat::wechat.pls_select_material'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
        }

        if ($mass_type == 'by_group') {
            if (empty($tag_id)) {
                return $this->showmessage('按群组发送，必须选择标签', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
        }

        try {
            $wechat_id = $this->platformAccount->getAccountID();
            $uuid = $this->platformAccount->getUUID();
            $wechat = with(new Ecjia\App\Wechat\WechatUUID($uuid))->getWechatInstance();

            if ($media_id) {
                with(new Ecjia\App\Wechat\Sends\BroadcastSendMessage($wechat, $wechat_id))->sendMediaMessage($media_id, $tag_id);
            } else {
                with(new Ecjia\App\Wechat\Sends\BroadcastSendMessage($wechat, $wechat_id))->sendTextMessage($content, $tag_id);
            }

            return $this->showmessage(RC_Lang::get('wechat::wechat.mass_task_info'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS,
                array('pjaxurl' => RC_Uri::url('wechat/platform_mass_message/init')));

        } catch (\Royalcms\Component\WeChat\Core\Exceptions\HttpException $e) {
            return $this->showmessage(\Ecjia\App\Wechat\WechatErrorCodes::getError($e->getCode(), $e->getMessage()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    /**
     * 群发消息列表
     */
    public function mass_list()
    {
        $this->admin_priv('wechat_message_manage');

        ecjia_platform_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.send_record')));
        $this->assign('ur_here', RC_Lang::get('wechat::wechat.send_record'));

        $wechat_id = $this->platformAccount->getAccountID();

        if (is_ecjia_error($wechat_id)) {
            $this->assign('errormsg', RC_Lang::get('wechat::wechat.add_platform_first'));
        } else {
            $this->assign('warn', 'warn');

            $type = RC_DB::table('platform_account')->where('id', $wechat_id)->pluck('type');
            $this->assign('type', $type);
            $this->assign('type_error', sprintf(RC_Lang::get('wechat::wechat.notice_certification_info'), RC_Lang::get('wechat::wechat.wechat_type.' . $type)));

            $list = $this->get_mass_history_list();
            $this->assign('list', $list);
        }
        $this->display('wechat_mass_list.dwt');
    }

    /**
     * 群发消息删除 1发送成功 2发送失败 3发送错误 4已删除
     */
    public function mass_del()
    {
        $this->admin_priv('wechat_message_manage', ecjia::MSGTYPE_JSON);

        $id = intval($this->request->input('id'));

        if (empty($id)) {
            return $this->showmessage('ID参数缺少', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $wechat_id = $this->platformAccount->getAccountID();
        $model = \Ecjia\App\Wechat\Models\WechatMassHistoryModel::where('wechat_id', $wechat_id)->where('id', $id)->first();

        if (!empty($model)) {
            try {

                if ($model->msg_id) {
                    $uuid = $this->platformAccount->getUUID();
                    $wechat = with(new Ecjia\App\Wechat\WechatUUID($uuid))->getWechatInstance();

                    $wechat->broadcast->delete($model->msg_id);
                }

            } catch (\Royalcms\Component\WeChat\Core\Exceptions\HttpException $e) {
                //微信服务器上删除失败不报错
                RC_Logger::getLogger('wechat')->error('微信服务器上删除失败:' . $e->getMessage());
                //return $this->showmessage($e->getMessage(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

            $model->delete();
        }

        return $this->showmessage(RC_Lang::get('wechat::wechat.remove_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
    }

    /**
     * 预览群发消息
     */
    public function preview_msg()
    {
        $type = trim($this->request->input('type')); //素材类型 text image voice video news
        $media_id = intval($this->request->input('media_id')); //素材id  1/2/3
        $content = trim($this->request->input('content')); //为text类型是 文本消息
        $wechat_account = trim($this->request->input('wechat_account')); //微信号

        if (empty($wechat_account)) {
            return $this->showmessage('请输入要预览的微信帐号', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        try {

            $wechat_id = $this->platformAccount->getAccountID();
            $uuid = $this->platformAccount->getUUID();
            $wechat = with(new Ecjia\App\Wechat\WechatUUID($uuid))->getWechatInstance();

            if ($media_id) {
                with(new Ecjia\App\Wechat\Sends\BroadcastSendMessage($wechat, $wechat_id))->previewMediaMessage($media_id, $wechat_account);
            } else {
                with(new Ecjia\App\Wechat\Sends\BroadcastSendMessage($wechat, $wechat_id))->prviewTextMessage($content, $wechat_account);
            }

            return $this->showmessage('发送预览成功，请留意你的手机微信', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);

        } catch (\Royalcms\Component\WeChat\Core\Exceptions\HttpException $e) {
            return $this->showmessage(\Ecjia\App\Wechat\WechatErrorCodes::getError($e->getCode(), $e->getMessage()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    private function get_mass_history_list()
    {
        $wechat_id = $this->platformAccount->getAccountID();

        $db_mass_history = RC_DB::table('wechat_mass_history')->where('wechat_id', $wechat_id);
        $count = $db_mass_history->count();
        $page = new ecjia_platform_page($count, 10, 5);
        $list = $db_mass_history->select('*')->orderBy('send_time', 'desc')->take(10)->skip($page->start_id - 1)->get();

        $status_list = array(
            'send success' => '发送成功',
            'send fail' => '发送失败',
            'err(10001)' => '涉嫌广告',
            'err(20001)' => '涉嫌政治',
            'err(20004)' => '涉嫌社会',
            'err(20002)' => '涉嫌色情',
            'err(20006)' => '涉嫌违法犯罪',
            'err(20008)' => '涉嫌欺诈',
            'err(20013)' => '涉嫌版权',
            'err(22000)' => '涉嫌互推(互相宣传)',
            'err(21000)' => '涉嫌其他',
            'err(30001)' => '原创校验出现系统错误且用户选择了被判为转载就不群发',
            'err(30002)' => '原创校验被判定为不能群发',
            'err(30003)' => '原创校验被判定为转载文且用户选择了被判为转载就不群发',
        );

        if (!empty($list)) {
            foreach ($list as $key => $val) {
                $list[$key]['send_time'] = RC_Time::local_date(ecjia::config('time_format'), $val['send_time']);
                $list[$key]['media_content'] = unserialize($val['content'])['media_content'];
                if ($val['type'] == 'voice') {
                    $list[$key]['media_content']['img_url'] = RC_App::apps_url('statics/images/voice.png', __FILE__);
                }

                if ($val['type'] == 'video') {
                    $list[$key]['media_content']['img_url'] = RC_App::apps_url('statics/images/video.png', __FILE__);
                }
                if (array_get($val['status'], $status_list)) {
                    $list[$key]['status'] = $status_list[$val['status']];
                }
            }
        }
        return array('list' => $list, 'page' => $page->show(5), 'desc' => $page->page_desc());
    }
}

//end
