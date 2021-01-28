<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!DOCTYPE html>
<html>
<head lang="zh-CN">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{t domain="upgrade"}ECJIA到家升级程序{/t}</title>
    {ecjia:hook id=front_enqueue_scripts}
    {ecjia:hook id=front_print_styles}
    {ecjia:hook id=front_print_scripts}
</head>

<body id="maincontainer" style="height:auto;">
    {include file="./library/header.lbi.php"}
    {block name="main_content"}{/block}
    {include file="./library/footer.lbi.php"}
    {ecjia:hook id=front_print_footer_scripts}
    {block name="footer"}{/block}
</body>
</html>
