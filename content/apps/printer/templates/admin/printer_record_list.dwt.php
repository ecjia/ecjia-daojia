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
        <a class="btn plus_or_reply" id="sticky_a" href="{$action_link.href}"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
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
							<th class="w120">{t domain="printer"}打印机名称{/t}</th>
                            <th class="w100">{t domain="printer"}订单编号{/t}</th>
                            <th class="w100">{t domain="printer"}打印编号{/t}</th>
                          	<th class="w100">{t domain="printer"}订单类型{/t}</th>
                          	<th class="w120">{t domain="printer"}打印时间{/t}</th>
                          	<th class="w120">{t domain="printer"}打印状态{/t}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- {foreach from=$record_list.item item=list} -->
                        <tr>
                        	<td class="hide-edit-area">
                        		{$list.machine_name}
                        		<div class="edit-list">
                        			<a class="view_print_content" href="javascript:;">{t domain="printer"}查看打印内容{/t}</a>&nbsp;|&nbsp;
	                             	<input type="hidden" value="{$list.content}" />
                            		<a class="data-pjax toggle_view" href="{RC_Uri::url('printer/admin_store_printer/reprint')}&id={$list.id}">{t domain="printer"}重新打印{/t}</a>
                            		{if $list.status eq 0 || $list.status eq 2}
                            		&nbsp;|&nbsp;<a class="data-pjax toggle_view" href="{RC_Uri::url('printer/admin_store_printer/cancel_print')}&id={$list.id}&page={$smarty.get.page}">{t domain="printer"}取消打印{/t}</a>
                            		{/if}
                            	</div>
                        	</td>
                        	
                            <td>{$list.order_sn}</td>
                            <td>{$list.print_order_id}</td>
                      		<td>
								{if $list.order_type eq 'test'}
                                {t domain="printer"}测试订单{/t}
								{else if $list.order_type eq 'buy'}
                                {t domain="printer"}普通订单{/t}
								{else if $list.order_type eq 'takeaway'}
                                {t domain="printer"}到店购物订单{/t}
								{else if $list.order_type eq 'quickpay'}
                                {t domain="printer"}优惠买单订单{/t}
								{/if}                                	
	                  		</td>
                            <td>{RC_Time::local_date('Y-m-d H:i:s', $list['print_time'])}</td>
                            <td>
                            	{if $list.status eq 0}
                                {t domain="printer"}待打印{/t}
                            	{else if $list.status eq 1}
                                {t domain="printer"}打印完成{/t}
                            	{else if $list.status eq 2}
                                {t domain="printer"}打印异常{/t}
                            	{else if $list.status eq 10}
                                {t domain="printer"}取消打印{/t}
                            	{/if}
                            </td>
                        </tr>
                        <!-- {foreachelse} -->
                        <tr><td class="no-records" colspan="6">{t domain="printer"}没有找到任何记录{/t}</td></tr>
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
		<h3>{t domain="printer"}打印内容{/t}</h3>
	</div>
	<div class="modal-body">
		<pre></pre>
	</div>
</div>
<!-- {/block} -->
