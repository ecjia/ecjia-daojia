<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.oauth_edit.init();
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
		<a class="btn plus_or_reply data-pjax" href="{$action_link.href}" id="sticky_a"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		{/if}
	</h3>
</div>

<div class="row-fluid edit-page">
	<div class="span12">
		<div class="tabbable">
			<form class="form-horizontal" action="{$form_action}" method="post" name="theForm" >
				<div class="tab-content">
					<fieldset>
						<div class="control-group formSep" >
							<label class="control-label">{lang key='wechat::wechat.label_is_open'}</label>
							<div class="controls chk_radio">
								<input type="radio" class="uni_style" name="oauth_status" value="1"  {if $wechat_oauth.oauth_status eq 1}checked{/if}><span>{lang key='wechat::wechat.enable'}</span>
								<input type="radio" class="uni_style" name="oauth_status" value="0"  {if $wechat_oauth.oauth_status eq 0}checked{/if}><span>{lang key='wechat::wechat.disable'}</span>
							</div>
						</div>
						
						<div class="control-group formSep" >
							<label class="control-label">{lang key='wechat::wechat.label_weshop_url'}</label>
							<div class="controls l_h30">
								{$weshop_url}
							</div>
						</div>
						
						<div class="control-group formSep" >
							<label class="control-label">{lang key='wechat::wechat.label_oauth_redirecturi'}</label>
							<div class="controls">
								<textarea class="span10 h100" name="oauth_redirecturi" cols="40" rows="3" id="oauth_redirecturi">{if $wechat_oauth.oauth_redirecturi}{$wechat_oauth.oauth_redirecturi}{else}{$oauth_url}{/if}</textarea>
								<span class="input-must">{lang key='system::system.require_field'}</span>
								<span class="help-block">{lang key='wechat::wechat.oauth_redirecturi_help'}</span>
							</div>
						</div>
						
						{if $wechat_oauth.wechat_id neq ''}
							<div class="control-group formSep" >
								<label class="control-label">{lang key='wechat::wechat.label_oauth_count'}</label>
								<div class="controls l_h30">
									{$wechat_oauth.oauth_count}
								</div>
							</div>
						{/if}

						{if $wechat_oauth.wechat_id neq ''}
							<div class="control-group formSep" >
								<label class="control-label">{lang key='wechat::wechat.label_last_time'}</label>
								<div class="controls l_h30">
									{$wechat_oauth.last_time}
								</div>
							</div>
						{/if}
							
						<div class="control-group">
        					<div class="controls">
        					    {if $errormsg}
								<input type="submit" name="submit" value="{lang key='wechat::wechat.ok'}"  class="btn btn-gebo" disabled="disabled" />	
								{else}
                                <input type="submit" name="submit" value="{lang key='wechat::wechat.ok'}" {if $type eq 0 || $type eq 1}disabled{/if} class="btn btn-gebo" />    
								{/if}
								<input type="hidden" name="wechat_id" value="{$wechat_oauth.wechat_id}" />
							</div>
						</div>
					</fieldset>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- {/block} -->