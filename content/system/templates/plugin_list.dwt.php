<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.plugin_list.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<h3 class="heading">
	<!-- {if $ur_here}{$ur_here}{/if} -->
	<!-- {if $action_link} -->
	<a class="data-pjax btn plus_or_reply" href="{$action_link.href}" id="sticky_a" style="float:right;margin-top:-3px;"><i class="fontello-icon-plus"></i>{$action_link.text}</a>
	<!-- {/if} -->
</h3>

<ul class="nav nav-pills">
	{if $smarty.get.usepluginsnum neq 1 and $smarty.get.usepluginsnum neq 2}<li class="active"><a>{else}<li><a class="data-pjax" href="{url path='@admin_plugin/init'}">{/if}{t}全部{/t} <span class="badge badge-info">{$plugins_num}</span> </a></li>
	{if $smarty.get.usepluginsnum eq 1}<li class="active"><a>{else}<li><a class="data-pjax" href="{url path='@admin_plugin/init' args='usepluginsnum=1'}">{/if}{t}已安装{/t}<span class="badge badge-info use-plugins-num">{$use_plugins_num}</span></a></li>
	{if $smarty.get.usepluginsnum eq 2}<li class="active"><a>{else}<li><a class="data-pjax" href="{url path='@admin_plugin/init' args='usepluginsnum=2'}">{/if}{t}未安装{/t}<span class="badge badge-info unuse-plugins-num">{$unuse_plugins_num}</span></a></li>
	<a class="btn f_r data-pjax" href="{url path='@admin_plugin/init' args='reload=1'}">{t}刷新列表{/t}</a>
</ul>

<div class="row-fluid sepH_c">
	<div class="span12">
		<table class="table table-plugin" data-rowlink="a" id="plugin-table">
			<thead>
				<tr>
					<th width="20%">{t}名称{/t}</th>
					<th>{t}描述{/t}</th>
				</tr>
			</thead>
			<tbody>
				<!-- {foreach from=$plugins item=plugin key=key} -->
				<tr {if $plugin.install == "1"} class="info left_border"{/if}>
					<td>
						<!-- {$plugin.Name} -->
						<br />
						<span class="hide-edit-area">
							<!-- {if $plugin.install eq 1} -->
							<!-- <a href="javascript:;">{t}设置{/t}</a> -->
							<a class="plugin-uninstall ecjiafc-red" data-id="{$key}" href='{url path="@admin_plugin/uninstall" args="id={$key}"}'>{t}卸载{/t}</a>
							<!-- {else} -->
							<a class="plugin-install" data-id="{$key}" href='{url path="@admin_plugin/install" args="id={$key}"}'>{t}安装{/t}</a>
							<a class="plugin-del ecjiafc-red" href="javascript:;">{t}删除{/t}</a>
							<!-- {/if} -->
						</span>

					</td>
					<td>{$plugin.Description|nl2br}<br />{$plugin.Version} {t}| 作者：{/t}<a href="{$plugin.AuthorURI}" target="_blank">{$plugin.Author}</a></td>
				</tr>
				<!-- {/foreach} -->
			</tbody>
		</table>	
	</div>
</div>
<!-- {/block} -->