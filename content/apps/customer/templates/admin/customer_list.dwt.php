<?php defined('IN_ECJIA') or exit('No permission resources.'); ?>
<!-- {extends file="ecjia.dwt.php"} -->
<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.admin.search.init();
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
<div>
    <h3 class="heading">
        <!-- {if $ur_here}{$ur_here}{/if} -->
        <a class="btn plus_or_reply data-pjax" id="sticky_a" href='{url path="customer/admin/add" args="{if $page}&page={$page}{/if}{if $status}&status={$status}{/if}{if $keywords}&keywords={$keywords}{/if}{if $customer_type}&customer_type={$customer_type}{/if}{if $customer_source}&customer_source={$customer_source}{/if}"}'><i class="fontello-icon-plus"></i>{t}添加客户{/t}</a>
    </h3>
</div>
<!-- 批量修改客户来源开始 -->
	<div class="modal hide fade" id="movetype" style="width:494px;">
			<div class="modal-header">
				<button class="close" data-dismiss="modal">×</button>
				<h3>当前操作：批量修改客户来源</h3>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" name=""  method="" action="">
					<div class="control-group formSep control-group-small" style="height:120px;">
						<label class="control-label" style="margin-left:80px;">{t}客户来源：{/t}</label>
						<div class="control">
							<select class="w200 f_l"  name="customer_source">
				                <option value="">请选择客户来源</option>
				                <!-- {foreach from=$source_list item=source } -->
								<option value="{$source.source_id}" {if $source.source_id == $customer_info.source_id}selected{/if}>{$source.source_name}</option>
								<!-- {/foreach} -->
							</select>
						</div>
					</div>
					<div class="control-group t_c">
						<a class="btn btn-gebo batchsubmit" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{$form_action}&type=change_source" data-msg="是否将选中客户修改客户来源？" data-noSelectMsg="请选择要修改的客户" href="javascript:;" name="change_source_ture">确定</a>
					</div>
				</form>
		  </div>
	</div>
<!--批量修改客户来源结束 -->
<!-- 批量修改客户类别开始 -->
	<div class="modal hide fade" id="move_customer_type" style="width:494px;">
			<div class="modal-header">
				<button class="close" data-dismiss="modal">×</button>
				<h3>当前操作：批量修改客户类别</h3>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" name=""  method="" action="">
					<div class="control-group formSep control-group-small" style="height:120px;">
						<label class="control-label" style="margin-left:80px;">{t}客户类别：{/t}</label>
						<div class="control">
							<select class="w200 f_l"  name="customer_type">
				                <option value="">请选择客户类别</option>
				                <!-- {foreach from=$customer_type_list item=state } -->
								<option value="{$state.state_id}" {if $state.state_id == $customer_info.state_id}selected {/if}>{$state.state_name}</option>
								<!-- {/foreach} -->
							</select>
						</div>
					</div>
					<div class="control-group t_c">
						<a class="btn btn-gebo batchsubmit" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{$form_action}&type=change_type" data-msg="是否将选中客户修改客户类别？" data-noSelectMsg="请选择要修改的客户" href="javascript:;" name="change_type_ture">确定</a>
					</div>
				</form>
		  </div>
	</div>
<!--批量修改客户类别结束 -->	
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
						<div class="controls">
							<select class="w200 f_l" name="customer_assign" id="admin_id">
				                <option class="" value="">请选择管理员</option>
								<!-- {foreach from=$admin_list item=list key=okey} -->
								<option class="" value="{$list.user_id}">{$list.user_name}</option>
								<!-- {/foreach} -->
							</select>
						</div>
					</div>
					<div class="control-group formSep control-group-small">
						<label class="control-label">原因：</label>
						<div class="controls">
							<textarea class=" h70 w280 task_remark" rows="3" cols="40" name="reason"></textarea>
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
						<a class="btn btn-gebo batchsubmit" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{$form_action}&type=button_assign_customer" data-msg="选中客户将指派给新负责人。您确定要这么做吗？" data-noSelectMsg="请选择要指派的客户" href="javascript:;" name="assign_customer_ture">指派</a>
					</div>
				</form>
		  </div>
	</div>
