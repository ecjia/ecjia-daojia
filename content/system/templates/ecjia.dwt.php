<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {if not is_pjax()} -->
<!DOCTYPE html>
<html lang="zh" class="pjaxLoadding-busy">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>{block name="title"}{if $ur_here}{$ur_here} - {/if}{$ecjia_admin_cptitle}{/block}</title>
	<link rel="shortcut icon" href="favicon.ico" />
	<!-- {ecjia:hook id=admin_print_styles} -->
	<!-- #BeginLibraryItem "/library/common_meta.lbi" --><!-- #EndLibraryItem -->
	<!-- {ecjia:hook id=admin_print_scripts} -->
	<!-- {block name="ready_meta"} --><!-- {/block} -->
	<!-- {block name="meta"} --><!-- {/block} -->
	<!-- {ecjia:hook id=admin_head} -->
</head>
<body>
	<div class="clearfix" id="maincontainer">
		<!-- #BeginLibraryItem "/library/common_header.lbi" --><!-- #EndLibraryItem -->
		<div id="contentwrapper">
			<div class="main_content">
				<!-- {ecjia:hook id=admin_print_main_header} -->
				<!-- {block name="main_content"} --><!-- {/block} -->
				<!-- {ecjia:hook id=admin_print_main_bottom} -->
			</div>
		</div>
		<!-- #BeginLibraryItem "/library/common_sidebar.lbi" --><!-- #EndLibraryItem -->
	</div>
	<!-- {ecjia:hook id=admin_print_footer_scripts} -->
	<!-- #BeginLibraryItem "/library/common_footer.lbi" --><!-- #EndLibraryItem -->
	<!-- {block name="ready_footer"} --><!-- {/block} -->
	<!-- {block name="footer"} --><!-- {/block} -->
	<!-- {ecjia:hook id=admin_footer} -->
    <div class="pjaxLoadding"><i class="peg"></i></div>
</body>
</html>
<!-- {else} -->
	<title>{block name="title"}{$ecjia_admin_cptitle}{if $ur_here} - {$ur_here}{/if}{/block}</title>
	<!-- {block name="meta"} --><!-- {/block} -->
	<!-- {ecjia:hook id=admin_pjax_head} -->
	<!-- {ecjia:hook id=admin_print_main_header} -->
	<!-- {block name="main_content"} --><!-- {/block} -->
	<!-- {ecjia:hook id=admin_print_main_bottom} -->
	<!-- {block name="footer"} --><!-- {/block} -->
	<!-- {ecjia:hook id=admin_pjax_footer} -->
<!-- {/if} -->
