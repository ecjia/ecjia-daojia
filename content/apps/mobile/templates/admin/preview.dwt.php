<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		{if $action_link}
		<a class="btn plus_or_reply data-pjax" href="{$action_link.href}" id="sticky_a" ><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		{/if}
		{if $action_linkedit}
		<a class="btn plus_or_reply data-pjax" href="{$action_linkedit.href}" id="sticky_a" ><i class="fontello-icon-edit"></i>{$action_linkedit.text}</a>
		{/if}
	</h3>	
</div>


<div class="row-fluid goods_preview">
	<div class="span12 ">
		<div class="foldable-list move-mod-group" id="goods_info_sort_submit">
			<div class="accordion-group">
				<div class="accordion-heading">
					<a class="accordion-toggle collapsed move-mod-head" data-toggle="collapse" data-target="#goods_info_area_submit">
						<strong>{lang key='mobile::mobile.device_info'}</strong>
					</a>
				</div>
				<div class="accordion-body in collapse" id="goods_info_area_submit">
					<table class="table table-oddtd m_b0">
						<tbody class="first-td-no-leftbd">
							<tr>
								<td><div align="right"><strong>{lang key='mobile::mobile.label_user_id'}</strong></div></td>
								<td colspan="3">{if $device.user_id eq 0}{lang key='mobile::mobile.no'}{else}{$device.user_id}{/if}&nbsp;&nbsp;&nbsp;{if $device.user_type neq 'admin'}【{lang key='mobile::mobile.not_admin'}】{else}【{lang key='mobile::mobile.is_admin'}】{/if}</td>
							</tr>
							<tr>
								<td><div align="right"><strong>{lang key='mobile::mobile.label_device_type'}</strong></div></td>
								<td>{$device.device_client}</td>
								<td><div align="right"><strong>{lang key='mobile::mobile.label_device_name'}</strong></div></td>
								<td>{$device.device_name}</td>
							</tr>
							<tr>
								<td><div align="right"><strong>{lang key='mobile::mobile.label_device_os'}</strong></div></td>
								<td><!-- {if $device.device_type} -->{$device.device_type}（{$device.device_os}）<!-- {/if} --></td>
								<td><div align="right"><strong>{lang key='mobile::mobile.label_device_udid'}</strong></div></td>
								<td>{$device.device_udid}</td>
							</tr>
							<tr>
								<td><div align="right"><strong>{lang key='mobile::mobile.label_device_alias'}</strong></div></td>
								<td>
							        <span class="cursor_pointer" data-text="text" data-trigger="editable" data-url="{RC_Uri::url('mobile/admin_device/edit_device_alias')}" data-name="device_alias" data-pk="{$device.id}" data-title="{lang key='mobile::mobile.edit_device_alias'}" >{$device.device_alias}</span>
							    </td>
								<td><div align="right"><strong>{lang key='mobile::mobile.label_in_status'}</strong></div></td>
								<td>{if $device.in_status eq 0}{lang key='mobile::mobile.enabled'}{else}{lang key='mobile::mobile.disable'}{/if}</td>
							</tr>	
							<tr>
								<td><div align="right"><strong>{lang key='mobile::mobile.label_add_time'}</strong></div></td>
								<td>{$device.add_time}</td>
								<td><div align="right"><strong>{lang key='mobile::mobile.label_location'}</strong></div></td>
								<td>{$device.location_province}/{$device.location_city}</td>
							</tr>
							<tr>
								<td><div align="right"><strong>{lang key='mobile::mobile.label_update_time'}</strong></div></td>
								<td>{$device.update_time}</td>
								<td><div align="right"><strong>{lang key='mobile::mobile.visit_times'}</strong></div></td>
								<td>{$device.visit_times}</td>
							</tr>
							<tr>
								<td><div align="right"><strong>{lang key='mobile::mobile.label_device_token'}</strong></div></td>
								<td colspan="3">{$device.device_token}</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- {/block} -->