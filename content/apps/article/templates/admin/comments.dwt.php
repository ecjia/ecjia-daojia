<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.comment_list.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a class="btn plus_or_reply data-pjax" href="{$action_link.href}"  id="sticky_a"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>

<ul class="nav nav-pills">
	<li class="{if !$smarty.get.type}active{/if}">
		<a class="data-pjax" href="{RC_Uri::url('article/admin/comments')}
			{if $id}&id={$id}{/if}{if $publishby}&publishby={$publishby}{/if}{if $filter.keywords}&keywords={$filter.keywords}{/if}">
			{t domain="article"}全部{/t}
			<span class="badge badge-info">{if $type_count.count}{$type_count.count}{else}0{/if}</span>
		</a>
	</li>
	<li class="{if $smarty.get.type eq 'has_checked'}active{/if}">
		<a class="data-pjax" href='{RC_Uri::url("article/admin/comments", "type=has_checked
			{if $id}&id={$id}{/if}{if $publishby}&publishby={$publishby}{/if}{if $filter.keywords}&keywords={$filter.keywords}{/if}")}'>
			{t domain="article"}通过审核{/t}
			<span class="badge badge-info use-plugins-num">{if $type_count.has_checked}{$type_count.has_checked}{else}0{/if}</span>
		</a>
	</li>
	<li class="{if $smarty.get.type eq 'wait_check'}active{/if}">	
		<a class="data-pjax" href='{RC_Uri::url("article/admin/comments", "type=wait_check
			{if $id}&id={$id}{/if}{if $publishby}&publishby={$publishby}{/if}{if $filter.keywords}&keywords={$filter.keywords}{/if}")}'>
			{t domain="article"}待审核{/t}
			<span class="badge badge-info unuse-plugins-num">{if $type_count.wait_check}{$type_count.wait_check}{else}0{/if}</span>
		</a>
	</li>
	<li class="{if $smarty.get.type eq 'rubbish_comments'}active{/if}">
		<a class="data-pjax" href='{RC_Uri::url("article/admin/comments", "type=rubbish_comments
			{if $id}&id={$id}{/if}{if $publishby}&publishby={$publishby}{/if}{if $filter.keywords}&keywords={$filter.keywords}{/if}")}'>
			{t domain="article"}垃圾评论{/t}
			<span class="badge badge-info unuse-plugins-num">{if $type_count.rubbish_comments}{$type_count.rubbish_comments}{else}0{/if}</span>
		</a>
	</li>
	<li class="{if $smarty.get.type eq 'trash'}active{/if}">
		<a class="data-pjax" href='{RC_Uri::url("article/admin/comments", "type=trash
			{if $id}&id={$id}{/if}{if $publishby}&publishby={$publishby}{/if}{if $filter.keywords}&keywords={$filter.keywords}{/if}")}'>
			{t domain="article"}回收站{/t}
			<span class="badge badge-info unuse-plugins-num">{if $type_count.trash}{$type_count.trash}{else}0{/if}</span>
		</a>
	</li>
</ul>
<!-- 批量操作和搜索 -->
<div class="row-fluid batch" >
	<form method="post" action="{$search_action}{if $type}&type={$type}{/if}{if $publishby}&publishby={$publishby}{/if}" name="searchForm">
		<div class="btn-group f_l m_r5">
			<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
				<i class="fontello-icon-cog"></i>{t domain="article"}批量操作{/t}
				<span class="caret"></span>
			</a>
			<ul class="dropdown-menu">
				<li><a class="button_remove" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url='{url path="article/admin/comment_batch" args="sel_action=button_remove&article_id={$id}{if $type}&type={$type}{/if}{if $publishby}&publishby={$publishby}{/if}"}' data-msg="{t domain="article"}您确定要这么做吗？{/t}" data-noSelectMsg="{t domain="article"}请选择要删除的评论{/t}" data-name="id" href="javascript:;"><i class="fontello-icon-trash"></i>{t domain="article"}删除评论{/t}</a></li>
				<li><a class="button_hide"   data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url='{url path="article/admin/comment_batch" args="sel_action=button_hide&article_id={$id}{if $type}&type={$type}{/if}{if $publishby}&publishby={$publishby}{/if}"}' data-msg="{t domain="article"}您确定要这么做吗？{/t}" data-noSelectMsg="{t domain="article"}请选择要移至回收站的评论{/t}" data-name="id" href="javascript:;"><i class="fontello-icon-box"></i>{t domain="article"}回收站{/t}</a></li>
				<li><a class="button_show"   data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url='{url path="article/admin/comment_batch" args="sel_action=button_show&article_id={$id}{if $type}&type={$type}{/if}{if $publishby}&publishby={$publishby}{/if}"}' data-msg="{t domain="article"}您确定要这么做吗？{/t}" data-noSelectMsg="{t domain="article"}请选择要审核通过的评论{/t}" data-name="id" href="javascript:;"><i class="fontello-icon-ok-circled"></i>{t domain="article"}审核通过{/t}</a></li>
				<li><a class="button_rubbish"data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url='{url path="article/admin/comment_batch" args="sel_action=button_rubbish&article_id={$id}{if $type}&type={$type}{/if}{if $publishby}&publishby={$publishby}{/if}"}' data-msg="{t domain="article"}您确定要这么做吗？{/t}" data-noSelectMsg="{t domain="article"}请选择要设为垃圾评论的评论{/t}" data-name="id" href="javascript:;"><i class="fontello-icon-cancel-circled"></i>{t domain="article"}设为垃圾评论{/t}</a></li>
			</ul>
		</div>
		<div class="choose_list f_r" >
			<input type="text" name="keywords" value="{$smarty.get.keywords}" placeholder="{t domain="article"}输入用户名或评论关键字{/t}"/>
			<button class="btn search_articles" type="button">{t domain="article"}搜索{/t}</button>
		</div>
	</form>
