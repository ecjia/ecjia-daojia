<?php
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * 收银管理
 */
return array(
	'identifier' 	=> 'ecjia.cashier',
	'directory' 	=> 'cashier',
	'name'			=> 'cashier',
	'description' 	=> 'cashier_desc',			/* 描述对应的语言项 */
	'author' 		=> 'ECJIA TEAM',			/* 作者 */
	'website' 		=> 'http://www.ecjia.com',	/* 网址 */
	'version' 		=> '1.18.0',					/* 版本号 */
	'copyright' 	=> 'ECJIA Copyright 2014 ~ 2019.',
    'namespace'     => 'Ecjia\App\Cashier',
    'provider'      => 'CashierServiceProvider',
);

// end