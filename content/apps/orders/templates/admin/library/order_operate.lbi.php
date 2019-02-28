<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<div class="modal hide fade" id="operate">
	<div class="modal-header">
		<button class="close" data-dismiss="modal">×</button>
		<h3>{t domain="orders"}订单操作：{/t}</h3>
	</div>
	<div class="modal-body">
		<div class="row-fluid">
			<div class="span12">
				<form class="form-horizontal" method="post" name="batchForm" action='{url path="orders/admin/operate_post"}'>
					<fieldset>
						<div class="control-group formSep control-group-small">
							<label class="control-label">{t domain="orders"}操作备注：{/t}</label>
							<div class="controls">
								<textarea name="action_note" class="span10 lbi_action_note" cols="60" rows="3"></textarea>
							</div>
						</div>
						<div class="control-group formSep control-group-small ecjiaf-dn show_cancel_note">
							<label class="control-label">{t domain="orders"}取消原因：{/t}</label>
							<div class="controls">
								<textarea name="cancel_note" class="span10" cols="60" rows="3" id="cancel_note">{$cancel_note}</textarea><br/>
                                {t domain="orders"}（会记录在商家给客户的留言中）{/t}
							</div>
						</div>
						<div class="control-group formSep control-group-small ecjiaf-dn show_invoice_no">
							<label class="control-label">{t domain="orders"}运单编号：{/t}</label>
							<div class="controls">
								<input name="invoice_no" type="text" class="span4" />
							</div>
						</div>
						<div class="control-group formSep control-group-small ecjiaf-dn show_refund">
							<label class="control-label">{t domain="orders"}退款方式：{/t}</label>
							<div class="controls chk_radio">
					    		<label class="anonymous ecjiaf-dn"><input class='refund_operate' type="radio" name="refund" value="1" />{t domain="orders"}退回用户余额{/t}</label>
						      	<label><input class='refund_operate' type="radio" name="refund" value="2" />{t domain="orders"}生成退款申请{/t}</label>
						      	<label><input class='refund_operate' type="radio" name="refund" value="3" />{t domain="orders"}不处理，误操作时选择此项{/t}</label>
							</div>
						</div>
						<div class="control-group formSep control-group-small ecjiaf-dn show_refund">
							<label class="control-label">{t domain="orders"}退款说明：{/t}</label>
							<div class="controls">
								<textarea name="refund_note" class="span10" cols="60" rows="3" id="refund_note">{$refund_note}</textarea>
								<span class="input-must">*</span>
							</div>
						</div>
						<div class="control-group t_c">
							<button class="btn btn-gebo batchsubmit" type="submit">{t domain="orders"}确定{/t}</button>
							<input type="hidden" name="order_id" value="{$order_id}" />
							<input class="batchtype" type='hidden' name='operation' />
							<input type="hidden" name="batch">
						</div>
					</fieldset>
				</form>
			</div>
		</div>
	</div>
</div>