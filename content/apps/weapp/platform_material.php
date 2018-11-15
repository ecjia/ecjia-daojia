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
use Ecjia\App\Wechat\Models\WechatMediaModel;

defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA素材
 */
class platform_material extends ecjia_platform
{
    public function __construct()
    {
        parent::__construct();

        RC_Loader::load_app_func('global');

        /* 加载所有全局 js/css */
        RC_Script::enqueue_script('bootstrap-placeholder');
        RC_Script::enqueue_script('jquery-validate');
        RC_Script::enqueue_script('jquery-form');
        RC_Script::enqueue_script('jquery-dropper', RC_App::apps_url('statics/platform-js/dropper-upload/jquery.fs.dropper.js', __FILE__), array(), false, true);

        RC_Script::enqueue_script('ecjia-platform-bootstrap-fileupload-js');
        RC_Style::enqueue_style('ecjia-platform-bootstrap-fileupload-css');

        RC_Script::enqueue_script('admin_material', RC_App::apps_url('statics/platform-js/admin_material.js', __FILE__), array(), false, true);
        RC_Style::enqueue_style('admin_material', RC_App::apps_url('statics/platform-css/admin_material.css', __FILE__));
        RC_Script::localize_script('admin_material', 'js_lang', RC_Lang::get('wechat::wechat.js_lang'));

        ecjia_platform_screen::get_current_screen()->set_subject('素材管理');
    }

    /**
     * 素材列表
     */
    public function init()
    {
        $this->admin_priv('weapp_material_manage');

        ecjia_platform_screen::get_current_screen()->remove_last_nav_here();
        $nav_here = RC_Lang::get('wechat::wechat.forever_material');

        $material = $this->request->input('material') ? 1 : 0;
        if ($material != 1) {
            $nav_here = RC_Lang::get('wechat::wechat.provisional_material');
        }
        ecjia_platform_screen::get_current_screen()->add_nav_here(new admin_nav_here($nav_here));

        $type = isset($_GET['type']) ? $_GET['type'] : '';
        $form_action = '';
        $action_link = '';

        if ($type == 'news') {
            $action_link = array('text' => RC_Lang::get('wechat::wechat.add_images'), 'href' => RC_Uri::url('weapp/platform_material/add'));
            $get_material_link = array('text' => '获取图文素材', 'href' => RC_Uri::url("weapp/platform_material/get_material", ['type' => 'news']));

            ecjia_platform_screen::get_current_screen()->set_help_sidebar(
                '<p>图文素材：分为单图文、多图文素材。支持图片，语音，视频，缩略图素材。</p>' .
                '<p>单图文素材添加好之后，即可将多条单图文素材组合成为一条多图文素材。</p>' .
                '<p>★ 注意事项：单图文素材如果经过修改，则原先添加好的多图文素材需要重新组合。</p>'
            );
        } elseif ($type == 'image') {
            $form_action = RC_Uri::url('weapp/platform_material/picture_insert');
            $get_material_link = array('text' => '获取图片素材', 'href' => RC_Uri::url("weapp/platform_material/get_material", ['type' => 'image']));

            if ($material) {
                ecjia_platform_screen::get_current_screen()->set_help_sidebar(
                    '<p>图片（image）素材大小: 2M，支持BMP/PNG/JPEG/JPG/GIF格式。</p>'
                );
            } else {
                ecjia_platform_screen::get_current_screen()->set_help_sidebar(
                    '<p>图片（image）素材大小: 2M，支持PNG/JPEG/JPG/GIF格式。</p>'
                );
            }
        } elseif ($type == 'voice') {
            $form_action = RC_Uri::url('weapp/platform_material/voice_insert');
            $get_material_link = array('text' => '获取语音素材', 'href' => RC_Uri::url("weapp/platform_material/get_material", ['type' => 'voice']));

            if ($material) {
                ecjia_platform_screen::get_current_screen()->set_help_sidebar(
                    '<p>语音（voice）素材大小：2M，播放长度不超过60s，mp3/wma/wav/amr格式。</p>'
                );
            } else {
                ecjia_platform_screen::get_current_screen()->set_help_sidebar(
                    '<p>语音（voice）素材大小：2M，播放长度不超过60s，支持AMR/MP3格式。</p>'
                );
            }
        } elseif ($type == 'video') {
            $action_link = array('text' => RC_Lang::get('wechat::wechat.add_video'), 'href' => RC_Uri::url('weapp/platform_material/video_add'));
            $get_material_link = array('text' => '获取视频素材', 'href' => RC_Uri::url("weapp/platform_material/get_material", ['type' => 'video']));

            ecjia_platform_screen::get_current_screen()->set_help_sidebar(
                '<p>视频（video）素材大小：10MB，支持MP4格式。</p>' .
                '<p>建议直接使用优酷等第三方视频网站的视频地址。优点:不占用服务器资源，支持更大、更多格式的视频素材。</p>'
            );
        } elseif ($type == 'thumb') {
            $form_action = RC_Uri::url('weapp/platform_material/thumb_insert');

            ecjia_screen::get_current_screen()->set_help_sidebar(
                '<p>缩略图（thumb）素材大小：64KB，支持JPG格式。</p>'
            );
        }

        if ($material) {
            $ur_here = '永久素材管理';
        } else {
            $ur_here = '临时素材管理';
        }

        $this->assign('ur_here', $ur_here);
        $this->assign('action_link', $action_link);

        if ($material == 1) {
            $this->assign('get_material_link', $get_material_link);
        }
        $this->assign('form_action', $form_action);
        $this->assign('warn', 'warn');

        $wechat_type = $this->platformAccount->getType();
        $this->assign('wechat_type', $wechat_type);

        $lists = $this->get_all_material();
        $this->assign('lists', $lists);

        $this->display('weapp_material.dwt');
    }

    /**
     * 图文添加
     */
    public function add()
    {
        $this->admin_priv('weapp_material_add');

        $material = 1;

        $nav_here = RC_Lang::get('wechat::wechat.forever_material');
        ecjia_platform_screen::get_current_screen()->add_nav_here(new admin_nav_here($nav_here, RC_Uri::url('weapp/platform_material/init', array('type' => 'news', 'material' => 1))));
        ecjia_platform_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.add_images')));
        ecjia_platform_screen::get_current_screen()->set_sidebar_display(false);

        $this->assign('ur_here', RC_Lang::get('wechat::wechat.add_images'));
        $this->assign('action_link', array('text' => RC_Lang::get('wechat::wechat.material_manage'), 'href' => RC_Uri::url('weapp/platform_material/init', array('type' => 'news', 'material' => 1))));
        $this->assign('form_action', RC_Uri::url('weapp/platform_material/insert'));
        $this->assign('action', 'article_add');

        $this->assign('warn', 'warn');

        $wechat_type = $this->platformAccount->getType();
        $this->assign('wechat_type', $wechat_type);
        $this->assign('material', $material);

        $this->display('weapp_material_add.dwt');
    }

