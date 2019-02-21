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
			<option value=''  		{if $smarty.get.platform eq '' }		selected="true"{/if}>{t domain="platform"}所有平台{/t}</option>
			<option value='wechat' 	{if $smarty.get.platform eq 'wechat'}	selected="true"{/if}>{t domain="platform"}微信{/t}</option>
		</select>
		<a class="btn m_l5 screen-btn">{t domain="platform"}筛选{/t}</a>
		<div class="choose_list f_r">
			<input type="text" name="keywords" value="{$smarty.get.keywords}" placeholder='{t domain="platform"}请输入命令关键字{/t}' />
			<button class="btn" type="submit">{t domain="platform"}搜索{/t}</button>
		</div>
	</form>
</div>

<div class="row-fluid">
	<div class="span12">
		<table class="table table-striped table-hide-edit" data-rowlink="a">
			<thead>
				<tr>
					<th class="w200">{t domain="platform"}公众号名称{/t}</th>
					<th class="w200">{t domain="platform"}平台{/t}</th>
					<th class="w200">{t domain="platform"}关键词{/t}</th>
					<th class="w100">{t domain="platform"}子命令{/t}</th>
				</tr>
			</thead>
			<tbody id="edit_tbody">
				<!-- {foreach from=$modules.module item=module} -->
				<tr>
					<td>{$module.name}</td>
					<td>
						{if $module.platform eq 'wechat'}
                            {t domain="platform"}微信{/t}
						{/if}
					</td>
					<td>{$module.cmd_word}</td>
					<td>{$module.sub_code}</td>
				</tr>
				<!-- {foreachelse} -->
			   	<tr><td class="no-records" colspan="4">{t domain="platform"}没有找到任何记录{/t}</td></tr>
				<!-- {/foreach} -->
			</tbody>
		</table>
		<!-- {$modules.page} -->
	</div>
</div>
<!-- {/block} -->