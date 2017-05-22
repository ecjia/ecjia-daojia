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
            <h3>广告位信息</h3>
            <ul>
                <li><div class="detail"><strong>广告位名称：</strong><span>{$position_data.position_name}{if $position_data.position_code}（{$position_data.position_code}）{else}（无）{/if}</span></div></li>
                <li><div class="detail"><strong>所在城市：</strong><span>{$position_data.city_name}</span></div></li>
                <li><div class="detail"><strong>显示数量：</strong><span>{$position_data.max_number}</span></div></li>
                <li><div class="detail"><strong>建议大小：</strong><span>{$position_data.ad_width} x {$position_data.ad_height}</span><p class="f_r"><a href='{url path="adsense/admin_position/edit" args="position_id={$position_id}"}'>快速进入广告位 >></a></p></div></li>
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
		<li class="{if $show_client eq $client_list.$key}active{/if}"><a class="data-pjax" href='{url path="adsense/admin/init" args="show_client={$client_list.$key}&position_id={$position_id}&media_type={$media_type}"}'>{if $key === 0}未选择{else}{$key}{/if}<span class="badge badge-info">{$val}</span></a></li>
		<!-- {/foreach} -->
		<!-- {/if} -->
		<form class="f_r form-inline"  method="post" action="{$search_action}" name="searchForm">
			<select name="media_type" id="media_type" class="no_search w150">
			    <option value='-1'  {if $smarty.get.media_type eq '-1' } selected="true" {/if}>{lang key='adsense::adsense.choose_media_type'}</option>
				<option value='0' {if $smarty.get.media_type eq '0'} selected="true" {/if}>{lang key='adsense::adsense.ad_img'}</option>
				<option value='2' {if $smarty.get.media_type eq '2'} selected="true" {/if}>{lang key='adsense::adsense.ad_html'}</option>
				<option value='3' {if $smarty.get.media_type eq '3'} selected="true" {/if}>{lang key='adsense::adsense.ad_text'}</option>
			</select>
			<input type="hidden" value="{$position_id}" name="position_id" />
			<input type="hidden" value="{$show_client}" name="show_client" />
			<a class="btn m_l5 screen-btn">{lang key='adsense::adsense.filter'}</a>
		</form>
	</ul>
</div>

<div class="row-fluid">
	<div class="span12">
		<table class="table table-striped smpl_tbl dataTable table-hide-edit" id="smpl_tbl">
			<thead>
				<tr>
				    <th class="w100">{lang key='adsense::adsense.ad_id'}</th>
                	<th>{lang key='adsense::adsense.ad_name'}</th>
			    	<th class="w100">{lang key='adsense::adsense.media_type'}</th>
			    	<th class="w100">{lang key='adsense::adsense.start_date'}</th>
			    	<th class="w100">{lang key='adsense::adsense.end_date'}</th>
			    	<th class="w100">是否开启</th>
			    	<th class="w50">排序</th>
                </tr>
			</thead>
			<tbody>
                <!-- {foreach from=$ads_list item=list} -->
                <tr>
                   <td> 
                    	<span>{$list.ad_id}</span>
                    </td>
                    <td class="hide-edit-area hide_edit_area_bottom">
					    <span class="cursor_pointer" data-text="text"data-trigger="editable" data-url="{RC_Uri::url('adsense/admin/edit_ad_name')}" data-name="ad_name" data-pk="{$list.ad_id}" data-title="{lang key='adsense::adsense.edit_ad_name'}">
					    	{$list.ad_name}
					    </span>
					    
					    <span>
						    {if $list.ad_code and $list.media_type eq 0}
							    <a tabindex="0" role="button" href="javascript:;" class="no-underline cursor_pointor" data-id="{$list.ad_id}" data-trigger="focus" data-toggle="popover" data-placement="top" title="{$list.ad_name}">（预览）</a>
							    <div class="hide" id="content_{$list.ad_id}"><img class="mh150" src="{RC_Upload::upload_url()}/{$list.ad_code}"></div> 
						    {/if}
					    </span>
					    
				    	<div class="edit-list">
					      	<a class="data-pjax" href='{RC_Uri::url("adsense/admin/edit", "ad_id={$list.ad_id}&position_id={$position_id}&show_client={$show_client}")}' title="{lang key='system::navigator.edit'}">{lang key='adsense::adsense.edit'}</a>&nbsp;|&nbsp;
				      		<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg="{lang key='adsense::adsense.confirm_remove'}" href='{RC_Uri::url("adsense/admin/remove","ad_id={$list.ad_id}")}' title="{lang key='adsense::adsense.remove'}">{lang key='adsense::adsense.remove'}</a>
						</div>
				    </td>
				    <td>{if $list.media_type eq 0}图片{elseif $list.media_type eq 2}代码{else}文字{/if}</td>
				    <td>{$list.start_time}</td>
				    <td>{$list.end_time}</td>
				    <td>
				    	<i class="{if $list.enabled eq '1'}fontello-icon-ok cursor_pointer{else}fontello-icon-cancel cursor_pointer{/if}" data-trigger="toggleState" data-url='{RC_Uri::url("adsense/admin/toggle_show","position_id={$position_id}&city_id={$city_id}&show_client={$show_client}")}' data-id="{$list.ad_id}" ></i>
					</td>
					<td><span class="edit_sort cursor_pointer" data-trigger="editable" data-url='{RC_Uri::url("adsense/admin/edit_sort", "position_id={$position_id}&show_client={$show_client}")}' data-name="sort_order" data-pk="{$list.ad_id}" data-title="排序">{$list.sort_order}</span></td>
                </tr>
                <!-- {foreachelse} -->
                <tr><td class="no-records" colspan="7">{lang key='system::system.no_records'}</td></tr>
                <!-- {/foreach} -->
            </tbody>
     	</table>
	   <!-- {$ads_list.page} -->
	</div>
</div>
<!-- {/block} -->