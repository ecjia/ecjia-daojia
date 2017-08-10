<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.mobile_manage.info();
</script>
<!-- {/block} -->
<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a class="data-pjax btn plus_or_reply" id="sticky_a" href="{$action_link.href}"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>


<div class="row-fluid">
	<div class="span12">
		<form class="form-horizontal" id="form-privilege" name="theForm" action="{$form_action}" method="post" enctype="multipart/form-data" >
			<fieldset>
				{if $action eq 'edit'}
					<div class="control-group formSep">
						<label class="control-label">应用名称：</label>
						<div class="controls l_h30">
						<span class="cursor_pointer ecjiaf-pre ecjiaf-wsn" data-trigger="editable" data-url='{url path="mobile/admin_mobile_manage/edit_app_name" args="code={$manage_data.platform}"}' data-name="app_name" data-pk="{$manage_data.app_id}" data-title="应用名称">{$manage_data.app_name}</span>
						</div>
					</div>
					
					<div class="control-group formSep">
						<label class="control-label">应用包名：</label>
						<div class="controls l_h30">
						<span class="cursor_pointer ecjiaf-pre ecjiaf-wsn" data-trigger="editable" data-url='{url path="mobile/admin_mobile_manage/edit_bag_name" args="code={$manage_data.platform}"}' data-name="bag_name" data-pk="{$manage_data.app_id}" data-title="应用包名">{$manage_data.bundle_id}</span>
						</div>
					</div>
					
					<div class="control-group formSep">
						<label class="control-label">Code：</label>
						<div class="controls l_h30">
							{$manage_data.platform}
						</div>
					</div>
					
					<div class="control-group formSep">
						<label class="control-label">Client：</label>
						<div class="controls l_h30">
							{$manage_data.device_client}
						</div>
					</div>
					
					<div class="control-group">
						<label class="control-label">Device Code：</label>
						<div class="controls l_h30">
							{$manage_data.device_code}
						</div>
					</div>

					<h3 class="heading">安全信息</h3>
					<div class="control-group formSep">
						<label class="control-label">AppKey：</label>
						<div class="controls l_h30">
							<div id="app_key" class="app_copy" data-clipboard-text="{$manage_data.app_key}">
								<span>{$manage_data.app_key}</span>
								<span class="cursor_pointer copy"><strong>复制</strong></span>
							</div>
						</div>
					</div>
					
					<div class="control-group formSep">
						<label class="control-label">AppSecret：</label>
						<div class="controls l_h30">
							<div id="app_secret"class="app_copy" data-clipboard-text="{$manage_data.app_secret}">
								<span>{$manage_data.app_secret}</span>
								<span class="cursor_pointer copy">复制</span>
							</div>
						</div>
					</div>
				{else}
					<div class="control-group formSep">
						<label class="control-label">应用名称：</label>
						<div class="controls">
							<input class="span4" name="name" type="text" value="" />
							<span class="input-must">{lang key='system::system.require_field'}</span> 
						</div>
					</div>
					<div class="control-group formSep">
						<label class="control-label">应用包名：</label>
						<div class="controls">
							<input class="span4" name="bundleid" type="text" value="" />
							<span class="input-must">{lang key='system::system.require_field'}</span> 
						</div>
					</div>
				{/if}
									
				{if $action eq 'edit'}
					<input type="hidden" name="code_vale" value="{$manage_data.platform}" />
					<input type="hidden" name="id" value="{$manage_data.app_id}" />
					<a data-toggle="ajaxremove" class="ajaxremove ecjiafc-red"  data-msg="你确定要删除该客户端端吗？"  href='{RC_Uri::url("mobile/admin_mobile_manage/remove","id={$manage_data.app_id}&code={$manage_data.platform}")}' title="删除">删除客户端</a>
					<div class="pull-right">
						<a class="change_status" style="cursor: pointer;"  
						 data-msg="{if $manage_data.status eq 1}您确定要关闭该客户端吗？{else}您确定要开启该客户端吗？{/if}" 
						 data-href='
						 {if $manage_data.status eq 1}
						 	{url path="mobile/admin_mobile_manage/close_status" args="code={$manage_data.platform}&id={$manage_data.app_id}"}
						 {else}
						 	{url path="mobile/admin_mobile_manage/open_status" args="code={$manage_data.platform}&id={$manage_data.app_id}"}
						 {/if}' >
				       	 {if $manage_data.status eq 1}
				         	<button class="btn" type="button" >点击关闭客户端</button>  
				         {else}
				         	<button class="btn btn-gebo" type="button" >点击开启客户端</button> 
				         {/if}
				        </a>  
				     </div>
				{else}
					<div class="control-group">
						<div class="controls">
							<input type="hidden" name="device_code" value="{$device_code} "/>
							<input type="hidden" name="device_client" value="{$device_client}" />
							<input type="hidden" name="code" value="{$code}" />
							<button class="btn btn-gebo" type="submit">激活</button>
						</div>
					</div>
				{/if}
					
			</fieldset>
		</form>
	</div>
</div>
<!-- {/block} -->