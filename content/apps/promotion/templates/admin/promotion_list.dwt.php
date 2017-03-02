<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.promotion_list.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a class="btn plus_or_reply data-pjax" href="{$action_link.href}"  id="sticky_a"><i class="fontello-icon-plus"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>
<ul class="nav nav-pills">
	<li class="{if $type eq ''}active{/if}"><a class="data-pjax" href='{url path="promotion/admin/init" args="{if $filter.merchant_keywords}&merchant_keywords={$filter.merchant_keywords}{/if}{if $filter.keywords}&keywords={$filter.keywords}{/if}"}'>{lang key='promotion::promotion.all'} <span class="badge badge-info">{if $type_count.count}{$type_count.count}{else}0{/if}</span> </a></li>
	<li class="{if $type eq 'on_sale'}active{/if}"><a class="data-pjax" href='{url path="promotion/admin/init" args="type=on_sale{if $filter.merchant_keywords}&merchant_keywords={$filter.merchant_keywords}{/if}{if $filter.keywords}&keywords={$filter.keywords}{/if}"}'>{lang key='promotion::promotion.on_sale'}<span class="badge badge-info">{if $type_count.on_sale}{$type_count.on_sale}{else}0{/if}</span> </a></li>
	<li class="{if $type eq 'coming'}active{/if}"><a class="data-pjax" href='{url path="promotion/admin/init" args="type=coming{if $filter.merchant_keywords}&merchant_keywords={$filter.merchant_keywords}{/if}{if $filter.keywords}&keywords={$filter.keywords}{/if}"}'>{lang key='promotion::promotion.coming'}<span class="badge badge-info">{if $type_count.coming}{$type_count.coming}{else}0{/if}</span> </a></li>
	<li class="{if $type eq 'finished'}active{/if}"><a class="data-pjax" href='{url path="promotion/admin/init" args="type=finished{if $filter.merchant_keywords}&merchant_keywords={$filter.merchant_keywords}{/if}{if $filter.keywords}&keywords={$filter.keywords}{/if}"}'>{lang key='promotion::promotion.finished'}<span class="badge badge-info">{if $type_count.finished}{$type_count.finished}{else}0{/if}</span> </a></li>
	<li class="{if $type eq 'self'}active{/if}"><a class="data-pjax" href='{url path="promotion/admin/init" args="type=self{if $filter.merchant_keywords}&merchant_keywords={$filter.merchant_keywords}{/if}{if $filter.keywords}&keywords={$filter.keywords}{/if}"}'>{lang key='promotion::promotion.self'}<span class="badge badge-info">{if $type_count.self}{$type_count.self}{else}0{/if}</span> </a></li>

	<li class="ecjiaf-fn">
		<form name="searchForm" method="post" action="{$form_search}{if $type}&type={$type}{/if}">
			<div class="f_r form-inline">
				<!-- 关键字 -->
				<input type="text" class="w180" name="merchant_keywords" value="{$smarty.get.merchant_keywords}" placeholder="{lang key='promotion::promotion.merchant_keywords'}"/> 
				<input type="text" class="w180" name="keywords" value="{$smarty.get.keywords}" placeholder="{lang key='promotion::promotion.goods_keywords'}"/> 
				<button class="btn" type="submit">{lang key='promotion::promotion.search'}</button>
			</div>
		</form>
	</li>
</ul>
<div class="row-fluid list-page">
	<div class="span12">
		<table class="table table-striped table-hide-edit">
			<thead>
				<tr>
					<th class="w120">{lang key='promotion::promotion.thumbnail'}</th>
					<th class="w120">{lang key='promotion::promotion.merchants_name'}</th>
					<th>{lang key='promotion::promotion.goods_name'}</th>
					<th class="w130">{lang key='promotion::promotion.start_time'}</th>
					<th class="w130">{lang key='promotion::promotion.end_time'}</th>
					<th class="w80">{lang key='promotion::promotion.promotion_price'}</th>
				</tr>
			</thead>
			<!-- {foreach from=$promotion_list.item item=item key=key} -->
			<tr>
				<td class="big">
					<a class="data-pjax" href="{url path='promotion/admin/edit' args="id={$item.goods_id}"}" title="{$item.goods_name}" >
						<img class="thumbnail" alt="{$item.goods_name}" src="{$item.goods_thumb}">
					</a>
				</td>
				<td class="ecjiafc-red">{$item.merchants_name}</td>
				<td class="hide-edit-area">
					<span class="{if ($time >= $item.promote_start_date) && ($time <= $item.promote_end_date)}ecjiafc-red{/if}" >{$item.goods_name}</span><br>
					<div class="edit-list">
						<a class="data-pjax" href='{RC_Uri::url("promotion/admin/edit", "id={$item.goods_id}")}' title="{lang key='system::system.edit'}">{lang key='system::system.edit'}</a>&nbsp;|&nbsp;
						<a data-toggle="ajaxremove" class="ajaxremove ecjiafc-red" data-msg="{lang key='promotion::promotion.drop_confirm'}" href='{RC_Uri::url("promotion/admin/remove", "id={$item.goods_id}")}' title="{lang key='system::system.drop'}">{lang key='system::system.drop'}</a>
				    </div>
				</td>
				<td>{$item.start_time}</td>
				<td>{$item.end_time}</td>
				<td>{$item.promote_price}</td>
			</tr>
			<!-- {foreachelse} -->
			<tr><td class="no-records" colspan="6">{lang key='system::system.no_records'}</td></tr>
			<!-- {/foreach} -->
		</table>
		<!-- {$promotion_list.page} -->
	</div>
</div>
<!-- {/block} -->