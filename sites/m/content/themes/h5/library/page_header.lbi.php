<?php
/*
Name: 页头
Description: 这是公共页头文件
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<header class="ecjia-header">
	<div class="ecjia-header-left">
	</div>
	<div class="ecjia-header-title">{$title}</div>
	<!-- {if $header_right} -->
	<div class="ecjia-header-right">
		<a href="{$header_right.href}">
			<!-- {if $header_right.icon neq ''} -->
			<i class="{$header_left.icon}"></i>
			<!-- {elseif $header_right.info neq ''} -->
			<span>{$header_right.info}</span>
			<!-- {/if} -->
		</a>
		<!-- {if $header_right.icon neq ''} -->
		<i class="{$header_left.icon}"></i>
		<!-- {else} -->
			<!-- {if $header_right.search neq ''} -->
			<a href="{$header_right.search_url}" class="m_r5"><span>{$header_right.search}</span></a>
			<!-- {/if} -->
			<!-- {if $header_right.location neq ''} -->
			<a href="{$header_right.location_url}" class="nopjax external"><span>{$header_right.location}</span></a>
			<!-- {/if} -->
		<!-- {/if} -->
	</div>
	<!-- {/if} -->
</header>
