<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<div class="modal fade" id="refund">
    <div class="modal-dialog">
        <div class="modal-content">
        	<div class="modal-header">
        		<button class="close" data-dismiss="modal">×</button>
        		<h3 class="modal-title">{t}订单操作：退款{/t}</h3>
        	</div>
        	<div class="modal-body">
				<form class="form-horizontal" method="post" name="refundForm" action='{url path="orders/merchant/process" args="&func=refund"}'>
					<fieldset>
						<div class="form-group">
							<label class="control-label col-lg-3">退款金额：</label>
							<div class="controls col-lg-6 l_h30" id="refund_amount">
								{$formated_refund_amount}
							</div>
						</div>
						<div class="form-group">
				    		<label class="control-label col-lg-3">退款方式：</label>
							<div class="col-lg-9 p_r0 chk_radio">
				        		<input type="radio" name="refund" id="refund_1" value="1" />
								<label for="refund_1">退回用户余额</label>
								<br/>
				    			 
				    			<input type="radio" name="refund" id="refund_2" value="2" checked/>
								<label for="refund_2">生成退款申请</label>
								<br/>
							  
							    <input type="radio" id="refund_3" name="refund" value="3" />
								<label for="refund_3">不处理，误操作时选择此项</label>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-lg-3">退款说明：</label>
							<div class="controls col-lg-8">
								<textarea name="refund_note" cols="60" rows="3" class="form-control" id="refund_note">{$refund_note}</textarea>
							</div>
							<span class="input-must">*</span>
						</div>
						
						<div class="control-group t_c">
							<button class="btn btn-info" type="submit">{t}确定{/t}</button>&nbsp;&nbsp;&nbsp;
							<input type="hidden" name="order_id" value="{$order_id}" />
							<input type="hidden" name="func" value="refund" />
							<input type="hidden" name="refund_amount" value="" />
						</div>
					</fieldset>
				</form>
            </div>
		</div>
	</div>
</div>