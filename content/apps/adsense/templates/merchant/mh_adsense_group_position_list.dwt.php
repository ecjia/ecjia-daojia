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
		<strong>{t domain="adsense"}温馨提示：{/t}</strong>{t domain="adsense"}请您先启用广告组。{/t}
	</div>
{/if}
<div class="row" >
    <div class="col-lg-12">
        <div class="tab-content">
            <div class="panel">
                <div class="panel-body">
                	<div class="col-lg-3">
						<div class="setting-group">
					        <span class="setting-group-title"><i class="fa fa-gear"></i> {t domain="adsense"}广告组{/t}</span>
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
								<!-- {if $ur_here}{$ur_here}{/if} --><font style="color: #999;">{t domain="adsense"}（拖拽列表可排序）{/t}</font>
								<div class="pull-right"  data-url='{RC_Uri::url("adsense/mh_group/update_sort")}'>
								{if $cycimage_config}
									<a id="ajaxstart" href='{RC_Uri::url("adsense/mh_group/insert")}' class="btn btn-primary" title='{t domain="adsense"}启用{/t}'><i class="fa fa-check-square-o"></i> {t domain="adsense"}启用广告组{/t}</a>
								{else}
									<a data-toggle="ajaxremove" class="ajaxremove btn btn-primary"  data-msg='{t domain="adsense"}您要关闭该广告组么？{/t}'  href='{RC_Uri::url("adsense/mh_group/remove","position_id={$position_id}")}' title='{t domain="adsense"}关闭{/t}'><i class="fa fa-minus-square"></i> {t domain="adsense"}关闭广告组{/t}</a>
								{/if}
								</div>
							</h2>
							
							<section class="panel">
								<table class="table table-striped" id="sort">
									<thead>
										<tr data-sorthref='{url path="adsense/mh_group/init" args="position_id={$position_id}"}'>
										 	<th class="w50">{t domain="adsense"}编号{/t}</th>
							                <th class="w200">{t domain="adsense"}广告位名称{/t}</th>
							                <th class="w130">{t domain="adsense"}广告位代号{/t}</th>
							                <th>{t domain="adsense"}广告位描述{/t}</th>
										    <th class="index w100" data-toggle="sortby" data-sortby="sort_order">{t domain="adsense"}排序{/t}</th>
										    <th class="w80">{t domain="adsense"}查看{/t}</th>
						                </tr>
									</thead>
									<tbody>
						            	<!-- {foreach from=$data_position item=val} -->
										<tr>
											<td class="position_id"><span>{$val.position_id}</span></td>
										    <td><span>{$val.position_name}</span></td>
										    <td><span>{if $val.position_code}{$val.position_code}{else}<i><无></i>{/if}</span></td>
										    <td><span>{$val.position_desc}</span></td>
										    <td class="position_sort index"><span class="edit_sort cursor_pointer" data-trigger="editable" data-url='{RC_Uri::url("adsense/mh_position/edit_sort", "group_position_id={$position_id}")}' data-name="sort_order" data-pk="{$val.position_id}" data-title='{t domain="adsense"}排序{/t}'>{$val.sort_order}</span></td>
										    <td>
											   	<a class="data-pjax" href='{RC_Uri::url("adsense/mh_ad/init", "position_id={$val.position_id}")}' title='{t domain="adsense"}查看广告{/t}'><button class="btn btn-primary screen-btn">{t domain="adsense"}查看广告{/t}</button></a>
										    </td>
										</tr>
										<!-- {foreachelse} -->
						                <tr><td class="no-records" colspan="7">{t domain="adsense"}没有找到任何记录{/t}</td></tr>
						                <!-- {/foreach} -->
						            </tbody>
								</table>
							</section>
							{if !$cycimage_config}
								<a href='{RC_Uri::url("adsense/mh_group/constitute","position_id={$position_id}")}' class="btn btn-primary data-pjax"><i class="fa fa-plus"></i> {t domain="adsense"}编排广告位{/t}</a>
							{/if}
						</div>
					</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- {/block} -->