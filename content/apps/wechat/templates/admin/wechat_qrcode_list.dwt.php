<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.wechat_qrcode_list.init();
</script>
<!-- {/block} -->
<!-- {block name="main_content"} -->

<!-- {if $warn} -->
	<!-- {if $type neq 2} -->
		<div class="alert alert-error">
			<strong>{lang key='wechat::wechat.label_notice'}</strong>{$type_error}
		</div>
	<!-- {/if} -->
<!-- {/if} -->	

{if $errormsg}
 	<div class="alert alert-error">
        <strong>{lang key='wechat::wechat.label_notice'}</strong>{$errormsg}
    </div>
{/if}

{platform_account::getAccountSwtichDisplay('wechat')}

<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		{if $action_link}
		<a class="btn plus_or_reply data-pjax" href="{$action_link.href}" id="sticky_a"><i class="fontello-icon-plus"></i>{$action_link.text}</a>
		{/if}
	</h3>
</div>

<!-- 批量操作和搜索 -->
<div class="row-fluid batch" >
	<form method="post" action="{$search_action}" name="searchForm">
		<div class="btn-group f_l m_r5">
			<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
				<i class="fontello-icon-cog"></i>{lang key='wechat::wechat.batch_operate'}
				<span class="caret"></span>
			</a>
			<ul class="dropdown-menu">
				<li><a class="button_remove" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url='{url path="wechat/admin_qrcode/batch"}'  data-msg="{lang key='wechat::wechat.remove_qrcode_confirm'}" data-noSelectMsg="{lang key='wechat::wechat.select_operate_qrcode'}" data-name="id" href="javascript:;"><i class="fontello-icon-trash"></i>{lang key='wechat::wechat.remove_qrcode'}</a></li>
			</ul>
		</div>
		<div class="choose_list f_r" >
			<input type="text" name="keywords" value="{$listdb.filter.keywords}" placeholder="{lang key='wechat::wechat.qrcode_search_placeholder'}"/>
			<button class="btn search_qrcode" type="button">{lang key='wechat::wechat.search'}</button>
		</div>
	</form>
</div>

<div class="row-fluid list-page">
	<div class="span12">	
		<div class="row-fluid">	
			<table class="table table-striped smpl_tbl table-hide-edit">
				<thead>
					<tr>
						<th class="table_checkbox"><input type="checkbox" name="select_rows" data-toggle="selectall" data-children=".checkbox"/></th>
						<th class="w250">{lang key='wechat::wechat.application_adsense'}</th>
						<th class="w200">{lang key='wechat::wechat.qrcode_type'}</th>
						<th class="w200">{lang key='wechat::wechat.function'}</th>
						<th class="w150">{lang key='wechat::wechat.status'}</th>
						<th class="w100">{lang key='wechat::wechat.sort'}</th>
					</tr>
				</thead>
				<tbody>
					<!-- {foreach from=$listdb.qrcode_list item=val} -->
						<tr>
							<td>
								<span><input type="checkbox" name="checkboxes[]" class="checkbox" value="{$val.id}"/></span>
							</td>
							<td class="hide-edit-area">
								{$val.scene_id}
					    		<div class="edit-list">
							     	{assign var=view_url value=RC_Uri::url('wechat/admin_qrcode/qrcode_get',"id={$val.id}")}
						      		<a class="ajaxwechat" href="{$view_url}">{lang key='wechat::wechat.get_qrcode'}</a>&nbsp;|&nbsp;
						      		<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg="{lang key='wechat::wechat.remove_qrcode_confirm'}" href='{RC_Uri::url("wechat/admin_qrcode/remove","id={$val.id}")}'>{lang key='system::system.drop'}</a>
							    </div>
							</td>
							<td>
								{if $val.type eq 0}{lang key='wechat::wechat.qrcode_short'}{else}{lang key='wechat::wechat.qrcode_forever'}{/if}
							</td>
							<td>
								{$val.function}
							</td>
							<td>
                                <i class="{if $val.status eq 1}fontello-icon-ok cursor_pointer{else}fontello-icon-cancel cursor_pointer{/if}" data-trigger="toggleState" data-url="{RC_Uri::url('wechat/admin_qrcode/toggle_show')}" data-id="{$val.id}" ></i>
							</td>
							<td><span class="cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('wechat/admin_qrcode/edit_sort')}" data-name="sort" data-pk="{$val.id}"  data-title="{lang key='wechat::wechat.edit_qrcode_sort'}">{$val.sort}</span></td>
						</tr>
						<!--  {foreachelse} -->
						<tr><td class="no-records" colspan="6">{lang key='system::system.no_records'}</td></tr>
					<!-- {/foreach} -->
				</tbody>
			</table>
			<!-- {$listdb.page} -->
		</div>
	</div>
</div> 
<!-- {/block} -->