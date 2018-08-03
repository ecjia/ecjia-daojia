<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<div class="weixin-menu-detail">
	<div class="menu-input-group" style="border-bottom: 2px #e8e8e8 solid;">
		<div class="menu-name">{$wechat_menus.name}</div>
		<div class="menu-del" data-toggle="del-menu" data-id="{$id}">{if $wechat_menus.pid eq 0}删除菜单{else}删除子菜单{/if}</div>
	</div>
	<div class="menu-input-group">
		<div class="menu-label col-lg-3">菜单名称：</div>
		<div class="menu-input col-lg-8">
			<input type="text" name="name" placeholder="请输入菜单名称" class="form-control" value="{$wechat_menus.name}">
			<p class="menu-tips hide" style="color:#e15f63" v-show="menuNameBounds">
				字数超过上限
			</p>
			<p class="menu-tips">
				字数不超过8个汉字或16个字母
			</p>
		</div>
		<span class="input-must">*</span>
	</div>

	<div class="menu-input-group">
		<div class="menu-label col-lg-3">菜单类型：</div>
		<div class="menu-input col-lg-8">
			<input id="type_click" type="radio" name="type" value="click" {if $wechat_menus.type eq 'click'}checked{/if}><label for="type_click"><span>发送消息</span></label>
			<input id="type_view" type="radio" name="type" value="view" {if $wechat_menus.type eq 'view'}checked{/if}><label for="type_view"><span>跳转网页</span></label>
			<input id="type_miniprogram" type="radio" name="type" value="miniprogram" {if $wechat_menus.type eq 'miniprogram'}checked{/if}><label for="type_miniprogram"><span>跳转小程序</span></label>
		</div>
	</div>

	<div class="menu-input-group div-input" id="keydiv">
		<div class="menu-label col-lg-3">菜单关键词：</div>
		<div class="menu-input col-lg-8">
			<select class="select2 form-control" id="key" name="key">
		   		<!-- {foreach from=$key_list key=key item=val} -->
				<optgroup label="{$key}">
					<!-- {foreach from=$val item=v} -->
					<option {if $wechat_menus.key eq $v}selected{/if} value="{$v}">{$v}</option>
					<!-- {/foreach} -->
				</optgroup>
				<!-- {/foreach} -->
			</select>

			<p class="menu-tips hide" style="color:#e15f63" v-show="menuNameBounds">
				请设置菜单关键词
			</p>
		</div>
	</div>

	<div class="menu-input-group div-input" id="urldiv">
		<div class="menu-label col-lg-3">外链url：</div>
		<div class="menu-input col-lg-8">
			<input class="form-control" type="text" name="url" id="url" value="{if $wechat_menus.type eq 'view'}{$wechat_menus.url}{/if}" />
			<p class="menu-tips" style="color:#e15f63; display: none;">请设置外联url</p>
		</div>
	</div>

	<div class="menu-input-group div-input" id="weappdiv">
		<div class="menu-label col-lg-3">选择小程序：</div>
		<div class="menu-input col-lg-8">
			<select class="select2 form-control" id="weapp_appid" name="weapp_appid">
		   		<option value='0'>请选择</option>
		  		<!-- {foreach from=$weapplist key=key item=val} -->
				<option value="{$key}" {if $key eq $wechat_menus.app_id}selected{/if}>{$val}</option>
				<!-- {/foreach} -->
			</select>
			<p class="menu-tips" style="color:#e15f63; display: none;">请选择小程序</p>
		</div>
	</div>

	<div class="menu-input-group">
		<div class="menu-label col-lg-3">是否开启：</div>
		<div class="menu-input col-lg-8">
			<input id="status_1" type="radio" name="status" value="1" {if $wechat_menus.status eq 1}checked{/if}><label for="status_1"><span>是</span></label>
			<input id="status_0" type="radio" name="status" value="0" {if $wechat_menus.status eq 0}checked{/if}><label for="status_0"><span>否</span></label>
		</div>
	</div>

	<div class="menu-input-group">
		<div class="menu-label col-lg-3">排序：</div>
		<div class="menu-input col-lg-8">
			<input class="form-control" type="text" name="sort" value="{$wechat_menus.sort}" />
		</div>
	</div>

	<div class="menu-input-group">
		<div class="menu-label col-lg-3"></div>
		<div class="menu-input col-lg-8">
			<input type="submit" class="btn btn-outline-primary btn-save" value="保存" />
		</div>
	</div>

	<input type="hidden" name="id" value="{$id}">
</div>
