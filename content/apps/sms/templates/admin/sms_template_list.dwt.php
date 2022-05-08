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
	<strong>{t domain="sms"}温馨提示：{/t}</strong>{t domain="sms"}请您先前往 "控制面板" -> "插件管理" 中安装短信渠道。{/t}
</div>
{/if}

<div class="row-fluid">
	<div class="span3">
		<div class="setting-group">
	        <span class="setting-group-title"><i class="fontello-icon-cog"></i>{t domain="sms"}短信渠道{/t}</span>
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
					<th class="w150">{t domain="sms"}模板代号{/t}</th>
					<th class="w150">{t domain="sms"}短信主题{/t}</th>
					<th>{t domain="sms"}模板内容{/t}</th>
				</tr>
			</thead>
			<tbody>
				<!-- {foreach from=$template item=list} -->
				<tr>
					 <td class="hide-edit-area hide_edit_area_bottom">{$list.template_code}
						<div class="edit-list">
						 <a class="data-pjax no-underline" href='{url path="sms/admin_template/edit" args="id={$list.id}&channel_code={$channel_code}&event_code={$list.template_code}"}' title='{t domain="sms"}编辑{/t}'>{t domain="sms"}编辑{/t}</a>&nbsp;|&nbsp;
		                 <a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg='{t domain="sms"}您确定要删除该短信模板吗？{/t}' href='{RC_Uri::url("sms/admin_template/remove", "id={$list.id}&channel_code={$channel_code}")}' title='{t domain="sms"}删除{/t}'>{t domain="sms"}删除{/t}</a>
		                &nbsp;|&nbsp; <a class="data-pjax no-underline" href='{url path="sms/admin_template/test" args="id={$list.id}&channel_code={$channel_code}&event_code={$list.template_code}"}'  title='{t domain="sms"}短信测试{/t}'>{t domain="sms"}短信测试{/t}</a>
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