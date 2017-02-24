<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<header>
	<div class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container-fluid">
				<a class="brand" href="{url path='@index/init'}"><i class="icon-home icon-white"></i> {$ecjia_admin_cpname}</a>
				<ul class="nav user_menu pull-right">
					<li class="hidden-phone hidden-tablet">
						<div class="nb_boxes clearfix">
							<!-- {ecjia:hook id=admin_dashboard_header_links} -->
						</div>
					</li>
					<li class="divider-vertical hidden-phone hidden-tablet"></li>
					<li class="dropdown">
						<a class="dropdown-toggle nav_condensed" href="#" data-toggle="dropdown"><i class="flag-cn"></i> <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="javascript:void(0)"><i class="flag-cn"></i> {t}简体中文{/t}</a></li>
							<!-- <li><a href="javascript:void(0)"><i class="flag-us"></i> {t}English{/t}</a></li> -->
						</ul>
					</li>
					<li class="divider-vertical hidden-phone hidden-tablet"></li>
					<li class="dropdown">
						<a class="dropdown-toggle" href="#" data-toggle="dropdown"><img src="{RC_Uri::admin_url('statics/images/user_avatar.png')}" alt="" class="user_avatar" />{$smarty.session.admin_name|escape}<b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="{url path='@privilege/modif'}">{t}个人设置{/t}</a></li>
							<!-- {if $admin_message_is_show} -->
							<li><a href="{url path='@admin_message/init'}">{t}管理员留言{/t}</a></li>
							<!-- {/if} -->
							<li class="divider"></li>
							<li><a href="{url path='@privilege/logout'}">{t}退出{/t}</a></li>
						</ul>
					</li>
				</ul>
				<!-- {ecjia:hook id=admin_print_header_nav} -->
			</div>
		</div>
	</div>
	<!-- {ecjia:hook id=admin_dashboard_header_codes} -->
</header>