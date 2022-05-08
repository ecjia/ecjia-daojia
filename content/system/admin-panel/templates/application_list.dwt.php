<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.application.list();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<!-- {if $application_num} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
	</h3>
	<ul class="nav nav-pills">
		<!-- {if $smarty.get.useapplicationnum neq 1 and $smarty.get.useapplicationnum neq 2} --><li class="active"><a><!-- {else} --><li><a class="data-pjax" href="{url path='@admin_application/init'}"><!-- {/if}{t}全部{/t} --> <span class="badge badge-info"><!-- {$application_num} --></span> </a></li>
		<!-- {if $smarty.get.useapplicationnum eq 1} --><li class="active"><a><!-- {else} --><li><a class="data-pjax" href="{url path='@admin_application/init' args='useapplicationnum=1'}"><!-- {/if}{t}已安装{/t} --><span class="badge badge-info"><!-- {$use_application_num} --></span></a></li>
		<!-- {if $smarty.get.useapplicationnum eq 2} --><li class="active"><a><!-- {else} --><li><a class="data-pjax" href="{url path='@admin_application/init' args='useapplicationnum=2'}"><!-- {/if}{t}未安装{/t} --><span class="badge badge-info"><!-- {$unuse_application_num} --></span></a></li>
		<a class="btn f_r data-pjax" href="{url path='@admin_application/init' args='reload=1'}"><!-- {t}刷新列表{/t} --></a>
	</ul>
</div>

<div class="row-fluid sepH_c">
	<div class="span12">
		<table class="table table-plugin" data-rowlink="a" id="plugin-table1">
			<thead>
				<tr>
					<th class="w100">{t}名称{/t}</th>
					<th>{t}描述{/t}</th>
				</tr>
			</thead>
			<tbody>
				<!-- {foreach from=$applications item=application} -->
				<tr {if $application.install eq 1}class="info left_border"{/if}>
					<td>
						<!-- {$application.package.format_name} -->
                        <!-- {if ! $application.is_core} -->
						<br />
						<span class="hide-edit-area">
							<!-- {if $application.installed eq 1} -->
							<a class="ecjiafc-red" href='{url path="@admin_application/uninstall" args="id={$application.identifier}"}' data-msg="{t}您确定要卸载该应用吗？{/t}" data-toggle="ajaxremove">{t}卸载{/t}</a>
							<!-- {else} -->
							<a class="data-pjax application-install" href='{url path="@admin_application/detail" args="step=install&id={$application.identifier}"}'>{t}安装{/t}</a>
							<a class="ecjiafc-red application-delete" href='{url path="@admin_application/uninstall" args="id={$application.identifier}"}' data-msg="{t}您确定要删除该应用吗？{/t}" data-toggle="ajaxremove">{t}删除{/t}</a>
							<!-- {/if} -->
						</span>
                        <!-- {/if} -->
					</td>
					<td>
						<!-- {$application.package.format_description|nl2br} -->
                        <br />
                        <!-- {if $application.is_core} -->
                        <span class="badge badge-default">内置</span>
                        <!-- {/if} -->
                        <!-- {$application.package.version} {t}| 作者：{/t} --><a href="{$application.package.website}"><!-- {$application.package.author} --></a> | <a class="data-pjax" href='{url path="@admin_application/detail" args="id={$application.identifier}"}'><!-- {t}查看详情{/t} --></a>
					</td>
				</tr>
				<!-- {/foreach} -->
			</tbody>
		</table>
	</div>
</div>
<!-- {/if} -->
<!-- {/block} -->
