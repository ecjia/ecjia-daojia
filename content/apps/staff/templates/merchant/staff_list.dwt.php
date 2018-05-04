<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.merchant.staff_list.init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->
<div class="row">
	<div class="col-lg-12">
		<h2 class="page-header">
			{$group_name} — <!-- {if $ur_here}{$ur_here}{/if} -->
			<div class="pull-right">
				{if $action_link_group}
				<a href="{$action_link_group.href}" class="btn btn-primary data-pjax">
					<i class="fa fa-reply"></i> {$action_link_group.text}
				</a>
				{/if}
				
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
						<input type="text" class="form-control" name="keywords" value="{$smarty.get.keywords}" placeholder="{lang key='staff::staff.staff_keywords'}"/> 
						<button type="button" class="btn btn-primary"><i class="fa fa-search"></i> {lang key='staff::staff.search'} </button>
					</div>
				</form>
			</div>
			<div class="panel-body panel-body-small">
				<section class="panel">
					<table class="table table-striped table-advance table-hover">
						<thead>
							<tr>
								<th>{lang key='staff::staff.staff_name'}({lang key='staff::staff.staff_nick_name'})</th>
								<th>{lang key='staff::staff.staff_id'}</th>
								<th>{lang key='staff::staff.staff_mobile'}</th>
								<th>{lang key='staff::staff.staff_email'}</th>
								<th>{lang key='staff::staff.staff_lasttime'}</th>
								<th>{lang key='staff::staff.operate'}</th>
							</tr>
						</thead>
						<tbody>
							<!-- {foreach from=$staff_list.staff_list item=list} -->
							<tr>
								<td>{$list.name}{if $list.nick_name}({$list.nick_name}){/if}{if $list.group_name} <small class="label label-warning">{$list.group_name}</small>{/if}</td>
								<td>{$list.user_ident}</td>
								<td>{$list.mobile}</td>
								<td>{$list.email}</td>
								<td>{$list.last_login}</td>
								<td>
									{if $list.group_id neq '-1' and $list.group_id neq '-2'}
										<a class="data-pjax" href='{RC_Uri::url("staff/merchant/allot", "user_id={$list.user_id}")}' title="分配权限"><button class="btn btn-primary btn-xs"><i class="fa fa-cog"></i></button></a>
									{/if}
									<a class="data-pjax" href='{RC_Uri::url("staff/mh_log/init", "user_id={$list.user_id}")}' title="{lang key='staff::staff.view_log'}"><button class="btn btn-primary btn-xs"><i class="fa fa-file-text-o"></i></button></a>
									<a class="data-pjax" href='{RC_Uri::url("staff/merchant/edit", "user_id={$list.user_id}&parent_id={$list.parent_id}")}' title="{lang key='system::system.edit'}"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></button></a>
									<a class="ajaxremove no-underline" data-toggle="ajaxremove" data-msg="{lang key='staff::staff.staff_confirm'}" href='{url path="staff/merchant/remove" args="user_id={$list.user_id}"}' title="{lang key='system::system.drop'}"><button class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></button></a>
								</td>
							</tr>
							<!-- {foreachelse} -->
							   <tr><td class="no-records" colspan="6">{lang key='system::system.no_records'}</td></tr>
							<!-- {/foreach} -->
						</tbody>
					</table>
				</section>
				<!-- {$staff_list.page} -->
			</div>
		</div>
	</div>
</div>
<!-- {/block} -->