    /**
     * 图文添加数据插入
     */
    public function insert()
    {
        $this->admin_priv('weapp_material_add', ecjia::MSGTYPE_JSON);

        $id = intval($this->request->query('id', 0));

        $title = !empty($_POST['title']) ? trim($_POST['title']) : '';
        $author = !empty($_POST['author']) ? trim($_POST['author']) : '';
        $is_show = !empty($_POST['is_show']) ? intval($_POST['is_show']) : 0;
        $digest = !empty($_POST['digest']) ? $_POST['digest'] : '';
        $link = !empty($_POST['link']) ? trim($_POST['link']) : '';
        $content = !empty($_POST['content']) ? stripslashes($_POST['content']) : '';
        $sort = !empty($_POST['sort']) ? intval($_POST['sort']) : 0;

        $thumb_media_id = $this->request->input('thumb_media_id');

        if (empty($title)) {
            return $this->showmessage(RC_Lang::get('wechat::wechat.enter_images_title'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        if (empty($content)) {
            return $this->showmessage(RC_Lang::get('wechat::wechat.enter_main_body'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        if (empty($thumb_media_id)) {
            return $this->showmessage('图文素材的封面图片必须选择一个', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        try {
            $wechat_id = $this->platformAccount->getAccountID();

            $model = WechatMediaModel::where('wechat_id', $wechat_id)->thumbMediaId($thumb_media_id)->first();
            if (empty($model)) {
                return $this->showmessage('图文素材的封面图片不是一个有效的素材，请更换一个封面素材。', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

            $uuid = $this->platformAccount->getUUID();
            $wechat = with(new Ecjia\App\Weapp\WeappUUID($uuid))->getWechatInstance();

            //conent中图片下载并上传至微信素材中
            $content = $this->uploadMassMessageContentImages($wechat, $content);

            $data = array(
                'wechat_id' => $wechat_id,
                'title' => $title,
                'author' => $author,
                'is_show' => $is_show,
                'digest' => $digest,
                'link' => $link,
                'content' => $content,
                'sort' => $sort,
                'thumb' => $thumb_media_id,
                'file' => $model->file,
                'size' => $model->size,
                'file_name' => $model->file_name,
                'add_time' => RC_Time::gmtime(),
                'type' => 'news',
                'is_material' => 'material',
            );
            if ($id) {
                $data['parent_id'] = $id;
            } else {
                $data['parent_id'] = 0;
            }
            // 上传单篇图文
            $article = new Royalcms\Component\WeChat\Message\Article([
                'title' => $title,
                'thumb_media_id' => $thumb_media_id,
                'author' => $author,
                'digest' => $digest,
                'show_cover_pic' => $is_show,
                'content' => $content,
                'content_source_url' => $link,
            ]);

            $rs = $wechat->material->uploadArticle($article);

            //图文消息的id
            $data['media_id'] = $rs['media_id'];

            $id = RC_DB::table('wechat_media')->insertGetId($data);
            $this->admin_log($title, 'add', 'article_material');

            $links[] = array('text' => RC_Lang::get('wechat::wechat.return_material_manage'), 'href' => RC_Uri::url('weapp/platform_material/init', array('type' => 'news', 'material' => 1)));
            $links[] = array('text' => RC_Lang::get('wechat::wechat.continue_material_manage'), 'href' => RC_Uri::url('weapp/platform_material/add', array('material' => 1)));
            return $this->showmessage(RC_Lang::get('wechat::wechat.add_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links, 'pjaxurl' => RC_Uri::url('weapp/platform_material/edit', array('id' => $id, 'material' => 1))));

        } catch (\Royalcms\Component\WeChat\Core\Exceptions\HttpException $e) {
            return $this->showmessage(\Ecjia\App\Wechat\WechatErrorCodes::getError($e->getCode(), $e->getMessage()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        } catch (\BadMethodCallException $e) {
            return $this->showmessage($e->getMessage(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    /**
     * 素材编辑
     */
    public function edit()
    {
        $this->admin_priv('weapp_material_update');

        $id = intval($_GET['id']);
        $wechat_id = $this->platformAccount->getAccountID();

        $article = RC_DB::table('wechat_media')->where('wechat_id', $wechat_id)->where('id', $id)->where('type', 'news')->first();
        if (empty($article)) {
            return $this->showmessage('该素材不存在', ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR);
        }

        if ($article['parent_id'] > 0) {
            $parent_model = WechatMediaModel::where('wechat_id', $wechat_id)->find($article['parent_id']);
            if (empty($parent_model)) {
                return $this->showmessage('父图文素材ID不存在。', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            $parent_id = $article['parent_id'];
        } else {
            $parent_id = $id;
        }
        if (!empty($article['file'])) {
            $article['file'] = RC_Upload::upload_url($article['file']);
        }

        ecjia_platform_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.material_manage'), RC_Uri::url('weapp/platform_material/init', array('type' => 'news', 'material' => 1))));
        ecjia_platform_screen::get_current_screen()->add_nav_here(new admin_nav_here('图文编辑'));
        ecjia_platform_screen::get_current_screen()->set_sidebar_display(false);

        $this->assign('ur_here', '图文编辑');
        $this->assign('form_action', RC_Uri::url('weapp/platform_material/update', array('id' => $id)));
        $this->assign('action_link', array('text' => RC_Lang::get('wechat::wechat.material_manage'), 'href' => RC_Uri::url('weapp/platform_material/init', array('type' => 'news', 'material' => 1))));
        $this->assign('action', 'article_add');
        $this->assign('warn', 'warn');

        $wechat_type = $this->platformAccount->getType();
        $this->assign('wechat_type', $wechat_type);

        $media_data = RC_DB::table('wechat_media')->where('wechat_id', $wechat_id)->where('id', $parent_id)->first();
        $media_data['file'] = !empty($media_data['file']) ? RC_Upload::upload_url($media_data['file']) : RC_Uri::admin_url('statics/images/nopic.png');
        $article['articles'][0] = $media_data;

        $db_wechat_media = RC_DB::table('wechat_media')->where('wechat_id', $wechat_id);

        $data = $db_wechat_media->where('parent_id', $parent_id)->orderBy('id', 'asc')->get();
        if (!empty($data)) {
            foreach ($data as $k => $v) {
                $article['articles'][$k + 1] = $v;
                if (!empty($v['file'])) {
                    $article['articles'][$k + 1]['file'] = RC_Upload::upload_url($v['file']);
                }
            }
        }

        $this->assign('media_data', $media_data);
        $this->assign('article', $article);
        $this->assign('parent_id', $parent_id);
        $this->assign('id', $id);

        $this->display('weapp_material_edit.dwt');
    }

    /**
     * 更新单篇图文素材
     * @return \Royalcms\Component\HttpKernel\Response|string
     */
    public function update()
    {
        $this->admin_priv('weapp_material_update', ecjia::MSGTYPE_JSON);

        $id = !empty($_GET['id']) ? $_GET['id'] : 0;
        $title = !empty($_POST['title']) ? trim($_POST['title']) : '';
        $author = !empty($_POST['author']) ? trim($_POST['author']) : '';
        $is_show = !empty($_POST['is_show']) ? intval($_POST['is_show']) : 0;
        $digest = !empty($_POST['digest']) ? $_POST['digest'] : '';
        $link = !empty($_POST['link']) ? trim($_POST['link']) : '';
        $content = !empty($_POST['content']) ? stripslashes($_POST['content']) : '';
        $sort = !empty($_POST['sort']) ? intval($_POST['sort']) : 0;
        $index = !empty($_POST['index']) ? intval($_POST['index']) : 0;

        $thumb_media_id = $this->request->input('thumb_media_id');

        if (empty($id)) {
            return $this->showmessage('图文素材ID不存在。', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $wechat_id = $this->platformAccount->getAccountID();

        //更新永久图文素材
        $model = WechatMediaModel::where('wechat_id', $wechat_id)->where('type', 'news')->find($id);
        if (empty($model)) {
            return $this->showmessage('图文素材ID不存在。', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        if (empty($title)) {
            return $this->showmessage(RC_Lang::get('wechat::wechat.enter_images_title'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        if (empty($thumb_media_id)) {
            return $this->showmessage('图文素材的封面图片必须选择一个', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        if (empty($content)) {
            return $this->showmessage(RC_Lang::get('wechat::wechat.enter_main_body'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $thumb_model = WechatMediaModel::where('wechat_id', $wechat_id)->thumbMediaId($thumb_media_id)->first();
        if (empty($thumb_model)) {
            return $this->showmessage('图文素材的封面图片不是一个有效的素材，请更换一个封面素材。', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        try {
            $uuid = $this->platformAccount->getUUID();
            $wechat = with(new Ecjia\App\Weapp\WeappUUID($uuid))->getWechatInstance();

            if ($model->parent_id > 0 && $model->sort != $sort) {
                $parent_model = WechatMediaModel::where('wechat_id', $wechat_id)->find($model->parent_id);
                if (empty($parent_model)) {
                    return $this->showmessage('父图文素材ID不存在。', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                }
                $parent_model->wait_upload_article = 1;
                $parent_model->save();
            }

            $content = $this->uploadMassMessageContentImages($wechat, $content);
            $data = array(
                'title' => $title,
                'author' => $author,
                'is_show' => $is_show,
                'digest' => $digest,
                'content' => $content,
                'link' => $link == 'http://' ? '' : $link,
                'sort' => $sort,
            );

            if ($thumb_model->thumb != $thumb_media_id) {
                $data['thumb'] = $thumb_media_id;
                $data['file'] = $thumb_model->file;
                $data['size'] = $thumb_model->size;
                $data['file_name'] = $thumb_model->file_name;
            }

            if ($model->parent_id > 0) {

                // 更新单篇图文
                $article = new Royalcms\Component\WeChat\Message\Article([
                    'title' => $title,
                    'thumb_media_id' => $thumb_media_id,
                    'author' => $author,
                    'digest' => $digest,
                    'show_cover_pic' => $is_show,
                    'content' => $content,
                    'content_source_url' => $link == 'http://' ? '' : $link,
                ]);
                $msg = $wechat->material->updateArticle($model->parentNews->media_id, $article, $index);
            }

            //更新数据库
            $data['edit_time'] = RC_Time::gmtime();
            $model->update($data);

            $title = RC_DB::table('wechat_media')->where('wechat_id', $wechat_id)->where('id', $id)->pluck('title');
            $this->admin_log($title, 'edit', 'article_material');

            return $this->showmessage(RC_Lang::get('wechat::wechat.edit_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('weapp/platform_material/edit', array('id' => $id))));
        } catch (\Royalcms\Component\WeChat\Core\Exceptions\HttpException $e) {
            return $this->showmessage(\Ecjia\App\Wechat\WechatErrorCodes::getError($e->getCode(), $e->getMessage()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        } catch (\BadMethodCallException $e) {
            return $this->showmessage($e->getMessage(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    /**
     * 添加子图文
     *
     * 第一步，保存进数据库
     * 第二步，删除原有单图文数据
     * 第三步，提交新多图文数据
     */
    public function add_child_article()
    {
        $this->admin_priv('weapp_material_update', ecjia::MSGTYPE_JSON);

        $parent_id = !empty($_GET['parent_id']) ? $_GET['parent_id'] : 0;
        $title = !empty($_POST['title']) ? trim($_POST['title']) : '';
        $author = !empty($_POST['author']) ? trim($_POST['author']) : '';
        $is_show = !empty($_POST['is_show']) ? intval($_POST['is_show']) : 0;
        $digest = !empty($_POST['digest']) ? $_POST['digest'] : '';
        $link = !empty($_POST['link']) ? trim($_POST['link']) : '';
        $content = !empty($_POST['content']) ? stripslashes($_POST['content']) : '';
        $index = !empty($_POST['index']) ? intval($_POST['index']) : 0;
        $sort = $index;

        $thumb_media_id = $this->request->input('thumb_media_id');

        if (empty($parent_id)) {
            return $this->showmessage('父级图文素材ID不存在。', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        if (empty($title)) {
            return $this->showmessage(RC_Lang::get('wechat::wechat.enter_images_title'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        if (empty($thumb_media_id)) {
            return $this->showmessage('图文素材的封面图片必须选择一个', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        if (empty($content)) {
            return $this->showmessage(RC_Lang::get('wechat::wechat.enter_main_body'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $wechat_id = $this->platformAccount->getAccountID();

        $parent_model = WechatMediaModel::where('wechat_id', $wechat_id)->find($parent_id);
        if (empty($parent_model)) {
            return $this->showmessage('父图文素材ID不存在。', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $thumb_model = WechatMediaModel::where('wechat_id', $wechat_id)->thumbMediaId($thumb_media_id)->first();
        if (empty($thumb_model)) {
            return $this->showmessage('图文素材的封面图片不是一个有效的素材，请更换一个封面素材。', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $data = array(
            'wechat_id' => $wechat_id,
            'title' => $title,
            'author' => $author,
            'is_show' => $is_show,
            'digest' => $digest,
            'link' => $link == 'http://' ? '' : $link,
            'content' => $content,
            'sort' => $sort,
            'thumb' => $thumb_media_id,
            'file' => $thumb_model->file,
            'size' => $thumb_model->size,
            'file_name' => $thumb_model->file_name,
            'add_time' => RC_Time::gmtime(),
            'type' => 'news',
            'is_material' => 'material',
            'parent_id' => $parent_id,
        );

        //标记父图文素材等待上传中
        if ($parent_model->wait_upload_article != 1) {
            $parent_model->wait_upload_article = 1;
            $parent_model->save();
        }

        //添加多图文素材
        $id = RC_DB::table('wechat_media')->insertGetId($data);
        $this->admin_log($title, 'add', 'article_material');

        return $this->showmessage(RC_Lang::get('wechat::wechat.add_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('weapp/platform_material/edit', array('id' => $id, 'material' => 1))));
    }

    /**
     * 移除子图文
     */
    public function remove_child_article()
    {
        $this->admin_priv('weapp_material_update', ecjia::MSGTYPE_JSON);

        $id = !empty($_GET['id']) ? $_GET['id'] : 0;

        if (empty($id)) {
            return $this->showmessage('图文素材ID不存在。', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $wechat_id = $this->platformAccount->getAccountID();

        //查找多图文素材
        $model = WechatMediaModel::where('wechat_id', $wechat_id)->where('type', 'news')->find($id);
        if (empty($model)) {
            return $this->showmessage('图文素材ID不存在。', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $parent_model = WechatMediaModel::where('wechat_id', $wechat_id)->where('type', 'news')->find($model->parent_id);
        if (empty($parent_model)) {
            return $this->showmessage('父图文素材ID不存在。', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        //标记父图文素材等待上传中
        if ($parent_model->wait_upload_article != 1) {
            $parent_model->wait_upload_article = 1;
            $parent_model->save();
        }

        $model->delete();

        return $this->showmessage(sprintf("移除%s图文素材成功", $model->title), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('weapp/platform_material/edit', array('id' => $model->parent_id, 'material' => 1))));
    }

    /**
     * 上传多图文素材
     */
    public function upload_multi_articles()
    {
        $this->admin_priv('weapp_material_update', ecjia::MSGTYPE_JSON);

        $id = !empty($_GET['id']) ? $_GET['id'] : 0;

        $wechat_id = $this->platformAccount->getAccountID();

        //查找多图文素材
        $model = WechatMediaModel::where('wechat_id', $wechat_id)->where('parent_id', 0)->find($id);
        if (empty($model)) {
            return $this->showmessage('多图文素材ID不存在。', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        try {
            $uuid = $this->platformAccount->getUUID();
            $wechat = with(new Ecjia\App\Weapp\WeappUUID($uuid))->getWechatInstance();

            $data = WechatMediaModel::where('parent_id', $id)->where('type', 'news')->orderBy('sort', 'asc')->orderBy('id', 'asc')->get();
            if (!empty($data)) {
                $data->prepend($model);

                $articles = $data->map(function ($item) {
                    // 更新单篇图文
                    $article = new Royalcms\Component\WeChat\Message\Article([
                        'title' => $item->title,
                        'thumb_media_id' => $item->thumb,
                        'author' => $item->author,
                        'digest' => $item->digest,
                        'show_cover_pic' => $item->is_show,
                        'content' => $item->content,
                        'content_source_url' => $item->link == 'http://' ? '' : $item->link,
                    ]);

                    return $article;
                });

                $rs = $wechat->material->uploadArticle($articles->all());

                //删除旧的图文消息
                $wechat->material->delete($model->media_id);

                //图文消息的id
                $model->media_id = $rs['media_id'];
                if ($model->wait_upload_article == 1) {
                    $model->wait_upload_article = 0;
                }
                $model->save();

                return $this->showmessage('多图文素材发布成功！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('weapp/platform_material/edit', array('id' => $id))));
            }
        } catch (\Royalcms\Component\WeChat\Core\Exceptions\HttpException $e) {
            return $this->showmessage(\Ecjia\App\Wechat\WechatErrorCodes::getError($e->getCode(), $e->getMessage()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        } catch (\BadMethodCallException $e) {
            return $this->showmessage($e->getMessage(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    //获取素材
    public function get_wechat_article()
    {
        $this->admin_priv('weapp_material_update', ecjia::MSGTYPE_JSON);

        $id = !empty($_GET['id']) ? $_GET['id'] : 0;
        $wechat_id = $this->platformAccount->getAccountID();

        //查找多图文素材
        $model = WechatMediaModel::where('wechat_id', $wechat_id)->where('type', 'news')->find($id);
        if (empty($model)) {
            return $this->showmessage('图文素材ID不存在。', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        try {
            $uuid = $this->platformAccount->getUUID();
            $wechat = with(new Ecjia\App\Weapp\WeappUUID($uuid))->getWechatInstance();

            $rs = $wechat->material->get($model->media_id);

            $data = [
                'item' => [
                    [
                        'media_id' => $model->media_id,
                        'content' => $rs,
                        'update_time' => SYS_TIME,
                    ],
                ],
                'total_count' => 1,
                'item_count' => 1,
            ];

            with(new \Ecjia\App\Wechat\Synchronizes\NewsMaterialStorage($wechat_id, 'news', collect($data), $wechat))->save();

            return $this->showmessage('获取素材成功！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('weapp/platform_material/edit', array('id' => $id))));

        } catch (\Royalcms\Component\WeChat\Core\Exceptions\HttpException $e) {
            return $this->showmessage(\Ecjia\App\Wechat\WechatErrorCodes::getError($e->getCode(), $e->getMessage()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        } catch (\BadMethodCallException $e) {
            return $this->showmessage($e->getMessage(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

    }

    /**
     * 删除图文素材
     */
    public function remove()
    {
        $this->admin_priv('weapp_material_delete', ecjia::MSGTYPE_JSON);

        $id = !empty($_GET['id']) ? intval($_GET['id']) : 0;

        if (empty($id)) {
            return $this->showmessage(RC_Lang::get('wechat::wechat.select_material'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $wechat_id = $this->platformAccount->getAccountID();

        //判断素材是否正在被使用
        $count = Ecjia\App\Wechat\Models\WechatReplyModel::where('wechat_id', $wechat_id)->where('type', 'news')->where('media_id', $id)->count();
        if ($count != 0) {
            return $this->showmessage(RC_Lang::get('wechat::wechat.news_used'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $model = Ecjia\App\Wechat\Models\WechatMediaModel::where('wechat_id', $wechat_id)->where('id', $id)->where('type', 'news')->where('parent_id', 0)->first();
        try {
            if ($model->media_id) {

                $uuid = $this->platformAccount->getUUID();
                $wechat = with(new Ecjia\App\Weapp\WeappUUID($uuid))->getWechatInstance();

                //删除永久素材
                $rs = $wechat->material->delete($model->media_id);
            }

            if (!$model->subNews->isEmpty()) {
                $model->subNews->each(function ($item) {
                    $item->delete();
                    $this->admin_log($item['title'], 'remove', 'article_material');
                    return true;
                });
            }

            $model->delete();

            $this->admin_log($model['title'], 'remove', 'article_material');

            return $this->showmessage(RC_Lang::get('wechat::wechat.remove_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);

        } catch (\Royalcms\Component\WeChat\Core\Exceptions\HttpException $e) {
            return $this->showmessage(\Ecjia\App\Wechat\WechatErrorCodes::getError($e->getCode(), $e->getMessage()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        } catch (\BadMethodCallException $e) {
            return $this->showmessage($e->getMessage(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    /**
     * 添加图片素材
     */
    public function picture_insert()
    {
        $this->admin_priv('weapp_material_add', ecjia::MSGTYPE_JSON);

        $material = $this->request->input('material') ? 1 : 0;

        $upload = RC_Upload::uploader(null, array('save_path' => 'data/material/image', 'auto_sub_dirs' => false));
        $upload->allowed_type(['png', 'jpeg', 'jpg', 'gif']);
        $upload->allowed_mime(['image/png', 'image/jpeg', 'image/gif']);
        $upload->allowed_size('2097152'); //单位是字节[byte],2x1024x1024

        if (!$upload->check_upload_file($_FILES['img_url'])) {
            return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        $image_info = $upload->upload($_FILES['img_url']);
        if (empty($image_info)) {
            return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $file_path = $upload->get_position($image_info);

        try {
            $wechat_id = $this->platformAccount->getAccountID();
            $uuid = $this->platformAccount->getUUID();
            $wechat = with(new Ecjia\App\Weapp\WeappUUID($uuid))->getWechatInstance();

            //永久素材
            if ($material === 1) {
                $rs = $wechat->material->uploadImage(RC_Upload::upload_path($file_path));
            }
            //临时素材
            else {
                $rs = $wechat->material_temporary->uploadImage(RC_Upload::upload_path($file_path));
            }

            $data = array(
                'title' => '',
                'author' => '',
                'is_show' => 0,
                'link' => '',
                'sort' => 0,
                'digest' => '',
                'content' => '',
                'file' => $file_path,
                'type' => 'image',
                'file_name' => $_FILES['img_url']['name'],
                'add_time' => RC_Time::gmtime(),
                'size' => $_FILES['img_url']['size'],
                'wechat_id' => $wechat_id,
            );

            //永久素材有media_url
            if ($material) {
                $data['is_material'] = 'material';
                $data['media_url'] = $rs['url'];
            }

            $data['media_id'] = $rs['media_id'];

            $id = RC_DB::table('wechat_media')->insertGetId($data);

            $this->admin_log($_FILES['img_url']['name'], 'add', 'picture_material');

            return $this->showmessage(RC_Lang::get('wechat::wechat.upload_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('weapp/platform_material/init', array('type' => 'image', 'material' => $material))));

        } catch (\Royalcms\Component\WeChat\Core\Exceptions\HttpException $e) {
            return $this->showmessage(\Ecjia\App\Wechat\WechatErrorCodes::getError($e->getCode(), $e->getMessage()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    /**
     * 删除图片素材
     */
    public function picture_remove()
    {
        $this->admin_priv('weapp_material_delete', ecjia::MSGTYPE_JSON);

        $id = !empty($_GET['id']) ? intval($_GET['id']) : 0;
        if (empty($id)) {
            return $this->showmessage(RC_Lang::get('wechat::wechat.select_material'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $wechat_id = $this->platformAccount->getAccountID();

        //判断素材是否正在被使用
        $count = Ecjia\App\Wechat\Models\WechatReplyModel::where('wechat_id', $wechat_id)->where('media_id', $id)->count();
        if ($count != 0) {
            return $this->showmessage(RC_Lang::get('wechat::wechat.images_beused'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $model = Ecjia\App\Wechat\Models\WechatMediaModel::where('wechat_id', $wechat_id)->where('id', $id)->where('type', 'image')->first();
        try {

            if (!empty($model)) {
                if ($model->is_material == 'material' && ($model->media_id || $model->thumb)) {

                    $uuid = $this->platformAccount->getUUID();
                    $wechat = with(new Ecjia\App\Weapp\WeappUUID($uuid))->getWechatInstance();

                    //删除永久素材
                    $rs = $wechat->material->delete($model->media_id);
                }

                //删除本地图片
                $disk = RC_Storage::disk();
                if (!empty($model['file']) && $disk->exists(RC_Upload::upload_path($model['file']))) {
                    $disk->delete(RC_Upload::upload_path($model['file']));
                }
                Ecjia\App\Wechat\Models\WechatMediaModel::where('wechat_id', $wechat_id)->where('id', $id)->delete();

                $this->admin_log($model['file_name'], 'remove', 'picture_material');
                return $this->showmessage(RC_Lang::get('wechat::wechat.remove_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
            }

            return $this->showmessage('素材ID未找到', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);

        } catch (\Royalcms\Component\WeChat\Core\Exceptions\HttpException $e) {
            return $this->showmessage($e->getMessage(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        } catch (\Error $e) {
            return $this->showmessage($e->getMessage(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    /**
     * 添加缩略图素材
     */
    public function thumb_insert()
    {
        $this->admin_priv('weapp_material_add', ecjia::MSGTYPE_JSON);

        $material = $this->request->input('material') ? 1 : 0;

        $upload = RC_Upload::uploader('file', array('save_path' => 'data/material/thumb', 'auto_sub_dirs' => false));
        $upload->allowed_type(['jpg']);
        $upload->allowed_mime(['image/jpeg']);
        $upload->allowed_size('65536');
        if (!$upload->check_upload_file($_FILES['img_url'])) {
            return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $file_info = $upload->upload($_FILES['img_url']);
        if (empty($file_info)) {
            return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $file_path = $upload->get_position($file_info);

        try {
            $wechat_id = $this->platformAccount->getAccountID();
            $uuid = $this->platformAccount->getUUID();
            $wechat = with(new Ecjia\App\Weapp\WeappUUID($uuid))->getWechatInstance();

            //永久素材
            if ($material) {
                $rs = $wechat->material->uploadThumb(RC_Upload::upload_path($file_path));
            }
            //临时素材
            else {
                $rs = $wechat->material_temporary->uploadThumb(RC_Upload::upload_path($file_path));
            }

            $data = array(
                'title' => '',
                'author' => '',
                'is_show' => 0,
                'link' => '',
                'sort' => 0,
                'digest' => '',
                'content' => '',
                'file' => $file_path,
                'type' => 'thumb',
                'file_name' => $_FILES['img_url']['name'],
                'add_time' => RC_Time::gmtime(),
                'size' => $_FILES['img_url']['size'],
                'wechat_id' => $wechat_id,
            );

            //永久素材处理
            if ($material) {
                $data['is_material'] = 'material';
                $data['media_id'] = $rs['media_id'];
                $data['media_url'] = $rs['url'];
            }
            //临时素材上传获取的是thumb_media_id，特别注意
            else {
                $data['media_id'] = $rs['thumb_media_id'];
            }

            $id = RC_DB::table('wechat_media')->insertGetId($data);

            $this->admin_log($_FILES['img_url']['name'], 'add', 'thumb_material');

            return $this->showmessage(RC_Lang::get('wechat::wechat.upload_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('weapp/platform_material/init', array('type' => 'thumb', 'material' => $material))));

        } catch (\Royalcms\Component\WeChat\Core\Exceptions\HttpException $e) {
            return $this->showmessage(\Ecjia\App\Wechat\WechatErrorCodes::getError($e->getCode(), $e->getMessage()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        } catch (\Royalcms\Component\Database\QueryException $e) {
            return $this->showmessage($e->getMessage(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    /**
     * 删除缩略图素材
     */
    public function thumb_remove()
    {
        $this->admin_priv('weapp_material_delete', ecjia::MSGTYPE_JSON);

        $id = !empty($_GET['id']) ? intval($_GET['id']) : 0;
        if (empty($id)) {
            return $this->showmessage(RC_Lang::get('wechat::wechat.select_material'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $wechat_id = $this->platformAccount->getAccountID();

        //判断素材是否正在被使用
        $count = Ecjia\App\Wechat\Models\WechatReplyModel::where('wechat_id', $wechat_id)->where('media_id', $id)->count();
        if ($count != 0) {
            return $this->showmessage(RC_Lang::get('wechat::wechat.thumb_used'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $model = Ecjia\App\Wechat\Models\WechatMediaModel::where('wechat_id', $wechat_id)->where('id', $id)->where('type', 'thumb')->first();
        try {

            if (!empty($model)) {

                if ($model->is_material == 'material' && $model->media_id) {
                    $uuid = $this->platformAccount->getUUID();
                    $wechat = with(new Ecjia\App\Weapp\WeappUUID($uuid))->getWechatInstance();

                    //删除永久素材
                    $rs = $wechat->material->delete($model->media_id);
                }

                //删除本地缩略图
                $disk = RC_Storage::disk();
                if (!empty($model['file']) && $disk->exists(RC_Upload::upload_path($model['file']))) {
                    $disk->delete(RC_Upload::upload_path($model['file']));
                }
                Ecjia\App\Wechat\Models\WechatMediaModel::where('wechat_id', $wechat_id)->where('id', $id)->delete();

                $this->admin_log($model['file_name'], 'remove', 'thumb_material');
                return $this->showmessage(RC_Lang::get('wechat::wechat.remove_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
            }
        } catch (\Royalcms\Component\WeChat\Core\Exceptions\HttpException $e) {
            return $this->showmessage($e->getMessage(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        } catch (\Error $e) {
            return $this->showmessage($e->getMessage(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    /**
     * 添加语音素材
     */
    public function voice_insert()
    {
        $this->admin_priv('weapp_material_add', ecjia::MSGTYPE_JSON);

        $material = $this->request->input('material') ? 1 : 0;

        $upload = RC_Upload::uploader('file', array('save_path' => 'data/material/voice', 'auto_sub_dirs' => false));
        $upload->allowed_type(['mp3', 'amr']);
        $upload->allowed_mime(['audio/mp3', 'audio/AMR']);
        $upload->allowed_size('2097152');
        if (!$upload->check_upload_file($_FILES['img_url'])) {
            return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $file_info = $upload->upload($_FILES['img_url']);
        if (empty($file_info)) {
            return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $file_path = $upload->get_position($file_info);

        try {
            $wechat_id = $this->platformAccount->getAccountID();
            $uuid = $this->platformAccount->getUUID();
            $wechat = with(new Ecjia\App\Weapp\WeappUUID($uuid))->getWechatInstance();

            //永久素材
            if ($material === 1) {
                $rs = $wechat->material->uploadVoice(RC_Upload::upload_path($file_path));
            }
            //临时素材
            else {
                $rs = $wechat->material_temporary->uploadVoice(RC_Upload::upload_path($file_path));
            }

            $data = array(
                'title' => '',
                'author' => '',
                'is_show' => 0,
                'link' => '',
                'sort' => 0,
                'digest' => '',
                'content' => '',
                'file' => $file_path,
                'type' => 'voice',
                'file_name' => $_FILES['img_url']['name'],
                'add_time' => RC_Time::gmtime(),
                'size' => $_FILES['img_url']['size'],
                'wechat_id' => $wechat_id,
            );

            //永久素材处理
            if ($material) {
                $data['is_material'] = 'material';
            }

            $data['media_id'] = $rs['media_id'];

            $id = RC_DB::table('wechat_media')->insertGetId($data);

            $this->admin_log($_FILES['img_url']['name'], 'add', 'voice_material');

            return $this->showmessage(RC_Lang::get('wechat::wechat.upload_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('weapp/platform_material/init', array('type' => 'voice', 'material' => $material))));

        } catch (\Royalcms\Component\WeChat\Core\Exceptions\HttpException $e) {
            return $this->showmessage(\Ecjia\App\Wechat\WechatErrorCodes::getError($e->getCode(), $e->getMessage()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    /**
     * 删除语音素材
     */
    public function voice_remove()
    {
        $this->admin_priv('weapp_material_delete', ecjia::MSGTYPE_JSON);

        $id = !empty($_GET['id']) ? intval($_GET['id']) : 0;
        if (empty($id)) {
            return $this->showmessage(RC_Lang::get('wechat::wechat.select_material'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $wechat_id = $this->platformAccount->getAccountID();

        //判断素材是否正在被使用
        $count = Ecjia\App\Wechat\Models\WechatReplyModel::where('wechat_id', $wechat_id)->where('media_id', $id)->count();
        if ($count != 0) {
            return $this->showmessage(RC_Lang::get('wechat::wechat.voice_used'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $model = Ecjia\App\Wechat\Models\WechatMediaModel::where('wechat_id', $wechat_id)->where('id', $id)->where('type', 'voice')->first();
        try {

            if (!empty($model)) {

                if ($model->is_material == 'material' && $model->media_id) {
                    $uuid = $this->platformAccount->getUUID();
                    $wechat = with(new Ecjia\App\Weapp\WeappUUID($uuid))->getWechatInstance();

                    //删除永久素材
                    $rs = $wechat->material->delete($model->media_id);
                }

                //删除本地语音
                $disk = RC_Storage::disk();
                if (!empty($model['file']) && $disk->exists(RC_Upload::upload_path($model['file']))) {
                    $disk->delete(RC_Upload::upload_path($model['file']));
                }
                Ecjia\App\Wechat\Models\WechatMediaModel::where('wechat_id', $wechat_id)->where('id', $id)->delete();

                $this->admin_log($model['file_name'], 'remove', 'voice_material');
                return $this->showmessage(RC_Lang::get('wechat::wechat.remove_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);

            }
        } catch (\Royalcms\Component\WeChat\Core\Exceptions\HttpException $e) {
            return $this->showmessage($e->getMessage(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        } catch (\Error $e) {
            return $this->showmessage($e->getMessage(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    /**
     * 添加视频素材
     */
    public function video_add()
    {
        $this->admin_priv('weapp_material_add');

        $material = $this->request->input('material') ? 1 : 0;

        $nav_here = RC_Lang::get('wechat::wechat.forever_material');
        if ($material != 1) {
            $nav_here = RC_Lang::get('wechat::wechat.provisional_material');
        }

        ecjia_platform_screen::get_current_screen()->remove_last_nav_here();
        ecjia_platform_screen::get_current_screen()->add_nav_here(new admin_nav_here($nav_here, RC_Uri::url('weapp/platform_material/init', array('type' => 'video', 'material' => $material))));
        ecjia_platform_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.add_video')));
        ecjia_platform_screen::get_current_screen()->set_help_sidebar(
            '<p>视频（video）素材大小：10MB，支持MP4格式。</p>' .
            '<p>建议直接使用优酷等第三方视频网站的视频地址。优点:不占用服务器资源，支持更大、更多格式的视频素材。</p>'
        );

        $this->assign('ur_here', RC_Lang::get('wechat::wechat.add_video'));
        $this->assign('action_link', array('text' => RC_Lang::get('wechat::wechat.material_manage'), 'href' => RC_Uri::url('weapp/platform_material/init', array('type' => 'video', 'material' => $material))));
        $this->assign('form_action', RC_Uri::url('weapp/platform_material/video_insert', array('material' => $material)));
        $this->assign('action', 'video_add');
        $this->assign('button_type', 'add');

        $this->assign('warn', 'warn');

        $wechat_type = $this->platformAccount->getType();

        $this->assign('wechat_type', $wechat_type);
        $this->assign('material', $material);

        $this->display('weapp_material_add.dwt');
    }

    /**
     * 保存视频素材
     */
    public function video_insert()
    {
        $this->admin_priv('weapp_material_add', ecjia::MSGTYPE_JSON);

        $wechat_id = $this->platformAccount->getAccountID();

        $material = $this->request->input('material') ? 1 : 0;
        $title = $this->request->input('video_title');
        $digest = $this->request->input('video_digest');

        if (empty($title)) {
            return $this->showmessage(RC_Lang::get('wechat::wechat.enter_title'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        if ($material == 1) {
            if (empty($digest)) {
                return $this->showmessage(RC_Lang::get('wechat::wechat.video_intro'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
        }
        if (empty($_FILES['video'])) {
            return $this->showmessage(RC_Lang::get('wechat::wechat.upload_viedo'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $upload = RC_Upload::uploader('file', array('save_path' => 'data/material/video', 'auto_sub_dirs' => false));
        $upload->allowed_type('mp4');
        $upload->allowed_mime('video/mp4');
        $upload->allowed_size('10485760');

        if (!$upload->check_upload_file($_FILES['video'])) {
            return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $file_info = $upload->upload($_FILES['video']);
        if (empty($file_info)) {
            return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $file_path = $upload->get_position($file_info);

        try {

            $uuid = $this->platformAccount->getUUID();
            $wechat = with(new Ecjia\App\Weapp\WeappUUID($uuid))->getWechatInstance();

            //永久素材
            if ($material === 1) {
                $rs = $wechat->material->uploadVideo(RC_Upload::upload_path($file_path), $title, $digest);
            }
            //临时素材
            else {
                $rs = $wechat->material_temporary->uploadVideo(RC_Upload::upload_path($file_path));
            }

            $data = array(
                'title' => $title,
                'digest' => $digest,
                'is_show' => 0,
                'file' => $file_path,
                'file_name' => $_FILES['video']['name'],
                'add_time' => RC_Time::gmtime(),
                'type' => 'video',
                'size' => $_FILES['video']['size'],
                'wechat_id' => $wechat_id,
            );

            //永久素材
            if ($material) {
                $data['is_material'] = 'material';
            }

            $data['media_id'] = $rs['media_id'];

            $id = RC_DB::table('wechat_media')->insertGetId($data);

            $this->admin_log($title, 'add', 'video_material');

            if ($id) {
                $links[] = array('text' => RC_Lang::get('wechat::wechat.return_material_manage'), 'href' => RC_Uri::url('weapp/platform_material/init', array('type' => 'video', 'material' => $material)));
                $links[] = array('text' => RC_Lang::get('wechat::wechat.continue_add_video'), 'href' => RC_Uri::url('weapp/platform_material/video_add', array('material' => $material)));
                return $this->showmessage(RC_Lang::get('wechat::wechat.add_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links, 'pjaxurl' => RC_Uri::url('weapp/platform_material/init', array('type' => 'video', 'material' => $material))));
            } else {
                return $this->showmessage(RC_Lang::get('wechat::wechat.add_failed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

        } catch (\Royalcms\Component\WeChat\Core\Exceptions\HttpException $e) {
            return $this->showmessage(\Ecjia\App\Wechat\WechatErrorCodes::getError($e->getCode(), $e->getMessage()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        } catch (\Error $e) {
            return $this->showmessage($e->getMessage(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    /**
     * 删除视频素材
     */
    public function video_remove()
    {
        $this->admin_priv('weapp_material_delete', ecjia::MSGTYPE_JSON);

        $id = !empty($_GET['id']) ? intval($_GET['id']) : 0;
        if (empty($id)) {
            return $this->showmessage(RC_Lang::get('wechat::wechat.select_material'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $uuid = $this->platformAccount->getUUID();
        $wechat = with(new Ecjia\App\Weapp\WeappUUID($uuid))->getWechatInstance();

        $wechat_id = $this->platformAccount->getAccountID();

        //判断素材是否正在被使用
        $count = Ecjia\App\Wechat\Models\WechatReplyModel::where('wechat_id', $wechat_id)->where('media_id', $id)->count();
        if ($count != 0) {
            return $this->showmessage(RC_Lang::get('wechat::wechat.video_used'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $model = Ecjia\App\Wechat\Models\WechatMediaModel::where('wechat_id', $wechat_id)->where('id', $id)->where('type', 'video')->first();
        try {
            if (!empty($model)) {
                if ($model->is_material == 'material' && $model->media_id) {
                    //删除永久素材
                    $rs = $wechat->material->delete($model->media_id);
                }

                //删除本地视频
                $disk = RC_Storage::disk();
                if (!empty($model['file']) && $disk->exists(RC_Upload::upload_path($model['file']))) {
                    $disk->delete(RC_Upload::upload_path($model['file']));
                }
                Ecjia\App\Wechat\Models\WechatMediaModel::where('wechat_id', $wechat_id)->where('id', $id)->delete();

                $this->admin_log($model['title'], 'remove', 'video_material');
                return $this->showmessage(RC_Lang::get('wechat::wechat.remove_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);

            }
        } catch (\Royalcms\Component\WeChat\Core\Exceptions\HttpException $e) {
            return $this->showmessage(\Ecjia\App\Wechat\WechatErrorCodes::getError($e->getCode(), $e->getMessage()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    /**
     * 获取素材
     */
    public function get_material()
    {
        $this->admin_priv('weapp_material_update', ecjia::MSGTYPE_JSON);

        set_time_limit(0);

        $type = $this->request->query('type', 'news');
        $page = $this->request->query('page', '1');

        $wechat_id = $this->platformAccount->getAccountID();

        try {
            $uuid = $this->platformAccount->getUUID();
            $wechat = with(new Ecjia\App\Weapp\WeappUUID($uuid))->getWechatInstance();

            //图文素材数据量比较大，容易超时，每次同步10条
            if ($type == 'news') {
                $pagesize = 10;
            } else {
                $pagesize = 20;
            }

            $start = $pagesize * ($page - 1);
            $get_count = $pagesize * $page;

            $rs = $wechat->material->lists($type, $start, $pagesize);
            $count = $rs['item_count'];

            //最后一页，直接返回结束
            if ($count == 0) {
                return $this->showmessage('获取完成', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('weapp/platform_material/init', array('type' => $type, 'material' => 1))));
            } else {
                //还有下一页
                $page++;
            }

            with(new \Ecjia\App\Wechat\Synchronizes\MaterialStorage($wechat_id, $type, $rs, $wechat))->save();

            //返回成功提示，继续请求下一条
            return $this->showmessage('已获取' . $get_count . '条素材', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => RC_Uri::url('weapp/platform_material/get_material', array('type' => $type)), 'page' => $page));

        } catch (\Royalcms\Component\WeChat\Core\Exceptions\HttpException $e) {
            return $this->showmessage(\Ecjia\App\Wechat\WechatErrorCodes::getError($e->getCode(), $e->getMessage()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        } catch (\InvalidArgumentException $e) {
            return $this->showmessage($e->getMessage(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        } catch (\GuzzleHttp\Exception\ConnectException $e) {
            return $this->showmessage($e->getMessage(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

    }

    /**
     * 编辑素材名称或文件名称
     */
    public function edit_file_name()
    {
        $this->admin_priv('weapp_material_update', ecjia::MSGTYPE_JSON);

        $wechat_id = $this->platformAccount->getAccountID();

        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $val = isset($_GET['val']) ? $_GET['val'] : '';
        $type = isset($_GET['type']) ? $_GET['type'] : '';
        if ($type == 'voice' || $type == 'picture') {
            if (empty($val)) {
                return $this->showmessage(RC_Lang::get('wechat::wechat.enter_filename'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            RC_DB::table('wechat_media')->where('wechat_id', $wechat_id)->where('id', $id)->update(array('file_name' => $val));
            if ($type == 'voice') {
                $this->admin_log($val, 'edit', 'voice_material');
            } elseif ($type == 'picture') {
                $this->admin_log($val, 'edit', 'picture_material');
            }
        } else {
            if (empty($val)) {
                return $this->showmessage(RC_Lang::get('wechat::wechat.enter_title'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            RC_DB::table('wechat_media')->where('wechat_id', $wechat_id)->where('id', $id)->update(array('title' => $val));

            $this->admin_log($val, 'edit', 'article_material');
        }
        return $this->showmessage(RC_Lang::get('wechat::wechat.edit_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
    }

    public function search()
    {

        $wechat_id = $this->platformAccount->getAccountID();

        $keyword = !empty($_POST['keyword']) ? trim($_POST['keyword']) : '';
        $arr = RC_DB::table('wechat_media')
            ->select('id', 'file')
            ->where('wechat_id', $wechat_id)
            ->where('type', 'news')
            ->where('title', 'like', "%" . mysql_like_quote($keyword) . "%")
            ->get();

        if (empty($arr)) {
            $arr = array(0 => array(
                'id' => 0,
                'file' => RC_Lang::get('wechat::wechat.nosearch_record'),
            ));
        } else {
            foreach ($arr as $key => $item) {
                if (!empty($item['file'])) {
                    $arr[$key]['file'] = RC_Upload::upload_url($item['file']);
                }
            }
        }
        return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $arr));
    }

    public function choose_material()
    {
        $wechat_id = $this->platformAccount->getAccountID();

        $material = !empty($_GET['material']) ? 'material' : null;
        $type = !empty($_POST['type']) ? trim($_POST['type']) : '';

        $wechat_media_model = Ecjia\App\Wechat\Models\WechatMediaModel::where('wechat_id', $wechat_id)->where('type', $type);
        $size = 18;
        if ($type == 'news') {
            $size = 8;
            $wechat_media_model->where('parent_id', 0)->where('wait_upload_article', 0);
        }
        $wechat_media_model->where('is_material', $material);

        $count = $wechat_media_model->count();
        $page = new ecjia_platform_page($count, $size, 5);
        $data = $wechat_media_model->select('*')->take($size)->skip($page->start_id - 1)->orderBy('edit_time', 'desc')->orderBy('add_time', 'desc')->orderBy('id', 'desc')->get();

        $newData = $data->map(function ($item) {
            $item->add_time = RC_Time::local_date(RC_Lang::get('wechat::wechat.date_nj'), $item->add_time);
            if (empty($item->file)) {
                $item->file = RC_Uri::admin_url('statics/images/nopic.png');
            } else {
                if ($item->type == 'voice') {
                    $item->thumb = RC_App::apps_url('statics/images/voice.png', __FILE__);
                    $item->file = RC_Upload::upload_url($item->file);
                } elseif ($item->type == 'video') {
                    $item->thumb = RC_App::apps_url('statics/images/video.png', __FILE__);
                    $item->file = RC_Upload::upload_url($item->file);
                } else {
                    $item->file = RC_Upload::upload_url($item->file);
                }
            }
            $content = !empty($item->digest) ? strip_tags(Ecjia\App\Weapp\Helper::html_out($item->digest)) : strip_tags(Ecjia\App\Weapp\Helper::html_out($item->content));
            if (strlen($content) > 100) {
                $item->content = Ecjia\App\Weapp\Helper::msubstr($content, 100);
            } else {
                $item->content = $content;
            }
            $newItem = $item->toArray();
            if ($item->type == 'news') {
                $subNews = $item->subNews;
                if (!$subNews->isEmpty()) {
                    $newSubNews = $subNews->map(function ($item) {
                        if (empty($item->file)) {
                            $item->file = RC_Uri::admin_url('statics/images/nopic.png');
                        } else {
                            $item->file = RC_Upload::upload_url($item->file);
                        }
                        return [
                            'id' => $item->id,
                            'title' => $item->title,
                            'file' => $item->file,
                            'file_name' => $item->file_name,
                        ];
                    });
                    $newItem['articles'] = $newSubNews->all();
                }
            }
            return $newItem;
        });

        if (is_ecjia_error($wechat_id)) {
            $this->assign('errormsg', RC_Lang::get('wechat::wechat.operate_before_pub'));
        }
        $wechat_type = $this->platformAccount->getType();
        $this->assign('wechat_type', $wechat_type);

        $list = $newData->all();
        $this->assign('list', $list);
        $this->assign('type', $type);

        $title = sprintf(RC_Lang::get('wechat::wechat.material_type_title'), RC_Lang::get('wechat::wechat.' . $type));
        $data = $this->fetch('library/weapp_choose_material_list.lbi');

        return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('data' => $data, 'title' => $title, 'page' => $page->show(5)));
    }

    public function get_material_info()
    {
        $wechat_id = $this->platformAccount->getAccountID();

        $id = intval($_GET['id']);
        $info = RC_DB::table('wechat_media')->where('wechat_id', $wechat_id)->where('id', $id)->first();

        $info['type'] = isset($info['type']) ? $info['type'] : '';
        if (empty($info['file']) || $info['type'] == 'voice' || $info['type'] == 'video') {
            if (empty($info['file'])) {
                $info['file'] = RC_Uri::admin_url('statics/images/nopic.png');
            } elseif ($info['type'] == 'voice') {
                $info['file'] = RC_App::apps_url('statics/images/voice.png', __FILE__);
            } elseif ($info['type'] == 'video') {
                $info['file'] = RC_App::apps_url('statics/images/video.png', __FILE__);
            }
        } else {
            $info['file'] = RC_Upload::upload_url($info['file']);
        }
        $info['href'] = RC_Uri::url('weapp/platform_material/remove_file', array('id' => $id));
        return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $info));
    }

    /**
     * 获取所有素材列表
     */
    private function get_all_material()
    {
        $material = !empty($_GET['material']) ? 'material' : '';

        $wechat_id = $this->platformAccount->getAccountID();

        if ($material) {
            $type = $this->request->query('type', 'news');
        } else {
            $type = $this->request->query('type', 'image');
        }
        $filter['type'] = $type;

        $wechat_media_model = Ecjia\App\Wechat\Models\WechatMediaModel::where('wechat_id', $wechat_id);

        $pageSize = 15;
        if ($type == 'image') {
            $wechat_media_model->where('type', 'image');
        } elseif ($type == 'news') {
            $pageSize = 12;
            $wechat_media_model->where('type', 'news')->where('parent_id', 0);
        } else {
            $wechat_media_model->where('type', $type);
        }

        $wechat_media_model->where('is_material', $material);

        $sumdata = Ecjia\App\Wechat\Models\WechatMediaModel::select(
            RC_DB::raw("SUM(type = 'news' and parent_id = 0) AS news"),
            RC_DB::raw("SUM(type = 'image') AS image"),
            RC_DB::raw("SUM(type = 'voice') AS voice"),
            RC_DB::raw("SUM(type = 'video') AS video"),
            RC_DB::raw("SUM(type = 'thumb') AS thumb")
        )->where('wechat_id', $wechat_id)
            ->where('is_material', $material)
            ->first();
        if (!empty($sumdata)) {
            $filter['count'] = $sumdata->toArray();
        }

        $count = $sumdata->$type;
        $page = new ecjia_platform_page($count, $pageSize, 5);
        $data = $wechat_media_model->orderBy('sort', 'asc')->orderBy('edit_time', 'desc')->orderBy('add_time', 'desc')->orderBy('id', 'desc')->take($pageSize)->skip($page->start_id - 1)->get();

        $newData = $data->map(function ($item) {
            $item->add_time = RC_Time::local_date(RC_Lang::get('wechat::wechat.date_nj'), $item->add_time);

            if (empty($item->file)) {

                $item->file = RC_Uri::admin_url('statics/images/nopic.png');

            } else {

                if ($item->type == 'voice') {

                    $item->thumb = RC_App::apps_url('statics/images/voice.png', __FILE__);
                    $item->file = RC_Upload::upload_url($item->file);

                } elseif ($item->type == 'video') {

                    $item->thumb = RC_App::apps_url('statics/images/video.png', __FILE__);
                    $item->file = RC_Upload::upload_url($item->file);

                } else {

                    $item->file = RC_Upload::upload_url($item->file);

                }

            }

            $content = !empty($item->digest) ? strip_tags(Ecjia\App\Weapp\Helper::html_out($item->digest)) : strip_tags(Ecjia\App\Weapp\Helper::html_out($item->content));

            if (strlen($content) > 100) {
                $item->content = Ecjia\App\Weapp\Helper::msubstr($content, 100);
            } else {
                $item->content = $content;
            }
            $newItem = $item->toArray();

            if ($item->type == 'news') {
                $subNews = $item->subNews;
                if (!$subNews->isEmpty()) {
                    $newSubNews = $subNews->map(function ($item) {
                        if (empty($item->file)) {
                            $item->file = RC_Uri::admin_url('statics/images/nopic.png');
                        } else {
                            $item->file = RC_Upload::upload_url($item->file);
                        }
                        return [
                            'id' => $item->id,
                            'title' => $item->title,
                            'file' => $item->file,
                            'file_name' => $item->file_name,
                        ];
                    });
                    $newItem['articles'] = $newSubNews->all();
                }
            }
            return $newItem;
        });

        $arr = array('item' => $newData->all(), 'desc' => $page->page_desc(), 'page' => $page->show(5), 'filter' => $filter);
        return $arr;
    }

    /**
     * 获取多图文信息
     */
    private function get_article_list($id)
    {
        $db_wechat_media = RC_DB::table('wechat_media');
        if ($id) {
            $db_wechat_media->where('type', 'news')->where('parent_id', $id)->orWhere('id', $id);
        }
        $data = $db_wechat_media->orderBy('id', 'asc')->get();
        return $data;
    }

    /**
     * 群发消息 内容上传图片（不是封面上传）
     * @param  string $content
     * @return
     */
    private function uploadMassMessageContentImages($wechat, $content)
    {

        $content = Ecjia\App\Weapp\Helper::html_out($content);
        $pattern = "/<[img|IMG].*?src=[\'|\"](.*?(?:[\.gif|\.jpg|\.png|\.bmp|\.jpeg]))[\'|\"].*?[\/]?>/";
        preg_match_all($pattern, $content, $match);

        $images = $match[1];

        if (count($images) > 0) {
            foreach ($images as $img) {
                if (strpos($img, RC_Upload::upload_url()) !== false) {

                    $filename = str_replace(RC_Upload::upload_url(), rtrim(RC_Upload::upload_path(), '/'), $img);
                    $rs = $wechat->material->uploadArticleImage($filename);

                    $replace = $rs['url']; // http://mmbiz.qpic.cn/mmbiz/gLO17UPS6FS2xsypf378iaNhWacZ1G1UplZYWEYfwvuU6Ont96b1roYs CNFwaRrSaKTPCUdBK9DgEHicsKwWCBRQ/0
                    $content = str_replace($img, $replace, $content);
                }
            }
        }
        return $content;
    }
}

//end
