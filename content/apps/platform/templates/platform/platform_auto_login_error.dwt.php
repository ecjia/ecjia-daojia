<!DOCTYPE html>
<html lang="zh" class="pjaxLoadding-busy">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
	<title>{block name="title"}{if $ur_here}{$ur_here}{/if}{if $ecjia_platform_cptitle} - {$ecjia_platform_cptitle}{/if}{/block}</title>
	<meta name="description" content="{ecjia::config('')}" />
	<meta name="keywords" content="{ecjia::config('')}" />
	<meta name="author" content="ecjia team" />
	<link rel="shortcut icon" href="favicon.ico">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
      <script src="{$ecjia_main_static_url}js/html5shiv.js"></script>
      <script src="{$ecjia_main_static_url}js/respond.min.js"></script>
    <![endif]-->
    <!-- {ecjia:hook id=platform_print_styles} -->
    <!-- {ecjia:hook id=platform_print_scripts} -->
    <!-- #BeginLibraryItem "/library/common_meta.lbi" --><!-- #EndLibraryItem -->
    <!-- {block name="ready_meta"} --><!-- {/block} -->
	<!-- {block name="meta"} --><!-- {/block} -->
    <!-- {ecjia:hook id=platform_head} -->
</head>
<body class="vertical-layout 2-columns fixed-navbar menu-expanded pace-done">
    <nav class="header-navbar navbar-expand-md navbar navbar-with-menu fixed-top navbar-light navbar-hide-on-scroll navbar-border navbar-shadow navbar-brand-center">
		<div class="navbar-wrapper">
			<div class="navbar-header">
	      		<ul class="nav navbar-nav flex-row">
	        		<li class="nav-item mobile-menu d-md-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu font-large-1"></i></a></li>
	        		<li class="nav-item">
	        			<a class="navbar-brand" href="{url path='platform/dashboard/init'}">
	        			<img class="brand-logo" alt="robust admin logo" src="{$ecjia_main_static_url}platform/images/logo/logo-dark-sm.png">
	            		<h3 class="brand-text">公众平台</h3>
	            		</a>
	        		</li>
	        		<li class="nav-item d-md-none"><a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i class="fa fa-ellipsis-v"></i></a></li>
	      		</ul>
			</div>
	    	<div class="navbar-container content">
	      		<div class="collapse navbar-collapse" id="navbar-mobile">
	        		<ul class="nav navbar-nav mr-auto float-left">
	          			<li class="nav-item d-none d-md-block"><a class="nav-link nav-menu-main menu-toggle hidden-xs hidden" href="#"><i class="ft-menu"></i></a></li>
	        		</ul>
	      		</div>
	    	</div>
		</div>
    </nav>

    <div class="app-content content">
		<div class="content-wrapper">
	        <div class="content-header row">
	        </div>
	        <div class="content-body">
		        <div class="col-sm-5 offset-sm-1 col-md-6 offset-md-3 col-lg-4 offset-lg-4 box-shadow-2">
					<div class="card border-grey border-lighten-3 px-2 my-0 row">
						<div class="card-header no-border pb-1">
							<div class="card-body">
								<h2 class="error-code text-center mb-2">错误报告</h2>
								<h3 class="text-uppercase text-center">{$error_message}</h3>
							</div>
						</div>
					</div>
				</div>
	        </div>
		</div>
    </div>
    
    <!-- {ecjia:hook id=platform_print_footer_scripts} -->
    
	<footer class="footer footer-static footer-transparent">
		<p class="clearfix blue-grey lighten-2 text-sm-center mb-0 px-2">
			<span class="d-block d-md-inline-block">
			Copyright &copy; 2018 {ecjia::config('shop_name')} {if ecjia::config('icp_number', 2)}<a href="http://www.miibeian.gov.cn" target="_blank">{ecjia::config('icp_number')}</a>{/if}
			</span>
		</p>
	</footer>
	
	{if ecjia::config('stats_code')}
	{stripslashes(ecjia::config('stats_code'))}
	{/if}

</body>
</html>