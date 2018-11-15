<?php defined('IN_ECJIA') or exit('No permission resources.'); ?>
<!-- {extends file="ecjia.dwt.php"} -->
<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.admin.linkman.init();
</script>
<style>
    table .no-records
    {
        text-align: center;
        height: 30px;
        line-height: 30px;
    }
	.aa a{	
    	/*display: inline-block;
	    font-weight: 400;
	    height: 41px;
	    overflow: hidden;
	    text-overflow: ellipsis;
	    white-space: nowrap;
	    width: 431px;
	    word-break: keep-all;*/
    	text-decoration:none;
    	color:black;
   }
   .new-table-oddtd  tr > td:nth-child(2n+1){
		 width: 8.5%;
   }
   .new-table-oddtd  tr > td:nth-child(2n){
		 width: 25%;
   }
   #modal-body_new {
		padding: 20px 15px;
   		max-height: 220px;
   		position: relative;
		line-height:220px;
		text-align:center;
		overflow: hidden;
		display:none;
   }
   .modal-body{
		overflow: hidden;
		display:none;
   		overflow-y: auto;
   }
</style>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
    <h3 class="heading">
        <!-- {if $ur_here}{$ur_here}{/if} -->
        {if $action_link}
        <a class="btn plus_or_reply data-pjax" href="{$action_link.href}" id="sticky_a"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
        {/if}
    </h3>

</div>
<!--查看联系人详情开始 -->
	<div class="modal hide fade" id="movetype" style="width:810px;">
			<div class="modal-header">
				<button class="close" data-dismiss="modal">×</button>
				<h3>当前操作：查看联系人详情</h3>
			</div>
			<div class="modal-body">
				 <div class="accordion-group">
			        <div class="accordion-body in collapse" id="">
			            <table class="table table-oddtd m_b0 ">
			                <tbody class="first-td-no-leftbd">
			                    <tr>
			                        <td><div align="right"><strong>{t}联系人{/t}</strong></div></td>
			                        <td id="link-man"></td>
			                        <td><div align="right"><strong>{t}出生年月{/t}</strong></div></td>
			                        <td class="birthday"></td>
			                    </tr>
			                    <tr>
			                        <td><div align="right"><strong>{t}所在部门{/t}</strong></div></td>
			                        <td class="department"></td>
			                        <td><div align="right"><strong>{t}当前职位{/t}</strong></div></td>
			                        <td class="duty"></td>
			                    </tr>
			                    <tr>
			                        <td><div align="right"><strong>{t}联系手机{/t}</strong></div></td>
			                        <td class="mobile"></td>
			                        <td><div align="right"><strong>{t}固定电话{/t}</strong></div></td>
			                        <td class="telphone"></td>
			                    </tr>
			                    <tr>
			                        <td><div align="right"><strong>{t}电子邮箱{/t}</strong></div></td>
			                        <td class="email"></td>
			                        <td><div align="right"><strong>{t}QQ/微信{/t}</strong></div></td>
			                        <td class="qq"></td>
			                    </tr>
			                    <tr>
			                        <td><div align="right"><strong>{t}建档客服{/t}</strong></div></td>
			                        <td class="user_name"></td>
			                        <td><div align="right"><strong>{t}建档时间{/t}</strong></div></td>
			                        <td class="add_time"></td>
			                    </tr>
			                    <tr>
			                        <td><div align="right"><strong>{t}备注信息{/t}</strong></div></td>
			                        <td colspan="3" class="summary"></td>
			                    </tr>
			                </tbody>
			            </table>
			        </div>	
			    </div>
		   </div>
		   <div id="modal-body_new"><img src="{RC_Uri::admin_url('statics/images/ajax_loader.gif')}" alt="{t}正在加载中……{/t}" /></div>
	</div>
<!--查看联系人详情结束 -->

