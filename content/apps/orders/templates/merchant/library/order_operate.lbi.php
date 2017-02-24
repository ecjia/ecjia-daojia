<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<div class="modal fade" id="operate">
	<div class="modal-dialog">
    	<div class="modal-content">
			<div class="modal-header">
				<button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
				<h4 class="modal-title">{lang key='orders::order.order_operate'}</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" method="post" name="batchForm" action='{url path="orders/admin/operate_post"}'>
					<div class="form-group">
						<label class="control-label col-lg-3">{lang key='orders::order.label_action_note'}</label>
						<div class="col-lg-6 controls">
							<textarea name="action_note" class="span10 lbi_action_note form-control" cols="40" rows="3"></textarea>
						</div>
						<span class="input-must">*</span>
					</div>
					<div class="form-group ecjiaf-dn show_cancel_note">
						<label class="control-label col-lg-3">{lang key='orders::order.label_cancel_note'}</label>
						<div class="col-lg-6">
							<textarea name="cancel_note" class="span10 form-control" cols="40" rows="3" id="cancel_note">{$cancel_note}</textarea><br/>
							{lang key='orders::order.notice_cancel_note'}
						</div>
					</div>
					<div class="form-group ecjiaf-dn show_invoice_no">
						<label class="control-label col-lg-3">{lang key='orders::order.label_invoice_no'}</label>
						<div class="col-lg-6">
							<input class="form-control" name="invoice_no" type="text" />
						</div>
					</div>
					<div class="form-group ecjiaf-dn show_refund">
						<label class="control-label col-lg-3">{lang key='orders::order.label_handle_refund'}</label>
						<div class="col-lg-6 l_h30">
							<div class="anonymous ecjiaf-dn">
								<input type="radio" name="refund" value="1" id="refund_1"/>
								<label for="refund_1">{lang key='orders::order.return_user_money'}</label>
							</div>
							<div>
								<input type="radio" name="refund" value="2"  id="refund_2"/>
								<label for="refund_2">{lang key='orders::order.create_user_account'}</label>
							</div>
							<div>
								<input type="radio" name="refund" value="3"  id="refund_3"/>
								<label for="refund_3">{lang key='orders::order.not_handle'}</label>
							</div>
						</div>
					</div>
					<div class="form-group ecjiaf-dn show_refund">
						<label class="control-label col-lg-3">{lang key='orders::order.label_refund_note'}</label>
						<div class="controls col-lg-6">
							<textarea class="form-control" name="refund_note" cols="40" rows="3" id="refund_note">{$refund_note}</textarea>
						</div>
						<span class="input-must">*</span>
					</div>
					<div class="form-group t_c">
						<button class="btn btn-info batchsubmit" type="submit">{t}确定{/t}</button>
						<input type="hidden" name="order_id" value="{$order_id}" />
						<input class="batchtype" type='hidden' name='operation' />
						<input type="hidden" name="batch">
					</div>
				</form>
           </div>
		</div>
	</div>
</div>