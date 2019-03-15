<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.admin_express_order.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a class="btn plus_or_reply data-pjax" href="{$action_link.href}"><i class="icon-search"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>

<div class="row-fluid batch" >
	<form action="{$search_action}" name="searchForm" method="post" >
		<div class="choose_list f_r" >
			<input type="text" name="merchant_keywords" value="{$smarty.get.merchant_keywords}" placeholder='{t domain="shipping"}输入商家名称关键字{/t}'/> 
			<input type="text" name="keywords" value="{$smarty.get.keywords}" placeholder='{t domain="shipping"}输入配送流水号等关键字{/t}'/> 
			<button class="btn" type="submit">{t domain="shipping"}搜索{/t}</button>
		</div>
	</form>
</div>

<div class="row-fluid">
	<div class="span12">
		<div class="row-fluid">
			<table class="table table-striped table-hide-edit">
				<thead>
					 <tr>
                        <th class="w150">{t domain="shipping"}配送流水号{/t}</th>
                        <th class="w150">{t domain="shipping"}发货单流水号{/t}</th>
                        <th class="w150">{t domain="shipping"}商家名称{/t}</th>
                        <th class="w110">{t domain="shipping"}收货人名称{/t}</th>
                        <th class="w120">{t domain="shipping"}联系方式{/t}</th>
                        <th class="w150">{t domain="shipping"}收货地址{/t}</th>
                        <th class="w180">{t domain="shipping"}创建时间{/t}</th>
                        <th class="w100">{t domain="shipping"}配送来源{/t}</th>
                        <th class="w100">{t domain="shipping"}配送状态{/t}</th>
                    </tr>
				</thead>
				<tbody>
				 <!-- {foreach from=$express_list.list item=express} -->
                    <tr>
                        <td class="hide-edit-area">
                            {$express.express_sn}
                            <br/>
                            <div class="edit-list">
                                <a class="data-pjax" href='{RC_Uri::url("shipping/admin_express_order/info", "express_id={$express.express_id}")}' title='{t domain="shipping"}查看详情{/t}'>{t domain="shipping"}查看详情{/t}</a>
                            </div>
                        </td>
                        <td>{$express.delivery_sn}</td>
                        <td class="ecjiafc-red">
                            {$express.merchants_name}
                        </td>
                        <td>
                            {$express.consignee}
                        </td>
                        <td>
                            {$express.mobile}
                        </td>
                        <td>{$express.address}</td>
                        <td>{$express.formatted_add_time}</td>
                        <td>{$express.label_from}</td>
                        <td>{$express.label_status}</td>
                    </tr>
                    <!-- {foreachelse} -->
                    <tr><td class="no-records" colspan="9">{t domain="shipping"}没有找到任何记录{/t}</td></tr>
                  <!-- {/foreach} -->
				</tbody>
			</table>
			<!-- {$express_list.page} -->	
		</div>
	</div>
</div>
<!-- {/block} -->