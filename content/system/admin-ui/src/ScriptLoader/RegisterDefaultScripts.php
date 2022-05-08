<?php


namespace Ecjia\System\AdminUI\ScriptLoader;


use Ecjia\Component\ScriptLoader\AbstractLoader;
use RC_Script;
use RC_Uri;

class RegisterDefaultScripts
{

    public function __invoke()
    {
        $url = RC_Uri::admin_url('admin-ui/statics/');
        $suffix = AbstractLoader::developMode();

        // 添加 ecjia-js
        RC_Script::add( 'ecjia', 				        $url."/lib/ecjia_js/ecjia$suffix.js", array('jquery') );
        RC_Script::add( 'ecjia-collect', 		        $url."/lib/ecjia_js/ecjia.collect.js", array('ecjia'), false, 1 );
        RC_Script::add( 'ecjia-hook', 		            $url."/lib/ecjia_js/ecjia.hook$suffix.js", array('ecjia'), false, 1 );
        RC_Script::add( 'ecjia-middleware', 		        $url."/lib/ecjia_js/ecjia.middleware.js", array('ecjia'), false, 1 );
        RC_Script::add( 'ecjia-utils', 			        $url."/lib/ecjia_js/ecjia.utils$suffix.js", array('ecjia'), false, 1 );
        RC_Script::add( 'ecjia-region', 			        $url."/lib/ecjia_js/ecjia.region$suffix.js", array('ecjia'), false, 1 );
        RC_Script::add( 'ecjia-ui', 				        $url."/lib/ecjia_js/ecjia.ui$suffix.js", array('ecjia') );

        // 添加jquery
        RC_Script::add( 'jquery', 				        $url."/js/jquery$suffix.js", array(), '2.1.0' );
        RC_Script::add( 'jquery-pjax', 			        $url."/js/jquery-pjax.js", array('jquery') );
        RC_Script::add( 'jquery-peity', 			        $url."/js/jquery-peity$suffix.js", array('jquery'), '0.6.0', 1  );
        RC_Script::add( 'jquery-mockjax', 		        $url."/js/jquery-mockjax$suffix.js", array('jquery'), '1.5.1', 1 );
        RC_Script::add( 'jquery-wookmark', 		        $url."/js/jquery-wookmark$suffix.js", array('jquery'), false, 1 );
        RC_Script::add( 'jquery-migrate', 		        $url."/js/jquery-migrate$suffix.js", array('jquery'), '1.0.0', 1 );
        RC_Script::add( 'jquery-cookie', 		        $url."/js/jquery-cookie$suffix.js", array('jquery'), true, 1 );
        RC_Script::add( 'jquery-actual', 		        $url."/js/jquery-actual$suffix.js", array('jquery'), '1.0.6', 1 );
        RC_Script::add( 'jquery-debouncedresize',        $url."/js/jquery-debouncedresize$suffix.js", array('jquery'), false, 1 );
        RC_Script::add( 'jquery-easing', 		        $url."/js/jquery-easing$suffix.js", array('jquery'), '1.3', 1 );
        RC_Script::add( 'jquery-mediaTable', 	        $url."/js/jquery-mediaTable$suffix.js", array('jquery'), false, 1 );
        RC_Script::add( 'jquery-imagesloaded', 	        $url."/js/jquery-imagesloaded$suffix.js", array('jquery'), '2.0.1', 1 );
        RC_Script::add( 'jquery-gmap3', 			        $url."/js/jquery-gmap3$suffix.js", array('jquery'), false, 1 );
        RC_Script::add( 'jquery-autosize', 		        $url."/js/jquery-autosize$suffix.js", array('jquery'), '1.7', 1 );
        RC_Script::add( 'jquery-counter', 		        $url."/js/jquery-counter$suffix.js", array('jquery'), '2.1', 1 );
        RC_Script::add( 'jquery-inputmask', 		        $url."/js/jquery-inputmask$suffix.js", array('jquery'), false, 1 );
        RC_Script::add( 'jquery-progressbar',	        $url."/js/jquery-anim_progressbar$suffix.js", array('jquery'), false, 1 );

        RC_Script::add( 'js-json', 				        $url."/js/json2.js", array(), false, 1 );
        RC_Script::add( 'js-sprintf', 			        $url."/lib/sprintf_js/sprintf$suffix.js", array(), '1.1.2', 1 );

        // 添加jquery-ui
        RC_Script::add( 'jquery-ui-touchpunch',	        $url."/js/ui/jquery-ui-touchpunch$suffix.js", array('jquery-ui'), false, 1 );
        RC_Script::add( 'jquery-ui-totop',		        $url."/js/ui/jquery-ui-totop$suffix.js", array(), false, 1 );


        // 添加ecjia-admin
        RC_Script::add( 'ecjia-admin', 			        $url.'/ecjia/ecjia-admin.js', array('ecjia', 'jquery-pjax', 'jquery-cookie', 'jquery-quicksearch', 'jquery-mousewheel', 'jquery-ui-totop') );// 'nicescroll',
        RC_Script::add( 'ecjia-front', 			        $url.'/ecjia/ecjia-front.js', array('ecjia') );

        // 添加ecjia admin lib
        RC_Script::add( 'ecjia-admin_cache',            $url.'/ecjia/ecjia-admin_cache.js', array('ecjia-admin'), false, 1 );
        RC_Script::add( 'ecjia-admin_logs',             $url.'/ecjia/ecjia-admin_logs.js', array('ecjia-admin'), false, 1 );
        RC_Script::add( 'ecjia-admin_message_list',     $url.'/ecjia/ecjia-admin_message_list.js', array('ecjia-admin'), false, 1 );
        RC_Script::add( 'ecjia-admin_region',           $url.'/ecjia/ecjia-admin_region.js', array('ecjia-admin'), false, 1 );
        RC_Script::add( 'ecjia-admin_role',             $url.'/ecjia/ecjia-admin_role.js', array('ecjia-admin'), false, 1 );
        RC_Script::add( 'ecjia-admin_upgrade',          $url.'/ecjia/ecjia-admin_upgrade.js', array('ecjia-admin'), false, 1 );
        RC_Script::add( 'ecjia-admin_application',      $url.'/ecjia/ecjia-application.js', array('ecjia-admin'), false, 1 );
        RC_Script::add( 'ecjia-admin_dashboard',        $url.'/ecjia/ecjia-dashboard.js', array('ecjia-admin'), false, 1 );
        RC_Script::add( 'ecjia-admin_team',       	   $url.'/ecjia/ecjia-about_team.js', array('ecjia-admin'), false, 1 );
        RC_Script::add( 'ecjia-admin_plugin',           $url.'/ecjia/ecjia-plugin_list.js', array('ecjia-admin'), false, 1 );
        RC_Script::add( 'ecjia-admin_privilege',        $url.'/ecjia/ecjia-privilege.js', array('ecjia-admin'), false, 1 );
        RC_Script::add( 'ecjia-admin_shop_config',      $url.'/ecjia/ecjia-shop_config.js', array('ecjia-admin'), false, 1 );
        RC_Script::add( 'ecjia-admin_license',          $url.'/ecjia/ecjia-admin_license.js', array('ecjia-admin'), false, 1 );

        //对lib的扩展js
        RC_Script::add( 'jquery-chosen', 			   $url."/js/ecjia.chosen.js", array('ecjia-jquery-chosen'), false, 1 );
        RC_Script::add( 'ecjia-jquery-chosen', 		   $url."/lib/chosen/chosen.jquery$suffix.js", array('jquery'), false, 1 );

        // 添加lib
        RC_Script::add( 'bootstrap', 				   $url."/lib/bootstrap/js/bootstrap$suffix.js" );
        RC_Script::add( 'jquery-ui',					   $url."/lib/jquery-ui/jquery-ui$suffix.js", array('jquery') );
        RC_Script::add( 'jquery-validate',			   $url."/lib/validation/jquery.validate$suffix.js", array('jquery'), false, 1 );
        RC_Script::add( 'jquery-uniform',			   $url."/lib/uniform/jquery.uniform$suffix.js", array('jquery'), false, 1 );
        RC_Script::add( 'smoke',						   $url."/lib/smoke/smoke$suffix.js", array(), false, 1 );

        RC_Script::add( 'bootstrap-placeholder',        $url."/lib/jasny-bootstrap/js/bootstrap-placeholder$suffix.js", array('bootstrap'), false, 1 );
        RC_Script::add( 'bootstrap-colorpicker',        $url."/lib/colorpicker/bootstrap-colorpicker$suffix.js", array(), false, 1 );

        RC_Script::add( 'jquery-flot', 				   $url."/lib/flot/jquery.flot$suffix.js", array('jquery'), false, 1 );
        RC_Script::add( 'jquery-flot-curvedLines', 	   $url."/lib/flot/jquery.flot.curvedLines$suffix.js", array('jquery-flot'), false, 1 );
        RC_Script::add( 'jquery-flot-multihighlight',   $url."/lib/flot/jquery.flot.multihighlight$suffix.js", array('jquery-flot'), false, 1 );
        RC_Script::add( 'jquery-flot-orderBars', 	   $url."/lib/flot/jquery.flot.orderBars$suffix.js", array('jquery-flot'), false, 1 );
        RC_Script::add( 'jquery-flot-pie', 			   $url."/lib/flot/jquery.flot.pie$suffix.js", array('jquery-flot'), false, 1 );
        RC_Script::add( 'jquery-flot-pyramid', 		   $url."/lib/flot/jquery.flot.pyramid$suffix.js", array('jquery-flot'), false, 1 );
        RC_Script::add( 'jquery-flot-resize', 		   $url."/lib/flot/jquery.flot.resize$suffix.js", array('jquery-flot'), false, 1 );

        RC_Script::add( 'antiscroll', 				   $url."/lib/antiscroll/antiscroll$suffix.js", array('jquery'), false, 1 );
        RC_Script::add( 'jquery-mousewheel', 		   $url."/lib/antiscroll/jquery-mousewheel.js", array('jquery','antiscroll'), false, 1 );
        RC_Script::add( 'nicescroll', 				   $url."/lib/nicescroll/jquery.nicescroll$suffix.js", array('jquery'), false, 1 );

        RC_Script::add( 'jquery-colorbox', 			    $url."/lib/colorbox/jquery.colorbox$suffix.js", array('jquery'), false, 1 );
        RC_Script::add( 'jquery-qtip', 				    $url."/lib/qtip2/jquery.qtip$suffix.js", array('jquery'), false, 1 );
        RC_Script::add( 'jquery-sticky', 			    $url."/lib/sticky/sticky$suffix.js", array('jquery'), false, 1 );
        RC_Script::add( 'jquery-jBreadCrumb', 		    $url."/lib/jBreadcrumbs/js/jquery.jBreadCrumb$suffix.js", array('jquery'), false, 1 );
        RC_Script::add( 'jquery-form', 				    $url."/lib/jquery-form/jquery.form$suffix.js", array('jquery'), false, 1 );

        RC_Script::add( 'ios-orientationchange',		    $url."/lib/ios-fix/ios-orientationchange-fix$suffix.js", array(), false, 1 );
        RC_Script::add( 'google-code-prettify',		    $url."/lib/google-code-prettify/prettify$suffix.js", array(), false, 1 );
        RC_Script::add( 'selectnav',					    $url."/lib/selectnav/selectnav$suffix.js", array(), false, 1 );

        RC_Script::add( 'jquery-dataTables', 			$url."/lib/datatables/jquery.dataTables$suffix.js", array('jquery'), false, 1 );
        RC_Script::add( 'jquery-dataTables-sorting',	    $url."/lib/datatables/jquery.dataTables.sorting$suffix.js", array('jquery-dataTables'), false, 1 );
        RC_Script::add( 'jquery-dataTables-bootstrap',	$url."/lib/datatables/jquery.dataTables.bootstrap$suffix.js", array('jquery-dataTables'), false, 1 );


        RC_Script::add( 'jquery-stepy',				    $url."/lib/stepy/js/jquery.stepy$suffix.js", array(), false, 1 );

        RC_Script::add( 'jquery-quicksearch',			$url."/lib/multi-select/js/jquery.quicksearch.js", array(), false, 1);

        RC_Script::add( 'bootstrap-datepicker',		    $url."/lib/datepicker/bootstrap-datepicker.min.js", array(), false, 1);


        // 添加vendor
        RC_Script::add( 'tinymce',	                    RC_Uri::vendor_url('tinymce/tinymce/tinymce') . "$suffix.js", array(), false, 1 );


    }

}