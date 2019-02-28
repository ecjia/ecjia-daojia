<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.order_query.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
			<a class="btn plus_or_reply data-pjax" href="{$action_link.href}"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>	

<form id="form-privilege" class="form-horizontal" name="theForm" action="{$form_action}" method="post" >
	<fieldset>
		<div class="row-fluid edit-page editpage-rightbar">
			<div class="left-bar">
				<div class="control-group control-group-small">
					<label class="control-label">订单号：</label>
					<div class="controls">
						<input class="w350"  type="text" name="order_sn" />
					</div>
				</div>
				<div class="control-group control-group-small">
					<label class="control-label">下单时间：</label>
					<div class="controls">
						<div class="controls-split">
							<div class="ecjiaf-fl wright_wleft">
								<input name="start_time" class="date wspan12" type="text" placeholder="开始时间"/>
							</div>
							<div class="ecjiaf-fl p_t5 wmidden">至</div>
							<div class="ecjiaf-fl wright_wleft">
								<input name="end_time" class="date wspan12" type="text" placeholder="结束时间"/>
							</div>
						</div>
					</div>
				</div>
				<div class="control-group control-group-small">
					<label class="control-label">订单状态：</label>
					<div class="controls" >
						<select class="w350" name="order_status" id="select9" >
							<option value="-1">请选择...</option>
							<!-- {foreach from = $os_list item = list key=key} -->
							<option value="{$key}">{$list}</option>
							<!-- {/foreach} -->
						</select>
					</div>
				</div>
				<div class="control-group control-group-small">
					<label class="control-label">付款状态：</label>
					<div class="controls">
						<select class="w350" name="pay_status" id="select11" >
							<option value="-1">请选择...</option>
							<!-- {html_options options=$ps_list selected=-1} -->
						</select>
					</div>
				</div>
				<div class="control-group  control-group-small">
					<label class="control-label">发货状态：</label>
					<div class="controls">
						<select class="w350" name="shipping_status" id="select10">
							<option value="-1">请选择...</option>
							<!-- {html_options options=$ss_list selected=-1} -->
						</select>
					</div>
				</div>
				<div class="control-group control-group-small">
					<label class="control-label">电子邮件：</label>
					<div class="controls">
						<input class="w350" type="text" name="email"/>
					</div>
				</div>
				<!--购货人-->
				<div class="control-group control-group-small">
					<label class="control-label">购货人：</label>
					<div class="controls">
						<input class="w350" type="text" name="user_name" />
					</div>
				</div>
				<!-- 收货人 -->
				<div class="control-group control-group-small">
					<label class="control-label">收货人：</label>
					<div class="controls">
						<input class="w350" type="text" name="consignee" />
					</div>
				</div>
				<div class="control-group control-group-small">
					<label class="control-label">电话：</label>
					<div class="controls">
						<input class="w350" type="text" name="tel" />
					</div>
				</div>
				<div class="control-group control-group-small">
					<label class="control-label">手机：</label>
					<div class="controls">
						<input class="w350" type="text" name="mobile" />
					</div>
				</div>
				<div class="control-group control-group-small">
					<label class="control-label">商家名称：</label>
					<div class="controls">
						<input class="w350" type="text" name="merchants_name" />
					</div>
				</div>
				<div class="control-group control-group-small">
					<div class="controls">
						<button class="btn btn-gebo" type="submit">搜索</button>
						<button class="btn" type="reset">重置</button>
					</div>
				</div>
			</div>
			<div class="right-bar move-mod">
				<div class="foldable-list move-mod-group">
					<div class="accordion-group">
						<div class="accordion-heading">
							<a class="accordion-toggle acc-in move-mod-head" data-target="#collapseOne" data-toggle="collapse"><strong>收货地址信息</strong></a>
						</div>
						<div class="accordion-body in in_visable collapse" id="collapseOne">
							<div class="accordion-inner">
								<div class="control-group control-group-small">
									<label class="control-label">地址：</label>
									<div>
										<input type="text" name="address"/>
									</div>
								</div>
							
								<div class="control-group control-group-small">
									<label class="control-label">省：</label>
									<div>
										<select class="region-summary-provinces" name="province" data-toggle="regionSummary" data-url='{url path="setting/region/init"}' data-type="1" data-target="region-summary-cities" >
											<option value="0">请选择...</option>
											<!-- {foreach from=$provinces key=key item=province} -->
											<option value="{$province.region_id}">{$province.region_name}</option>
											<!-- {/foreach} -->
										</select>
									</div>
								</div>
								<div class="control-group control-group-small">
									<label class="control-label">市：</label>
									<div>
										<select class="region-summary-cities" name="city" data-toggle="regionSummary" data-type="2" data-target="region-summary-districts" >
											<option value="0">请选择...</option>
										</select>
									</div>
								</div>
								<div class="control-group control-group-small">
									<label class="control-label">区/县：</label>
									<div>
										<select class="region-summary-districts" name="district" data-toggle="regionSummary" data-type="3" data-target="region-summary-streets" >
											<option value="0">请选择...</option>
										</select>
									</div>
								</div>
								<div class="control-group control-group-small">
									<label class="control-label">街道/镇：</label>
									<div>
										<select class="region-summary-streets" name="street">
											<option value="0">请选择...</option>
										</select>
									</div>
								</div>
								<div class="control-group control-group-small">
									<label class="control-label">邮编：</label>
									<div>
										<input type="text" name="zipcode"  />
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="foldable-list move-mod-group">
					<div class="accordion-group">
						<div class="accordion-heading">
							<a class="accordion-toggle acc-in move-mod-head" data-target="#collapseTwo" data-toggle="collapse"><strong>配送/支付方式</strong></a>
						</div>
						<div class="accordion-body in in_visable collapse" id="collapseTwo">
							<div class="accordion-inner">
								<div class="control-group control-group-small">
									<label class="control-label">配送方式：</label>
									<div>
										<select name="shipping_id" id="select4">
											<option value="0">请选择...</option>
											<!-- {foreach from=$shipping_list item=shipping} -->
											<option value="{$shipping.shipping_id}">{$shipping.shipping_name}</option>
											<!-- {/foreach} -->
										</select>
									</div>
								</div>
								<div class="control-group control-group-small">
									<label class="control-label">支付方式：</label>
									<div>
										<select name="pay_id" id="select5">
											<option value="0">请选择...</option>
											<!-- {foreach from=$pay_list item=pay} -->
											<option value="{$pay.pay_id}">{$pay.pay_name}</option>
											<!-- {/foreach} -->
										</select>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</fieldset>
</form>
<!-- {/block} -->