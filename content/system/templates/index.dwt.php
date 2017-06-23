<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->
<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.dashboard.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div class="row-fluid move-mods">
	<div class="span12 move-mod nomove">
		<!-- {ecjia:hook id=admin_dashboard_top} -->
	</div>
</div>

<div class="row-fluid move-mods" id="sortable_panels">
	<div class="span6 move-mod nomove">
		<!-- {ecjia:hook id=admin_dashboard_left} -->
	</div>
	<div class="span6 move-mod nomove">
		<!-- {ecjia:hook id=admin_dashboard_right} -->
	</div>
</div>

<div class="row-fluid move-mods">
	<div class="span3 move-mod nomove">
	   <!-- {ecjia:hook id=admin_dashboard_left3} -->
	</div>
	<div class="span3 move-mod nomove">
	   <!-- {ecjia:hook id=admin_dashboard_center3} -->
	</div>
	<div class="span6 move-mod nomove">
	   <!-- {ecjia:hook id=admin_dashboard_right6} -->
	</div>
</div>

<div class="row-fluid move-mods">
	<div class="span8 move-mod nomove">
	   <!-- {ecjia:hook id=admin_dashboard_left8} -->
	</div>
	<div class="span4 move-mod nomove">
	   <!-- {ecjia:hook id=admin_dashboard_right4} -->
	</div>
</div>

<div class="row-fluid move-mods">
	<div class="span4 move-mod nomove">
	   <!-- {ecjia:hook id=admin_dashboard_left4} -->
	</div>
	<div class="span4 move-mod nomove">
	   <!-- {ecjia:hook id=admin_dashboard_center4} -->
	</div>
	<div class="span4 move-mod nomove">
	   <!-- {ecjia:hook id=admin_dashboard_right4} -->
	</div>
</div>

<div class="row-fluid move-mods">
	<div class="span12 move-mod nomove">
	<!-- {ecjia:hook id=admin_dashboard_bottom} -->
	</div>
</div>
	
<!-- {/block} -->