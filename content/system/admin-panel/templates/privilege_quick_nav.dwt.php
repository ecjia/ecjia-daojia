<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.admin.privilege.modif();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<h3 class="heading">
	<!-- {if $ur_here}{$ur_here}{/if} -->
	<!-- {if $action_link} -->
	<a class="btn data-pjax plus_or_reply" id="sticky_a" href="{$action_link.href}"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
	<!-- {/if} -->
</h3>

<form class="form-horizontal {$action}" id="form-privilege" name="theForm" action="{$form_link}" method="post">
	<div class="row-fluid">
		<div class="span12">
			<div class="m_b20"><span class="help-inline">{t}点击左侧导航列表选项，添加个人导航。双击右侧个人导航列表，或点击x号，可从个人导航列表中移除。点击保存后保存更改。{/t}</span></div>
			<div class="control-group draggable">
				<div class="controls span12 m_b20">
					<div class="ms-container " id="ms-custom-navigation">
						<div class="ms-selectable">
							<div class="search-header">
								<input class="span12" type="text" placeholder="{t}搜索的导航名称{/t}" autocomplete="off" id="ms-search" />
							</div>
							<ul class="ms-list nav-list-ready">
								<!-- {foreach from=$menus_list.apps item=menu key=k} -->
								<group class="ms-group">
								<li class="ms-optgroup-label"><span>{$menu->name}</span></li>
								<!-- {foreach from=$menu->submenus item=child} -->
								<!-- {if $child->link} -->
								<li class="ms-elem-selectable {foreach from=$nav_arr item=nav}{if $nav == $child->name}disabled{/if}{/foreach}" id="{$child->action}" data-val="{$child->link}"><span><!-- {$child->name} --></span></li>
								<!-- {/if} -->
								<!-- {/foreach} -->
								</group>
								<!-- {foreachelse} -->
								<li class="ms-elem-selectable disabled"><span>{t}暂无内容{/t}</span></li>
								<!-- {/foreach} -->
							</ul>
						</div>
						<div class="ms-selection modif">
							<div class="custom-header custom-header-align">{t}个人自定义导航{/t}</div>
							<ul class="ms-list nav-list-content">
								<!-- {foreach from=$nav_arr item=nav key=key} -->
								<li class="ms-elem-selection"><input type="hidden" value="{$nav}|{$key}" name="nav_list[]"><!-- {$nav} --><span class="edit-list"><i class="fontello-icon-minus-circled ecjiafc-red"></i></span></li>
								<!-- {/foreach} -->
							</ul>
						</div>
					</div>
				</div>
			</div>

			<div class="control-group">
				<div class="controls">
					<input class="btn btn-gebo" type="submit" value="{t}保存{/t}" />&nbsp;&nbsp;&nbsp;
					<input class="btn" type="reset" value="{t}重置{/t}" />
					<input type="hidden" name="id" value="{$user.user_id}" />
				</div>
			</div>
		</div>
	</div>
</form>
<!-- {/block} -->
