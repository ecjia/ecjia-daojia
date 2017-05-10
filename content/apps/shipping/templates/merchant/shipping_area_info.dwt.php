<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.merchant.area_info.init();
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

<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<div class="panel-body">
			<div class="alert alert-info">	
            	<strong>首重单位为1公斤/千克，续重计算单位为 每公斤/千克。</strong>
        		<button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-times" data-original-title="" title=""></i></button>
        	</div>
				<div class="form">
					<input type="hidden" id="region_warn" value="{lang key='shipping::shipping_area.js_languages.region_exists'}" />
					<input type="hidden" id="region_get_url" date-toggle="{$region_get_url}" />
					<form id="form-privilege" class="form-horizontal" name="theForm" action="{$form_action}" method="post" enctype="multipart/form-data">
						<!-- {if $area_id} -->
						<input type="hidden" name="id" value="{$area_id}" />
						<!-- {/if} -->
						<input type="hidden" name="shipping_id" value="{$shipping_area.shipping_id}" />
						<div class="form-group">
							<label class="control-label col-lg-2">{lang key='shipping::shipping_area.label_shipping_area_name'}</label>
							<div class="controls col-lg-3">
								<input class="form-control" name="shipping_area_name" type="text" value="{$shipping_area.shipping_area_name}" /> 
							</div>
							<span class="input-must">{lang key='system::system.require_field'}</span>
						</div>
						
						<!-- 费用计算方式 -->
						<!-- {if $shipping_area.shipping_code eq 'ship_ems' || $shipping_area.shipping_code eq 'ship_yto' || $shipping_area.shipping_code eq 'ship_zto' || $shipping_area.shipping_code eq 'ship_sto_express' || $shipping_area.shipping_code eq 'ship_post_mail' || $shipping_area.shipping_code eq 'ship_sf_express' || $shipping_area.shipping_code eq 'ship_post_express' } -->
						<div class="form-group">
							<label class="control-label col-lg-2">{lang key='shipping::shipping_area.label_fee_compute_mode'}</label>
							<div class="controls col-lg-3">
								<input type="radio" id="fee_compute_mode_by_weight" class="uni_style" {if $fee_compute_mode neq 'by_number' }checked="checked" {/if}
								onclick="javascript:ecjia.merchant.shippingObj.area_compute_mode('{$shipping_area.shipping_code}','weight')" name="fee_compute_mode" value="by_weight" />
								<label for="fee_compute_mode_by_weight">{lang key='shipping::shipping_area.fee_by_weight'}</label>
								<input type="radio" id="fee_compute_mode_by_number" class="uni_style" {if $fee_compute_mode eq 'by_number'}checked="checked" {/if}  
								onclick="javascript:ecjia.merchant.shippingObj.area_compute_mode('{$shipping_area.shipping_code}','number')"
								name="fee_compute_mode" value="by_number" />
								<label for="fee_compute_mode_by_number">{lang key='shipping::shipping_area.fee_by_number'}</label>
							</div>
						</div>
						<!-- {/if} -->
						
						<!-- 500克以内的费用 -->
						<!--{if $shipping_area.shipping_code != 'ship_cac'}-->
						<!-- {foreach from=$fields item=field} -->
						<!--{if $fee_compute_mode == 'by_number'}-->
						<!--{if $field.name == 'item_fee' || $field.name == 'free_money' || $field.name == 'pay_fee'}-->
						<div class="form-group"  id="{$field.name}">
							<label class="control-label col-lg-2">{$field.label}</label>
							<div class="controls col-lg-3">
								<input class="form-control" name="{$field.name}" type="text" value="{$field.value}"/> 
							</div>
							<span class="input-must">{lang key='system::system.require_field'}</span>
						</div>
						<!--{else}-->
						<div class="form-group"  id="{$field.name}" style="display: none;">
							<label class="control-label col-lg-2">{$field.label}</label>
							<div class="controls col-lg-3">
								<input class="form-control" name="{$field.name}" type="text" value="{$field.value}" />
							</div>
							<span class="input-must">{lang key='system::system.require_field'}</span>
						</div>
						<!--{/if}-->
						<!--{else}-->
						<!--{if $field.name != 'item_fee'}-->
						<div class="form-group"  id="{$field.name}">
							<label class="control-label col-lg-2">{$field.label}</label>
							<div class="controls col-lg-3">
								<input class="form-control" name="{$field.name}" type="text" value="{$field.value}"/>
							</div>
							<span class="input-must">{lang key='system::system.require_field'}</span>
						</div>
						<!--{else}-->
						<div class="form-group"  id="{$field.name}"  style="display: none;">
							<label class="control-label col-lg-2">{$field.label}</label>
							<div class="controls col-lg-3">
								<input class="form-control" name="{$field.name}" type="text" value="{$field.value}" size="40" />
							</div>
							<span class="input-must">{lang key='system::system.require_field'}</span>
						</div>
						<!--{/if}-->
						<!--{/if}-->
						<!-- {/foreach} -->
						<!--{/if}-->
						
						<!-- {if $shipping_area.shipping_code eq 'ship_o2o_express'} -->
							<div class="form-group" id="express_money">
								<label class="control-label col-lg-2">配送员费用：</label>
								<div class="controls col-lg-3">
									<input class="form-control col-lg-3" name="express_money" type="text" value="{$express_money|default:0}" size="40" />
								</div>
							</div>
							<div class="form-group" id="ship_days">
								<label class="control-label col-lg-2">下单后几天内配送：</label>
								<div class="controls col-lg-3">
									<input class="form-control col-lg-3" name="ship_days" placeholder="请填写有效天数，最小单位为1" type="text" value="{$ship_days}" />
								</div>
								<div class="clear">
									<label class="control-label col-lg-2"></label>
									<span class="col-lg-5 help-block">默认7天以内配送（用户可选择的时间）</span>
								</div> 
							</div>
							<div class="form-group" id="last_order_time">
								<label class="control-label col-lg-2">提前下单时间：</label>
								<div class="controls col-lg-3">
									<input class="date form-control" name="last_order_time" placeholder="最小单位为分钟；如30" type="text" value="{$last_order_time}" />
								 
								</div>
								<div class="clear">
									<label class="control-label col-lg-2"></label>
									<span class="col-lg-5 help-block">需比配送时间提前多久下单才能配送，否则匹配至下个配送时间</span>
								</div>
							</div>
							<!-- {if $area_id} -->
								<div class="form-group" id="ship_time">
									<label class="control-label col-lg-2">配送时间：</label>
									<div class="controls col-lg-4">
									<!-- {foreach from=$o2o_shipping_time item=shipping_time name=shipping} -->
										<div class='time-picker'>
											从&nbsp;&nbsp;<input class="w100 form-control tp_1" name="start_ship_time[]" type="text" value="{$shipping_time.start}" autocomplete="off" />&nbsp;&nbsp;
											至&nbsp;&nbsp;<input class="w100 form-control tp_1" name="end_ship_time[]" type="text" value="{$shipping_time.end}" autocomplete="off" />
											<!-- {if $smarty.foreach.shipping.last} -->
												<a class="no-underline" data-toggle="clone-obj" data-before="before" data-parent=".time-picker" href="javascript:;"><i class="fontello-icon-plus fa fa-plus"></i></a>
											<!-- {else} -->
												<a class="no-underline" href="javascript:;" data-parent=".time-picker" data-toggle="remove-obj"><i class="fontello-icon-cancel ecjiafc-red fa fa-times "></i></a>
											<!-- {/if} -->
										</div> 
									<!-- {/foreach} -->   
									</div>
								</div>
							<!-- {else} -->
									<div class="form-group" id="ship_time">
										<label class="control-label col-lg-2">配送时间：</label>
										<div class="controls col-lg-4">
											<div class='time-picker'>
												从&nbsp;&nbsp;<input class="w100 form-control tp_1" name="start_ship_time[]" type="text" value="{$time_field.start}"/>&nbsp;&nbsp;
												至&nbsp;&nbsp;<input class="w100 form-control tp_1" name="end_ship_time[]" type="text" value="{$time_field.end}" />
												<a class="no-underline" data-toggle="clone-obj" data-before="before" data-parent=".time-picker" href="javascript:;"><i class="fontello-icon-plus fa fa-plus"></i></a>
											</div>    
										</div>
									</div>
									
							<!-- {/if} -->
						<!-- {/if} -->
						
						<!--  国家选择 -->
						<h3 class="page-header">{lang key='shipping::shipping_area.shipping_area_regions'}</h3>
						
						<div class="form-group">
							<label class="control-label label-selected-area col-lg-2">{lang key='shipping::shipping_area.select_shipping_area'}</label>
							<div class="controls col-lg-3 selected_area">
								<!-- {foreach from=$regions item=region key=id} -->
								<input class="uni_style" type="checkbox" name="regions[]" value="{$id}" checked="checked" id="regions_{$id}" />
								<label for="regions_{$id}">{$region}&nbsp;&nbsp;</label>
								<!-- {/foreach} -->
							</div>
						</div>
						
						<div class="form-group">
							<div class="ms-container ms-shipping" id="ms-custom-navigation">
								<div class="ms-selectable col-lg-3">
									<div class="search-header">
										<input class="form-control" type="text" placeholder="{lang key='shipping::shipping_area.search_country_name'}" autocomplete="off" id="selCountry" />
									</div>
									<ul class="ms-list nav-list-ready selCountry" data-url="{url path='shipping/region/init' args='target=selProvinces&type=1'}" data-next="selProvinces">
										<!-- {foreach from=$countries item=country key=key} -->
										<li class="ms-elem-selectable" data-val="{$country.region_id}"><span>{$country.region_name|escape:html}</span><span class="edit-list"><a href="javascript:;">{lang key='shipping::shipping_area.add'}</a></span></li>
										<!-- {foreachelse} -->
										<li class="ms-elem-selectable" data-val="0"><span>{lang key='shipping::shipping_area.no_country_choose'}</span></li>
										<!-- {/foreach} -->
									</ul>
								</div>
		
								<div class="ms-selectable col-lg-3">
									<div class="search-header">
										<input class="form-control" type="text" placeholder="{lang key='shipping::shipping_area.search_province_name'}" autocomplete="off" id="selProvinces" />
									</div>
									<ul class="ms-list nav-list-ready selProvinces" data-url="{url path='shipping/region/init' args='target=selCities&type=2'}" data-next="selCities">
										<li class="ms-elem-selectable" data-val="0"><span>{lang key='shipping::shipping_area.choose_province_first'}</span></li>
									</ul>
								</div>
								
								<div class="ms-selectable col-lg-3">
									<div class="search-header">
										<input class="form-control" type="text" placeholder="{lang key='shipping::shipping_area.search_city_name'}" autocomplete="off" id="selCities" />
									</div>
									<ul class="ms-list nav-list-ready selCities" data-url="{url path='shipping/region/init' args='target=selDistricts&type=3'}" data-next="selDistricts">
										<li class="ms-elem-selectable" data-val="0"><span>{lang key='shipping::shipping_area.choose_city_first'}</span></li>
									</ul>
								</div>
								
								<div class="ms-selectable col-lg-3">
									<div class="search-header">
										<input class="form-control" type="text" placeholder="{lang key='shipping::shipping_area.search_districe_name'}" autocomplete="off" id="selDistricts" />
									</div>
									<ul class="ms-list nav-list-ready selDistricts">
										<li class="ms-elem-selectable" data-val="0"><span>{lang key='shipping::shipping_area.choose_districe_first'}</span></li>
									</ul>
								</div>
							</div>
							
						</div>
						<div class="form-group ecjiaf-tac">
							<div class="controls">
								<button class="btn btn-info form_submit_btn" type="submit">{lang key='system::system.button_submit'}</button>
							</div>
						</div>
						
					</form>
				</div>
			</div>
		</section>
	</div>
</div>
<!-- {/block} -->