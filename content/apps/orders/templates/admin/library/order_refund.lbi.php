<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<div class="modal hide fade" id="refund">
	<div class="modal-header">
		<button class="close" data-dismiss="modal">×</button>
		<h3>{lang key='orders::order.order_operatio'}</h3>
	</div>
	<div class="modal-body">
		<div class="row-fluid">
			<div class="span12">
				<form class="form-horizontal" method="post" name="refundForm" action='{url path="orders/admin/process" args="&func=refund"}'>
					<fieldset>
						<div class="control-group formSep control-group-small">
							<label class="control-label">{lang key='orders::order.label_refund_amount'}</label>
							<div class="controls" id="refund_amount">
								{$formated_refund_amount}
							</div>
						</div>
						<div class="control-group formSep control-group-small">
							<label class="control-label">{lang key='orders::order.label_handle_refund'}</label>
							<div class="controls">
								<p>
									<label class="ecjiaf-dn" id="anonymous"><input type="radio" name="refund" value="1" />{lang key='orders::order.return_user_money'}</label>
									<label><input type="radio" name="refund" value="2" checked='checked' />{lang key='orders::order.create_user_account'}</label>
									<label><input name="refund" type="radio" value="3" />{lang key='orders::order.not_handle'}</label>
								</p>
							</div>
						</div>
						<div class="control-group formSep control-group-small">
							<label class="control-label">{lang key='orders::order.label_refund_note'}</label>
							<div class="controls">
								<textarea name="refund_note" cols="60" rows="3" class="span10" id="refund_note">{$refund_note}</textarea>
							</div>
						</div>
						<div class="control-group t_c">
							<button class="btn btn-gebo batchsubmit" type="submit">{lang key='system::system.button_submit'}</button>&nbsp;&nbsp;&nbsp;
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