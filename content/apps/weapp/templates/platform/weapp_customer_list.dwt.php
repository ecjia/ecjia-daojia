<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-platform.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.platform.wechat_customer.init();
</script>
<!-- {/block} -->
<!-- {block name="home-content"} -->

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
				<div><button type="button" class="ajaxmenu btn btn-outline-primary" data-url='{RC_Uri::url("weapp/platform_customer/get_customer")}'>{lang key='wechat::wechat.get_customer'}</button><span style="margin-left: 20px;">{lang key='wechat::wechat.get_customer_notice'}</span></div><br/>
				<div><button type="button" class="ajaxmenu btn btn-outline-primary" data-url='{RC_Uri::url("weapp/platform_customer/get_online_customer")}'>{lang key='wechat::wechat.get_online_customer'}</button><span style="margin-left: 20px;">{lang key='wechat::wechat.get_online_customer_notice'}</span></div>
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
				<a class="btn btn-outline-primary float-right m_r10" href="https://mpkf.weixin.qq.com/" target="__blank"><i class="ft-link"></i>去微信客服中心</a>
                </h4>
            </div>
			<div class="card-body">
				<ul class="nav nav-pills float-left">
					<li class="nav-item">
						<a class="nav-link {if !$smarty.get.type}active{/if} data-pjax" href='{url path="weapp/platform_customer/init"}'>{lang key='wechat::wechat.all_customer'}
						<span class="badge badge-pill badge-glow badge-default badge-primary ml-1">{$list.filter.all}</span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link {if $smarty.get.type eq 'online'}active{/if} data-pjax" href='{url path="weapp/platform_customer/init" args="type=online"}'>{lang key='wechat::wechat.online_customer'}
						<span class="badge badge-pill badge-glow badge-default badge-primary ml-1">{$list.filter.online}</span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link {if $smarty.get.type eq 'deleted'}active{/if} data-pjax" href='{url path="weapp/platform_customer/init" args="type=deleted"}'>已删客服
						<span class="badge badge-pill badge-glow badge-default badge-primary ml-1">{$list.filter.deleted}</span></a>
					</li>
				</ul>
			</div>
			<div class="col-md-12">
				<table class="table table-hide-edit">
					<thead>
						<tr>
							<th class="w130">{lang key='wechat::wechat.kf_headimgurl'}</th>
							<th class="w250">{lang key='wechat::wechat.kf_account'}</th>
							<th class="w200">{lang key='wechat::wechat.kf_nick'}</th>
							<th class="w150">{lang key='wechat::wechat.online_status'}</th>
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
									<a class="get_session" href='{RC_Uri::url("weapp/platform_customer/get_session", "kf_account={$val.kf_account}")}' title="获取客服会话">获取客服会话</a>&nbsp;|&nbsp;
									{/if}

									{if $smarty.get.type eq 'deleted'}
										<a class="ajaxremove ecjiafc-red" 
										data-toggle="ajaxremove" 
										data-msg="解绑该客服后将无法还原，您确定要解绑该客服吗？" 
										href='{RC_Uri::url("weapp/platform_customer/remove", "id={$val.id}")}' 
										title="{lang key='system::system.drop'}">
										{lang key='system::system.drop'}
										</a>
									{else}
										<a class="ajaxremove ecjiafc-red" 
										data-toggle="ajaxremove" 
										data-msg="{lang key='wechat::wechat.remove_kf_confirm'}" 
										href='{RC_Uri::url("weapp/platform_customer/edit_status", "id={$val.id}{if $smarty.get.type}&type={$smarty.get.type}{/if}")}' 
										title="解绑">
										解绑
										</a>
									{/if}
								</div>
							</td>
		
							<td>
								<span class="cursor_pointer" data-text="text" data-trigger="editable" data-url='{RC_Uri::url("weapp/platform_customer/edit_nick")}' data-name="{$val.kf_nick}" data-pk="{$val.id}" data-title="{lang key='wechat::wechat.edit_kf_nick'}" >{$val.kf_nick}</span>
							</td>
							<td class="{if $val.online_status}ecjiafc-red{/if}">
								{if $val.online_status eq 1}
									{lang key='wechat::wechat.web_online'}
								{elseif $val.online_status eq 0}
									{lang key='wechat::wechat.not_online'}
								{/if}
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
			
			<!-- {if $errormsg} -->
				<div class="card-body">
				    <div class="alert alert-danger m_b0">
			            <strong>{lang key='wechat::wechat.label_notice'}</strong>{$errormsg}
			        </div>
				</div>
			<!-- {/if} -->
			
			<form class="form" method="post" name="bind_form" action="{url path='weapp/platform_customer/bind_wx'}">
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
					<input type="submit" value="{lang key='wechat::wechat.invite_bind'}" class="btn btn-outline-primary" />
				</div>
			</form>
		</div>
	</div>
</div>

<!-- {/block} -->