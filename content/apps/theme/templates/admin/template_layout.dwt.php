<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.admin_template_setup.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<!-- {if !$template_files} -->
<div class="alert alert-info">
	<a class="close" data-dismiss="alert">×</a>
	{t domain="theme"}当前选择的主题没有可用布局管理模板。{/t}
</div>
<!-- {/if} -->
<h3 class="heading">
	<!-- {if $ur_here}{$ur_here}{/if} -->
	<!-- {if $template_files} -->
	<span class="subtitle">（正在编辑的模板文件是 {$template_file}.dwt.php）</span>
	<!-- {/if} -->
	<!-- {if $action_link} -->
	<a class="btn" id="sticky_a" href="{$action_link.href}" style="float:right;margin-top:-3px;"><i class="fontello-icon-plus"></i>{$action_link.text}</a>
	<!-- {/if} -->
</h3>

<div class="row-fluid chat_box layout-content">
	<div class="pan9">
		<div class="widget-liquid-left span4">
			<div id="widgets-left">
			    <!-- {if $available_widgets} -->
				<div class="id-available-widgets widgets-holder-wrap ui-droppable">
					<div class="sidebar-name">
						<div class="fontello-icon-up-open sidebar-name-arrow"><br></div>
						<h3>
							{t domain="theme"}可用库项目{/t}
							<span class="id-removing-widget" style="display: none;">{t domain="theme"}停用{/t} <span></span></span>
						</h3>
					</div>
					<div class="sidebar-description">
						<p class="description">{t domain="theme"}要激活某一小工具，将它拖动到侧栏或点击它。要禁用某一小工具并删除其设置，将它拖回来。{/t}</p>
					</div>
					<div class="id-widget-list">
					    <!-- {foreach from=$available_widgets item=widget key=key} -->
					    <!-- {assign var=lib value=$widget->process()} -->
						<!-- #BeginLibraryItem "/library/template_layout_widget_form.lbi" --><!-- #EndLibraryItem -->
						<!-- {/foreach} -->
					</div>
					<br class="clear">
				</div>
				<!-- {/if} -->
                <!-- {if $temp_dyna_libs} -->
				<div class="id-available-widgets widgets-holder-wrap ui-droppable">
					<div class="sidebar-name">
						<div class="fontello-icon-up-open sidebar-name-arrow"><br></div>
						<h3>
							{t domain="theme"}动态库项目{/t}
							<span class="id-removing-widget" style="display: none;">{t domain="theme"}停用{/t} <span></span></span>
						</h3>
					</div>
					<div class="sidebar-description">
						<p class="description">{t domain="theme"}要激活某一小工具，将它拖动到侧栏或点击它。要禁用某一小工具并删除其设置，将它拖回来。{/t}</p>
					</div>
					<div class="id-widget-list">
					    <!-- {foreach from=$temp_dyna_libs item=lib key=key} -->
						<!-- #BeginLibraryItem "/library/template_layout_widget_form.lbi" --><!-- #EndLibraryItem -->
						<!-- {/foreach} -->
					</div>
					<br class="clear">
				</div>
				<!-- {/if} -->

				<div class="widgets-holder-wrap inactive-sidebar">
					<div class="widget-holder inactive">
						<div class="widgets-sortables ui-sortable"  data-url="{$sort_action}" data-file="{$template_file}" data-name="inactive" id="ecjia_inactive_widgets">
							<div class="sidebar-name">
								<div class="fontello-icon-up-open sidebar-name-arrow"><br></div>
								<h3>{t domain="theme"}未使用的小工具{/t}<span class="spinner" style="display: none;"></span></h3>
							</div>
							<div class="sidebar-description">
								<p class="description">{t domain="theme"}将小工具拖至这里，将它们从边栏移除，但同时保留设置。{/t}</p>
							</div>
    					    <!-- {foreach from=$inactive_sidebar item=widget key=key} -->
    					    <!-- {assign var=lib value=$widget->process()} -->
    						<!-- #BeginLibraryItem "/library/template_layout_widget_form.lbi" --><!-- #EndLibraryItem -->
    						<!-- {/foreach} -->
						</div>
						<div class="clear"></div>
					</div>
				</div>

			</div>
		</div>

		<div class="widget-liquid-right span5">
			<div id="widgets-right">

				<div class="sidebars-column-0">
					<!-- {foreach from=$editable_regions item=region name=regions} -->
					<!-- {assign var=region_name value=$region.name} -->
					<div class="widgets-holder-wrap">
						<div class="widgets-sortables widget-list" data-name="{$region_name}" data-file="{$template_file}" id="sidebar-{$smarty.foreach.regions.index}">
							<div class="sidebar-name">
								<div class="fontello-icon-up-open sidebar-name-arrow"><br></div>
								<h3>{$region.name} <span class="spinner" style="display: none;"></span></h3>
							</div>
							<div class="sidebar-description"><p class="description">{$region.desc}</p></div>
							<!-- {foreach from=$available_region_libs.$region_name item=widget key=key} -->
							<!-- {assign var=lib value=$widget->process()} -->
							<!-- #BeginLibraryItem "/library/template_layout_widget_form.lbi" --><!-- #EndLibraryItem -->
							<!-- {/foreach} -->
						</div>
					</div>
					<!-- {foreachelse} -->
					<div class="widgets-holder-wrap">
						<div class="widget-list" id="sidebar-no">
							<div class="sidebar-name">
								<div class="fontello-icon-up-open sidebar-name-arrow"><br></div>
								<h3>{t domain="theme"}暂无可用区域{/t}<span class="spinner" style="display: none;"></span></h3>
							</div>
							<div class="sidebar-description"><p class="description">{t domain="theme"}暂无可用区域{/t}</p></div>
						</div>
					</div>
					<!-- {/foreach} -->
				</div>

			</div>
		</div>
	</div>
	
	<div class="span3 chat_sidebar{if $full} hide{/if}">
        <div class="chat_heading clearfix">
            {t domain="theme"}模板文件{/t}
        </div>
        <div class="ms-selectable">
            <div class="template_list" id="ms-custom-navigation">
                <input class="span12" id="ms-search" type="text" placeholder="{t domain="theme"}筛选搜索到的商品信息{/t}" autocomplete="off">
                <ul class="unstyled">
                    <!-- {foreach from=$template_files item=val key=key} -->
                    <!-- {assign var=url_args value="template_file=$key&full=0"} -->
                    <li class="ms-elem-selectable"><a class="data-pjax{if $key eq $template_file} choose{/if}" href="{url path='theme/admin_layout/init' args=$url_args}">{$val.File} <br /> {$val.Name}</a></li>
                    <!-- {/foreach} -->
                </ul>
            </div>
        </div>
    </div>
    
    <div class="widgets-chooser">
    	<ul class="widgets-chooser-sidebars">
    	</ul>
    	<div class="widgets-chooser-actions">
    		<button class="btn btn-secondary">{t domain="theme"}取消{/t}</button>
    		<button class="btn btn-info">{t domain="theme"}添加小工具{/t}</button>
    	</div>
    </div>
</div>
<!-- {/block} -->