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
		<!-- {foreach from=$list item=item} -->
			<div class="chat_content">
				<div class="chat_heading clearfix">
					<span class="badge badge-danger">{$item.count}</span>
					{$item.type_title}
					<a class="f_r toggle_view no-underline" href="{RC_Uri::url('notification/admin/mark_read')}{if $smarty.get.status}&status={$smarty.get.status}{/if}" data-type="{$item.type}" title="标记为已读">标记 {$item.type} 的当前通知为已读</a>
				</div>
				
				<div class="msg_window">
					<!-- {foreach from=$item.list item=val} -->
                  		<div class="panel-body">
                    		<i class=" fontello-icon-comment"></i>
              				<span class="text-content">{$val.content}</span>
                            <span class="edit-range f_r">
                            	<span class="m_r5">{$val.created_time}</span>
                                <!-- {if !$val.read_at} -->
                                <a class="toggle_view" href="{RC_Uri::url('notification/admin/mark_read')}{if $smarty.get.status}&status={$smarty.get.status}{/if}" data-id="{$val.id}" title="标记为已读">
                                	<i class="fontello-icon-ok"></i>
                                </a>
                                <!-- {else} -->
                                <a href="javascript:;" title="已读">
                                	<i class="stop_color fontello-icon-ok"></i>
                                </a>
                                <!-- {/if} -->
                            </span>
                    	</div>
                	<!-- {/foreach} -->
				</div>
			</div>
		<!-- {foreachelse} -->
			<div class="notice_empty text-center">
            	<div class="ui tertiary segment">
					<div class="ui list">
						<div class="item">
							<i class="fontello-icon-bell-alt"></i>
						</div>
						<div class="item">
							<h3 class="ui header">没有相关未读消息</h3>
						</div>
					</div>
				</div>
 			</div>
		<!-- {/foreach} -->
		</div>

		<div class="span4 chat_sidebar">
			<div class="chat_heading clearfix">
				<div class="btn-group pull-right">
					<a class="btn btn-mini ttip_t data-pjax" title="{t}刷新{/t}" href='{url path="notification/admin/init" args="{if $smarty.get.status}&status={$smarty.get.status}{/if}"}'><i class="icon-refresh"></i></a>
					<a href="#" data-toggle="dropdown" class="dropdown-toggle btn btn-mini ttip_t" oldtitle="Options" aria-describedby="ui-tooltip-3"><i class="icon-cog"></i></a>
					<ul class="dropdown-menu">
						<li><a class="toggle_view" href="{RC_Uri::url('notification/admin/mark_read')}{if $smarty.get.status}&status={$smarty.get.status}{/if}" {if $count.count neq 0 }data-type="mark_all"{/if} title="标记为已读">标记所有为已读</a></li>
					</ul>
				</div>
			</div>
			<ul class="chat_user_list">
				<li class="{if $smarty.get.status eq 'not_read'}active{/if}">
					<a class="data-pjax" href="{RC_Uri::url('notification/admin/init')}&status=not_read" title="未读通知">未读通知</a>
					<span class="badge badge-danger">{$count.not_read}</span>
				</li>
				
				<li class="{if $smarty.get.status neq 'not_read'}active{/if}">
					<a class="data-pjax" href="{RC_Uri::url('notification/admin/init')}&status=all" title="所有通知">所有通知</a>
					<span class="badge badge-primary">{$count.count}</span>
				</li>
			</ul>
		</div>
	</div>
</div>

<!-- {/block} -->