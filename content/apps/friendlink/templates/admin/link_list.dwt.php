<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.list.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
 		{if $ur_here}{$ur_here}{/if}
        {if $action_link}
		<a href="{$action_link.href}" class="btn data-pjax plus_or_reply" ><i class="fontello-icon-plus"></i>{$action_link.text}</a>
		{/if}
   	</h3>
</div>

<div class="row-fluid">
	<div class="btn-group f_l m_r5">
		<a class="btn dropdown-toggle" data-toggle="dropdown" href="">
			<i class="fontello-icon-cog"></i>{lang key='friendlink::friend_link.batch_handle'}
			<span class="caret"></span>
		</a>
		<ul class="dropdown-menu">
			<li><a data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{$form_action}&type=remove" data-msg="{lang key='friendlink::friend_link.batch_drop_confirm'}" data-noSelectMsg="{lang key='friendlink::friend_link.select_drop_link'}" href="javascript:;"><i class="fontello-icon-trash"></i>{lang key='system::system.drop'}</a></li>
		</ul>
	</div>

	<!-- 搜索 -->
	<form class="f_r form-inline" method="post" action="{$search_action}" name="searchForm">
		<div class="choose_list f_r" >
			<input type="text" name="keywords" value="{$list.filter.keywords}" placeholder="{lang key='friendlink::friend_link.link_keywords'}"/>
			<button class="btn search_friendlink" type="button">{lang key='friendlink::friend_link.search'}</button>
		</div>
	</form>
</div>

<div class="row-fluid">
	<div class="span12">
		<form method="POST" action="{$form_action}" name="listForm" data-pjax-url="{RC_Uri::url('adsense/admin/init')}">
			<table class="table table-striped smpl_tbl dataTable table-hide-edit"  >
                <thead>
                    <tr>
                    	<th class="table_checkbox"><input type="checkbox" data-toggle="selectall" data-children=".checkbox"/></th>
                    	<th class="w130">{lang key='friendlink::friend_link.link_logo'}</th>
                        <th class="w150">{lang key='friendlink::friend_link.link_name'}</th>
					    <th>{lang key='friendlink::friend_link.link_url'}</th>
					    <th class="w70">{lang key='friendlink::friend_link.show_order'}</th>
                    </tr>
                </thead>
                <tbody>
                 	<!-- {foreach from=$list.list item=link} -->
                    <tr>
                    	<td class="center-td">
				      		<input class="checkbox" type="checkbox" name="checkboxes[]" value="{$link.link_id}" />
				    	</td>
				    	<td><span>{$link.link_logo_html}</span></td>
                      	<td class="hide-edit-area hide_edit_area_bottom">
                      		<span class="cursor_pointer" data-text="text" data-trigger="editable" data-url="{RC_Uri::url('friendlink/admin/edit_link_name')}" data-name="link_name" data-pk="{$link.link_id}" data-title="{lang key='friendlink::friend_link.edit_link_name'}" >{$link.link_name}</span>
                      		<br>
                      		<div class="edit-list">
							    <a class="data-pjax" href='{RC_Uri::url("friendlink/admin/edit", "id={$link.link_id}")}' title="{lang key='system::system.edit'}">{lang key='system::system.edit'}</a>&nbsp;|&nbsp;
						    	<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg="{lang key='friendlink::friend_link.drop_confirm'}" href='{RC_Uri::url("friendlink/admin/remove","id={$link.link_id}")}' title="{lang key='system::system.drop'}">{lang key='system::system.drop'}</a>
							</div>
                      	</td>
					    <td><span><a href="{$link.link_url}" target="_blank">{$link.link_url}</a></span></td>
					    <td>
                        	<span class="cursor_pointer" data-placement="left" data-text="text" data-trigger="editable" data-url="{RC_Uri::url('friendlink/admin/edit_show_order')}" data-name="show_order" data-pk="{$link.link_id}" data-title="{lang key='friendlink::friend_link.edit_order'}" >{$link.show_order}</span>
                  		</td>
                    </tr>
					<!-- {foreachelse} -->
				    <tr><td class="no-records" colspan="10">{lang key='system::system.no_records'}</td></tr>
			    	<!-- {/foreach} -->
	            </tbody>
			</table>
        	<!-- {$list.page} -->
    	</form>
    </div>
</div>
<!-- {/block} -->