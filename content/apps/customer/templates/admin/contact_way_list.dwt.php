<?php defined('IN_ECJIA') or exit('No permission resources.'); ?>
<!-- {extends file="ecjia.dwt.php"} -->
<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.admin.contact_way.init();
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
        <!-- {if $contact_way_add} -->
        <a class="btn plus_or_reply add_contact_way data-pjax" id="sticky_a" href="javascript:;" title="添加联系方式"><i class="fontello-icon-plus"></i>{t}添加联系方式{/t}</a>
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
				<form class="form-horizontal" name="addForm"  method="post" action="{url path='customer/admin_contact/contact_way_insert'}">
					<div class="control-group formSep control-group-small">
						<label class="control-label" style="width: 104px;">联系方式名称：</label>
						<div class="controls">
							<input type="text" name="way_name" class=""  value=""/>
							<span class="input-must">*</span>
						</div>
					</div>
					<div class="control-group formSep control-group-small">
						<label class="control-label" style="width: 104px;">排序值：</label>
						<div class="controls">
							<input type="text" name="sort_order" class="contact-order"  value="10"/>
							<span class="input-must">*</span>
						</div>
					</div>
					<div class="control-group t_c">
						<button class="btn btn-gebo batchsubmit" type="submit">确定</button>
						<input type="hidden" name="page" value="{$page}"/>
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
				<form class="form-horizontal" name="editForm"  method="post" action="{url path='customer/admin_contact/contact_way_update'}">
					<div class="control-group formSep control-group-small">
						<label class="control-label" style="width: 104px;">联系方式名称：</label>
						<div class="controls">
							<input type="text" name="way_name" class="contact_way_name"  value=""/>
							<span class="input-must">*</span>
						</div>
					</div>
					<div class="control-group formSep control-group-small">
						<label class="control-label" style="width: 104px;">排序值：</label>
						<div class="controls">
							<input type="text" name="sort_order" class="contact-sort"  value=""/>
							<span class="input-must">*</span>
						</div>
					</div>
					<div class="control-group t_c">
						<button class="btn btn-gebo batchsubmit" type="submit">确定</button>
						<input type="hidden" name="way_id" value="" id='way_id'/>
						<input type="hidden" name="page" value="{$page}"/>
					</div>
				</form>
		  </div>
	</div>
<!--编辑结束 -->
<div class="row-fluid">
    <div class="span12">
        <div class="row-fluid"> 
            <!-- start contact_way_list  -->
            <table class="table table-striped smpl_tbl table-hide-edit">
                <thead>
                    <tr>
                        <th class="w280">{t}联系方式名称{/t}</th>
                        <th class="w80">{t}排序{/t}</th>
                        <th class="w80">{t}操作人{/t}</th>
                        <th class="w100">{t}操作时间{/t}</th>
                        <th class="w80">{t}操作{/t}</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- {foreach from=$contact_way_list.list  item=way} -->
                    <tr align="center">
                        <td class="center-td">{$way.way_name}</td>
                        <td class="center-td">{$way.sort_order}</td>
                        <td class="center-td">{$way.updater}</td>
                        <td class="center-td">{$way.update_time}</td>
                        <td class="center-td">
                        	<!-- {if $contact_way_update} -->
                        	<a href="javascript:;" way_id='{$way.way_id}' way_name='{$way.way_name}' sort_order='{$way.sort_order}' title="编辑联系方式" class="edit_contact_way"><i class=" fontello-icon-edit"></i></a>
					    	<!-- {/if} -->
					    	<a class="ajaxremove" data-toggle="ajaxremove" data-msg="{t}您确定要删除联系方式[{$way.way_name}]吗？{/t}" href='{RC_Uri::url("customer/admin_contact/contact_way_remove","id={$way.way_id}&way_name={$way.way_name}")}' title="{t}移除{/t}"><i class="fontello-icon-trash"></i></a>
					    </td>
                    </tr>
                    <!-- {foreachelse} -->
                    <tr>
                        <td class="dataTables_empty" colspan="5">{t}暂无任何记录!{/t}</td>
                    </tr>
                    <!-- {/foreach} -->
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- {$contact_way_list.page} -->
<!-- {/block} -->
