<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<div class="modal hide fade" id="refund">
	<div class="modal-header">
		<button class="close" data-dismiss="modal">×</button>
		<h3>{t domain="orders"}订单操作：退款{/t}</h3>
	</div>
	<div class="modal-body">
		<div class="row-fluid">
			<div class="span12">
				<form class="form-horizontal" method="post" name="refundForm" action='{url path="orders/admin/process" args="&func=refund"}'>
					<fieldset>
						<div class="control-group formSep control-group-small">
							<label class="control-label">{t domain="orders"}退款金额：{/t}</label>
							<div class="controls" id="refund_amount">
								{$formated_refund_amount}
							</div>
						</div>
						<div class="control-group formSep control-group-small">
							<label class="control-label">{t domain="orders"}退款方式：{/t}</label>
							<div class="controls">
								<p>
									<label class="ecjiaf-dn" id="anonymous"><input type="radio" name="refund" value="1" />{t domain="orders"}退回用户余额{/t}</label>
									<label><input type="radio" name="refund" value="2" checked='checked' />{t domain="orders"}生成退款申请{/t}</label>
									<label><input name="refund" type="radio" value="3" />{t domain="orders"}不处理，误操作时选择此项{/t}</label>
								</p>
							</div>
						</div>
						<div class="control-group formSep control-group-small">
							<label class="control-label">{t domain="orders"}退款说明：{/t}</label>
							<div class="controls">
								<textarea name="refund_note" cols="60" rows="3" class="span10" id="refund_note">{$refund_note}</textarea>
							</div>
						</div>
						<div class="control-group t_c">
							<button class="btn btn-gebo batchsubmit" type="submit">{t domain="orders"}确定{/t}</button>&nbsp;&nbsp;&nbsp;
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