<?php defined('IN_ECJIA') or exit('No permission resources.');?>

<div class="modal-dialog">
	<div class="modal-content">
        <div class="modal-header">
            <button data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">{t domain="express"}配送员当前位置{/t}</h4>
        </div>
        <div class="modal-body">
			<div id="allmap"></div>
			<input id="start"  type="hidden" value="{$content.start}"/>
			<input id="end" type="hidden" value="{$content.end}"/>
			<input id="policy" type="hidden" value="LEAST_TIME"/>
			<input id="routes"  type="hidden" />
			<input type="hidden" class="nearest_exuser_name" value="{$content.express_user}"/>
			<input type="hidden" class="nearest_exuser_mobile" value="{$content.express_mobile}"/>
			<input type="hidden" class="nearest_exuser_lng" value="{$content.eu_longitude}"/>
			<input type="hidden" class="nearest_exuser_lat" value="{$content.eu_latitude}"/>
		</div>
    </div>
</div>                   
