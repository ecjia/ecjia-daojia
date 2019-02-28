<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<div class="modal fade" id="consignee_info">
    <div class="modal-dialog">
        <div class="modal-content">
        	<div class="modal-header">
        		<button class="close" data-dismiss="modal">×</button>
        		<h3 class="modal-title">{t domain="orders"}收货人信息{/t}</h3>
        	</div>
        	<div class="modal-body">
                <div class="row-fluid">
					<div class="span12">
            			<table class="table table-bordered">
            				<tr><td colspan="2"><strong>{t domain="orders"}收货人信息{/t}</strong></td></tr>
            				<tr><td class="w200">{t domain="orders"}收货人：{/t}<span id="consignee"></span></td></tr>
        				    <tr><td>{t domain="orders"}电子邮件：{/t}<span id="email"></span></td></tr>
				    	    <tr><td>{t domain="orders"}地址：{/t}<span id="address"></span></td></tr>
        				    <tr><td>{t domain="orders"}邮编：{/t}<span id="zipcode"></span></td></tr>
        			        <tr><td>{t domain="orders"}电话：{/t}<span id="tel"></span></td></tr>
        			        <tr><td>{t domain="orders"}手机：{/t}<span id="mobile"></span></td></tr>
        			        <tr><td>{t domain="orders"}标志性建筑：{/t}<span id="building"></span></td></tr>
                 			<tr><td>{t domain="orders"}最佳送货时间：{/t}<span id="shipping_best_time"></span></td></tr>
            			</table>
    			   	</div>
    	       </div>
	       </div>
    	</div>
	</div>
</div>