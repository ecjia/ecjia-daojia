<?php defined('IN_ECJIA') or exit('No permission resources.');?>

<script type="text/javascript">
	ecjia.merchant.mh_express_order_list.init();
</script>

<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">修改配送员</h4>
        </div>
        
        <input type="hidden" name="home_url" value="{RC_Uri::home_url()}"/>
        
        <div class="modal-body">
        	<div class="express_reassign">
				<div class="map-reassign" id="allmap"></div>
				<div class="original-div">
					<!-- #BeginLibraryItem "/library/reassign_express_user_list.lbi" --><!-- #EndLibraryItem -->
				</div>
				
				<div class="new-div">
				</div>
				
				<input id="start"  type="hidden" value="{$content.start}"/>
				<input id="end"  type="hidden" value="{$content.end}"/>
				<input id="policy" type="hidden" value="LEAST_TIME"/>
				<input id="routes" type="hidden" />
				<input type="hidden" class="nearest_exuser_name" value="{$content.express_user}"/>
				<input type="hidden" class="nearest_exuser_mobile" value="{$content.express_mobile}"/>
				<input type="hidden" class="nearest_exuser_lng" value="{$content.eu_longitude}"/>
				<input type="hidden" class="nearest_exuser_lat" value="{$content.eu_latitude}"/>
				<input type="hidden" class="selected-express-id" value="{$express_id}"/>
			</div>
		</div>
    </div>
</div>



	