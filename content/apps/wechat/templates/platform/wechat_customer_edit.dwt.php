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

<div class="row">
    <div class="col-12">
        <div class="card">
			<div class="card-header">
                <h4 class="card-title">
                	{$ur_here}
	               	{if $action_link}
					<a class="btn btn-outline-primary plus_or_reply data-pjax float-right" href="{$action_link.href}" id="sticky_a"><i class="fa fa-reply"></i> {$action_link.text}</a>
					{/if}
                </h4>
            </div>
            <div class="col-lg-12">
				<form class="form" method="post" name="theForm" action="{$form_action}">
					<div class="card-body">
						<div class="form-body">
							<div class="form-group row">
								<label class="col-lg-2 label-control text-right">{lang key='wechat::wechat.label_kf_account'}</label>
								<div class="col-lg-8 controls">
									<!-- {if $list.kf_account} -->
									<span>{$list.kf_account}</span>
									<input class="input-xlarge" name="kf_account" type="hidden" value="{$list.kf_account|escape}" maxlength="32" size="34" autocomplete="off" />
									<!-- {else} -->
									<input class="input-xlarge form-control" name="kf_account" type="text" value="{$list.kf_account|escape}" maxlength="32" size="34" autocomplete="off" />
									<span class="help-block">{lang key='wechat::wechat.kf_account_help'}</span>
									<!-- {/if} -->
								</div>
								<span class="input-must">{lang key='system::system.require_field'}</span>
							</div>
							
							<div class="form-group row">
								<label class="col-lg-2 label-control text-right">{lang key='wechat::wechat.label_kf_nick'}</label>
								<div class="col-lg-8 controls">
									<input class="input-xlarge form-control" name="kf_nick" type="text" value="{$list.kf_nick|escape}" maxlength="32" size="34" autocomplete="off" />
								</div>
								<span class="input-must">{lang key='system::system.require_field'}</span>
							</div>
							
							<!-- {if $list.id} -->
							<div class="form-group row">
								<label class="col-lg-2 label-control text-right">{lang key='wechat::wechat.label_kf_headimgurl'}</label>
								<div class="col-lg-8 controls">
									<div class="fileupload {if $list.kf_headimgurl}fileupload-exists{else}fileupload-new{/if}" data-provides="fileupload">	
										<div class="fileupload-preview fileupload-exists thumbnail" style="width: 50px; height: 50px; line-height: 50px;">
											{if $list.kf_headimgurl}
											<img src="{$list.kf_headimgurl}" alt="{lang key='wechat::wechat.img_priview'}" />
											{/if}
										</div>
										<span class="btn btn-outline-primary btn-file">
											<span class="fileupload-new">{lang key='wechat::wechat.browser'}</span>
											<span class="fileupload-exists">{lang key='wechat::wechat.modify'}</span>
											<input type='file' name='kf_headimgurl' size="35"/>
										</span>
										<a class="btn btn-danger {if !$list.kf_headimgurl}fileupload-exists{else}fileupload-new{/if}" {if !$list.kf_headimgurl}data-dismiss="fileupload" href="javascript:;"{/if}>{lang key='system::system.drop'}</a>
									</div>
								</div>
							</div>
							<!-- {/if} -->
							
							<div class="form-group row">
								<label class="col-lg-2 label-control text-right">{lang key='wechat::wechat.label_status'}</label>
								<div class="col-lg-8 controls">
									<input type="radio" id="status_1" name="status" value="1" {if $list.status eq 1}checked{/if}><label for="status_1">{lang key='wechat::wechat.open'}</label>
									<input type="radio" id="status_0" name="status" value="0" {if $list.status eq 0}checked{/if}><label for="status_0">{lang key='wechat::wechat.close'}</label>
									<div class="help-block">{lang key='wechat::wechat.status_help'}</div>
								</div>
							</div>
							
							<!-- {if $list.id} -->
							<div class="form-group row">
								<label class="col-lg-2 label-control text-right">绑定微信号：</label>
								<div class="col-lg-8 controls">
									{if $list.status eq 1}
										{if $list.kf_wx}
											{$list.kf_wx}
										{elseif $list.invite_wx}
											{if $list.invite_status eq 'waiting'}
												{$list.invite_wx}<br />
												<span class="ecjiafc-999">
												{lang key='wechat::wechat.invite_waiting'}<a class="hint--bottom hint--rounded" data-hint="绑定邀请已发送至 {$list.invite_wx} 的微信，请去微信客户端确认后即可绑定"><i class="fontello-icon-help-circled"></i></a>
												</span>
											{elseif $list.invite_status eq 'rejected'}
												<span class="ecjiafc-999">
												{lang key='wechat::wechat.invite_rejected'}<a class="hint--bottom  hint--rounded" data-hint="{lang key='wechat::wechat.rejected_rebind_notice'}"><i class="fontello-icon-help-circled"></i></a>
												</span><br />
												<a class="bind_wx" data-toggle="modal" href="#bind_wx" title="{lang key='wechat::wechat.bind_wx'}" data-val="{$list.kf_account}">{lang key='wechat::wechat.rebind'}</a>
											{elseif $list.invite_status eq 'expired'}
												<span class="ecjiafc-999">
													{lang key='wechat::wechat.invite_expired'}<a class="hint--bottom  hint--rounded" data-hint="{lang key='wechat::wechat.expired_rebind_notice'}"><i class="fontello-icon-help-circled"></i></a>
												</span><br />
												<a class="bind_wx" data-toggle="modal" href="#bind_wx" title="{lang key='wechat::wechat.bind_wx'}" data-val="{$list.kf_account}">{lang key='wechat::wechat.rebind'}</a>
											{/if}
										{else}
											<a class="bind_wx" data-toggle="modal" href="#bind_wx" title="{lang key='wechat::wechat.bind_wx'}" data-val="{$list.kf_account}">绑定微信号</a>
										{/if}
									{else}
										<span class="ecjiafc-999">{lang key='wechat::wechat.kf_account_disabled'}</span><br >
										<a class="bind_wx" data-toggle="modal" href="#bind_wx" title="{lang key='wechat::wechat.bind_wx'}" data-val="{$list.kf_account}">{lang key='wechat::wechat.rebind'}</a>
									{/if}
								</div>
							</div>
							<!-- {/if} -->
						</div>
					</div>
	
					<div class="modal-footer justify-content-center">
						<!-- {if $list.id} -->
						<input class="btn btn-outline-primary" {if $errormsg || ($warn && $type neq 2)}disabled{/if} type="submit" value="{lang key='wechat::wechat.update'}" />
						<!-- {else} -->
						<input class="btn btn-outline-primary" {if $errormsg || ($warn && $type neq 2)}disabled{/if} type="submit" value="{lang key='wechat::wechat.ok'}" />
						<!-- {/if} -->
						<input type="hidden" name="id" value="{$list.id}" />
					</div>
				</form>	
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
			
			<form class="form" method="post" name="bind_form" action="{url path='wechat/platform_customer/bind_wx'}&id={$list.id}">
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

<!-- {/block} -->