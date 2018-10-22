<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.integrate_setup.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<!--{if $code eq 'ucenter'}-->
<div class="form-div">
	<div class="alert alert-info" >{lang key='user::integrate.UCenter_api'}</div>
</div>
<!--{else}-->
<div class="form-div">
    <div class="alert alert-info" >{lang key='user::integrate.UCenter_integration'}</div>
</div>
<!--{/if}-->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a href="{$action_link.href}" class="btn plus_or_reply data-pjax" ><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>	
</div>

<div class="row-fluid edit-page">
	<div class="span12">
		<!--{if $code eq 'ucenter'}-->
		<div>
			<form class="form-horizontal" id="form-privilege" name="Form1" action="{$form_action}" method="post">
				<fieldset>
					<div class="control-group">
						<label class="control-label">{lang key='user::integrate.ucenter_lab_id'}</label>
						<div class="controls">
							<input class="w350" type="text" name="cfg[uc_id]" value="{$cfg.uc_id}" /><i class="input-must">{lang key='system::system.require_field'}</i>
							<span class="help-block" id="noticeGoodsSN">{lang key='user::integrate.ucenter_notice_id'}</span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">{lang key='user::integrate.ucenter_lab_key'}</label>
						<div class="controls users">
							<input class="w350" type="text" name="cfg[uc_key]" value="{$cfg.uc_key}" /><i class="input-must">{lang key='system::system.require_field'}</i>
							<span class="w400 help-block" id="noticeGoodsSN">{lang key='user::integrate.ucenter_notice_key'}</span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">{lang key='user::integrate.ucenter_lab_url'}</label>
						<div class="controls users">
							<input class="w350" type="text" name="cfg[uc_url]" value="{$cfg.uc_url}" /><i class="input-must">{lang key='system::system.require_field'}</i>
							<span class="w400 help-block" id="noticeGoodsSN">{lang key='user::integrate.ucenter_notice_url'}</span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">{lang key='user::integrate.ucenter_lab_ip'}</label>
						<div class="controls users">
							<input class="w350" type="text" name="cfg[uc_ip]" value="{$cfg.uc_ip}" />
							<span class="help-block" id="noticeGoodsSN">{lang key='user::integrate.ucenter_notice_ip'}</span>
						</div>
					</div>

					<div class="control-group">
						<div class="controls">
							<input type="hidden" name="cfg[uc_connect]" value="post" />
							<input type="hidden" name="cfg[uc_lang][exchange]" value="{$cfg.uc_lang.exchange}" />
							<input type="hidden" name="code" value="{$code}" />
							<input class="btn btn-gebo m_r10" type="submit" value="{lang key='user::integrate.save'}" />
							<input class="btn" type="reset" value="{lang key='system::system.button_reset'}" />
						</div>
					</div>
				</fieldset>
			</form>
		</div>
        <!--{elseif $code eq 'ecjia'}-->
        <div>
            <div class="control-group">
                <div class="controls">
                    <div class="alert alert-error" >{$error_message}</div>
                </div>
            </div>
        </div>
		<!--{else}-->
		<div id="form3">
			<form class="form-horizontal" id="form-privilege" action="{$form_action}" method="post" name="setupForm">
				<fieldset>
					<div class="control-group ">
						<label class="control-label">{lang key='user::integrate.lable_db_host'}</label>
						<div class="controls users">
							<input class="w350" type="text" name="cfg[db_host]" value="{$cfg.db_host}" /><i class="input-must">{lang key='system::system.require_field'}</i>
						</div>
					</div>
					<div class="control-group ">
						<label class="control-label">{lang key='user::integrate.lable_db_user'}</label>
						<div class="controls users">
							<input class="w350" type="text" name="cfg[db_user]" value="{$cfg.db_user}" /><i class="input-must">{lang key='system::system.require_field'}</i>
						</div>
					</div>
					<div class="control-group ">
						<label class="control-label">{lang key='user::integrate.lable_db_pass'}</label>
						<div class="controls users">
							<input class="w350" type="password" name="cfg[db_pass]" value="{$cfg.db_pass}" /><i class="input-must">{lang key='system::system.require_field'}</i>
						</div>
					</div>
					<div class="control-group ">
						<label class="control-label">{lang key='user::integrate.lable_db_name'}</label>
						<div class="controls users">
							<input class="w350" type="text" name="cfg[db_name]" value="{$cfg.db_name}" /><i class="input-must">{lang key='system::system.require_field'}</i>
						</div>
					</div>
					<div class="control-group ">
						<label class="control-label">{lang key='user::integrate.lable_db_chartset'}</label>
						<div class="controls users">
							<select class="w350" name="cfg[db_charset]">{html_options options=$set_list selected=$cfg.db_charset}</select>
							<span class="help-block"> {lang key='user::integrate.notice_latin1'}</span>
						</div>
					</div>
					<div class="control-group ">
						<label class="control-label">{lang key='user::integrate.lable_is_latin1'}：</label>
						<div class="controls users">
							<input type="radio" name="cfg[is_latin1]" value="1" {if $cfg.is_latin1}checked="checked"{/if} />{lang key='user::integrate.yes'}
							<input type="radio" name="cfg[is_latin1]" value="0" {if !$cfg.is_latin1}checked="checked"{/if} />{lang key='user::integrate.no'}
						</div>
					</div>
					<div class="control-group ">
						<label class="control-label">{lang key='user::integrate.lable_prefix'}</label>
						<div class="controls users">
							<input class="w350" type="text" name="cfg[prefix]" value="{$cfg.prefix}" />
						</div>
					</div> 
					<div class="control-group ">
						<label class="control-label">{lang key='user::integrate.lable_url'}</label>
						<div class="controls users">
							<input class="w350" type="text" name="cfg[integrate_url]" value="{$cfg.integrate_url}" /><i class="input-must">{lang key='system::system.require_field'}</i>
						</div>
					</div>
					<!-- {if isset($cfg.cookie_prefix)} -->
					<div class="control-group ">
						<label class="control-label">{lang key='user::integrate.cookie_prefix'}</label>
						<div class="controls users">
							<input class="w350" type="text" name="cfg[cookie_prefix]" value="{$cfg.cookie_prefix}" /><i class="input-must">{lang key='system::system.require_field'}</i>
						</div>
					</div>
					<!-- {/if} -->
					<!-- {if isset($cfg.cookie_salt)} -->
					<div class="control-group ">
						<label class="control-label">{lang key='user::integrate.cookie_salt'}</label>
						<div class="controls users">
							<input type="text" name="cfg[cookie_salt]" value="{$cfg.cookie_salt}" /><i class="input-must">{lang key='system::system.require_field'}</i>
						</div>
					</div>
					<!-- {/if} -->
					<div class="control-group">
						<div class="controls">
							<input type="submit" value="{lang key='user::integrate.button_save_config'}" class="btn btn-gebo" />
							<input type="reset" value="{lang key='system::system.button_reset'}" class="btn"  />
							<input type="hidden" name="code" value="{$code}" />
							<input type="hidden" name="act" value="check_config" />
							<input type="hidden" name="save" id="ECS_SAVE" value="{$save|default:0}">  
						</div>
					</div>
				</fieldset>
			</form>
		</div>
		<!--{/if}-->
	</div>
</div>
<!-- {/block} -->
