<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.merchant.staff_group_list.init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->
<div class="row">
	<div class="col-lg-12">
		<h2 class="page-header">
			<!-- {if $ur_here}{$ur_here}{/if} -->
			<div class="pull-right">
				{if $action_link}
				<a href="{$action_link.href}" class="btn btn-primary data-pjax">
					<i class="fa fa-plus"></i> {$action_link.text}
				</a>
				{/if}
			</div>
		</h2>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="panel">
			<div class="panel-body panel-body-small">
				<form class="form-inline pull-right" name="searchForm" method="post" action="{$search_action}">
					<div class="form-group">
						<input type="text" class="form-control" name="keywords" value="{$smarty.get.keywords}" placeholder="{t}请输入员工组名称{/t}"/> 
						<button type="button" class="btn btn-primary"><i class="fa fa-search"></i> {lang key='staff::staff.search'}</button>
					</div>
				</form>
			</div>
			<div class="panel-body panel-body-small">
				<section class="panel">
					<table class="table table-striped table-advance table-hover">
						<thead>
							<tr>
								<th>{lang key='staff::staff.group_id'}</th>
								<th>{lang key='staff::staff.group_name'}</th>
								<th>{lang key='staff::staff.group_desc'}</th>
								<th>{lang key='staff::staff.operate'}</th>
							</tr>
						</thead>
						<tbody>
							<!-- {foreach from=$staff_group_list.staff_group_list item=list} -->
							<tr>
								<td>{$list.group_id}</td>
								<td>{$list.group_name}</td>
								<td>{$list.groupdescribe}</td>
								<td>
									<a class="data-pjax" href='{RC_Uri::url("staff/mh_group/edit", "group_id={$list.group_id}")}'><button class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></button></a>
									<a class="ajaxremove no-underline" data-toggle="ajaxremove" data-msg="{lang key='staff::staff.staff_group_confirm'}" href='{url path="staff/mh_group/remove" args="group_id={$list.group_id}"}'><button class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></button></a>
								</td>
							</tr>
							<!-- {foreachelse} -->
							   <tr><td class="no-records" colspan="10">{lang key='system::system.no_records'}</td></tr>
							<!-- {/foreach} -->
						</tbody>
					</table>
				</section>
				<!-- {$staff_group_list.page} -->
			</div>
		</div>
	</div>
</div>
<!-- {/block} -->