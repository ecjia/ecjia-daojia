<?php


namespace Ecjia\App\Installer\Controllers;


use Ecjia\App\Installer\Subscribers\FrontHookSubscriber;
use Ecjia\Component\BrowserEvent\PageScriptPrint;
use Ecjia\System\BaseController\SimpleController;
use RC_App;
use RC_Hook;
use RC_Script;
use RC_Style;
use RC_Uri;

abstract class BaseControllerAbstract extends SimpleController
{

    protected $__FILE__;

    public function __construct()
    {
        $this->__FILE__ = dirname(dirname(__FILE__));

        parent::__construct();

        /* js与css加载路径*/
        $this->assign('system_statics_url', RC_Uri::system_static_url());
        $this->assign('front_url', RC_App::apps_url('statics/front', $this->__FILE__));
        $this->assign('logo_pic', RC_App::apps_url('statics/front/images/logo_pic.png', $this->__FILE__));

        $this->assign('version', config('release.version'));
        $this->assign('build', config('release.build'));

        //模板引擎设置
        $this->view->caching = 0;
        $this->view->cache_lifetime = 0;
        $this->view->debugging = true;
        $this->view->force_compile = true;

    }

    protected function load_hooks()
    {
        parent::load_hooks();

        //单独加载安装器的hooker
        royalcms('Royalcms\Component\Hook\Dispatcher')->subscribe(FrontHookSubscriber::class);
    }

    /**
     * 直接跳转，返回Response对象
     *
     * @param string $url
     * @param int $code
     */
    public function redirect($url, $code = 302)
    {
        return redirect($url, $code);
    }


    protected function load_default_script_style()
    {
        //自定义加载
        RC_Style::enqueue_style('installer-normalize', RC_App::apps_url('statics/front/css/normalize.css', $this->__FILE__));
        RC_Style::enqueue_style('installer-grid', RC_App::apps_url('statics/front/css/grid.css', $this->__FILE__));
        RC_Style::enqueue_style('installer-style', RC_App::apps_url('statics/front/css/style.css', $this->__FILE__));

        //系统加载样式
        RC_Style::enqueue_style('ecjia-ui');
        RC_Style::enqueue_style('install-bootstrap', RC_App::apps_url('statics/front/css/bootstrap.min.css', $this->__FILE__));
        RC_Style::enqueue_style('bootstrap-responsive-nodeps');
        RC_Style::enqueue_style('chosen');
        RC_Style::enqueue_style('uniform-aristo');
        RC_Style::enqueue_style('fontello');

        //系统加载脚本
        RC_Script::enqueue_script('ecjia-jquery-chosen');
        RC_Script::enqueue_script('jquery-migrate');
//        RC_Script::enqueue_script('jquery-form');
        RC_Script::enqueue_script('jquery-uniform');
        RC_Script::enqueue_script('smoke');
        RC_Script::enqueue_script('jquery-cookie');

        RC_Script::enqueue_script('ecjia-installer', RC_App::apps_url('statics/front/js/install.js', $this->__FILE__), array('ecjia-front'), false, true);
        RC_Script::localize_script('ecjia-installer', 'js_lang', config('app-installer::jslang.installer_page'));
    }

    public function loadPageScript($page)
    {
        RC_Hook::add_action( 'front_print_footer_scripts',	array(new PageScriptPrint($page), 'printFooterScripts'), 30 );
    }

}