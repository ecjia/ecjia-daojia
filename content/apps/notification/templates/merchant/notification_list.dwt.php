<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.merchant.notice_list.init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->
<div class="row">
	<div class="col-lg-12">
		<h2 class="page-header">
			<!-- {if $ur_here}{$ur_here}{/if} -->
		</h2>
	</div>
</div>

<div class="row">
	<div class="col-lg-12 notice_list">
		<div class="panel">
			<div class="panel-body {if !$list}panel-empty{/if}">
				<div class="col-lg-9 col-md-4 col-sm-4 col-xs-12 pull-left">
					{if $list.item}
					<div class="panel panel-default">
						<!-- {foreach from=$list.item item=val} -->
						<div class="panel-body">
							<i class="fa fa-comment"></i>
							<span class="text-content">【{$val.type_title}】{$val.content}</span>
							<span class="edit-range f_r">
								<span class="m_r5">{$val.created_time}</span>
								<!-- {if !$val.read_at} -->
								<a class="toggle_view" href="{RC_Uri::url('notification/mh_notification/mark_read')}{if $smarty.get.status}&status={$smarty.get.status}{/if}"
								    data-id="{$val.id}" title='{t domain="notification"}标记为已读{/t}'>
									<i class="fa fa-check"></i>
								</a>
								<!-- {else} -->
								<a href="javascript:;" title='{t domain="notification"}已读{/t}'>
									<i class="fa fa-check stop_color"></i>
								</a>
								<!-- {/if} -->
							</span>
						</div>
						<!-- {/foreach} -->
					</div>
					{else}
					<div class="text-center">
						<div class="ui tertiary segment">
							<div class="ui list">
								<div class="item">
									<i class="fa fa-bell"></i>
								</div>
								<div class="item">
									<h3 class="ui header">{t domain="notification"}没有相关未读消息{/t}</h3>
								</div>
							</div>
						</div>
					</div>
					{/if}
					{$list.page}
				</div>

				<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 pull-right">
					<a class="btn btn-success btn-block m_b10 toggle_view" href="{RC_Uri::url('notification/mh_notification/mark_read')}{if $smarty.get.status}&status={$smarty.get.status}{/if}{if $smarty.get.page}&page={$smarty.get.page}{/if}"
					    data-type="mark_all" title='{t domain="notification"}标记为已读{/t}'>{t domain="notification"}标记所有为已读{/t}</a>
					<ul class="list-group">
						<li class="list-group-item {if $smarty.get.status eq 'not_read' || !$smarty.get.status}list-group-item-info{/if}">
							<a class="data-pjax" href="{RC_Uri::url('notification/mh_notification/init')}&status=not_read" title='{t domain="notification"}未读通知{/t}'>{t domain="notification"}未读通知{/t}</a>
							<span class="badge badge-danger">{$list.type_count.not_read}</span>
						</li>

						<li class="list-group-item {if $smarty.get.status eq 'all'}list-group-item-info{/if}">
							<a class="data-pjax" href="{RC_Uri::url('notification/mh_notification/init')}&status=all" title='{t domain="notification"}所有通知{/t}'>{t domain="notification"}所有通知{/t}</a>
							<span class="badge badge-primary">{$list.type_count.count}</span>
						</li>
					</ul>
					{if $list.type_list}
					<ul class="list-group">
						<!-- {foreach from=$list.type_list item=val} -->
						<li class="list-group-item {if $smarty.get.status eq $val.type}list-group-item-info{/if}">
							<a class="data-pjax" href='{RC_Uri::url("notification/mh_notification/init")}&status={$val.type}'>{$val.notice_type_title}</a>
							<span class="badge badge-primary">{$val.count}</span>
						</li>
						<!-- {/foreach} -->
					</ul>
					{/if}
				</div>
			</div>
		</div>
	</div>
</div>
<!-- {/block} -->