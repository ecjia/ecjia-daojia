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
	<strong>{t domain="wechat"}温馨提示：{/t}</strong>{$type_error}
</div>
<!-- {/if} -->		
		
<!-- {if $errormsg} -->
	<div class="alert alert-danger">
    	<strong>{t domain="wechat"}温馨提示：{/t}</strong>{$errormsg}
    </div>
<!-- {/if} -->

<div class="alert alert-info">
    {t domain="wechat" escape=no}
	<strong>温馨提示：</strong>绑定后的客服帐号，可以登录<a style="text-decoration:none;" target="_blank" href="https://mpkf.weixin.qq.com/">【在线客服功能】</a>，进行客服沟通。
    {/t}
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">
                    {t domain="wechat"}多客服同步操作{/t}
                </h4>
            </div>
            <div class="card-body">
				<div><button type="button" class="ajaxmenu btn btn-outline-primary" data-url='{RC_Uri::url("wechat/platform_customer/get_customer")}'>{t domain="wechat"}获取全部客服{/t}</button><span style="margin-left: 20px;">{t domain="wechat"}通过点击该按钮可以获取微信端原有的客服到本地。{/t}</span></div><br/>
				<div><button type="button" class="ajaxmenu btn btn-outline-primary" data-url='{RC_Uri::url("wechat/platform_customer/get_online_customer")}'>{t domain="wechat"}获取在线客服{/t}</button><span style="margin-left: 20px;">{t domain="wechat"}通过点击该按钮可以获取微信端在线的客服到本地。{/t}</span></div>
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
					<a class="btn btn-outline-primary float-right m_r10" href="https://mpkf.weixin.qq.com/" target="__blank"><i class="ft-link"></i>{t domain="wechat"}去微信客服中心{/t}</a>
                </h4>
            </div>
			<div class="card-body">
				<ul class="nav nav-pills float-left">
					<li class="nav-item">
						<a class="nav-link {if $smarty.get.type neq 'online'}active{/if} data-pjax" href='{url path="wechat/platform_customer/init"}'>{t domain="wechat"}全部客服{/t}
						<span class="badge badge-pill badge-glow badge-default badge-primary ml-1">{$list.filter.all}</span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link {if $smarty.get.type eq 'online'}active{/if} data-pjax" href='{url path="wechat/platform_customer/init" args="type=online"}'>{t domain="wechat"}在线客服{/t}
						<span class="badge badge-pill badge-glow badge-default badge-primary ml-1">{$list.filter.online}</span></a>
					</li>
				</ul>
			</div>
			<div class="col-md-12">
				<table class="table table-hide-edit">
					<thead>
						<tr>
							<th class="w130">{t domain="wechat"}客服头像{/t}</th>
							<th class="w250">{t domain="wechat"}客服账号{/t}</th>
							<th class="w200">{t domain="wechat"}绑定微信号{/t}</th>
							<th class="w200">{t domain="wechat"}客服昵称{/t}</th>
							<th class="w150">{t domain="wechat"}在线状态{/t}</th>
							<th class="w100">{t domain="wechat"}是否启用{/t}</th>
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
									<a class="get_session" href='{RC_Uri::url("wechat/platform_customer/get_session", "kf_account={$val.kf_account}")}' title='{t domain="wechat"}获取客服会话{/t}'>{t domain="wechat"}获取客服会话{/t}</a>&nbsp;|&nbsp;
									{/if}
									{if $val.invite_status neq 'waiting'}
									<a class="data-pjax" href='{RC_Uri::url("wechat/platform_customer/edit", "id={$val.id}")}' title='{t domain="wechat"}编辑{/t}'>{t domain="wechat"}编辑{/t}</a>&nbsp;|&nbsp;
									{/if}
									<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg='{t domain="wechat"}您确定要删除该客服吗？{/t}' href='{RC_Uri::url("wechat/platform_customer/remove", "id={$val.id}")}' title='{t domain="wechat"}删除{/t}'>{t domain="wechat"}删除{/t}</a>
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
											{t domain="wechat"}邀请绑定待确认{/t}<a class="hint--bottom hint--rounded" data-hint="{t domain="wechat" 1={$val.invite_wx}}绑定邀请已发送至 %1 的微信，请去微信客户端确认后即可绑定{/t}"><i class="fontello-icon-help-circled"></i></a>
											</span>
										{elseif $val.invite_status eq 'rejected'}
											<span class="ecjiafc-999">
											{t domain="wechat"}邀请绑定被拒绝{/t}<a class="hint--bottom  hint--rounded" data-hint='{t domain="wechat"}由于对方已拒绝绑定，可重新进行绑定。{/t}'><i class="fontello-icon-help-circled"></i></a>
											</span><br />
											<a class="bind_wx" data-toggle="modal" href="#bind_wx" title='{t domain="wechat"}绑定微信号{/t}' data-val="{$val.kf_account}">{t domain="wechat"}重新绑定{/t}</a>
										{elseif $val.invite_status eq 'expired'}
											<span class="ecjiafc-999">
												{t domain="wechat"}邀请绑定过期{/t}<a class="hint--bottom  hint--rounded" data-hint='{t domain="wechat"}由于邀请绑定已过期，可重新进行绑定。{/t}'><i class="fontello-icon-help-circled"></i></a>
											</span><br />
											<a class="bind_wx" data-toggle="modal" href="#bind_wx" title='{t domain="wechat"}绑定微信号{/t}' data-val="{$val.kf_account}">{t domain="wechat"}重新绑定{/t}</a>
										{/if}
									{else}
										<a class="bind_wx" data-toggle="modal" href="#bind_wx" title='{t domain="wechat"}绑定微信号{/t}' data-val="{$val.kf_account}">{t domain="wechat"}绑定微信号{/t}</a>
									{/if}
								{else}
									<span class="ecjiafc-999">{t domain="wechat"}该客服账号已停用{/t}</span>
									<br />
									<a class="bind_wx" data-toggle="modal" href="#bind_wx" title='{t domain="wechat"}绑定微信号{/t}' data-val="{$val.kf_account}">{t domain="wechat"}重新绑定{/t}</a>
								{/if}
							</td>
							<td>
								<span class="cursor_pointer" data-text="text" data-trigger="editable" data-url='{RC_Uri::url("wechat/platform_customer/edit_nick")}' data-name="{$val.kf_nick}" data-pk="{$val.id}" data-title='{t domain="wechat"}编辑客服昵称{/t}'>{$val.kf_nick}</span>
							</td>
							<td class="{if $val.online_status}ecjiafc-red{/if}">
								{if $val.online_status eq 1}
                                {t domain="wechat"}web在线{/t}
								{elseif $val.online_status eq 0}
                                {t domain="wechat"}不在线{/t}
								{/if}
							</td>
							<td>
	                        	<i class="{if $val.status eq 1}fa fa-check cursor_pointer{else}fa fa-times cursor_pointer{/if}" data-trigger="toggle_CustomerState" data-url="{RC_Uri::url('wechat/platform_customer/toggle_show')}" data-id="{$val.id}" data-msg='
	                        	{if $val.status}
	                        	{t domain="wechat" 1={$val.kf_account}}关闭客服[%1]将在微信端删除该客服，您确定要这么做吗？{/t}
	                        	{else}
                                {t domain="wechat" 1={$val.kf_account}}开启客服[%1]将在微信端添加该客服，您确定要这么做吗？{/t}
	                        	{/if}'></i>
							</td>
					    </tr>
					    <!--  {foreachelse} -->
						<tr><td class="no-records" colspan="6">{t domain="wechat"}没有找到任何记录{/t}</td></tr>
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
				<h3 class="modal-title">{t domain="wechat"}绑定微信号{/t}</h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			
			<!-- {if $errormsg || $type neq 2} -->
				<div class="card-body">
					<!-- {if $errormsg} -->
				    <div class="alert alert-danger m_b0">
			            <strong>{t domain="wechat"}温馨提示：{/t}</strong>{$errormsg}
			        </div>
			        <!-- {/if} -->
					<!-- {if $type neq 2} -->
					<div class="alert alert-danger m_b0">
						<strong>{t domain="wechat"}温馨提示：{/t}</strong>{$type_error}
					</div>
					<!-- {/if} -->
				</div>
			<!-- {/if} -->
			
			<form class="form" method="post" name="bind_form" action="{url path='wechat/platform_customer/bind_wx'}">
				<div class="card-body">
					<div class="form-body">
						<div class="form-group row">
							<label class="col-md-3 label-control text-right">{t domain="wechat"}微信号：{/t}</label>
							<div class="col-md-8 controls">
								<input class="form-control" type="text" name="kf_wx" value="{$smarty.get.kf_wx}" autocomplete="off" placeholder='{t domain="wechat"}请输入需要绑定的客服人员微信号{/t}'/>
							</div>
							<div class="col-md-1"><span class="input-must">*</span></div>
						</div>
					</div>
				</div>

				<div class="modal-footer justify-content-center">
			   		<input type="hidden" name="kf_account" />
					<input type="submit" value='{t domain="wechat"}邀请绑定{/t}' class="btn btn-outline-primary" {if $errormsg || $warn && $type neq 2}disabled{/if}/>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- {/block} -->