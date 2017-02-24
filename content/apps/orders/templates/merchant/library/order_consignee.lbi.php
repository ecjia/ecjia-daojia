<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<div class="modal fade" id="consignee_info">
    <div class="modal-dialog">
        <div class="modal-content">
        	<div class="modal-header">
        		<button class="close" data-dismiss="modal">×</button>
        		<h3 class="modal-title">{lang key='orders::order.consignee_info'}</h3>
        	</div>
        	<div class="modal-body">
                <div class="row-fluid">
					<div class="span12">
            			<table class="table table-bordered">
            				<tr><td colspan="2"><strong>{lang key='orders::order.consignee_info'}</strong></td></tr>
            				<tr><td class="w200">{lang key='orders::order.label_consignee'}<span id="consignee"></span></td></tr>
        				    <tr><td>{lang key='orders::order.label_email'}<span id="email"></span></td></tr>
				    	    <tr><td>{lang key='orders::order.label_address'}<span id="address"></span></td></tr>
        				    <tr><td>{lang key='orders::order.label_zipcode'}<span id="zipcode"></span></td></tr>
        			        <tr><td>{lang key='orders::order.label_tel'}<span id="tel"></span></td></tr>
        			        <tr><td>{lang key='orders::order.label_mobile'}<span id="mobile"></span></td></tr>
        			        <tr><td>{lang key='orders::order.label_sign_building'}<span id="building"></span></td></tr>
                 			<tr><td>{lang key='orders::order.label_best_time'}<span id="shipping_best_time"></span></td></tr>
            			</table>
    			   	</div>
    	       </div>
	       </div>
    	</div>
	</div>
</div>