<div class="foldable-list move-mod-group">
    <div class="accordion-group">
        <div class="accordion-heading accordion-heading-url">
            <div class="accordion-toggle acc-in" data-toggle="collapse" data-target="#telescopic1">
                <strong>{t}客户信息{/t}</strong>
            </div>
            <a class="data-pjax accordion-url" href='{url path="customer/admin/edit" args="id={$customer.customer_id}&page={$smarty.get.page}{if $smarty.get.keywords}&keywords={$smarty.get.keywords}{/if}&type=orders{if $status}&status={$status}{/if}"}'>编辑</a>
        </div>
        <div class="accordion-body in collapse" id="telescopic1">
            <table class="table table-oddtd m_b0 new-table-oddtd" >
                <tbody class="first-td-no-leftbd">
                    <tr>
                        <td><div align="right"><strong>{t}客户编号{/t}</strong></div></td>
                        <td>CT{$customer.customer_sn}</td>
                        <td><div align="right"><strong>{t}客户名称{/t}</strong></div></td>
                        <td colspan="3">{$customer.customer_name}</td>
                    </tr>
                    <tr>
                        <td><div align="right"><strong>{t}主联系人{/t}</strong></div></td>
                        <td style="width:8%;">{$customer.link_man}&nbsp;({if $customer.sex eq 0 }男{elseif $customer.sex eq 1}女{/if})</td>
                        <td><div align="right"><strong>{t}手机{/t}</strong></div></td>
                        <td>{$customer.mobile}</td>
                        <td><div align="right"><strong>{t}固定电话{/t}</strong></div></td>
                        <td>{$customer.telphone1}</td>
                    </tr>
                    <tr>
                        <td><div align="right"><strong>{t}办公电话{/t}</strong></div></td>
                        <td>{$customer.telphone2}</td>
                        <td><div align="right"><strong>{t}微信{/t}</strong></div></td>
                        <td>{$customer.wechat}</td>
                        <td><div align="right"><strong>{t}最近联系{/t}</strong></div></td>
                        <td>{$customer.last_contact_time}</td>
                    </tr>
                    <tr>
                        <td><div align="right"><strong>{t}QQ/旺旺{/t}</strong></div></td>
                        <td>{$customer.qq}</td>
                        <td><div align="right"><strong>{t}邮箱{/t}</strong></div></td>
                        <td>{$customer.email}</td>
                    	<td><div align="right"><strong>{t}网址{/t}</strong></div></td>
                        <td>{if $customer.url neq '' AND $customer.url neq 'http://'}<a href="{$customer.url}" target="_blank">{$customer.url}</a>{else}暂无{/if}</td>
                    </tr>
                    <tr>
                    	<td><div align="right"><strong>{t}绑定用户{/t}</strong></div></td>
                        <td>{if $customer.username}{$customer.username}{/if}{if $customer.user_id neq ''&& $customer.user_id neq '0' }({$customer.user_id}){else}未绑定{/if}</td>
                        <td><div align="right"><strong>{t}销售总额{/t}</strong></div></td>
                        <td class="ecjiafc-red">{$customer.sale_total}</td>
                        <td><div align="right"><strong>{t}欠款总额{/t}</strong></div></td>
                        <td class="ecjiafc-red">{$customer.debt_total}</td>
                    </tr>
                    <tr>
                        <td><div align="right"><strong>{t}客服专员{/t}</strong></div></td>
                        <td>{$customer.chargeman}</td>
                        <td><div align="right"><strong>{t}营销顾问{/t}</strong></div></td>
                        <td>{$customer.adviser_name}{if $customer.ad_id}&nbsp;({$customer.ad_id}){/if}</td>
                        <td><div align="right"><strong>{t}预约时间{/t}</strong></div></td>
                        <td>{$customer.reservation_time}</td>
                    </tr>
                    <tr>
                        <td><div align="right"><strong>{t}客户类别{/t}</strong></div></td>
                        <td>{$customer.state_name}</td>
                        <td><div align="right"><strong>{t}客户来源{/t}</strong></div></td>
                        <td>{$customer.source_name}</td>
                        <td><div align="right"><strong>{t}添加时间{/t}</strong></div></td>
                        <td>{$customer.add_time}&nbsp;&nbsp;({$customer.adder})</td>
                    </tr>
                    <tr>
                        <td><div align="right"><strong>{t}客户地址{/t}</strong></div></td>
                        <td colspan="5">{$customer.address}</td>
                    </tr>
                    <tr>
                        <td><div align="right"><strong>{t}客户备注{/t}</strong></div></td>
                        <td colspan="5">{$customer.summary}</td>
                    </tr>
                </tbody>
            </table>
        </div>	
    </div>
</div>

