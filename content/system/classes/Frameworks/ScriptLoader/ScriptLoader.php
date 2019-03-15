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

/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-03-06
 * Time: 17:26
 */

namespace Ecjia\System\Frameworks\ScriptLoader;


use Ecjia\System\Frameworks\Contracts\ScriptLoaderInterface;
use Royalcms\Component\Script\HandleScripts;
use RC_Uri;
use RC_Hook;

/**
 * ecjia scripts and styles default loader.
 *
 * Several constants are used to manage the loading, concatenating and compression of scripts and CSS:
 * define('SCRIPT_DEBUG', true); loads the development (non-minified) versions of all scripts and CSS, and disables compression and concatenation,
 * define('CONCATENATE_SCRIPTS', false); disables compression and concatenation of scripts and CSS,
 * define('COMPRESS_SCRIPTS', false); disables compression of scripts,
 * define('COMPRESS_CSS', false); disables compression of CSS,
 * define('ENFORCE_GZIP', true); forces gzip for compression (default is deflate).
 *
 * The globals $concatenate_scripts, $compress_scripts and $compress_css can be set by plugins
 * to temporarily override the above settings. Also a compression test is run once and the result is saved
 * as option 'can_compress_scripts' (0/1). The test will run again if that option is deleted.
 *
 * @package ecjia
 */
class ScriptLoader implements ScriptLoaderInterface
{

    /**
     * @var HandleScripts
     */
    protected $scripts;

    protected $concatenate_scripts;

    protected $compress_scripts;

    /**
     * ScriptLoader constructor.
     * @param $scripts
     */
    public function __construct(HandleScripts $scripts)
    {
        $this->scripts = $scripts;

        $this->scripts->base_url = RC_Uri::system_static_url();
        $this->scripts->content_url = RC_Uri::system_static_url();
        $this->scripts->default_version = \ecjia::VERSION;
        $this->scripts->default_dirs = array('/');

        $this->default_scripts();
        $this->script_concat_settings();
    }

