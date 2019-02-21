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
	<strong>{t domain="goods"}温馨提示：{/t}</strong>{t domain="goods"}您需要到工具->计划任务中开启该功能后才能使用。{/t}
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
				<input type="text" name="select_time" class="w150 date" placeholder="{t domain="goods"}请选择时间{/t}">
				<a class="btn btnSubmit" data-idclass=".checkbox:checked" data-url='{url path="goods/admin_goods_auto/batch_start"}' data-msg="{t domain="goods"}你确定要批量上架选中的商品吗？{/t}" data-noselectmsg="{t domain="goods"}请选择自动上架的商品{/t}" data-name="goods_id" href="javascript:;">{t domain="goods"}批量上架{/t}</a>
				<a class="btn btnSubmit" data-idclass=".checkbox:checked" data-url='{url path="goods/admin_goods_auto/batch_end"}' data-msg="{t domain="goods"}你确定要批量下架选中的商品吗？{/t}" data-noselectmsg="{t domain="goods"}请选择自动下架的商品{/t}" data-name="goods_id" href="javascript:;">{t domain="goods"}批量下架{/t}</a>
			</div>
			<div class="choose_list f_r" data-url="{$search_action}">
				<input type="text" name="keywords" value="{$smarty.get.keywords}" placeholder="{t domain="goods"}请输入商品名称关键字{/t}"/>
				<button class="btn search_goods" type="button">{t domain="goods"}搜索{/t}</button>
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
                    {t domain="goods"}编号{/t}
				</th>
				<th>
                    {t domain="goods"}商品名称{/t}
				</th>
				<th class="w180">
                    {t domain="goods"}上架时间{/t}
				</th>
				<th class="w180">
                    {t domain="goods"}下架时间{/t}
				</th>
				<th class="w70">
					{t domain="goods"}操作{/t}
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
					<span class="cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('goods/admin_goods_auto/edit_starttime')}" data-name="goods_start_time" data-pk="{$val.starttime}" data-title="{t domain="goods"}请选择商品自动上架时间{/t}">
						{$val.starttime}
					</span>
					<!-- {else} -->
						0000-00-00
					<!-- {/if} -->
				</td>
				<td>
					<!-- {if $val.endtime} -->
					<span class="cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('goods/admin_goods_auto/edit_endtime')}" data-name="goods_end_time" data-pk="{$val.endtime}" data-title="{t domain="goods"}请选择商品自动下架时间{/t}">
						{$val.endtime}
					</span>
					<!-- {else} -->
						0000-00-00
					<!-- {/if} -->
				</td>
				<td>
					<span>
					{if $val.endtime || $val.starttime}
					<a class="ajax-remove" data-toggle="ajaxremove" data-msg="{t domain="goods"}您确定要撤销自动上下架该商品吗？{/t}" href='{RC_Uri::url("goods/admin_goods_auto/del", "id={$val.goods_id}")}' title="{t domain="goods"}撤销{/t}"><i class="fontello-icon-export-alt"></i></a>
					{else}
						-
					{/if}
					</span>
				</td>
			</tr>
			<!-- {foreachelse} -->
			<tr>
				<td class="no-records" colspan="10">
					{t domain="goods"}没有找到任何记录{/t}
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