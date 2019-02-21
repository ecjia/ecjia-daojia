<?php
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * 物流追踪管理
 */
return array(
	'identifier' 	=> 'ecjia.track',
	'directory' 	=> 'track',
	'name'			=> __('物流跟踪', 'track'),
	'description' 	=> __('订单物流跟踪管理。', 'track'),
	'author' 		=> 'ECJIA TEAM',			/* 作者 */
	'website' 		=> 'http://www.ecjia.com',	/* 网址 */
	'version' 		=> '1.27.4',					/* 版本号 */
	'copyright' 	=> 'ECJIA Copyright 2014 ~ 2019.',
    'namespace'     => 'Ecjia\App\Track',
    'provider'      => 'TrackServiceProvider',
);

// end