<div class="row-fluid edit-page">
	<div class="span12">
		<div class="tabbable">
			<ul class="nav nav-tabs">
				<li{if $smarty.get.type == 'orders' || $smarty.get.type ==''} class="active"{/if}><a class="data-pjax" href='{url path="customer/admin/detail" args="id={$customer.customer_id}&page={$smarty.get.page}{if $smarty.get.keywords}&keywords={$smarty.get.keywords}{/if}&type=orders{if $status}&status={$status}{/if}"}'>{t}订单信息{/t}</a></li>
				<li{if $smarty.get.type == 'contact'} class="active"{/if}><a class="data-pjax" href='{url path="customer/admin/detail" args="id={$customer.customer_id}&page={$smarty.get.page}{if $smarty.get.keywords}&keywords={$smarty.get.keywords}{/if}&type=contact{if $status}&status={$status}{/if}"}'>{t}联系记录{/t}</a></li>
				<li{if $smarty.get.type == 'linkman'} class="active"{/if}><a class="data-pjax" href='{url path="customer/admin/detail" args="id={$customer.customer_id}&page={$smarty.get.page}{if $smarty.get.keywords}&keywords={$smarty.get.keywords}{/if}&type=linkman{if $status}&status={$status}{/if}"}'>{t}联系人{/t}</a></li>
				<li{if $smarty.get.type == 'service'} class="active"{/if}><a class="data-pjax" href='{url path="customer/admin/detail" args="id={$customer.customer_id}&page={$smarty.get.page}{if $smarty.get.keywords}&keywords={$smarty.get.keywords}{/if}&type=service{if $status}&status={$status}{/if}"}'>{t}服务信息{/t}</a></li>
				<li{if $smarty.get.type == 'tickets'} class="active"{/if}><a class="data-pjax" href='{url path="customer/admin/detail" args="id={$customer.customer_id}&page={$smarty.get.page}{if $smarty.get.keywords}&keywords={$smarty.get.keywords}{/if}&type=tickets{if $status}&status={$status}{/if}"}'>{t}客户工单{/t}</a></li>
				<li{if $smarty.get.type == 'complain'} class="active"{/if}><a class="data-pjax" href='{url path="customer/admin/detail" args="id={$customer.customer_id}&page={$smarty.get.page}{if $smarty.get.keywords}&keywords={$smarty.get.keywords}{/if}&type=complain{if $status}&status={$status}{/if}"}'>{t}客户投诉{/t}</a></li>
				<li{if $smarty.get.type == 'files'} class="active"{/if}><a class="data-pjax" href='{url path="customer/admin/detail" args="id={$customer.customer_id}&page={$smarty.get.page}{if $smarty.get.keywords}&keywords={$smarty.get.keywords}{/if}&type=files{if $status}&status={$status}{/if}"}'>{t}合同文档{/t}</a></li>
			</ul>
		</div>
	</div>
</div>
<!--订单信息 start-->
{if $smarty.get.type == 'orders' || $smarty.get.type ==''}
<div class="foldable-list move-mod-group" style="margin-top:12px">
    <div class="accordion-group">
        <div id="order_info" class="accordion-body">
            <table class="table table-striped" style="margin-bottom:0px">
                <thead>
                    <tr>
                        <th>{t}订单号{/t}</th>
                        <th>{t}产品名称{/t}</th>
                        <th>{t}下单时间{/t}</th>
                        <th>{t}金额{/t}</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- {foreach from =$order_list.list item=list} -->
                    <tr align="center">
                        <td class="center-td">{$list.order_sn}</td>
                        <td class="center-td">{$list.goods_name}</td>
                        <td class="center-td">{$list.pay_time}&nbsp;&nbsp{if $list.pay_time neq 0}(已付款){/if}</td>
                        <td class="center-td">{$list.goods_price}元</td>
                    </tr>
                    <!-- {foreachelse} -->
                    <tr align="center">
                        <td class="dataTables_empty" colspan="4">{t}暂无任何记录!{/t}</td>
                    </tr>
                    <!-- {/foreach} -->
                </tbody>
            </table>
        </div>
    </div>
    <!-- {$order_list.page} -->
</div>
{/if}
<!--订单信息 end-->
<!--联系记录 start-->
{if $smarty.get.type == 'contact'}
<h3 class="heading" style="border-bottom: none; height:30px; margin-bottom:5px;">
    <a class="btn plus_or_reply data-pjax" id="sticky_a" href='{url path="customer/admin/contact_add" args="id={$customer.customer_id}&page={$smarty.get.page}{if $smarty.get.keywords}&keywords={$smarty.get.keywords}{/if}&type=contact{if $status}&status={$status}{/if}"}'><i class="fontello-icon-plus"></i>{t}添加联系记录{/t}</a>
