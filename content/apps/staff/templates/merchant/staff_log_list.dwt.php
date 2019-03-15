<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.merchant.staff_logs.init();
</script>
<!-- {/block} -->


<!-- {block name="home-content"} -->

<div class="row">
	<div class="col-lg-12">
		<h2 class="page-header">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		</h2>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="panel">
			<div class="panel-body panel-body-small">
				<form class="form-inline pull-left" name="siftForm" action="{$form_search_action}" method="post">
					<div class="screen f_l">
						<div class="form-group">
							<select class="form-control"  name="ip">
								<option value="0">{t domain="staff"}全部IP{/t}</option>
								<!-- {foreach from=$ip_list item=list} -->
								<option value="{$list}" {if $list eq $smarty.get.ip}selected="selected"{/if}>{$list}</option>
								<!-- {/foreach} -->
							</select>
						</div>
						<div class="form-group">
							<select class="w110" name="userid">
								<option value="0">{t domain="staff"}全部管理员{/t}</option>
								<!-- {foreach from=$user_list item=list key=key} -->
								<option value="{$key}" {if $key eq $smarty.get.user_id}selected="selected"{/if}>{$list}</option>
								<!-- {/foreach} -->
							</select>
						</div>
						
						<button class="btn btn-primary screen-btn" type="submit"><i class="fa fa-search"></i> {t domain="staff"}筛选{/t} </button>
					</div>
				</form>
				<form class="form-inline pull-right" name="searchForm" method="post" action="{$form_search_action}">
					<div class="form-group">
						<!-- 关键字 -->
						<input type="text" class="form-control" name="keyword" value="{$smarty.get.keyword}" placeholder='{t domain="staff"}请输入关键字{/t}'/>
						<button class="btn btn-primary" type="submit">{t domain="staff"}搜索{/t}</button>
					</div>
				</form>
			</div>
			<div class="panel-body panel-body-small">
				<section class="panel">
					<table class="table table-striped table-advance table-hover">
						<thead>
							<tr>
								<th class="w30">{t domain="staff"}编号{/t}</th>
								<th class="w100">{t domain="staff"}操作者{/t}</th>
								<th class="w150">{t domain="staff"}操作日期{/t}</th>
								<th class="w150">{t domain="staff"}IP地址{/t}</th>
								<th class="w250">{t domain="staff"}操作记录{/t}</th>
							</tr>
						</thead>
						<tbody>
							<!-- {foreach from=$logs.list item=list} -->
							<tr>
								<td>{$list.log_id}</td>
								<td>{$list.name}</td>
								<td>{$list.log_time}</td>
								<td>{$list.ip_address}</td>
								<td>{$list.log_info}</td>
							</tr>
							<!-- {foreachelse} -->
							   <tr><td class="no-records" colspan="5">{t domain="staff"}没有找到任何记录{/t}</td></tr>
							<!-- {/foreach} -->
						</tbody>
					</table>
				</section>
			<!-- {$logs.page} -->
			</div>
		</div>
	</div>
</div>
<!-- {/block} -->