<?php defined('IN_ECJIA') or exit('No permission resources.'); ?>
<!-- {extends file="ecjia.dwt.php"} -->
<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.admin.contact_record_list.init();
</script>
<style>
   #modal-body_new {
		padding: 20px 15px;
   		max-height: 260px;
   		position: relative;
		line-height:260px;
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
    </h3>
</div>
<!--查看联系记录详情开始 -->
	<div class="modal hide fade" id="movetype" style="width:810px;">
			<div class="modal-header">
				<button class="close" data-dismiss="modal">×</button>
				<h3>当前操作：查看联系记录详情</h3>
			</div>
			<div class="modal-body">
				 <div class="accordion-group">
			        <div class="accordion-body in collapse" id="">
			            <table class="table table-oddtd m_b0">
			                <tbody class="first-td-no-leftbd">
			                    <tr>
			                        <td><div align="right"><strong>{t}客户名称{/t}</strong></div></td>
			                        <td id="customer_name"></td>
			                        <td><div align="right"><strong>{t}客户类别{/t}</strong></div></td>
			                        <td class="state_name"></td>
			                    </tr>
			                    <tr>
			                        <td><div align="right"><strong>{t}联系人{/t}</strong></div></td>
			                        <td class="link_man_name"></td>
			                        <td><div align="right"><strong>{t}联系方式{/t}</strong></div></td>
			                        <td class="way_name"></td>
			                    </tr>
			                    <tr>
			                        <td><div align="right"><strong>{t}固定电话{/t}</strong></div></td>
			                        <td class="telphone"></td>
			                        <td><div align="right"><strong>{t}联系时间{/t}</strong></div></td>
			                        <td class="contact_time"></td>
			                    </tr>
			                    <tr>
			                        <td><div align="right"><strong>{t}联系类型{/t}</strong></div></td>
			                        <td class="type_name"></td>
			                        <td><div align="right"><strong>{t}下次联系{/t}</strong></div></td>
			                        <td class="next"></td>
			                    </tr>
			                    <tr>
			                        <td><div align="right"><strong>{t}联系客服{/t}</strong></div></td>
			                        <td class="user_name"></td>
			                        <td><div align="right"><strong>{t}客户来源{/t}</strong></div></td>
			                        <td class="source_name"></td>
			                    </tr>
			                    <tr>
			                        <td><div align="right"><strong>{t}联系内容{/t}</strong></div></td>
			                        <td colspan="3" class="summary"></td>
			                    </tr>
			                    <tr>
			                        <td><div align="right"><strong>{t}下次目标{/t}</strong></div></td>
			                        <td colspan="3" class="next_goal"></td>
			                    </tr>
			                </tbody>
			            </table>
			        </div>	
			    </div>
		   </div>
		   <div id="modal-body_new"><img src="{RC_Uri::admin_url('statics/images/ajax_loader.gif')}" alt="{t}正在加载中……{/t}" /></div>
	</div>
<!--查看联系记录详情结束 -->
<ul class="nav nav-pills">
    <li class="{if $contact_record_list.filter.status eq '1'}active{/if}"><a class="data-pjax" href='{url path="customer/admin_contact/init" args="status=1{if $keywords}&keywords={$keywords}{/if}"}'>全部<span class="badge badge-info">{if $contact_record_list.filter.count.all eq ''}0{else}{$contact_record_list.filter.count.all}{/if}</span></a></li>
  	<li class="{if $contact_record_list.filter.status eq '3'}active{/if}"><a class="data-pjax" href='{url path="customer/admin_contact/init" args="status=3{if $keywords}&keywords={$keywords}{/if}"}'>客户回访<span class="badge badge-info">{if $contact_record_list.filter.count.customer_visits eq ''}0{else}{$contact_record_list.filter.count.customer_visits}{/if}</span></a></li>
    <li class="{if $contact_record_list.filter.status eq '-1'}active{/if}"><a class="data-pjax" href='{url path="customer/admin_contact/init" args="status=-1{if $keywords}&keywords={$keywords}{/if}"}'>客户来电<span class="badge badge-info">{if $contact_record_list.filter.count.customer_calls eq ''}0{else}{$contact_record_list.filter.count.customer_calls}{/if}</span></a></li>
	<form action="{$search_action}&status={$status}" name="theForm">		
		<div class="choose_list f_r">
			<select class="w120 m_l5" name="adminner">
				<option value="0" >{t}请选择员工{/t}</option>
	              <!-- {foreach from=$admin_list item=list } -->
					<option value="{$list.user_id}" {if  $list.user_id == $smarty.get.adminner}selected{/if}>{$list.user_name}</option>
				  <!-- {/foreach} -->
			</select>
			<select class="w150 m_l5" name="way">
				<option value="0" >{t}请选择联系方式{/t}</option>
	            <!-- {foreach from=$contact_way_list item=list} -->
					<option value="{$list.way_id}" {if $list.way_id == $smarty.get.way}selected{/if}>{$list.way_name}</option>
				<!-- {/foreach} -->
			</select>
			<input type="text" class="w250" name="keywords" value="{$smarty.get.keywords}" placeholder="输入客户名称，联系人，电话等关键字"/>
			<input class="btn screen-btn" type="submit" value="搜索">
		</div>
    </form>
