<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<div class="modal hide fade" id="consignee_info">
	<div class="modal-header">
		<button class="close" data-dismiss="modal">×</button>
		<h3>{lang key='orders::order.consignee_info'}</h3>
	</div>
	<div class="modal-body">
		<div class="row-fluid form-horizontal">
			<div class="control-group">
				<label class="control-label">{lang key='orders::order.label_consignee'}</label>
				<div class="controls" id="consignee">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">{lang key='orders::order.label_email'}</label>
				<div class="controls" id="email">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">{lang key='orders::order.label_address'}</label>
				<div class="controls" id="address">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">{lang key='orders::order.label_zipcode'}</label>
				<div class="controls" id="zipcode">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">{lang key='orders::order.label_tel'}</label>
				<div class="controls" id="tel">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">{lang key='orders::order.label_mobile'}</label>
				<div class="controls" id="mobile">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">{lang key='orders::order.label_sign_building'}</label>
				<div class="controls" id="building">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">{lang key='orders::order.label_best_time'}</label>
				<div class="controls" id="shipping_best_time">
				</div>
			</div>
		</div>
	</div>
</div>