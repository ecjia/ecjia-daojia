<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.article_list.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div class="modal hide fade" id="movetype">
	<div class="modal-header">
		<button class="close" data-dismiss="modal">×</button>
		<h3>{lang key='article::article.move_to_category'}</h3>
	</div>
	<div class="modal-body h350">
		<div class="row-fluid  ecjiaf-tac">
			<div>
				<select class="noselect no_search w200" size="15" name="target_cat">
					<option value="0" disabled>{lang key='article::article.all_cat'}</option>
					<!-- {foreach from=$cat_select key=key item=val} -->
					<option value="{$val.cat_id}" {if $val.level}style="padding-left:{$val.level*20}px"{/if}>{$val.cat_name}</option>
					<!-- {/foreach} -->
				</select>
			</div>
			<div>
				<a class="btn btn-gebo m_l5" data-toggle="ecjiabatch" data-name="article_id" data-idClass=".checkbox:checked" data-url="{$form_action}&sel_action=move_to&" data-msg="{lang key='article::article.move_confirm'}" data-noSelectMsg="{lang key='article::article.select_move_article'}" href="javascript:;" name="move_cat_ture">{lang key='article::article.begin_move'}</a>
			</div>
		</div>
	</div>
</div>
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a class="btn plus_or_reply data-pjax" href="{$action_link.href}"  id="sticky_a"><i class="fontello-icon-plus"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>

<ul class="nav nav-pills">
	<li class="{if !$smarty.get.type}active{/if}">
		<a class="data-pjax" href="{RC_Uri::url('article/admin/init')}
			{if $filter.cat_id}&cat_id={$filter.cat_id}{/if}
			{if $publishby}&publishby={$publishby}{/if}
			{if $filter.keywords}&keywords={$filter.keywords}{/if}">
			{lang key='article::article.all'} 
			<span class="badge badge-info">{if $type_count.count}{$type_count.count}{else}0{/if}</span>
		</a>
	</li>
	<li class="{if $smarty.get.type eq 'has_checked'}active{/if}">
		<a class="data-pjax" href='{RC_Uri::url("article/admin/init", "type=has_checked
			{if $filter.cat_id}&cat_id={$filter.cat_id}{/if}
			{if $publishby}&publishby={$publishby}{/if}
			{if $filter.keywords}&keywords={$filter.keywords}{/if}")}'>
			{lang key='article::article.has_checked'} 
			<span class="badge badge-info use-plugins-num">{if $type_count.has_checked}{$type_count.has_checked}{else}0{/if}</span>
		</a>
	</li>
	<li class="{if $smarty.get.type eq 'wait_check'}active{/if}">	
		<a class="data-pjax" href='{RC_Uri::url("article/admin/init", "type=wait_check
			{if $filter.cat_id}&cat_id={$filter.cat_id}{/if}
			{if $publishby}&publishby={$publishby}{/if}
			{if $filter.keywords}&keywords={$filter.keywords}{/if}")}'>
			{lang key='article::article.wait_check'}
			<span class="badge badge-info unuse-plugins-num">{if $type_count.wait_check}{$type_count.wait_check}{else}0{/if}</span>
		</a>
	</li>
	<li class="{if $smarty.get.type eq 'rubbish_article'}active{/if}">
		<a class="data-pjax" href='{RC_Uri::url("article/admin/init", "type=rubbish_article
			{if $filter.cat_id}&cat_id={$filter.cat_id}{/if}
			{if $publishby}&publishby={$publishby}{/if}
			{if $filter.keywords}&keywords={$filter.keywords}{/if}")}'>
			{lang key='article::article.rubbish_article'}
			<span class="badge badge-info unuse-plugins-num">{if $type_count.rubbish_article}{$type_count.rubbish_article}{else}0{/if}</span>
		</a>
	</li>
	<li class="{if $smarty.get.type eq 'trash'}active{/if}">
		<a class="data-pjax" href='{RC_Uri::url("article/admin/init", "type=trash
			{if $filter.cat_id}&cat_id={$filter.cat_id}{/if}
			{if $publishby}&publishby={$publishby}{/if}
			{if $filter.keywords}&keywords={$filter.keywords}{/if}")}'>
			{lang key='article::article.trash'}
			<span class="badge badge-info unuse-plugins-num">{if $type_count.trash}{$type_count.trash}{else}0{/if}</span>
		</a>
	</li>
	<li class="{if $smarty.get.suggest_type eq 'default'}active{/if}">
		<a class="data-pjax" href='{RC_Uri::url("article/admin/init", "suggest_type=default
			{if $filter.cat_id}&cat_id={$filter.cat_id}{/if}
			{if $publishby}&publishby={$publishby}{/if}
			{if $filter.keywords}&keywords={$filter.keywords}{/if}")}'>
			{t}默认{/t}
			<span class="badge badge-info unuse-plugins-num">{if $suggest_type_count.default_count}{$suggest_type_count.default_count}{else}0{/if}</span>
		</a>
	</li>
	<li class="{if $smarty.get.suggest_type eq 'top'}active{/if}">
		<a class="data-pjax" href='{RC_Uri::url("article/admin/init", "suggest_type=top
			{if $filter.cat_id}&cat_id={$filter.cat_id}{/if}
			{if $publishby}&publishby={$publishby}{/if}
			{if $filter.keywords}&keywords={$filter.keywords}{/if}")}'>
			{t}置顶{/t}
			<span class="badge badge-info unuse-plugins-num">{if $suggest_type_count.top}{$suggest_type_count.top}{else}0{/if}</span>
		</a>
	</li>
