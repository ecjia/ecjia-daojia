<?php
/*
Name: 搜索模块
Description: 这是搜索模块
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<div class="ecjia-search-panel">
	<header class="ecjia-header">
		<div class="ecjia-search-header ecjia-search">
			<form class="ecjia-form" action="{url path='goods/category/store_list'}{if $store_id neq 0}&store_id={$store_id}{/if}" name="search-form">
				<input id="keywordBox" name="keywords" type="search" placeholder="{if $store_id neq 0}搜索店内商品{else}搜索附近门店{/if}" {if $keywords}value={$keywords}{/if}>
				<i class="iconfont icon-search btn-search"></i>
			</form>
			<div class="search-cancel"><a href="javascript:;">取消</a></div>
		</div>
	</header>
	
	<!-- {if $searchs} -->
	<div class="ecjia-search-history">
		<p class="title">
			搜索 （{$searchs_count}条记录） {if $searchs}<a class="ecjiaf-csp" data-toggle="del_history" data-href="{url path='touch/index/del_search'}{if $store_id}&store_id={$store_id}{/if}"><i class="iconfont icon-delete"></i>{t}清除{/t}</a>{/if}
		</p>
		<div>
			<ul>
				<!-- {foreach from=$searchs item=search name=keywords} -->
				<a href='{url path="goods/category/store_list" args="{if $store_id neq 0}store_id={$store_id}&{/if}keywords={$search}"}'>
					<li>
						<p class="{if $smarty.foreach.keywords.last}border-none{/if}">{$search}</p>
					</li>
				</a>
				<!-- {/foreach} -->
			</ul>
		</div>
	</div>
	<!-- {else} -->
	<div class="ecjia-no-record">您还没有搜索记录</div>
	<!-- {/if} -->
</div>
