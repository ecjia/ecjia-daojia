<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.wechat_customer.init();
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
		
<!-- {if $errormsg} -->
	<div class="alert alert-error">
    	<strong>{lang key='wechat::wechat.label_notice'}</strong>{$errormsg}
    </div>
<!-- {/if} -->

<div class="alert alert-info">
	<strong>{lang key='wechat::wechat.label_notice'}</strong>{lang key='wechat::wechat.online_customer_info'}
</div>
{platform_account::getAccountSwtichDisplay('wechat')}

<div>
	<h3 class="heading">{lang key='wechat::wechat.customer_synchro'}</h3>
</div>

<div class="row-fluid">
	<div style="margin-left: 20px;">
		<div><button type="button" class="ajaxmenu btn" data-url='{RC_Uri::url("wechat/admin_customer/get_customer")}'>{lang key='wechat::wechat.get_customer'}</button><span style="margin-left: 20px;">{lang key='wechat::wechat.get_customer_notice'}</span></div><br/>
		<div><button type="button" class="ajaxmenu btn" data-url='{RC_Uri::url("wechat/admin_customer/get_online_customer")}'>{lang key='wechat::wechat.get_online_customer'}</button><span style="margin-left: 20px;">{lang key='wechat::wechat.get_online_customer_notice'}</span></div>
	</div>
</div>

<div class="row-fluid list-page">
	<div class="span12">	
		<div>
			<h3 class="heading">
				<!-- {if $ur_here}{$ur_here}{/if} -->
				{if $action_link}
					<a class="btn plus_or_reply data-pjax" href="{$action_link.href}" id="sticky_a"><i class="fontello-icon-plus"></i>{$action_link.text}</a>
				{/if}
			</h3>
		</div>
		<div class="row-fluid">
			<ul class="nav nav-pills">
				<li class="{if $smarty.get.type neq 'online'}active{/if}"><a class="data-pjax" href='{url path="wechat/admin_customer/init"}'>{lang key='wechat::wechat.all_customer'}<span class="badge badge-info">{$list.filter.all}</span></a></li>
				<li class="{if $smarty.get.type eq 'online'}active{/if}"><a class="data-pjax" href='{url path="wechat/admin_customer/init" args="type=online"}'>{lang key='wechat::wechat.online_customer'}<span class="badge badge-info">{$list.filter.online}</span></a></li>
			</ul>
		</div>
		<table class="table table-striped smpl_tbl table-hide-edit">
			<thead>
				<tr>
					<th class="w130">{lang key='wechat::wechat.kf_headimgurl'}</th>
					<th class="w250">{lang key='wechat::wechat.kf_account'}</th>
					<th class="w200">{lang key='wechat::wechat.bind_wx'}</th>
					<th class="w200">{lang key='wechat::wechat.kf_nick'}</th>
					<th class="w150">{lang key='wechat::wechat.online_status'}</th>
					<th class="w100">{lang key='wechat::wechat.is_used'}</th>
				</tr>
			</thead>
			<tbody>
				<!-- {foreach from=$list.item item=val} -->
				<tr class="big">
					<td><img class="thumbnail" src="{$val.kf_headimgurl}"></td>
					<td class="hide-edit-area">
						{$val.kf_account}
						<div class="edit-list">
							{if $val.invite_status neq 'waiting'}
							<a class="data-pjax" href='{RC_Uri::url("wechat/admin_customer/edit", "id={$val.id}")}' title="{lang key='system::system.edit'}">{lang key='system::system.edit'}</a>&nbsp;|&nbsp;
							{/if}
							<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg="{lang key='wechat::wechat.remove_kf_confirm'}" href='{RC_Uri::url("wechat/admin_customer/remove", "id={$val.id}")}' title="{lang key='system::system.drop'}">{lang key='system::system.drop'}</a>
						</div>
					</td>

					<td>
						{if $val.status eq 1}
							{if $val.kf_wx}
								{$val.kf_wx}
							{elseif $val.invite_wx}
								
								{if $val.invite_status eq 'waiting'}
									{$val.invite_wx}<br>
									<span class="ecjiafc-999">
									<!-- todo -->
									{lang key='wechat::wechat.invite_waiting'}<a class="hint--bottom hint--rounded" data-hint="绑定邀请已发送至 {$val.invite_wx} 的微信，请去微信客户端确认后即可绑定"><i class="fontello-icon-help-circled"></i></a>
									</span>
								{elseif $val.invite_status eq 'rejected'}
									<a class="bind_wx" data-toggle="modal" href="#bind_wx" title="{lang key='wechat::wechat.bind_wx'}" data-val="{$val.kf_account}">{lang key='wechat::wechat.rebind'}</a><br>
									<span class="ecjiafc-999">
									{lang key='wechat::wechat.invite_rejected'}<a class="hint--bottom  hint--rounded" data-hint="{lang key='wechat::wechat.rejected_rebind_notice'}"><i class="fontello-icon-help-circled"></i></a>
									</span>
								{elseif $val.invite_status eq 'expired'}
									<a class="bind_wx" data-toggle="modal" href="#bind_wx" title="{lang key='wechat::wechat.bind_wx'}" data-val="{$val.kf_account}">{lang key='wechat::wechat.rebind'}</a><br>
									{lang key='wechat::wechat.invite_expired'}<a class="hint--bottom  hint--rounded" data-hint="{lang key='wechat::wechat.expired_rebind_notice'}"><i class="fontello-icon-help-circled"></i></a>
								{/if}
							{else}
								<a class="bind_wx" data-toggle="modal" href="#bind_wx" title="{lang key='wechat::wechat.bind_wx'}" data-val="{$val.kf_account}">{lang key='wechat::wechat.binding_wx'}</a><br>
								<span class="ecjiafc-999">
									{lang key='wechat::wechat.not_bind'}<a class="hint--bottom  hint--rounded" data-hint="{lang key='wechat::wechat.complete_bind_notice'}"><i class="fontello-icon-help-circled"></i></a>
								</span>
							{/if}
						{else}
							<span class="ecjiafc-999">{lang key='wechat::wechat.kf_account_disabled'}</span>
						{/if}
					</td>
					<td>
						<span class="cursor_pointer" data-text="text" data-trigger="editable" data-url='{RC_Uri::url("wechat/admin_customer/edit_nick")}' data-name="{$val.kf_nick}" data-pk="{$val.id}" data-title="{lang key='wechat::wechat.edit_kf_nick'}" >{$val.kf_nick}</span>
					</td>
					<td class="{if $val.online_status}ecjiafc-red{/if}">
						{if $val.online_status eq 1}
							{lang key='wechat::wechat.web_online'}
						{elseif $val.online_status eq 0}
							{lang key='wechat::wechat.not_online'}
						{/if}
					</td>
					<td>
						<!-- todo -->
                        	<i class="{if $val.status eq 1}fontello-icon-ok cursor_pointer{else}fontello-icon-cancel cursor_pointer{/if}" data-trigger="toggle_CustomerState" data-url="{RC_Uri::url('wechat/admin_customer/toggle_show')}" data-id="{$val.id}" data-msg="{if $val.status}关闭客服[{$val.kf_account}]将在微信端删除该客服，{else}开启客服[{$val.kf_account}]将在微信端添加该客服，{/if}您确定要这么做吗？"></i>
						</td>
					</tr>
					<!--  {foreachelse} -->
				<tr><td class="no-records" colspan="6">{lang key='system::system.no_records'}</td></tr>
				<!-- {/foreach} -->
			</tbody>
		</table>
	</div>
