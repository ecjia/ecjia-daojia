<?php
/**
 * 友情链接应用
 */
defined('IN_ECJIA') or exit('No permission resources.');

return array(
	'identifier' 	=> 'ecjia.friendlink',
	'directory' 	=> 'friendlink',
	'name'			=> __('友情链接', 'friendlink'),
	'description' 	=> __('友情链接是指互相在自己的网站上放对方网站的链接。必须要能在网页代码中找到网址和网站名称，而且浏览网页的时候能显示网站名称；友情链接是网站流量来源的根本，比如一种可以自动交换链接的友情链接网站，这是一种创新的自助式友情链接互连网模式。', 'friendlink'),
	'author' 		=> 'ECJIA TEAM',				/* 作者 */
	'website' 		=> 'http://www.ecjia.com',		/* 网址 */
	'version' 		=> '1.21.4',						/* 版本号 */
	'copyright' 	=> 'ECJIA Copyright 2014 ~ 2019.',
    'namespace'     => 'Ecjia\App\Friendlink',
    'provider'      => 'FriendlinkServiceProvider',
);

// end