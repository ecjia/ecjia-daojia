<?php defined('IN_ECJIA') or exit('No permission resources.'); ?>
<!-- {extends file="ecjia.dwt.php"} -->
<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.admin.customer_type_search.init();
</script>
<!-- {/block} -->
<!-- {block name="main_content"} -->
<style type="text/css">
{literal}
.modal.fade.in{
	top:20%;
}
{/literal}
</style>
<div>
    <h3 class="heading">
        <!-- {if $ur_here}{$ur_here}{/if} -->
        <!-- {if $customer_type_add} -->
        <a class="btn plus_or_reply add_customer_type data-pjax" id="sticky_a" href="javascript:;" title="添加客户类别"><i class="fontello-icon-plus"></i>{t}添加类别{/t}</a>
    	<!-- {/if} -->
    </h3>

</div>
<!-- 添加开始 -->
	<div class="modal hide fade" id="movetype" style="width:494px;">
			<div class="modal-header">
				<button class="close" data-dismiss="modal">×</button>
				<h3>当前操作：<span class="action_title"></span></h3>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" name="addForm"  method="post" action="{url path='customer/admin_customer_type/insert'}">
					<div class="control-group formSep control-group-small">
						<label class="control-label">类别名称：</label>
						<div class="controls">
							<input type="text" name="state_name" class=""  value=""/>
							<span class="input-must">*</span>
						</div>
					</div>
					<div class="control-group formSep control-group-small">
						<label class="control-label">类别描述：</label>
						<div class="controls">
							<textarea class=" h70 w280" rows="3" cols="40" name="summary"></textarea>
						</div>
					</div>
					<div class="control-group t_c">
						<button class="btn btn-gebo batchsubmit" type="submit">确定</button>
						<input type="hidden" name="page" value="{$page}"/>
						<input type="hidden" name="add_keywords" value="{$keywords}"/>
					</div>
				</form>
		  </div>
	</div>
<!--添加结束 -->
<!-- 编辑开始 -->
	<div class="modal hide fade" id="movetype_edit" style="width:494px;">
			<div class="modal-header">
				<button class="close" data-dismiss="modal">×</button>
				<h3>当前操作：<span class="edit_action_title"></span></h3>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" name="editForm"  method="post" action="{url path='customer/admin_customer_type/update'}">
					<div class="control-group formSep control-group-small">
						<label class="control-label">类别名称：</label>
						<div class="controls">
							<input type="text" name="state_name" class="customer_type_state_name"  value=""/>
							<span class="input-must">*</span>
						</div>
					</div>
					<div class="control-group formSep control-group-small">
						<label class="control-label">类别描述：</label>
						<div class="controls">
							<textarea class=" h70 w280 customer_type_summary" rows="3" cols="40" name="summary"></textarea>
						</div>
					</div>
					<div class="control-group t_c">
						<button class="btn btn-gebo batchsubmit" type="submit">确定</button>
						<input type="hidden" name="state_id" value="" id='state_id'/>
						<input type="hidden" name="page" value="{$page}"/>
						<input type="hidden" name="edit_keywords" value="{$keywords}"/>
					</div>
				</form>
		  </div>
	</div>
<!--编辑结束 -->
<!-- {if $customer_type_batch} -->
<div class="row-fluid batch" >
    <div class="btn-group f_l m_r5">
        <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
            <i class="fontello-icon-cog"></i>{t}批量操作{/t}
            <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
            <li><a data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{$form_action}&type=button_remove" data-msg="选中的客户类别将会被删除。您确定要这么做吗？" data-noSelectMsg="请选择要删除的客户类别" href="javascript:;"> <i class="fontello-icon-trash"></i>{t}批量删除{/t}</a></li>
        </ul>
    </div>
    <form action="{$search_action}" name="theForm">		
		<div class="choose_list f_r">
			<input type="text" class="w250" name="keywords" value="{$smarty.get.keywords}" placeholder="输入类别名称，类别描述，关键字"/>
			<input class="btn screen-btn" type="submit" value="搜索">
		</div>
    </form>
</div>
<!-- {/if} -->
<div class="row-fluid">
    <div class="span12">
        <div class="row-fluid"> 
            <!-- start customer_type list -->
            <table class="table table-striped smpl_tbl table-hide-edit">
                <thead>
                    <tr>
                        <th class="table_checkbox"><input type="checkbox" data-toggle="selectall" data-children=".checkbox"/></th>
                        <th class="w200">{t}类别名称{/t}</th>
                        <th class="w280">{t}类别描述{/t}</th>
                        <th class="w70">{t}操作人{/t}</th>
                        <th class="w150">{t}添加时间{/t}</th>
                        <!-- {if $customer_type_update} -->
                        <th class="w80">{t}是否默认{/t}</th>
                        <!-- {/if} -->
                        <th class="w80">{t}操作{/t}</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- {foreach from=$customer_type_list.list  item=customer_type} -->
                    <tr align="center">
                        <td class="center-td">
                            <span><input class="checkbox" type="checkbox" name="checkboxes[]"  value="{$customer_type.state_id}" /></span>
                        </td>
                        <td class="center-td">{$customer_type.state_name}</td>
                        <td class="center-td">{$customer_type.summary}</td>
                        <td class="center-td">{$customer_type.adder}</td>
                        <td class="center-td">{$customer_type.add_time}</td>
                        <!-- {if $customer_type_update} -->
                        <td class="center-td">
					    	<i class="{if $customer_type.is_lock eq '1'}fontello-icon-ok cursor_pointer{else}fontello-icon-cancel cursor_pointer{/if}" data-trigger="toggleState" data-url="{url path='customer/admin_customer_type/is_default'}" data-id="{$customer_type.state_id}" title="点击切换是否默认"></i>
					    </td>
					    <!-- {/if} -->
                        <td class="center-td">
                        	<!-- {if $customer_type_update} -->
                        	<a href="javascript:;"  state_id='{$customer_type.state_id}' state_name='{$customer_type.state_name}' summary='{$customer_type.summary}' title="编辑客户类别" class="edit_customer_type"><i class=" fontello-icon-edit"></i></a>
					    	<!-- {/if} -->
					    	<a class="ajaxremove" data-toggle="ajaxremove" data-msg="{t}您确定要删除客户类别[{$customer_type.state_name}]吗？{/t}" href='{RC_Uri::url("customer/admin_customer_type/remove","id={$customer_type.state_id}&state_name={$customer_type.state_name}")}' title="{t}移除{/t}"><i class="fontello-icon-trash"></i></a>
					    </td>
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
    <!-- {$customer_type_list.page} -->
</div>
<!-- {/block} -->
