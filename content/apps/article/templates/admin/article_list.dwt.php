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
	<div class="modal-body h300">
		<div class="row-fluid  ecjiaf-tac">
			<div>
				<select class="noselect no_search w200" size="15" name="target_cat">
					<option value="0">{lang key='article::article.all_cat'}</option>
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

<!-- 批量操作和搜索 -->
<div class="row-fluid batch" >
	<form method="post" action="{$search_action}" name="searchForm">
		<div class="btn-group f_l m_r5">
			<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
				<i class="fontello-icon-cog"></i>{lang key='article::article.batch'}
				<span class="caret"></span>
			</a>
			<ul class="dropdown-menu">
				<li><a class="button_remove" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{url path='article/admin/batch' args='sel_action=button_remove'}" data-msg="{lang key='article::article.confirm_drop'}" data-noSelectMsg="{lang key='article::article.select_drop_article'}" data-name="article_id" href="javascript:;"><i class="fontello-icon-trash"></i>{lang key='article::article.drop_article'}</a></li>
				<li><a class="button_hide"   data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{url path='article/admin/batch' args='sel_action=button_hide'}" data-msg="{lang key='article::article.confirm_drop'}" data-noSelectMsg="{lang key='article::article.select_hide_article'}" data-name="article_id" href="javascript:;"><i class="fontello-icon-eye-off"></i>{lang key='article::article.hide'}</a></li>
				<li><a class="button_show"   data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{url path='article/admin/batch' args='sel_action=button_show'}" data-msg="{lang key='article::article.confirm_drop'}" data-noSelectMsg="{lang key='article::article.select_display_article'}" data-name="article_id" href="javascript:;"><i class="fontello-icon-eye"></i>{lang key='article::article.display'}</a></li>
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
			<input type="text" name="keywords" value="{$smarty.get.keywords}" placeholder="{lang key='article::article.enter_article_title'}"/>
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
				    <th>{lang key='article::article.title'}</th>
				    <th class="w200">{lang key='article::article.cat'}</th>
				    <th class="w250">{lang key='article::article.add_time'}</th>
				    <th class="w100">{lang key='article::article.is_open'}</th>
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
					      	<a class="data-pjax" href='{RC_Uri::url("article/admin/preview", "id={$list.article_id}")}' title="{lang key='article::article.view'}">{lang key='article::article.view'}</a>&nbsp;|&nbsp;
					      	<a class="data-pjax" href='{RC_Uri::url("article/admin/edit", "id={$list.article_id}")}' title="{lang key='system::system.edit'}">{lang key='system::system.edit'}</a>&nbsp;|&nbsp; 
					      	{if $has_goods}
					      	<a class="data-pjax" href='{url path="article/admin/link_goods" args="id={$list.article_id}"}' title="{lang key='article::article.tab_goods'}">{lang key='article::article.tab_goods'}</a>&nbsp;|&nbsp; 
					      	{/if}
					     	<!-- {if $list.cat_id > 0} -->
					     	<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg="{lang key='article::article.drop_confirm'}" href='{RC_Uri::url("article/admin/remove", "id={$list.article_id}")}' title="{lang key='system::system.remove'}">{lang key='system::system.drop'}</a>
					     	<!-- {/if} -->
					     </div>
					</td>
				    <td><span><!-- {if $list.cat_id > 0} -->{$list.cat_name|escape:html}<!-- {else} -->{lang key='article::article.reserve'}<!-- {/if} --></span></td>
				    <td><span>{$list.date}</span><br><span>{if $list.article_type eq 0}{lang key='article::article.common'}{else}{lang key='article::article.top'}{/if}</span></td>
				    <td>
			    	<i class="{if $list.is_open eq '1'}fontello-icon-ok cursor_pointer{else}fontello-icon-cancel cursor_pointer{/if}" data-trigger="toggleState" data-url="{RC_Uri::url('article/admin/toggle_show')}" data-id="{$list.article_id}" ></i>
				    </td>
				</tr>
				<!-- {foreachelse} -->
				   <tr><td class="no-records" colspan="5">{lang key='system::system.no_records'}</td></tr>
				<!-- {/foreach} -->
            </tbody>
         </table>
    	<!-- {$article_list.page} -->
	</div>
</div>
<!-- {/block} -->