<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
{insert_sys_scripts files="ecjia.region.js"}
<script type="text/javascript">
{literal}
    ecjia.admin.area_info.init();
{/literal}
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div class="alert alert-info" style=" line-height: 150%">	
	首重单位为1公斤/千克，续重计算单位为 每公斤/千克
</div>
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a href="{$action_link.href}" class="btn plus_or_reply data-pjax" id="sticky_a">
			<i class="fontello-icon-reply"></i>{$action_link.text}
		</a> 
		<!-- {/if} -->
	</h3>
</div>
<div class="row-fluid edit-page">
	<div class="span12">
		<input type="hidden" id="region_warn" value="{lang key='shipping::shipping_area.js_languages.region_exists'}" />
		<input type="hidden" id="region_get_url" date-toggle="{$region_get_url}" />
		
		<form id="form-privilege" class="form-horizontal" name="theForm" action="{$form_action}" method="post" enctype="multipart/form-data">
			<fieldset>
			    {if $store.merchants_name}
			    <div class="control-group formSep">
					<label class="control-label">商家名称：</label>
					<div class="controls">
						<input name="" type="text" value="{$store.merchants_name}" size="40" readonly="readonly" /> 
						<input type="hidden" name="store_id" value="{$store.store_id}" />
					</div>
				</div>
			    {/if}
				<!-- {if $area_id} -->
				<input type="hidden" name="id" value="{$area_id}" />
				<!-- {/if} -->
				<input type="hidden" name="shipping_id" value="{$shipping_area.shipping_id}" />
				<div class="control-group formSep">
					<label class="control-label">{lang key='shipping::shipping_area.label_shipping_area_name'}</label>
					<div class="controls">
						<input name="shipping_area_name" type="text" value="{$shipping_area.shipping_area_name}" size="40" /> 
						<span class="input-must">{lang key='system::system.require_field'}</span>
					</div>
				</div>
				<!-- 费用计算方式 -->
				{if $shipping_area.shipping_code eq 'ship_ems' || $shipping_area.shipping_code eq 'ship_yto' ||
				$shipping_area.shipping_code eq 'ship_zto' || $shipping_area.shipping_code eq 'ship_sto_express' ||
				$shipping_area.shipping_code eq 'ship_post_mail' || $shipping_area.shipping_code eq 'ship_sf_express' ||
				$shipping_area.shipping_code eq 'ship_post_express' }
				<div class="control-group formSep">
					<label class="control-label">{lang key='shipping::shipping_area.label_fee_compute_mode'}</label>
					<div class="controls chk_radio">
						<input type="radio" class="uni_style" {if $fee_compute_mode neq 'by_number' }checked="checked" {/if}
						onclick="javascript:ecjia.admin.shippingObj.area_compute_mode('{$shipping_area.shipping_code}','weight')" name="fee_compute_mode" value="by_weight" />
						<span>{lang key='shipping::shipping_area.fee_by_weight'}</span>
						<input type="radio" class="uni_style" {if $fee_compute_mode eq 'by_number'}checked="checked" {/if}  
						onclick="javascript:ecjia.admin.shippingObj.area_compute_mode('{$shipping_area.shipping_code}','number')"
						name="fee_compute_mode" value="by_number" /><span>{lang key='shipping::shipping_area.fee_by_number'}</span>
					</div>
				</div>
				<!-- {/if} -->

				<!-- 500克以内的费用 -->
				<!--{if $shipping_area.shipping_code != 'ship_cac'}-->
				<!-- {foreach from=$fields item=field} -->
				<!--{if $fee_compute_mode == 'by_number'}-->
				<!--{if $field.name == 'item_fee' || $field.name == 'free_money' || $field.name == 'pay_fee'}-->
				<div class="control-group formSep" id="{$field.name}">
					<label class="control-label">{$field.label}</label>
					<div class="controls">
						<input name="{$field.name}" type="text" value="{$field.value}" size="40" /> 
						<span class="input-must">{lang key='system::system.require_field'}</span>
					</div>
				</div>
				<!--{else}-->
				<div class="control-group formSep" id="{$field.name}" style="display: none;">
					<label class="control-label">{$field.label}</label>
					<div class="controls">
						<input name="{$field.name}" type="text" value="{$field.value}" size="40" />
						<span class="input-must">{lang key='system::system.require_field'}</span>
					</div>
				</div>
				<!--{/if}-->
				<!--{else}-->
				<!--{if $field.name != 'item_fee'}-->
				<div class="control-group formSep" id="{$field.name}">
					<label class="control-label">{$field.label}</label>
					<div class="controls">
						<input name="{$field.name}" type="text" value="{$field.value}" size="40" />
						<span class="input-must">{lang key='system::system.require_field'}</span>
					</div>
				</div>
				<!--{else}-->
				<div class="control-group formSep" id="{$field.name}" style="display: none;">
				<label class="control-label">{$field.label}</label>
				<div class="controls">
						<input name="{$field.name}" type="text" value="{$field.value}" size="40" />
						<span class="input-must">{lang key='system::system.require_field'}</span>
					</div>
				</div>
				<!--{/if}-->
				<!--{/if}-->
				<!-- {/foreach} -->
				<!--{/if}-->
				
				
				<!-- {if $shipping_area.shipping_code eq 'ship_o2o_express'} -->
					<div class="control-group formSep" id="ship_days">
						<label class="control-label">下单后几天内配送：</label>
						<div class="controls">
							<input name="ship_days" placeholder="请填写有效天数，最小单位为1" type="text" value="{$ship_days}" size="40" />
							<span class="help-block">默认7天以内配送（用户可选择的时间）</span> 
						</div>
					</div>
					<div class="control-group formSep" id="last_order_time">
						<label class="control-label">提前下单时间：</label>
						<div class="controls">
							<input class="date" name="last_order_time" placeholder="最小单位为分钟；如30" type="text" value="{$last_order_time}" size="40" />
							<span class="help-block">需比配送时间提前多久下单才能配送，否则匹配至下个配送时间</span> 
						</div>
					</div>
					<!-- {if $area_id} -->
						<div class="control-group formSep" id="ship_time">
							<label class="control-label">配送时间：</label>
							<div class="controls">
							<!-- {foreach from=$o2o_shipping_time item=shipping_time name=shipping} -->
								<div class='goods_type'>
									从&nbsp;&nbsp;<input class="w100 tp_1" name="start_ship_time[]" type="text" value="{$shipping_time.start}" autocomplete="off" />&nbsp;&nbsp;
									至&nbsp;&nbsp;<input class="w100 tp_1" name="end_ship_time[]" type="text" value="{$shipping_time.end}" autocomplete="off" />
									<!-- {if $smarty.foreach.shipping.last} -->
										<a class="no-underline" data-toggle="clone-obj" data-before="before" data-parent=".goods_type" href="javascript:;"><i class="fontello-icon-plus"></i></a>
									<!-- {else} -->
										<a class="no-underline" href="javascript:;" data-parent=".goods_type" data-toggle="remove-obj"><i class="fontello-icon-cancel ecjiafc-red"></i></a>
									<!-- {/if} -->
								</div> 
							<!-- {/foreach} -->   
							</div>
						</div>
					<!-- {else} -->
							<div class="control-group formSep" id="ship_time">
								<label class="control-label">配送时间：</label>
								<div class="controls">
									<div class='goods_type'>
										从&nbsp;&nbsp;<input class="w100 tp_1" name="start_ship_time[]" type="text" value="{$time_field.start}"/>&nbsp;&nbsp;
										至&nbsp;&nbsp;<input class="w100 tp_1" name="end_ship_time[]" type="text" value="{$time_field.end}" />
										<a class="no-underline" data-toggle="clone-obj" data-before="before" data-parent=".goods_type" href="javascript:;"><i class="fontello-icon-plus"></i></a>
									</div>    
								</div>
							</div>
							
					<!-- {/if} -->
				<!-- {/if} -->
				
				<!--  国家选择 -->
				<h3 class="heading">{lang key='shipping::shipping_area.shipping_area_regions'}</h3>

				<div class="control-group formSep">
					<label class="control-label">{lang key='shipping::shipping_area.select_shipping_area'}</label>
					<div class="controls selected_area chk_radio">
						<!-- {foreach from=$regions item=region key=id} -->
						<input class="uni_style" type="checkbox" name="regions[]" value="{$id}" checked="checked" /> <span class="m_r10">{$region}&nbsp;&nbsp;</span>
						<!-- {/foreach} -->
					</div>
				</div>

				<div class="span12 m_l0 m_b20">
					<div class="ms-container ms-shipping span12" id="ms-custom-navigation">
						<div class="ms-selectable span3">
							<div class="search-header">
								<input class="span12" type="text" placeholder="{lang key='shipping::shipping_area.search_country_name'}" autocomplete="off" id="selCountry" />
							</div>
							<ul class="ms-list nav-list-ready selCountry" data-url="{url path='shipping/region/init' args='target=selProvinces&type=1'}" data-next="selProvinces">
								<!-- {foreach from=$countries item=country key=key} -->
								<li class="ms-elem-selectable" data-val="{$country.region_id}"><span>{$country.region_name|escape:html}</span><span class="edit-list"><a href="javascript:;">{lang key='shipping::shipping_area.add'}</a></span></li>
								<!-- {foreachelse} -->
								<li class="ms-elem-selectable" data-val="0"><span>{lang key='shipping::shipping_area.no_country_choose'}</span></li>
								<!-- {/foreach} -->
							</ul>
						</div>

						<div class="ms-selectable span3">
							<div class="search-header">
								<input class="span12" type="text" placeholder="{lang key='shipping::shipping_area.search_province_name'}" autocomplete="off" id="selProvinces" />
							</div>
							<ul class="ms-list nav-list-ready selProvinces" data-url="{url path='shipping/region/init' args='target=selCities&type=2'}" data-next="selCities">
								<li class="ms-elem-selectable" data-val="0"><span>{lang key='shipping::shipping_area.choose_province_first'}</span></li>
							</ul>
						</div>
						
						<div class="ms-selectable span3">
							<div class="search-header">
								<input class="span12" type="text" placeholder="{lang key='shipping::shipping_area.search_city_name'}" autocomplete="off" id="selCities" />
							</div>
							<ul class="ms-list nav-list-ready selCities" data-url="{url path='shipping/region/init' args='target=selDistricts&type=3'}" data-next="selDistricts">
								<li class="ms-elem-selectable" data-val="0"><span>{lang key='shipping::shipping_area.choose_city_first'}</span></li>
							</ul>
						</div>
						
						<div class="ms-selectable span3">
							<div class="search-header">
								<input class="span12" type="text" placeholder="{lang key='shipping::shipping_area.search_districe_name'}" autocomplete="off" id="selDistricts" />
							</div>
							<ul class="ms-list nav-list-ready selDistricts">
								<li class="ms-elem-selectable" data-val="0"><span>{lang key='shipping::shipping_area.choose_districe_first'}</span></li>
							</ul>
						</div>
					</div>
				</div>

				<div class="control-group">
					<div class="controls">
						<button class="btn btn-gebo form_submit_btn" type="submit">{lang key='system::system.button_submit'}</button>
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</div>
<!-- {/block} -->