    /**
     * Register all ECJia scripts.
     *
     * Localizes some of them.
     * args order: $scripts->add( 'handle', 'url', 'dependencies', 'query-string', 1 );
     * when last arg === 1 queues the script for the footer
     *
     * @since 1.0.0
     *
     * @param object $scripts WP_Scripts object.
     */
    protected function default_scripts()
    {
        $develop_src = false !== strpos( \ecjia::VERSION, '-src' );

        if ( ! config('system.script_debug') ) {
            $suffix = '.min';
        } else {
            $suffix = '';
        }

        $dev_suffix = $develop_src ? '' : '.min';

        // 添加 ecjia-js
        $this->scripts->add( 'ecjia', 				    '/lib/ecjia-js/ecjia.js', array('jquery') );
        $this->scripts->add( 'ecjia-region', 			'/lib/ecjia-js/ecjia.region.js', array('ecjia') );
        $this->scripts->add( 'ecjia-ui', 				'/lib/ecjia-js/ecjia.ui.js', array('ecjia') );
        $this->scripts->add( 'ecjia-utils', 			'/lib/ecjia-js/ecjia.utils.js', array('ecjia') );

        // 添加jquery
        $this->scripts->add( 'jquery', 				    "/js/jquery$suffix.js", array(), '2.1.0' );
        $this->scripts->add( 'jquery-pjax', 			"/js/jquery-pjax.js", array('jquery') );
        $this->scripts->add( 'jquery-peity', 			"/js/jquery-peity$suffix.js", array('jquery'), '0.6.0', 1  );
        $this->scripts->add( 'jquery-mockjax', 		    "/js/jquery-mockjax$suffix.js", array('jquery'), '1.5.1', 1 );
        $this->scripts->add( 'jquery-wookmark', 		"/js/jquery-wookmark$suffix.js", array('jquery'), false, 1 );
        $this->scripts->add( 'jquery-migrate', 		    "/js/jquery-migrate$suffix.js", array('jquery'), '1.0.0', 1 );
        $this->scripts->add( 'jquery-cookie', 		    "/js/jquery-cookie$suffix.js", array('jquery'), true, 1 );
        $this->scripts->add( 'jquery-actual', 		    "/js/jquery-actual$suffix.js", array('jquery'), '1.0.6', 1 );
        $this->scripts->add( 'jquery-debouncedresize',  "/js/jquery-debouncedresize$suffix.js", array('jquery'), false, 1 );
        $this->scripts->add( 'jquery-easing', 		    "/js/jquery-easing$suffix.js", array('jquery'), '1.3', 1 );
        $this->scripts->add( 'jquery-mediaTable', 	    "/js/jquery-mediaTable$suffix.js", array('jquery'), false, 1 );
        $this->scripts->add( 'jquery-imagesloaded', 	"/js/jquery-imagesloaded$suffix.js", array('jquery'), '2.0.1', 1 );
        $this->scripts->add( 'jquery-gmap3', 			"/js/jquery-gmap3$suffix.js", array('jquery'), false, 1 );
        $this->scripts->add( 'jquery-autosize', 		"/js/jquery-autosize$suffix.js", array('jquery'), '1.7', 1 );
        $this->scripts->add( 'jquery-counter', 		    "/js/jquery-counter$suffix.js", array('jquery'), '2.1', 1 );
        $this->scripts->add( 'jquery-inputmask', 		"/js/jquery-inputmask$suffix.js", array('jquery'), false, 1 );
        $this->scripts->add( 'jquery-progressbar',	    "/js/jquery-anim_progressbar$suffix.js", array('jquery'), false, 1 );

        $this->scripts->add( 'js-json', 				"/js/json2.js", array(), false, 1 );
        $this->scripts->add( 'js-sprintf', 			    "/lib/sprintf_js/sprintf$suffix.js", array(), '1.1.2', 1 );

        // 添加jquery-ui
        $this->scripts->add( 'jquery-ui-touchpunch',	"/js/ui/jquery-ui-touchpunch$suffix.js", array('jquery-ui'), false, 1 );
        $this->scripts->add( 'jquery-ui-totop',		    "/js/ui/jquery-ui-totop$suffix.js", array('jquery-ui'), false, 1 );


        // 添加ecjia-admin
        $this->scripts->add( 'ecjia-admin', 			    '/ecjia/ecjia-admin.js', array('ecjia', 'jquery-pjax', 'jquery-cookie', 'jquery-quicksearch', 'jquery-mousewheel', 'jquery-ui-totop') );// 'nicescroll',
        $this->scripts->add( 'ecjia-front', 			    '/ecjia/ecjia-front.js', array('ecjia') );

        // 添加ecjia admin lib
        $this->scripts->add( 'ecjia-admin_cache',           '/ecjia/ecjia-admin_cache.js', array('ecjia-admin'), false, 1 );
        $this->scripts->add( 'ecjia-admin_logs',            '/ecjia/ecjia-admin_logs.js', array('ecjia-admin'), false, 1 );
        $this->scripts->add( 'ecjia-admin_message_list',    '/ecjia/ecjia-admin_message_list.js', array('ecjia-admin'), false, 1 );
        $this->scripts->add( 'ecjia-admin_region',          '/ecjia/ecjia-admin_region.js', array('ecjia-admin'), false, 1 );
        $this->scripts->add( 'ecjia-admin_role',            '/ecjia/ecjia-admin_role.js', array('ecjia-admin'), false, 1 );
        $this->scripts->add( 'ecjia-admin_upgrade',         '/ecjia/ecjia-admin_upgrade.js', array('ecjia-admin'), false, 1 );
        $this->scripts->add( 'ecjia-admin_application',     '/ecjia/ecjia-application.js', array('ecjia-admin'), false, 1 );
        $this->scripts->add( 'ecjia-admin_dashboard',       '/ecjia/ecjia-dashboard.js', array('ecjia-admin'), false, 1 );
        $this->scripts->add( 'ecjia-admin_team',       	    '/ecjia/ecjia-about_team.js', array('ecjia-admin'), false, 1 );
        $this->scripts->add( 'ecjia-admin_plugin',          '/ecjia/ecjia-plugin_list.js', array('ecjia-admin'), false, 1 );
        $this->scripts->add( 'ecjia-admin_privilege',       '/ecjia/ecjia-privilege.js', array('ecjia-admin'), false, 1 );
        $this->scripts->add( 'ecjia-admin_shop_config',     '/ecjia/ecjia-shop_config.js', array('ecjia-admin'), false, 1 );
        $this->scripts->add( 'ecjia-admin_license',         '/ecjia/ecjia-admin_license.js', array('ecjia-admin'), false, 1 );

        //对lib的扩展js
        $this->scripts->add( 'jquery-chosen', 			    "/js/ecjia.chosen.js", array('ecjia-jquery-chosen'), false, 1 );
        $this->scripts->add( 'ecjia-jquery-chosen', 		"/lib/chosen/chosen.jquery$suffix.js", array('jquery'), false, 1 );

        // 添加lib
        $this->scripts->add( 'bootstrap', 				    "/lib/bootstrap/js/bootstrap$suffix.js" );
        $this->scripts->add( 'jquery-ui',					"/lib/jquery-ui/jquery-ui$suffix.js", array('jquery') );
        $this->scripts->add( 'jquery-validate',			    "/lib/validation/jquery.validate$suffix.js", array('jquery'), false, 1 );
        $this->scripts->add( 'jquery-uniform',			    "/lib/uniform/jquery.uniform$suffix.js", array('jquery'), false, 1 );
        $this->scripts->add( 'smoke',						"/lib/smoke/smoke$suffix.js", array(), false, 1 );

        $this->scripts->add( 'bootstrap-placeholder',       "/lib/jasny-bootstrap/js/bootstrap-placeholder$suffix.js", array('bootstrap'), false, 1 );
        $this->scripts->add( 'bootstrap-colorpicker',       "/lib/colorpicker/bootstrap-colorpicker$suffix.js", array(), false, 1 );

        $this->scripts->add( 'jquery-flot', 				"/lib/flot/jquery.flot$suffix.js", array('jquery'), false, 1 );
        $this->scripts->add( 'jquery-flot-curvedLines', 	"/lib/flot/jquery.flot.curvedLines$suffix.js", array('jquery-flot'), false, 1 );
        $this->scripts->add( 'jquery-flot-multihighlight',  "/lib/flot/jquery.flot.multihighlight$suffix.js", array('jquery-flot'), false, 1 );
        $this->scripts->add( 'jquery-flot-orderBars', 	    "/lib/flot/jquery.flot.orderBars$suffix.js", array('jquery-flot'), false, 1 );
        $this->scripts->add( 'jquery-flot-pie', 			"/lib/flot/jquery.flot.pie$suffix.js", array('jquery-flot'), false, 1 );
        $this->scripts->add( 'jquery-flot-pyramid', 		"/lib/flot/jquery.flot.pyramid$suffix.js", array('jquery-flot'), false, 1 );
        $this->scripts->add( 'jquery-flot-resize', 		    "/lib/flot/jquery.flot.resize$suffix.js", array('jquery-flot'), false, 1 );

        $this->scripts->add( 'antiscroll', 				    "/lib/antiscroll/antiscroll$suffix.js", array('jquery'), false, 1 );
        $this->scripts->add( 'jquery-mousewheel', 		    "/lib/antiscroll/jquery-mousewheel.js", array('jquery','antiscroll'), false, 1 );
        $this->scripts->add( 'nicescroll', 				    "/lib/nicescroll/jquery.nicescroll$suffix.js", array('jquery'), false, 1 );

        $this->scripts->add( 'jquery-colorbox', 			"/lib/colorbox/jquery.colorbox$suffix.js", array('jquery'), false, 1 );
        $this->scripts->add( 'jquery-qtip', 				"/lib/qtip2/jquery.qtip$suffix.js", array('jquery'), false, 1 );
        $this->scripts->add( 'jquery-sticky', 			    "/lib/sticky/sticky$suffix.js", array('jquery'), false, 1 );
        $this->scripts->add( 'jquery-jBreadCrumb', 		    "/lib/jBreadcrumbs/js/jquery.jBreadCrumb$suffix.js", array('jquery'), false, 1 );
        $this->scripts->add( 'jquery-form', 				"/lib/jquery-form/jquery.form$suffix.js", array('jquery'), false, 1 );

        $this->scripts->add( 'ios-orientationchange',		"/lib/ios-fix/ios-orientationchange-fix$suffix.js", array(), false, 1 );
        $this->scripts->add( 'google-code-prettify',		"/lib/google-code-prettify/prettify$suffix.js", array(), false, 1 );
        $this->scripts->add( 'selectnav',					"/lib/selectnav/selectnav$suffix.js", array(), false, 1 );

        $this->scripts->add( 'jquery-dataTables', 			"/lib/datatables/jquery.dataTables$suffix.js", array('jquery'), false, 1 );
        $this->scripts->add( 'jquery-dataTables-sorting',	"/lib/datatables/jquery.dataTables.sorting$suffix.js", array('jquery-dataTables'), false, 1 );
        $this->scripts->add( 'jquery-dataTables-bootstrap',	"/lib/datatables/jquery.dataTables.bootstrap$suffix.js", array('jquery-dataTables'), false, 1 );


        $this->scripts->add( 'jquery-stepy',				"/lib/stepy/js/jquery.stepy$suffix.js", array(), false, 1 );

        $this->scripts->add( 'jquery-quicksearch',			"/lib/multi-select/js/jquery.quicksearch.js", array(), false, 1);


        // 添加vendor
        $this->scripts->add( 'tinymce',	                    RC_Uri::vendor_url('tinymce/tinymce/tinymce') . "$suffix.js", array(), false, 1 );

        //js语言包调用
        $this->scripts->localize('ecjia.ui', 'admin_lang', config('system::jslang.loader_page'));
    }

