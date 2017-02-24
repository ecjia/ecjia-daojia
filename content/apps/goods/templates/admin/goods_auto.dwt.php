<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->
<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.goods_auto.init();
</script>
<!-- {/block} -->
<!-- {block name="main_content"} -->
{if $crons_enable neq 1}
<div class="alert alert-info">
	<strong>{lang key='goods::goods_auto.label_notice'}</strong>{lang key='goods::goods_auto.enable_notice'}
</div>
{/if}
<div>
	<h3 class="heading">
	<!-- {if $ur_here}{$ur_here}{/if} -->
		{if $action_link}
	<a href="{$action_link.href} data-pjax" class="btn plus_or_reply" id="sticky_a"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		{/if}
	</h3>
</div>
<div class="row-fluid list-page">
	<div class="span12">
		<div class="row-fluid batch">
			<div class="f_l form-inline">
				<input type="text" name="select_time" class="w150 date" placeholder="{lang key='goods::goods_auto.select_time'}">
				<a class="btn btnSubmit" data-idclass=".checkbox:checked" data-url='{url path="goods/admin_goods_auto/batch_start"}' data-msg="{lang key='goods::goods_auto.batch_start_confirm'}" data-noselectmsg="{lang key='goods::goods_auto.select_start_goods'}" data-name="goods_id" href="javascript:;">{lang key='goods::goods_auto.button_start'}</a>
				<a class="btn btnSubmit" data-idclass=".checkbox:checked" data-url='{url path="goods/admin_goods_auto/batch_end"}' data-msg="{lang key='goods::goods_auto.batch_end_confirm'}" data-noselectmsg="{lang key='goods::goods_auto.select_end_goods'}" data-name="goods_id" href="javascript:;">{lang key='goods::goods_auto.button_end'}</a>
			</div>
			<div class="choose_list f_r" data-url="{$search_action}">
				<input type="text" name="keywords" value="{$smarty.get.keywords}" placeholder="{lang key='goods::goods_auto.goods_name_keywords'}"/>
				<button class="btn search_goods" type="button">{lang key='goods::goods_auto.search'}</button>
			</div>
		</div>
		<div class="row-fluid">
			<table class="table table-striped smpl_tbl">
			<thead>
			<tr>
				<th class="table_checkbox">
					<input type="checkbox" name="select_rows" data-toggle="selectall" data-children=".checkbox"/>
				</th>
				<th class="w70">
					{lang key='goods::goods_auto.id'}
				</th>
				<th>
					{lang key='goods::goods_auto.goods_name'}
				</th>
				<th class="w180">
					{lang key='goods::goods_auto.starttime'}
				</th>
				<th class="w180">
					{lang key='goods::goods_auto.endtime'}
				</th>
				<th class="w70">
					{lang key='system::system.handler'}
				</th>
			</tr>
			</thead>
			<tbody>
			<!-- {foreach from=$goodsdb.item item=val} -->
			<tr>
				<td>
					<input name="checkboxes[]" type="checkbox" value="{$val.goods_id}" class="uni_style checkbox"/>
				</td>
				<td>
					{$val.goods_id}
				</td>
				<td>
					{$val.goods_name}
				</td>
				<td>
					<!-- {if $val.starttime} -->
					<span class="cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('goods/admin_goods_auto/edit_starttime')}" data-name="goods_start_time" data-pk="{$val.starttime}" data-title="{lang key='goods::goods_auto.select_start_time'}"> 
						{$val.starttime}
					</span>
					<!-- {else} -->
						0000-00-00
					<!-- {/if} -->
				</td>
				<td>
					<!-- {if $val.endtime} -->
					<span class="cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('goods/admin_goods_auto/edit_endtime')}" data-name="goods_end_time" data-pk="{$val.endtime}" data-title="{lang key='goods::goods_auto.select_end_time'}"> 
						{$val.endtime}
					</span>
					<!-- {else} -->
						0000-00-00
					<!-- {/if} -->
				</td>
				<td>
					<span>
					{if $val.endtime || $val.starttime}
					<a class="ajax-remove" data-toggle="ajaxremove" data-msg="{lang key='goods::goods_auto.delete_confirm'}" href='{RC_Uri::url("goods/admin_goods_auto/del", "id={$val.goods_id}")}' title="{t}撤销{/t}"><i class="fontello-icon-export-alt"></i></a>
					{else}
						-
					{/if}
					</span>
				</td>
			</tr>
			<!-- {foreachelse} -->
			<tr>
				<td class="no-records" colspan="10">
					{lang key='system::system.no_records'}
				</td>
			</tr>
			<!-- {/foreach} -->
			</tbody>
			</table>
			<!-- {$goodsdb.page} -->
		</div>
	</div>
</div>
<!-- {/block} -->