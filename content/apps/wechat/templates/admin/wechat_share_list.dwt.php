<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.wechat_qrcodeshare_list.init();
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

<div class="row-fluid list-page">
	<div class="span12">	
		<div class="row-fluid">	
			<table class="table table-striped smpl_tbl table-hide-edit">
				<thead>
					<tr>
						<th class="w150">{lang key='wechat::wechat.recommended_person'}</th>
						<th class="w100">{lang key='wechat::wechat.cash_into'}</th>
						<th class="w100">{lang key='wechat::wechat.scan_num'}</th>
						<th class="w150">{lang key='wechat::wechat.expire_seconds'}</th>
						<th class="w200">{lang key='wechat::wechat.function'}</th>
						<th class="w100">{lang key='wechat::wechat.sort'}</th>
					</tr>
				</thead>
				<tbody>
					<!-- {foreach from=$listdb.share_list item=val} -->
					<tr>
						<td class="hide-edit-area">
							{$val.username}
				    		<div class="edit-list">
						     	{assign var=view_url value=RC_Uri::url('wechat/admin_qrcode/qrcode_get',"id={$val.id}")}
					      		<a class="ajaxwechat" href="{$view_url}" title="{lang key='system::system.view'}">{lang key='wechat::wechat.get_qrcode'}</a>&nbsp;|&nbsp;
					      		<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg="{lang key='wechat::wechat.remove_qrcode_confirm'}" href='{RC_Uri::url("wechat/admin_share/remove","id={$val.id}")}' title="{lang key='system::system.drop'}">{lang key='system::system.drop'}</a>
						    </div>
						</td>
						<td>
							0
						</td>
						<td>
							{$val['scan_num']}
						</td>
						<td>
							{$val['expire_seconds']}
						</td>
						<td>
							{$val.function}
						</td>
						<td><span class="cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('wechat/admin_share/edit_sort')}" data-name="sort" data-pk="{$val.id}"  data-title="{lang key='wechat::wechat.edit_qrcode_sort'}">{$val.sort}</span></td>
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