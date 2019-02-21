<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.integrate_setup.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<!--{if $code eq 'ucenter' || $code eq 'ecjiauc'}-->
<div class="form-div">
    <div class="alert alert-info" >{$plugin_lang.ucenter_api_readme}</div>
</div>
<!--{else}-->
<div class="form-div">
    <div class="alert alert-info" >{t domain="integrate"}目前仅支持UCenter会员整合{/t}</div>
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
		<!--{if $code eq 'ecjiauc' || $code eq 'ucenter'}-->
		<div>
			<form class="form-horizontal" id="form-privilege" name="Form1" action="{$form_action}" method="post">
				<fieldset>
					<div class="control-group">
						<label class="control-label">{$plugin_lang.ucenter_lable_id}</label>
						<div class="controls">
							<input class="w350" type="text" name="cfg[uc_id]" value="{$cfg.uc_id}" /><i class="input-must"><span class="require-field" style="color:#FF0000,">*</span></i>
							<span class="help-block" id="noticeGoodsSN">{$plugin_lang.ucenter_notice_id}</span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">{$plugin_lang.ucenter_lable_key}</label>
						<div class="controls users">
							<input class="w350" type="text" name="cfg[uc_key]" value="{$cfg.uc_key}" /><i class="input-must"><span class="require-field" style="color:#FF0000,">*</span></i>
							<span class="w400 help-block" id="noticeGoodsSN">{$plugin_lang.ucenter_notice_key}</span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">{$plugin_lang.ucenter_lable_url}</label>
						<div class="controls users">
							<input class="w350" type="text" name="cfg[uc_url]" value="{$cfg.uc_url}" /><i class="input-must"><span class="require-field" style="color:#FF0000,">*</span></i>
							<span class="w400 help-block" id="noticeGoodsSN">{$plugin_lang.ucenter_notice_url}</span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">{$plugin_lang.ucenter_lable_ip}</label>
						<div class="controls users">
							<input class="w350" type="text" name="cfg[uc_ip]" value="{$cfg.uc_ip}" />
							<span class="help-block" id="noticeGoodsSN">{$plugin_lang.ucenter_notice_ip}</span>
						</div>
					</div>

					<div class="control-group">
						<div class="controls">
							<input type="hidden" name="code" value="{$code}" />
							<input class="btn btn-gebo m_r10" type="submit" value='{t domain="integrate"}保存{/t}' />
							<input class="btn" type="reset" value='{t domain="integrate"}重置{/t}' />
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
						<label class="control-label">{t domain="integrate"}数据库服务器主机名：{/t}</label>
						<div class="controls users">
							<input class="w350" type="text" name="cfg[db_host]" value="{$cfg.db_host}" /><i class="input-must"><span class="require-field" style="color:#FF0000,">*</span></i>
						</div>
					</div>
					<div class="control-group ">
						<label class="control-label">{t domain="integrate"}数据库帐号：{/t}</label>
						<div class="controls users">
							<input class="w350" type="text" name="cfg[db_user]" value="{$cfg.db_user}" /><i class="input-must"><span class="require-field" style="color:#FF0000,">*</span></i>
						</div>
					</div>
					<div class="control-group ">
						<label class="control-label">{t domain="integrate"}数据库密码：{/t}</label>
						<div class="controls users">
							<input class="w350" type="password" name="cfg[db_pass]" value="{$cfg.db_pass}" /><i class="input-must"><span class="require-field" style="color:#FF0000,">*</span></i>
						</div>
					</div>
					<div class="control-group ">
						<label class="control-label">{t domain="integrate"}数据库名：{/t}</label>
						<div class="controls users">
							<input class="w350" type="text" name="cfg[db_name]" value="{$cfg.db_name}" /><i class="input-must"><span class="require-field" style="color:#FF0000,">*</span></i>
						</div>
					</div>
					<div class="control-group ">
						<label class="control-label">{t domain="integrate"}数据库字符集：{/t}</label>
						<div class="controls users">
							<select class="w350" name="cfg[db_charset]">{html_options options=$set_list selected=$cfg.db_charset}</select>
							<span class="help-block"> {t domain="integrate"}该选项填写错误时将可能到导致中文用户名无法使用{/t}</span>
						</div>
					</div>
					<div class="control-group ">
						<label class="control-label">{t domain="integrate"}是否为latin1编码：{/t}</label>
						<div class="controls users">
							<input type="radio" name="cfg[is_latin1]" value="1" {if $cfg.is_latin1}checked="checked"{/if} />{t domain="integrate"}是{/t}
							<input type="radio" name="cfg[is_latin1]" value="0" {if !$cfg.is_latin1}checked="checked"{/if} />{t domain="integrate"}否{/t}
						</div>
					</div>
					<div class="control-group ">
						<label class="control-label">{t domain="integrate"}数据表前缀：{/t}</label>
						<div class="controls users">
							<input class="w350" type="text" name="cfg[prefix]" value="{$cfg.prefix}" />
						</div>
					</div> 
					<div class="control-group ">
						<label class="control-label">{t domain="integrate"}被整合系统的完整 URL：{/t}</label>
						<div class="controls users">
							<input class="w350" type="text" name="cfg[integrate_url]" value="{$cfg.integrate_url}" /><i class="input-must"><span class="require-field" style="color:#FF0000,">*</span></i>
						</div>
					</div>
					<!-- {if isset($cfg.cookie_prefix)} -->
					<div class="control-group ">
						<label class="control-label">{t domain="integrate"}COOKIE前缀：{/t}</label>
						<div class="controls users">
							<input class="w350" type="text" name="cfg[cookie_prefix]" value="{$cfg.cookie_prefix}" /><i class="input-must"><span class="require-field" style="color:#FF0000,">*</span></i>
						</div>
					</div>
					<!-- {/if} -->
					<!-- {if isset($cfg.cookie_salt)} -->
					<div class="control-group ">
						<label class="control-label">{t domain="integrate"}COOKIE加密串：{/t}</label>
						<div class="controls users">
							<input type="text" name="cfg[cookie_salt]" value="{$cfg.cookie_salt}" /><i class="input-must"><span class="require-field" style="color:#FF0000,">*</span></i>
						</div>
					</div>
					<!-- {/if} -->
					<div class="control-group">
						<div class="controls">
							<input type="submit" value='{t domain="integrate"}保存配置信息{/t}' class="btn btn-gebo" />
							<input type="reset" value='{t domain="integrate"}重置{/t}' class="btn"  />
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
