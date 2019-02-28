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
						<strong>{t domain="mobile"}移动设备信息{/t}</strong>
					</a>
				</div>
				<div class="accordion-body in collapse" id="goods_info_area_submit">
					<table class="table table-oddtd m_b0">
						<tbody class="first-td-no-leftbd">
							<tr>
								<td><div align="right"><strong>{t domain="mobile"}用户ID：{/t}</strong></div></td>
								<td colspan="3">{if $device.user_id eq 0}{t domain="mobile"}暂无{/t}{else}{$device.user_id}{/if}&nbsp;&nbsp;&nbsp;{if $device.user_type neq 'admin'}【{t domain="mobile"}不是管理员{/t}】{else}【{t domain="mobile"}是管理员{/t}】{/if}</td>
							</tr>
							<tr>
								<td><div align="right"><strong>{t domain="mobile"}设备类型：{/t}</strong></div></td>
								<td>{$device.device_client}</td>
								<td><div align="right"><strong>{t domain="mobile"}设备名称：{/t}</strong></div></td>
								<td>{$device.device_name}</td>
							</tr>
							<tr>
								<td><div align="right"><strong>{t domain="mobile"}操作系统：{/t}</strong></div></td>
								<td><!-- {if $device.device_type} -->{$device.device_type}（{$device.device_os}）<!-- {/if} --></td>
								<td><div align="right"><strong>{t domain="mobile"}UDID：{/t}</strong></div></td>
								<td>{$device.device_udid}</td>
							</tr>
							<tr>
								<td><div align="right"><strong>{t domain="mobile"}设备别名：{/t}</strong></div></td>
								<td>
							        <span class="cursor_pointer" data-text="text" data-trigger="editable" data-url="{RC_Uri::url('mobile/admin_device/edit_device_alias')}" data-name="device_alias" data-pk="{$device.id}" data-title='{t domain="mobile"}编辑设备别名{/t}' >{$device.device_alias}</span>
							    </td>
								<td><div align="right"><strong>{t domain="mobile"}状态：{/t}</strong></div></td>
								<td>{if $device.in_status eq 0}{t domain="mobile"}开启{/t}{else}{t domain="mobile"}关闭{/t}{/if}</td>
							</tr>	
							<tr>
								<td><div align="right"><strong>{t domain="mobile"}添加时间：{/t}</strong></div></td>
								<td>{$device.add_time}</td>
								<td><div align="right"><strong>{t domain="mobile"}位置：{/t}</strong></div></td>
								<td>{$device.location_province}/{$device.location_city}</td>
							</tr>
							<tr>
								<td><div align="right"><strong>{t domain="mobile"}更新时间：{/t}</strong></div></td>
								<td>{$device.update_time}</td>
								<td><div align="right"><strong>{t domain="mobile"}访问次数：{/t}</strong></div></td>
								<td>{$device.visit_times}</td>
							</tr>
							<tr>
								<td><div align="right"><strong>{t domain="mobile"}DeviceToken：{/t}</strong></div></td>
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