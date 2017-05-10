<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.wechat_menus_list.init();
</script>
<!-- {/block} -->
<!-- {block name="main_content"} -->
{if $warn}
	{if $type eq 0}
	 	<div class="alert alert-error">
	        <strong>{lang key='wechat::wechat.label_notice'}</strong>{$type_error}
	    </div>
	{/if}
{/if}

{if $errormsg}
 	<div class="alert alert-error">
        <strong>{lang key='wechat::wechat.label_notice'}</strong>{$errormsg}
    </div>
{/if}

{platform_account::getAccountSwtichDisplay('wechat')}

<div>
	<h3 class="heading">
		{lang key='wechat::wechat.label_notice'}
	</h3>
</div>
<div style="margin-left: 20px;">
	<div><button type="button" class="ajaxmenu  btn" data-url='{RC_Uri::url("wechat/admin_menus/get_menu")}'>{lang key='wechat::wechat.get_menu'}</button><span style="margin-left: 20px;">{lang key='wechat::wechat.get_menu_notice'}</span></div><br/>
	<div><button type="button" class="ajaxmenu  btn" data-url='{RC_Uri::url("wechat/admin_menus/delete_menu")}' data-msg="{lang key='wechat::wechat.clear_menu_confirm'}">{lang key='wechat::wechat.clear_menu'}</button><span style="margin-left: 20px;">{lang key='wechat::wechat.clear_menu_notice'}</span></div><br/>
	<div><button type="button" class="ajaxmenu  btn" data-url='{RC_Uri::url("wechat/admin_menus/sys_menu")}'>{lang key='wechat::wechat.make_menu'}</button><span style="margin-left: 20px;">{lang key='wechat::wechat.make_menu_notice'}</span></div>
</div>
<br/>
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		{if $action_link}
		<a class="btn plus_or_reply data-pjax" href="{$action_link.href}" id="sticky_a"><i class="fontello-icon-plus"></i>{$action_link.text}</a>
		{/if}
	</h3>
</div>

<div class="row-fluid list-page">
	<div class="span12">	
		<div class="row-fluid">	
			<table class="table table-striped smpl_tbl table-hide-edit" style="table-layout:fixed;">
				<thead>
					<tr>
						<th class="w180">{lang key='wechat::wechat.menu_name'}</th>
						<th class="w110">{lang key='wechat::wechat.menu_keywords'}</th>
						<th class="w200">{lang key='wechat::wechat.menu_url'}</th>
						<th class="w80">{lang key='wechat::wechat.status'}</th>
						<th class="w80">{lang key='wechat::wechat.sort'}</th>
						<th class="w80">{lang key='wechat::wechat.operate'}</th>
					</tr>
				</thead>
				<tbody>
					<!-- {foreach from=$listdb.menu_list item=val} -->
						<tr>
							<td>{$val.name}</td>
							<td>{$val.key}</td>
							<td>{$val.url}</td>
							<td><i class="{if $val.status eq '1'}fontello-icon-ok cursor_pointer{else}fontello-icon-cancel cursor_pointer{/if}" data-trigger="toggleState" data-url="{RC_Uri::url('wechat/admin_menus/toggle_show')}" data-id="{$val.id}" ></i></td>
							<td><span class="cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('wechat/admin_menus/edit_sort')}" data-name="sort" data-pk="{$val.id}"  data-title="{lang key='wechat::wechat.edit_sort'}">{$val.sort}</span></td>
							<td>
								<span>
									{assign var=edit_url value=RC_Uri::url('wechat/admin_menus/edit',"id={$val.id}")}
									<a class="data-pjax no-underline" href="{$edit_url}" title="{lang key='system::system.edit'}"><i class="fontello-icon-edit"></i></a>
									<a class="ajaxremove no-underline" data-toggle="ajaxremove" data-msg="{t}您确定要删除菜单[{$val.name}]吗？{/t}" href='{RC_Uri::url("wechat/admin_menus/remove","id={$val.id}")}' title="{lang key='system::system.drop'}"><i class="fontello-icon-trash"></i></a>
								</span>
							</td>
						</tr>
						<!-- {foreach $val.sub_button item=v} -->
						<tr>
							<td>&nbsp;|---&nbsp;&nbsp;{$v.name}</td>
							<td>{$v.key}</td>
							<td class="ecjiaf-pre ecjiaf-wsn">{$v.url}</td>
							<td><i class="{if $v.status eq '1'}fontello-icon-ok cursor_pointer{else}fontello-icon-cancel cursor_pointer{/if}" data-trigger="toggleState" data-url="{RC_Uri::url('wechat/admin_menus/toggle_show')}" data-id="{$v.id}" ></i></td>
							<td><span class="cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('wechat/admin_menus/edit_sort')}" data-name="sort" data-pk="{$v.id}"  data-title="{lang key='wechat::wechat.edit_sort'}">{$v.sort}</span></td>
							<td>
								<span>
									{assign var=edit_url value=RC_Uri::url('wechat/admin_menus/edit',"id={$v.id}")}
									<a class="data-pjax no-underline" href="{$edit_url}" title="{lang key='system::system.edit'}"><i class="fontello-icon-edit"></i></a>
									<a class="ajaxremove no-underline" data-toggle="ajaxremove" data-msg="{t}您确定要删除菜单[{$v.name}]吗？{/t}" href='{RC_Uri::url("wechat/admin_menus/remove","id={$v.id}")}' title="{lang key='system::system.drop'}"><i class="fontello-icon-trash"></i></a>
								</span>
							</td>
						</tr>
						<!-- {/foreach} -->
						<!--  {foreachelse} -->
					<tr><td class="no-records" colspan="6">{lang key='system::system.no_records'}</td></tr>
					<!-- {/foreach} -->
				</tbody>
			</table>
		</div>
	</div>
</div> 
<!-- {/block} -->