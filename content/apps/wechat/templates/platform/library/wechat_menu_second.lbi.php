<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<div class="weixin-menu-detail">
	<div class="menu-input-group" style="border-bottom: 2px #e8e8e8 solid;">
		<div class="menu-name">{$wechat_menus.name}</div>
		<div class="menu-del" data-toggle="del-menu" data-id="{$id}">{t domain="wechat"}删除菜单{/t}</div>
	</div>
	<div class="menu-input-group">
		<div class="menu-label col-lg-3">{t domain="wechat"}菜单名称：{/t}</div>
		<div class="menu-input col-lg-8">
			<input type="text" name="name" placeholder='{t domain="wechat"}请输入菜单名称{/t}' class="form-control" value="{$wechat_menus.name}">
			<p class="menu-tips hide" style="color:#e15f63" v-show="menuNameBounds">
                {t domain="wechat"}字数超过上限{/t}
			</p>
			<p class="menu-tips">
                {t domain="wechat"}字数不超过6个汉字或16个字母{/t}
			</p>
		</div>
		<span class="input-must">*</span>
	</div>

	<div class="menu-input-group">
		<div class="menu-label col-lg-3">{t domain="wechat"}是否开启：{/t}</div>
		<div class="menu-input col-lg-8">
			<input id="status_1" type="radio" name="status" value="1" {if $wechat_menus.status eq 1}checked{/if}><label for="status_1"><span>{t domain="wechat"}是{/t}</span></label>
			<input id="status_0" type="radio" name="status" value="0" {if $wechat_menus.status eq 0}checked{/if}><label for="status_0"><span>{t domain="wechat"}否{/t}</span></label>
		</div>
	</div>

	<div class="menu-input-group">
		<div class="menu-label col-lg-3">{t domain="wechat"}排序：{/t}</div>
		<div class="menu-input col-lg-8">
			<input class="form-control" type="text" name="sort" value="{$wechat_menus.sort}" />
		</div>
	</div>

	<input type="hidden" name="id" value="{$id}">

	<div class="menu-input-group">
		<div class="menu-label col-lg-3"></div>
		<div class="menu-input col-lg-8">
			<input type="submit" class="btn btn-outline-primary btn-save" value='{t domain="wechat"}保存{/t}' />
		</div>
	</div>
</div>