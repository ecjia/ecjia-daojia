<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.adsense_list.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->

<div class="row-fluid">
     <div class="span12">
         <div class="position_detail">
            <h3>{t domain="adsense"}广告位信息{/t}</h3>
            <ul>
                <li><div class="detail"><strong>{t domain="adsense"}广告位名称：{/t}</strong><span>{$position_data.position_name}{if $position_data.position_code}（{$position_data.position_code}）{else}（无）{/if}</span></div></li>
                <li><div class="detail"><strong>{t domain="adsense"}所在城市：{/t}</strong><span>{$position_data.city_name}</span></div></li>
                <li><div class="detail"><strong>{t domain="adsense"}显示数量：{/t}</strong><span>{$position_data.max_number}</span></div></li>
                <li><div class="detail"><strong>{t domain="adsense"}建议大小：{/t}</strong><span>{$position_data.ad_width} x {$position_data.ad_height}</span><p class="f_r"><a href='{url path="adsense/admin_position/edit" args="position_id={$position_id}"}'>{t domain="adsense"}快速进入广告位{/t} >></a></p></div></li>
            </ul>
          </div>
     </div>		
</div>

<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		{if $action_link}
			<a class="btn plus_or_reply data-pjax" href="{$action_link.href}" id="sticky_a"><i class="fontello-icon-plus"></i>{$action_link.text}</a>
		{/if}
		
		{if $back_position_list}
        	<a class="btn plus_or_reply data-pjax" href="{$back_position_list.href}" id="sticky_a"><i class="fontello-icon-reply"></i>{$back_position_list.text}</a>
        {/if}
	</h3>
</div>

<div> 
	<ul class="nav nav-pills">
	<!-- {if $available_clients} -->
 		<!-- {foreach from=$available_clients key=key item=val} -->
		<li class="{if $show_client eq $client_list.$key}active{/if}"><a class="data-pjax" href='{url path="adsense/admin/init" args="show_client={$client_list.$key}&position_id={$position_id}&media_type={$media_type}"}'>{if $key === 0}{t domain="adsense"}未选择{/t}{else}{$key}{/if}<span class="badge badge-info">{$val}</span></a></li>
		<!-- {/foreach} -->
		<!-- {/if} -->
		<form class="f_r form-inline"  method="post" action="{$search_action}" name="searchForm">
			<select name="media_type" id="media_type" class="no_search w150">
			    <option value='-1'  {if $smarty.get.media_type eq '-1' } selected="true" {/if}>{t domain="adsense"}请选择媒介类型{/t}</option>
				<option value='0' {if $smarty.get.media_type eq '0'} selected="true" {/if}>{t domain="adsense"}图片{/t}</option>
				<option value='2' {if $smarty.get.media_type eq '2'} selected="true" {/if}>{t domain="adsense"}代码{/t}</option>
				<option value='3' {if $smarty.get.media_type eq '3'} selected="true" {/if}>{t domain="adsense"}文字{/t}</option>
			</select>
			<input type="hidden" value="{$position_id}" name="position_id" />
			<input type="hidden" value="{$show_client}" name="show_client" />
			<a class="btn m_l5 screen-btn">{t domain="adsense"}筛选{/t}</a>
		</form>
	</ul>
</div>

<div class="row-fluid">
	<div class="span12">
		<table class="table table-striped smpl_tbl dataTable table-hide-edit" id="smpl_tbl">
			<thead>
				<tr>
				    <th class="w100">{t domain="adsense"}编号{/t}</th>
                	<th>{t domain="adsense"}广告名称{/t}</th>
			    	<th class="w100">{t domain="adsense"}媒介类型{/t}</th>
			    	<th class="w100">{t domain="adsense"}开始日期{/t}</th>
			    	<th class="w100">{t domain="adsense"}结束日期{/t}</th>
			    	<th class="w100">{t domain="adsense"}是否开启{/t}</th>
			    	<th class="w50">{t domain="adsense"}排序{/t}</th>
                </tr>
			</thead>
			<tbody>
                <!-- {foreach from=$ads_list item=list} -->
                <tr>
                   <td> 
                    	<span>{$list.ad_id}</span>
                    </td>
                    <td class="hide-edit-area hide_edit_area_bottom">
					    <span class="cursor_pointer" data-text="text"data-trigger="editable" data-url="{RC_Uri::url('adsense/admin/edit_ad_name')}" data-name="ad_name" data-pk="{$list.ad_id}" data-title='{t domain="adsense"}编辑广告名称{/t}'>
					    	{$list.ad_name}
					    </span>
					    
					    <span>
						    {if $list.ad_code and $list.media_type eq 0}
							    <a tabindex="0" role="button" href="javascript:;" class="no-underline cursor_pointor" data-id="{$list.ad_id}" data-trigger="focus" data-toggle="popover" data-placement="top" title="{$list.ad_name}">{t domain="adsense"}（预览）{/t}</a>
							    <div class="hide" id="content_{$list.ad_id}"><img class="mh150" src="{RC_Upload::upload_url()}/{$list.ad_code}"></div> 
						    {/if}
					    </span>
					    
				    	<div class="edit-list">
					      	<a class="data-pjax" href='{RC_Uri::url("adsense/admin/edit", "ad_id={$list.ad_id}&position_id={$position_id}&show_client={$show_client}")}' title='{t domain="adsense"}编辑{/t}'>{t domain="adsense"}编辑{/t}</a>&nbsp;|&nbsp;
				      		<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg='{t domain="adsense"}您确定要删除吗？{/t}' href='{RC_Uri::url("adsense/admin/remove","ad_id={$list.ad_id}")}' title='{t domain="adsense"}删除{/t}'>{t domain="adsense"}删除{/t}</a>
						</div>
				    </td>
				    <td>{if $list.media_type eq 0}{t domain="adsense"}图片{/t}{elseif $list.media_type eq 2}{t domain="adsense"}代码{/t}{else}{t domain="adsense"}文字{/t}{/if}</td>
				    <td>{$list.start_time}</td>
				    <td>{$list.end_time}</td>
				    <td>
				    	<i class="{if $list.enabled eq '1'}fontello-icon-ok cursor_pointer{else}fontello-icon-cancel cursor_pointer{/if}" data-trigger="toggleState" data-url='{RC_Uri::url("adsense/admin/toggle_show","position_id={$position_id}&city_id={$city_id}&show_client={$show_client}")}' data-id="{$list.ad_id}" ></i>
					</td>
					<td><span class="edit_sort cursor_pointer" data-trigger="editable" data-url='{RC_Uri::url("adsense/admin/edit_sort", "position_id={$position_id}&show_client={$show_client}")}' data-name="sort_order" data-pk="{$list.ad_id}" data-title='{t domain="adsense"}排序{/t}'>{$list.sort_order}</span></td>
                </tr>
                <!-- {foreachelse} -->
                <tr><td class="no-records" colspan="7">{t domain="adsense"}没有找到任何记录{/t}</td></tr>
                <!-- {/foreach} -->
            </tbody>
     	</table>
	   <!-- {$ads_list.page} -->
	</div>
</div>
<!-- {/block} -->