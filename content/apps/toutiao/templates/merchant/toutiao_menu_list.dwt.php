<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->
<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.merchant.menu.init();
</script>
<!-- {/block} -->
<!-- {block name="home-content"} -->
<div class="row">
	<div class="col-lg-12">
		<h2 class="page-header">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		</h2>
	</div>
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="panel">
			<div class="weixin-menu-title">{t domain="toutiao"}店铺菜单列表{/t}</div>
			<div class="weixin-menu-content">
				<div id="weixin-app-menu">
					<div class="weixin-menu-right">
						<form class="form" name="the_form" method="post" action="{RC_Uri::url('toutiao/mh_menu/update')}">
							<div class="weixin-menu-right-content">
								<div class="menu_initial_tips">{t domain="toutiao"}点击左侧菜单进行编辑操作{/t}</div>
							</div>
						</form>
					</div>
					<!-- 预览窗 -->
					<div class="weixin-preview">
						<div class="mobile_menu_preview">
							<div class="weixin-hd">
								<div class="weixin-title">{$store_name}</div>
							</div>
							<div class="weixin-bd">
								<ul class="weixin-menu" id="weixin-menu">
									<!-- {foreach from=$menu_list item=list name=m} -->
									<li class="menu-item size_{$count}">
										<div class="menu-item-title" data-toggle="edit-menu" data-id="{$list.id}" data-pid="{$list.pid}">
											{if $list.sub_button}
											<i class="icon_menu_dot"></i>
											{/if}
											<span>{$list.name}</span>
										</div>
										<ul class="weixin-sub-menu hide">
											<!-- {foreach from=$list.sub_button item=sub name=s} -->
											<li class="menu-sub-item {if $id eq $sub.id}current{/if}">
												<div class="menu-item-title" data-toggle="edit-menu" data-id="{$sub.id}" data-pid="{$sub.pid}">{$sub.name}</div>
											</li>
											<!-- {/foreach} -->
											{if $list.count lt 5}
											<li class="menu-sub-item" data-toggle="add-menu" data-pid="{$list.id}" data-count="{$list.count}">
												<div class="menu-item-title">
													<a class="pre_menu_link" href="javascript:void(0);" title='{t domain="toutiao"}最多添加5个子菜单{/t}'><i class="icon14_menu_add"></i></a>
												</div>
											</li>
											{/if}
											<i class="menu-arrow arrow_out"></i>
											<i class="menu-arrow arrow_in"></i>
										</ul>
									</li>
									<!-- {/foreach} -->
									{if $count lt 3}
									<li class="menu-item size_{$count}" data-toggle="add-menu" data-pid="0"><a class="pre_menu_link" href="javascript:void(0);" title='{t domain="toutiao"}最多添加3个一级菜单{/t}'> <i class="icon14_menu_add"></i> {if $count eq 0}<span>{t domain="toutiao"}添加菜单{/t}</span>{/if}</a></li>
									{/if}
								</ul>
							</div>
						</div>
					</div>
				</div>
				{if $menu_list}
				<div class="weixin-btn-group">
					<div data-toggle="btn-create" class="btn btn-warning m_l20" data-url='{RC_Uri::url("toutiao/mh_menu/sys_menu")}' data-msg='{t domain="toutiao"}发布成功后会覆盖原版本，且将在24小时内对所有用户生效，确认发布？{/t}'>{t domain="toutiao"}发布{/t}</div>
				</div>
				{/if}
				<input type="hidden" name="add_url" value="{$form_action}" />
				<input type="hidden" name="edit_url" value="{$edit_url}" />
				<input type="hidden" name="del_url" value="{$del_url}" />
				<input type="hidden" name="check_url" value="{$check_url}" />
			</div>
		</div>
	</div>
</div>
<!-- {/block} -->