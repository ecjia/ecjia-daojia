<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {if not is_pjax()} -->
<!DOCTYPE html>
<html lang="zh" class="pjaxLoadding-busy">
<head>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>{block name="title"}{if $ur_here}{$ur_here}{/if}{if $ecjia_merchant_cptitle} - {$ecjia_merchant_cptitle}{/if}{/block}</title>
	<meta name="description" content="{ecjia::config('')}" />
	<meta name="keywords" content="{ecjia::config('')}" />
	<meta name="author" content="ecjia team" />
	<link rel="shortcut icon" href="favicon.ico">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
      <script src="{$ecjia_main_static_url}js/html5shiv.js"></script>
      <script src="{$ecjia_main_static_url}js/respond.min.js"></script>
    <![endif]-->
    <!-- {ecjia:hook id=merchant_print_styles} -->
    <!-- {ecjia:hook id=merchant_print_scripts} -->
    <!-- #BeginLibraryItem "/library/common_meta.lbi" --><!-- #EndLibraryItem -->
    <!-- {block name="ready_meta"} --><!-- {/block} -->
	<!-- {block name="meta"} --><!-- {/block} -->
    <!-- {ecjia:hook id=merchant_head} -->
</head>
<body>
    <!-- start:wrapper -->
    <div id="wrapper">
        <!-- {block name="common_header"} -->
        <!-- #BeginLibraryItem "/library/common_header.lbi" --><!-- #EndLibraryItem -->
        <!-- {/block} -->

        <!-- start:main -->
        <div class="container">
            <div id="main" class="main_content">
                <!-- start:breadcrumb -->
                <!-- {ecjia:hook id=merchant_print_main_header} -->
                <!-- end:breadcrumb -->
                <!-- {block name="home-content"} --><!-- {/block} -->
                <!-- {ecjia:hook id=merchant_print_main_bottom} -->
            </div>
        </div>
        <!-- end:main -->

        <!-- {block name="common_footer"} -->
        <!-- #BeginLibraryItem "/library/common_footer.lbi" --><!-- #EndLibraryItem -->
        <!-- {/block} -->
    </div>
    <!-- end:wrapper -->
	<!-- start:javascript -->
	<!-- javascript default for all pages-->
    <!-- {ecjia:hook id=merchant_print_footer_scripts} -->
    <!-- start:javascript for this page -->
    <!-- {block name="ready_footer"} --><!-- {/block} -->
    <!-- {block name="footer"} --><!-- {/block} -->
    <!-- end:javascript for this page -->
    <!-- {ecjia:hook id=merchant_footer} -->
    <div class="pjaxLoadding"><i class="peg"></i></div>
</body>
</html>
<!-- {else} -->
	<!-- {block name="meta"} --><!-- {/block} -->
	<!-- {ecjia:hook id=merchant_pjax_head} -->
	<!-- {ecjia:hook id=merchant_print_main_header} -->
	<!-- {block name="home-content"} --><!-- {/block} -->
	<!-- {ecjia:hook id=merchant_print_main_bottom} -->
	<!-- {block name="footer"} --><!-- {/block} -->
	<!-- {ecjia:hook id=merchant_pjax_footer} -->
<!-- {/if} -->
