<?php defined('IN_ECJIA') or exit('No permission resources.'); ?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.admin.admin_express_order_list.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
    <h3 class="heading">
        <!-- {if $ur_here}{$ur_here}{/if} -->
        <!-- {if $action_link} -->
        <a class="btn plus_or_reply data-pjax" href="{$action_link.href}" id="sticky_a"><i
                    class="fontello-icon-plus"></i>{$action_link.text}</a>
        <!-- {/if} -->
    </h3>
</div>

<div class="wait-grab-order-detail">
    <div class="modal order-detail hide fade" id="myModal1" style="height:590px;"></div>
</div>

<div class="assign-order-detail">
    <div class="modal express-reassign-modal hide fade" id="myModal2" style="height:590px;"></div>
</div>

<!-- 批量操作和搜索 -->
<div class="row-fluid batch" >
	<ul class="nav nav-pills" style="margin-bottom:5px;">
		<li class="{if $type eq ''}active{/if}"><a class="data-pjax" href='{url path="express/admin_reminder/init" args="{if $keywords}&keywords={$keywords}{/if}"}'>{t domain="express"}全部{/t}<span class="badge badge-info">{if $express_remind_count.whole}{$express_remind_count.whole}{else}0{/if}</span> </a></li>
		<li class="{if $type eq 'wait_process'}active{/if}"><a class="data-pjax" href='{url path="express/admin_reminder/init" args="type=wait_process{if $keywords}&keywords={$keywords}{/if}"}'>{t domain="express"}待处理{/t}<span class="badge badge-info">{if $express_remind_count.wait_process}{$express_remind_count.wait_process}{else}0{/if}</span> </a></li>
		<li class="{if $type eq 'processed'}active{/if}"><a class="data-pjax" href='{url path="express/admin_reminder/init" args="type=processed{if $keywords}&keywords={$keywords}{/if}"}'>{t domain="express"}已处理{/t} <span class="badge badge-info">{if $express_remind_count.processed}{$express_remind_count.processed}{else}0{/if}</span> </a></li>
		<form method="post" action="{$search_action}{if $type}&type={$type}{/if}" name="searchForm">
	        <div class="choose_list f_r">
	            <input type="text" name="keywords" value="{$smarty.get.keywords}" placeholder='{t domain="express"}请输入配送单号或收货人关键字{/t}'/>
	            <button class="btn search_express" type="submit">{t domain="express"}搜索{/t}</button>
	        </div>
	    </form>
	</ul>
</div>

<div class="row-fluid">
    <div class="span12">
        <table class="table table-striped smpl_tbl table-hide-edit">
            <thead>
            <tr>
                <th class="table_checkbox"><input type="checkbox" name="select_rows" data-toggle="selectall" data-children=".checkbox"/></th>
                <th class="w150">{t domain="express"}配送单号{/t}</th>
                <th class="w150">{t domain="express"}收货人{/t}</th>
                <th class="w150">{t domain="express"}收货地址{/t}</th>
                <th class="w100">{t domain="express"}审核状态{/t}</th>
                <th class="w100">{t domain="express"}催单时间{/t}</th>
            </tr>
            </thead>
            <!-- {foreach from=$result_list.list item=express} -->
            <tr>
                <td>
                    <span><input type="checkbox" name="checkboxes[]" class="checkbox" value="{$express.express_id}"/></span>
                </td>
                <td class="hide-edit-area">
                    {$express.express_sn}
                    <div class="edit-list">
                        <a class="express-order-modal" data-toggle="modal" data-backdrop="static" href="#myModal1"
                           express-id="{$express.express_id}"
                           express-order-url='{url path="express/admin_reminder/order_detail" args="express_id={$express.express_id}&store_id={$express.store_id}"}'
                           title='{t domain="express"}查看详情{/t}'>{t domain="express"}查看详情{/t}</a>
                        {if $express.unformat_status eq '0'}
                        	&nbsp;|&nbsp;<a class="express-reassign-click" data-toggle="modal" data-backdrop="static" href="#myModal2"
                           express-id="{$express.express_id}"
                           express-reassign-url='{url path="express/admin_reminder/express_detail" args="express_id={$express.express_id}&store_id={$express.store_id}"}'
                           title='{t domain="express"}重新指派{/t}'>{t domain="express"}指派订单{/t}</a>
                        {/if}  
                    </div>
                </td>
                <td>
                    {$express.consignee}<br/>
                    {$express.mobile}
                </td>
                <td>{$express.express_all_address}{$express.address}</td>
                <td>{$express.status}</td>
                <td>{$express.create_time}</td>
            </tr>
            <!-- {foreachelse} -->
            <tr>
                <td class="no-records" colspan="6">{t domain="express"}没有找到任何记录{/t}</td>
            </tr>
            <!-- {/foreach} -->
            </tbody>
        </table>
        <!-- {$result_list.page} -->
    </div>
</div>
<!-- {/block} -->