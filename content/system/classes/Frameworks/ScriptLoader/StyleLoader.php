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


use Ecjia\System\Frameworks\Contracts\StyleLoaderInterface;
use Royalcms\Component\Script\HandleStyles;
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
class StyleLoader implements StyleLoaderInterface
{

    /**
     * @var HandleStyles
     */
    protected $styles;

    protected $concatenate_styles;
    protected $compress_css;

    public function __construct($styles)
    {
        $this->styles = $styles;

        $this->styles->base_url = RC_Uri::system_static_url();
        $this->styles->content_url = RC_Uri::system_static_url();
        $this->styles->default_version = \ecjia::VERSION;
        $this->styles->text_direction = function_exists( 'is_rtl' ) && is_rtl() ? 'rtl' : 'ltr';
        $this->styles->default_dirs = array('/');

        $this->default_styles();
        $this->style_concat_settings();
    }

    /**
     * Assign default styles to $styles object.
     *
     * Nothing is returned, because the $styles parameter is passed by reference.
     * Meaning that whatever object is passed will be updated without having to
     * reassign the variable that was passed back to the same value. This saves
     * memory.
     *
     * Adding default styles is not the only task, it also assigns the base_url
     * property, the default version, and text direction for the object.
     *
     * @since 1.0.0
     *
     * @param object $styles
     */
    protected function default_styles()
    {
        $develop_src = false !== strpos( \ecjia::VERSION, '-src' );

        if ( ! config('system.script_debug') ) {
            $suffix = '.min';
        } else {
            $suffix = '';
        }

        $dev_suffix = $develop_src ? '' : '.min';

        // ECJia CSS
        $this->styles->add( 'ecjia',           			"/styles/ecjia.css" );
        $this->styles->add( 'ecjia-ui',           		"/styles/ecjia.ui.css" ); //array('ecjia')
        $this->styles->add( 'ecjia-function',           "/styles/ecjia.function.css" );
        $this->styles->add( 'ecjia-skin-blue',         	"/styles/ecjia.skin.blue.css", array('ecjia') );


        // lib css
        $this->styles->add( 'bootstrap',         		    "/lib/bootstrap/css/bootstrap$suffix.css" );
        $this->styles->add( 'bootstrap-responsive',         "/lib/bootstrap/css/bootstrap-responsive$suffix.css", array('bootstrap') );
        $this->styles->add( 'bootstrap-responsive-nodeps',  "/lib/bootstrap/css/bootstrap-responsive$suffix.css" );

        $this->styles->add( 'jquery-ui-aristo', 			"/lib/jquery-ui/css/Aristo/Aristo.css" );
        $this->styles->add( 'jquery-qtip', 				    "/lib/qtip2/jquery.qtip$suffix.css" );
        $this->styles->add( 'jquery-jBreadCrumb', 		    "/lib/jBreadcrumbs/css/BreadCrumb.css" );
        $this->styles->add( 'jquery-colorbox', 			    "/lib/colorbox/colorbox.css" );
        $this->styles->add( 'jquery-sticky', 				"/lib/sticky/sticky.css" );

        $this->styles->add( 'google-code-prettify', 		"/lib/google-code-prettify/prettify.css" );
        $this->styles->add( 'splashy', 					    "/images/splashy/splashy.css" );
        $this->styles->add( 'flags', 						"/images/flags/flags.css" );

        $this->styles->add( 'datatables-TableTools', 		"/lib/datatables/extras/TableTools/media/css/TableTools.css" );
        $this->styles->add( 'fontello', 					"/lib/fontello/css/fontello.css" );
        $this->styles->add( 'chosen', 					    "/lib/chosen/chosen.css" );
        $this->styles->add( 'uniform-aristo', 			    "/lib/uniform/Aristo/uniform.aristo.css" );

        $this->styles->add( 'jquery-stepy',				    "/lib/stepy/css/jquery.stepy.css" );


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
    protected function style_concat_settings()
    {

        $compressed_output = ( ini_get('zlib.output_compression') || 'ob_gzhandler' == ini_get('output_handler') );

        if ( is_null($this->concatenate_styles) ) {
            $this->concatenate_styles = config('system.concatenate_scripts', true);
            if (  config('system.script_debug') ) //( ! is_ecjia_admin() ) ||
            {
                $this->concatenate_styles = false;
            }
        }

        if ( is_null($this->compress_css) ) {
            $this->compress_css = config('system.compress_css', true);
            if ( $this->compress_css && ( ! config('system.can_compress_scripts') || $compressed_output ) ) {
                $this->compress_css = false;
            }
        }

    }

    /**
     * Prints the styles queue in the HTML head on admin pages.
     *
     * @since 1.0.0
     */
    public function print_head_styles()
    {

        $this->styles->do_concat = $this->concatenate_styles;
        $this->styles->do_items(false);

        /**
         * Filter whether to print the admin styles.
         *
         * @since 1.0.0
         *
         * @param bool $print Whether to print the admin styles. Default true.
         */
        if ( RC_Hook::apply_filters( 'print_admin_styles', true ) ) {
            $this->_print_styles();
        }

        $this->styles->reset();
        return $this->styles->done;
    }


    /**
     * Prints the styles that were queued too late for the HTML head.
     *
     * @since 1.0.0
     */
    public function print_late_styles()
    {

        $this->styles->do_concat = $this->concatenate_styles;
        $this->styles->do_footer_items();

        /**
         * Filter whether to print the styles queued too late for the HTML head.
         *
         * @since 1.0.0
         *
         * @param bool $print Whether to print the 'late' styles. Default true.
         */
        if ( RC_Hook::apply_filters( 'print_late_styles', true ) ) {
            $this->_print_styles();
        }

        $this->styles->reset();
        return $this->styles->done;
    }


    /**
     * @internal use
     */
    protected function _print_styles()
    {

        $zip = $this->compress_css ? 1 : 0;
        if ( $zip && config('system.enforce_gzip') ) {
            $zip = 'gzip';
        }

        if ( $concat = trim( $this->styles->concat, ', ' ) ) {

            $dir = $this->styles->text_direction;
            $ver = $this->styles->default_version;

            $concat = str_split( $concat, 128 );
            $concat = 'load%5B%5D=' . implode( '&load%5B%5D=', $concat );

            $args = "compress={$zip}&dir={$dir}&" . $concat . '&ver=' . $ver;
            $href = RC_Uri::url('@load_styles/init', $args);

            echo "<link rel=\"stylesheet\" href=\"" . \RC_Format::esc_attr($href) . "\" type=\"text/css\" media=\"all\" />\n";

            if ( !empty($this->styles->print_code) ) {
                echo "<style type='text/css'>\n";
                echo $this->styles->print_code;
                echo "\n</style>\n";
            }
        }

        if ( !empty($this->styles->print_html) )
        {
            echo $this->styles->print_html;
        }
    }


}