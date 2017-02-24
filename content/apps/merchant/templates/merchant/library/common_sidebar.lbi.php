<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<a class="sidebar_switch on_switch ttip_r" href="javascript:void(0)" title="{t}隐藏侧边栏{/t}">{t}侧边栏开关{/t}</a>
<div class="sidebar">
	<div class="antiScroll">
		<div class="antiscroll-inner">
			<div class="antiscroll-content">
				<div class="sidebar_inner">
					<form class="input-append" onsubmit="return false">
						<input class="search_query input-medium" autocomplete="off" name="query" size="16" type="text" placeholder="{t}搜索导航{/t}" /><a class="btn search_query_btn"><i class="icon-search"></i></a>
					</form>
					<div class="accordion" id="side_accordion">
						<div class="accordion-group">
							<div class="accordion-heading">
								<a class="accordion-toggle search_query_close" href="#collapse_search_query" data-parent="#side_accordion" data-toggle="collapse">
									<i class="icon-search"></i> {t}快速搜索{/t}
								</a>
							</div>
							<div class="accordion-body collapse" id="collapse_search_query">
								<div class="accordion-inner">
									<ul class="nav nav-list">
										<li class="search_query_none"><a href="javascript:;">{t}请先输入搜索信息{/t}</a></li>
										<!--{ecjia:hook id=admin_sidebar_collapse_search}-->
									</ul>
								</div>
							</div>
						</div>
						<!--{ecjia:hook id=admin_sidebar_collapse}-->
					</div>
					<div class="push"></div>
				</div>

				<div class="sidebar_info">
					<!--{ecjia:hook id=admin_sidebar_info}-->
				</div>
			</div>
		</div>
	</div>
</div>