</div>
	
<div class="row-fluid">
	<div class="span12">
		<table class="table table-striped smpl_tbl table-hide-edit">
			<thead>
				<tr>
				    <th class="table_checkbox"><input type="checkbox" name="select_rows" data-toggle="selectall" data-children=".checkbox"/></th>
				    <th class="w100">{t domain="article"}用户名{/t}</th>
				    <th class="w300">{t domain="article"}评论详情{/t}</th>
				    <th class="w80">{t domain="article"}审核状态{/t}</th>
			  	</tr>
			</thead>
			<tbody>
				<!-- {foreach from=$comment_list.arr item=list} -->
				<tr>
				    <td>
				         <span><input type="checkbox" name="checkboxes[]" class="checkbox" value="{$list.id}"/></span>
				    </td>
				    <td>{$list.user_name}</td>
				    <td class="hide-edit-area">
						<div><a href='{RC_Uri::url("article/admin/preview", "id={$list.id_value}{if $publishby}&publishby={$publishby}{/if}")}' target="_blank">{$list.title}</a></div>
						<div>{t domain="article"}评论于{/t}&nbsp;&nbsp;{$list.add_time}</div>
						{$list.content|truncate:100|escape:html}
						<div class="edit-list">
							<!-- {if ($list.comment_approved eq '0') || ($list.comment_approved eq '1')} -->
								<a class="toggle_view" href='{url path="article/admin/comment_check" args="id={$list.id}&article_id={$list.id_value}{if $type}&type={$type}{/if}{if $publishby}&publishby={$publishby}{/if}"}' data-val="{if $list.comment_approved eq 0}allow{elseif $list.comment_approved eq 1}forbid{/if}" data-status="{$list.comment_approved}">
									{if $list.comment_approved eq '0'}{t domain="article"}批准{/t}{elseif $list.comment_approved eq '1'}<span class="ecjiafc-red">{t domain="article"}驳回{/t}</span>{/if}
								</a>
								&nbsp;|&nbsp;<a class="ecjiafc-red toggle_view" href='{url path="article/admin/comment_check" args="id={$list.id}&article_id={$list.id_value}{if $type}&type={$type}{/if}{if $publishby}&publishby={$publishby}{/if}"}' data-msg="{t domain="article"}您确定要将改评论设为垃圾评论吗？{/t}" data-val="rubbish_comment" data-status="{$list.comment_approved}">{t domain="article"}垃圾评论{/t}</a>
								&nbsp;|&nbsp;<a class="ecjiafc-red toggle_view" href='{url path="article/admin/comment_check" args="id={$list.id}&article_id={$list.id_value}{if $type}&type={$type}{/if}{if $publishby}&publishby={$publishby}{/if}"}' data-msg="{t domain="article"}您确定要将改评论移到回收站吗？{/t}" data-val="trashed_comment" data-status="{$list.comment_approved}">{t domain="article"}移至回收站{/t}</a>
							<!-- {/if} -->
							<!-- {if ($list.comment_approved eq 'spam') || ($list.comment_approved eq 'trash')} -->
								<!-- {if $list.comment_approved eq 'spam'}  -->
									 <a class="toggle_view" href='{url path="article/admin/comment_check" args="id={$list.id}&article_id={$list.id_value}{if $type}&type={$type}{/if}{if $publishby}&publishby={$publishby}{/if}"}' data-val="no_rubbish" data-status="{$list.comment_approved}">{t domain="article"}不是垃圾评论{/t}</a>&nbsp;|&nbsp;
								<!-- {/if}  -->
								<!-- {if $list.comment_approved eq 'trash'}  -->
									<a class="toggle_view" href='{url path="article/admin/comment_check" args="id={$list.id}&article_id={$list.id_value}{if $type}&type={$type}{/if}{if $publishby}&publishby={$publishby}{/if}"}' data-val="no_trashed" data-status="{$list.comment_approved}">{t domain="article"}还原评论{/t}</a>&nbsp;|&nbsp;
								<!-- {/if}  -->
								<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg="{t domain="article"}您确定要删除这条评论吗？{/t}" href='{url path="article/admin/comment_remove" args="id={$list.id}&article_id={$list.id_value}"}' title="{t domain="article"}永久删除{/t}">
									{t domain="article"}永久删除{/t}
								</a>
							<!-- {/if} -->
						</div>
					</td>
				    <td>
						<!-- {if $list.comment_approved eq 1} -->
								审核通过
						<!-- {elseif $list.comment_approved eq '0'} -->
								<span style="color:#08c;">待审核</span>
						<!-- {elseif $list.comment_approved eq 'trash'} -->
								<span class="ecjiafc-red">回收站</span>
						<!-- {elseif $list.comment_approved eq 'spam'} -->
								<span class="ecjiafc-red">垃圾评论</span>
						<!-- {/if} -->
					</td>
				</tr>
				<!-- {foreachelse} -->
				   <tr><td class="no-records" colspan="4">{t domain="article"}没有找到任何记录{/t}</td></tr>
				<!-- {/foreach} -->
            </tbody>
         </table>
    	<!-- {$comment_list.page} -->
	</div>
</div>
<!-- {/block} -->