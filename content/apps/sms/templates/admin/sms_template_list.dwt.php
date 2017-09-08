<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.sms_template_list.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
{if !$data}
<div class="alert alert-error">
	<a class="close" data-dismiss="alert">×</a>
	<strong>温馨提示：</strong>请您先前往 "控制面板" -> "插件管理" 中安装短信渠道。
</div>
{/if}

<div class="row-fluid">
	<div class="span3">
		<div class="setting-group">
	        <span class="setting-group-title"><i class="fontello-icon-cog"></i>短信渠道</span>
	        <!-- {if $data} -->
	        <ul class="nav nav-list m_t10">
		        <!-- {foreach from=$data item=val} -->
		        	<li><a class="setting-group-item data-pjax {if $channel_code eq $val.channel_code}llv-active{/if}" href='{url path="sms/admin_template/init" args="channel_code={$val.channel_code}"}'>{$val.channel_name}</a></li>
		        <!-- {/foreach} -->
	        </ul>
	        <!-- {/if} -->
		</div>
	</div>
	
	<div class="span9">
		<h3 class="heading">
			<!-- {if $ur_here}{$ur_here}{/if} -->
			{if $action_link}
				<a class="btn plus_or_reply data-pjax" href="{$action_link.href}" id="sticky_a"><i class="fontello-icon-plus"></i>{$action_link.text}</a>
			{/if}
			{if $action_link_event} 
				<a class="btn plus_or_reply data-pjax" href="{$action_link_event.href}" id="sticky_a"><i class="fontello-icon-reply"></i>{$action_link_event.text}</a>
			{/if}
			{if $channel_code}（{$channel_code}）{/if}
		</h3>
	
		<table class="table table-striped smpl_tbl dataTable table-hide-edit" id="plugin-table">
			<thead>
				<tr>
					<th class="w150">模板代号</th>
					<th class="w150">{lang key='sms::sms.sms_template_subject'}</th>
					<th>{lang key='sms::sms.sms_template_content'}</th>
				</tr>
			</thead>
			<tbody>
				<!-- {foreach from=$template item=list} -->
				<tr>
					 <td class="hide-edit-area hide_edit_area_bottom">{$list.template_code}
						<div class="edit-list">
						 <a class="data-pjax no-underline" href='{url path="sms/admin_template/edit" args="id={$list.id}&channel_code={$channel_code}&event_code={$list.template_code}"}' title="{lang key='system::system.edit'}">{lang key='system::system.edit'}</a>&nbsp;|&nbsp;
		                 <a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg="{lang key='sms::sms.drop_confirm'}" href='{RC_Uri::url("sms/admin_template/remove", "id={$list.id}&channel_code={$channel_code}")}' title="{lang key='system::system.drop'}">{lang key='system::system.drop'}</a>
		                &nbsp;|&nbsp; <a class="data-pjax no-underline" href='{url path="sms/admin_template/test" args="id={$list.id}&channel_code={$channel_code}&event_code={$list.template_code}"}'  title="短信测试">短信测试</a>
						</div>
					 </td>
					<td>{$list.template_subject}</td>
					<td>{$list.template_content}</td>
				</tr>
				<!-- {/foreach} -->
			</tbody>
		</table>
	</div>
</div>
<!-- {/block} -->