</h3>
<div class="foldable-list move-mod-group">
    <div class="accordion-group">
        <div id="" class="accordion-body">
            <table class="table  table-striped" style="margin-bottom:0px">
                <thead>
                    <tr>
                        <th class="w100">{t}联系时间&客服{/t}</th>
                        <th>{t}联系内容{/t}</th>
                        <th class="w80">{t}类型&方式{/t}</th>
                        <th class="w100">{t}联系人&电话{/t}</th>
                        <th class="w50">{t}操作{/t}</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- {foreach from =$contact_list.list item=list} -->
                    <tr align="center">
                        <td class="center-td">{$list.add_time}<br>{$list.admin_name}</td>
                        <td class="center-td aa"><a title="{$list.summary}">{$list.summary|truncate:118:'...':true}</a></td>
                        <td class="center-td">{$list.type_name}<br>{$list.way_name}</td>
                        <td class="center-td">{if $list.link_man_name}{$list.link_man_name}{/if}{if $list.mobile}<br>{$list.mobile}{/if}</td>
                        <td class="center-td">
                            {assign var=edit_url value=RC_Uri::url('customer/admin/contact_edit',"id={$id}&feed_id={$list.feed_id}&status={$status}{if $page}&page={$page}{/if}{if $type}&type={$type}{/if}{if $keywords}&keywords={$keywords}{/if}")}
					      	<a class="data-pjax" href="{$edit_url}" title="编辑"><i class="fontello-icon-edit"></i></a>
					    	<a class="ajaxremove" data-toggle="ajaxremove" data-msg="{t}您确定要删除此条记录吗？{/t}" href='{RC_Uri::url("customer/admin/contact_remove","feed_id={$list.feed_id}&id={$id}")}' title="{t}移除{/t}"><i class="fontello-icon-trash"></i></a>
                        </td>
                    </tr>
                    <!-- {foreachelse} -->
                    <tr align="center">
                        <td class="dataTables_empty" colspan="5">{t}暂无任何记录!{/t}</td> 
                    </tr>
                    <!-- {/foreach} -->
                </tbody>
            </table>
        </div>
    </div>
   <!-- {$contact_list.page} --> 
</div>
{/if}
<!--联系记录 end-->
<!--联系人 start-->
{if $smarty.get.type == 'linkman'}
<h3 class="heading" style="border-bottom: none; height:30px; margin-bottom:5px;">
    <a class="btn plus_or_reply data-pjax" id="sticky_a" href='{url path="customer/admin/linkman_add" args="id={$customer.customer_id}&page={$smarty.get.page}{if $smarty.get.keywords}&keywords={$smarty.get.keywords}{/if}&type=linkman{if $status}&status={$status}{/if}"}'><i class="fontello-icon-plus"></i>{t}添加联系人{/t}</a>
</h3>
<div class="foldable-list move-mod-group">
    <div class="accordion-group">
        <div id="" class="accordion-body">
            <table class="table table-striped" style="margin-bottom:0px">
                <thead>
                    <tr>
                        <th class="w150">{t}联系人{/t}</th>
                        <th class="w200">{t}部门&职位{/t}</th>
                        <th class="w200">{t}联系电话{/t}</th>
                        <th class="w200">{t}QQ/旺旺{/t}</th>
                        <th class="w200">{t}邮件{/t}</th>
                        <th class="w150">{t}操作{/t}</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- {foreach from =$linkman_list.list item=list} -->
                    <tr align="center">
                        <td class="center-td">{if $list.link_man_name}{$list.link_man_name}&nbsp;({if $list.sex == 0}男{else}女{/if}){/if}</td>
                        <td class="center-td">{$list.department}&nbsp;{if $list.duty}({$list.duty}){/if}</td>
                        <td class="center-td">
                            {$list.mobile}
                        </td>
                        <td class="center-td">{$list.qq}</td>
                        <td class="center-td">{$list.email}</td>
                         <td class=" pagination-centered">
                            <a class="data-pjax" href='{url path="customer/admin/linkman_edit" args="id={$list.customer_id}&link_id={$list.link_id}{if $status}&status={$status}{/if}{if $page}&page={$page}{/if}{if $keywords}&keywords={$keywords}{/if}{if $type}&type={$type}{/if}"}' title="{t}编辑{/t}"><i class="fontello-icon-edit"></i></a>
                            <a class="linkman-detail" href='javascript:;'  title="查看详情" data-url="{$detail_action}&id={$list.customer_id}&link_id={$list.link_id}"><i class="fontello-icon-eye"></i></a>
                            <a class="ajaxremove" data-toggle="ajaxremove" data-msg="{t}您确定要删除此联系人吗？{/t}" href='{RC_Uri::url("customer/admin/linkman_remove","id={$list.customer_id}&link_id={$list.link_id}&link_man_name={$list.link_man_name}")}' title="{t}移除{/t}"><i class="fontello-icon-trash"></i></a>
                        </td>
                    </tr>
                    <!-- {foreachelse} -->
                    <tr align="center">
                        <td class="dataTables_empty" colspan="6">{t}暂无任何记录!{/t}</td> 
                    </tr>
                    <!-- {/foreach} -->
                </tbody>
            </table>
        </div>
    </div>
 <!-- {$linkman_list.page} --> 