</ul>
<!-- 批量操作和搜索 -->
<div class="row-fluid batch" >
	<form method="post" action="{$search_action}{if $type}&type={$type}{/if}" name="searchForm">
		<div class="btn-group f_l m_r5">
			<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
				<i class="fontello-icon-cog"></i>{lang key='article::article.batch'}
				<span class="caret"></span>
			</a>
			<ul class="dropdown-menu">
				<li><a class="button_remove" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url='{url path="article/admin/batch" args="sel_action=button_remove{if $publishby}&publishby={$publishby}{/if}"}' data-msg="{lang key='article::article.confirm_drop'}" data-noSelectMsg="{lang key='article::article.select_drop_article'}" data-name="article_id" href="javascript:;"><i class="fontello-icon-trash"></i>{lang key='article::article.drop_article'}</a></li>
				<li><a class="button_hide"   data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url='{url path="article/admin/batch" args="sel_action=button_hide{if $publishby}&publishby={$publishby}{/if}"}' data-msg="{lang key='article::article.confirm_drop'}" data-noSelectMsg="{lang key='article::article.select_trash_article'}" data-name="article_id" href="javascript:;"><i class="fontello-icon-box"></i>回收站</a></li>
				<li><a class="button_show"   data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url='{url path="article/admin/batch" args="sel_action=button_show{if $publishby}&publishby={$publishby}{/if}"}' data-msg="{lang key='article::article.confirm_drop'}" data-noSelectMsg="{lang key='article::article.select_approve_article'}" data-name="article_id" href="javascript:;"><i class="fontello-icon-ok-circled"></i>审核通过</a></li>
				<li><a class="button_rubbish"data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url='{url path="article/admin/batch" args="sel_action=button_rubbish{if $publishby}&publishby={$publishby}{/if}"}' data-msg="{lang key='article::article.confirm_drop'}" data-noSelectMsg="{lang key='article::article.select_rubbish_article'}" data-name="article_id" href="javascript:;"><i class="fontello-icon-cancel-circled"></i>设为垃圾文章</a></li>
				<li><a class="batch-move-btn" href="javascript:;" data-move="data-operatetype" data-name="move_cat"><i class="fontello-icon-exchange"></i>{lang key='article::article.move_category'}</a></li>
			</ul>
		</div>
		<select class="w220" name="cat_id" id="select-cat">
			<option value="0">{lang key='article::article.all_cat'}</option>
			<!-- {foreach from=$cat_select key=key item=val} -->
			<option value="{$val.cat_id}" {if $smarty.get.cat_id eq $val.cat_id}selected{/if} {if $val.level}style="padding-left:{$val.level*20}px"{/if}>{$val.cat_name}</option>
			<!-- {/foreach} -->
		</select>
		<a class="btn m_l5 screen-btn">{lang key='article::article.filter'}</a>
		<div class="choose_list f_r" >
			<input type="text" name="keywords" value="{$smarty.get.keywords}" placeholder="{if $publishby}请输入商家名称或文章标题{else}{lang key='article::article.enter_article_title'}{/if}"/>
			<button class="btn search_articles" type="button">{lang key='system::system.button_search'}</button>
		</div>
	</form>
