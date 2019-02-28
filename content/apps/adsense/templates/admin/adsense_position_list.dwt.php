<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.ad_position_list.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div class="alert">
	<a class="close" data-dismiss="alert">×</a>
	<strong>{t domain="adsense"}温馨提示：{/t}</strong>{t domain="adsense"}建议您添加为"默认"地区的广告位，当并未设置地区时就会显示默认的广告位。{/t}
</div>

<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		{if $action_link}
		<a href="{$action_link.href}" class="btn plus_or_reply data-pjax" id="sticky_a"><i class="fontello-icon-plus"></i>{$action_link.text}</a>
		{/if}
	</h3>
</div>

<ul class="nav nav-pills">
 <!-- {foreach from=$city_list item=val} -->
	<li class="{if $city_id eq $val.city_id}active{/if}"><a class="data-pjax" href='{url path="adsense/admin_position/init" args="city_id={$val.city_id}"}'>{$val.city_name}<span class="badge badge-info"></span></a></li>
 <!-- {/foreach} -->
</ul>

<div class="row-fluid">
	<div class="span12">
		<table class="table table-striped smpl_tbl dataTable table-hide-edit">
			<thead>
				<tr data-sorthref='{url path="adsense/admin_position/init"}'>
				    <th class="w50" data-toggle="sortby" data-sortby="position_id">{t domain="adsense"}编号{/t}</th>
	                <th class="w200">{t domain="adsense"}广告位名称{/t}</th>
	                <th class="w130" data-toggle="sortby" data-sortby="position_code">{t domain="adsense"}广告位代号{/t}</th>
	                <th>{t domain="adsense"}广告位描述{/t}</th>
				    <th class="w100">{t domain="adsense"}建议大小{/t}</th>
				    <th class="w100" data-toggle="sortby" data-sortby="sort_order">{t domain="adsense"}排序{/t}</th>
				    <th class="w80">{t domain="adsense"}查看{/t}</th>
                </tr>
			</thead>
			<tbody>
            	<!-- {foreach from=$data item=val} -->
				<tr>
					<td><span>{$val.position_id}</span></td>
				    <td class="hide-edit-area hide_edit_area_bottom">
				    	<span class="cursor_pointer" data-text="text" data-trigger="editable" data-url="{RC_Uri::url('adsense/admin_position/edit_position_name')}" data-name="position_name" data-pk="{$val.position_id}" data-title='{t domain="adsense"}编辑广告位置名称{/t}'>{$val.position_name}</span>
                    	<div class="edit-list">
					      	<a class="data-pjax" href='{RC_Uri::url("adsense/admin_position/edit", "position_id={$val.position_id}&city_id={$city_id}")}' title='{t domain="adsense"}编辑{/t}'>{t domain="adsense"}编辑{/t}</a>&nbsp;|&nbsp;
					    	<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg='{t domain="adsense"}您确定要删除吗？{/t}' href='{RC_Uri::url("adsense/admin_position/remove", "id={$val.position_id}")}' title='{t domain="adsense"}删除{/t}'>{t domain="adsense"}删除{/t}</a>
						</div>
				    </td>
				    <td><span>{if $val.position_code}{$val.position_code}{else}<i><无></i>{/if}</span></td>
				    <td><span>{$val.position_desc}</span></td>
				    <td><span>{$val.ad_width} x {$val.ad_height}</span></td>
				    <td><span class="edit_sort cursor_pointer" data-trigger="editable" data-url='{RC_Uri::url("adsense/admin_position/edit_sort", "city_id={$city_id}")}' data-name="sort_order" data-pk="{$val.position_id}" data-title='{t domain="adsense"}排序{/t}'>{$val.sort_order}</span></td>
				    <td>
					   	<a class="data-pjax" href='{RC_Uri::url("adsense/admin/init", "position_id={$val.position_id}&city_id={$city_id}")}' title='{t domain="adsense"}查看广告{/t}'><button class="btn">{t domain="adsense"}查看广告{/t}</button></a>
				    </td>
				</tr>
				<!-- {foreachelse} -->
                <tr><td class="no-records" colspan="7">{t domain="adsense"}没有找到任何记录{/t}</td></tr>
                <!-- {/foreach} -->
            </tbody>
		</table>
		<!-- {$position_list.page} -->
	</div>
</div>
<!-- {/block} -->