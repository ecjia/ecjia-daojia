<?php defined('IN_ECJIA') or exit('No permission resources.'); ?>
<!-- {extends file="ecjia.dwt.php"} -->
<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.admin.search.init();
    ecjia.admin.search.common_search();
    ecjia.admin.customer.get_customer();
</script>
<style>
<!--
.chzn-drop .chzn-results {
	max-height: 140px;
    overflow-y: auto;
}
-->
</style>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div class="alert alert-info" style=" line-height: 150%">	
	公共客户的数据来源：1. 建档客服或者客服专员，主动放弃的客户； 2. 超过跟进周期，被系统自动回收的客户；
</div>
<div>
    <h3 class="heading">
        <!-- {if $ur_here}{$ur_here}{/if} -->
    </h3>
</div>
<!-- 批量指派客户开始 -->
	<div class="modal hide fade" id="batch_assign_customers_model" style="width:494px;">
			<div class="modal-header">
				<button class="close" data-dismiss="modal">×</button>
				<h3>当前操作：批量指派客户</h3>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" name=""  method="" action="">
					<div class="control-group formSep control-group-small">
						<label class="control-label">管理员：</label>
						<select class="w200 f_l" name="customer_assign" id="admin_id">
			                <option class="" value="">请选择管理员</option>
							<!-- {foreach from=$admin_list item=list key=okey} -->
							<option class="" value="{$list.user_id}">{$list.user_name}</option>
							<!-- {/foreach} -->
						</select>
						<span class="input-must">*</span>
					</div>
					<div class="control-group formSep control-group-small">
						<label class="control-label">原因：</label>
						<div class="controls">
							<textarea class=" h70 w280" rows="3" cols="40" name="reason"></textarea>
						</div>
					</div>
					<div class="control-group control-group-small">
						<label class="control-label"></label>
						<div class="chk_radio control">
							<input type="checkbox" name="send_email_notice" value="1" checked="true" style="opacity: 0;">
							<span class="replyemail">邮件通知</span>&nbsp;&nbsp;
						</div>
					</div>
					<div class="control-group t_c" style="margin-bottom:0px;">
						<a class="btn btn-gebo batchsubmit" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{url path='customer/admin/batch' args='type=button_assign_customer&refer=public'}" data-msg="选中客户将指派给新负责人。您确定要这么做吗？" data-noSelectMsg="请选择要指派的客户" href="javascript:;" name="assign_customer_ture">指派</a>
					</div>
				</form>
		  </div>
	</div>
<!-- 批量指派客户结束 -->
<div class="row-fluid batch" >
    <form action="{$search_action}&status={$status}" name="searchForm">	
    {if $customer_get || $customer_assign_batch}
    <div class="btn-group f_l m_r5">
        <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
            <i class="fontello-icon-cog"></i>{t}批量操作{/t}
            <span class="caret"></span>
        </a>
        <ul class="dropdown-menu batch-move" data-url="{RC_Uri::url('customer/admin/batch')}">
        	{if $customer_get}
        		<li><a data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url='{url path="customer/admin/get_customer" args="batch=true{if $page}&page={$page}{/if}{if $keywords}&keywords={$keywords}{/if}{if $customer_type}&customer_type={$customer_type}{/if}{if $customer_source}&customer_source={$customer_source}{/if}" }' data-noSelectMsg="请选择要领用的客户" href="javascript:;"> <i class="fontello-icon-ok" style="color:#000"></i>{t}领用{/t}</a></li>
        	{/if}
        	{if $customer_assign_batch}
        	<li><a class="batch-assign-customer"data-name="assign_customers" data-move="data-operatetype" href="javascript:;" title="指派"> <i class="fontello-icon-right-hand"></i>{t}指派{/t}</a></li>
        	{/if}
        </ul>
    </div>
    {/if}
    <div class="choose_list f_r">
        <select class="w200 m_l5" name="type_customer">
			<option value="0" >{t}请选择客户类别{/t}</option>
              <!-- {foreach from=$customer_type_list item=state } -->
				<option value="{$state.state_id}" {if $state.state_id == $smarty.get.type_customer}selected{/if}>{$state.state_name}</option>
			  <!-- {/foreach} -->
		</select>&nbsp;&nbsp;
		<input type="text" class="w250" name="keywords" value="{$smarty.get.keywords}" placeholder="输入客户名称，联系人，电话等关键字"/>
		<input class="btn screen-btn" type="submit" value="搜索">
	</div>
    </form>
</div>
<div class="row-fluid">
    <div class="span12">
        <div class="row-fluid"> 
            <!-- start case list -->
            <table class="table table-striped smpl_tbl table-hide-edit">
                <thead>
                    <tr data-sorthref='{url path="customer/admin/init" args="status={$status}"}'>
                        <th class="table_checkbox"><input type="checkbox" data-toggle="selectall" data-children=".checkbox" /></th>
                        <th class="w120">{t}客户编号{/t}</th>
                        <th class="w150">{t}客户名称{/t}</th>
                        <th class="w100">{t}联系人{/t}</th>                       
                        <th class="w100">{t}联系方式{/t}</th>
                        <th class="w100">{t}客户类别{/t}</th>
                        <th class="w70">{t}操作{/t}</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- {foreach from=$customer_list.list  item=list} -->
                    <tr align="center">
                        <td>
                            <span><input class="checkbox" type="checkbox" name="checkboxes[]"  value="{$list.customer_id}" /></span>
                        </td>
                        <td>
                            <div>
                                <div class="">
                                <a class="data-pjax" href='{url path="customer/admin/detail" args="id={$list.customer_id}&refer=public{if $page}&page={$page}{/if}{if $status}&status={$status}{/if}{if $keywords}&keywords={$keywords}{/if}{if $customer_type}&customer_type={$customer_type}{/if}{if $customer_source}&customer_source={$customer_source}{/if}"}' title="{t}客户详情{/t}">CT{$list.customer_sn}</a>
                                </div>
                            </div>
                            <div style=" margin-bottom:23px">
                                <div class="edit-list" style=" color:#222;opacity:1;">添加于&nbsp;&nbsp;{$list.add_time}&nbsp;&nbsp;{if $list.adder}({$list.add_user_name}){/if}
                                </div>
                            </div>
                        </td>
                        <td>
                            {if $list.url neq 'http://' AND $list.url neq ''}<a href="{$list.url}" target="_blank">{$list.customer_name}</a>{else}{$list.customer_name}{/if}
                        </td>
						<td>{$list.link_man}&nbsp;({if $list.sex == 0}男{else}女{/if})</td>
                        <td>
                            <div class="w115">
                                {$list.telphone1}
                            </div>
                            {$list.mobile}
                        </td>
                        <td>{$list.state_name}</td>
                        <td><a class="get_customer" href="javascript:;" data-id="{$list.customer_id}" data-url='{url path="customer/admin/get_customer" args="id={$list.customer_id}{if $page}&page={$page}{/if}{if $status}&status={$status}{/if}{if $keywords}&keywords={$keywords}{/if}{if $customer_type}&customer_type={$customer_type}{/if}{if $customer_source}&customer_source={$customer_source}{/if}"}' >领用</a></td>
                    </tr>
                    <!-- {foreachelse} -->
                    <tr>
                        <td class="dataTables_empty" colspan="7">{t}暂无任何记录!{/t}</td>
                    </tr>
                    <!-- {/foreach} -->
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- {$customer_list.page} -->
<!-- {/block} -->
