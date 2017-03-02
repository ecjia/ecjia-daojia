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
								<option value="0">{t}全部IP{/t}</option>
								<!-- {foreach from=$ip_list item=list} -->
								<option value="{$list}" {if $list eq $smarty.get.ip}selected="selected"{/if}>{$list}</option>
								<!-- {/foreach} -->
							</select>
						</div>
						<div class="form-group">
							<select class="w110" name="userid">
								<option value="0">{t}全部管理员{/t}</option>
								<!-- {foreach from=$user_list item=list key=key} -->
								<option value="{$key}" {if $key eq $smarty.get.user_id}selected="selected"{/if}>{$list}</option>
								<!-- {/foreach} -->
							</select>
						</div>
						
						<button class="btn btn-primary screen-btn" type="submit"><i class="fa fa-search"></i> {lang key='staff::staff.filter'} </button>
					</div>
				</form>
				<form class="form-inline pull-right" name="searchForm" method="post" action="{$form_search_action}">
					<div class="form-group">
						<!-- 关键字 -->
						<input type="text" class="form-control" name="keyword" value="{$smarty.get.keyword}" placeholder="{lang key='staff::staff.keyword'}"/> 
						<button class="btn btn-primary" type="submit">{lang key='staff::staff.search'}</button>
					</div>
				</form>
			</div>
			<div class="panel-body panel-body-small">
				<section class="panel">
					<table class="table table-striped table-advance table-hover">
						<thead>
							<tr>
								<th class="w30">{lang key='staff::staff.log_id'}</th>
								<th class="w100">{lang key='staff::staff.log_name'}</th>
								<th class="w150">{lang key='staff::staff.log_time'}</th>
								<th class="w150">{lang key='staff::staff.log_ip'}</th>
								<th class="w250">{lang key='staff::staff.log_info'}</th>
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
							   <tr><td class="no-records" colspan="5">{lang key='system::system.no_records'}</td></tr>
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