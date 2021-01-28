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
                    <!-- {ecjia:hook id=admin_header_extend_links} -->

					<li class="divider-vertical hidden-phone hidden-tablet"></li>
					<li class="dropdown">
						<a class="dropdown-toggle" href="#" data-toggle="dropdown"><img src="{RC_Uri::admin_url('statics/images/user_avatar.png')}" alt="" class="user_avatar" />{$smarty.session.admin_name|escape}<b class="caret"></b></a>
						<ul class="dropdown-menu">
                            <!-- {ecjia:hook id=admin_header_profile_links} -->
						</ul>
					</li>
				</ul>
				<!-- {ecjia:hook id=admin_print_header_nav} -->
			</div>
		</div>
	</div>
	<!-- {ecjia:hook id=admin_dashboard_header_codes} -->
</header>