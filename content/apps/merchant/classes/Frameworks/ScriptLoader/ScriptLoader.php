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

namespace Ecjia\App\Merchant\Frameworks\ScriptLoader;


use Ecjia\System\Frameworks\ScriptLoader\ScriptLoader as EcjiaScriptLoader;
use RC_App;

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
class ScriptLoader extends EcjiaScriptLoader
{

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

        $base_url = dirname(dirname(dirname(RC_App::app_dir_url(__FILE__)))) . '/statics';

        $this->scripts->remove('jquery');
        $this->scripts->remove('bootstrap');

        $this->scripts->add( 'bootstrap', 		        $base_url.'/mh-js/bootstrap.min.js' );
        $this->scripts->add( 'jquery', 			        $base_url.'/mh-js/jquery-1.11.1.min.js' );
        $this->scripts->add( 'ecjia-merchant', 			$base_url.'/ecjia/ecjia-merchant.js', array('jquery', 'ecjia') );
        $this->scripts->add( 'ecjia-merchant-ui', 		$base_url.'/ecjia/ecjia-merchant-ui.js', array('jquery', 'ecjia') );

        // 添加 merchant-template-js
        $this->scripts->add( 'ecjia-mh-jquery-customSelect',   $base_url.'/mh-js/jquery.customSelect.min.js', array('jquery'), false, 1 );

        $this->scripts->add( 'ecjia-mh-jquery-dcjqaccordion',  $base_url.'/mh-js/jquery.dcjqaccordion.2.7.min.js', array('jquery'), false, 1 );

        $this->scripts->add( 'ecjia-mh-jquery-nicescroll',     $base_url.'/mh-js/jquery.nicescroll.js', array('jquery'), false, 1 );
        $this->scripts->add( 'ecjia-mh-jquery-scrollTo',  $base_url.'/mh-js/jquery.scrollTo.min.js', array('jquery'), false, 1 );
        $this->scripts->add( 'ecjia-mh-jquery-sparkline', $base_url.'/mh-js/jquery.sparkline.js', array('jquery'), false, 1 );
        $this->scripts->add( 'ecjia-mh-jquery-stepy',     $base_url.'/mh-js/jquery.stepy.js', array('jquery'), false, 1 );
        $this->scripts->add( 'ecjia-mh-jquery-tagsinput', $base_url.'/mh-js/jquery.tagsinput.js', array('jquery'), false, 1 );
        $this->scripts->add( 'ecjia-mh-jquery-validate',  $base_url.'/mh-js/jquery.validate.min.js', array('jquery'), false, 1 );
        $this->scripts->add( 'ecjia-mh-jquery-actual',   	$base_url.'/mh-js/jquery-actual.min.js', array('jquery'), false, 1 );
        $this->scripts->add( 'ecjia-mh-jquery-migrate',   $base_url.'/mh-js/jquery-migrate.min.js', array('jquery'), false, 1 );
        $this->scripts->add( 'ecjia-mh-jquery-quicksearch',   $base_url.'/mh-js/jquery.quicksearch.js', array('jquery'), false, 1 );

        $this->scripts->add( 'ecjia-mh-jquery-easy-pie-chart',  $base_url.'/assets/jquery-easy-pie-chart/jquery.easy-pie-chart.js', array('jquery'), false, 1 );
        $this->scripts->add( 'ecjia-mh-morris-script',    $base_url.'/assets/morris.js-0.4.3/morris.min.js', array(), false, 1 );
        $this->scripts->add( 'ecjia-mh-owl-carousel',     $base_url.'/mh-js/owl.carousel.js', array(), false, 1 );
        $this->scripts->add( 'ecjia-mh-respond',          $base_url.'/mh-js/respond.min.js', array(), false, 1 );
        $this->scripts->add( 'ecjia-mh-slider',    $base_url.'/assets/slider/js/bootstrap-slider.js', array(), false, 1 );
        $this->scripts->add( 'ecjia-mh-sparkline-chart',  $base_url.'/mh-js/sparkline-chart.js', array(), false, 1 );
        $this->scripts->add( 'ecjia-mh-themes',    $base_url.'/mh-js/themes.js', array(), false, 1 );
        $this->scripts->add( 'ecjia-mh-xchart',    $base_url.'/mh-js/xchart.js', array(), false, 1 );
        $this->scripts->add( 'ecjia-mh-chosen-jquery',    $base_url.'/assets/chosen/chosen.jquery.min.js', array(), false, 1 );
        $this->scripts->add( 'ecjia-mh-chart',    $base_url.'/assets/Chart/Chart.min.js', array(), false, 1 );
        $this->scripts->add( 'ecjia-mh-bootstrap-fileupload-js',	$base_url.'/assets/bootstrap-fileupload/bootstrap-fileupload.js', array(), false, 1 );
        $this->scripts->add( 'ecjia-mh-editable-js',    $base_url.'/assets/x-editable/bootstrap-editable/js/bootstrap-editable.min.js', array(), false, 1 );
    }
}