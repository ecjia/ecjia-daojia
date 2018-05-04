<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<div class="modal-header">
	<button class="close" data-dismiss="modal">×</button>
	<h3>当前操作：<span class="action_title">添加经营城市</span></h3>
</div>
<div class="modal-body">
	<form class="form-horizontal" name="Form"  method="post" action="{url path='store/admin_store_business_city/insert'}">
		<div class="control-group formSep">
			<label class="control-label control-label-new">选择经营城市：</label>
			<div class="controls controls-new choose_list">
	        	<select class="region-summary-provinces w120" name="province" id="selProvinces" data-url="{url path='setting/region/init'}" data-toggle="regionSummary" data-type="2" data-target="region-summary-cities" >
        			<option value='0'>{lang key='system::system.select_please'}</option>
        			<!-- {foreach from=$province item=region} -->
        			<option value="{$region.region_id}">{$region.region_name}</option>
        			<!-- {/foreach} -->
        		</select>
	        	<select class="region-summary-cities w120" name="city" id="selCities" data-url="{url path='setting/region/init'}" data-toggle="regionSummary" data-type="3" data-target="">
	        		<option value='0'>{lang key='system::system.select_please'}</option>
	        		<!-- {foreach from=$city item=region} -->
        		<option value="{$region.region_id}">{$region.region_name}</option>
        		<!-- {/foreach} -->
        		</select>
        	</div>
        </div>
        <div class="control-group formSep">
        	<label class="control-label">城市别名：</label>
        	<div class="controls">
        		<input class="span4" name="business_city_alias" type="text" value="" />
        	</div>
        </div>
		<div class="control-group formSep">
        	<label class="control-label">索引首字母：</label>
        	<div class="controls">
        		<input class="span4" name="index_letter" type="text" value="" />
        		<span class="help-block">{t}城市名第一个字的拼音首字母{/t}</span>
        	</div>
        </div>
        <div class="control-group t_c">
			<button class="btn btn-gebo" type="submit">确定</button>
		</div>
	</form>
</div>



           
