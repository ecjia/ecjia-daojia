<?php

defined('IN_ECJIA') or exit('No permission resources.');

return array(

	'Ecjia\Component\Framework\EcjiaServiceProvider',
	'Ecjia\Component\Config\ConfigServiceProvider',
	'Ecjia\Component\Password\PasswordServiceProvider',
	'Ecjia\Component\AdminLog\AdminLogServiceProvider',
	'Ecjia\Component\CleanCache\CleanCacheServiceProvider',
	'Ecjia\Component\Plugin\PluginServiceProvider',
	'Ecjia\Component\Region\RegionServiceProvider',


    'Ecjia\System\Providers\EventServiceProvider',
    'Ecjia\System\Providers\HookerServiceProvider',
    'Ecjia\System\Providers\MacroServiceProvider',

    'Ecjia\System\AdminPanel\EcjiaAdminPanelServiceProvider',
    'Ecjia\System\AdminUI\EcjiaAdminUIServiceProvider',

);

//end