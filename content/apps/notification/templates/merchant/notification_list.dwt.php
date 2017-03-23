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
					<!-- {foreach from=$list item=item} -->
					<div class="panel panel-default">
	                	<div class="panel-heading">
	                 		<header class="pull-left">
	                    		<span class="badge badge-danger">{$item.count}</span>
	                 			{$item.type_title}
	            			</header>
	                    	<a class="pull-right toggle_view" href="{RC_Uri::url('notification/mh_notification/mark_read')}{if $smarty.get.status}&status={$smarty.get.status}{/if}" data-type="{$item.type}" title="标记为已读">标记 {$item.notice_type} 的当前通知为已读</a>
	                        <div class="clear"></div>
	               		</div>
           				<!-- {foreach from=$item.list item=val} -->
                  		<div class="panel-body">
                    		<i class="fa fa-comment"></i>
              				<span class="text-content">{$val.content}</span>
                            <span class="edit-range f_r">
                            	<span class="m_r5">{$val.created_time}</span>
                                <!-- {if !$val.read_at} -->
                                <a class="toggle_view" href="{RC_Uri::url('notification/mh_notification/mark_read')}{if $smarty.get.status}&status={$smarty.get.status}{/if}" data-id="{$val.id}" title="标记为已读">
                                	<i class="fa fa-check"></i>
                                </a>
                                <!-- {else} -->
                                <a href="javascript:;" title="已读">
                                	<i class="fa fa-check stop_color"></i>
                                </a>
                                <!-- {/if} -->
                            </span>
                    	</div>
                	<!-- {/foreach} -->
               		</div>
               		<!-- {foreachelse} -->
               		<div class="text-center">
               			<div class="ui tertiary segment">
							<div class="ui list">
								<div class="item">
									<i class="fa fa-bell"></i>
								</div>
								<div class="item">
									<h3 class="ui header">没有相关未读消息</h3>
								</div>
							</div>
						</div>
               		</div>
               		<!-- {/foreach} -->
				</div>
			
				<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 pull-right">
					<a class="btn btn-success btn-block m_b10 toggle_view" href="{RC_Uri::url('notification/mh_notification/mark_read')}{if $smarty.get.status}&status={$smarty.get.status}{/if}" {if $count.count neq 0 }data-type="mark_all"{/if} title="标记为已读">标记所有为已读</a>
					<ul class="list-group">
						<li class="list-group-item {if $smarty.get.status eq 'not_read'}list-group-item-info{/if}">
							<a class="data-pjax" href="{RC_Uri::url('notification/mh_notification/init')}&status=not_read" title="未读通知">未读通知</a>
							<span class="badge badge-danger">{$count.not_read}</span>
						</li>
						
						<li class="list-group-item {if $smarty.get.status neq 'not_read'}list-group-item-info{/if}">
							<a class="data-pjax" href="{RC_Uri::url('notification/mh_notification/init')}&status=all" title="所有通知">所有通知</a>
							<span class="badge badge-primary">{$count.count}</span>
						</li>
					</ul>
				</div>
				
			</div>
		</div>
	</div>
</div>
<!-- {/block} -->