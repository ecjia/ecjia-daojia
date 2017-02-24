<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<div class="control-group formSep">
	<label class="control-label">{$var.name}：</label>
	<div class="controls">
	   <!-- {if $var.code eq "shop_country"} -->
		<select class="w350" name="value[{$var.id}]" id="selCountries" data-toggle="regionSummary" data-url="{RC_Uri::url('shipping/region/init')}" data-type="1" data-target="region-summary-provinces">
			<option value='0'>{t}请选择...{/t}</option>
			<!-- {foreach from=$countries item=region} -->
			<option value="{$region.region_id}" {if $region.region_id eq $ecjia_config.shop_country}selected{/if}>{$region.region_name}</option>
			<!-- {/foreach} -->
		</select>
		<!-- {elseif $var.code eq "shop_province"} -->
		<select class="w350 region-summary-provinces" name="value[{$var.id}]" id="selProvinces" data-toggle="regionSummary" data-type="2" data-target="region-summary-cities" >
			<option value='0'>{t}请选择...{/t}</option>
			<!-- {foreach from=$provinces item=region} -->
			<option value="{$region.region_id}" {if $region.region_id eq $ecjia_config.shop_province}selected{/if}>{$region.region_name}</option>
			<!-- {/foreach} -->
		</select>
		<!-- {elseif $var.code eq "shop_city"} -->
		<select class="w350 region-summary-cities" name="value[{$var.id}]" id="selCities" >
			<option value='0'>{t}请选择...{/t}</option>
			<!-- {foreach from=$cities item=region} -->
			<option value="{$region.region_id}" {if $region.region_id eq $ecjia_config.shop_city}selected{/if}>{$region.region_name}</option>
			<!-- {/foreach} -->
		</select>
        <!-- {/if} -->
	    <!-- {if $var.desc} -->
		<span class="help-block" id="notice{$var.code}">{$var.desc|nl2br}</span>
		<!-- {/if} -->
	</div>
</div>