<?php defined('IN_ECJIA') or exit('No permission resources.'); ?>
<!-- {extends file="ecjia.dwt.php"} -->
<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.admin.contact_plan.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
    <h3 class="heading">
        <!-- {if $ur_here}{$ur_here}{/if} -->
    </h3>
</div>
<div class="row-fluid batch" >
    <form action="{$search_action}" name="theForm">		
		<div class="choose_list f_r">
			<input type="text" class="w250" name="keywords" value="{$smarty.get.keywords}" placeholder="输入客户名称，联系人，电话等关键字"/>
			<input class="btn screen-btn" type="submit" value="搜索">
		</div>
		<div class="choose_list f_r">
			<span class="f_l" style="margin-top:1px">预约时间：</span>
			<input class=" f_l w120 date" name="begin_date" type="text" value="{$smarty.get.begin_date}" placeholder="请选择时间">
			<span class="f_l">-</span>
			<input class=" f_l w120 date" name="end_date" type="text" value="{$smarty.get.end_date}" placeholder="请选择时间">&nbsp;&nbsp;
		</div>
    </form>
</div>
<div class="row-fluid">
    <div class="span12">
        <div class="row-fluid"> 
            <!-- start case list -->
            <table class="table table-striped smpl_tbl table-hide-edit">
                <thead>
                    <tr>
                        <th class="w180">{t}预约时间&客户名称{/t}</th>
                        <th class="w400">{t}联系记录{/t}</th>                       
                        <th class="w150">{t}联系人&电话{/t}</th>
                        <th class="w150">{t}回访客服&时间{/t}</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- {foreach from=$contact_record_list.list  item=list} -->
                    <tr align="center">
                        <td class="hide-edit-area">
                            <div>
                                <div>{$list.next_time}</div>
                                <div>{$list.customer_name}</div>
                            </div>
                            <div class="edit-list">
                                <a class="" target="_blank" href='{url path="customer/admin/contact_add" args="id={$list.customer_id}&feed_id={$list.feed_id}&page={$page}{if $keywords}&keywords={$keywords}{/if}{if $begin_date}&begin_date={$begin_date}{/if}{if $end_date}&end_date={$end_date}{/if}"}' title="{t}回访{/t}">回访</a>&nbsp;
                            	<a class="" target="_blank" href='{url path="customer/admin/detail" args="id={$list.customer_id}&feed_id={$list.feed_id}&page={$page}&status={$status}&keywords={$customer_list.filter.keywords}"}' title="{t}客户详情{/t}">客户详情</a>
                            </div>
                        </td>
						<td class="center-td"><!-- 两行，超出部分隐藏，详情页查看 -->
							<div><b>上次记录：</b>{$list.summary}</div>
						    <div><b>本次目标：</b>{$list.next_goal}</div>
						</td>
						<td class="center-td">
						    <div>{$list.link_man_name}&nbsp;({if $list.sex == 0}男{else}女{/if})</div>
                            <div>{$list.telphone}</div>
						</td>
                        <td class="center-td">
                            <div>{$list.user_name}</div>
                            <div>{$list.add_time}</div>
                        </td>
                    </tr>
                    <!-- {foreachelse} -->
                    <tr>
                        <td class="dataTables_empty" colspan="4">{t}暂无任何记录!{/t}</td>
                    </tr>
                    <!-- {/foreach} -->
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- {$contact_record_list.page} -->
<!-- {/block} -->
