<?php defined('IN_ECJIA') or exit('No permission resources.'); ?>
<!-- {extends file="ecjia.dwt.php"} -->
<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.admin.customer_source.init();
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
        <!-- {if $customer_source_add} -->
        <a class="btn plus_or_reply customer_source_add data-pjax" id="sticky_a" href='javascript:;' title="添加客户来源"><i class="fontello-icon-plus"></i>{t}添加客户来源{/t}</a>
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
				<form class="form-horizontal" name="addForm"  method="post" action="{url path='customer/admin_customer_source/insert'}">
					<div class="control-group formSep control-group-small">
						<label class="control-label">来源名称：</label>
						<div class="controls">
							<input type="text" name="source_name" class="w300"  value=""/>
							<span class="input-must">*</span>
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
				<form class="form-horizontal" name="editForm"  method="post" action="{url path='customer/admin_customer_source/update'}">
					<div class="control-group formSep control-group-small">
						<label class="control-label">来源名称：</label>
						<div class="controls">
							<input type="text" name="source_name" class="customer_source_name w300"  value=""/>
							<span class="input-must">*</span>
						</div>
					</div>
					<div class="control-group t_c">
						<button class="btn btn-gebo batchsubmit" type="submit">确定</button>
						<input type="hidden" name="source_id" value="" id='source_id'/>
						<input type="hidden" name="page" value="{$page}"/>
						<input type="hidden" name="edit_keywords" value="{$keywords}"/>
					</div>
				</form>
		  </div>
	</div>
<!--编辑结束 -->
<!-- {if $customer_source_batch} -->
<div class="row-fluid batch" >
    <div class="btn-group f_l m_r5">
        <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
            <i class="fontello-icon-cog"></i>{t}批量操作{/t}
            <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
            <li><a data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{$form_action}&type=button_remove" data-msg="选中客户来源将被删除。您确定要这么做吗？" data-noSelectMsg="请选择要删除的客户来源" href="javascript:;"> <i class="fontello-icon-trash"></i>{t}批量删除{/t}</a></li>
        </ul>
    </div>
    <form action="{$search_action}" name="theForm">		
		<div class="choose_list f_r">
			<input type="text" class="w250" name="keywords" value="{$smarty.get.keywords}" placeholder="输入客户来源名称"/>
			<input class="btn screen-btn" type="submit" value="搜索">
		</div>
    </form>
</div>
<!-- {/if} -->
<div class="row-fluid">
    <div class="span12">
        <div class="row-fluid"> 
            <!-- start case list -->
            <table class="table table-striped smpl_tbl table-hide-edit">
                <thead>
                    <tr>
                        <th class="table_checkbox"><input type="checkbox" data-toggle="selectall" data-children=".checkbox"/></th>
                        <th class="w500">{t}来源名称{/t}</th>
                        <th class="w80">{t}操作人{/t}</th>
                        <th class="w100">{t}添加时间{/t}</th>
                        <!-- {if $customer_source_update} -->
                        <th class="w70">{t}是否默认{/t}</th>
                        <!-- {/if} -->
                        <th class="w80">{t}操作{/t}</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- {foreach from=$customer_source_list.list  item=customer_source} -->
                    <tr align="center">
                        <td class="center-td">
                            <span><input class="checkbox" type="checkbox" name="checkboxes[]"  value="{$customer_source.source_id}" /></span>
                        </td>
                        <td class="center-td">{$customer_source.source_name}</td>
                        <td class="center-td">{$customer_source.adder}</td>
                        <td class="center-td">{$customer_source.add_time}</td>
                        <!-- {if $customer_source_update} -->
                        <td class="center-td">
					    	<i class="{if $customer_source.is_lock eq '1'}fontello-icon-ok cursor_pointer{else}fontello-icon-cancel cursor_pointer{/if}" data-trigger="toggleState" data-url="{url path='customer/admin_customer_source/is_default'}" data-id="{$customer_source.source_id}" title="点击切换是否默认"></i>
					    </td>
                        <!-- {/if} -->
                        <td class="center-td">
                        	<!-- {if $customer_source_update} -->
                        	<a href="javascript:;" source_id='{$customer_source.source_id}' source_name='{$customer_source.source_name}' class="edit_customer_source" title="编辑客户来源"><i class=" fontello-icon-edit"></i></a>
					    	<!-- {/if} -->
					    	<a class="ajaxremove" data-toggle="ajaxremove" data-msg="{t}您确定要删除客户来源[{$customer_source.source_name}]吗？{/t}" href='{RC_Uri::url("customer/admin_customer_source/remove","id={$customer_source.source_id}&source_name={$customer_source.source_name}")}' title="{t}移除{/t}"><i class="fontello-icon-trash"></i></a>
					    </td>
                    </tr>
                    <!-- {foreachelse} -->
                    <tr>
                        <td class="dataTables_empty" colspan="6">{t}暂无任何记录!{/t}</td>
                    </tr>
                    <!-- {/foreach} -->
                </tbody>
            </table>
        </div>
    </div>
    <!-- {$customer_source_list.page} -->
</div>
<!-- {/block} -->
