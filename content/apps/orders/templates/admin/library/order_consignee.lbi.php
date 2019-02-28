<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<div class="modal hide fade" id="consignee_info">
	<div class="modal-header">
		<button class="close" data-dismiss="modal">×</button>
		<h3>{t domain="orders"}收货人信息{/t}</h3>
	</div>
	<div class="modal-body">
		<div class="row-fluid form-horizontal">
			<div class="control-group">
				<label class="control-label">{t domain="orders"}收货人：{/t}</label>
				<div class="controls" id="consignee">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">{t domain="orders"}电子邮件：{/t}</label>
				<div class="controls" id="email">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">{t domain="orders"}地址：{/t}</label>
				<div class="controls" id="address">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">{t domain="orders"}邮编：{/t}</label>
				<div class="controls" id="zipcode">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">{t domain="orders"}电话：{/t}</label>
				<div class="controls" id="tel">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">{t domain="orders"}手机：{/t}</label>
				<div class="controls" id="mobile">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">{t domain="orders"}标志性建筑：{/t}</label>
				<div class="controls" id="building">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">{t domain="orders"}最佳送货时间：{/t}</label>
				<div class="controls" id="shipping_best_time">
				</div>
			</div>
		</div>
	</div>
</div>