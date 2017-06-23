<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!--{extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
ecjia.merchant.merhcant_group_list.init();

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

		      	var url = $('.pull-right').attr('data-url');
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
					ecjia.merchant.showmessage(data);
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

<!-- {block name="home-content"} -->
{if $cycimage_config}
	<div class="alert alert-info">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-times" data-original-title="" title=""></i></button>
		<strong>温馨提示：</strong>请您先启用广告组。
	</div>
{/if}
<div class="row" >
    <div class="col-lg-12">
        <div class="tab-content">
            <div class="panel">
                <div class="panel-body">
                	<div class="col-lg-3">
						<div class="setting-group">
					        <span class="setting-group-title"><i class="fa fa-gear"></i> 广告组</span>
					        <!-- {if $data} -->
					        <ul class="nav nav-list m_t10 change">
						        <!-- {foreach from=$data item=val} -->
						        	<li><a class="setting-group-item data-pjax {if $position_id eq $val.position_id}llv-active{/if}" href='{url path="adsense/mh_group/init" args="position_id={$val.position_id}"}'>{$val.position_name}</a></li>
						        <!-- {/foreach} -->
					        </ul>
					        <!-- {/if} -->
						</div>
					</div>
					
					<div class="col-lg-9">
						<div class="panel-body panel-body-small">
							<h2 class="page-header">
								<!-- {if $ur_here}{$ur_here}{/if} --><font style="color: #999;">（拖拽列表可排序）</font>
								<div class="pull-right"  data-url='{RC_Uri::url("adsense/mh_group/update_sort")}'>
								{if $cycimage_config}
									<a id="ajaxstart" href='{RC_Uri::url("adsense/mh_group/insert")}' class="btn btn-primary" title="启用"><i class="fa fa-check-square-o"></i> 启用广告组</a>
								{else}
									<a data-toggle="ajaxremove" class="ajaxremove btn btn-primary"  data-msg="您要关闭该广告组么？"  href='{RC_Uri::url("adsense/mh_group/remove","position_id={$position_id}")}' title="关闭"><i class="fa fa-minus-square"></i> 关闭广告组</a>
								{/if}
								</div>
							</h2>
							
							<section class="panel">
								<table class="table table-striped" id="sort">
									<thead>
										<tr data-sorthref='{url path="adsense/mh_group/init" args="position_id={$position_id}"}'>
										 	<th class="w50">编号</th>
							                <th class="w200">广告位名称</th>
							                <th class="w130">广告位代号</th>
							                <th>广告位描述</th>
										    <th class="index w100" data-toggle="sortby" data-sortby="sort_order">排序</th>
										    <th class="w80">查看</th>
						                </tr>
									</thead>
									<tbody>
						            	<!-- {foreach from=$data_position item=val} -->
										<tr>
											<td class="position_id"><span>{$val.position_id}</span></td>
										    <td><span>{$val.position_name}</span></td>
										    <td><span>{if $val.position_code}{$val.position_code}{else}<i><无></i>{/if}</span></td>
										    <td><span>{$val.position_desc}</span></td>
										    <td class="position_sort index"><span class="edit_sort cursor_pointer" data-trigger="editable" data-url='{RC_Uri::url("adsense/mh_position/edit_sort", "group_position_id={$position_id}")}' data-name="sort_order" data-pk="{$val.position_id}" data-title="排序">{$val.sort_order}</span></td>
										    <td>
											   	<a class="data-pjax" href='{RC_Uri::url("adsense/mh_ad/init", "position_id={$val.position_id}")}' title="查看广告"><button class="btn btn-primary screen-btn">查看广告</button></a>
										    </td>
										</tr>
										<!-- {foreachelse} -->
						                <tr><td class="no-records" colspan="7">{lang key='system::system.no_records'}</td></tr>
						                <!-- {/foreach} -->
						            </tbody>
								</table>
							</section>
							{if !$cycimage_config}
								<a href='{RC_Uri::url("adsense/mh_group/constitute","position_id={$position_id}")}' class="btn btn-primary data-pjax"><i class="fa fa-plus"></i> 编排广告位</a>	
							{/if}
						</div>
					</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- {/block} -->