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
		<li class="{if $type eq ''}active{/if}"><a class="data-pjax" href='{url path="express/admin_reminder/init" args="{if $keywords}&keywords={$keywords}{/if}"}'>全部<span class="badge badge-info">{if $express_remind_count.whole}{$express_remind_count.whole}{else}0{/if}</span> </a></li>
		<li class="{if $type eq 'wait_process'}active{/if}"><a class="data-pjax" href='{url path="express/admin_reminder/init" args="type=wait_process{if $keywords}&keywords={$keywords}{/if}"}'>待处理<span class="badge badge-info">{if $express_remind_count.wait_process}{$express_remind_count.wait_process}{else}0{/if}</span> </a></li>
		<li class="{if $type eq 'processed'}active{/if}"><a class="data-pjax" href='{url path="express/admin_reminder/init" args="type=processed{if $keywords}&keywords={$keywords}{/if}"}'>已处理 <span class="badge badge-info">{if $express_remind_count.processed}{$express_remind_count.processed}{else}0{/if}</span> </a></li>
		<form method="post" action="{$search_action}{if $type}&type={$type}{/if}" name="searchForm">
	        <div class="choose_list f_r">
	            <input type="text" name="keywords" value="{$smarty.get.keywords}" placeholder="请输入配送单号或收货人关键字"/>
	            <button class="btn search_express" type="submit">搜索</button>
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
                <th class="w150">配送单号</th>
                <th class="w150">收货人</th>
                <th class="w150">收货地址</th>
                <th class="w100">审核状态</th>
                <th class="w100">催单时间</th>
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
                           title="查看详情">查看详情</a>
                        {if $express.unformat_status eq '0'}
                        	&nbsp;|&nbsp;<a class="express-reassign-click" data-toggle="modal" data-backdrop="static" href="#myModal2"
                           express-id="{$express.express_id}"
                           express-reassign-url='{url path="express/admin_reminder/express_detail" args="express_id={$express.express_id}&store_id={$express.store_id}"}'
                           title="重新指派">指派订单</a>
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
                <td class="no-records" colspan="6">{lang key='system::system.no_records'}</td>
            </tr>
            <!-- {/foreach} -->
            </tbody>
        </table>
        <!-- {$result_list.page} -->
    </div>
</div>
<!-- {/block} -->