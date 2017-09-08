<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.wechat_menus_edit.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
{if $warn}
	{if $type eq 0}
	 	<div class="alert alert-error">
	        <strong>{lang key='wechat::wechat.label_notice'}</strong>{$type_error}
	    </div>
	{/if}
{/if}

{if $errormsg}
 	<div class="alert alert-error">
        <strong>{lang key='wechat::wechat.label_notice'}</strong>{$errormsg}
    </div>
{/if}
	
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		{if $action_link} 
		<a class="btn plus_or_reply data-pjax" href="{$action_link.href}" id="sticky_a"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		{/if}
	</h3>
</div>

<div class="row-fluid ">
	<div class="span12">
		<div class="tabbable">
			<form class="form-horizontal" action="{$form_action}" method="post" name="theForm" >
				<div class="tab-content">
					<fieldset>
						<div class="control-group formSep" >
							<label class="control-label">{lang key='wechat::wechat.label_parent_menu'}</label>
							<div class="controls">
								<select name="pid" class="form-control">
									<option value="">{lang key='wechat::wechat.pls_select_menu'}</option>
									<!-- {foreach from=$pmenu item=val} -->
									<option value="{$val.id}" {if $val.id eq $child}selected{/if}>{$val.name}</option>
									<!-- {/foreach} -->
								</select>
							</div>
						</div>
						
						<div class="control-group formSep" >
							<label class="control-label">{lang key='wechat::wechat.label_menu_name'}</label>
							<div class="controls">
								<input type="text" name="name" id="name" value="{$wechatmenus.name}" />
								<span class="input-must">{lang key='system::system.require_field'}</span>
							</div>
						</div>
						
						<div class="control-group formSep" >
							<label class="control-label">{lang key='wechat::wechat.label_menu_type'}</label>
							<div class="controls">
								<input type="radio" name="type" value="click" {if $wechatmenus.type eq 'click'}checked{/if}><span>发送消息</span>
								<input type="radio" name="type" value="view"  {if $wechatmenus.type eq 'view'}checked{/if}><span>跳转网页</span>
								<input type="radio" name="type" value="miniprogram"  {if $wechatmenus.type eq 'miniprogram'}checked{/if}><span>跳转小程序</span>
							</div>
						</div>
						
						<div id="keydiv" class="control-group formSep">
							<label class="control-label">{lang key='wechat::wechat.label_menu_keywords'}</label>
							<div class="controls">
								<input type="text" name="key" id="key" value="{$wechatmenus.key}" />
							</div>
						</div>
						
						<div id="urldiv" class="control-group formSep">
							<label class="control-label">{lang key='wechat::wechat.label_menu_url'}</label>
							<div class="controls">
								<input type="text" name="url" id="url" value="{$wechatmenus.url}" />
							</div>
						</div>
						
						<div id="weappdiv" class="control-group formSep" >
							<label class="control-label">选择小程序：</label>
							<div class="controls">
								<select class="form-control"  id="weapp_appid" name="weapp_appid">
			                        <option value='0'>请选择</option>
			                      	<!-- {foreach from=$weapplist key=key item=val} -->
									<option value="{$key}" {if $key eq $wechatmenus.app_id}selected{/if}>{$val}</option>
									<!-- {/foreach} -->
								</select>
							</div>
						</div>
						
						<div class="control-group formSep" >
							<label class="control-label">{lang key='wechat::wechat.label_menu_status'}</label>
							<div class="controls">
								<input type="radio" class="uni_style" name="status" value="1" {if $wechatmenus.status eq 1}checked{/if}><span>{lang key='system::system.yes'}</span>
								<input type="radio" class="uni_style" name="status" value="0" {if $wechatmenus.status eq 0}checked{/if}><span>{lang key='system::system.no'}</span>
							</div>
						</div>
						
						<div class="control-group formSep" >
							<label class="control-label">{lang key='wechat::wechat.label_sort'}</label>
							<div class="controls">
								<input type="text" name="sort" id="sort" value="{$wechatmenus.sort}" />
							</div>
						</div>
						
						<div class="control-group">
        					<div class="controls">
								<input name="menu_id" type="hidden"value="{$wechatmenus.id}">
								{if $errormsg}
								<input type="submit" name="submit" value="{lang key='wechat::wechat.ok'}" disabled="disabled" class="btn btn-gebo" />	
								{else}
								<input type="submit" name="submit" value="{lang key='wechat::wechat.ok'}" class="btn btn-gebo" />	
								{/if}
							</div>
						</div>
					</fieldset>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- {/block} -->