<!-- 批量指派客户结束 -->	
	
<!-- 批量分享客户开始 -->
	<div class="modal hide fade" id="share-customers">
			<div class="modal-header">
				<button class="close" data-dismiss="modal">×</button>
				<h3>当前操作：批量共享客户</h3>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" name=""  method="" action="">
					<div class="control-group formSep control-group-small" style="height:100px;">
						<label class="control-label" style="margin-left:113px;">管理员：</label>
						<div class="controls">
							<select class="w200 f_l" name="share" id="share_id">
				                <option class="share_customer" value="">请选择管理员</option>
								<!-- {foreach from=$admin_list item=list } -->
								<option class="share_customer" value="{$list.user_id}">{$list.user_name}</option>
								<!-- {/foreach} -->
							</select>
						</div>
					</div>
					<div class="control-group t_c" style="margin-bottom:0px;">
						<a class="btn btn-gebo batchsubmit" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{$form_action}&type=button_share_customer" data-msg="选中客户将分享给其他人。您确定要这么做吗？" data-noSelectMsg="请选择要分享的客户" href="javascript:;" name="share_customer_ture">共享</a>
					</div>
				</form>
		  </div>
	</div>
<!-- 批量分享客户结束 -->	
<!-- 列表单个共享开始 -->
	<div class="modal hide fade" id="movetype_share">
			<div class="modal-header">
				<button class="close" data-dismiss="modal">×</button>
				<h3>当前操作：共享客户</h3>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" name="shareForm"  method="post" action="{url path='customer/admin/share'}">
					<div class="control-group formSep control-group-small" style="height:100px;">
						<label class="control-label" style="margin-left:113px;">管理员：</label>
						<div class="controls">
							<select class="w200 f_l" name="sharer_id" id="">
				                <option class="option_designee" value="">请选择管理员</option>
								<!-- {foreach from=$admin_list item=list key=okey} -->
								<option class="option_designee" value="{$list.user_id}">{$list.user_name}</option>
								<!-- {/foreach} -->
							</select>
						</div>
					</div>
					<div class="control-group t_c" style="margin-bottom:0px;">
						<button class="btn btn-gebo batchsubmit" type="submit">共享</button>		
						<input type="hidden" name="customer-share-id" value="" id='customer_new_id'/>  
					</div>
				</form>
		  </div>
	</div>
<!-- 列表单个共享结束 -->
	
