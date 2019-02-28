<?php defined('IN_ECJIA') or exit('No permission resources.');?>
{nocache}
<!DOCTYPE html>
<html>
  <head lang="zh-CN">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{t domain="upgrade"}ECJIA到家升级程序{/t}</title>
    {ecjia:hook id=front_head}
  </head>

  <body id="maincontainer" style="height:auto;">
    {include file="./library/header.lbi.php"}
   
    {block name="main_content"}{/block}

    {include file="./library/footer.lbi.php"}

    {if $step eq 1}
        {ecjia:hook id=front_print_footer_scripts}
	    {ecjia:hook id=front_footer}
	    
	    <script type="text/javascript">
	       ecjia.front.upgrade.init();
	    </script>
    {/if}
  </body>
</html>
{/nocache}