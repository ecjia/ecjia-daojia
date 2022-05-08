<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="plugin_config.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.channel_list.init();
</script>
<!-- {/block} -->

<!-- {block name="admin_plugin_list"} -->
<h3 class="heading">{if $ur_here}{$ur_here}{/if} {t domain="sms"}（发送短信的渠道是按照该列表第一条优先执行）{/t}</h3>

<table class="table table-striped table-hide-edit" data-rowlink="a">
	<thead>
		<tr>
			<th class="w150">{t domain="sms"}用户名{/t}</th>
			<th>{t domain="sms"}描述{/t}</th>
			<th class="w80">{t domain="sms"}排序{/t}</th>
			<th class="w80">{t domain="sms"}是否开启{/t}</th>
		</tr>
	</thead>
	<tbody>
		<!-- {foreach from=$list.item item=val} -->
		<tr>
			<td >
				<!-- {if $val.enabled == 1} -->
					<span class="cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('sms/admin_plugin/edit_name')}" data-name="channel_name" data-pk="{$val.channel_id}"  data-title='{t domain="sms"}编辑名称{/t}'>{$val.channel_name}</span>
				<!-- {else} -->
					{$val.channel_name}
				<!-- {/if} -->
			</td>
			<td class="hide-edit-area">
				{$val.channel_desc|nl2br}<br>
				<span class="balance" style="color: #08c;font-size:14px;"></span>
				<!-- {if $val.enabled == 1} -->
					<div class="edit-list">
						<a class="data-pjax" href='{RC_Uri::url("sms/admin_plugin/edit", "code={$val.channel_code}")}' title='{t domain="sms"}编辑{/t}'>{t domain="sms"}编辑{/t}</a>&nbsp;|&nbsp;
						<a class="switch ecjiafc-red" href="javascript:;" data-url='{RC_Uri::url("sms/admin_plugin/switch_state", "code={$val.channel_code}")}&enabled=0' title='{t domain="sms"}注销短信服务{/t}'>{t domain="sms"}注销短信服务{/t}</a>&nbsp;|&nbsp;
						<a class="check" href="javascript:;" data-url='{RC_Uri::url("sms/admin_plugin/check_balance", "code={$val.channel_code}")}' title='{t domain="sms"}查看余额{/t}'>{t domain="sms"}查看余额{/t}</a>
					</div>
				<!-- {else} -->
					<div class="edit-list">
						<a class="switch" href="javascript:;" data-url='{RC_Uri::url("sms/admin_plugin/switch_state", "code={$val.channel_code}")}&enabled=1' title='{t domain="sms"}启用{/t}'>{t domain="sms"}启用{/t}</a>
					</div>
				<!-- {/if} -->
			</td>
			<td>
				<!-- {if $val.enabled == 1} -->
					<span class="cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('sms/admin_plugin/edit_order')}" data-name="sort_order" data-pk="{$val.channel_id}" data-title='{t domain="sms"}编辑排序{/t}'>{$val.sort_order}</span>
				<!-- {else} -->
					{$val.sort_order}
				<!-- {/if} -->
			</td>
			<td>
				<i class="{if $val.enabled eq 1}fontello-icon-ok{else}fontello-icon-cancel{/if}"></i>
			</td>
		</tr>
		<!-- {foreachelse} -->
		<tr><td class="no-records" colspan="4">{t domain="sms"}没有找到任何记录{/t}</td></tr>
		<!-- {/foreach} -->
	</tbody>
</table>
<!-- {$list.page} -->
<!-- {/block} -->
