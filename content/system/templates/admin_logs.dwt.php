<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.admin_logs.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
	<div>
		<h3 class="heading">
			<!-- {if $ur_here}{$ur_here}{/if} -->
		</h3>
	</div>
	<div class="row-fluid">
		<div class="control-group form-horizontal choose_list span12">
			<form name="deleteForm" method="post" action="{url path='@admin_logs/batch_drop'}">
				<!-- 批量删除 -->
				<select class="w110" name="log_date">
					<option value="0">{t}选择日期{/t}</option>
					<option value="1">{t}一周之前{/t}</option>
					<option value="2">{t}一个月前{/t}</option>
					<option value="3">{t}三个月前{/t}</option>
					<option value="4">{t}半年之前{/t}</option>
					<option value="5">{t}一年之前{/t}</option>
				</select>
				<input type="hidden" name="drop_type_date" value="true" />
				<button class="btn f_l" type="submit">{t}批量删除{/t}</button>
			</form>
			<form name="siftForm" method="post" action="{url path='@admin_logs/init'}">
				<span class="separ">&nbsp;</span>
				<select class="w120" name="ip">
					<option value="0">{t}全部IP{/t}</option>
					<!-- {foreach from=$ip_list item=list} -->
					<option value="{$list}" {if $list eq $smarty.get.ip}selected="selected"{/if}>{$list}</option>
					<!-- {/foreach} -->
				</select>
				<select class="w130" name="userid">
					<option value="0">{t}全部管理员{/t}</option>
					<!-- {foreach from=$user_list item=list key=key} -->
					<option value="{$key}" {if $key eq $smarty.get.user_id}selected="selected"{/if}>{$list}</option>
					<!-- {/foreach} -->
				</select>
				<button class="btn f_l" type="submit">{t}筛选{/t}</button>
			</form>
			<form class="f_r" name="searchForm" method="post" action="{url path='@admin_logs/init'}">
				<!-- 关键字 -->
				<input type="text" name="keyword" size="15" placeholder="{t}请输入关键字{/t}" />
				<button class="btn" type="submit">{t}搜索{/t}</button>
			</form>
		</div>
		<table class="table table-striped" id="smpl_tbl">
			<thead>
				<tr>
					<th class="w50">{t}编号{/t}</th>
					<th class="w120">{t}操作者{/t}</th>
					<th class="w150">{t}操作日期{/t}</th>
					<th class="w120">{t}IP地址{/t}</th>
					<th>{t}操作记录{/t}</th>
				</tr>
			</thead>
			<tbody>
				<!-- {foreach from=$logs.list item=list} -->
				<tr>
					<td class="first-cell" >{$list.log_id}</td>
					<td align="left">{$list.user_name|escape:html}</td>
					<td align="center">{$list.log_time}</td>
					<td align="center">{$list.ip_address}</td>
					<td align="center">{$list.log_info}</td>
				</tr>
				<!-- {foreachelse} -->
				<tr>
					<td class="no-records" colspan="10">{t}没有找到任何记录{/t}</td>
				</tr>
				<!-- {/foreach} -->
			</tbody>
		</table>
		<!-- {$logs.page} -->
	</div>
<!-- {/block} -->