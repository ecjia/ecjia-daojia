<?php
/**
 * 客户管理应用
 */
defined('IN_ECJIA') or exit('No permission resources.');
return array(
    'identifier' 	=> 'ecjia.customer',
	'directory' 	=> 'customer',
	'name'			=> __('商家会员', 'customer'),
	'description' 	=> __('商家会员', 'customer'),
	'author' 		=> 'ECJIA TEAM',
	'website' 		=> 'http://www.ecjia.com',
	'version' 		=> '1.29.0',
    'copyright' 	=> 'ECJIA Copyright 2014 ~ 2019.',
    'namespace'     => 'Ecjia\App\Customer',
    'provider'      => 'CustomerServiceProvider',
);

// end