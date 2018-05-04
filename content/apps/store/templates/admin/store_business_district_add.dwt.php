<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<div class="modal-header">
	<button class="close" data-dismiss="modal">×</button>
	<h3>当前操作：<span class="action_title">添加经营地区</span></h3>
</div>

<div class="modal-body">
	<form class="form-horizontal" method="post" action="{url path='store/admin_store_business_city/insert_district'}" name="Form">
		<fieldset>
			<div class="row-fluid priv_list">
				<div class="control-group formSep">
					<label class="control-label control-label-new">所属经营城市名：</label>
					<div class="controls">
						<span class="parent_name">{$business_city_info.business_city_name}</span>
					</div>
		        </div>
				
				<div class="control-group formSep">
					<label class="control-label control-label-new">选择经营地区：</label>
					<div class="controls">
						<!-- {foreach from=$district_list item=region key=id} -->
						<div class="choose">
							<label><input class="checkbox"  name="region_id[]" type="checkbox" value="{$region.region_id}" {if $region.cando eq 1} checked="checked"{/if} autocomplete="off" />{$region.region_name}</label>
						</div>
						<!-- {/foreach} -->
					</div>
				</div>
				<div class="control-group">
					<label class="check">
						<input data-toggle="selectall" data-children=".checkbox" type="checkbox" name="checkall" value="checkbox" {if $select_all} checked="checked"{/if} autocomplete="off" />{t}全选{/t}
					</label>
					<div class="controls">
						<button class="btn btn-gebo" type="submit">确定</button>
						<input name="city_id" type="hidden" value="{$business_city_info.business_city}"/>
					</div>
				</div>
			</div>
		</fieldset>
	</form>
</div>



           
