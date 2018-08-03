<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-platform.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.platform.wechat_customer.init();
</script>
<!-- {/block} -->
<!-- {block name="home-content"} -->

<!-- {if $warn && $type neq 2} -->
<div class="alert alert-danger">
	<strong>{lang key='wechat::wechat.label_notice'}</strong>{$type_error}
</div>
<!-- {/if} -->		
		
<!-- {if $errormsg} -->
	<div class="alert alert-danger">
    	<strong>{lang key='wechat::wechat.label_notice'}</strong>{$errormsg}
    </div>
<!-- {/if} -->

<div class="alert alert-info">
	<strong>{lang key='wechat::wechat.label_notice'}</strong>{lang key='wechat::wechat.online_customer_info'}
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">
                	{lang key='wechat::wechat.customer_synchro'}
                </h4>
            </div>
            <div class="card-body">
				<div><button type="button" class="ajaxmenu btn btn-outline-primary" data-url='{RC_Uri::url("wechat/platform_customer/get_customer")}'>{lang key='wechat::wechat.get_customer'}</button><span style="margin-left: 20px;">{lang key='wechat::wechat.get_customer_notice'}</span></div><br/>
				<div><button type="button" class="ajaxmenu btn btn-outline-primary" data-url='{RC_Uri::url("wechat/platform_customer/get_online_customer")}'>{lang key='wechat::wechat.get_online_customer'}</button><span style="margin-left: 20px;">{lang key='wechat::wechat.get_online_customer_notice'}</span></div>
			</div>
		</div>
	</div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">
                <!-- {if $ur_here}{$ur_here}{/if} -->
				{if $action_link}
					<a class="btn btn-outline-primary data-pjax float-right" href="{$action_link.href}" id="sticky_a"><i class="ft-plus"></i>{$action_link.text}</a>
				{/if}
					<a class="btn btn-outline-primary float-right m_r10" href="https://mpkf.weixin.qq.com/" target="__blank"><i class="ft-link"></i>去微信客服中心</a>
                </h4>
            </div>
			<div class="card-body">
				<ul class="nav nav-pills float-left">
					<li class="nav-item">
						<a class="nav-link {if $smarty.get.type neq 'online'}active{/if} data-pjax" href='{url path="wechat/platform_customer/init"}'>{lang key='wechat::wechat.all_customer'}
						<span class="badge badge-pill badge-glow badge-default badge-primary ml-1">{$list.filter.all}</span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link {if $smarty.get.type eq 'online'}active{/if} data-pjax" href='{url path="wechat/platform_customer/init" args="type=online"}'>{lang key='wechat::wechat.online_customer'}
						<span class="badge badge-pill badge-glow badge-default badge-primary ml-1">{$list.filter.online}</span></a>
					</li>
				</ul>
			</div>
			<div class="col-md-12">
				<table class="table table-hide-edit">
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
						<tr>
							<td class="big"><img class="thumbnail" src="{$val.kf_headimgurl}"></td>
							<td class="hide-edit-area">
								{$val.kf_account}
								<div class="edit-list">
									{if $val.online_status eq 1}
									<a class="get_session" href='{RC_Uri::url("wechat/platform_customer/get_session", "kf_account={$val.kf_account}")}' title="获取客服会话">获取客服会话</a>&nbsp;|&nbsp;
									{/if}
									{if $val.invite_status neq 'waiting'}
									<a class="data-pjax" href='{RC_Uri::url("wechat/platform_customer/edit", "id={$val.id}")}' title="{lang key='system::system.edit'}">{lang key='system::system.edit'}</a>&nbsp;|&nbsp;
									{/if}
									<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg="{lang key='wechat::wechat.remove_kf_confirm'}" href='{RC_Uri::url("wechat/platform_customer/remove", "id={$val.id}")}' title="{lang key='system::system.drop'}">{lang key='system::system.drop'}</a>
								</div>
							</td>
		
							<td>
								{if $val.status eq 1}
									{if $val.kf_wx}
										{$val.kf_wx}
									{elseif $val.invite_wx}
										{if $val.invite_status eq 'waiting'}
											{$val.invite_wx}<br />
											<span class="ecjiafc-999">
											{lang key='wechat::wechat.invite_waiting'}<a class="hint--bottom hint--rounded" data-hint="绑定邀请已发送至 {$val.invite_wx} 的微信，请去微信客户端确认后即可绑定"><i class="fontello-icon-help-circled"></i></a>
											</span>
										{elseif $val.invite_status eq 'rejected'}
											<span class="ecjiafc-999">
											{lang key='wechat::wechat.invite_rejected'}<a class="hint--bottom  hint--rounded" data-hint="{lang key='wechat::wechat.rejected_rebind_notice'}"><i class="fontello-icon-help-circled"></i></a>
											</span><br />
											<a class="bind_wx" data-toggle="modal" href="#bind_wx" title="{lang key='wechat::wechat.bind_wx'}" data-val="{$val.kf_account}">{lang key='wechat::wechat.rebind'}</a>
										{elseif $val.invite_status eq 'expired'}
											<span class="ecjiafc-999">
												{lang key='wechat::wechat.invite_expired'}<a class="hint--bottom  hint--rounded" data-hint="{lang key='wechat::wechat.expired_rebind_notice'}"><i class="fontello-icon-help-circled"></i></a>
											</span><br />
											<a class="bind_wx" data-toggle="modal" href="#bind_wx" title="{lang key='wechat::wechat.bind_wx'}" data-val="{$val.kf_account}">{lang key='wechat::wechat.rebind'}</a>
										{/if}
									{else}
										<a class="bind_wx" data-toggle="modal" href="#bind_wx" title="{lang key='wechat::wechat.bind_wx'}" data-val="{$val.kf_account}">绑定微信号</a>
									{/if}
								{else}
									<span class="ecjiafc-999">{lang key='wechat::wechat.kf_account_disabled'}</span>
									<br />
									<a class="bind_wx" data-toggle="modal" href="#bind_wx" title="{lang key='wechat::wechat.bind_wx'}" data-val="{$val.kf_account}">{lang key='wechat::wechat.rebind'}</a>
								{/if}
							</td>
							<td>
								<span class="cursor_pointer" data-text="text" data-trigger="editable" data-url='{RC_Uri::url("wechat/platform_customer/edit_nick")}' data-name="{$val.kf_nick}" data-pk="{$val.id}" data-title="{lang key='wechat::wechat.edit_kf_nick'}" >{$val.kf_nick}</span>
							</td>
							<td class="{if $val.online_status}ecjiafc-red{/if}">
								{if $val.online_status eq 1}
									{lang key='wechat::wechat.web_online'}
								{elseif $val.online_status eq 0}
									{lang key='wechat::wechat.not_online'}
								{/if}
							</td>
							<td>
	                        	<i class="{if $val.status eq 1}fa fa-check cursor_pointer{else}fa fa-times cursor_pointer{/if}" data-trigger="toggle_CustomerState" data-url="{RC_Uri::url('wechat/platform_customer/toggle_show')}" data-id="{$val.id}" data-msg="{if $val.status}关闭客服[{$val.kf_account}]将在微信端删除该客服，{else}开启客服[{$val.kf_account}]将在微信端添加该客服，{/if}您确定要这么做吗？"></i>
							</td>
							</tr>
							<!--  {foreachelse} -->
						<tr><td class="no-records" colspan="6">{lang key='system::system.no_records'}</td></tr>
						<!-- {/foreach} -->
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<div class="modal fade text-left" id="bind_wx">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title">{lang key='wechat::wechat.bind_wx'}</h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			
			<!-- {if $errormsg || $type neq 2} -->
				<div class="card-body">
					<!-- {if $errormsg} -->
				    <div class="alert alert-danger m_b0">
			            <strong>{lang key='wechat::wechat.label_notice'}</strong>{$errormsg}
			        </div>
			        <!-- {/if} -->
					<!-- {if $type neq 2} -->
					<div class="alert alert-danger m_b0">
						<strong>{lang key='wechat::wechat.label_notice'}</strong>{$type_error}
					</div>
					<!-- {/if} -->
				</div>
			<!-- {/if} -->
			
			<form class="form" method="post" name="bind_form" action="{url path='wechat/platform_customer/bind_wx'}">
				<div class="card-body">
					<div class="form-body">
						<div class="form-group row">
							<label class="col-md-3 label-control text-right">微信号：</label>
							<div class="col-md-8 controls">
								<input class="form-control" type="text" name="kf_wx" value="{$smarty.get.kf_wx}" autocomplete="off" placeholder="请输入需要绑定的客服人员微信号"/>
							</div>
							<div class="col-md-1"><span class="input-must">*</span></div>
						</div>
					</div>
				</div>

				<div class="modal-footer justify-content-center">
			   		<input type="hidden" name="kf_account" />
					<input type="submit" value="{lang key='wechat::wechat.invite_bind'}" class="btn btn-outline-primary" {if $errormsg || $warn && $type neq 2}disabled{/if}/>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- {/block} -->