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
    
    
<h3 class="heading">
	<!-- {if $ur_here}{$ur_here}{/if} -->
	<!-- {if $action_link} -->
	<a class="btn data-pjax plus_or_reply" id="sticky_a" href="{$action_link.href}"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
	<!-- {/if} -->
</h3>

<form class="form-horizontal" id="form-privilege" name="theForm" action="{$form_action}" method="post">
	<div class="row-fluid">
		<div class="span12">
			<fieldset>
				<div class="control-group formSep">
					<label class="control-label">{lang key='wechat::wechat.label_kf_account'}</label>
					<div class="controls">
						<!-- {if $list.kf_account} -->
						<span class="l_h30">{$list.kf_account}</span>
						<input class="input-xlarge" name="kf_account" type="hidden" value="{$list.kf_account|escape}" maxlength="32" size="34" autocomplete="off" />
						<!-- {else} -->
						<input class="input-xlarge" name="kf_account" type="text" value="{$list.kf_account|escape}" maxlength="32" size="34" autocomplete="off" />
						<span class="input-must">{lang key='system::system.require_field'}</span>
						<span class="help-block">{lang key='wechat::wechat.kf_account_help'}</span>
						<!-- {/if} -->
					</div>
				</div>
				
				<div class="control-group formSep">
					<label class="control-label">{lang key='wechat::wechat.label_kf_nick'}</label>
					<div class="controls">
						<input class="input-xlarge" name="kf_nick" type="text" value="{$list.kf_nick|escape}" maxlength="32" size="34" autocomplete="off" />
						<span class="input-must">{lang key='system::system.require_field'}</span>
					</div>
				</div>
				
				<!-- {if $list.id} -->
				<div class="control-group formSep">
					<label class="control-label">{lang key='wechat::wechat.label_kf_headimgurl'}</label>
					<div class="controls chk_radio">
						<div class="fileupload {if $list.kf_headimgurl}fileupload-exists{else}fileupload-new{/if}" data-provides="fileupload">	
							<div class="fileupload-preview fileupload-exists thumbnail" style="width: 50px; height: 50px; line-height: 50px;">
								{if $list.kf_headimgurl}
								<img src="{$list.kf_headimgurl}" alt="{lang key='wechat::wechat.img_priview'}" />
								{/if}
							</div>
							<span class="btn btn-file">
								<span class="fileupload-new">{lang key='wechat::wechat.browser'}</span>
								<span class="fileupload-exists">{lang key='wechat::wechat.modify'}</span>
								<input type='file' name='kf_headimgurl' size="35"/>
							</span>
							<a class="btn {if !$list.kf_headimgurl}fileupload-exists{else}fileupload-new{/if}" {if !$list.kf_headimgurl}data-dismiss="fileupload" href="javascript:;"{/if}>{lang key='system::system.drop'}</a>
						</div>
					</div>
				</div>
				<!-- {/if} -->
				
				<div class="control-group formSep" >
					<label class="control-label">{lang key='wechat::wechat.label_status'}</label>
					<div class="controls">
						<input type="radio" name="status" value="1" {if $list.status eq 1}checked{/if}><span>{lang key='wechat::wechat.open'}</span>
						<input type="radio" name="status" value="0" {if $list.status eq 0}checked{/if}><span>{lang key='wechat::wechat.close'}</span>
						<span class="help-block">{lang key='wechat::wechat.status_help'}</span>
					</div>
				</div>

				<div class="control-group">
					<div class="controls">
						<!-- {if $list.id} -->
						<input class="btn btn-gebo" {if $errormsg}disabled{/if} type="submit" value="{lang key='wechat::wechat.update'}" />
						<!-- {else} -->
						<input class="btn btn-gebo" {if $errormsg}disabled{/if} type="submit" value="{lang key='wechat::wechat.ok'}" />
						<!-- {/if} -->
						<input type="hidden" name="id" value="{$list.id}" />
					</div>
				</div>
			</fieldset>
		</div>
	</div>
</form>
<!-- {/block} -->