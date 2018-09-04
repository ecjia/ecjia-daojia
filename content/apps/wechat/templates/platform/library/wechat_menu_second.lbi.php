<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<div class="weixin-menu-detail">
	<div class="menu-input-group" style="border-bottom: 2px #e8e8e8 solid;">
		<div class="menu-name">{$wechat_menus.name}</div>
		<div class="menu-del" data-toggle="del-menu" data-id="{$id}">删除菜单</div>
	</div>
	<div class="menu-input-group">
		<div class="menu-label col-lg-3">菜单名称：</div>
		<div class="menu-input col-lg-8">
			<input type="text" name="name" placeholder="请输入菜单名称" class="form-control" value="{$wechat_menus.name}">
			<p class="menu-tips hide" style="color:#e15f63" v-show="menuNameBounds">
				字数超过上限
			</p>
			<p class="menu-tips">
				字数不超过6个汉字或16个字母
			</p>
		</div>
		<span class="input-must">*</span>
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

	<input type="hidden" name="id" value="{$id}">

	<div class="menu-input-group">
		<div class="menu-label col-lg-3"></div>
		<div class="menu-input col-lg-8">
			<input type="submit" class="btn btn-outline-primary btn-save" value="保存" />
		</div>
	</div>
</div>