</div>
{/if}
<!--联系人 end-->
<!--客户服务 start-->
{if $smarty.get.type == 'service'}
<div class="foldable-list move-mod-group">
    <div class="accordion-group">
        <div id="service_info" class="accordion-body">
            <table class="table table-striped" style="margin-bottom:0px">
                <thead>
	                <tr>
		                <th>{t}服务名称{/t}</th>
		                <th>{t}开始日期{/t}</th>
		                <th>{t}结束日期{/t}</th>
		                <th>{t}添加时间{/t}</th>
		                <th>{t}状态{/t}</th>
	                </tr>
                </thead>
                <tbody>
                    <!-- {foreach from =$service_list.list item=list} -->
                    <tr align="center">
                        <td class="w500 center-td">{$list.service_name}</td>
                        <td class="w70 center-td">{$list.begin_date}</td>
                        <td class="w70 center-td">{$list.end_date}</td>
                        <td class="w100 center-td">{$list.add_time}</td>
                        <td class="w70 center-td">{$list.status_name}</td>
                    </tr>
                     <!-- {foreachelse} -->
                     <tr align="center">
                         <td class="dataTables_empty" colspan="5">{t}暂无任何记录!{/t}</td>
                    </tr>
                    <!-- {/foreach} -->
                </tbody>
            </table>
        </div>
    </div>
<!-- {$service_list.page} -->   
</div>
{/if}
<!--客户服务 end-->
<!--客户工单 start-->
{if $smarty.get.type == 'tickets'}
<div class="foldable-list move-mod-group">
    <div class="accordion-group">
        <div id="customer_workorder" class="accordion-body">
            <table class="table table-striped" style="margin-bottom:0px">
                <thead>
                    <tr>
                        <th class="w150">{t}工单编号{/t}</th>
                        <th class="w300">{t}标题{/t}</th>
                        <th class="w150">{t}状态{/t}</th>
                        <th class="w100">{t}添加时间{/t}</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- {foreach from =$ticket_lists.list item=list} -->
                    <tr align="center">
                        <td class="center-td">{$list.ticket_sn}</td>
                        <td class="center-td">{$list.title}</td>
                        <td class="center-td">
                            {if $list.status eq '0'}用户主动撤销
                            {elseif $list.status eq '1'}待受理
                            {elseif $list.status eq '2'}已受理
                            {elseif $list.status eq '3'}待确认
                            {elseif $list.status eq '4'}待评价
                            {elseif $list.status eq '5'}已关闭
                            {/if}
                        </td>
                        <td class="center-td">{$list.add_time}</td>

                    </tr>
                    <!-- {foreachelse} -->
                    <tr align="center">
                        <td class="dataTables_empty" colspan="4">{t}暂无任何记录!{/t}</td> 
                    </tr>
                    <!-- {/foreach} -->
                </tbody>
            </table>
        </div>
    </div>
