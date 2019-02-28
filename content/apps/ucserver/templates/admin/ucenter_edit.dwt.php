<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->
<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.ucenter_edit.init();
</script>
<!-- {/block} -->
<!-- {block name="main_content"} -->

<div>
	<h3 class="heading">
	<!-- {if $ur_here}{$ur_here}{/if} -->
	<!-- {if $action_link} -->
	<a class="btn plus_or_reply data-pjax" href="{$action_link.href}"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
	<!-- {/if} -->
	</h3>
</div>

<div class="row-fluid edit-page">
	<div class="span12">
		<form class="form-horizontal" action="{$form_action}" method="post" name="theForm">
			<fieldset>
				<div class="control-group formSep">
					<label class="control-label">{t domain="ucserver"}应用类型：{/t}</label>
					<div class="controls">
						<select class="w350" name="type">
							<!--{foreach from=$typelist item=name key=key}-->
							<option value="{$key}" {if $data.type eq $key}selected{/if}>{$name}</option>
							<!--{/foreach}-->
						</select>
					</div>
				</div>

				<div class="control-group formSep">
					<label class="control-label">{t domain="ucserver"}应用名称：{/t}</label>
					<div class="controls">
						<input class="w350" type="text" name="name" value="{$data.name}"/>
						<span class="help-block">{t domain="ucserver"}限 20 字节{/t}</span>
					</div>
				</div>

				<div class="control-group formSep">
					<label class="control-label">{t domain="ucserver"}应用的主URL：{/t}</label>
					<div class="controls">
						<input class="w350" type="text" name="url" value="{$data.url}"/>
						<span class="input-must"><span class="require-field" style="color:#FF0000,">*</span></span>
					</div>
					<div class="m_t30 controls help-block">{t domain="ucserver"}该应用与 UCenter 通信的接口 URL，结尾请不要加“/” ，应用的通知只发送给主 URL{/t}</div>
				</div>

				<div class="control-group formSep">
					<label class="control-label">{t domain="ucserver"}应用IP：{/t}</label>
					<div class="controls">
						<input class="w350" type="text" name="ip" value="{$data.ip}"/>
						<span class="help-block">{t domain="ucserver"}正常情况下留空即可。如果由于域名解析问题导致 UCenter 与该应用通信失败，请尝试设置为该应用所在服务器的 IP 地址{/t}</span>
					</div>
				</div>

				<div class="control-group formSep">
					<label class="control-label">{t domain="ucserver"}通信密钥：{/t}</label>
					<div class="controls">
						<input class="w350" type="text" name="authkey" value="{$data.authkey}"/>
						<span class="help-block">{t domain="ucserver"}只允许使用英文字母及数字，限 64 字节。应用端的通信密钥必须与此设置保持一致，否则该应用将无法与 UCenter 正常通信{/t}</span>
					</div>
				</div>

				<div class="control-group formSep">
					<label class="control-label">{t domain="ucserver"}应用接口文件的名称：{/t}</label>
					<div class="controls">
						<input class="w350" type="text" name="apifilename" value="{if $data.apifilename}{$data.apifilename}{else}uc.php{/if}"/>
						<span class="help-block">{t domain="ucserver"}应用接口文件名称，不含路径，默认为uc.php{/t}</span>
					</div>
				</div>

				<div class="control-group formSep">
					<label class="control-label">{t domain="ucserver"}是否开启同步登陆：{/t}</label>
					<div class="controls l_h30">
						<input type="radio" name="synlogin" value="1" {if $data.synlogin eq 1}checked{/if}/><span>{t domain="ucserver"}是{/t}</span>
						<input type="radio" name="synlogin" value="0" {if $data.synlogin eq 0}checked{/if}/><span>{t domain="ucserver"}否{/t}</span>
						<span class="help-block">{t domain="ucserver"}开启同步登录后，当用户在登录其他应用时，同时也会登录该应用{/t}</span>
					</div>
				</div>

				<div class="control-group formSep">
					<label class="control-label">{t domain="ucserver"}是否接受通知：{/t}</label>
					<div class="controls l_h30">
						<input type="radio" name="recvnote" value="1" {if $data.recvnote eq 1}checked{/if}/><span>{t domain="ucserver"}是{/t}</span>
						<input type="radio" name="recvnote" value="0" {if $data.recvnote eq 0}checked{/if}/><span>{t domain="ucserver"}否{/t}</span>
					</div>
				</div>

				<div class="control-group">
					<div class="controls">
						<button class="btn btn-gebo" type="submit">{t domain="ucserver"}确定{/t}</button>
						<input type="hidden" name="id" value="{$data.appid}"/>
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</div>
<!-- {/block} -->
