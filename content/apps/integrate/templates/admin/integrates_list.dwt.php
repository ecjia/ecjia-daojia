<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="plugin_config.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.integrate_list.init();
</script>
<!-- {/block} -->

<!-- {block name="admin_plugin_list"} -->
<div class="form-div">
	<div class="alert alert-info" >{t domain="integrate" escape=no}使用方法：<br/>
         1:如果需要整合其他的用户系统，请到 插件中心 安装相应插件进行整合。<br/>
         2:如果需要更换整合的用户系统，直接启用目标插件即可完成整合，同时将自动停用其他整合插件。<br/>
         3:如果不需要整合任何用户系统，请选择启用 ECJia 插件，即可停用所有的整合插件。{/t}</div>
</div>

<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a class="btn plus_or_reply data-pjax" href="{$action_link.href}"><i class="fontello-icon-plus"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>	
</div>
<div class="row-fluid">
	<div class="span12">
		<form method="post"  name="listForm" >
			<table class="table" id="smpl_tbl">
				<thead>
					<tr>
						<th class="w100">{t domain="integrate"}名称{/t}</th>
						<th>{t domain="integrate"}描述{/t}</th>
					</tr>
				</thead>
				<tbody>
					<!-- {foreach from=$integrate_list item=integrate} -->
					<tr{if $integrate.activate eq 1} class="info left_border"{/if}>
						<td class="first-cell">{$integrate.format_name}</td>
						<td class="first-cell">{$integrate.format_description}
							<br/>
						<!-- {if $integrate.activate eq 1} -->
							<a class="cursor_pointer data-pjax" id="setup" href='{url path="integrate/admin_plugin/setup" args="code={$integrate.code}"}'>{t domain="integrate"}设置{/t}</a>
						<!-- {else} -->
							<a class="install cursor_pointer" href='{url path="integrate/admin_plugin/activate" args="code={$integrate.code}"}'>{t domain="integrate"}启用{/t}</a>
						<!-- {/if} -->
						</td>
					</tr>
					<!-- {foreachelse} -->
					<tr><td class="no-records" colspan="2">{t domain="integrate"}没有找到任何记录{/t}</td></tr>
					<!-- {/foreach} -->
				</tbody>
			</table>
		</form>
	</div>
</div>
<!-- {/block} -->