<ul class="nav nav-pills">
    <!-- {if $customer_list.filter.menu neq 'all'} -->
	    <li class="{if $customer_list.filter.status eq '1'}active{/if}"><a class="data-pjax" href='{url path="customer/admin/init" args="status=1{if $keywords}&keywords={$keywords}{/if}{if $view}&view={$view}{/if}{if $customer_type}&type_customer={$customer_type}{/if}{if $customer_source}&source_customer={$customer_source}{/if}"}'>我的客户<span class="badge badge-info">{if $customer_list.filter.count_m.count_mine eq ''}0{else}{$customer_list.filter.count_m.count_mine}{/if}</span></a></li>
	  	<li class="{if $customer_list.filter.status eq '-2'}active{/if}"><a class="data-pjax" href='{url path="customer/admin/init" args="status=-2{if $keywords}&keywords={$keywords}{/if}{if $view}&view={$view}{/if}{if $customer_type}&type_customer={$customer_type}{/if}{if $customer_source}&source_customer={$customer_source}{/if}"}'>我的领用<span class="badge badge-info">{if $customer_list.filter.count_r.count_my_recipients eq ''}0{else}{$customer_list.filter.count_r.count_my_recipients}{/if}</span></a></li>
	    <li class="{if $customer_list.filter.status eq '-1'}active{/if}"><a class="data-pjax" href='{url path="customer/admin/init" args="status=-1{if $keywords}&keywords={$keywords}{/if}{if $view}&view={$view}{/if}{if $customer_type}&type_customer={$customer_type}{/if}{if $customer_source}&source_customer={$customer_source}{/if}"}'>即将回收<span class="badge badge-info">{if $customer_list.filter.count_b.count_back eq ''}0{else}{$customer_list.filter.count_b.count_back}{/if}</span></a></li>
	<!-- {/if} -->
	<!-- {if $customer_list.filter.menu eq 'all'} -->
		<li class="{if $customer_list.filter.status eq 'whole'}active{/if}"><a class="data-pjax" href='{url path="customer/admin/init" args="status=whole{if $menu}&menu={$menu}{/if}{if $keywords}&keywords={$keywords}{/if}{if $view}&view={$view}{/if}{if $customer_type}&type_customer={$customer_type}{/if}{if $customer_source}&source_customer={$customer_source}{/if}"}'>全部<span class="badge badge-info">{if $customer_list.filter.count_w.whole eq ''}0{else}{$customer_list.filter.count_w.whole}{/if}</span></a></li>
	<!-- {/if} -->
	<li class="{if $customer_list.filter.status eq 'transhed'}active{/if}"><a class="data-pjax" href='{url path="customer/admin/init" args="status=transhed{if $menu}&menu={$menu}{/if}{if $keywords}&keywords={$keywords}{/if}{if $view}&view={$view}{/if}{if $customer_type}&type_customer={$customer_type}{/if}{if $customer_source}&source_customer={$customer_source}{/if}"}'>回收站<span class="badge badge-info">{if $customer_list.filter.count_t.throwed eq ''}0{else}{$customer_list.filter.count_t.throwed}{/if}</span></a></li>
	<form action="{$search_action}&status={$status}{if $menu}&menu={$menu}{/if}{if $customer_type}&type_customer={$customer_type}{/if}{if $customer_source}&source_customer={$customer_source}{/if}{if $view}&view={$view}{/if}" name="theForm">		
		<div class="choose_list f_r">
			<select class="w150 m_l5" name="customer_fields">
			    <option value="1" {if $smarty.get.customer_fields== 1}selected{/if}>{t}系统字段{/t}</option>
	            <option value="2" {if $smarty.get.customer_fields== 2}selected{/if}>{t}自定义字段{/t}</option>
			</select>
			<input type="text" class="w250" name="keywords" value="{$smarty.get.keywords}" placeholder="输入客户名称，联系人，电话等关键字"/>
			<input class="btn screen-btn" type="submit" value="搜索">
		</div>
    </form>
