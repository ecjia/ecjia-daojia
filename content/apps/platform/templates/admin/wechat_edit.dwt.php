<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.platform.init();
	ecjia.admin.generate_token.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->

<div class="staticalert alert alert-info alert-dismissable ui_showmessage panel"><a class="close" data-dismiss="alert">×</a>
	<p><h3>{t domain="platform"}操作提示{/t}</h3></p>
	<p>{t domain="platform"}一、配置前先需要申请一个微信服务号，并且通过微信认证。（认证服务号需要注意每年微信官方都需要重新认证，如果认证过期，接口功能将无法使用，具体请登录微信公众号平台了解详情）{/t}</p>
	<p>{t domain="platform"}二、网站域名 需要通过ICP备案并正确解析到空间服务器，临时域名与IP地址无法配置。{/t}</p>
	<p>{t escape=no domain="platform"}三、登录 <a href="https://mp.weixin.qq.com/" target="_blank">微信公众号平台 </a>，获取且依次填写好 公众号名称，公众号原始ID，Appid，Appsecret，token值。{/t}</p>
	<p>{t domain="platform"}四、自定义Token值，必须为英文或数字（长度为3-32字符），如 weixintoken，并保持后台与公众号平台填写的一致。{/t}</p>
    <p>{t domain="platform"}五、复制接口地址，填写到微信公众号平台 开发=> 基本配置，服务器配置下的 URL地址，验证提交通过后，并启用。（注意仅支持80端口）{/t}</p>
