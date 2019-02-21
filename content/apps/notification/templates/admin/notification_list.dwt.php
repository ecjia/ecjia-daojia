<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.notice_list.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
	</h3>
</div>

<div class="row-fluid notice_list">
	<div class="chat_box">
		<div class="span8">
			{if $list.item}
			<div class="chat_content">
				<div class="msg_window">
					<!-- {foreach from=$list.item item=val} -->
					<div class="panel-body">
						<i class=" fontello-icon-comment"></i>
						<span class="text-content">【{$val.type_title}】{$val.content}</span>
						<span class="edit-range f_r">
							<span class="m_r5">{$val.created_time}</span>
							<!-- {if !$val.read_at} -->
							<a class="toggle_view" href="{RC_Uri::url('notification/admin/mark_read')}{if $smarty.get.status}&status={$smarty.get.status}{/if}"
							    data-id="{$val.id}" title='{t domain="notification"}标记为已读{/t}'>
								<i class="fontello-icon-ok"></i>
							</a>
							<!-- {else} -->
							<a href="javascript:;" title='{t domain="notification"}已读{/t}'>
								<i class="stop_color fontello-icon-ok"></i>
							</a>
							<!-- {/if} -->
						</span>
					</div>
					<!-- {/foreach} -->
				</div>
			</div>
			{else}
			<div class="notice_empty text-center">
				<div class="ui tertiary segment">
					<div class="ui list">
						<div class="item">
							<i class="fontello-icon-bell-alt"></i>
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

		<div class="span4 chat_sidebar">
			<div class="chat_heading clearfix">
				<div class="btn-group pull-right">
					<a class="btn btn-mini ttip_t data-pjax" title='{t domain="notification"}刷新{/t}' href='{url path="notification/admin/init" args="{if $smarty.get.status}&status={$smarty.get.status}{/if}"}'><i
						    class="icon-refresh"></i></a>
					<a href="#" data-toggle="dropdown" class="dropdown-toggle btn btn-mini ttip_t" oldtitle="Options" aria-describedby="ui-tooltip-3"><i
						    class="icon-cog"></i></a>
					<ul class="dropdown-menu">
						<li><a class="toggle_view" href="{RC_Uri::url('notification/admin/mark_read')}{if $smarty.get.status}&status={$smarty.get.status}{/if}{if $smarty.get.page}&page={$smarty.get.page}{/if}"
							    data-type="mark_all" title='{t domain="notification"}标记为已读{/t}'>{t domain="notification"}标记所有为已读{/t}</a></li>
					</ul>
				</div>
			</div>
			<ul class="chat_user_list">
				<li class="{if $smarty.get.status eq 'not_read' || !$smarty.get.status}active{/if}">
					<a class="data-pjax" href="{RC_Uri::url('notification/admin/init')}&status=not_read" title='{t domain="notification"}未读通知{/t}'>{t domain="notification"}未读通知{/t}</a>
					<span class="badge badge-danger">{$list.type_count.not_read}</span>
				</li>

				<li class="{if $smarty.get.status eq 'all'}active{/if}">
					<a class="data-pjax" href="{RC_Uri::url('notification/admin/init')}&status=all" title='{t domain="notification"}所有通知{/t}'>{t domain="notification"}所有通知{/t}</a>
					<span class="badge badge-primary">{$list.type_count.count}</span>
				</li>
				{if $list.type_list}
				<!-- {foreach from=$list.type_list item=val} -->
				<li class="{if $smarty.get.status eq $val.type}active{/if}">
					<a class="data-pjax" href="{RC_Uri::url('notification/admin/init')}&status={$val.type}">{$val.notice_type_title}</a>
					<span class="badge badge-primary">{$val.count}</span>
				</li>
				<!-- {/foreach} -->
				{/if}
			</ul>
		</div>
	</div>
</div>

<!-- {/block} -->