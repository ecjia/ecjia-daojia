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
	<strong>{t domain="wechat"}温馨提示：{/t}</strong>{$type_error}
</div>
{/if}

{if $errormsg}
<div class="alert alert-danger">
	<strong>{t domain="wechat"}温馨提示：{/t}</strong>{$errormsg}
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
								<label class="col-lg-2 label-control text-right">{t domain="wechat"}父级菜单：{/t}</label>
								<div class="col-lg-8 controls">
									<select name="pid" class="select2 form-control">
										<option value="">{t domain="wechat"}请选择菜单{/t}</option>
										<!-- {foreach from=$pmenu item=val} -->
										<option value="{$val.id}" {if $val.id eq $child}selected{/if}>{$val.name}</option>
										<!-- {/foreach} -->
									</select>
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-lg-2 label-control text-right">{t domain="wechat"}菜单名称：{/t}</label>
								<div class="col-lg-8 controls">
									<input class="form-control" type="text" name="name" id="name" value="{$wechatmenus.name}" />
								</div>
								<span class="input-must">*</span>
							</div>
							
							<div class="form-group row">
								<label class="col-lg-2 label-control text-right">{t domain="wechat"}菜单类型：{/t}</label>
								<div class="col-lg-8 controls">
									<input id="type_click" type="radio" name="type" value="click" {if $wechatmenus.type eq 'click'}checked{/if}><label for="type_click"><span>{t domain="wechat"}发送消息{/t}</span></label>
									<input id="type_view" type="radio" name="type" value="view" {if $wechatmenus.type eq 'view'}checked{/if}><label for="type_view"><span>{t domain="wechat"}跳转网页{/t}</span></label>
									<input id="type_miniprogram" type="radio" name="type" value="miniprogram" {if $wechatmenus.type eq 'miniprogram'}checked{/if}><label for="type_miniprogram"><span>{t domain="wechat"}跳转小程序{/t}</span></label>
								</div>
							</div>
							
							<div  id="keydiv" class="form-group row">
								<label class="col-lg-2 label-control text-right">{t domain="wechat"}菜单关键词：{/t}</label>
								<div class="col-lg-8 controls">
									<input class="form-control" type="text" name="key" id="key" value="{$wechatmenus.key}" />
								</div>
							</div>
							
							<div id="urldiv" class="form-group row">
								<label class="col-lg-2 label-control text-right">{t domain="wechat"}外链url：{/t}</label>
								<div class="col-lg-8 controls">
									<input class="form-control" type="text" name="url" id="url" value="{$wechatmenus.url}" />
								</div>
							</div>
							
							<div id="weappdiv" class="form-group row" >
								<label class="col-lg-2 label-control text-right">{t domain="wechat"}选择小程序：{/t}</label>
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
								<label class="col-lg-2 label-control text-right">{t domain="wechat"}是否开启：{/t}</label>
								<div class="col-lg-8 controls">
									<input id="status_1" type="radio" class="uni_style" name="status" value="1" {if $wechatmenus.status eq 1}checked{/if}><label for="status_1">{t domain="wechat"}是{/t}</label>
									<input id="status_0" type="radio" class="uni_style" name="status" value="0" {if $wechatmenus.status eq 0}checked{/if}><label for="status_0">{t domain="wechat"}否{/t}</label>
								</div>
							</div>
							
							<div class="form-group row" >
								<label class="col-lg-2 label-control text-right">{t domain="wechat"}排序：{/t}</label>
								<div class="col-lg-8 controls">
									<input class="form-control" type="text" name="sort" id="sort" value="{$wechatmenus.sort}" />
								</div>
							</div>
						</div>
					</div>
	
					<div class="modal-footer justify-content-center">
						<input name="menu_id" type="hidden"value="{$wechatmenus.id}">
						{if $errormsg}
						<input type="submit" name="submit" value='{t domain="wechat"}确定{/t}' disabled="disabled" class="btn btn-outline-primary" />
						{else}
						<input type="submit" name="submit" value='{t domain="wechat"}确定{/t}' class="btn btn-outline-primary" />
						{/if}
					</div>
				</form>	
            </div>
        </div>
    </div>
</div>
<!-- {/block} -->