</div>

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
			<form class="form-horizontal" action="{$form_action}" method="post" name="theForm" enctype="multipart/form-data">
				<div class="tab-content">
					<fieldset>
						<div class="row-fluid edit-page">
							{if $wechat.id neq ''}
							<div class="control-group formSep">
								<label class="control-label">{t domain="platform"}UUID：{/t}</label>
								<div class="controls l_h30">
									{$wechat.uuid}<br>
									<input type="hidden" name="uuid" value="{$wechat.uuid}" />
								</div>
							</div>
							
							<div class="control-group formSep">
								<label class="control-label">{t domain="platform"}外部访问地址：{/t}</label>
								<div class="controls l_h30">
									<input class="w600" type="text" readonly value="{$url}" id="external_address" />&nbsp;&nbsp;
									<a class="btn copy-url-btn" href='javascript:;' data-clipboard-action="copy" data-clipboard-target="#external_address">复制URL</a>
								</div>
							</div>
							{/if}
							
							<div class="control-group formSep">
								<label class="control-label">{t domain="platform"}平台：{/t}</label>
								<div class="controls">
									<select name="platform" class="form-control w350">
										<option value="" {if $wechat.platform eq ''}selected="selected"{/if}>{t domain="platform"}请选择平台{/t}</option>
										<option value="wechat" {if $wechat.platform eq 'wechat'}selected="selected"{/if}>{t domain="platform"}微信{/t}</option>
									</select>
									<span class="input-must">*</span>
								</div>
							</div>
						
							<div class="control-group formSep">
								<label class="control-label">{t domain="platform"}公众号类型：{/t}</label>
								<div class="controls">
									<select name="type" class="form-control w350">
										<option value="0" {if $wechat.type eq 0}selected="selected"{/if}>{t domain="platform"}未认证的公众号{/t}</option>
										<option value="1" {if $wechat.type eq 1}selected="selected"{/if}>{t domain="platform"}订阅号{/t}</option>
										<option value="2" {if $wechat.type eq 2}selected="selected"{/if}>{t domain="platform"}服务号{/t}</option>
										<option value="3" {if $wechat.type eq 3}selected="selected"{/if}>{t domain="platform"}测试账号{/t}</option>
									</select>
									<span class="help-block">{t domain="platform"}认证服务号是指向微信官方交过300元认证费的服务号{/t}</span>
								</div>
							</div>
							
							<div class="control-group formSep">
								<label class="control-label">{t domain="platform"}公众号名称：{/t}</label>
								<div class="controls">
									<input class="w350" type="text" name="name" id="name" value="{$wechat.name}" />
									<span class="input-must">*</span>
								</div>
							</div>
							
							<div class="control-group formSep">
								<label class="control-label">{t domain="platform"}Logo：{/t}</label>
								<div class="controls chk_radio">
									<div class="fileupload {if $wechat.logo}fileupload-exists{else}fileupload-new{/if}" data-provides="fileupload">	
										<div class="fileupload-preview fileupload-exists thumbnail" style="width: 50px; height: 50px; line-height: 50px;">
											{if $wechat.logo}
											<img src="{$wechat.logo}" alt='{t domain="platform"}图片预览{/t}' />
											{/if}
										</div>
										<span class="btn btn-file">
											<span  class="fileupload-new">{t domain="platform"}浏览{/t}</span>
											<span  class="fileupload-exists">{t domain="platform"}修改{/t}</span>
											<input type='file' name='platform_logo' size="35"/>
										</span>
										<a class="btn fileupload-exists" {if !$wechat.logo}data-dismiss="fileupload" href="javascript:;"{else}data-toggle="ajaxremove" data-msg='{t domain="platform"}您确定要删除吗？{/t}' href='{url path="platform/admin/remove_logo" args="id={$wechat.id}"}' title='{t domain="platform"}删除{/t}' {/if}>{t domain="platform"}删除{/t}</a>
									</div>
								</div>
							</div>		
							
							<div class="control-group formSep">
								<label class="control-label">{t domain="platform"}Token：{/t}</label>
								<div class="controls">
									<input class="generate_token w350" type="text" name="token" id="token" value="{$wechat.token}" />&nbsp;&nbsp;
									<a class="toggle_view btn filter-btn" href='{url path="platform/admin/generate_token"}'  data-val="allow">{t domain="platform"}生成Token{/t}</a>&nbsp;&nbsp;
									<a class="btn copy-token-btn" href='javascript:;' data-clipboard-action="copy" data-clipboard-target="#token">{t domain="platform"}复制Token{/t}</a>
									<span class="input-must">*</span>
									<span class="help-block">{t domain="platform"}自定义的Token值，或者点击生成Token创建一个，复制到微信公众平台配置中{/t}</span>
								</div>
							</div>
							
							<div class="control-group formSep">
								<label class="control-label">{t domain="platform"}AppID：{/t}</label>
								<div class="controls">
									<input class="w350" type="text" name="appid" id="appid" value="{$wechat.appid}" />
									<span class="input-must">*</span>
								</div>
							</div>
							
							<div class="control-group formSep">
								<label class="control-label">{t domain="platform"}AppSecret：{/t}</label>
								<div class="controls">
									<input class="w350" type="text" name="appsecret" id="appsecret" value="{$wechat.appsecret}" />
									<span class="input-must">*</span>
								</div>
							</div>
							
							<div class="control-group formSep">
								<label class="control-label">{t domain="platform"}EncodingAESKey：{/t}</label>
								<div class="controls">
									<input class="w350" type="text" name="aeskey" id="aeskey" value="{$wechat.aeskey}" />
								</div>
							</div>

							<div class="control-group formSep">
								<label class="control-label">{t domain="platform"}消息加密方式：{/t}</label>
								<div class="controls chk_radio">
									<input type="radio" checked><span>{t domain="platform"}明文模式{/t}</span><span class="custom-help-block">{t domain="platform"}(不使用消息体加解密功能，安全系数较低){/t}</span>
								</div>
							</div>
							
							<div class="control-group formSep">
								<label class="control-label">{t domain="platform"}状态：{/t}</label>
								<div class="controls chk_radio">
									<input type="radio" name="status" value="1" {if $wechat.status eq 1}checked{/if}><span>{t domain="platform"}开启{/t}</span>
                                    <input type="radio" name="status" value="0" {if $wechat.status eq 0}checked{/if}><span>{t domain="platform"}关闭{/t}</span>
								</div>
							</div>
								
							<div class="control-group formSep">
								<label class="control-label">{t domain="platform"}排序：{/t}</label>
								<div class="controls">
									<input class="w350" type="text" name="sort" id="sort" value="{$wechat.sort|default:0}" />
								</div>
							</div>
							
							<div class="control-group">
	        					<div class="controls">
	        						{if $wechat.id eq ''}
	        						<input type="submit" name="submit" value='{t domain="platform"}确定{/t}' class="btn btn-gebo" />
	        						{else}
	        						<input type="submit" name="submit" value='{t domain="platform"}更新{/t}' class="btn btn-gebo" />
	        						{/if}
									<input name="id" type="hidden" value="{$wechat.id}">
								</div>
							</div>
						</div>
					</fieldset>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- {/block} -->