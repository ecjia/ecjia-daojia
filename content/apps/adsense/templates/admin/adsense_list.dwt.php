<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.adsense_list.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
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

<!-- 搜索 -->
<div class="row-fluid batch">
	<form method="post" action="{$search_action}" name="searchForm">
		<select name="media_type" id="media_type" class="no_search w150">
		    <option value=''  {if $ads_list.filter.media_type eq '' } selected="true" {/if}>{lang key='adsense::adsense.choose_media_type'}</option>
			<option value='0' {if $ads_list.filter.media_type eq '0'} selected="true" {/if}>{lang key='adsense::adsense.ad_img'}</option>
			<option value='1' {if $ads_list.filter.media_type eq '1'} selected="true" {/if}>{lang key='adsense::adsense.ad_flash'}</option>
			<option value='2' {if $ads_list.filter.media_type eq '2'} selected="true" {/if}>{lang key='adsense::adsense.ad_html'}</option>
			<option value='3' {if $ads_list.filter.media_type eq '3'} selected="true" {/if}>{lang key='adsense::adsense.ad_text'}</option>
		</select>
		<a class="btn m_l5 screen-btn">{lang key='adsense::adsense.filter'}</a>
		
		<div class="choose_list f_r" >
			<input type="text" name="keywords" value="{$ads_list.filter.keywords}" placeholder="{lang key='adsense::adsense.ad_name_empty'}"/>
			<button class="btn search_ad" type="button">{lang key='adsense::adsense.search'}</button>
		</div>
	</form>
</div>

<div class="row-fluid">
	<div class="span12">
		<table class="table table-striped smpl_tbl dataTable table-hide-edit" id="smpl_tbl">
			<thead>
				<tr>
				    <th class="w35">{lang key='adsense::adsense.ad_id'}</th>
                	<th>{lang key='adsense::adsense.ad_name'}</th>
			    	<th class="w200">{lang key='adsense::adsense.position_id'}</th>
			    	<th class="w70">{lang key='adsense::adsense.media_type'}</th>
			    	<th class="w100">{lang key='adsense::adsense.start_date'}</th>
			    	<th class="w100">{lang key='adsense::adsense.end_date'}</th>
			    	<th class="w80">{lang key='adsense::adsense.click_count'}</th>
                </tr>
			</thead>
			<tbody>
                <!-- {foreach from=$ads_list.item item=list}-->
                <tr>
                   <td> 
                    	<span>{$list.ad_id}</span>
                    </td>
                    <td class="hide-edit-area hide_edit_area_bottom">
					    <span class="cursor_pointer" data-text="text"data-trigger="editable" data-url="{RC_Uri::url('adsense/admin/edit_ad_name')}" data-name="ad_name" data-pk="{$list.ad_id}" data-title="{lang key='adsense::adsense.edit_ad_name'}">
					    {$list.ad_name}
					    </span>
					    
					    <span>
					    {if $list.image}
					    <a tabindex="0" role="button" href="javascript:;" class="no-underline cursor_pointor" data-id="{$list.ad_id}" data-trigger="focus" data-toggle="popover" data-placement="top" title="{$list.ad_name}">{lang key='adsense::adsense.preview_image'}</a>
					    <div class="hide" id="content_{$list.ad_id}"><img class="mh150" src="{$list.image}"></div> 
					    {/if}
					    </span>
					    
				    	<div class="edit-list">
							{if $list.position_id eq 0}
					      	<a class="data-pjax" href='{RC_Uri::url("adsense/admin/add_js", "type={$list.media_type}&id={$list.ad_id}")}' title="{lang key='adsense::adsense.add_js_code_btn'}">{lang key='adsense::adsense.add_js_code_btn'}</a>&nbsp;|&nbsp;
					      	{/if}
					      	<a class="data-pjax" href='{RC_Uri::url("adsense/admin/edit", "id={$list.ad_id}")}' title="{lang key='system::navigator.edit'}">{lang key='adsense::adsense.edit'}</a>&nbsp;|&nbsp;
				      		<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg="{lang key='adsense::adsense.confirm_remove'}" href='{RC_Uri::url("adsense/admin/remove","id={$list.ad_id}")}' title="{lang key='adsense::adsense.remove'}">{lang key='adsense::adsense.remove'}</a>
						</div>
				    </td>
				    <td>
					    <span>
					    {if $list.position_id eq 0}
					    {lang key='adsense::adsense.outside_posit'}
					    {else}
					    {$list.position_name}
					    {/if}</span>
				    </td>
				    <td><span>{$list.type}</span></td>
				    <td><span>{$list.start_date}</span></td>
				    <td><span>{$list.end_date}</span></td>
				    <td><span>{$list.click_count}</span></td>
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