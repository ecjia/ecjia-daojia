<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<div class="weixin-menu-detail">
	<div class="menu-input-group menu-title">
		<div class="menu-name">{$menus.name}</div>
		<div class="menu-del" data-toggle="del-menu" data-id="{$id}"><i class="fa fa-trash-o"></i></div>
	</div>
	<div class="menu-input-group">
		<div class="menu-label col-lg-3">菜单名称：</div>
		<div class="menu-input col-lg-8">
			<input type="text" name="name" placeholder="请输入菜单名称" class="form-control" value="{$menus.name}">
			<p class="menu-tips hide" style="color:#e15f63" v-show="menuNameBounds">
				字数超过上限
			</p>
			<p class="menu-tips">
				字数不超过6个汉字或16个字母
			</p>
		</div>
		<span class="input-must">*</span>
	</div>

	<div class="menu-input-group div-input">
		<div class="menu-label col-lg-3">外链url：</div>
		<div class="menu-input col-lg-8">
			<input class="form-control" type="text" name="url" id="url" value="{$menus.url}" />
			<p class="menu-tips hide" style="color:#e15f63;">请设置外联url</p>
		</div>
		<span class="input-must">*</span>
	</div>

	<div class="menu-input-group">
		<div class="menu-label col-lg-3">是否开启：</div>
		<div class="menu-input col-lg-8">
			<input id="status_1" type="radio" name="status" value="1" {if $menus.status eq 1}checked{/if}><label for="status_1"><span>是</span></label>
			<input id="status_0" type="radio" name="status" value="0" {if $menus.status eq 0}checked{/if}><label for="status_0"><span>否</span></label>
		</div>
	</div>
	<div class="menu-input-group">
		<div class="menu-label col-lg-3">排序：</div>
		<div class="menu-input col-lg-8">
			<input class="form-control" type="text" name="sort" value="{$menus.sort}" />
		</div>
	</div>
	<div class="menu-input-group">
		<div class="menu-label col-lg-3"></div>
		<div class="menu-input col-lg-8">
			<input type="submit" class="btn btn-info btn-save" value="保存" />
		</div>
	</div>
	<input type="hidden" name="pid" value="{$menus.pid}">
	<input type="hidden" name="id" value="{$id}">
</div>