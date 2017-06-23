<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->
<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.merchant.article_list.init();
</script>
<!-- {/block} -->
<!-- {block name="home-content"} -->
<div class="modal fade" id="movetype">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button class="close" data-dismiss="modal">×</button>
				<h3>{lang key='article::article.move_to_category'}</h3>
			</div>
			<div class="modal-body h400 form-horizontal">
				<div class="form-group ecjiaf-tac">
					<select class="noselect w200 ecjiaf-ib form-control" size="15" name="target_cat">
						<option value="0" disabled>{lang key='article::article.all_cat'}</option>
						<!-- {foreach from=$cat_select key=key item=val} -->
						<option value="{$val.cat_id}" {if $val.level}style="padding-left:{$val.level*20}px"{/if}>{$val.cat_name}</option>
						<!-- {/foreach} -->
					</select>
				</div>
				<div class="form-group t_c">
					<a class="btn btn-primary btn-gebo m_l5" data-toggle="ecjiabatch" data-name="article_id" data-idclass=".checkbox:checked" data-url="{$form_action}&sel_action=move_to&" data-msg="{lang key='article::article.move_confirm'}" data-noselectmsg="{lang key='article::article.select_move_article'}" href="javascript:;" name="move_cat_ture">{lang key='article::article.begin_move'}</a>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="page-header">
	<h2 class="pull-left">
	<!-- {if $ur_here}{$ur_here}{/if} -->
	<!-- {if $action_link} -->
	<!-- {/if} -->
	</h2>
	<div class="pull-right">
		<a class="btn btn-primary data-pjax" href="{$action_link.href}" id="sticky_a"><i class="fa fa-plus"></i><i class="fontello-icon-plus"></i> {$action_link.text}</a>
	</div>
	<div class="clearfix">
	</div>
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="panel">
			<div class="panel-body panel-body-small">
				<ul class="nav nav-pills pull-left">
					<li class="{if $type eq ''}active{/if}"><a class="data-pjax" href='{url path="article/merchant/init" args="{if $filter.keywords}&keywords={$filter.keywords}{/if}{if $filter.cat_id}&cat_id={$filter.cat_id}{/if}"}'>{lang key='article::article.all'} <span class="badge badge-info">{if $type_count.count}{$type_count.count}{else}0{/if}</span></a></li>
					<li class="{if $type eq 'has_checked'}active{/if}"><a class="data-pjax" href='{url path="article/merchant/init" args="type=has_checked{if $filter.keywords}&keywords={$filter.keywords}{/if}{if $filter.cat_id}&cat_id={$filter.cat_id}{/if}"}'>{lang key='article::article.has_checked'}<span class="badge badge-info">{if $type_count.has_checked}{$type_count.has_checked}{else}0{/if}</span></a></li>
					<li class="{if $type eq 'wait_check'}active{/if}"><a class="data-pjax" href='{url path="article/merchant/init" args="type=wait_check{if $filter.keywords}&keywords={$filter.keywords}{/if}{if $filter.cat_id}&cat_id={$filter.cat_id}{/if}"}'>{lang key='article::article.wait_check'}<span class="badge badge-info">{if $type_count.wait_check}{$type_count.wait_check}{else}0{/if}</span></a></li>
				</ul>
				<div class="clearfix"></div>
			</div>
			<div class="panel-body panel-body-small">
				<form class="form-inline" method="post" action="{$search_action}" name="searchForm">
					<div class="btn-group f_l m_r5">
						<a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
							<i class="fa fa-cogs"></i>
							<i class="fontello-icon-cog"></i>{lang key='article::article.batch'}
							<span class="caret"></span>
						</a>
						<ul class="dropdown-menu">
							<li><a class="batch-move-btn" href="javascript:;" data-move="data-operatetype" data-name="move_cat"><i class="fa fa-mail-forward"></i><i class="fontello-icon-exchange"></i> {lang key='article::article.move_category'}</a></li>
							<li><a class="button_remove" data-toggle="ecjiabatch" data-idclass=".checkbox:checked" data-url="{url path='article/merchant/batch' args='sel_action=button_remove'}" data-msg="{lang key='article::article.confirm_drop'}" data-noselectmsg="{lang key='article::article.select_drop_article'}" data-name="article_id" href="javascript:;"><i class="fa fa-trash-o"></i><i class="fontello-icon-trash"></i> {lang key='article::article.drop_article'}</a></li>
						</ul>
					</div>
					<select class="w250" name="cat_id" id="select-cat">
						<option value="0">{lang key='article::article.all_cat'}</option>
						<!-- {foreach from=$cat_select key=key item=val} -->
						<option value="{$val.cat_id}" {if $smarty.get.cat_id eq $val.cat_id}selected{/if} {if $val.level}style="padding-left:{$val.level*20}px"{/if}>{$val.cat_name}</option>
						<!-- {/foreach} -->
					</select>
					<a class="btn btn-primary m_l5 screen-btn"><i class="fa fa-search"></i> {lang key='article::article.filter'}</a>
					<div class="f_r form-group">
						<input type="text" name="keywords" class="form-control" value="{$smarty.get.keywords}" placeholder="{lang key='article::article.enter_article_title'}"/>
						<a class="btn btn-primary m_l5 search_articles"><i class="fa fa-search"></i> 筛选</a>
					</div>
				</form>
			</div>
			<div class="panel-body panel-body-small">
				<table class="table table-striped table-hover table-hide-edit ecjiaf-tlf">
					<thead>
						<tr data-sorthref='{url path="article/merchant/init" args="{if $filter.keywords}&keywords={$filter.keywords}{/if}{if $filter.cat_id}&cat_id={$filter.cat_id}{/if}"}'>
							<th class="table_checkbox check-list w30">
								<div class="check-item">
									<input id="checkall" type="checkbox" name="select_rows" data-toggle="selectall" data-children=".checkbox"/>
									<label for="checkall"></label>
								</div>
							</th>
							<th>
								{lang key='article::article.title'}
							</th>
							<th class="w200">
								{lang key='article::article.cat'}
							</th>
							<th class="w130 sorting" data-toggle="sortby" data-sortby="like_count">
								{lang key='article::article.like_count'}
							</th>
							<th class="w130 sorting" data-toggle="sortby" data-sortby="comment_count">
								{lang key='article::article.comment_count'}
							</th>
							<th class="w180">
								{lang key='article::article.add_time'}
							</th>
						</tr>
					</thead>
					<tbody>
					<!-- {foreach from=$article_list.arr item=list} -->
						<tr>
							<td class="check-list">
								<div class="check-item">
									<input id="check_{$list.article_id}" class="checkbox" type="checkbox" name="checkboxes[]" value="{$list.article_id}"/>
									<label for="check_{$list.article_id}"></label>
								</div>
							</td>
							<td class="hide-edit-area">
								<span class="cursor_pointer" data-text="textarea" data-trigger="editable" data-url="{RC_Uri::url('article/merchant/edit_title')}" data-name="{$list.cat_id}" data-pk="{$list.article_id}" data-title="{lang key='article::article.edit_article_title'}">{$list.title}</span>
								<div class="edit-list">
									<a target="_blank" href='{RC_Uri::url("article/merchant/preview", "id={$list.article_id}")}' title="{lang key='article::article.view'}">{lang key='article::article.view'}</a>&nbsp;|&nbsp;
									<a class="data-pjax" href='{RC_Uri::url("article/merchant/edit", "id={$list.article_id}")}' title="{lang key='system::system.edit'}">{lang key='system::system.edit'}</a>&nbsp;|&nbsp; 
									{if $has_goods}
									<a class="data-pjax" href='{url path="article/merchant/link_goods" args="id={$list.article_id}"}' title="{lang key='article::article.tab_goods'}">{lang key='article::article.tab_goods'}</a>&nbsp;|&nbsp; 
									{/if}
									<a class="data-pjax" href='{RC_Uri::url("article/merchant/article_comment", "id={$list.article_id}")}' title="{lang key='article::article.view'}">{lang key='article::article.view_comment'}</a>&nbsp;|&nbsp;
									{if $list.cat_id gt 0}
									<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg="{lang key='article::article.drop_confirm'}" href='{RC_Uri::url("article/merchant/remove", "id={$list.article_id}")}' title="{lang key='system::system.remove'}">{lang key='system::system.drop'}</a>
									{/if}
								</div>
							</td>
							<td>
								<span>{if $list.cat_id gt 0}{$list.cat_name|escape:html}{else}{lang key='article::article.reserve'}{/if}</span>
							</td>
							<td>{$list.like_value}</td>
							<td>{$list.comment_count}</td>
							<td>
								<span>{$list.date}</span>
							</td>
						</tr>
						<!-- {foreachelse} -->
						<tr>
							<td class="no-records" colspan="6">
								{lang key='system::system.no_records'}
							</td>
						</tr>
					<!-- {/foreach} -->
					</tbody>
				</table>
				<!-- {$article_list.page} -->
			</div>
		</div>
	</div>
</div>
<!-- {/block} -->