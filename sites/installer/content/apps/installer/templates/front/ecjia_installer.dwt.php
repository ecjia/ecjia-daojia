<?php defined('IN_ECJIA') or exit('No permission resources.');?>
{nocache}
<!DOCTYPE html>
<html lang="zh-CN">
	<head>
	    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>{t domain="installer"}ECJIA到家安装程序{/t}</title>
        {ecjia:hook id=front_enqueue_scripts}
        {ecjia:hook id=front_print_styles}
        {ecjia:hook id=front_print_scripts}
	</head>
    <body id="ecjia-container">
        {include file="./library/header.lbi.php"}
        {block name="main_content"}{/block}
        {include file="./library/footer.lbi.php"}
        {ecjia:hook id=front_print_footer_scripts}
        {block name="footer"}{/block}
    </body>
</html>
{/nocache}