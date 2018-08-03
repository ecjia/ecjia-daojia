<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.merchant.platform.init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->

<div class="page-header">
	<div class="pull-left">
		<h2><!-- {if $ur_here}{$ur_here}{/if} --></h2>
  	</div>
  	<div class="pull-right">
  		{if $action_link}
		<a href="{$action_link.href}" class="btn btn-primary data-pjax">
			<i class="fa fa-plus"></i> {$action_link.text}
		</a>
		{/if}
  	</div>
  	<div class="clearfix"></div>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="panel">
			<div class="panel-body panel-body-small">
				<div class="btn-group f_l">
					<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><i class="fa fa-cogs"></i> {lang key='goods::goods.batch_handle'} <span class="caret"></span></button>
					<ul class="dropdown-menu">
						<li><a class="button_remove" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url='{url path="platform/merchant/batch_remove"}'  data-msg="{lang key='platform::platform.sure_want_do'}" data-noSelectMsg="{lang key='platform::platform.delete_selected_plat'}" data-name="id" href="javascript:;"><i class="fa fa-trash-o"></i> {lang key='platform::platform.platform_del'}</a></li>
		           	</ul>
				</div>
				
				<form class="form-inline f_l m_l5" action="{RC_Uri::url('platform/merchant/init')}{if $smarty.get.type}&type={$smarty.get.type}{/if}" method="post" name="filter_form">
					<div class="screen f_l">
						<div class="form-group">
							<select class="w130 form-control" name="platform" id="select_type">
								<option value=''  		{if $smarty.get.platform eq ''}			selected="true"{/if}>{lang key='platform::platform.all_platform'}</option>
								<option value='wechat' 	{if $smarty.get.platform eq 'wechat'}	selected="true"{/if}>{lang key='platform::platform.weixin'}</option>
							</select>
						</div>
						<button class="btn btn-primary screen-btn" type="button"><i class="fa fa-search"></i> {lang key='platform::platform.filtrate'} </button>
					</div>
				</form>
				
				<form class="form-inline f_r" action="{$search_action}" method="post" name="searchForm">
					<div class="screen f_r">
						<div class="form-group">
							<input class="form-control" type="text" name="keywords" value="{$smarty.get.keywords}" placeholder="{lang key='platform::platform.input_plat_name_key'}"/>
						</div>
						<button class="btn btn-primary search_wechat" type="submit"><i class="fa fa-search"></i> 搜索 </button>
					</div>
				</form>
			</div>
			
			<div class="panel-body panel-body-small">
				<section class="panel">
					<table class="table table-striped table-hover table-hide-edit ecjiaf-tlf">
						<thead>
							<tr>
								<th class="table_checkbox check-list w30">
									<div class="check-item">
										<input id="checkbox_all" type="checkbox" name="select_rows" data-toggle="selectall" data-children=".checkbox"/><label for="checkbox_all"></label>
									</div>
								</th>
								<th class="w80">{lang key='platform::platform.logo'}</th>
								<th class="w200">{lang key='platform::platform.platform_name'}</th>
								<th class="w50">{lang key='platform::platform.terrace'}</th>
								<th class="w100">{lang key='platform::platform.platform_num_type'}</th>
								<th class="w50">{lang key='platform::platform.status'}</th>
								<th class="w50">{lang key='platform::platform.sort'}</th>
								<th class="w100">{lang key='platform::platform.add_time'}</th>
							</tr>
						</thead>
						<tbody>
							<!-- {foreach from=$wechat_list.item item=val} -->
							<tr class="big">
								<td class="check-list">
									<div class="check-item"><input id="checkbox_{$val.id}" type="checkbox" name="checkboxes[]" class="checkbox" value="{$val.id}"/><label for="checkbox_{$val.id}"></label></div>
								</td>
								<td><img class="thumbnail" src="{$val.logo}"></td>
								<td class="hide-edit-area">
									{$val.name}<br>
									<div class="edit-list">
										<a target="__blank" href='{RC_Uri::url("platform/merchant/autologin","id={$val.id}")}' title="进入管理">进入管理</a> &nbsp;|&nbsp;
								      	<a class="data-pjax" href='{RC_Uri::url("platform/merchant/edit", "id={$val.id}")}' title="{lang key='system::system.edit'}">{lang key='platform::platform.edit'}</a> &nbsp;|&nbsp;
								     	<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg="{t}您确定要删除公众号[{$val.name}]吗？{/t}" href='{RC_Uri::url("platform/merchant/remove","id={$val.id}")}' title="{lang key='platform::platform.delete'}">{lang key='platform::platform.delete'}</a>
							     	</div>
								</td>
								<td>
									{if $val.platform eq 'wechat'}
										{lang key='platform::platform.weixin'}
									{/if}
								</td>
								<td>
									{if $val.type eq 0}
										{lang key='platform::platform.un_platform_num'}
									{elseif $val.type eq 1}
										{lang key='platform::platform.subscription_num'}
									{elseif $val.type eq 2}
										{lang key='platform::platform.server_num'}
									{elseif $val.type eq 3}
										{lang key='platform::platform.test_account'}
									{/if}
								</td>
								<td>
							        <i class="fa {if $val.status eq 1}fa-check{else}fa-times{/if} cursor_pointer" data-trigger="toggleState" data-url="{RC_Uri::url('platform/merchant/toggle_show')}" data-id="{$val.id}" ></i>
								</td>
								<td><span class="cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('platform/merchant/edit_sort')}" data-name="sort" data-pk="{$val.id}"  data-title="{lang key='platform::platform.edit_plat_sort'}">{$val.sort}</span></td>
								<td>
									{$val.add_time}
								</td>
							</tr>
							<!--  {foreachelse} -->
							<tr><td class="no-records" colspan="8">{lang key='system::system.no_records'}</td></tr>
							<!-- {/foreach} -->
						</tbody>
					</table>
				</section>
				<!-- {$wechat_list.page} -->
			</div>
		</div>
	</div>
</div>
<!-- {/block} -->