<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.topic_list.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		{if $action_link}
		<a class="btn plus_or_reply data-pjax" href="{$action_link.href}" id="sticky_a"><i class="fontello-icon-plus"></i>{$action_link.text}</a>
		{/if}
	</h3>
</div>
	<!-- 批量操作和搜索 -->
<div class="row-fluid batch" >
	<form method="post" action="{$search_action}" name="searchForm">
		<div class="btn-group f_l m_r5">
			<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
				<i class="fontello-icon-cog"></i>{t domain="topic"}批量操作{/t}
				<span class="caret"></span>
			</a>
			<ul class="dropdown-menu">
				<li><a class="button_remove" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{url path='topic/admin/batch'}" data-msg='{t domain="topic"}您确定要这么做吗？{/t}' data-noSelectMsg='{t domain="topic"}请先选中要删除的专题{/t}' data-name="topic_id" href="javascript:;"><i class="fontello-icon-trash"></i>{t domain="topic"}删除专题{/t}</a></li>
			</ul>
		</div>
		<div class="choose_list f_r" >
			<input type="text" name="keywords" value="{$topic_list.filter.keywords}" placeholder="{t domain="topic"}请输入专题名称{/t}"/>
			<button class="btn search_topic" type="button">{t domain="topic"}搜索{/t}</button>
		</div>
	</form>
</div>

<div class="row-fluid">
	<div class="span12">
		<table class="table table-striped smpl_tbl dataTable table-hide-edit">
			<thead>
				<tr>
					<th class="table_checkbox"><input type="checkbox" name="select_rows" data-toggle="selectall" data-children=".checkbox"/></th>
                	<th>{t domain="topic"}专题名称{/t}</th>
			    	<th class="w150">{t domain="topic"}活动开始时间{/t}</th>
			    	<th class="w150">{t domain="topic"}活动结束时间{/t}</th>
                </tr>
		  	</thead>
			<tbody>
            	<!-- {foreach from=$topic_list.topic item=topic} -->
			    <tr>
				    <td>
				        <span><input type="checkbox" name="checkboxes[]" class="checkbox" value="{$topic.topic_id}"/></span>
				    </td>
				    <td class="hide-edit-area">
				    	 <span class="cursor_pointer" data-text="text" data-trigger="editable" 
				    	 data-url="{RC_Uri::url('topic/admin/edit_title')}" data-name="title" data-pk="{$topic.topic_id}" data-title='{t domain="topic"}编辑专题名称{/t}' >{$topic.title}</span>
				    	 <div class="edit-list">
					      	<a href='{RC_Uri::url("topic/admin/preview", "id={$topic.topic_id}")}' title='{t domain="topic"}预览{/t}'  target="_blank" >{t domain="topic"}预览{/t}</a>&nbsp;|&nbsp;
					      	<a class="data-pjax" href='{RC_Uri::url("topic/admin/edit","id={$topic.topic_id}")}' title='{t domain="topic"}编辑{/t}'>{t domain="topic"}编辑{/t}</a>&nbsp;|&nbsp;
					      	<a class="data-pjax" href='{url path="topic/admin/topic_cat" args="id={$topic.topic_id}"}' title='{t domain="topic"}专题分类{/t}'>{t domain="topic"}专题分类{/t}</a>&nbsp;|&nbsp;
					      	<a class="data-pjax" href='{url path="topic/admin/topic_goods" args="id={$topic.topic_id}"}' title='{t domain="topic"}专题商品{/t}'>{t domain="topic"}专题商品{/t}</a>&nbsp;|&nbsp;
						    <a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg='{t domain="topic"}确定删除选中项吗?{/t}' href='{RC_Uri::url("topic/admin/remove", "id={$topic.topic_id}")}' title="{t domain="topic"}删除{/t}">{t domain="topic"}删除{/t}</a>
					     </div>
					</td>
				    <td>{$topic.start_time}</td>
				    <td>{$topic.end_time}</td>
			    </tr>
		   	 	<!-- {foreachelse} -->
                <tr><td class="no-records" colspan="10">{t domain="topic"}没有找到任何记录{/t}</td></tr>
                <!-- {/foreach} -->
            </tbody>
		</table>
		<!-- {$topic_list.page} -->
	</div>
</div>
<!-- {/block} -->