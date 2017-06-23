<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->
<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.merchant.article_list.init();
</script>
<!-- {/block} -->
<!-- {block name="home-content"} -->

<div class="page-header">
	<h2 class="pull-left">
	<!-- {if $ur_here}{$ur_here}{/if} -->
	<!-- {if $action_link} -->
	<!-- {/if} -->
	</h2>
	<div class="pull-right">
		<a class="btn btn-primary data-pjax" href="{$article_list}" id="sticky_a"><i class="fa fa-reply"></i><i class="fontello-icon-plus"></i> {lang key='article::article.article_list'}</a>
	</div>
	<div class="clearfix">
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="panel">
			<div class="panel-body panel-body-small">
				<ul class="nav nav-pills pull-left">
					<li class="{if $type eq ''}active{/if}"><a class="data-pjax" href='{url path="article/merchant/article_comment" args="{if $id}id={$id}&{/if}{if $filter.keywords}&keywords={$filter.keywords}{/if}"}'>{lang key='article::article.all'} <span class="badge badge-info">{if $type_count.count}{$type_count.count}{else}0{/if}</span></a></li>
					<li class="{if $type eq 'has_checked'}active{/if}"><a class="data-pjax" href='{url path="article/merchant/article_comment" args="{if $id}id={$id}&{/if}type=has_checked{if $filter.keywords}&keywords={$filter.keywords}{/if}"}'>{lang key='article::article.has_checked'}<span class="badge badge-info">{if $type_count.has_checked}{$type_count.has_checked}{else}0{/if}</span></a></li>
					<li class="{if $type eq 'wait_check'}active{/if}"><a class="data-pjax" href='{url path="article/merchant/article_comment" args="{if $id}id={$id}&{/if}type=wait_check{if $filter.keywords}&keywords={$filter.keywords}{/if}"}'>{lang key='article::article.wait_check'}<span class="badge badge-info">{if $type_count.wait_check}{$type_count.wait_check}{else}0{/if}</span></a></li>
					<li class="{if $type eq 'spam'}active{/if}"><a class="data-pjax" href='{url path="article/merchant/article_comment" args="{if $id}id={$id}&{/if}type=spam{if $filter.keywords}&keywords={$filter.keywords}{/if}"}'>{lang key='article::article.trash_comment'}<span class="badge badge-info">{if $type_count.spam}{$type_count.spam}{else}0{/if}</span></a></li>
				</ul>
				<div class="clearfix"></div>
			</div>
			
			<div class="panel-body panel-body-small">	
				<form class="form-inline" method="post" action='{url path="article/merchant/article_comment" args="{if $id}id={$id}{/if}"}' name="searchForm">
					<div class="btn-group f_l m_r5">
						<a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
							<i class="fa fa-cogs"></i>
							<i class="fontello-icon-cog"></i>{lang key='article::article.batch'}
							<span class="caret"></span>
						</a>
						<ul class="dropdown-menu">
							<!-- {if $filter.type eq 'trash'} -->
							<li><a class="button_remove" data-toggle="ecjiabatch" data-idclass=".checkbox:checked" data-url="{url path='article/merchant/batch_check'}&type=batch_uncheck&article_id={$id}" data-msg="您确定要批量执行该操作吗？" data-noselectmsg="请选择要操作的评论" data-name="id" href="javascript:;"><i class="fa fa-reply"></i> 还原评论</a></li>
							<!-- {/if} -->
							
							<!-- {if $filter.type neq 'trash'} -->
							<!-- {if $filter.type neq 'has_checked'} -->
							<li><a class="button_remove" data-toggle="ecjiabatch" data-idclass=".checkbox:checked" data-url="{url path='article/merchant/batch_check'}&type=batch_check&article_id={$id}" data-msg="您确定要批量执行该操作吗？" data-noselectmsg="请选择要操作的评论" data-name="id" href="javascript:;"><i class="fa fa-check"></i> 通过审核</a></li>
							<!-- {/if} -->
							
							<!-- {if $filter.type neq 'wait_check'} -->
							<li><a class="button_remove" data-toggle="ecjiabatch" data-idclass=".checkbox:checked" data-url="{url path='article/merchant/batch_check'}&type=batch_uncheck&article_id={$id}" data-msg="您确定要批量执行该操作吗？" data-noselectmsg="请选择要操作的评论" data-name="id" href="javascript:;"><i class="fa fa-info-circle"></i> 设为待审核</a></li>
							<!-- {/if} -->
						
							<li><a class="button_remove" data-toggle="ecjiabatch" data-idclass=".checkbox:checked" data-url="{url path='article/merchant/batch_check'}&type=batch_trash&article_id={$id}" data-msg="您确定要批量执行该操作吗？" data-noselectmsg="请选择要操作的评论" data-name="id" href="javascript:;"><i class="fa fa-archive"></i> 设为垃圾评论</a></li>
							<!-- {/if} -->
							
							<li><a class="button_remove" data-toggle="ecjiabatch" data-idclass=".checkbox:checked" data-url="{url path='article/merchant/remove_comment'}&type=batch&article_id={$id}" data-msg="{lang key='article::article.confirm_drop'}" data-noselectmsg="{lang key='article::article.select_drop_comment'}" data-name="id" href="javascript:;"><i class="fa fa-trash-o"></i> {lang key='article::article.drop_comment'}</a></li>
						</ul>
					</div>
					
					<div class="f_r form-group">
						<input type="text" name="keywords" class="form-control" value="{$smarty.get.keywords}" placeholder="{lang key='article::article.enter_comment_username'}"/>
						<a class="btn btn-primary m_l5 search_articles"><i class="fa fa-search"></i> {lang key='system::system.button_search'}</a>
					</div>
				</form>
			</div>
			
			<div class="panel-body panel-body-small">
				<table class="table table-striped table-hover table-hide-edit ecjiaf-tlf">
					<thead>
						<tr>
							<th class="table_checkbox check-list w30">
								<div class="check-item">
									<input id="checkall" type="checkbox" name="select_rows" data-toggle="selectall" data-children=".checkbox"/>
									<label for="checkall"></label>
								</div>
							</th>
							<th class="w200">
								{lang key='article::article.user_name'}
							</th>
							<th>
								{lang key='article::article.comment_detail'}
							</th>
							<th class="w180">
								{lang key='article::article.comment_status'}
							</th>
						</tr>
					</thead>
					<tbody>
					<!-- {foreach from=$data.arr item=list} -->
						<tr>
							<td class="check-list">
								<div class="check-item">
									<input id="check_{$list.id}" class="checkbox" type="checkbox" name="checkboxes[]" value="{$list.id}"/>
									<label for="check_{$list.id}"></label>
								</div>
							</td>
							<td>{$list.user_name}</td>
							<td class="hide-edit-area">
								<a href='{RC_Uri::url("article/merchant/article_comment", "id={$list.id_value}")}' target="__blank"><span>{$list.title}</span></a>
								<div>评论于&nbsp;{$list.date}</div>
								<span>{$list.content}</span>
								<div class="edit-list">
									<!-- {if $list.comment_approved neq 'trash'} -->
										<!-- {if $list.comment_approved eq 1} -->
										<a class="toggle_view ecjiafc-red" href='{url path="article/merchant/comment_check" args="id={$list.id}{if $filter.type}&type={$filter.type}{/if}{if $filter.keywords}&keywords={$filter.keywords}{/if}"}' data-id="{$list.id_value}" data-val="forbid" data-status=0>驳回</a>&nbsp;|&nbsp;
										<!-- {/if} -->
										
										<!-- {if $list.comment_approved eq 0} -->
										<a class="toggle_view" href='{url path="article/merchant/comment_check" args="id={$list.id}{if $filter.type}&type={$filter.type}{/if}{if $filter.keywords}&keywords={$filter.keywords}{/if}"}' data-id="{$list.id_value}" data-val="allow" data-status=1>批准</a>&nbsp;|&nbsp;
										<!-- {/if} -->
										
										<a class="toggle_view ecjiafc-red" href='{url path="article/merchant/comment_check" args="id={$list.id}{if $filter.type}&type={$filter.type}{/if}{if $filter.keywords}&keywords={$filter.keywords}{/if}"}' data-id="{$list.id_value}" data-val="forbid" data-status="trash" data-msg="{lang key='article::article.trash_comment_confirm'}">垃圾评论</a>&nbsp;|&nbsp;
									<!-- {else} -->
										<a class="toggle_view ecjiafc-blue" href='{url path="article/merchant/comment_check" args="id={$list.id}{if $filter.type}&type={$filter.type}{/if}{if $filter.keywords}&keywords={$filter.keywords}{/if}"}' data-id="{$list.id_value}" data-val="forbid" data-status=0>还原评论</a>&nbsp;|&nbsp;
									<!-- {/if} -->
									<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg="{lang key='article::article.drop_comment_confirm'}" href='{RC_Uri::url("article/merchant/remove_comment", "id={$list.id}&article_id={$list.id_value}")}' title="{lang key='system::system.remove'}">{lang key='system::system.drop'}</a>
								</div>
							</td>
							<td>
								<!-- {if $list.comment_approved eq 1} -->
									审核通过
								<!-- {else} -->
									<span class="ecjiafc-blue">待审核</span>
								<!-- {/if} -->
							</td>
						</tr>
						<!-- {foreachelse} -->
						<tr>
							<td class="no-records" colspan="4">
								{lang key='system::system.no_records'}
							</td>
						</tr>
					<!-- {/foreach} -->
					</tbody>
				</table>
				<!-- {$data.page} -->
			</div>
		</div>
	</div>
</div>
<!-- {/block} -->