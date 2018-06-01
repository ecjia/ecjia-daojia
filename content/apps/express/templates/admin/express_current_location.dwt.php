<?php defined('IN_ECJIA') or exit('No permission resources.');?>
	<div class="modal-header">
		<button class="close" data-dismiss="modal">×</button>
		<h3>配送员当前位置</h3>
	</div> 
	<div class="location-detail">
		<div class="modal-body">
		<div class="express_loacation">
			<div class="map-current-location"id="allmap"></div>
			<input id="start" class="span9" type="hidden" value="{$content.start}"/>
			<input id="end" class="span9" type="hidden" value="{$content.end}"/>
			<input id="policy" class="span9" type="hidden" value="LEAST_TIME"/>
			<input id="routes" class="span9" type="hidden" ></input>
			<input type="hidden" class="nearest_exuser_name" value="{$content.express_user}"/>
			<input type="hidden" class="nearest_exuser_mobile" value="{$content.express_mobile}"/>
			<input type="hidden" class="nearest_exuser_lng" value="{$content.eu_longitude}"/>
			<input type="hidden" class="nearest_exuser_lat" value="{$content.eu_latitude}"/>
		</div>
	</div>
	</div>
	