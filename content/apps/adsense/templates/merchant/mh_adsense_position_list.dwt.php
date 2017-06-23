<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!--{extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->
<div class="row">
	<div class="col-lg-12">
		<h2 class="page-header">
			<!-- {if $ur_here}{$ur_here}{/if} -->
			<div class="pull-right">
				{if $action_link}<a href="{$action_link.href}" class="btn btn-primary data-pjax"><i class="fa fa-plus"></i> {$action_link.text}</a>{/if}
			</div>
		</h2>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="panel">
			<div class="panel-body panel-body-small">
				<section class="panel">
					<table class="table table-striped table-hover table-hide-edit ecjiaf-tlf">
						<thead>
							<tr data-sorthref='{url path="adsense/mh_position/init"}'>
							    <th class="w80" data-toggle="sortby" data-sortby="position_id">编号</th>
				                <th class="w200">广告位名称</th>
				                <th class="w150" data-toggle="sortby" data-sortby="position_code">广告位代号</th>
				                <th>广告位描述</th>
							    <th class="w100">建议大小</th>
							    <th class="w100" data-toggle="sortby" data-sortby="sort_order">排序</th>
							    <th class="w110">查看</th>
			                </tr>
						</thead>
						<tbody>
			            	<!-- {foreach from=$data item=val} -->
							<tr>
								<td><span>{$val.position_id}</span></td>
							    <td class="hide-edit-area hide_edit_area_bottom">
							    	<span class="cursor_pointer" data-text="text" data-trigger="editable" data-url="{RC_Uri::url('adsense/mh_position/edit_position_name')}" data-name="position_name" data-pk="{$val.position_id}" data-title="编辑广告位置名称">{$val.position_name}</span>
			                    	<div class="edit-list">
								      	<a class="data-pjax" href='{RC_Uri::url("adsense/mh_position/edit", "position_id={$val.position_id}")}' title="{lang key='system::navigator.edit'}">{lang key='system::system.edit'}</a>&nbsp;|&nbsp;
								    	<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg="{lang key='adsense::adsense.confirm_remove'}" href='{RC_Uri::url("adsense/mh_position/remove", "id={$val.position_id}")}' title="删除">{lang key='adsense::adsense.remove'}</a>
									</div>
							    </td>
							    <td><span>{if $val.position_code}{$val.position_code}{else}<i><无></i>{/if}</span></td>
							    <td><span>{$val.position_desc}</span></td>
							    <td><span>{$val.ad_width} x {$val.ad_height}</span></td>
							    <td><span class="edit_sort cursor_pointer" data-trigger="editable" data-url='{RC_Uri::url("adsense/mh_position/edit_sort")}' data-name="sort_order" data-pk="{$val.position_id}" data-title="排序">{$val.sort_order}</span></td>
							    <td>
								   	<a class="btn btn-primary data-pjax" href='{RC_Uri::url("adsense/mh_ad/init", "position_id={$val.position_id}")}'>查看广告</a>
							    </td>
							</tr>
							<!-- {foreachelse}-->
							<tr>
								<td class="no-records" colspan="7">{lang key='system::system.no_records'}</td>
							</tr>
							<!-- {/foreach} -->
						</tbody>
					</table>
				</section>
			</div>
		</div>
	</div>
</div>
<!-- {/block} -->