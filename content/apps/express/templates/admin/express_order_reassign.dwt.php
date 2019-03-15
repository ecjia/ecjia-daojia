<?php defined('IN_ECJIA') or exit('No permission resources.');?>
	<script type="text/javascript">
		ecjia.admin.admin_express_order_list.init();
	</script>
	<div class="modal-header">
		<button class="close" data-dismiss="modal">×</button>
		<h3>{if $title}{$title}{else}{t domain="express"}修改配送员{/t}{/if}</h3>
	</div> 
	<div class="assign-detail">
		<div class="modal-body">
		<div class="express_reassign">
			<div class="map-reassign"id="allmap"></div>
			<div class="original-div">
				<!-- #BeginLibraryItem "/library/reassign_express_user_list.lbi" --><!-- #EndLibraryItem -->
			</div>
			<div class="new-div">
				
			</div>
			<input id="start" class="span9" type="hidden" value="{$content.start}"/>
			<input id="end" class="span9" type="hidden" value="{$content.end}"/>
			<input id="policy" class="span9" type="hidden" value="LEAST_TIME"/>
			<input id="routes" class="span9" type="hidden" ></input>
			<input type="hidden" class="nearest_exuser_name" value="{$content.express_user}"/>
			<input type="hidden" class="nearest_exuser_mobile" value="{$content.express_mobile}"/>
			<input type="hidden" class="nearest_exuser_lng" value="{$content.eu_longitude}"/>
			<input type="hidden" class="nearest_exuser_lat" value="{$content.eu_latitude}"/>
			<input type="hidden" class="selected-express-id" value="{$express_id}"/>
		</div>
	</div>
	</div>
	