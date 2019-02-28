<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<div class="weixin-menu-detail">
	<div class="menu-input-group menu-title">
		<div class="menu-name">{$menus.name}</div>
		<div class="menu-del" data-toggle="del-menu" data-id="{$id}"><i class="fa fa-trash-o"></i></div>
	</div>
	<div class="menu-input-group">
		<div class="menu-label col-lg-3">{t domain="toutiao"}菜单名称：{/t}</div>
		<div class="menu-input col-lg-8">
			<input type="text" name="name" placeholder='{t domain="toutiao"}请输入菜单名称{/t}' class="form-control" value="{$menus.name}">
			<p class="menu-tips hide" style="color:#e15f63" v-show="menuNameBounds">
                {t domain="toutiao"}字数超过上限{/t}
			</p>
			<p class="menu-tips">
                {t domain="toutiao"}字数不超过6个汉字或16个字母{/t}
			</p>
		</div>
		<span class="input-must">*</span>
	</div>
	<div class="menu-input-group">
		<div class="menu-label col-lg-3">{t domain="toutiao"}是否开启：{/t}</div>
		<div class="menu-input col-lg-8">
			<input id="status_1" type="radio" name="status" value="1" {if $menus.status eq 1}checked{/if}><label for="status_1"><span>{t domain="toutiao"}是{/t}</span></label>
			<input id="status_0" type="radio" name="status" value="0" {if $menus.status eq 0}checked{/if}><label for="status_0"><span>{t domain="toutiao"}否{/t}</span></label>
		</div>
	</div>
	<div class="menu-input-group">
		<div class="menu-label col-lg-3">{t domain="toutiao"}排序：{/t}</div>
		<div class="menu-input col-lg-8">
			<input class="form-control" type="text" name="sort" value="{$menus.sort}" />
		</div>
	</div>
	<input type="hidden" name="id" value="{$id}">
	<div class="menu-input-group">
		<div class="menu-label col-lg-3"></div>
		<div class="menu-input col-lg-8">
			<input type="submit" class="btn btn-info btn-save" value='{t domain="toutiao"}保存{/t}' />
		</div>
	</div>
</div>