</div>

<div class="modal hide fade" id="bind_wx">
	<div class="modal-header">
		<button class="close" data-dismiss="modal">×</button>
		<h3>{lang key='wechat::wechat.bind_wx'}</h3>
	</div>
	<div class="modal-body" id="bind_modal">
		<div class="row-fluid edit-page">
			<div class="span12">
			<!-- {if $errormsg} -->
			    <div class="alert alert-error">
		            <strong>{lang key='wechat::wechat.label_notice'}</strong>{$errormsg}
		        </div>
			<!-- {/if} -->
			
			<!-- {if $warn} -->
				<!-- {if $type eq 0} -->
				<div class="alert alert-error">
					<strong>{lang key='wechat::wechat.label_notice'}</strong>{$type_error}
				</div>
				<!-- {/if} -->
			<!-- {/if} -->
				<form class="form-horizontal" method="post" name="bind_form" action="{url path='wechat/admin_customer/bind_wx'}">
					<fieldset>
						<div class="w330 m_0">
							<div class="m_b5 m_l10">{lang key='wechat::wechat.label_kf_wx_required'}</div>
							<div class="ecjiaf-tac m_b10">
								<input type="text" name="kf_wx" value="{$smarty.get.kf_wx}" autocomplete="off"/>
								<input type="hidden" name="kf_account" />
								<input type="submit" value="{lang key='wechat::wechat.invite_bind'}" class="btn btn-gebo m_l5" {if $errormsg || $warn && $type eq 0}disabled{/if}/>
							</div>
						</div>
					</fieldset>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- {/block} -->