    /**
     * Determine the concatenation and compression settings for scripts and styles.
     *
     * @since 2.8.0
     *
     * @global bool $concatenate_scripts
     * @global bool $compress_scripts
     * @global bool $compress_css
     */
    protected function script_concat_settings()
    {

        $compressed_output = ( ini_get('zlib.output_compression') || 'ob_gzhandler' == ini_get('output_handler') );

        if ( is_null($this->concatenate_scripts) ) {
            $this->concatenate_scripts = config('system.concatenate_scripts', true);
            if (  config('system.script_debug') ) //( ! is_ecjia_admin() ) ||
            {
                $this->concatenate_scripts = false;
            }
        }

        if ( is_null($this->compress_scripts) ) {
            $this->compress_scripts = config('system.compress_scripts', true);
            if ( $this->compress_scripts && ( ! config('system.can_compress_scripts') || $compressed_output ) ) {
                $this->compress_scripts = false;
            }
        }

    }


    /**
     * Prints the script queue in the HTML head on admin pages.
     *
     * Postpones the scripts that were queued for the footer.
     * print_footer_scripts() is called in the footer to print these scripts.
     *
     * @since 1.0.0
     *
     * @see admin_print_scripts()
     */
    public function print_head_scripts()
    {
        if ( ! RC_Hook::did_action('rc_print_scripts') ) {
            RC_Hook::do_action( 'rc_print_scripts' );
        }

        $this->scripts->do_concat = $this->concatenate_scripts;

        $this->scripts->do_head_items();

        /**
         * Filter whether to print the head scripts.
         *
         * @since 1.0.0
         *
         * @param bool $print Whether to print the head scripts. Default true.
         */
        if ( RC_Hook::apply_filters( 'print_head_scripts', true ) ) {
            $this->_print_scripts();
        }

        $this->scripts->reset();
        return $this->scripts->done;
    }


