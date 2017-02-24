<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.upgrade.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
	</h3>
</div>

<div id="upgrade">
	<!-- {if $nav_tabs} -->
	<ul class="nav nav-tabs">
		<!-- {foreach from=$nav_tabs item=tab} -->
		<!-- {if $tab.key neq $smarty.const.ROUTE_A} -->
		<li><a class="data-pjax" href="{$tab.url}">{$tab.title}</a></li>
		<!-- {else} -->
		<li class="active"><a href="javascript:;">{$tab.title}</a></li>
		<!-- {/if} -->
		<!-- {/foreach} -->
	</ul>
	<!-- {/if} -->

	<div class="row-fluid">
		<div class="span12">
			<form class="form-inline" name="checkUpdate" action="{url path='@upgrade/check_update'}" method="post">
				<div class="control-group">
					<label class="oldTime checkbox">{t}最后检查于: {/t}{$check_upgrade_time}&nbsp;</label>
					<button class="checkUpdate btn">{t}再次检查{/t}</button>
					<!-- <div class="upgrade_go ecjiafd-inline hide">
						<a class="btn btn-info" href="javascript:;">{t}开始升级{/t}</a>
					</div> -->
				</div>
			</form>

			<div class="alert alert-info hide">
				<a class="close" data-dismiss="alert">×</a>
				{t}注意：若您未检测到可用更新，您还可以到{/t}<a target="_blank" href="http://www.ecjia.com">www.ecjia.com</a>{t}查看。{/t}
			</div>

			<table class="table table-striped smpl_tbl">
				<thead>
					<tr>
						<th width="50%">{t}当前版本{/t}</th>
						<th width="50%">{t}更新日期{/t}</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Ver. {$smarty.const.VERSION}</td>
						<td>{$smarty.const.RELEASE}</td>
					</tr>
				</tbody>
			</table>

			<!-- <table class="table table-striped smpl_tbl newVer hide">
				<thead>
					<tr>
						<th width="50%">{t}可升级版本{/t}</th>
						<th width="50%">{t}更新日期{/t}</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Ver. 1.2</td>
						<td>20140529</td>
					</tr>
				</tbody>
			</table> -->
		</div>
	</div>
</div>

<!-- {/block} -->