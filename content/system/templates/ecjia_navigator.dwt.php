<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->	

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a class="data-pjax btn plus_or_reply" id="sticky_a" href="{$action_link.href}"><i class="fontello-icon-plus"></i>{$action_link.text}</a>
		<!-- {/if} -->
		<!-- {if $action_link2} -->
		<span class="data-pjax btn plus_or_reply"><a href="{$action_link2.href}">{$action_link2.text}</a>&nbsp;&nbsp;</span>
		<!-- {/if} -->
	</h3>
</div>
<div id="navigator">
	<div class="nav_list choose_list">
		<label for="type">{t}选择要编辑的菜单：{/t}</label>
		<select name="type">
			<!-- {foreach from=$nav_list item=lists} -->
			<option value="{$lists.type}" {if $lists.name == $nav_name}selected{/if} >{$lists.name}</option>
			<!-- {/foreach} -->
		</select>
		<a class="btn data-pjax" href="javascript:;">{t}选择{/t}</a>
		<i class="m_r5">{t}或{/t}</i>
		<a class="data-pjax" href="{url path='@navigator/add_nav_list'}">{t}创建新菜单{/t}</a>
	</div>
	<div class="row-fluid nav_main">
		<div class="span3 nav_add">
			<div class="accordion" id="accordion2">
				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle" data-parent="#accordion2" data-toggle="collapse" href="#collapseTwo2">{t}页面{/t}</a>
					</div>
					<div class="accordion-body collapse in" id="collapseTwo2">
						<div class="accordion-inner">
							<!-- {foreach from=$pagenav item=nav} -->
							<label class="checkbox"><input class="nav_url" type="checkbox" value="{$nav.1}" /><span class="nav_name">{$nav.0}</span></label>
							<!-- {/foreach} -->
							<p>
								<a class="checkall" href="javascript:;">{t}全选{/t}</a>
								<a class="btn f_r addtolist m_b10" href="javascript:;">{t}添加至菜单{/t}</a>
							</p>
						</div>
					</div>
				</div>
				<div class="accordion-group">
					<div class="accordion-heading">
						<a href="#collapseOne2" data-parent="#accordion2" data-toggle="collapse" class="accordion-toggle">{t}链接{/t}</a>
					</div>
					<div class="accordion-body collapse" id="collapseOne2">
						<div class="accordion-inner">
							<p>{t}URL：{/t}<input class="span10 nav_url" type="text" name="nav_url" /></p>
							<p>{t}文字：{/t}<input class="span10 nav_name" type="text" /></p>
							<p><a href="javascript:;" class="btn f_r addtolist m_b10">{t}添加至菜单{/t}</a></p>
						</div>
					</div>
				</div>
				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle" href="#collapseThree2" data-parent="#accordion2" data-toggle="collapse">{t}分类目录{/t}</a>
					</div>
					<div class="accordion-body collapse" id="collapseThree2">
						<div class="accordion-inner">
							<!-- {foreach from=$categorynav item=nav} -->
							<label class="checkbox"><input class="nav_url" type="checkbox" value="{$nav.1}" /><span class="nav_name">{$nav.2}</span></label>
							<!-- {/foreach} -->
							<p>
								<a class="checkall" href="javascript:;">{t}全选{/t}</a>
								<a href="javascript:;" class="btn f_r addtolist m_b10">{t}添加至菜单{/t}</a>
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="span9 nav_edit">
			<div class="nav_edit_hd">
				<label for="nav_name">{t}菜单名称：{/t}</label><input type="hidden" name="nav_type" value="{$nav_type}" /><input type="text" id="navlist_name" name="navlist_name" value="{$nav_name}" /><a href="javascript:;" class="btn f_r navlist_submit">{t}保存菜单{/t}</a>
			</div>
			<div class="nav_edit_bd">
				<div class="control-group formSep">
					<h3>{t}菜单结构{/t}</h3>
					<span class="help-block">{t}拖放各个项目到您喜欢的顺序，点击右侧的箭头可进行更详细的设置。{/t}</span>
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
									<p>{t}URL：{/t}<input type="text" name="url" class="span12" value="{$nav.url}" /></p>
									<p>{t}导航标签{/t}<input type="text" name="name" class="span12" value="{$nav.name}" /></p>
									<p>
										<label class="checkbox">
											<input type="checkbox" name="ifshow" {if $nav.ifshow}checked{/if} />{t}是否显示{/t}
										</label>
										<label class="checkbox">
											<input type="checkbox" name="opennew" {if $nav.opennew}checked{/if} />{t}是否新窗口{/t}
										</label>
									</p>
									<p><a class="btn del_nav">{t}移除{/t}</a></p>
								</div>
							</div>
							<!-- {/foreach} -->
						</div>
					</div>
				</div>
				<div class="control-group">
					<h3>{t}菜单设置{/t}</h3>
					<label class="help-block">{t}主题位置{/t}</label>
					<div class="nav_set">
						<label class="checkbox">
							<input type="checkbox" value="option1" name="nav1">
							{t}首页/列表页菜单{/t}<span class="help-inline">{t}（当前设置：底部）{/t}</span>
						</label>
						<label class="checkbox">
							<input type="checkbox" value="option1" name="nav1">
							{t}页脚菜单{/t}<span class="help-inline">{t}（当前设置：底部）{/t}</span>
						</label>
						<label class="checkbox">
							<input type="checkbox" value="option1" name="nav1">
							{t}播放页菜单{/t}<span class="help-inline">{t}（当前设置：底部）{/t}</span>
						</label>
						<label class="checkbox">
							<input type="checkbox" value="option1" name="nav1">
							{t}新闻页菜单{/t}<span class="help-inline">{t}（当前设置：底部）{/t}</span>
						</label>
					</div>
				</div>
			</div>
			<div class="nav_edit_ft">
				<a class="del_navlist data-pjax" href='{url path="@navigator/del_navlist" args="showstate=2&del_type={$nav_type}"}'>{t}删除菜单{/t}</a><a href="javascript:;" class="btn f_r navlist_submit">{t}保存菜单{/t}</a>
			</div>
		</div>
	</div>
</div>

<!-- {/block} -->