<?php


namespace Ecjia\System\AdminPanel\Foundation\ScriptLoader;


use Ecjia\Component\ScriptLoader\AbstractLoader;
use RC_Style;
use RC_Uri;

class RegisterDefaultStyles
{

    public function __invoke()
    {
        $url = RC_Uri::admin_url('admin-panel/statics/');
        $suffix = AbstractLoader::developMode();

        // ECJia CSS
        RC_Style::add( 'ecjia',           			$url."/styles/ecjia.css" );
        RC_Style::add( 'ecjia-ui',           	    $url."/styles/ecjia.ui.css" ); //array('ecjia')
        RC_Style::add( 'ecjia-ui-widget',           	$url."/styles/ecjia.ui.widget.css" ); //array('ecjia')
        RC_Style::add( 'ecjia-function',             $url."/styles/ecjia.function.css" );
        RC_Style::add( 'ecjia-skin-blue',         	$url."/styles/ecjia.skin.blue.css", array('ecjia') );
    }

}