</div>
	
<div class="row-fluid">
	<div class="span12">
		<table class="table table-striped smpl_tbl table-hide-edit">
			<thead>
				<tr>
				    <th class="table_checkbox"><input type="checkbox" name="select_rows" data-toggle="selectall" data-children=".checkbox"/></th>
				    <th class="w250">{lang key='article::article.title'}</th>
				    <!-- {if $publishby}  -->
				    <th class="w120">{t}商家名称{/t}</th>
				    <!-- {/if}  -->
				    <th class="w120">{lang key='article::article.cat'}</th>
				    <th class="w150">{lang key='article::article.add_time'}</th>
				    <th class="w50">{t}点赞数{/t}</th>
				    <th class="w80">{t}审核状态{/t}</th>
			  	</tr>
			</thead>
			<tbody>
				<!-- {foreach from=$article_list.arr item=list} -->
				<tr>
				    <td>
				         <span><input type="checkbox" name="checkboxes[]" class="checkbox" value="{$list.article_id}" {if $list.cat_id lte 0 }disabled="disabled"{/if}/></span>
				    </td>
				    <td class="hide-edit-area">
				    	<span class="cursor_pointer" data-text="textarea" data-trigger="editable" data-url="{RC_Uri::url('article/admin/edit_title')}" data-name="{$list.cat_id}" data-pk="{$list.article_id}" data-title="{lang key='article::article.edit_article_title'}">{$list.title}</span>
				    	<div class="edit-list">
				    		<!-- {if $list.article_approved eq '1'}  -->
				    			<a href='{RC_Uri::url("article/admin/preview", "id={$list.article_id}{if $publishby}&publishby={$publishby}{/if}")}' target="_blank" title="{lang key='article::article.view'}">{lang key='article::article.view'}</a>&nbsp;|&nbsp;
				    		<!-- {/if}  -->
				    		<a class="toggle_view" href='{url path="article/admin/top" args="id={$list.article_id}{if $type}&type={$type}{/if}{if $publishby}&publishby={$publishby}{/if}"}' data-val="{if $list.suggest_type eq '0'}allow{elseif $list.suggest_type eq 'stickie'}forbid{/if}" data-status="{$list.suggest_type}">
									{if $list.suggest_type eq '0'}{t}置顶{/t}{elseif $list.suggest_type eq 'stickie'}<span class="ecjiafc-red">{t}取消置顶{/t}</span>{/if}
								</a>&nbsp;|&nbsp;
				    		<!-- {if ($list.article_approved eq '0') || ($list.article_approved eq '1')} -->
					    		<a class="toggle_view" href='{url path="article/admin/check" args="id={$list.article_id}{if $type}&type={$type}{/if}{if $publishby}&publishby={$publishby}{/if}"}' data-val="{if $list.article_approved eq 0}allow{elseif $list.article_approved eq 1}forbid{/if}" data-status="{$list.article_approved}">
									{if $list.article_approved eq '0'}{t}批准{/t}{elseif $list.article_approved eq '1'}<span class="ecjiafc-red">{t}驳回{/t}</span>{/if}
								</a>&nbsp;|&nbsp;
								<a class="ecjiafc-red toggle_view" href='{url path="article/admin/check" args="id={$list.article_id}{if $type}&type={$type}{/if}{if $publishby}&publishby={$publishby}{/if}"}' data-msg="{lang key='article::article.trash_confirm'}" data-val="rubbish_article" data-status="{$list.article_approved}">{lang key='article::article.trash_msg'}</a>&nbsp;|&nbsp;
								<a class="ecjiafc-red toggle_view" href='{url path="article/admin/check" args="id={$list.article_id}{if $type}&type={$type}{/if}{if $publishby}&publishby={$publishby}{/if}"}' data-msg="{lang key='article::article.spam_confirm'}" data-val="trashed_article" data-status="{$list.article_approved}">{lang key='article::article.move_to_recycle'}</a>&nbsp;|&nbsp;
								<a class="data-pjax" href='{RC_Uri::url("article/admin/edit", "id={$list.article_id}{if $publishby}&publishby={$publishby}{/if}")}' title="{lang key='system::system.edit'}">{lang key='system::system.edit'}</a>&nbsp;|&nbsp;
								{if $list.article_approved eq 1}
						      		<a class="data-pjax" href='{url path="article/admin/comments" args="id={$list.article_id}{if $publishby}&publishby={$publishby}{/if}"}' title="{lang key='article::article.article_comments'}">{lang key='article::article.article_comments'}</a>&nbsp;|&nbsp;
						     	{/if}
							<!-- {/if} -->
					      	{if $has_goods}
					      		<a class="data-pjax" href='{url path="article/admin/link_goods" args="id={$list.article_id}{if $publishby}&publishby={$publishby}{/if}"}' title="{lang key='article::article.tab_goods'}">{lang key='article::article.tab_goods'}</a> 
					      	{/if}
					     	<!-- {if $list.cat_id > 0} -->
						     	<!-- {if ($list.article_approved eq 'spam') || ($list.article_approved eq 'trash')} -->
						     	<!-- {if $list.article_approved eq 'spam'} -->
						     		&nbsp;|&nbsp;<a class="toggle_view" href='{url path="article/admin/check" args="id={$list.article_id}"}{if $type}&type={$type}{/if}{if $publishby}&publishby={$publishby}{/if}' data-val="no_rubbish" data-status="{$list.article_approved}">{t}不是垃圾文章{/t}</a>&nbsp;|&nbsp;
						     	<!-- {/if} -->
						     	<!-- {if $list.article_approved eq 'trash'} -->
						     		&nbsp;|&nbsp;<a class="toggle_view" href='{url path="article/admin/check" args="id={$list.article_id}"}{if $type}&type={$type}{/if}{if $publishby}&publishby={$publishby}{/if}' data-val="no_trash" data-status="{$list.article_approved}">{t}还原文章{/t}</a>&nbsp;|&nbsp;
						     	<!-- {/if} -->
						     	<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg="{lang key='article::article.drop_confirm'}" href='{RC_Uri::url("article/admin/remove", "id={$list.article_id}{if $publishby}&publishby={$publishby}{/if}")}' title="{lang key='system::system.remove'}">{t}永久删除{/t}</a>
						     	<!-- {/if} -->
					     	<!-- {/if} -->
					     </div>
					</td>
					<!-- {if $publishby} --><td>{$list.merchants_name}</td><!-- {/if} -->
				    <td><span><!-- {if $list.cat_id > 0} -->{$list.cat_name|escape:html}<!-- {else} -->{lang key='article::article.reserve'}<!-- {/if} --></span></td>
				    <td><span>{$list.date}</span><br><span>
						{if $list.article_type eq 'article'} {lang key='article::article.common'}
						{elseif $list.article_type eq 'redirect'} {t}跳转链接{/t}
						{elseif $list.article_type eq 'download'} {t}点击标题直接下载{/t}
						{elseif $list.article_type eq 'related'} {t}文章内容底部相关下载{/t}
					    {/if}</span>
				   </td>
				   <td>{$list.like_count}</td>
				    <td>
						<!-- {if $list.article_approved eq 1} -->
							<span>审核通过</span>
						<!-- {elseif $list.article_approved eq '0'} -->
							<span style="color:#08c;">待审核</span>
						<!-- {elseif $list.article_approved eq 'trash'} -->
							<span class="ecjiafc-red">回收站</span>
						<!-- {elseif $list.article_approved eq 'spam'} -->
							<span class="ecjiafc-red">垃圾文章</span>
						<!-- {/if} -->
						<br>
						<!-- {if $list.suggest_type eq 'stickie'} -->
						  <span>置顶</span>
						<!-- {else} -->
						   <span>默认</span> 
						<!-- {/if} -->
					</td>
				</tr>
				<!-- {foreachelse} -->
				   <tr><td class="no-records" colspan="{if $publishby}7{else}6{/if}">{lang key='system::system.no_records'}</td></tr>
				<!-- {/foreach} -->
            </tbody>
         </table>
    	<!-- {$article_list.page} -->
	</div>
</div>
<!-- {/block} -->