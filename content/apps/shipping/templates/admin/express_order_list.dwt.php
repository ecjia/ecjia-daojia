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
			<input type="text" name="merchant_keywords" value="{$smarty.get.merchant_keywords}" placeholder="{lang key='shipping::shipping.admin_enter_merchant_keywords'}"/> 
			<input type="text" name="keywords" value="{$smarty.get.keywords}" placeholder="{lang key='shipping::shipping.admin_pls_express_sn'}"/> 
			<button class="btn" type="submit">{lang key='shipping::shipping.admin_search_express'}</button>
		</div>
	</form>
</div>

<div class="row-fluid">
	<div class="span12">
		<div class="row-fluid">
			<table class="table table-striped table-hide-edit">
				<thead>
					 <tr>
                        <th class="w150">{lang key='shipping::shipping.admin_express_sn'}</th>
                        <th class="w150">{lang key='shipping::shipping.admin_delivery_sn'}</th>
                        <th class="w150">{lang key='shipping::shipping.admin_merchants_name'}</th>
                        <th class="w110">{lang key='shipping::shipping.admin_consignee'}</th>
                        <th class="w120">{lang key='shipping::shipping.admin_mobile'}</th>
                        <th class="w150">{lang key='shipping::shipping.admin_address'}</th>
                        <th class="w180">{lang key='shipping::shipping.admin_add_time'}</th>
                        <th class="w100">{lang key='shipping::shipping.admin_from'}</th>
                        <th class="w100">{lang key='shipping::shipping.admin_express_status'}</th>
                    </tr>
				</thead>
				<tbody>
				 <!-- {foreach from=$express_list.list item=express} -->
                    <tr>
                        <td class="hide-edit-area">
                            {$express.express_sn}
                            <br/>
                            <div class="edit-list">
                                <a class="data-pjax" href='{RC_Uri::url("shipping/admin_express_order/info", "express_id={$express.express_id}")}' title="{lang key='shipping::shipping.admin_view_info'}">{lang key='shipping::shipping.admin_view_info'}</a><!-- &nbsp;|&nbsp;
                                <a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg="{lang key='bonus::bonus.remove_bonustype_confirm'}" href='{RC_Uri::url("bonus/merchant/remove","id={$type.type_id}")}' title="{lang key='system::system.remove'}">{lang key='system::system.drop'}</a> -->
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
                    <tr><td class="no-records" colspan="9">{lang key='system::system.no_records'}</td></tr>
                  <!-- {/foreach} -->
				</tbody>
			</table>
			<!-- {$express_list.page} -->	
		</div>
	</div>
</div>
<!-- {/block} -->