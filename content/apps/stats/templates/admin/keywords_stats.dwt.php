<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.keywords.init();
</script>
<!-- {/block} -->
<!-- {block name="main_content"} -->
<!--搜索引擎-->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} --><a class="btn plus_or_reply"  id="sticky_a" href="{$action_link.href}&start_date={$start_date}&end_date={$end_date}&filter={$filter}"><i class="fontello-icon-download"></i>{t}{$action_link.text}{/t}</a><!-- {/if} -->
	</h3>
</div>

<div class="row-fluid">
	<form action="{$search_action}" method="post" name="theForm">
		{if 0}<div class="row-fluid">
			<div class="choose_list f_r">
			<span class="f_r">{lang key='stats::statistic.result_filter'}</span>
			<!-- {foreach from=$keywords key=sename item=val} -->
				<div class="f_l">
					<input type="checkbox" name="filter" value="{$sename}" {if $val}checked{/if} >
				</div>
				<span class="l_h25">{$sename}</span>
			<!-- {/foreach} -->
			</div>
		</div>{/if}
		<div class="row-fluid">
			<div class="choose_list f_r">
				<span class="f_r">{lang key='stats::statistic.start_date'}</span>
				<input class="start_date f_l w110" name="start_date" type="text" placeholder="{lang key='stats::statistic.start_date_msg'}" value="{$start_date}">
				<span class="f_r">{lang key='stats::statistic.end_date'}</span>
				<input class="end_date f_l w110" name="end_date" type="text" placeholder="{lang key='stats.statistic.end_date_msg'}" value="{$end_date}">
				<input class="btn screen-btn" type="submit" value="{lang key='system::system.button_search'}">
			</div>
		</div>
	</form>
</div>
	
<div class="row-fluid">
	<table class="table table-striped" id="smpl_tbl">
		<thead>
			<tr>
				<th>{lang key='stats::statistic.keywords'}</th>
				{if 0}<th class="w150">{lang key='stats::statistic.list_searchengine'}</th>{/if}
				<th class="w120">{lang key='stats::statistic.hits'}</th>
				<th class="w100">{lang key='stats::statistic.date'}</th>
			</tr>
		</thead>
		<tbody>
			<!-- {foreach from=$keywords_data.item item=list} -->
			<tr>
				<td>{$list.keyword}</td>
				{if 0}<td>{$list.searchengine}</td>{/if}
				<td>{$list.count}</td>
				<td>{$list.date}</td>
			</tr>
			<!-- {foreachelse} -->
	    	<tr><td class="dataTables_empty" colspan="3">{lang key='system::system.no_records'}</td></tr>
	  		<!-- {/foreach} -->
		</tbody>
	</table>
	<!-- {$keywords_data.page} -->
</div>
	
<!-- {/block} -->