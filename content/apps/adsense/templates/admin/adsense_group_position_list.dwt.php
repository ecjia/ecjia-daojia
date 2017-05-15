<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
$(document).ready(function(){
	  	var fixHelperModified = function(e, tr) {
	     var $originals = tr.children();
	     var $helper = tr.clone();
	     $helper.children().each(function(index) {
	      	$(this).width($originals.eq(index).width())
	     });
	     return $helper;
	    },
	    
	    updateIndex = function(e, ui) {
		     $('td.index', ui.item.parent()).each(function (i) {
		      	$(this).html(i + 1);
		     });

		      	var url = $('.position_detail').attr('data-url');
				var info = {literal}{'position_array' : []}{/literal};
		
				$('tbody tr').each(function (index){
					var position_id = $('tbody tr').eq(index).find('.position_id').text();
					var position_sort = $('tbody tr').eq(index).find('.position_sort').text();
					info.position_array.push({
						'position_id': position_id,
						'position_sort': position_sort
					});
				});
				
				$.get(url, info, function(data) {
					ecjia.admin.showmessage(data);
				});
	    };
	    
		  $("#sort tbody").sortable({
			   helper: fixHelperModified,
			   stop: updateIndex
		  }).disableSelection();
});
</script>
<style>
tr{
 	cursor: pointer;
}
</style>

<!-- {/block} -->

<!-- {block name="main_content"} -->
<div class="row-fluid">
     <div class="span12">
         <div class="position_detail" data-url='{RC_Uri::url("adsense/admin_group/update_sort")}'>
            <h3>广告组信息</h3>
            <ul>
                <li><div class="detail"><strong>广告组名称：</strong><span>{$position_data.position_name}{if $position_data.position_code}（{$position_data.position_code}）{else}（无）{/if}</span></div></li>
                <li>
                	<div class="detail">
		                <strong>所在城市：</strong><span>{$position_data.city_name}</span>
		                <p class="f_r"> 
			               <a class="data-pjax ecjiafc-gray" href='{RC_Uri::url("adsense/admin_group/edit", "position_id={$position_data.position_id}&city_id={$city_id}")}'><i class="fontello-icon-edit"></i>编辑广告组</a>&nbsp;|&nbsp;
			               <a class="ajaxremove ecjiafc-gray" data-toggle="ajaxremove" data-msg="你确定要删除该广告组吗？" href='{RC_Uri::url("adsense/admin_group/remove", "group_position_id={$position_data.position_id}&city_id={$city_id}")}' title="删除"><i class="fontello-icon-trash"></i>删除广告组</a>
		                </p>
	                </div>
                </li>
            </ul>
          </div>
     </div>		
</div>

<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} --><span class="muted">（拖拽列表可排序）</span>
		{if $action_link}
		<a href="{$action_link.href}" class="btn plus_or_reply data-pjax" id="sticky_a"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		{/if}
		
		{if $edit_action_link}
		<a href="{$edit_action_link.href}" class="btn plus_or_reply data-pjax" id="sticky_a"><i class="fontello-icon-plus"></i>{$edit_action_link.text}</a>
		{/if}
	</h3>
</div>

<div class="row-fluid">
	<div class="span12">
		<table class="table table-striped" id="sort">
			<thead>
				<tr data-sorthref='{url path="adsense/admin_group/group_position_list" args="city_id={$city_id}&position_id={$position_id}"}'>
				 	<th class="w50">编号</th>
	                <th class="w200">广告位名称</th>
	                <th class="w130">广告位代号</th>
	                <th>广告位描述</th>
				    <th class="index w100" data-toggle="sortby" data-sortby="sort_order">排序</th>
				    <th class="w80">查看</th>
                </tr>
			</thead>
			<tbody>
            	<!-- {foreach from=$data item=val} -->
				<tr>
					<td class="position_id"><span>{$val.position_id}</span></td>
				    <td><span>{$val.position_name}</span></td>
				    <td><span>{if $val.position_code}{$val.position_code}{else}<i><无></i>{/if}</span></td>
				    <td><span>{$val.position_desc}</span></td>
				    <td class="position_sort index"><span class="edit_sort cursor_pointer" data-trigger="editable" data-url='{RC_Uri::url("adsense/admin_position/edit_sort", "city_id={$city_id}&group_position_id={$position_id}")}' data-name="sort_order" data-pk="{$val.position_id}" data-title="排序">{$val.sort_order}</span></td>
				    <td>
					   	<a class="data-pjax" href='{RC_Uri::url("adsense/admin/init", "position_id={$val.position_id}&city_id={$city_id}")}' title="查看广告"><button class="btn">查看广告</button></a>
				    </td>
				</tr>
				<!-- {foreachelse} -->
                <tr><td class="no-records" colspan="7">{lang key='system::system.no_records'}</td></tr>
                <!-- {/foreach} -->
            </tbody>
		</table>
		<!-- {$position_list.page} -->
	</div>
</div>
<!-- {/block} -->