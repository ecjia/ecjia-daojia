<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {if not is_pjax()} -->
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
<body {if ecjia_platform_screen::get_current_screen()->get_sidebar_display()}class="vertical-layout vertical-content-menu 2-columns fixed-navbar menu-expanded pace-done" data-open="click" data-menu="vertical-content-menu" data-col="2-columns"{else}class="vertical-layout vertical-overlay-menu 2-columns fixed-navbar  menu-hide pace-done" data-open="click" data-menu="vertical-overlay-menu" data-col="2-columns"{/if}>
    
        <!-- {block name="common_header"} -->
        <!-- #BeginLibraryItem "/library/common_header.lbi" --><!-- #EndLibraryItem -->
        <!-- {/block} -->

        <!-- start:main -->
        <div class="app-content content">

        	<div class="content-wrapper">
                <!-- #BeginLibraryItem "/library/common_sidebar.lbi" --><!-- #EndLibraryItem -->

	            <div class="content-body" id="content-body">
	            
	            	<div class="content-header row">
		                <!-- {ecjia:hook id=platform_print_main_header} -->
	                </div>
	                
	                <!-- {block name="home-content"} -->
	                <!-- {/block} -->
	                <!-- {ecjia:hook id=platform_print_main_bottom} -->
	            </div>
            </div>
        </div>
        <!-- end:main -->
        
    <!-- {block name="common_footer"} -->
    <!-- #BeginLibraryItem "/library/common_footer.lbi" --><!-- #EndLibraryItem -->
    <!-- {/block} -->
    
	<!-- start:javascript -->
	<!-- javascript default for all pages-->
    <!-- {ecjia:hook id=platform_print_footer_scripts} -->
    <!-- start:javascript for this page -->
    <!-- {block name="ready_footer"} --><!-- {/block} -->
    <!-- {block name="footer"} --><!-- {/block} -->
    <!-- end:javascript for this page -->
    <!-- {ecjia:hook id=platform_footer} -->
    <div class="pjaxLoadding"><i class="peg"></i></div>
</body>
</html>
<!-- {else} -->
	<!-- {block name="meta"} --><!-- {/block} -->
	<!-- {ecjia:hook id=platform_pjax_head} -->
	
	<div class="content-header row">
		<!-- {ecjia:hook id=platform_print_main_header} -->
	</div>
	                
	<!-- {block name="home-content"} --><!-- {/block} -->
	<!-- {ecjia:hook id=platform_print_main_bottom} -->
	<!-- {block name="footer"} --><!-- {/block} -->
	<!-- {ecjia:hook id=platform_pjax_footer} -->
<!-- {/if} -->
