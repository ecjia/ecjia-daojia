<?php
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * 收银管理
 */
return array(
	'identifier' 	=> 'ecjia.cashier',
	'directory' 	=> 'cashier',
	'name'			=> __('收银', 'cashier'),
	'description' 	=> __('线下收银设备管理，收银记录管理。', 'cashier'),
	'author' 		=> 'ECJIA TEAM',			/* 作者 */
	'website' 		=> 'http://www.ecjia.com',	/* 网址 */
	'version' 		=> '1.31.0',					/* 版本号 */
	'copyright' 	=> 'ECJIA Copyright 2014 ~ 2019.',
    'namespace'     => 'Ecjia\App\Cashier',
    'provider'      => 'CashierServiceProvider',
);

// end