<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.admin_request.init();
// 	var type = "{$type}";
</script>
<!-- {/block} -->
<!-- {block name="main_content"} -->
<!-- {if $errormsg} -->
	<div class="alert alert-error">
    	<strong>{lang key='wechat::wechat.label_notice'}</strong>{$errormsg}
	</div>
<!-- {/if} -->

{platform_account::getAccountSwtichDisplay('wechat')}

<div>
	<h3 class="heading">
		<!-- {if $ur_list}{$ur_list}{/if} -->
	</h3>
</div>

<div class="row-fluid list-page">
	<div class="span12">
		{if !$errormsg}	
		<div class="tabbable">
			<ul class="nav nav-tabs">
				<li {if $type eq 1}class="active"{/if}><a class="data-pjax" href='{url path="wechat/admin_request/init" args="type=1"}'>{lang key='wechat::wechat.today'}（{$list.date.today}）</a></li>
				<li {if $type eq 2}class="active"{/if}><a class="data-pjax" href='{url path="wechat/admin_request/init" args="type=2"}'>{lang key='wechat::wechat.yesterday'}（{$list.date.yesterday}）</a></li>
			</ul>
		</div>
		{/if}
		<table class="table table-striped smpl_tbl table-hide-edit">
			<thead>
				<tr>
					<th class="w200">{lang key='wechat::wechat.api_name'}</th>
					<th class="w180">{lang key='wechat::wechat.daily_call_limit'}</th>
					<th class="w180">{lang key='wechat::wechat.daily_call_dosage'}</th>
					<th class="w150">{lang key='wechat::wechat.last_request_time'}</th>
				</tr>
			</thead>
			<tbody>
				<!-- {foreach from=$list.item item=val key=key} -->
				<tr>
					<td>{$val.title}</td>
					<td>{if $val.times}{$val.times}{else}{lang key='wechat::wechat.not_have'}{/if}</td>
					<td>{if $val.info.times}{$val.info.times}{else}0{/if}</td>
					<td>{if $val.info.last_time}{$val.info.last_time}{/if}</td>
				</tr>
				<!--  {foreachelse} -->
				<tr><td class="no-records" colspan="4">{lang key='system::system.no_records'}</td></tr>
				<!-- {/foreach} -->
			</tbody>
		</table>
	</div>
</div>
<!-- {/block} -->