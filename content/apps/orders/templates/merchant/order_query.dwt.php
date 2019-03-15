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

<form id="form-privilege" class="form-horizontal panel" name="theForm" action="{$form_action}" method="post">
	<fieldset>
		<div class="row-fluid editpage-rightbar panel-heading">
			<div class="left-bar">
				<div class="form-group">
					<label class="control-label col-lg-2">{t domain="orders"}订单号：{/t}</label>
					<div class="col-lg-6">
						<input class="form-control" type="text" name="order_sn" />
					</div>
				</div>
				<div class="form-group form-inline order-query">
					<label class="control-label col-lg-2">{t domain="orders"}下单时间：{/t}</label>
					<div class="col-lg-10"> 
						<div class="form-group ">
								<input name="start_time" class="date form-control w-form-control" type="text" placeholder='{t domain="orders"}开始时间{/t}'/>
						</div>
						<div class="form-group">{t domain="orders"}至{/t}</div>
						<div class="form-group">
							<input name="end_time" class="date form-control w-form-control" type="text" placeholder='{t domain="orders"}结束时间{/t}'/>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-lg-2">{t domain="orders"}订单状态：{/t}</label>
					<div class="col-lg-6">
						<select class="form-control" name="order_status" id="select9" >
							<option value="-1">{t domain="orders"}请选择...{/t}</option>
							<!-- {foreach from = $os_list item = list key=key} -->
							<option value="{$key}">{$list}</option>
							<!-- {/foreach} -->
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-lg-2">{t domain="orders"}付款状态：{/t}</label>
					<div class="col-lg-6">
						<select class="form-control" name="pay_status" id="select11" >
							<option value="-1">{t domain="orders"}请选择...{/t}</option>
							<!-- {html_options options=$ps_list selected=-1} -->
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-lg-2">{t domain="orders"}发货状态：{/t}</label>
					<div class="col-lg-6">
						<select class="form-control" name="shipping_status" id="select10">
							<option value="-1">{t domain="orders"}请选择...{/t}</option>
							<!-- {html_options options=$ss_list selected=-1} -->
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-lg-2">{t domain="orders"}电子邮件：{/t}</label>
					<div class="col-lg-6">
						<input class="form-control" type="text" name="email" autocomplete="off"/>
					</div>
				</div>
				
				<!--购货人-->
				<div class="form-group">
					<label class="control-label col-lg-2">{t domain="orders"}购货人：{/t}</label>
					<div class="col-lg-6">
						<input class="form-control" type="text" name="user_name" autocomplete="off" />
					</div>
				</div>
				
				<!-- 收货人 -->
				<div class="form-group">
					<label class="control-label col-lg-2">{t domain="orders"}收货人：{/t}</label>
					<div class="col-lg-6">
						<input class="form-control" type="text" name="consignee" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-lg-2">{t domain="orders"}电话：{/t}</label>
					<div class="col-lg-6">
						<input class="form-control" type="text" name="tel" />
					</div>
				</div>
				
				<div class="form-group">
					<label class="control-label col-lg-2">{t domain="orders"}手机：{/t}</label>
					<div class="col-lg-6">
						<input class="form-control" type="text" name="mobile" />
					</div>
				</div>
				
				<div class="form-group">
					<label class="control-label col-lg-2"></label>
					<div class="col-lg-6">
						<button class="btn btn-info" type="submit">{t domain="orders"}搜索{/t}</button>
						<button class="btn btn-info" type="reset">{t domain="orders"}重置{/t}</button>
					</div>
				</div>
			</div>
			<div class="right-bar move-mod order-query-accordion order-step-formgroup">
				<div class="panel panel-info">
					<div class="panel-heading">
	                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="accordion-toggle">
	                    	<span class="glyphicon"></span>
	                        <h4 class="panel-title">
	                            <strong>{t domain="orders"}收货地址信息{/t}</strong>
	                        </h4>
	                    </a>
	                </div>
	                <div class="accordion-body in collapse " id="collapseOne">
	                	<div class="form-group first-form-group form-inline">
							<label class="control-label col-lg-4">{t domain="orders"}地址：{/t}</label>
							<div class="col-lg-7">
								<input class="form-control" type="text" name="address"/>
							</div>
						</div>
						<div class="form-group form-inline">
							<label class="control-label col-lg-4">{t domain="orders"}省：{/t}</label>
							<div class="col-lg-7">
								<select class="region-summary-provinces form-control" name="province" data-toggle="regionSummary" data-url='{url path="merchant/region/init"}' data-type="1" data-target="region-summary-cities" >
									<option value="0">{t domain="orders"}请选择...{/t}</option>
									<!-- {foreach from=$provinces item=province} -->
									<option value="{$province.region_id}">{$province.region_name}</option>
									<!-- {/foreach} -->
								</select>
							</div>
						</div>
						<div class="form-group form-inline">
							<label class="control-label col-lg-4">{t domain="orders"}市：{/t}</label>
							<div class="col-lg-7">
								<select class="region-summary-cities form-control" name="city" data-toggle="regionSummary" data-type="2" data-target="region-summary-districts" >
									<option value="0">{t domain="orders"}请选择...{/t}</option>
								</select>
							</div>
						</div>
						<div class="form-group form-inline">
							<label class="control-label col-lg-4">{t domain="orders"}区/县：{/t}</label>
							<div class="col-lg-7">
								<select class="region-summary-districts form-control" name="district" data-toggle="regionSummary" data-type="3" data-target="region-summary-streets" >
									<option value="0">{t domain="orders"}请选择...{/t}</option>
								</select>
							</div>
						</div>
						<div class="form-group form-inline">
							<label class="control-label col-lg-4">{t domain="orders"}街道/镇：{/t}</label>
							<div class="col-lg-7">
								<select class="region-summary-streets form-control" name="street">
									<option value="0">{t domain="orders"}请选择...{/t}</option>
								</select>
							</div>
						</div>
						<div class="form-group form-inline">
							<label class="control-label col-lg-4">{t domain="orders"}邮编：{/t}</label>
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
	                            <strong>{t domain="orders"}收货地址信息{/t}</strong>
	                        </h4>
	                    </a>
	                </div>
	                <div class="accordion-body in collapse " id="collapseTwo">
	                	<div class="form-group first-form-group form-inline">
							<label class="control-label col-lg-4">{t domain="orders"}配送方式：{/t}</label>
							<div class="col-lg-7">
								<select class="form-control" name="shipping_id" id="select4">
									<option value="0">{t domain="orders"}请选择...{/t}</option>
									<!-- {foreach from=$shipping_list item=shipping} -->
									<option value="{$shipping.shipping_id}">{$shipping.shipping_name}</option>
									<!-- {/foreach} -->
								</select>
							</div>
						</div>
						<div class="form-group form-inline">
							<label class="control-label col-lg-4">{t domain="orders"}支付方式：{/t}</label>
							<div class="col-lg-7">
								<select class="form-control" name="pay_id" id="select5">
									<option value="0">{t domain="orders"}请选择...{/t}</option>
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