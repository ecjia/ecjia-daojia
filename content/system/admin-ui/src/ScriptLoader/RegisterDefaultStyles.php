<?php


namespace Ecjia\System\AdminUI\ScriptLoader;


use Ecjia\Component\ScriptLoader\AbstractLoader;
use RC_Style;
use RC_Uri;

class RegisterDefaultStyles
{

    public function __invoke()
    {
        $url = RC_Uri::admin_url('admin-ui/statics/');
        $suffix = AbstractLoader::developMode();

        // lib css
        RC_Style::add( 'bootstrap',         		    $url."/lib/bootstrap/css/bootstrap$suffix.css" );
        RC_Style::add( 'bootstrap-responsive',       $url."/lib/bootstrap/css/bootstrap-responsive$suffix.css", array('bootstrap') );
        RC_Style::add( 'bootstrap-responsive-nodeps',$url."/lib/bootstrap/css/bootstrap-responsive$suffix.css" );

        RC_Style::add( 'jquery-ui-aristo', 			$url."/lib/jquery-ui/css/Aristo/Aristo.css" );
        RC_Style::add( 'jquery-qtip', 				$url."/lib/qtip2/jquery.qtip$suffix.css" );
        RC_Style::add( 'jquery-jBreadCrumb', 		$url."/lib/jBreadcrumbs/css/BreadCrumb.css" );
        RC_Style::add( 'jquery-colorbox', 			$url."/lib/colorbox/colorbox.css" );
        RC_Style::add( 'jquery-sticky', 				$url."/lib/sticky/sticky.css" );

        RC_Style::add( 'google-code-prettify', 		$url."/lib/google-code-prettify/prettify.css" );
        RC_Style::add( 'splashy', 					$url."/images/splashy/splashy.css" );
        RC_Style::add( 'flags', 						$url."/images/flags/flags.css" );

        RC_Style::add( 'datatables-TableTools', 		$url."/lib/datatables/extras/TableTools/media/css/TableTools.css" );
        RC_Style::add( 'fontello', 					$url."/lib/fontello/css/fontello.css" );
        RC_Style::add( 'chosen', 					$url."/lib/chosen/chosen.css" );
        RC_Style::add( 'uniform-aristo', 			$url."/lib/uniform/Aristo/uniform.aristo.css" );

        RC_Style::add( 'jquery-stepy',				$url."/lib/stepy/css/jquery.stepy.css" );

        RC_Style::add( 'bootstrap-datepicker',       $url."/lib/datepicker/datepicker.css" );
    }

}