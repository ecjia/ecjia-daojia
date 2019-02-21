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
								<label class="col-lg-2 label-control text-right">{t domain="wechat"}客服账号：{/t}</label>
								<div class="col-lg-8 controls">
									<!-- {if $list.kf_account} -->
									<span>{$list.kf_account}</span>
									<input class="input-xlarge" name="kf_account" type="hidden" value="{$list.kf_account|escape}" maxlength="32" size="34" autocomplete="off" />
									<!-- {else} -->
									<input class="input-xlarge form-control" name="kf_account" type="text" value="{$list.kf_account|escape}" maxlength="32" size="34" autocomplete="off" />
									<span class="help-block">{t domain="wechat"}账号格式：账号前缀@公众号微信号{/t}</span>
									<!-- {/if} -->
								</div>
								<span class="input-must">*</span>
							</div>
							
							<div class="form-group row">
								<label class="col-lg-2 label-control text-right">{t domain="wechat"}客服昵称：{/t}</label>
								<div class="col-lg-8 controls">
									<input class="input-xlarge form-control" name="kf_nick" type="text" value="{$list.kf_nick|escape}" maxlength="32" size="34" autocomplete="off" />
								</div>
								<span class="input-must">*</span>
							</div>
							
							<!-- {if $list.id} -->
							<div class="form-group row">
								<label class="col-lg-2 label-control text-right">{t domain="wechat"}客服头像：{/t}</label>
								<div class="col-lg-8 controls">
									<div class="fileupload {if $list.kf_headimgurl}fileupload-exists{else}fileupload-new{/if}" data-provides="fileupload">	
										<div class="fileupload-preview fileupload-exists thumbnail" style="width: 50px; height: 50px; line-height: 50px;">
											{if $list.kf_headimgurl}
											<img src="{$list.kf_headimgurl}" alt='{t domain="wechat"}图片预览{/t}' />
											{/if}
										</div>
										<span class="btn btn-outline-primary btn-file">
											<span class="fileupload-new">{t domain="wechat"}浏览{/t}</span>
											<span class="fileupload-exists">{t domain="wechat"}修改{/t}</span>
											<input type='file' name='kf_headimgurl' size="35"/>
										</span>
										<a class="btn btn-danger {if !$list.kf_headimgurl}fileupload-exists{else}fileupload-new{/if}" {if !$list.kf_headimgurl}data-dismiss="fileupload" href="javascript:;"{/if}>{t domain="wechat"}删除{/t}</a>
									</div>
								</div>
							</div>
							<!-- {/if} -->
							
							<div class="form-group row">
								<label class="col-lg-2 label-control text-right">{t domain="wechat"}状态：{/t}</label>
								<div class="col-lg-8 controls">
									<input type="radio" id="status_1" name="status" value="1" {if $list.status eq 1}checked{/if}><label for="status_1">{t domain="wechat"}开启{/t}</label>
									<input type="radio" id="status_0" name="status" value="0" {if $list.status eq 0}checked{/if}><label for="status_0">{t domain="wechat"}关闭{/t}</label>
									<div class="help-block">{t domain="wechat"}如果状态为关闭，则微信端不添加该客服{/t}</div>
								</div>
							</div>
							
							<!-- {if $list.id} -->
							<div class="form-group row">
								<label class="col-lg-2 label-control text-right">{t domain="wechat"}绑定微信号：{/t}</label>
								<div class="col-lg-8 controls">
									{if $list.status eq 1}
										{if $list.kf_wx}
											{$list.kf_wx}
										{elseif $list.invite_wx}
											{if $list.invite_status eq 'waiting'}
												{$list.invite_wx}<br />
												<span class="ecjiafc-999">
												{t domain="wechat"}邀请绑定待确认{/t}<a class="hint--bottom hint--rounded" data-hint='{t domain="wechat" 1={$list.invite_wx}}绑定邀请已发送至 %1 的微信，请去微信客户端确认后即可绑定{/t}'><i class="fontello-icon-help-circled"></i></a>
												</span>
											{elseif $list.invite_status eq 'rejected'}
												<span class="ecjiafc-999">
												{t domain="wechat"}邀请绑定被拒绝{/t}<a class="hint--bottom  hint--rounded" data-hint='{t domain="wechat"}由于对方已拒绝绑定，可重新进行绑定。{/t}'><i class="fontello-icon-help-circled"></i></a>
												</span><br />
												<a class="bind_wx" data-toggle="modal" href="#bind_wx" title='{t domain="wechat"}绑定微信号{/t}' data-val="{$list.kf_account}">{t domain="wechat"}重新绑定{/t}</a>
											{elseif $list.invite_status eq 'expired'}
												<span class="ecjiafc-999">
													{t domain="wechat"}邀请绑定过期{/t}<a class="hint--bottom  hint--rounded" data-hint='{t domain="wechat"}由于邀请绑定已过期，可重新进行绑定。{/t}'><i class="fontello-icon-help-circled"></i></a>
												</span><br />
												<a class="bind_wx" data-toggle="modal" href="#bind_wx" title='{t domain="wechat"}绑定微信号{/t}' data-val="{$list.kf_account}">{t domain="wechat"}重新绑定{/t}</a>
											{/if}
										{else}
											<a class="bind_wx" data-toggle="modal" href="#bind_wx" title='{t domain="wechat"}绑定微信号{/t}' data-val="{$list.kf_account}">{t domain="wechat"}绑定微信号{/t}</a>
										{/if}
									{else}
										<span class="ecjiafc-999">{t domain="wechat"}该客服账号已停用{/t}</span><br >
										<a class="bind_wx" data-toggle="modal" href="#bind_wx" title='{t domain="wechat"}绑定微信号{/t}' data-val="{$list.kf_account}">{t domain="wechat"}重新绑定{/t}</a>
									{/if}
								</div>
							</div>
							<!-- {/if} -->
						</div>
					</div>
	
					<div class="modal-footer justify-content-center">
						<!-- {if $list.id} -->
						<input class="btn btn-outline-primary" {if $errormsg || ($warn && $type neq 2)}disabled{/if} type="submit" value='{t domain="wechat"}更新{/t}' />
						<!-- {else} -->
						<input class="btn btn-outline-primary" {if $errormsg || ($warn && $type neq 2)}disabled{/if} type="submit" value='{t domain="wechat"}确定{/t}' />
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
			
			<form class="form" method="post" name="bind_form" action="{url path='wechat/platform_customer/bind_wx'}&id={$list.id}">
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