<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->
<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.admin.printer.init();
</script>
<!-- {/block} -->
<!-- {block name="main_content"} -->
<div>
    <h3 class="heading">
        <!-- {if $ur_here}{$ur_here}{/if} -->
        <!-- {if $action_link} -->
        <a class="data-pjax btn plus_or_reply" id="sticky_a" href="{$action_link.href}"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
        <!-- {/if} -->
    </h3>
</div>

<div class="row-fluid m_b20">
    <div class="span3">
        <!-- {ecjia:hook id=display_admin_store_menus} -->
    </div>
    <div class="span9">
 		<div class="panel-body panel-body-small">
 			<section class="panel">
                <table class="table table-striped table-hide-edit">
                    <thead>
                        <tr>
							<th class="w120">打印机名称</th>
                            <th class="w100">订单编号</th>
                            <th class="w100">打印编号</th>
                          	<th class="w100">订单类型</th>
                          	<th class="w120">打印时间</th>
                          	<th class="w120">打印状态</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- {foreach from=$record_list.item item=list} -->
                        <tr>
                        	<td class="hide-edit-area">
                        		{$list.machine_name}
                        		<div class="edit-list">
                        			<a class="view_print_content" href="javascript:;">查看打印内容</a>&nbsp;|&nbsp;
	                             	<input type="hidden" value="{$list.content}" />
                            		<a class="data-pjax toggle_view" href="{RC_Uri::url('printer/admin_store_printer/reprint')}&id={$list.id}">重新打印</a>
                            		{if $list.status eq 0 || $list.status eq 2}
                            		&nbsp;|&nbsp;<a class="data-pjax toggle_view" href="{RC_Uri::url('printer/admin_store_printer/cancel_print')}&id={$list.id}&page={$smarty.get.page}">取消打印</a>
                            		{/if}
                            	</div>
                        	</td>
                        	
                            <td>{$list.order_sn}</td>
                            <td>{$list.print_order_id}</td>
                      		<td>
								{if $list.order_type eq 'test'}
								测试订单
								{else if $list.order_type eq 'buy'}
								普通订单
								{else if $list.order_type eq 'takeaway'}
								到店购物订单
								{else if $list.order_type eq 'quickpay'}
								优惠买单订单
								{/if}                                	
	                  		</td>
                            <td>{RC_Time::local_date('Y-m-d H:i:s', $list['print_time'])}</td>
                            <td>
                            	{if $list.status eq 0}
                            	待打印
                            	{else if $list.status eq 1}
                            	打印完成
                            	{else if $list.status eq 2}
                            	打印异常
                            	{else if $list.status eq 10}
                            	取消打印
                            	{/if}
                            </td>
                        </tr>
                        <!-- {foreachelse} -->
                        <tr><td class="no-records" colspan="6">{lang key='system::system.no_records'}</td></tr>
                        <!-- {/foreach} -->
                    </tbody>
                </table>
                <!-- {$record_list.page} -->
            </section>
		</div>
    </div>
</div>

<div class="modal hide fade" id="print_content">
	<div class="modal-header">
		<button class="close" data-dismiss="modal">×</button>
		<h3>{t}打印内容{/t}</h3>
	</div>
	<div class="modal-body">
		<pre></pre>
	</div>
</div>
<!-- {/block} -->