</ul>
<div class="row-fluid batch" >
    <div class="btn-group f_l m_r5">
        <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
            <i class="fontello-icon-cog"></i>{t}批量操作{/t}
            <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
            <li><a data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{$form_action}&type=button_remove&status={$status}" data-msg="选中联系记录将删除。您确定要这么做吗？" data-noSelectMsg="请选择要删除的联系记录" href="javascript:;"> <i class="fontello-icon-trash"></i>{t}删除{/t}</a></li>
        </ul>
    </div>
    <form class="f_r form-inline" action="{$search_contact_action}&status={$status}"  method="post" name="searchForm">
		<div class="choose_list f_r">
			<span class="f_l">&nbsp;&nbsp;联系时间：</span>
			<input class="f_l w150 date" name="contact_time1" type="text" value="{$smarty.get.contact_time1}"  placeholder="请选择时间">
			<span class="f_l">-</span>
			<input class="f_l w150 date" name="contact_time2" type="text" value="{$smarty.get.contact_time2}" placeholder="请选择时间">&nbsp;&nbsp;
			<input style="margin-right: -7px;" class="btn btn-select" type="submit" value="筛选">
		</div>
	</form>    
</div>
<div class="row-fluid">
    <div class="span12">
        <div class="row-fluid"> 
            <!-- start case list -->
            <table class="table table-striped smpl_tbl table-hide-edit" style="margin-bottom: 0;">
                <thead>
                    <tr>
                        <th class="table_checkbox"><input type="checkbox" data-toggle="selectall" data-children=".checkbox"/></th>
                        <th class="w200">{t}客户名称{/t}</th>
                        <th class="w80">{t}联系人{/t}</th>                       
                        <th class="w80">{t}联系方式{/t}</th>
                        <th class="w100">{t}联系时间{/t}</th>
                        <th class="w50">{t}联系类型{/t}</th>
                        <th class="w70">{t}操作{/t}</th>
                    </tr>
                </thead>
                <tbody>
            <!-- {foreach from=$contact_record_list.list item=list} -->
                    <tr align="center">
                        <td>
                            <input class="checkbox" type="checkbox" name="checkboxes[]"  value="{$list.feed_id}" />
                        </td>
                        <td>
                            {if $list.customer_name neq ''}<a href='{url path="customer/admin/detail" args="id={$list.customer_id}{if $page}&page={$page}{/if}"}' target="_blank">{$list.customer_name}</a>{/if}
                        </td>
						<td>{if $list.link_man_name}{$list.link_man_name}&nbsp;({if $list.sex == 0}男{else}女{/if}){/if}</td>
                        <td>
                            {if $list.telphone}{$list.telphone}&nbsp;{if $list.way_name}({$list.way_name}){/if}{/if}
                        </td>
                        <td>{$list.add_time}</td>
                        <td>{$list.type_name}</td>
                        <td>
                            <a class="feedback-detail" href='javascript:;' feed_id='{$list.feed_id}' title="查看详情" data-url="{$detail_action}&id={$list.customer_id}&feed_id={$list.feed_id}" name="detail_ture"><i class="fontello-icon-eye"></i></a>
                            <a class="data-pjax" href='{url path="customer/admin/contact_edit" args="id={$list.customer_id}&feed_id={$list.feed_id}&status={$status}&refer=to_contact_record{if $keywords}&keywords={$keywords}{/if}{if $contact_time1}&contact_time1={$contact_time1}{/if}{if $contact_time2}&contact_time2={$contact_time2}{/if}"}' title="{t}编辑{/t}"><i class="fontello-icon-edit"></i></a>
                            <a class="ajaxremove" data-toggle="ajaxremove" data-msg="{t}您确定要删除此记录吗？{/t}" href='{RC_Uri::url("customer/admin/contact_remove","id={$list.customer_id}&feed_id={$list.feed_id}{if $status}&status={$status}{/if}{if $keywords}&keywords={$keywords}{/if}{if $contact_time1}&contact_time1={$contact_time1}{/if}{if $contact_time2}&contact_time2={$contact_time2}{/if}")}' title="{t}移除{/t}"><i class="fontello-icon-trash"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="7" style="padding: 10px;">{$list.summary}</td>
                    </tr>
                   
		            <!-- {foreachelse} -->
                    <tr>
                        <td class="dataTables_empty" colspan="7">{t}暂无任何记录!{/t}</td>
                    </tr>
                	<!-- {/foreach} -->
                	</tbody>
                	</table>
            <div style="height:20px"></div>
        </div>
    </div>
</div>
<!-- {$contact_record_list.page} -->
<!-- {/block} -->
