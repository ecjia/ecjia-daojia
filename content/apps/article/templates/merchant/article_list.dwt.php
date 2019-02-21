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
				<h3>{t domain="article"}转移文章至分类{/t}</h3>
			</div>
			<div class="modal-body h400 form-horizontal">
				<div class="form-group ecjiaf-tac">
					<select class="noselect w200 ecjiaf-ib form-control" size="15" name="target_cat">
						<option value="0" disabled>{t domain="article"}全部分类{/t}</option>
						<!-- {foreach from=$cat_select key=key item=val} -->
						<option value="{$val.cat_id}" {if $val.level}style="padding-left:{$val.level*20}px"{/if}>{$val.cat_name}</option>
						<!-- {/foreach} -->
					</select>
				</div>
				<div class="form-group t_c">
					<a class="btn btn-primary btn-gebo m_l5" data-toggle="ecjiabatch" data-name="article_id" data-idclass=".checkbox:checked" data-url="{$form_action}&sel_action=move_to&" data-msg='{t domain="article"}是否将选中文章转移至分类？{/t}' data-noselectmsg='{t domain="article"}请先选中要转移的文章{/t}' href="javascript:;" name="move_cat_ture">{t domain="article"}开始转移{/t}</a>
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
					<li class="{if $type eq ''}active{/if}"><a class="data-pjax" href='{url path="article/merchant/init" args="{if $filter.keywords}&keywords={$filter.keywords}{/if}{if $filter.cat_id}&cat_id={$filter.cat_id}{/if}"}'>{t domain="article"}全部{/t} <span class="badge badge-info">{if $type_count.count}{$type_count.count}{else}0{/if}</span></a></li>
					<li class="{if $type eq 'has_checked'}active{/if}"><a class="data-pjax" href='{url path="article/merchant/init" args="type=has_checked{if $filter.keywords}&keywords={$filter.keywords}{/if}{if $filter.cat_id}&cat_id={$filter.cat_id}{/if}"}'>{t domain="article"}通过审核{/t}<span class="badge badge-info">{if $type_count.has_checked}{$type_count.has_checked}{else}0{/if}</span></a></li>
					<li class="{if $type eq 'wait_check'}active{/if}"><a class="data-pjax" href='{url path="article/merchant/init" args="type=wait_check{if $filter.keywords}&keywords={$filter.keywords}{/if}{if $filter.cat_id}&cat_id={$filter.cat_id}{/if}"}'>{t domain="article"}待审核{/t}<span class="badge badge-info">{if $type_count.wait_check}{$type_count.wait_check}{else}0{/if}</span></a></li>
				</ul>
				<div class="clearfix"></div>
			</div>
			<div class="panel-body panel-body-small">
				<form class="form-inline" method="post" action="{$search_action}" name="searchForm">
					<div class="btn-group f_l m_r5">
						<a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
							<i class="fa fa-cogs"></i>
							<i class="fontello-icon-cog"></i>{t domain="article"}批量操作{/t}
							<span class="caret"></span>
						</a>
						<ul class="dropdown-menu">
							<li><a class="batch-move-btn" href="javascript:;" data-move="data-operatetype" data-name="move_cat"><i class="fa fa-mail-forward"></i><i class="fontello-icon-exchange"></i> {t domain="article"}转移分类{/t}</a></li>
							<li><a class="button_remove" data-toggle="ecjiabatch" data-idclass=".checkbox:checked" data-url="{url path='article/merchant/batch' args='sel_action=button_remove'}" data-msg='{t domain="article"}您确定要这么做吗？{/t}' data-noselectmsg='{t domain="article"}请先选中要删除的文章{/t}' data-name="article_id" href="javascript:;"><i class="fa fa-trash-o"></i><i class="fontello-icon-trash"></i> {t domain="article"}删除文章{/t}</a></li>
						</ul>
					</div>
					<select class="w250" name="cat_id" id="select-cat">
						<option value="0">{t domain="article"}全部分类{/t}</option>
						<!-- {foreach from=$cat_select key=key item=val} -->
						<option value="{$val.cat_id}" {if $smarty.get.cat_id eq $val.cat_id}selected{/if} {if $val.level}style="padding-left:{$val.level*20}px"{/if}>{$val.cat_name}</option>
						<!-- {/foreach} -->
					</select>
					<a class="btn btn-primary m_l5 screen-btn"><i class="fa fa-search"></i> {t domain="article"}筛选{/t}</a>
					<div class="f_r form-group">
						<input type="text" name="keywords" class="form-control" value="{$smarty.get.keywords}" placeholder='{t domain="article"}请输入文章名称{/t}'/>
						<a class="btn btn-primary m_l5 search_articles"><i class="fa fa-search"></i> {t domain="article"}筛选{/t}</a>
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
								{t domain="article"}文章标题{/t}
							</th>
							<th class="w200">
								{t domain="article"}文章分类{/t}
							</th>
							<th class="w130 sorting" data-toggle="sortby" data-sortby="like_count">
								{t domain="article"}点赞数{/t}
							</th>
							<th class="w130 sorting" data-toggle="sortby" data-sortby="comment_count">
								{t domain="article"}评论数{/t}
							</th>
							<th class="w180">
								{t domain="article"}添加日期{/t}
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
								<span class="cursor_pointer" data-text="textarea" data-trigger="editable" data-url="{RC_Uri::url('article/merchant/edit_title')}" data-name="{$list.cat_id}" data-pk="{$list.article_id}" data-title='{t domain="article"}编辑文章名称{/t}'>{$list.title}</span>
								<div class="edit-list">
									<a target="_blank" href='{RC_Uri::url("article/merchant/preview", "id={$list.article_id}")}' title='{t domain="article"}预览{/t}'>{t domain="article"}预览{/t}</a>&nbsp;|&nbsp;
									<a class="data-pjax" href='{RC_Uri::url("article/merchant/edit", "id={$list.article_id}")}' title='{t domain="article"}编辑{/t}'>{t domain="article"}编辑{/t}</a>&nbsp;|&nbsp; 
									{if $has_goods}
									<a class="data-pjax" href='{url path="article/merchant/link_goods" args="id={$list.article_id}"}' title='{t domain="article"}关联商品{/t}'>{t domain="article"}关联商品{/t}</a>&nbsp;|&nbsp; 
									{/if}
									<a class="data-pjax" href='{RC_Uri::url("article/merchant/article_comment", "id={$list.article_id}")}' title='{t domain="article"}查看评论{/t}'>{t domain="article"}查看评论{/t}</a>&nbsp;|&nbsp;
									{if $list.cat_id gt 0}
									<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg='{t domain="article"}您确认要删除这篇文章吗？{/t}' href='{RC_Uri::url("article/merchant/remove", "id={$list.article_id}")}' title='{t domain="article"}删除{/t}'>{t domain="article"}删除{/t}</a>
									{/if}
								</div>
							</td>
							<td>
								<span>{if $list.cat_id gt 0}{$list.cat_name|escape:html}{else}{t domain="article"}保留{/t}{/if}</span>
							</td>
							<td>{$list.like_count}</td>
							<td>{$list.comment_count}</td>
							<td>
								<span>{$list.date}</span>
							</td>
						</tr>
						<!-- {foreachelse} -->
						<tr>
							<td class="no-records" colspan="6">
								{t domain="article"}没有找到任何记录{/t}
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