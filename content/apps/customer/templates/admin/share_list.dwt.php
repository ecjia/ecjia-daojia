<?php defined('IN_ECJIA') or exit('No permission resources.'); ?>
<!-- {extends file="ecjia.dwt.php"} -->
<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.admin.search.common_search();
    ecjia.admin.customer.cancel_share();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
    <h3 class="heading">
        <!-- {if $ur_here}{$ur_here}{/if} -->
    </h3>
</div>
	
<ul class="nav nav-pills">
    <li class="{if $share_type eq 'share_customers'}active{/if}"><a class="data-pjax" href='{url path="customer/admin/share_list" args="share_type=share_customers{if $keywords}&keywords={$keywords}{/if}{if $page}&page={$page}{/if}"}'>共享给我<span class="badge badge-info">{if $customer_list.filter.count_share_customers eq ''}0{else}{$customer_list.filter.count_share_customers}{/if}</span></a></li>
  	<li class="{if $share_type eq 'my_share'}active{/if}"><a class="data-pjax" href='{url path="customer/admin/share_list" args="share_type=my_share{if $keywords}&keywords={$keywords}{/if}{if $page}&page={$page}{/if}"}'>我的共享<span class="badge badge-info">{if $customer_list.filter.count_my_share eq ''}0{else}{$customer_list.filter.count_my_share}{/if}</span></a></li>
  	{if $share_type == 'share_customers'}
  	<form class="f_r form-inline" action="{$search_action}&share_type={$share_type}"  method="post" name="searchForm">
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
	{/if}
</ul>
{if $share_type == 'my_share'}
<div class="row-fluid batch" >
    <div class="btn-group f_l m_r5">
        <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
            <i class="fontello-icon-cog"></i>{t}批量操作{/t}
            <span class="caret"></span>
        </a>
        <ul class="dropdown-menu batch-move" data-url="{RC_Uri::url('customer/admin/share_cancel')}">
        	<li><a data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{$batch_action}&batch=cancel{if $page}&page={$page}{/if}{if $share_type}&share_type={$share_type}{/if}{if $keywords}&keywords={$keywords}{/if}{if $customer_type}&customer_type={$customer_type}{/if}{if $customer_source}&customer_source={$customer_source}{/if}" data-msg="选中客户取消共享，确认要取消吗？" data-noSelectMsg="请选择要取消共享的客户" href="javascript:;"> <i class="fontello-icon-cancel-circled"></i>{t}取消共享{/t}</a></li>
        </ul>
    </div>
 	<form class="f_r form-inline" action="{$search_action}&share_type={$share_type}"  method="post" name="searchForm">
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
{/if}
<div class="row-fluid">
    <div class="span12">
        <div class="row-fluid"> 
            <!-- start case list -->
            {if $share_type == 'share_customers'}
            <table class="table table-striped smpl_tbl table-hide-edit">
                <thead>
                    <tr data-sorthref='{url path="customer/admin/share_list" args="share_type={$share_type}"}'>
                        <th class="w200">{t}客户名称{/t}</th>
                        <th class="w70">{t}联系人{/t}</th>                       
                        <th class="w70">{t}联系方式{/t}</th>
                        <th class="w100">{t}客户类别{/t}</th>
                        <th class="w100">{t}客户来源{/t}</th>
                        <th class="w150 sorting" data-toggle="sortby" data-sortby="last_contact_time">{t}最近联系时间{/t}</th>
                        <th class="w150 sorting" data-toggle="sortby" data-sortby="reservation_time">{t}预约联系时间{/t}</th>
                        <th class="w70">{t}共享人{/t}</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- {foreach from=$customer_list.list  item=list} -->
                    <tr align="center">
                        <td>
                            <div>
                                <div class=""><a class="data-pjax" href='{url path="customer/admin/detail" args="id={$list.customer_id}&refer=share{if $share_type}&share_type={$share_type}{/if}{if $keywords}&keywords={$keywords}{/if}"}'>{$list.customer_name}</a></div>
                            </div>
                            <div style=" margin-bottom:23px">
                                <div class="edit-list" style=" color:#222;opacity:1;" title="添加时间和添加人">添加于&nbsp;&nbsp;{$list.add_time}&nbsp;&nbsp;{if $list.adder}({$list.add_user_name}){/if}
                                </div>
                            </div>
                        </td>
						<td>{$list.link_man}&nbsp;&nbsp;({if $list.sex == 0}男{else}女{/if})</td>
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
                        <td>{$list.sharer}</td>
                    </tr>
                    <!-- {foreachelse} -->
                    <tr>
                        <td class="dataTables_empty" colspan="8">{t}暂无任何记录!{/t}</td>
                    </tr>
                    <!-- {/foreach} -->
                </tbody>
            </table>
            {else}
            <table class="table table-striped smpl_tbl table-hide-edit">
                <thead>
                    <tr data-sorthref='{url path="customer/admin/init" args="status={$status}"}'>
                        <th class="table_checkbox"><input type="checkbox" data-toggle="selectall" data-children=".checkbox"/></th>
                        <th class="w200">{t}客户名称{/t}</th>
                        <th class="w100">{t}共享给{/t}</th>
                        <th class="w150">{t}共享时间{/t}</th>
                        <th class="w70">{t}联系人{/t}</th>                       
                        <th class="w70">{t}联系方式{/t}</th>
                        <th class="w100">{t}客户类别{/t}</th>
                        <th class="w100">{t}客户来源{/t}</th>
                        <th class="w70">{t}操作{/t}</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- {foreach from=$customer_list.list  item=list} -->
                    <tr align="center">
                        <td>
                            <span><input class="checkbox" type="checkbox" name="checkboxes[]"  value="{$list.share_id}" /></span>
                        </td>
                        <td>
                            <div>
                                <a class="data-pjax" href='{url path="customer/admin/detail" args="id={$list.customer_id}&refer=share{if $share_type}&share_type={$share_type}{/if}{if $keywords}&keywords={$keywords}{/if}"}'>{$list.customer_name}</a></div>
                            </div>
                            <div style=" margin-bottom:23px">
                                <div class="edit-list" style=" color:#222;opacity:1;" title="添加时间和添加人">添加于&nbsp;&nbsp;{$list.add_time}&nbsp;&nbsp;{if $list.adder}({$list.add_user_name}){/if}
                                </div>
                            </div>
                        </td>
                        <td>{$list.employee}</td>
                        <td>{$list.share_time}</td>
						<td>{$list.link_man}&nbsp;&nbsp;({if $list.sex == 0}男{else}女{/if})</td>
                        <td>
                            <div class="w115">
                                {$list.telphone1}
                            </div>
                            {$list.mobile}
                        </td>
                        <td>{$list.state_name}</td>
                        <td>{$list.source_name}</td>
                        <td><a class="cancel_share" href="javascript:;" data-id="{$list.share_id}" data-url='{url path="customer/admin/share_cancel" args="id={$list.share_id}&customer_name={$list.customer_name}{if $page}&page={$page}{/if}{if $share_type}&share_type={$share_type}{/if}{if $keywords}&keywords={$keywords}{/if}{if $customer_type}&customer_type={$customer_type}{/if}{if $customer_source}&customer_source={$customer_source}{/if}"}'>取消共享</a></td>
                    </tr>
                    <!-- {foreachelse} -->
                    <tr>
                        <td class="dataTables_empty" colspan="9">{t}暂无任何记录!{/t}</td>
                    </tr>
                    <!-- {/foreach} -->
                </tbody>
            </table>
            {/if}
        </div>
    </div>
</div>
<!-- {$customer_list.page} -->
<!-- {/block} -->
