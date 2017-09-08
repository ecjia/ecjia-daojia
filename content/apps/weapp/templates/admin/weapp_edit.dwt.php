<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.weapp.init();
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
							{if $wxapp_info.id neq ''}
								<div class="control-group formSep" >
									<label class="control-label">UUID：</label>
									<div class="controls l_h30">
										{$wxapp_info.uuid}<br>
									</div>
								</div>
							{/if}
							<div class="control-group formSep" >
								<label class="control-label">小程序名称</label>
								<div class="controls">
									<input type="text" name="name" value="{$wxapp_info.name}" />
									<span class="input-must">{lang key='system::system.require_field'}</span>
								</div>
							</div>
							<div class="control-group formSep">
								<label class="control-label">Logo</label>
								<div class="controls chk_radio">
									<div class="fileupload {if $wxapp_info.logo}fileupload-exists{else}fileupload-new{/if}" data-provides="fileupload">	
										<div class="fileupload-preview fileupload-exists thumbnail" style="width: 50px; height: 50px; line-height: 50px;">
											{if $wxapp_info.logo}
											<img src="{$wxapp_info.logo}" alt="{lang key='weapp::weapp.look_picture'}" />
											{/if}
										</div>
										<span class="btn btn-file">
											<span  class="fileupload-new">{lang key='weapp::weapp.browse'}</span>
											<span  class="fileupload-exists">{lang key='weapp::weapp.modification'}</span>
											<input type='file' name='weapp_logo' size="35"/>
										</span>
										<a class="btn fileupload-exists" {if !$wxapp_info.logo}data-dismiss="fileupload" href="javascript:;"{else}data-toggle="ajaxremove" data-msg="{lang key='weapp::weapp.sure_del'}" href='{url path="weapp/admin/remove_logo" args="id={$wxapp_info.id}"}' title="{lang key='weapp::weapp.delete'}"{/if}>{lang key='weapp::weapp.delete'}</a>
									</div>
								</div>
							</div>		
							<div class="control-group formSep" >
								<label class="control-label">AppID：</label>
								<div class="controls">
									<input type="text" name="appid" value="{$wxapp_info.appid}" />
									<span class="input-must">{lang key='system::system.require_field'}</span>
								</div>
							</div>
							
							<div class="control-group formSep" >
								<label class="control-label">{t}AppSecret：{/t}</label>
								<div class="controls">
									<input type="text" name="appsecret" value="{$wxapp_info.appsecret}" />
									<span class="input-must">{lang key='system::system.require_field'}</span>
								</div>
							</div>
							
							<div class="control-group formSep" >
								<label class="control-label">{lang key='weapp::weapp.lable_status'}</label>
								<div class="controls chk_radio">
									<input type="radio" name="status" value="1" {if $wxapp_info.status eq 1}checked{/if}><span>{lang key='weapp::weapp.open'}</span>
                                    <input type="radio" name="status" value="0" {if $wxapp_info.status eq 0}checked{/if}><span>{lang key='weapp::weapp.close'}</span>
								</div>
							</div>
								
							<div class="control-group formSep" >
								<label class="control-label">{lang key='weapp::weapp.lable_sort'}</label>
								<div class="controls">
									<input type="text" name="sort" value="{$wxapp_info.sort|default:0}" />
								</div>
							</div>
							
							<div class="control-group">
	        					<div class="controls">
	        						{if $wxapp_info.id eq ''}
	        						<input type="submit" name="submit" value="{lang key='weapp::weapp.confirm'}" class="btn btn-gebo" />	
	        						{else}
	        						<input type="submit" name="submit" value="{lang key='weapp::weapp.update'}" class="btn btn-gebo" />	
	        						{/if}
									<input name="id" type="hidden"value="{$wxapp_info.id}">
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