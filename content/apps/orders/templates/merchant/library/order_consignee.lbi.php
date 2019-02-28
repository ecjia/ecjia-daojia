<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<div class="modal fade" id="consignee_info">
    <div class="modal-dialog">
        <div class="modal-content">
        	<div class="modal-header">
        		<button class="close" data-dismiss="modal">×</button>
        		<h3 class="modal-title">收货人信息</h3>
        	</div>
        	<div class="modal-body">
                <div class="row-fluid">
					<div class="span12">
            			<table class="table table-bordered">
            				<tr><td colspan="2"><strong>收货人信息</strong></td></tr>
            				<tr><td class="w200">收货人：<span id="consignee"></span></td></tr>
        				    <tr><td>电子邮件：<span id="email"></span></td></tr>
				    	    <tr><td>地址：<span id="address"></span></td></tr>
        				    <tr><td>邮编：<span id="zipcode"></span></td></tr>
        			        <tr><td>电话：<span id="tel"></span></td></tr>
        			        <tr><td>手机：<span id="mobile"></span></td></tr>
        			        <tr><td>标志性建筑：<span id="building"></span></td></tr>
                 			<tr><td>最佳送货时间：<span id="shipping_best_time"></span></td></tr>
            			</table>
    			   	</div>
    	       </div>
	       </div>
    	</div>
	</div>
</div>