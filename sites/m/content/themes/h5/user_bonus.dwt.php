<?php 
/*
Name: 红包模板
Description: 红包页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
var bonus_sn_error = '该红包序列号不正确';
var bonus_sn_empty = '请输入您要添加的红包号码！';
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<ul class="ecjia-list ecjia-list-three ecjia-bonus ecjia-bonus-top-head ecjia-nav ecjia-bonus-border-right">
	<li {if $status eq 'allow_use'} class="red-bottom"{elseif $smarty.get.status eq ''}class="red-bottom"{else}class=''{/if}><a {if $status eq 'allow_use'} class="red-font"{elseif $smarty.get.status eq ''}class="red-font"{else}class=""{/if} href="{url path='user/bonus/init' args='status=allow_use'}">{t domain="h5"}可使用{/t}</a></li>
	<li {if $status eq 'is_used'} class="red-bottom"{else}class=""{/if}><a {if $status eq 'is_used'} class="red-font"{else}class=""{/if} href="{url path='user/bonus/init' args='status=is_used'}">{t domain="h5"}已使用{/t}</a></li>
	<li {if $status eq 'expired'} class="red-bottom"{else}class=""{/if}><a {if $status eq 'expired'} class="red-font right-border"{else}class="right-border"{/if} href="{url path='user/bonus/init' args='status=expired'}">{t domain="h5"}已过期{/t}</a></li>
</ul>
<div class="ecjia-bonus bonus_explain">
    <a class="external" href="{$bonus_readme_url}">{t domain="h5"}使用说明{/t}</a> 
</div>
{if $status eq 'allow_use'}
<ul class="ecjia-bouns-list ecjia-margin-t ecjia-bonus ecjia-list-two" id="J_ItemList"  data-toggle="asynclist" data-loadimg="{$theme_url}dist/images/loader.gif" data-url="{url path='user/bonus/async_allow_use'}" data-size="10"></ul>
{elseif $status eq 'is_used'}
<ul class="ecjia-bouns-list ecjia-margin-t ecjia-bonus ecjia-list-two" id="J_ItemList"  data-toggle="asynclist" data-loadimg="{$theme_url}dist/images/loader.gif" data-url="{url path='user/bonus/async_is_used'}" data-size="10"></ul>
{elseif $status eq 'expired'}
<ul class="ecjia-bouns-list ecjia-margin-t ecjia-bonus ecjia-list-two" id="J_ItemList"  data-toggle="asynclist" data-loadimg="{$theme_url}dist/images/loader.gif" data-url="{url path='user/bonus/async_expired'}" data-size="10"></ul>
{elseif $status eq ''}
<ul class="ecjia-bouns-list ecjia-margin-t ecjia-bonus ecjia-list-two" id="J_ItemList"  data-toggle="asynclist" data-loadimg="{$theme_url}dist/images/loader.gif" data-url="{url path='user/bonus/async_allow_use'}" data-size="10"></ul>
{/if}
<!-- {/block} -->

{/nocache}