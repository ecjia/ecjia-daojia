<?php 
/*
Name: 促销商品模版
Description: 促销商品列表页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.touch.index.init();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<div class="ecjia-promotion-model">
	<ul class="ecjia-promotion-tab">
		<li class="{if $promotion_type eq 'today'}active{/if}">
			<!-- {if $promotion_type neq 'today'} -->
			<a class="fnUrlReplace" href="{RC_Uri::url('goods/index/promotion')}&promotion_type=today"><span>今日促销</span></a>
			<!-- {else} -->
			<a href="javascript:;"><span>今日促销</span></a>
			<!-- {/if} -->
		</li>
		<li class="{if $promotion_type eq 'tomorrow'}active{/if}">
			<!-- {if $promotion_type neq 'tomorrow'} -->
			<a class="fnUrlReplace" href="{RC_Uri::url('goods/index/promotion')}&promotion_type=tomorrow"><span>明日促销</span></a>
			<!-- {else} -->
			<a href="javascript:;"><span>明日促销</span></a>
			<!-- {/if} -->
		</li>
		<li class="{if $promotion_type eq 'aftertheday'}active{/if}">
			<!-- {if $promotion_type neq 'aftertheday'} -->
			<a class="fnUrlReplace" href="{RC_Uri::url('goods/index/promotion')}&promotion_type=aftertheday"><span>后日促销</span></a>
			<!-- {else} -->
			<a href="javascript:;"><span>后日促销</span></a>
			<!-- {/if} -->
		</li>
		<li class="{if $promotion_type eq 'all'}active{/if}">
			<!-- {if $promotion_type neq 'all'} -->
			<a class="fnUrlReplace" href="{RC_Uri::url('goods/index/promotion')}&promotion_type=all"><span>更多促销</span></a>
			<!-- {else} -->
			<a href="javascript:;"><span>更多促销</span></a>
			<!-- {/if} -->
		</li>
	</ul>
	<ul class="ecjia-promotion-list" data-toggle="asynclist" data-url="{url path='#index/ajax_goods' args='type=promotion'}&promotion_type={$promotion_type}" data-loadimg="{$theme_url}dist/images/loader.gif">
	</ul>
</div>
<!-- {/block} -->
{/nocache}