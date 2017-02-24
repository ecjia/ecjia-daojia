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
					<label class="control-label">{lang key='orders::order.label_order_sn'}</label>
					<div class="controls">
						<input class="w350"  type="text" name="order_sn" />
					</div>
				</div>
				<div class="control-group control-group-small">
					<label class="control-label">{lang key='orders::order.label_time'}</label>
					<div class="controls">
						<div class="controls-split">
							<div class="ecjiaf-fl wright_wleft">
								<input name="start_time" class="date wspan12" type="text" placeholder="{lang key='orders::order.start_time'}"/>
							</div>
							<div class="ecjiaf-fl p_t5 wmidden">{lang key='orders::order.to'}</div>
							<div class="ecjiaf-fl wright_wleft">
								<input name="end_time" class="date wspan12" type="text" placeholder="{lang key='orders::order.end_time'}"/>
							</div>
						</div>
					</div>
				</div>
				<div class="control-group control-group-small">
					<label class="control-label">{lang key='orders::order.label_order_status'}</label>
					<div class="controls" >
						<select class="w350" name="order_status" id="select9" >
							<option value="-1">{lang key='system::system.select_please'}</option>
							<!-- {foreach from = $os_list item = list key=key} -->
							<option value="{$key}">{$list}</option>
							<!-- {/foreach} -->
						</select>
					</div>
				</div>
				<div class="control-group control-group-small">
					<label class="control-label">{lang key='orders::order.label_pay_status'}</label>
					<div class="controls">
						<select class="w350" name="pay_status" id="select11" >
							<option value="-1">{lang key='system::system.select_please'}</option>
							<!-- {html_options options=$ps_list selected=-1} -->
						</select>
					</div>
				</div>
				<div class="control-group  control-group-small">
					<label class="control-label">{lang key='orders::order.label_shipping_status'}</label>
					<div class="controls">
						<select class="w350" name="shipping_status" id="select10">
							<option value="-1">{lang key='system::system.select_please'}</option>
							<!-- {html_options options=$ss_list selected=-1} -->
						</select>
					</div>
				</div>
				<div class="control-group control-group-small">
					<label class="control-label">{lang key='orders::order.label_email'}</label>
					<div class="controls">
						<input class="w350" type="text" name="email"/>
					</div>
				</div>
				<!--购货人-->
				<div class="control-group control-group-small">
					<label class="control-label">{lang key='orders::order.label_user_name'}</label>
					<div class="controls">
						<input class="w350" type="text" name="user_name" />
					</div>
				</div>
				<!-- 收货人 -->
				<div class="control-group control-group-small">
					<label class="control-label">{lang key='orders::order.label_consignee'}</label>
					<div class="controls">
						<input class="w350" type="text" name="consignee" />
					</div>
				</div>
				<div class="control-group control-group-small">
					<label class="control-label">{lang key='orders::order.label_tel'}</label>
					<div class="controls">
						<input class="w350" type="text" name="tel" />
					</div>
				</div>
				<div class="control-group control-group-small">
					<label class="control-label">{lang key='orders::order.label_mobile'}</label>
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
						<button class="btn btn-gebo" type="submit">{lang key='system::system.button_search'}</button>
						<button class="btn" type="reset">{lang key='system::system.button_reset'}</button>
					</div>
				</div>
			</div>
			<div class="right-bar move-mod">
				<div class="foldable-list move-mod-group">
					<div class="accordion-group">
						<div class="accordion-heading">
							<a class="accordion-toggle acc-in move-mod-head" data-target="#collapseOne" data-toggle="collapse"><strong>{lang key='orders::order.shipping_address_information'}</strong></a>
						</div>
						<div class="accordion-body in in_visable collapse" id="collapseOne">
							<div class="accordion-inner">
								<div class="control-group control-group-small">
									<label class="control-label">{lang key='orders::order.label_address'}</label>
									<div>
										<input type="text" name="address"/>
									</div>
								</div>
								<div class="control-group control-group-small">
									<label class="control-label">{lang key='orders::order.country_lable'}</label>
									<div>
										<select name="country" data-toggle="regionSummary" data-url='{url path="shipping/region/init"}' data-type="1" data-target="region-summary-provinces" >
											<option value="0">{lang key='system::system.select_please'}</option>
											<!-- {foreach from=$country_list item=country} -->
											<option value="{$country.region_id}">{$country.region_name}</option>
											<!-- {/foreach} -->
										</select>
									</div>
								</div>
								<div class="control-group control-group-small">
									<label class="control-label">{lang key='orders::order.province_and_city_lable'}</label>
									<div>
										<select class="region-summary-provinces" name="province" data-toggle="regionSummary" data-type="2" data-target="region-summary-cities" >
											<option value="0">{lang key='system::system.select_please'}</option>
										</select>
									</div>
								</div>
								<div class="control-group control-group-small">
									<label class="control-label">{lang key='orders::order.city_lable'}</label>
									<div>
										<select class="region-summary-cities" name="city" data-toggle="regionSummary" data-type="3" data-target="region-summary-districts" >
											<option value="0">{lang key='system::system.select_please'}</option>
										</select>
									</div>
								</div>
								<div class="control-group control-group-small">
									<label class="control-label">{lang key='orders::order.area_lable'}</label>
									<div>
										<select class="region-summary-districts" name="district">
											<option value="0">{lang key='system::system.select_please'}</option>
										</select>
									</div>
								</div>
								<div class="control-group control-group-small">
									<label class="control-label">{lang key='orders::order.label_zipcode'}</label>
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
							<a class="accordion-toggle acc-in move-mod-head" data-target="#collapseTwo" data-toggle="collapse"><strong>{lang key='orders::order.shipping_payment'}</strong></a>
						</div>
						<div class="accordion-body in in_visable collapse" id="collapseTwo">
							<div class="accordion-inner">
								<div class="control-group control-group-small">
									<label class="control-label">{lang key='orders::order.label_shipping'}</label>
									<div>
										<select name="shipping_id" id="select4">
											<option value="0">{lang key='system::system.select_please'}</option>
											<!-- {foreach from=$shipping_list item=shipping} -->
											<option value="{$shipping.shipping_id}">{$shipping.shipping_name}</option>
											<!-- {/foreach} -->
										</select>
									</div>
								</div>
								<div class="control-group control-group-small">
									<label class="control-label">{lang key='orders::order.label_payment'}</label>
									<div>
										<select name="pay_id" id="select5">
											<option value="0">{lang key='system::system.select_please'}</option>
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