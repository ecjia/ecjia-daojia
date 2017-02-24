<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
ecjia.merchant.order_query.init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->
<div class="page-header">
	<div class="pull-left">
		<h2><!-- {if $ur_here}{$ur_here}{/if} --></h2>
  	</div>
  	<div class="pull-right">
  		{if $action_link}
		<a href="{$action_link.href}" class="btn btn-primary data-pjax">
			<i class="fa fa-reply"></i> {$action_link.text}
		</a>
		{/if}
  	</div>
  	<div class="clearfix"></div>
</div>

<form id="form-privilege" class="form-horizontal panel" name="theForm" action="{$form_action}" method="post" >
	<fieldset>
		<div class="row-fluid editpage-rightbar panel-heading">
			<div class="left-bar">
				<div class="form-group">
					<label class="control-label col-lg-2">{lang key='orders::order.label_order_sn'}</label>
					<div class="col-lg-6">
						<input class="form-control" type="text" name="order_sn" />
					</div>
				</div>
				<div class="form-group form-inline order-query">
					<label class="control-label col-lg-2">{lang key='orders::order.label_time'}</label>
					<div class="col-lg-10"> 
						<div class="form-group ">
								<input name="start_time" class="date form-control w-form-control" type="text" placeholder="{t}开始时间{/t}"/>
						</div>
						<div class="form-group">至</div>
						<div class="form-group">
							<input name="end_time" class="date form-control w-form-control" type="text" placeholder="{t}结束时间{/t}"/>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-lg-2">{lang key='orders::order.label_order_status'}</label>
					<div class="col-lg-6">
						<select class="form-control" name="order_status" id="select9" >
							<option value="-1">{lang key='system::system.select_please'}</option>
							<!-- {foreach from = $os_list item = list key=key} -->
							<option value="{$key}">{$list}</option>
							<!-- {/foreach} -->
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-lg-2">{lang key='orders::order.label_pay_status'}</label>
					<div class="col-lg-6">
						<select class="form-control" name="pay_status" id="select11" >
							<option value="-1">{lang key='system::system.select_please'}</option>
							<!-- {html_options options=$ps_list selected=-1} -->
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-lg-2">{lang key='orders::order.label_shipping_status'}</label>
					<div class="col-lg-6">
						<select class="form-control" name="shipping_status" id="select10">
							<option value="-1">{lang key='system::system.select_please'}</option>
							<!-- {html_options options=$ss_list selected=-1} -->
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-lg-2">{lang key='orders::order.label_email'}</label>
					<div class="col-lg-6">
						<input class="form-control" type="text" name="email" autocomplete="off"/>
					</div>
				</div>
				
				<!--购货人-->
				<div class="form-group">
					<label class="control-label col-lg-2">{lang key='orders::order.label_user_name'}</label>
					<div class="col-lg-6">
						<input class="form-control" type="text" name="user_name" autocomplete="off" />
					</div>
				</div>
				
				<!-- 收货人 -->
				<div class="form-group">
					<label class="control-label col-lg-2">{lang key='orders::order.label_consignee'}</label>
					<div class="col-lg-6">
						<input class="form-control" type="text" name="consignee" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-lg-2">{lang key='orders::order.label_tel'}</label>
					<div class="col-lg-6">
						<input class="form-control" type="text" name="tel" />
					</div>
				</div>
				
				<div class="form-group">
					<label class="control-label col-lg-2">{lang key='orders::order.label_mobile'}</label>
					<div class="col-lg-6">
						<input class="form-control" type="text" name="mobile" />
					</div>
				</div>
				
				<div class="form-group">
					<label class="control-label col-lg-2"></label>
					<div class="col-lg-6">
						<button class="btn btn-info" type="submit">{lang key='system::system.button_search'}</button>
						<button class="btn btn-info" type="reset">{lang key='system::system.button_reset'}</button>
					</div>
				</div>
			</div>
			<div class="right-bar move-mod order-query-accordion order-step-formgroup">
				<div class="panel panel-info">
					<div class="panel-heading">
	                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="accordion-toggle">
	                    	<span class="glyphicon"></span>
	                        <h4 class="panel-title">
	                            <strong>收货地址信息</strong>
	                        </h4>
	                    </a>
	                </div>
	                <div class="accordion-body in collapse " id="collapseOne">
	                	<div class="form-group first-form-group form-inline">
							<label class="control-label col-lg-4">{lang key='orders::order.label_address'}</label>
							<div class="col-lg-7">
								<input class="form-control" type="text" name="address"/>
							</div>
						</div>
						<div class="form-group form-inline">
							<label class="control-label col-lg-4">{t}国家：{/t}</label>
							<div class="col-lg-7">
								<select class="form-control" name="country" data-toggle="regionSummary" data-url='{url path="shipping/region/init"}' data-type="1" data-target="region-summary-provinces" >
									<option value="0">{lang key='system::system.select_please'}</option>
									<!-- {foreach from=$country_list item=country} -->
									<option value="{$country.region_id}">{$country.region_name}</option>
									<!-- {/foreach} -->
								</select>
							</div>
						</div>
						<div class="form-group form-inline">
							<label class="control-label col-lg-4">{t}省/市：{/t}</label>
							<div class="col-lg-7">
								<select class="region-summary-provinces form-control" name="province" data-toggle="regionSummary" data-type="2" data-target="region-summary-cities" >
									<option value="0">{lang key='system::system.select_please'}</option>
								</select>
							</div>
						</div>
						<div class="form-group form-inline">
							<label class="control-label col-lg-4">{t}市：{/t}</label>
							<div class="col-lg-7">
								<select class="region-summary-cities form-control" name="city" data-toggle="regionSummary" data-type="3" data-target="region-summary-districts" >
									<option value="0">{lang key='system::system.select_please'}</option>
								</select>
							</div>
						</div>
						<div class="form-group form-inline">
							<label class="control-label col-lg-4">{t}区：{/t}</label>
							<div class="col-lg-7">
								<select class="region-summary-districts form-control" name="district">
									<option value="0">{lang key='system::system.select_please'}</option>
								</select>
							</div>
						</div>
						<div class="form-group form-inline">
							<label class="control-label col-lg-4">{lang key='orders::order.label_zipcode'}</label>
							<div class="col-lg-7">
								<input class="form-control" type="text" name="zipcode"  />
							</div>
						</div>
	                </div>
				</div>
				<div class="panel panel-info">
					<div class="panel-heading">
	                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" class="accordion-toggle">
	                    	<span class="glyphicon"></span>
	                        <h4 class="panel-title">
	                            <strong>收货地址信息</strong>
	                        </h4>
	                    </a>
	                </div>
	                <div class="accordion-body in collapse " id="collapseTwo">
	                	<div class="form-group first-form-group form-inline">
							<label class="control-label col-lg-4">{lang key='orders::order.label_shipping'}</label>
							<div class="col-lg-7">
								<select class="form-control" name="shipping_id" id="select4">
									<option value="0">{lang key='system::system.select_please'}</option>
									<!-- {foreach from=$shipping_list item=shipping} -->
									<option value="{$shipping.shipping_id}">{$shipping.shipping_name}</option>
									<!-- {/foreach} -->
								</select>
							</div>
						</div>
						<div class="form-group form-inline">
							<label class="control-label col-lg-4">{lang key='orders::order.label_payment'}</label>
							<div class="col-lg-7">
								<select class="form-control" name="pay_id" id="select5">
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
	</fieldset>
</form>
<!-- {/block} -->