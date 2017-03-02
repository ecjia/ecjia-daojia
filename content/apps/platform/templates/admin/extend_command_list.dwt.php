<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.platform.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		{$ext_name}<small>（{$code}）</small>
		{if $back_link}
		<a class="btn plus_or_reply data-pjax" href="{$back_link.href}" id="sticky_a"><i class="fontello-icon-reply"></i>{$back_link.text}</a>
		{/if}
	</h3>
</div>	

<div class="row-fluid">
	<form method="post" action="{$search_action}" name="searchForm">
		<select class="w150" name="platform" id="select-type">
			<option value=''  		{if $smarty.get.platform eq '' }		selected="true"{/if}>{lang key='platform::platform.all_platform'}</option>
			<option value='wechat' 	{if $smarty.get.platform eq 'wechat'}	selected="true"{/if}>{lang key='platform::platform.weixin'}</option>
		</select>
		<a class="btn m_l5 screen-btn">{lang key='platform::platform.filtrate'}</a>
		<div class="choose_list f_r" >
			<input type="text" name="keywords" value="{$smarty.get.keywords}" placeholder="{lang key='platform::platform.command_key'}"/> 
			<button class="btn" type="submit">{lang key='platform::platform.search'}</button>
		</div>
	</form>
</div>

<div class="row-fluid">
	<div class="span12">
		<table class="table table-striped table-hide-edit" data-rowlink="a">
			<thead>
				<tr>
					<th class="w200">{lang key='platform::platform.platform_name'}</th>
					<th class="w200">{lang key='platform::platform.terrace'}</th>
					<th class="w200">{lang key='platform::platform.keyword'}</th>
					<th class="w100">{lang key='platform::platform.subcommand'}</th>
				</tr>
			</thead>
			<tbody id="edit_tbody">
				<!-- {foreach from=$modules.module item=module} -->
				<tr>
					<td>{$module.name}</td>
					<td>
						{if $module.platform eq 'wechat'}
							{lang key='platform::platform.weixin'}
						{/if}
					</td>
					<td>{$module.cmd_word}</td>
					<td>{$module.sub_code}</td>
				</tr>
				<!-- {foreachelse} -->
			   	<tr><td class="no-records" colspan="4">{lang key='system::system.no_records'}</td></tr>
				<!-- {/foreach} -->
			</tbody>
		</table>
		<!-- {$modules.page} -->
	</div>
</div>
<!-- {/block} -->
