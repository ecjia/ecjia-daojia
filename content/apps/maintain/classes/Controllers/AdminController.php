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
namespace Ecjia\App\Maintain\Controllers;

use admin_nav_here;
use ecjia;
use Ecjia\App\Maintain\MaintainPlugin;
use Ecjia\App\Maintain\EventFactory\EventFactory;
use ecjia_screen;
use RC_App;
use RC_Script;
use RC_Style;
use RC_Uri;
use Royalcms\Component\App\Exceptions\FileNotFoundException;


class AdminController extends AdminBase
{
    public function __construct()
    {
        parent::__construct();

        RC_Style::enqueue_style('chosen');
        RC_Style::enqueue_style('uniform-aristo');
        RC_Script::enqueue_script('jquery-chosen');
        RC_Script::enqueue_script('jquery-uniform');
        RC_Script::enqueue_script('jquery-validate');
        RC_Script::enqueue_script('jquery-form');
        RC_Script::enqueue_script('smoke');
        RC_Script::enqueue_script('jquery-dataTables-bootstrap');

        RC_Style::enqueue_style('jquery-stepy');

        /*加载自定义JS和CSS*/
        RC_Style::enqueue_style('maintain', RC_App::apps_url('statics/css/maintain.css', $this->__FILE__), array(), false, false);
        RC_Script::enqueue_script('maintain', RC_App::apps_url('statics/js/maintain.js', $this->__FILE__), array(), false, 1);
        RC_Script::localize_script('maintain', 'js_lang_maintain', config('app-maintain::jslang.maintain_page'));

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('运维工具', 'maintain'), RC_Uri::url('maintain/admin/init')));
        ecjia_screen::get_current_screen()->set_parentage('maintain', 'maintain/admin');
    }


    /**
     * 工具列表页面加载
     */
    public function init()
    {
        $this->admin_priv('maintain_manage');

        ecjia_screen::get_current_screen()->remove_last_nav_here();
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('运维工具', 'maintain')));
        $this->assign('ur_here', __('运维工具', 'maintain'));

        $data = $this->maintain_list();
        $this->assign('data', $data);

        return $this->display('maintain_list.dwt');
    }

    /**
     * 工具列表页面加载
     */
    public function run()
    {
        $this->admin_priv('maintain_manage');

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('运行', 'maintain')));
        $this->assign('ur_here', __('运行', 'maintain'));
        $this->assign('action_link', array('text' => __('运维工具', 'maintain'), 'href' => RC_Uri::url('maintain/admin/init')));
        $code = trim($_GET['code']);
        if (!empty($code)) {
            try {
                $factory               = new EventFactory();
                $maintain              = $factory->command($code);
                $config['code']        = $maintain->getCode();
                $config['name']        = $maintain->getName();
                $config['description'] = $maintain->getDescription();
            } catch (FileNotFoundException $exception) {
                $plugin = (new MaintainPlugin())->getPluginInfo($code);
                $config['code']        = $plugin['code'];
                $config['name']        = $plugin['format_name'];
                $config['description'] = $plugin['format_description'];
            }

            $this->assign('config', $config);
        }

        return $this->display('maintain_run.dwt');
    }

    /**
     * 执行运行
     */
    public function command_run()
    {
        try {
            $this->admin_priv('maintain_manage');

            $code = trim($_GET['code']);
            if (empty($code)) {
                return $this->showmessage(__('参数缺少', 'maintain'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

            //提前加载插件
            try {
                $plugin = (new MaintainPlugin())->channel($code);
                $plugin->handle();
            } catch (\Exception $exception) {
                ecjia_log_error($exception);
            }

            $factory  = new EventFactory();
            $maintain = $factory->command($code);
            $result   = $maintain->run();

            if (is_ecjia_error($result)) {
                return $this->showmessage($result->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('pjaxurl' => RC_Uri::url('maintain/admin/run', array('code' => $code))));
            }

            if ($result instanceof \Ecjia\App\Maintain\CommandOutput) {
                $message = $result->getMessage();
            } else {
                $message = __('运行成功', 'maintain');
            }

            return $this->showmessage($message, ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('maintain/admin/run', array('code' => $code))));

        } catch (\Exception $e) {
            return $this->showmessage($e->getMessage(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        } catch (\Error $e) {
            return $this->showmessage($e->getMessage(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }


    /**
     * 获取工具信息
     */
    private function maintain_list()
    {
        $maintain_list = array();

        $factory       = new EventFactory();
        $maintain_data = $factory->getCommands();
        foreach ($maintain_data as $k => $event) {
            $maintain_list[$k]['code']        = $event->getCode();
            $maintain_list[$k]['name']        = $event->getName();
            $maintain_list[$k]['description'] = $event->getDescription();
            $maintain_list[$k]['icon']        = $event->getIcon();
        }

        $plugins = (new MaintainPlugin())->availablePluginList();

        foreach ($plugins as $plugin) {
            $code = $plugin['code'];
            $maintain_list[$code]['code']        = $plugin['code'];
            $maintain_list[$code]['name']        = $plugin['format_name'];
            $maintain_list[$code]['description'] = $plugin['format_description'];
            $maintain_list[$code]['icon']        = null;
        }

        return $maintain_list;
    }

}

//end