<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-platform.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.platform.wechat_menus_edit.init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->
{if $warn && $type eq 0}
<div class="alert alert-danger">
	<strong>{lang key='wechat::wechat.label_notice'}</strong>{$type_error}
</div>
{/if}

{if $errormsg}
<div class="alert alert-danger">
	<strong>{lang key='wechat::wechat.label_notice'}</strong>{$errormsg}
</div>
{/if}

<div class="row">
    <div class="col-12">
        <div class="card">
			<div class="card-header">
                <h4 class="card-title">
                	{$ur_here}
	               	{if $action_link}
					<a class="btn btn-outline-primary plus_or_reply data-pjax float-right" href="{$action_link.href}" id="sticky_a"><i class="fa fa-reply"></i> {$action_link.text}</a>
					{/if}
                </h4>
            </div>
            <div class="col-lg-12">
				<form class="form" method="post" name="theForm" action="{$form_action}">
					<div class="card-body">
						<div class="form-body">
							<div class="form-group row">
								<label class="col-lg-2 label-control text-right">{lang key='wechat::wechat.label_parent_menu'}</label>
								<div class="col-lg-8 controls">
									<select name="pid" class="select2 form-control">
										<option value="">{lang key='wechat::wechat.pls_select_menu'}</option>
										<!-- {foreach from=$pmenu item=val} -->
										<option value="{$val.id}" {if $val.id eq $child}selected{/if}>{$val.name}</option>
										<!-- {/foreach} -->
									</select>
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-lg-2 label-control text-right">{lang key='wechat::wechat.label_menu_name'}</label>
								<div class="col-lg-8 controls">
									<input class="form-control" type="text" name="name" id="name" value="{$wechatmenus.name}" />
								</div>
								<span class="input-must">{lang key='system::system.require_field'}</span>
							</div>
							
							<div class="form-group row">
								<label class="col-lg-2 label-control text-right">{lang key='wechat::wechat.label_menu_type'}</label>
								<div class="col-lg-8 controls">
									<input id="type_click" type="radio" name="type" value="click" {if $wechatmenus.type eq 'click'}checked{/if}><label for="type_click"><span>发送消息</span></label>
									<input id="type_view" type="radio" name="type" value="view"  {if $wechatmenus.type eq 'view'}checked{/if}><label for="type_view"><span>跳转网页</span></label>
									<input id="type_miniprogram" type="radio" name="type" value="miniprogram"  {if $wechatmenus.type eq 'miniprogram'}checked{/if}><label for="type_miniprogram"><span>跳转小程序</span></label>
								</div>
							</div>
							
							<div  id="keydiv" class="form-group row">
								<label class="col-lg-2 label-control text-right">{lang key='wechat::wechat.label_menu_keywords'}</label>
								<div class="col-lg-8 controls">
									<input class="form-control" type="text" name="key" id="key" value="{$wechatmenus.key}" />
								</div>
							</div>
							
							<div id="urldiv" class="form-group row">
								<label class="col-lg-2 label-control text-right">{lang key='wechat::wechat.label_menu_url'}</label>
								<div class="col-lg-8 controls">
									<input class="form-control" type="text" name="url" id="url" value="{$wechatmenus.url}" />
								</div>
							</div>
							
							<div id="weappdiv" class="form-group row" >
								<label class="col-lg-2 label-control text-right">选择小程序：</label>
								<div class="col-lg-8 controls">
									<select class="select2 form-control"  id="weapp_appid" name="weapp_appid">
				                        <option value='0'>请选择</option>
				                      	<!-- {foreach from=$weapplist key=key item=val} -->
										<option value="{$key}" {if $key eq $wechatmenus.app_id}selected{/if}>{$val}</option>
										<!-- {/foreach} -->
									</select>
								</div>
							</div>
							
							<div class="form-group row" >
								<label class="col-lg-2 label-control text-right">{lang key='wechat::wechat.label_menu_status'}</label>
								<div class="col-lg-8 controls">
									<input id="status_1" type="radio" class="uni_style" name="status" value="1" {if $wechatmenus.status eq 1}checked{/if}><label for="status_1">{lang key='system::system.yes'}</label>
									<input id="status_0" type="radio" class="uni_style" name="status" value="0" {if $wechatmenus.status eq 0}checked{/if}><label for="status_0">{lang key='system::system.no'}</label>
								</div>
							</div>
							
							<div class="form-group row" >
								<label class="col-lg-2 label-control text-right">{lang key='wechat::wechat.label_sort'}</label>
								<div class="col-lg-8 controls">
									<input class="form-control" type="text" name="sort" id="sort" value="{$wechatmenus.sort}" />
								</div>
							</div>
						</div>
					</div>
	
					<div class="modal-footer justify-content-center">
						<input name="menu_id" type="hidden"value="{$wechatmenus.id}">
						{if $errormsg}
						<input type="submit" name="submit" value="{lang key='wechat::wechat.ok'}" disabled="disabled" class="btn btn-outline-primary" />	
						{else}
						<input type="submit" name="submit" value="{lang key='wechat::wechat.ok'}" class="btn btn-outline-primary" />	
						{/if}
					</div>
				</form>	
            </div>
        </div>
    </div>
</div>
<!-- {/block} -->