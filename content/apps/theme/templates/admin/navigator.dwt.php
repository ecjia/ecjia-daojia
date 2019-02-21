<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.admin_nav.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
	</h3>
</div>
<div id="navigator">
	<div class="row-fluid">
		<div class="nav_list choose_list span12">
			<label for="type">{t domain="theme"}选择要编辑的菜单：{/t}</label>
			<select name="type">
				<!-- {foreach from=$nav_list item=lists} -->
				<option value="{$lists.type}" {if $lists.name == $nav_name}selected{/if} >{$lists.name}</option>
				<!-- {/foreach} -->
			</select>
			<a class="btn data-pjax f_l m_r5" href="javascript:;">{t domain="theme"}选择{/t}</a>
			<span class="m_r5">{t domain="theme"}或{/t}</span>
			<a class="data-pjax" href="{url path='theme/navigator/add_nav_list'}">{t domain="theme"}创建新菜单{/t}</a>
		</div>
	</div>

	<div class="row-fluid nav_main">
		<div class="span3 nav_add">
			<div class="accordion" id="accordion2">
				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle is-accordion" data-parent="#accordion2" data-toggle="collapse" href="#collapseTwo2">{t domain="theme"}页面{/t}</a>
					</div>
					<div class="accordion-body collapse in" id="collapseTwo2">
						<div class="accordion-inner">
							<!-- {foreach from=$pagenav item=nav} -->
							<label><input class="nav_url" type="checkbox" value="{$nav.1}" /><span class="nav_name">{$nav.0}</span></label>
							<!-- {/foreach} -->
							<p><a class="checkall btn btn-mini" href="javascript:;">{t domain="theme"}全选{/t}</a><a class="btn btn-mini btn-info f_r addtolist m_b10" href="javascript:;">{t domain="theme"}添加至菜单{/t}</a></p>
						</div>
					</div>
				</div>
				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle is-accordion" data-parent="#accordion2" data-toggle="collapse" href="#collapseOne2">{t domain="theme"}链接{/t}</a>
					</div>
					<div class="accordion-body collapse" id="collapseOne2">
						<div class="accordion-inner">
							<p>{t domain="theme"}URL：{/t}<input class="span10 nav_url" type="text" name="nav_url" /></p>
							<p>{t domain="theme"}文字：{/t}<input class="span10 nav_name" type="text" /></p>
							<p><a class="btn btn-mini btn-info f_r addtolist m_b10" href="javascript:;">{t domain="theme"}添加至菜单{/t}</a></p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="span9 nav_edit">
			<div class="nav_edit_hd">
				<label for="nav_name">{t domain="theme"}菜单名称：{/t}</label><input type="hidden" name="nav_type" value="{$nav_type}" /><input id="navlist_name" type="text" name="navlist_name" value="{$nav_name}" /><input type="hidden" id="navlist_del" name="navlist_del" value="0" /><a class="btn btn-info f_r navlist_submit" href="javascript:;">{t domain="theme"}保存菜单{/t}</a>
			</div>
			<div class="nav_edit_bd">
				<div class="control-group formSep">
					<h3>{t domain="theme"}菜单结构{/t}</h3>
					<span class="help-block">{t domain="theme"}拖放各个项目到您喜欢的顺序，点击右侧的箭头可进行更详细的设置。{/t}</span>
					<div class="controls moveaccordion">
						<div class="span5">
							<!-- {foreach from=$navdb item=nav key=id} -->
							<div class="w-box" id="{$nav.type}{$id}" value="{$id}">
								<div class="w-box-header">
									{$nav.name}
									<span class="fontello-icon-down-open portlet-toggle"></span>
								</div>
								<div class="w-box-content hide">
									<input type="hidden" name="id" value="{$nav.id}" />
									<input type="hidden" name="vieworder" value="{$nav.vieworder}" />
									<p>{t domain="theme"}URL：{/t}<input class="span12" type="text" name="url" value="{$nav.url}" /></p>
									<p>{t domain="theme"}导航标签{/t}<input class="span12" type="text" name="name" value="{$nav.name}" /></p>
									<p>
										<label>
											<input type="checkbox" name="ifshow" {if $nav.ifshow}checked{/if} />{t domain="theme"}是否显示{/t}
										</label>
										<label>
											<input type="checkbox" name="opennew" {if $nav.opennew}checked{/if} />{t domain="theme"}是否新窗口{/t}
										</label>
									</p>
									<p><a class="btn btn-mini btn-danger del_nav">{t domain="theme"}移除{/t}</a></p>
								</div>
							</div>
							<!-- {/foreach} -->
						</div>
					</div>
				</div>
				<div class="control-group">
					<h3>{t domain="theme"}菜单设置{/t}</h3>
					<label class="help-block">{t domain="theme"}主题位置{/t}</label>
					<div class="nav_set">
						<label>
							<input name="nav1" type="checkbox" value="option1">{t domain="theme"}首页/列表页菜单{/t}
							<span class="help-inline">{t domain="theme"}（当前设置：底部）{/t}</span>
						</label>
						<label>
							<input name="nav1" type="checkbox" value="option1">{t domain="theme"}页脚菜单{/t}
							<span class="help-inline">{t domain="theme"}（当前设置：底部）{/t}</span>
						</label>
						<label>
							<input name="nav1" type="checkbox" value="option1">{t domain="theme"}播放页菜单{/t}
							<span class="help-inline">{t domain="theme"}（当前设置：底部）{/t}</span>
						</label>
						<label>
							<input name="nav1" type="checkbox" value="option1">{t domain="theme"}新闻页菜单{/t}
							<span class="help-inline">{t domain="theme"}（当前设置：底部）{/t}</span>
						</label>
					</div>
				</div>
			</div>
			<div class="nav_edit_ft">
				<a class="del_navlist data-pjax" href='{url path="theme/navigator/del_navlist" args="showstate=2&del_type={$nav_type}"}'>{t domain="theme"}删除菜单{/t}</a>
				<a class="btn btn-info f_r navlist_submit" href="javascript:;">{t domain="theme"}保存菜单{/t}</a>
			</div>
		</div>
	</div>
</div>
<!-- {/block} -->