</ul>
<div class="row-fluid batch" >
   {if $customer_type_update_batch || $customer_source_update_batch || $customer_assign_batch || $customer_share_batch || $customer_quit_batch || $customer_del_batch || $customer_reback}
    <div class="btn-group f_l m_r5">
        <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
            <i class="fontello-icon-cog"></i>{t}批量操作{/t}
            <span class="caret"></span>
        </a>
        <ul class="dropdown-menu batch-move" data-url="{RC_Uri::url('customer/admin/batch')}">
        	<!-- {if $customer_type_update_batch AND $status neq 'transhed'} -->
        		<li><a class="batch-change-customer-type"data-name="move_type" data-move="data-operatetype" href="javascript:;" title="修改客户类别"> <i class="fontello-icon-forward"></i>{t}修改客户类别{/t}</a></li>
        	<!-- {/if} -->
        	<!-- {if $customer_source_update_batch AND $status neq 'transhed'} -->
        		<li><a class="batch-change-customer-source"data-name="move_source" data-move="data-operatetype" href="javascript:;" title="修改客户来源"> <i class="fontello-icon-forward"></i>{t}修改客户来源{/t}</a></li>
        	<!-- {/if} -->
        	<!-- {if $customer_assign_batch AND $status neq 'transhed'} -->
        		<li><a class="batch-assign-customer"data-name="assign_customers" data-move="data-operatetype" href="javascript:;" title="客户指派"> <i class="fontello-icon-right-hand"></i>{t}客户指派{/t}</a></li>
        	<!-- {/if} -->
        	<!-- {if $customer_share_batch AND $status neq 'transhed'} -->
        		<li><a class="batch-share-customer"data-name="share_customers" data-move="data-operatetype" href="javascript:;" title="共享客户"> <i class="fontello-icon-comment-empty"></i>{t}共享{/t}</a></li>
        	<!-- {/if} -->
        	<!-- {if $customer_quit_batch AND $status neq 'transhed'} -->
        		<li><a data-toggle="ecjiabatch"  data-idClass=".checkbox:checked" data-url="{$form_action}&type=button_quit&status={$customer_list.filter.status}" data-msg="选中客户放弃后，该客户将进入公共客户池，别人可领用，确认要放弃吗？" data-noSelectMsg="请选择要放弃的客户" href="javascript:;"> <i class="fontello-icon-cancel-circled"></i>{t}放弃{/t}</a></li>
        	<!-- {/if} -->
        	<!-- {if $customer_del_batch AND $status neq 'transhed'} -->
        		<li><a data-toggle="ecjiabatch"  data-idClass=".checkbox:checked" data-url="{$form_action}&type=button_remove&status={$customer_list.filter.status}" data-msg="选中客户将移至回收站。您确定要这么做吗？" data-noSelectMsg="请选择要移至回收站的客户" href="javascript:;"> <i class="fontello-icon-trash"></i>{t}移至回收站{/t}</a></li>
        	<!-- {/if} -->
        	<!-- {if $customer_reback AND $status eq 'transhed'} -->
        		<li><a data-toggle="ecjiabatch"  data-idClass=".checkbox:checked" data-url="{$form_action}&type=button_reback&status={$customer_list.filter.status}{if $menu}&menu={$menu}{/if}" data-msg="选中客户将还原。您确定要这么做吗？" data-noSelectMsg="请选择要还原的客户" href="javascript:;"> <i class=" fontello-icon-ccw"></i>{t}还原客户{/t}</a></li>
        	<!-- {/if} -->
        </ul>
    </div>
    {/if}
    {if $customer_list.filter.menu eq 'all'}
    	<a class="btn f_l customer-export" href="{url path='customer/admin/customer_export'}{if $status}&status={$status}{/if}{if $keywords}&keywords={$keywords}{/if}{if $customer_type}&type_customer={$customer_type}{/if}{if $customer_source}&source_customer={$customer_source}{/if}{if $view}&view={$view}{/if}" title="{t}导出{/t}">导出</a>
    {/if}
 	<form class="f_r form-inline" action="{$search_source_action}&status={$status}{if $menu}&menu={$menu}{/if}{if $keywords}&keywords={$keywords}{/if}"  method="post" name="searchForm">
 	  <div class="choose_list f_r">
 	  		<select class="w200 m_l5" name="view">
				<option value="0" >{t}请选择快捷视图{/t}</option>
	              <!-- {foreach from=$view_list item=list } -->
					<option value="{$list.view_id}" {if  $list.view_id == $smarty.get.view}selected{/if}>{$list.view_name}</option>
				  <!-- {/foreach} -->
			</select>
			<select class="w200 m_l5" name="type_customer">
				<option value="0" >{t}请选择客户类别{/t}</option>
	              <!-- {foreach from=$customer_type_list item=state } -->
					<option value="{$state.state_id}" {if  $state.state_id == $smarty.get.type_customer}selected{/if}>{$state.state_name}</option>
				  <!-- {/foreach} -->
			</select>
			<select class="w200 m_l5" name="source_customer">
				<option value="0" >{t}请选择来源{/t}</option>
	            <!-- {foreach from=$source_list item=source } -->
					<option value="{$source.source_id}" {if $source.source_id == $smarty.get.source_customer}selected{/if}>{$source.source_name}</option>
				<!-- {/foreach} -->
			</select>
		<button class="btn btn-select" type="submit">{t}筛选{/t}</button>
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
                        <th class="table_checkbox"><input type="checkbox" data-toggle="selectall" data-children=".checkbox"/></th>
                        <th class="w200">{t}客户名称{/t}</th>
                        <th class="w80">{t}联系人{/t}</th>                       
                        <th class="w70">{t}联系方式{/t}</th>
                        <th class="w100">{t}客户类别{/t}</th>
                        <th class="w100">{t}客户来源{/t}</th>
                        <th class="w150 sorting" data-toggle="sortby" data-sortby="last_contact_time">{t}最近联系时间{/t}</th>
                        <th class="w150 sorting" data-toggle="sortby" data-sortby="reservation_time">{t}预约联系时间{/t}</th>
                        <!-- {if $priv_manage_all eq 'true' && $menu eq 'all'} -->
                        <th class="w80">{t}负责人{/t}</th>
                        <!-- {/if} -->
                        <th class="w50">{t}状态{/t}</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- {foreach from=$customer_list.list  item=list} -->
                    <tr align="center">
                        <td>
                            <span><input class="checkbox" type="checkbox" name="checkboxes[]"  value="{$list.customer_id}" /></span>
                        </td>
                        <td class="hide-edit-area">
                            <div>
                                <div class="">{if $list.url neq 'http://' AND $list.url neq ''}<a href="{$list.url}" target="_blank">{$list.customer_name}</a>{else}{$list.customer_name}{/if}</div>
                            </div>
                            <div style=" margin-bottom:23px">
                                <div class="edit-list" style=" color:#222;opacity:1;">添加于&nbsp;&nbsp;{$list.add_time}&nbsp;&nbsp;{if $list.adder}({$list.add_user_name}){/if}
                                </div>
                            </div>
                            <div class="edit-list">
                                <a class="data-pjax" href='{url path="customer/admin/detail" args="id={$list.customer_id}{if $page}&page={$page}{/if}{if $status}&status={$status}{/if}{if $keywords}&keywords={$keywords}{/if}{if $customer_type}&customer_type={$customer_type}{/if}{if $customer_source}&customer_source={$customer_source}{/if}{if $menu}&menu={$menu}{/if}"}' title="{t}客户详情{/t}">客户详情</a>
                                <!-- {if  $status neq 'transhed'} -->
	                                &nbsp;&nbsp;|&nbsp;&nbsp;<a class="data-pjax" href='{url path="customer/admin/edit" args="id={$list.customer_id}{if $page}&page={$page}{/if}{if $status}&status={$status}{/if}{if $keywords}&keywords={$keywords}{/if}{if $customer_type}&customer_type={$customer_type}{/if}{if $customer_source}&customer_source={$customer_source}{/if}{if $menu}&menu={$menu}{/if}"}' title="{t}编辑{/t}">编辑</a>
	                                &nbsp;&nbsp;|&nbsp;&nbsp;<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg="{t}您确定要将此客户移至回收站吗？{/t}" href='{RC_Uri::url("customer/admin/remove","id={$list.customer_id}{if $page}&page={$page}{/if}{if $status}&status={$status}{/if}{if $keywords}&keywords={$keywords}{/if}{if $customer_type}&customer_type={$customer_type}{/if}{if $customer_source}&customer_source={$customer_source}{/if}{if $menu}&menu={$menu}{/if}")}' title="{t}移至回收站{/t}">移至回收站</a>
                               	<!-- {/if} -->
                               	<!-- {if $customer_reback} -->
	                                <!-- {if $list.is_delete eq '1'} -->
	                                	&nbsp;&nbsp;|&nbsp;&nbsp;<a class="toggle_view" data-msg="{t}您确定要将此客户还原吗？{/t}" href='{RC_Uri::url("customer/admin/reback","id={$list.customer_id}")}' data-pjax-url='{url path="customer/admin/init"}&status={$status}{if $page}&page={$page}{/if}{if $keywords}&keywords={$keywords}{/if}{if $customer_type}&customer_type={$customer}{/if}{if $customer_source}&customer_source={$customer_source}{/if}{if $menu}&menu={$menu}{/if}' data-val="back" title="{t}还原客户{/t}">还原客户</a>
	                                <!-- {/if} -->
                                <!-- {/if} -->
                                {if $priv_manage_all neq 'true' || $menu neq 'all'}
                                	{if $customer_share AND $status neq 'transhed'}
                                    	&nbsp;&nbsp;|&nbsp;&nbsp;<a href="javascript:;" class="customer_single_share data-pjax" title="共享客户" customer_id='{$list.customer_id}' title="共享客户">{t}共享{/t}</a>
                                    {/if}
                                    {if $customer_quit}
	                                    {if $list.charge_man neq '0' AND $status neq 'transhed'}
	                                    	&nbsp;&nbsp;|&nbsp;&nbsp;<a class="toggle_view" data-msg="{t}放弃后，该客户将进入公共客户池，别人可领用，确认要放弃吗？{/t}" href='{RC_Uri::url("customer/admin/quit","id={$list.customer_id}")}' data-pjax-url='{url path="customer/admin/init"}&status={$status}{if $page}&page={$page}{/if}{if $keywords}&keywords={$keywords}{/if}{if $customer_type}&customer_type={$customer}{/if}{if $customer_source}&customer_source={$customer_source}{/if}' data-val="quit" title="{t}放弃{/t}">放弃</a>
	                                    {/if}
	                                {/if}
                                {/if}
                                {if $binding_priv}
	                                {if ($list.user_id) AND $status neq 'transhed'}
	                                	&nbsp;&nbsp;|&nbsp;&nbsp;<a class="data-pjax" href='{url path="customer/admin/binding_adviser" args="id={$list.customer_id}&user_id={$list.user_id}{if $page}&page={$page}{/if}{if $status}&status={$status}{/if}{if $keywords}&keywords={$keywords}{/if}{if $customer_type}&customer_type={$customer_type}{/if}{if $customer_source}&customer_source={$customer_source}{/if}"}' {if $list.adviser_id eq 0} title="{t}绑定顾问{/t}" {else} title="{t}更换顾问{/t}" {/if}>{if $list.adviser_id eq 0}绑定{else}更换{/if}顾问</a>
	                            	{/if}
                            	{/if}
                            </div>
                        </td>
						<td>{$list.link_man}&nbsp;({if $list.sex == 0}男{else}女{/if})</td>
                        <td>
                            <div class="w115">
                                {$list.telphone1}
                            </div>
                            {$list.mobile}
                        </td>
                        <td>{$list.state_name}</td>
                        <td>{$list.source_name}</td>
                        <td>{$list.last_contact_time}</td>
                        <td>{$list.reservation_time}</td>
                        <!-- {if $priv_manage_all eq 'true' && $menu eq 'all'} -->
                        <td>{if $list.charge_man_name eq ''}公共客户{else}{$list.charge_man_name}{/if}</td>
                        <!-- {/if} -->
                        <td>
                            {if $list.user_id neq '' AND $list.user_id neq '0'}已绑定({$list.member_name})
                            {else}未绑定
                            {/if}
                        </td>
                    </tr>
                    <!-- {foreachelse} -->
                    <tr>
                        <!-- {if $priv_manage_all eq 'true' && $menu eq 'all'} -->
                        <td class="dataTables_empty" colspan="10">{t}暂无任何记录!{/t}</td>
                        <!-- {else} -->
                        <td class="dataTables_empty" colspan="9">{t}暂无任何记录!{/t}</td>
                        <!-- {/if} -->
                        
                    </tr>
                    <!-- {/foreach} -->
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- {$customer_list.page} -->
<!-- {/block} -->
