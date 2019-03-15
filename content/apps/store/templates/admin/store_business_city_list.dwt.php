<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->
<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.store_business_city.init();
</script>
<!-- {/block} -->
<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a class="btn plus_or_reply add-business-city-modal" data-toggle="modal" data-backdrop="static" href="#myModal1" add-business-city-url='{url path="store/admin_store_business_city/add"}'  title="{$action_link.text}"><i class="fontello-icon-plus"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>

<div id="myModal1" class="modal hide fade add-business-city" style="height:430px;width:650px;"></div>
<div id="myModal2" class="modal hide fade edit-business-city" style="height:430px;width:650px;"></div>
<div id="myModal4" class="modal hide fade add-business-district" style="height:500px;width:650px;margin-left:-230px; margin-top:80px;"></div>
   

<!-- start ad position list -->
<div class="row-fluid">
	<table class="table table-striped"  id="list-table">
		<thead>
			<tr>
				<th>{t domain="store"}城市名称{/t}</th>
				<th>{t domain="store"}城市别名{/t}</th>
				<th class="w80">{t domain="store"}操作{/t}</th>
			</tr>
		</thead>
		<!-- {foreach from=$business_city_list item=business_city} -->
			<tr class="0" id="0_{$business_city.business_city}">
				<td class="first-cell" align="left">
					<i class="fontello-icon-minus-squared-alt cursor_pointer ecjiafc-blue" id="icon_0_{$business_city.business_city}" style="margin-left:0em" onclick="rowClicked(this)" /></i>
					<span>{$business_city.business_city_name}{if $business_city.business_city_alias}{/if}</span>
				</td>
				<td>{$business_city.business_city_alias}</td>
				<td>
					<a class="no-underline edit-business-city-modal" data-toggle="modal" data-backdrop="static" href="#myModal2" edit-business-city-url='{url path="store/admin_store_business_city/edit" args="city_id={$business_city.business_city}"}'  title='{t domain="store"}编辑经营城市{/t}'><i class="fontello-icon-edit"></i></a>
					<a class="no-underline add-business-district-modal" data-toggle="test_modal" data-backdrop="static" data-href="#myModal4" add-business-district-url='{url path="store/admin_store_business_city/add_business_district" args="city_id={$business_city.business_city}"}'  title='{t domain="store"}添加经营地区{/t}'><i class="fontello-icon-pencil-squared"></i></a>
					<a class="ajaxremove no-underline" data-toggle="ajaxremove" data-msg='{t domain="store"}您确定删除该经营城市吗？{/t}' href='{url path="store/admin_store_business_city/remove" args="city_id={$business_city.business_city}"}' title='{t domain="store"}删除经营城市{/t}'><i class="fontello-icon-trash"></i></a>
				</td>
			</tr>
			<!-- {if $business_city.business_district_name}-->
				<!-- {foreach from=$business_city.business_district_name item=district} -->
			<tr class="1" id="1_{$district.district_id}">
				<td class="first-cell" align="left">
					<i class="fontello-icon-minus-squared-alt cursor_pointer ecjiafc-blue" id="icon_1_{$district.district_id}" style="margin-left:1em" onclick="rowClicked(this)" /></i>
					<span>{$district.district_name}</span>
				</td>
				<td></td>
				<td>
					<a class="ajaxremove no-underline" data-toggle="ajaxremove" data-msg='{t domain="store"}您确定删除该经营地区吗？{/t}' href='{url path="store/admin_store_business_city/remove_business_district" args="city_id={$business_city.business_city}&district_id={$district.district_id}"}' title='{t domain="store"}删除经营地区{/t}'><i class="fontello-icon-trash"></i></a>
				</td>
			</tr>
				<!-- {/foreach} -->
			<!-- {/if}-->
		<!-- {foreachelse}-->
			<tr>
				<td class="no-records" colspan="3">{t domain="store"}没找到任何记录{/t}</td>
			</tr>	
		<!-- {/foreach} -->
	</table>
</div>
<!-- {/block} -->