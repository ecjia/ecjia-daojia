<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a href="{$action_link.href}{if $smarty.get.store_id}&store_id={$smarty.get.store_id}{/if}" class="btn plus_or_reply data-pjax" id="sticky_a"><i class="fontello-icon-plus"></i>{$action_link.text}</a>
		<!-- {/if} -->
		<!-- {if $shipping_method} -->
		<a href="{$shipping_method.href}" class="btn plus_or_reply data-pjax" id="sticky_a"><i class="fontello-icon-reply"></i>{$shipping_method.text}</a>
		<!-- {/if} -->
	</h3>
</div>
<div class="row-fluid">
	<div class="span12">
		<form method="post" action="{$form_action}" name="listForm" >
			<input type="hidden" name="shipping_id" value="{$shipping_id}" />
			<input type="hidden" name="code" value="{$code}" />
			<div class="row-fluid">
				<div class="btn-group ">
					<button data-toggle="dropdown" class="btn dropdown-toggle btnSubmit" >
						<i class="fontello-icon-cog"></i>
						{lang key='shipping::shipping_area.batch'}
						<span class="caret"></span>
					</button>
					<ul class="dropdown-menu">
						<li><a class="button_remove" data-name="area_ids" data-noselectmsg="{lang key='shipping::shipping_area.select_drop_area'}" data-url="{$form_action}" data-msg="{lang key='shipping::shipping_area.batch_drop_confirm'}" data-idclass=".checkbox:checked" data-toggle="ecjiabatch"  href="javascript:;"><i class="fontello-icon-trash"></i>{lang key='system::system.drop'}</a></li>
					</ul>
				</div>
				<div class="choose_list f_r" >
					<input type="text" name="keywords" value="{$areas.filter.keywords}" placeholder="{lang key='shipping::shipping_area.area_name_keywords'}"/> 
					<button class="btn" type="button" id="search_btn" onclick='javascript:ecjia.admin.shippingObj.shipping_area_list_search("{$search_action}")'>{lang key='shipping::shipping_area.search'}</button>
				</div>
			</div>
			<div class="row-fluid">
				<table class="table table-striped smpl_tbl">
					<thead>
						<tr>
							<th class="table_checkbox">
								<input type="checkbox" data-children=".checkbox" data-toggle="selectall" name="select_rows" style="opacity: 0;">
							</th>
							<th class="w150">{lang key='shipping::shipping_area.shipping_area_name'}</th>
							<th class="w150">{lang key='shipping::shipping_area.merchant_name'}</th>
							<th>{lang key='shipping::shipping_area.shipping_area_regions'}</th>
							<th class="w100">{lang key='system::system.handler'}</th>
						</tr>
					</thead>
					<tbody>
						<!-- {foreach from=$areas.areas_list item=area} -->
						<tr id="aa">
							<td> 
								<input class="checkbox" type="checkbox" value="{$area.shipping_area_id}"  name="areas[]" style="opacity: 0;">
							</td>
							<td>{$area.shipping_area_name|escape:"html"}</td>
							<td>{$area.merchants_name}</td>
							<td>{$area.shipping_area_regions}</td>
							<td>
								<a class="data-pjax no-underline" href='{RC_Uri::url("shipping/admin_area_plugin/edit", "id={$area.shipping_area_id}&shipping_id={$shipping_id}&code={$code}")}' class="sepV_a" title="{lang key='system::system.edit'}"><i class="fontello-icon-edit"></i></a>
								<a class="ajaxremove  no-underline" data-toggle="ajaxremove" data-msg="{lang key='shipping::shipping_area.drop_area_confirm'}" href='{RC_Uri::url("shipping/admin_area_plugin/remove_area","id={$area.shipping_area_id}")}' title="{lang key='system::system.remove'}"><i class="fontello-icon-trash"></i></a>
							</td>
						</tr>
						<!-- {foreachelse} -->
					    <tr><td class="no-records" colspan="5">{lang key='system::system.no_records'}</td></tr>
						<!-- {/foreach} -->
					</tbody>
				</table>
				<!-- {$areas.page} -->	
				<div class="hide">
					<!-- confirmation box -->
					<div id="confirm_dialog" class="cbox_content">
						<div class="sepH_c tac"><strong>{lang key='shipping::shipping_area.remove_confirm'}</strong></div>
						<div class="tac">
							<a href="javascript:;" class="btn btn-gebo confirm_yes">{lang key='shipping::shipping_area.yes'}</a>
							<a href="javascript:;" class="btn confirm_no">{lang key='shipping::shipping_area.no'}</a>
						</div>
					</div>
				</div>
			</div>
		</form>	
	</div>
</div>
<!-- {/block} -->