<!-- {$ticket_lists.page} -->      
</div>
{/if}
<!--客户工单 end-->
<!--客户投诉 start-->
{if $smarty.get.type == 'complain'}
<div class="foldable-list move-mod-group">
    <div class="accordion-group">
        <div id="customer_complain_info" class="accordion-body">
            <table class="table table-striped" style="margin-bottom:0px">
                <thead>
                    <tr>
                        <th class="w150">{t}投诉工单{/t}</th>
                        <th class="w300">{t}投诉内容{/t}</th>
                        <th class="w150">{t}类型{/t}</th>
                        <th class="w100">{t}投诉时间{/t}</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- {foreach from =$complain_list.list item=list} -->
                    <tr align="center">
                        <td class="center-td">{$list.ticket_sn}</td>
                        <td class="center-td">{$list.reason}</td>
                        <td class="center-td">{if $list.complain_type eq '1'}投诉服务
                            {elseif $list.complain_type eq '2'}产品问题
                            {elseif $list.complain_type eq '1,'}投诉服务
                            {elseif $list.complain_type eq '2,'}产品问题
                            {elseif $list.complain_type eq '1,2'}产品问题,投诉服务
                            {elseif $list.complain_type eq '1,2,'}产品问题,投诉服务
                            {/if}</td>
                        <td class="center-td">{$list.add_time}</td>
                    </tr>
                     <!-- {foreachelse} -->
                     <tr align="center">
                         <td class="dataTables_empty" colspan="4">{t}暂无任何记录!{/t}</td>
                     </tr>
                    <!-- {/foreach} -->
                </tbody>
            </table>
        </div>
    </div>
<!-- {$complain_list.page} -->     
</div>
{/if}
<!--客户投诉 end-->
<!--合同文档 start-->
{if $smarty.get.type == 'files'}
<h3 class="heading" style="border-bottom: none; height:30px; margin-bottom:5px;">
    <a class="btn plus_or_reply data-pjax" id="sticky_a" href='{url path="customer/admin/files_add" args="id={$customer.customer_id}&page={$smarty.get.page}{if $smarty.get.keywords}&keywords={$smarty.get.keywords}{/if}&type=files&status={$status}"}'><i class="fontello-icon-plus"></i>{t}添加文档{/t}</a>
</h3>
<div class="foldable-list move-mod-group">
    <div class="accordion-group">
        <div id="customer_complain_info" class="accordion-body">
            <table class="table table-striped" style="margin-bottom:0px">
                <thead>
                    <tr>
                        <th class="w250">{t}文档名称{/t}</th>
                        <th class="w80">{t}文档类别{/t}</th>
                        <th class="w180">{t}相关附件{/t}</th>
                        <th class="w180">{t}文档说明{/t}</th>
                        <th class="w180">{t}添加时间&添加人{/t}</th>
                        <th class="w80">{t}操作{/t}</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- {foreach from =$files_list.list item=list} -->
                    <tr align="center">
                        <td class="center-td">{$list.doc_name}</td>
                        <td class="center-td">{if $list.doc_category eq '0'}合同文档
                            {else}其他文档
                            {/if}</td>
                        <td class="center-td"><a href="{$list.image_url}" target="_blank" title="点击预览" style="text-decoration: none;">{$list.file_name}</a></td>
                        <td class="center-td">{$list.doc_summary}</td>
                        <td class="center-td">{$list.add_time}&nbsp;({$list.admin_name})</td>
                        <td class="center-td">
                        	<a class="data-pjax" href='{url path="customer/admin/files_edit" args="id={$list.customer_id}&doc_id={$list.doc_id}{if $status}&status={$status}{/if}{if $page}&page={$page}{/if}{if $keywords}&keywords={$keywords}{/if}{if $type}&type={$type}{/if}"}' title="{t}编辑{/t}"><i class="fontello-icon-edit"></i></a>
                            <a class="ajaxremove" data-toggle="ajaxremove" data-msg="{t}您确定要删除此合同文档吗？{/t}" href='{RC_Uri::url("customer/admin/files_remove","id={$list.customer_id}&doc_id={$list.doc_id}&doc_name={$list.doc_name}")}' title="{t}移除{/t}"><i class="fontello-icon-trash"></i></a>
                        </td>
                     </tr>
                     <!-- {foreachelse} -->
                     <tr align="center">
                         <td class="dataTables_empty" colspan="6">{t}暂无任何记录!{/t}</td>
                     </tr>
                     <!-- {/foreach} -->
                </tbody>
            </table>
        </div>
    </div>
 <!-- {$files_list.page} --> 
</div>
{/if}
<!--合同文档 end-->
<!-- {/block} -->
