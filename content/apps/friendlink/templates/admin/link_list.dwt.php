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
			<i class="fontello-icon-cog"></i>{t domain="friendlink"}批量操作{/t}
			<span class="caret"></span>
		</a>
		<ul class="dropdown-menu">
			<li><a data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{$form_action}&type=remove" data-msg='{t domain="friendlink"}您确定要删除选中的友情链接吗？{/t}' data-noSelectMsg='{t domain="friendlink"}请选择要删除的友情链接{/t}' href="javascript:;"><i class="fontello-icon-trash"></i>{t}删除{/t}</a></li>
		</ul>
	</div>

	<!-- 搜索 -->
	<form class="f_r form-inline" method="post" action="{$search_action}" name="searchForm">
		<div class="choose_list f_r" >
			<input type="text" name="keywords" value="{$list.filter.keywords}" placeholder="{lang key='friendlink::friend_link.link_keywords'}"/>
			<button class="btn search_friendlink" type="button">{t domain="friendlink"}搜索{/t}</button>
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
                    	<th class="w130">{t domain="friendlink"}链接LOGO{/t}</th>
                        <th class="w150">{t domain="friendlink"}链接名称{/t}</th>
					    <th>{t domain="friendlink"}链接地址{/t}</th>
					    <th class="w70">{t domain="friendlink"}排序{/t}</th>
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
                      		<span class="cursor_pointer" data-text="text" data-trigger="editable" data-url="{RC_Uri::url('friendlink/admin/edit_link_name')}" data-name="link_name" data-pk="{$link.link_id}" data-title='{t domain="friendlink"}编辑链接名称{/t}' >{$link.link_name}</span>
                      		<br>
                      		<div class="edit-list">
							    <a class="data-pjax" href='{RC_Uri::url("friendlink/admin/edit", "id={$link.link_id}")}' title="{lang key='system::system.edit'}">{t}编辑{/t}</a>&nbsp;|&nbsp;
						    	<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg='{t domain="friendlink"}您确定要删除该友情链接吗？{/t}' href='{RC_Uri::url("friendlink/admin/remove","id={$link.link_id}")}' title="{lang key='system::system.drop'}">{t}删除{/t}</a>
							</div>
                      	</td>
					    <td><span><a href="{$link.link_url}" target="_blank">{$link.link_url}</a></span></td>
					    <td>
                        	<span class="cursor_pointer" data-placement="left" data-text="text" data-trigger="editable" data-url="{RC_Uri::url('friendlink/admin/edit_show_order')}" data-name="show_order" data-pk="{$link.link_id}" data-title='{t domain="friendlink"}编辑排序{/t}' >{$link.show_order}</span>
                  		</td>
                    </tr>
					<!-- {foreachelse} -->
				    <tr><td class="no-records" colspan="10">{t}没有找到任何记录{/t}</td></tr>
			    	<!-- {/foreach} -->
	            </tbody>
			</table>
        	<!-- {$list.page} -->
    	</form>
    </div>
</div>
<!-- {/block} -->