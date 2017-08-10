<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.admin_nav.addlist();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
	</h3>
</div>
<div id="navigator_addlist">
	<div class="row-fluid">
		<form action="{$form_action}" method="get" name="theForm">
			<div class="nav_list choose_list span12">
				<label for="type">{t}选择要编辑的菜单：{/t}</label>
				<select name="type">
					<option value="-" checked >{t}--选择--{/t}</option>
					<!-- {foreach from=$nav_list item=lists} -->
					<option value="{$lists.type}" >{$lists.name}</option>
					<!-- {/foreach} -->
				</select>
				<a class="btn data-pjax f_l m_r5" href="javascript:;">{t}选择{/t}</a>
				<span class="m_r5">{t}或{/t}</span><a class="data-pjax" href="{url path='theme/navigator/init'}">{t}返回自定义导航栏{/t}</a>
			</div>
		</form>
	</div>
	<div class="row-fluid nav_main">
		<div class="span3 nav_add">
			<div class="accordion" id="accordion2">
				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle" href="#collapseTwo2" data-parent="#accordion2" data-toggle="collapse">{t}页面{/t}</a>
					</div>
					<div class="accordion-body collapse in" id="collapseTwo2">
						<div class="accordion-inner">
							<!-- {foreach from=$pagenav item=nav} -->
							<label><input class="nav_url" type="checkbox" value="{$nav.1}" /><span class="nav_name">{$nav.0}</span></label>
							<!-- {/foreach} -->
							<p><a class="checkall btn btn-mini" href="javascript:;">{t}全选{/t}</a><a class="btn btn-mini btn-info f_r addtolist m_b10" href="javascript:;">{t}添加至菜单{/t}</a></p>
						</div>
					</div>
				</div>
				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle" data-parent="#accordion2" data-toggle="collapse" href="#collapseOne2">{t}链接{/t}</a>
					</div>
					<div class="accordion-body collapse" id="collapseOne2">
						<div class="accordion-inner">
							<p>{t}URL：{/t}<input class="span10 nav_url" type="text" name="nav_url" /></p>
							<p>{t}文字：{/t}<input class="span10 nav_name" type="text" /></p>
							<p><a class="btn btn-mini btn-info f_r addtolist m_b10" href="javascript:;">{t}添加至菜单{/t}</a></p>
						</div>
					</div>
				</div>
				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle" data-parent="#accordion2" data-toggle="collapse" href="#collapseThree2">{t}分类目录{/t}</a>
					</div>
					<div class="accordion-body collapse" id="collapseThree2">
						<div class="accordion-inner">
							<!-- {foreach from=$categorynav item=nav} -->
							<label><input class="nav_url" type="checkbox" value="{$nav.1}" /><span class="nav_name">{$nav.2}</span></label>
							<!-- {/foreach} -->
							<p>
								<a class="checkall btn btn-mini" href="javascript:;">{t}全选{/t}</a><a class="btn btn-mini btn-info f_r addtolist m_b10" href="javascript:;">{t}添加至菜单{/t}</a>
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="span9 nav_edit">
			<form class="add_navlist_form" name="theForm" action="{url path='theme/navigator/update_nav_list'}" method="post">
				<div class="nav_edit_hd">
					<label for="nav_name">{t}菜单名称：{/t}</label><input id="nav_name" name="nav_name" type="text" /><a class="data-pjax btn btn-info f_r" href="">{t}创建菜单{/t}</a>
				</div>
				<div class="nav_edit_bd">
					<span class="help-block">{t}在上面给菜单命名，然后点击“创建菜单”。{/t}</span>
				</div>
				<div class="nav_edit_ft">
					<a class="data-pjax btn btn-info f_r" href="">{t}创建菜单{/t}</a>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- {/block} -->