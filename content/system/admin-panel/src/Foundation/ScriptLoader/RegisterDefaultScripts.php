<?php


namespace Ecjia\System\AdminPanel\Foundation\ScriptLoader;


use Ecjia\Component\ScriptLoader\AbstractLoader;
use RC_Script;
use RC_Uri;

class RegisterDefaultScripts
{

    public function __invoke()
    {
        $url = RC_Uri::admin_url('admin-panel/statics/');
        $suffix = AbstractLoader::developMode();

        // 添加ecjia-admin
        RC_Script::add( 'ecjia-admin', 			    $url.'/scripts/ecjia-admin.js', array('ecjia', 'jquery-pjax', 'jquery-cookie', 'jquery-quicksearch', 'jquery-mousewheel', 'jquery-ui-totop') );// 'nicescroll',

        // 添加ecjia admin lib
        RC_Script::add( 'ecjia-admin_cache',         $url.'/scripts/ecjia-admin_cache.js', array('ecjia-admin'), false, 1 );
        RC_Script::add( 'ecjia-admin_logs',          $url.'/scripts/ecjia-admin_logs.js', array('ecjia-admin'), false, 1 );
        RC_Script::add( 'ecjia-admin_message_list',  $url.'/scripts/ecjia-admin_message_list.js', array('ecjia-admin'), false, 1 );
        RC_Script::add( 'ecjia-admin_region',        $url.'/scripts/ecjia-admin_region.js', array('ecjia-admin'), false, 1 );
        RC_Script::add( 'ecjia-admin_role',          $url.'/scripts/ecjia-admin_role.js', array('ecjia-admin'), false, 1 );
        RC_Script::add( 'ecjia-admin_upgrade',       $url.'/scripts/ecjia-admin_upgrade.js', array('ecjia-admin'), false, 1 );
        RC_Script::add( 'ecjia-admin_application',   $url.'/scripts/ecjia-application.js', array('ecjia-admin'), false, 1 );
        RC_Script::add( 'ecjia-admin_dashboard',     $url.'/scripts/ecjia-dashboard.js', array('ecjia-admin'), false, 1 );
        RC_Script::add( 'ecjia-admin_team',       	$url.'/scripts/ecjia-about_team.js', array('ecjia-admin'), false, 1 );
        RC_Script::add( 'ecjia-admin_plugin',        $url.'/scripts/ecjia-plugin_list.js', array('ecjia-admin'), false, 1 );
        RC_Script::add( 'ecjia-admin_privilege',     $url.'/scripts/ecjia-privilege.js', array('ecjia-admin'), false, 1 );
        RC_Script::add( 'ecjia-admin_shop_config',   $url.'/scripts/ecjia-shop_config.js', array('ecjia-admin'), false, 1 );
        RC_Script::add( 'ecjia-admin_license',       $url.'/scripts/ecjia-admin_license.js', array('ecjia-admin'), false, 1 );

        //js语言包调用
        RC_Script::localize('ecjia-ui', 'admin_lang', config('system::jslang.loader_page'));

    }

}