    /**
     * Prints the scripts that were queued for the footer or too late for the HTML head.
     *
     * @since 1.0.0
     */
    public function print_footer_scripts()
    {

        $this->scripts->do_concat = $this->concatenate_scripts;
        $this->scripts->do_footer_items();

        /**
         * Filter whether to print the footer scripts.
         *
         * @since 1.0.0
         *
         * @param bool $print Whether to print the footer scripts. Default true.
         */
        if ( RC_Hook::apply_filters( 'print_footer_scripts', true ) ) {
            $this->_print_scripts();
        }

        $this->scripts->reset();
        return $this->scripts->done;
    }


    /**
     * @internal use
     */
    protected function _print_scripts()
    {

        $zip = $this->compress_scripts ? 1 : 0;
        if ( $zip && config('system.enforce_gzip') )
        {
            $zip = 'gzip';
        }

        if ( $concat = trim( $this->scripts->concat, ', ' ) ) {

            if ( !empty($this->scripts->print_code) ) {
                echo "\n<script type='text/javascript'>\n";
                echo "/* <![CDATA[ */\n"; // not needed in HTML 5
                echo $this->scripts->print_code;
                echo "/* ]]> */\n";
                echo "</script>\n";
            }

            $concat = str_split( $concat, 128 );
            $concat = 'load%5B%5D=' . implode( '&load%5B%5D=', $concat );

            $args = "compress={$zip}&" . $concat . '&ver=' . $this->scripts->default_version;
            $src = RC_Uri::url('@load_scripts/init', $args);
            echo "<script type='text/javascript' src='" . \RC_Format::esc_attr($src) . "'></script>\n";
        }

        if ( !empty($this->scripts->print_html) )
        {
            echo $this->scripts->print_html;
        }
    }

}