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
		<!-- {if $ur_here}{$ur_here}{/if} -->
		{if $action_link}
		<a href="{$action_link.href}" class="btn plus_or_reply data-pjax" id="sticky_a"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		{/if}
	</h3>
</div>	

<div class="row-fluid edit-page">
	<div class="span12 m_t30 m_b30">
		<form class="form-horizontal" method="post" action="{$search_action}" name="searchForm">
			<fieldset>
				<div class="w500 m_0">
					{lang key='platform::platform.lable_command_key'}
					<input type="text" name='keywords' value="{$smarty.get.keywords}">
					<input type="submit" value="{lang key='platform::platform.find'}" class="btn btn-gebo search_command m_l5" />
				</div>
			</fieldset>
		</form>
	</div>
</div>

<!-- {if $smarty.get.keywords} -->
<div class="row-fluid">
	<form method="post" action="{$search_action}" name="searchForm">
		<select class="w150" name="platform" id="select-type">
			<option value=''  		{if $smarty.get.platform eq ''}selected="true"{/if}>{lang key='platform::platform.all_platform'}</option>
			<option value='wechat' 	{if $smarty.get.platform eq 'wechat'}selected="true"{/if}>{lang key='platform::platform.weixin'}</option>
		</select>
		<input type="hidden" name="keyword" value="{$keywords}" />
		<a class="btn m_l5 select-btn">{lang key='platform::platform.filtrate'}</a>
	</form>
</div>

<div class="row-fluid">
	<div class="span12">
		<table class="table table-striped table-hide-edit" data-rowlink="a">
			<thead>
				<tr>
					<th class="w150">{lang key='platform::platform.platform_name'}</th>
					<th class="w150">{lang key='platform::platform.plug_name'}</th>
					<th class="w70">{lang key='platform::platform.terrace'}</th>
					<th class="w150">{lang key='platform::platform.keyword'}</th>
					<th class="w150">{lang key='platform::platform.subcommand'}</th>
					<th class="w50">{lang key='platform::platform.operation'}</th>
				</tr>
			</thead>
			<tbody>
				<!-- {foreach from=$list.item item=item} -->
				<tr>
					<td>{$item.name}</td>
					<td>{$item.ext_name}（{$item.ext_code}）</td>
					<td>
						{if $item.platform eq 'wechat'}
							{lang key='platform::platform.weixin'}
						{/if}
					</td>
					<td>{$item.cmd_word}</td>
					<td>{$item.sub_code}</td>
					<td>
                        <a target="_blank" href='{RC_Uri::url("platform/admin_command/init", "code={$item.ext_code}&account_id={$item.account_id}")}' title="查看">{lang key='platform::platform.examine'}</a>
                    </td>
					
				</tr>
				<!-- {foreachelse} -->
				   <tr><td class="no-records" colspan="6">{lang key='platform::platform.no_find_record'}</td></tr>
				<!-- {/foreach} -->
			</tbody>
		</table>	
		<!-- {$list.page} -->
	</div>
</div>
<!-- {/if} -->
<!-- {/block} -->