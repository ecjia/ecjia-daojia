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
		<a class="btn btn-primary data-pjax" href="{$article_list}" id="sticky_a"><i class="fa fa-reply"></i><i class="fontello-icon-plus"></i> {t domain="article"}文章列表{/t}</a>
	</div>
	<div class="clearfix">
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="panel">
			<div class="panel-body panel-body-small">
				<ul class="nav nav-pills pull-left">
					<li class="{if $type eq ''}active{/if}"><a class="data-pjax" href='{url path="article/merchant/article_comment" args="{if $id}id={$id}&{/if}{if $filter.keywords}&keywords={$filter.keywords}{/if}"}'>{t domain="article"}全部{/t} <span class="badge badge-info">{if $type_count.count}{$type_count.count}{else}0{/if}</span></a></li>
					<li class="{if $type eq 'has_checked'}active{/if}"><a class="data-pjax" href='{url path="article/merchant/article_comment" args="{if $id}id={$id}&{/if}type=has_checked{if $filter.keywords}&keywords={$filter.keywords}{/if}"}'>{t domain="article"}通过审核{/t}<span class="badge badge-info">{if $type_count.has_checked}{$type_count.has_checked}{else}0{/if}</span></a></li>
					<li class="{if $type eq 'wait_check'}active{/if}"><a class="data-pjax" href='{url path="article/merchant/article_comment" args="{if $id}id={$id}&{/if}type=wait_check{if $filter.keywords}&keywords={$filter.keywords}{/if}"}'>{t domain="article"}待审核{/t}<span class="badge badge-info">{if $type_count.wait_check}{$type_count.wait_check}{else}0{/if}</span></a></li>
					<li class="{if $type eq 'spam'}active{/if}"><a class="data-pjax" href='{url path="article/merchant/article_comment" args="{if $id}id={$id}&{/if}type=spam{if $filter.keywords}&keywords={$filter.keywords}{/if}"}'>{t domain="article"}垃圾评论{/t}<span class="badge badge-info">{if $type_count.spam}{$type_count.spam}{else}0{/if}</span></a></li>
				</ul>
				<div class="clearfix"></div>
			</div>
			
			<div class="panel-body panel-body-small">	
				<form class="form-inline" method="post" action='{url path="article/merchant/article_comment" args="{if $id}id={$id}{/if}"}' name="searchForm">
					<div class="btn-group f_l m_r5">
						<a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
							<i class="fa fa-cogs"></i>
							<i class="fontello-icon-cog"></i>{t domain="article"}批量操作{/t}
							<span class="caret"></span>
						</a>
						<ul class="dropdown-menu">
							<!-- {if $filter.type eq 'trash'} -->
							<li><a class="button_remove" data-toggle="ecjiabatch" data-idclass=".checkbox:checked" data-url="{url path='article/merchant/batch_check'}&type=batch_uncheck&article_id={$id}" data-msg='{t domain="article"}您确定要批量执行该操作吗？{/t}' data-noselectmsg='{t domain="article"}请选择要操作的评论{/t}' data-name="id" href="javascript:;"><i class="fa fa-reply"></i> {t domain="article"}还原评论{/t}</a></li>
							<!-- {/if} -->
							
							<!-- {if $filter.type neq 'trash'} -->
							<!-- {if $filter.type neq 'has_checked'} -->
							<li><a class="button_remove" data-toggle="ecjiabatch" data-idclass=".checkbox:checked" data-url="{url path='article/merchant/batch_check'}&type=batch_check&article_id={$id}" data-msg='{t domain="article"}您确定要批量执行该操作吗？{/t}' data-noselectmsg='{t domain="article"}请选择要操作的评论{/t}' data-name="id" href="javascript:;"><i class="fa fa-check"></i> {t domain="article"}通过审核{/t}</a></li>
							<!-- {/if} -->
							
							<!-- {if $filter.type neq 'wait_check'} -->
							<li><a class="button_remove" data-toggle="ecjiabatch" data-idclass=".checkbox:checked" data-url="{url path='article/merchant/batch_check'}&type=batch_uncheck&article_id={$id}" data-msg='{t domain="article"}您确定要批量执行该操作吗？{/t}' data-noselectmsg='{t domain="article"}请选择要操作的评论{/t}' data-name="id" href="javascript:;"><i class="fa fa-info-circle"></i> {t domain="article"}设为待审核{/t}</a></li>
							<!-- {/if} -->
						
							<li><a class="button_remove" data-toggle="ecjiabatch" data-idclass=".checkbox:checked" data-url="{url path='article/merchant/batch_check'}&type=batch_trash&article_id={$id}" data-msg='{t domain="article"}您确定要批量执行该操作吗？{/t}' data-noselectmsg='{t domain="article"}请选择要操作的评论{/t}' data-name="id" href="javascript:;"><i class="fa fa-archive"></i> {t domain="article"}设为垃圾评论{/t}</a></li>
							<!-- {/if} -->
							
							<li><a class="button_remove" data-toggle="ecjiabatch" data-idclass=".checkbox:checked" data-url="{url path='article/merchant/remove_comment'}&type=batch&article_id={$id}" data-msg='{t domain="article"}您确定要这么做吗？{/t}' data-noselectmsg='{t domain="article"}请选择要删除的评论{/t}' data-name="id" href="javascript:;"><i class="fa fa-trash-o"></i> {t domain="article"}删除评论{/t}</a></li>
						</ul>
					</div>
					
					<div class="f_r form-group">
						<input type="text" name="keywords" class="form-control" value="{$smarty.get.keywords}" placeholder='{t domain="article"}请输入用户名或评论关键字{/t}'/>
						<a class="btn btn-primary m_l5 search_articles"><i class="fa fa-search"></i> {t domain="article"}搜索{/t}</a>
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
								{t domain="article"}用户名{/t}
							</th>
							<th>
								{t domain="article"}评论详情{/t}
							</th>
							<th class="w180">
								{t domain="article"}审核状态{/t}
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
								<a href='{RC_Uri::url("article/merchant/article_comment", "id={$list.id_value}")}' target="_blank"><span>{$list.title}</span></a>
								<div>{t domain="article"}评论于{/t}&nbsp;{$list.date}</div>
								<span>{$list.content}</span>
								<div class="edit-list">
									<!-- {if $list.comment_approved neq 'trash'} -->
										<!-- {if $list.comment_approved eq 1} -->
										<a class="toggle_view ecjiafc-red" href='{url path="article/merchant/comment_check" args="id={$list.id}{if $filter.type}&type={$filter.type}{/if}{if $filter.keywords}&keywords={$filter.keywords}{/if}"}' data-id="{$list.id_value}" data-val="forbid" data-status=0>{t domain="article"}驳回{/t}</a>&nbsp;|&nbsp;
										<!-- {/if} -->
										
										<!-- {if $list.comment_approved eq 0} -->
										<a class="toggle_view" href='{url path="article/merchant/comment_check" args="id={$list.id}{if $filter.type}&type={$filter.type}{/if}{if $filter.keywords}&keywords={$filter.keywords}{/if}"}' data-id="{$list.id_value}" data-val="allow" data-status=1>{t domain="article"}批准{/t}</a>&nbsp;|&nbsp;
										<!-- {/if} -->
										
										<a class="toggle_view ecjiafc-red" href='{url path="article/merchant/comment_check" args="id={$list.id}{if $filter.type}&type={$filter.type}{/if}{if $filter.keywords}&keywords={$filter.keywords}{/if}"}' data-id="{$list.id_value}" data-val="forbid" data-status="trash" data-msg='{t domain="article"}您确定要将该评论设为垃圾评论吗？{/t}'>{t domain="article"}垃圾评论{/t}</a>&nbsp;|&nbsp;
									<!-- {else} -->
										<a class="toggle_view ecjiafc-blue" href='{url path="article/merchant/comment_check" args="id={$list.id}{if $filter.type}&type={$filter.type}{/if}{if $filter.keywords}&keywords={$filter.keywords}{/if}"}' data-id="{$list.id_value}" data-val="forbid" data-status=0>{t domain="article"}还原评论{/t}</a>&nbsp;|&nbsp;
									<!-- {/if} -->
									<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg='{t domain="article"}您确定要删除该文章评论吗？{/t}' href='{RC_Uri::url("article/merchant/remove_comment", "id={$list.id}&article_id={$list.id_value}")}' title='{t domain="article"}删除{/t}'>{t domain="article"}删除{/t}</a>
								</div>
							</td>
							<td>
								<!-- {if $list.comment_approved eq 1} -->
									{t domain="article"}审核通过{/t}
								<!-- {else} -->
									<span class="ecjiafc-blue">{t domain="article"}待审核{/t}</span>
								<!-- {/if} -->
							</td>
						</tr>
						<!-- {foreachelse} -->
						<tr>
							<td class="no-records" colspan="4">
								{t domain="article"}没有找到任何记录{/t}
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