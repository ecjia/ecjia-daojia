<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.platform.init();
	ecjia.admin.generate_token.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
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
							<div class="control-group formSep" >
								<label class="control-label">UUID：</label>
								<div class="controls l_h30">
									{$wechat.uuid}<br>
									<input type="hidden" name="uuid" value="{$wechat.uuid}" />
								</div>
							</div>
							
							<div class="control-group formSep" >
								<label class="control-label">{lang key='platform::platform.lable_external_address'}</label>
								<div class="controls l_h30">
									{$url}
								</div>
							</div>
							{/if}
							
							<div class="control-group formSep" >
								<label class="control-label">{lang key='platform::platform.lable_terrace'}</label>
								<div class="controls w300 no-chzn-container">
									<select name="platform" class="form-control">
										<option value="0" {if $wechat.platform eq 0}selected="selected"{/if}>{lang key='platform::platform.select_terrace'}</option>
										<option value="wechat" {if $wechat.platform eq 'wechat'}selected="selected"{/if}>{lang key='platform::platform.weixin'}</option>
									</select>
									<span class="input-must">{lang key='system::system.require_field'}</span>
								</div>
							</div>
						
							<div class="control-group formSep" >
								<label class="control-label">{lang key='platform::platform.lable_platform_num_type'}</label>
								<div class="controls w300">
									<select name="type" class="form-control">
										<option value="0" {if $wechat.type eq 0}selected="selected"{/if}>{lang key='platform::platform.un_platform_num'}</option>
										<option value="1" {if $wechat.type eq 1}selected="selected"{/if}>{lang key='platform::platform.subscription_num'}</option>
										<option value="2" {if $wechat.type eq 2}selected="selected"{/if}>{lang key='platform::platform.server_num'}</option>
										<option value="3" {if $wechat.type eq 3}selected="selected"{/if}>{lang key='platform::platform.test_account'}</option>
									</select>
									<span class="help-block">{lang key='platform::platform.weixin_three_hundred'}</span>
								</div>
							</div>
							
							<div class="control-group formSep" >
								<label class="control-label">{lang key='platform::platform.lable_platform_name'}</label>
								<div class="controls">
									<input type="text" name="name" id="name" value="{$wechat.name}" />
									<span class="input-must">{lang key='system::system.require_field'}</span>
								</div>
							</div>
							
							<div class="control-group formSep">
								<label class="control-label">{lang key='platform::platform.lable_logo'}</label>
								<div class="controls chk_radio">
									<div class="fileupload {if $wechat.logo}fileupload-exists{else}fileupload-new{/if}" data-provides="fileupload">	
										<div class="fileupload-preview fileupload-exists thumbnail" style="width: 50px; height: 50px; line-height: 50px;">
											{if $wechat.logo}
											<img src="{$wechat.logo}" alt="{lang key='platform::platform.look_picture'}" />
											{/if}
										</div>
										<span class="btn btn-file">
											<span  class="fileupload-new">{lang key='platform::platform.browse'}</span>
											<span  class="fileupload-exists">{lang key='platform::platform.modification'}</span>
											<input type='file' name='platform_logo' size="35"/>
										</span>
										<a class="btn fileupload-exists" {if !$wechat.logo}data-dismiss="fileupload" href="javascript:;"{else}data-toggle="ajaxremove" data-msg="{lang key='platform::platform.sure_del'}" href='{url path="platform/admin/remove_logo" args="id={$wechat.id}"}' title="{lang key='platform::platform.delete'}"{/if}>{lang key='platform::platform.delete'}</a>
									</div>
								</div>
							</div>		
							
							<div class="control-group formSep" >
								<label class="control-label">{t}Token：{/t}</label>
								<div class="controls">
									<input class="generate_token" type="text" name="token" id="token" value="{$wechat.token}" />&nbsp;&nbsp;
									<a class="toggle_view btn filter-btn" href='{url path="platform/admin/generate_token"}'  data-val="allow" >生成Token</a>
									<span class="input-must">{lang key='system::system.require_field'}</span>
									<span class="help-block">自定义的Token值，或者点击生成Token创建一个，复制到微信公众平台配置中</span>
								</div>
							</div>
							
							<div class="control-group formSep" >
								<label class="control-label">{lang key='platform::platform.lable_appid'}</label>
								<div class="controls">
									<input type="text" name="appid" id="appid" value="{$wechat.appid}" />
									<span class="input-must">{lang key='system::system.require_field'}</span>
								</div>
							</div>
							
							<div class="control-group formSep" >
								<label class="control-label">{t}AppSecret：{/t}</label>
								<div class="controls">
									<input type="text" name="appsecret" id="appsecret" value="{$wechat.appsecret}" />
									<span class="input-must">{lang key='system::system.require_field'}</span>
								</div>
							</div>
							
							<div class="control-group formSep" >
								<label class="control-label">{t}EncodingAESKey：{/t}</label>
								<div class="controls">
									<input type="text" name="aeskey" id="aeskey" value="{$wechat.aeskey}" />
								</div>
							</div>
							
							<div class="control-group formSep" >
								<label class="control-label">{lang key='platform::platform.lable_status'}</label>
								<div class="controls chk_radio">
									<input type="radio" name="status" value="1" {if $wechat.status eq 1}checked{/if}><span>{lang key='platform::platform.open'}</span>
                                    <input type="radio" name="status" value="0" {if $wechat.status eq 0}checked{/if}><span>{lang key='platform::platform.close'}</span>
								</div>
							</div>
								
							<div class="control-group formSep" >
								<label class="control-label">{lang key='platform::platform.lable_sort'}</label>
								<div class="controls">
									<input type="text" name="sort" id="sort" value="{$wechat.sort|default:0}" />
								</div>
							</div>
							
							<div class="control-group">
	        					<div class="controls">
	        						{if $wechat.id eq ''}
	        						<input type="submit" name="submit" value="{lang key='platform::platform.confirm'}" class="btn btn-gebo" />	
	        						{else}
	        						<input type="submit" name="submit" value="{lang key='platform::platform.update'}" class="btn btn-gebo" />	
	        						{/if}
									<input name="id" type="hidden"value="{$wechat.id}">
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