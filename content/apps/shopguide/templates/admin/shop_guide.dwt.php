<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.admin.shopguide.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
    <h3 class="heading">
        <!-- {if $ur_here}{$ur_here}{/if} -->
    </h3>
</div>

<div class="row-fluid">
    <div class="span12">
    	<ul id="validate_wizard-titles" class="stepy-titles clearfix">
    		<!-- {if !$smarty.get.step || $smarty.get.step eq '1'} -->
    		<li id="step1" class="current-step cursor_pointor"><div>{lang key='shopguide::shopguide.base_info'}</div><span>{lang key='shopguide::shopguide.base_info_notice'}</span><span class="stepNb">1</span></li>
    		<!-- {elseif $smarty.get.step eq '2'} -->
    		<li id="step2" class="current-step cursor_pointor"><div>{lang key='shopguide::shopguide.goods_info'}</div><span>{lang key='shopguide::shopguide.goods_info_notice'}</span><span class="stepNb">2</span></li>
    		<!-- {elseif $smarty.get.step eq '3'} -->
    		<li id="step3" class="current-step cursor_pointor"><div>{lang key='shopguide::shopguide.result_info'}</div><span>{lang key='shopguide::shopguide.result_info_notice'}</span><span class="stepNb">3</span></li>
    		<!-- {/if} -->
    	</ul>
        <form class="stepy-wizzard form-horizontal application-installer" id="validate_wizard" action="{url path='shopguide/admin/step_post'}{if $smarty.get.step}&step={$smarty.get.step}{/if}" method="post" name="theForm">
            <!-- {if !$smarty.get.step || $smarty.get.step eq '1'} -->
            <fieldset class="step_one step" title="{lang key='shopguide::shopguide.base_info'}">
                <div class="control-group formSep m_t10">
					<label class="control-label">{lang key='shopguide::shopguide.label_shop_name'}</label>
					<div class="controls">
						<input class="w350" type="text" name="shop_name" value="{$data.shop_name}" />
						<span class="input-must">{lang key='system::system.require_field'}</span>
					</div>
				</div>
				
				<div class="control-group formSep">
					<label class="control-label">{lang key='shopguide::shopguide.label_shop_title'}</label>
					<div class="controls">
						<input class="w350" type="text" name="shop_title" value="{$data.shop_title}" />
					</div>
				</div>
				
				<div class="control-group formSep">
					<label class="control-label">{lang key='shopguide::shopguide.label_shop_country'}</label>
					<div class="controls">
						<select class="w350" name="shop_country" id="selCountries" data-toggle="regionSummary" data-url="{RC_Uri::url('shopguide/region/init')}" data-type="1" data-target="region-summary-provinces">
							<option value='0'>{lang key='shopguide::shopguide.pls_select'}</option>
							<!-- {foreach from=$countries item=region} -->
							<option value="{$region.region_id}">{$region.region_name}</option>
							<!-- {/foreach} -->
						</select>
					</div>
				</div>
				
				<div class="control-group formSep">
					<label class="control-label">{lang key='shopguide::shopguide.label_shop_province'}</label>
					<div class="controls">
						<select class="w350 region-summary-provinces" name="shop_province" id="selProvinces" data-toggle="regionSummary" data-type="2" data-target="region-summary-cities">
							<option value='0'>{lang key='shopguide::shopguide.pls_select'}</option>
							<!-- {foreach from=$provinces item=region} -->
							<option value="{$region.region_id}">{$region.region_name}</option>
							<!-- {/foreach} -->
						</select>
					</div>
				</div>
				
				<div class="control-group formSep">
					<label class="control-label">{lang key='shopguide::shopguide.label_shop_city'}</label>
					<div class="controls">
						<select class="w350 region-summary-cities" name="shop_city" id="selCities">
							<option value='0'>{lang key='shopguide::shopguide.pls_select'}</option>
							<!-- {foreach from=$cities item=region} -->
							<option value="{$region.region_id}">{$region.region_name}</option>
							<!-- {/foreach} -->
						</select>
					</div>
				</div>	
				
				<div class="control-group formSep">
					<label class="control-label">{lang key='shopguide::shopguide.label_shop_address'}</label>
					<div class="controls">
						<input class="w350" type="text" name="shop_address" value="" />
					</div>
				</div>	
				
				<div class="control-group formSep">
					<label class="control-label">{lang key='shopguide::shopguide.label_shipping'}</label>
					<div class="controls">
						<select class="w350" name="shipping" id="shipping_type">
				    		<option value=''>{lang key='shopguide::shopguide.pls_select'}</option>
				            <!-- {foreach from=$shipping_list item=module} -->
				            <option value="{$module.id}">{$module.name}</option>
				            <!-- {/foreach} -->
				        </select>
					</div>
				</div>
				
				<div class="shipping_area hide">
					<div class="control-group">
						<label class="control-label">{lang key='shopguide::shopguide.label_shipping_area'}</label>
						<div class="controls">
							<input class="w350" type="text" name="shipping_area_name" />
							<span class="input-must">{lang key='system::system.require_field'}</span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">{lang key='shopguide::shopguide.label_shipping_country'}</label>
						<div class="controls">
							<select class="w350 selCountry sel_region" name="shipping_country" data-next="selProvinces" data-url="{url path='shopguide/region/init' args='target=selProvinces&type=1'}">
								<option value='0'>{lang key='shopguide::shopguide.pls_select'}</option>
								<!-- {foreach from=$countries item=region} -->
								<option value="{$region.region_id}">{$region.region_name}</option>
								<!-- {/foreach} -->
							</select>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">{lang key='shopguide::shopguide.label_shipping_province'}</label>
						<div class="controls">
							<select class="w350 selProvinces sel_region" name="shipping_province" data-next="selCities" data-url="{url path='shopguide/region/init' args='target=selCities&type=2'}">
								<option value='0'>{lang key='shopguide::shopguide.pls_select'}</option>
							</select>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">{lang key='shopguide::shopguide.label_shipping_city'}</label>
						<div class="controls">
							<select class="w350 selCities sel_region" name="shipping_city" data-url="{url path='shopguide/region/init' args='target=selDistricts&type=3'}" data-next="selDistricts">
								<option value='0'>{lang key='shopguide::shopguide.pls_select'}</option>
							</select>
						</div>
					</div>	
					<div class="control-group formSep">
						<label class="control-label">{lang key='shopguide::shopguide.label_shipping_district'}</label>
						<div class="controls">
							<select class="w350 selDistricts sel_region" name="shipping_district">
								<option value='0'>{lang key='shopguide::shopguide.pls_select'}</option>
							</select>
						</div>
					</div>
				</div>
				
				<div class="control-group formSep">
					<label class="control-label">{lang key='shopguide::shopguide.label_pay_type'}</label>
					<div class="controls">
						<select class="w350" name="payment" id="pay_type" data-url="{url path='shopguide/admin/get_pay'}">
				    		<option value=''>{lang key='shopguide::shopguide.pls_select'}</option>
				    		<!-- {foreach from=$pay_list item=module} -->
				            <option value="{$module.code}">{$module.name}</option>
				            <!-- {/foreach} -->
				        </select>
					</div>
				</div>
				
				<div class="payment_area hide">
				</div>
				
                <input class="btn btn-inverse f_r m_l10" type="submit" value="{lang key='shopguide::shopguide.next_step'}"/>
            </fieldset>
            
            <!-- {elseif $smarty.get.step eq '2'} -->
            <fieldset class="step_two step" title="{lang key='shopguide::shopguide.goods_info'}">
				<div class="control-group formSep m_t10">
					<label class="control-label">{lang key='shopguide::shopguide.label_goods_cat'}</label>
					<div class="controls">
						<input class="w350" type="text" name="cat_name" />
						<span class="input-must">{lang key='system::system.require_field'}</span>
					</div>
				</div>
				
				<div class="control-group formSep m_t10">
					<label class="control-label">{lang key='shopguide::shopguide.label_store_cat'}</label>
					<div class="controls">
						<input class="w350" type="text" name="store_cat" />
						<span class="input-must">{lang key='system::system.require_field'}</span>
					</div>
				</div>		
				
			    <input class="btn btn-inverse f_r m_l10" type="submit" value="{lang key='shopguide::shopguide.next_step'}"/>	
			</fieldset>
			
			<!-- {elseif $smarty.get.step eq '3'} -->
			<fieldset class="step_three step" title="{lang key='shopguide::shopguide.result_info'}">
			<div class="row-fluid padding5 m_l15">
				<div class="span2"><a class="btn w100" href="{RC_Uri::url('@index/init')}">{lang key='shopguide::shopguide.view_shop'}</a></div>
				<div class="span2"><a class="btn w100" href="{RC_Uri::url('setting/shop_config/init')}&code=shop_info">{lang key='shopguide::shopguide.shop_config'}</a></div>
				<div class="span2"><a class="btn w100" href="{RC_Uri::url('@privilege/add')}">{lang key='shopguide::shopguide.add_admin'}</a></div>
			</div>
			
			<div class="row-fluid padding5 m_l15">
				<div class="span2"><a class="btn w100" href="{RC_Uri::url('goods/admin_category/add')}">{lang key='shopguide::shopguide.add_goods_cat'}</a></div>
				<div class="span2"><a class="btn w100" href="{RC_Uri::url('goods/admin/init')}">{lang key='shopguide::shopguide.goods_list'}</a></div>
				<div class="span2"><a class="btn w100" href="{RC_Uri::url('goods/admin_goods_type/init')}">{lang key='shopguide::shopguide.goods_type'}</a></div>
			</div>
			
			<div class="row-fluid padding5 m_l15">
				<div class="span2"><a class="btn w100" href="{RC_Uri::url('@admin_template/init')}">{lang key='shopguide::shopguide.choose_template'}</a></div>
				<div class="span2"><a class="btn w100" href="{RC_Uri::url('favourable/admin/add')}">{lang key='shopguide::shopguide.add_favourable'}</a></div>
				<div class="span2"><a class="btn w100" href="{RC_Uri::url('user/admin/add')}">{lang key='shopguide::shopguide.add_user'}</a></div>
			</div>
			<!-- {/if} -->
			</fieldset>
        </form>
    </div>
</div>
<!-- {/block} -->