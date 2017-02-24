<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.affiliate.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<!-- 分成管理-->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
	</h3>
</div>
	
<div class="row-fluid">
	<form method="post" action="{$search_action}" name="search_from">
		<select name="status" class="w150">
			<option value=""	{if $smarty.get.status eq ''}	selected{/if}>{lang key='affiliate::affiliate_ck.sch_stats.all'}</option>
			<option value="0" 	{if $smarty.get.status eq '0'}	selected{/if}>{lang key='affiliate::affiliate_ck.sch_stats.0'}</option>
			<option value="1"	{if $smarty.get.status eq '1'}	selected{/if}>{lang key='affiliate::affiliate_ck.sch_stats.1'}</option>
			<option value="2"	{if $smarty.get.status eq '2'}	selected{/if}>{lang key='affiliate::affiliate_ck.sch_stats.2'}</option>
		</select>
		<a class="btn m_l5 screen-btn">{lang key='affiliate::affiliate_ck.filter'}</a>
		
		<div class="top_right f_r" >
			<input type="text" name="order_sn" value="{$smarty.get.order_sn}" placeholder="{lang key='affiliate::affiliate_ck.order_sn_empty'}">
			<input type="submit" value="{lang key='system::system.button_search'}" class="btn">
		</div>
	</form>
</div>

<div class="row-fluid">
	 <div class="span12"> 
		<table class="table table-hide-edit" id="list-table">
			<thead>
			  	<tr>
			  		<th class="w120">{lang key='affiliate::affiliate_ck.order_id'}</th>
				    <th class="w100">{lang key='affiliate::affiliate_ck.order_stats.name'}</th>
				    <th class="w100">{lang key='affiliate::affiliate_ck.sch_stats.name'}</th>
				    <th>{lang key='affiliate::affiliate_ck.log_info'}</th>
				    <th class="w110">{lang key='affiliate::affiliate_ck.separate_type'}</th>
				    <th class="w100">{lang key='system::system.handler'}</th>	
			  	</tr>
		  	</thead>
		  	<tbody>
			  	<!-- {foreach from=$logdb.item item=log} -->
			  	<tr align="center">
			  		<td>{$log.order_sn}</td>
			  		<td>{$order_stats[$log.order_status]}</td>
			  		<td>{$sch_stats[$log.is_separate]}</td>
			  		<td>{$log.info}</td>
			  		<td>{$separate_by[$log.separate_type]}</td>
			  		<td>
			  			<!-- {if $log.is_separate eq 0 && $log.separate_able eq 1 && $on eq 1} -->
			  			<a class="toggle_view" href='{url path="affiliate/admin_separate/admin_separate" args="id={$log.order_id}"}'  data-msg="{lang key='affiliate::affiliate_ck.js_languages.separate_confirm'}" data-pjax-url='{url path="affiliate/admin_separate/init" args="page={$logdb.current_page}"}' data-val="separate">{lang key='affiliate::affiliate_ck.affiliate_separate'}</a>&nbsp;|&nbsp;
			  			<a class="toggle_view" href='{url path="affiliate/admin_separate/cancel" args="id={$log.order_id}"}'  data-msg="{lang key='affiliate::affiliate_ck.js_languages.cancel_confirm'}" data-pjax-url='{url path="affiliate/admin_separate/init" args="page={$logdb.current_page}"}' data-val="cancel">{lang key='affiliate::affiliate_ck.affiliate_cancel'}</a>
			  			<!-- {elseif $log.is_separate eq 1} -->
			  			<a class="toggle_view" href='{url path="affiliate/admin_separate/rollback" args="id={$log.log_id}"}'  data-msg="{lang key='affiliate::affiliate_ck.js_languages.rollback_confirm'}" data-pjax-url='{url path="affiliate/admin_separate/init" args="page={$logdb.current_page}"}' data-val="rollback">{lang key='affiliate::affiliate_ck.affiliate_rollback'}</a>
			  			<!-- {else} -->
			  			-
			  			<!-- {/if} -->
			  		</td>
			  	</tr>
			  	<!-- {foreachelse} -->
				<tr><td class="dataTables_empty" colspan="6">{lang key='system::system.no_records'}</td></tr>
            	<!-- {/foreach} -->
			</tbody>
		</table>
		<!-- {$logdb.page} -->
	</div>
</div>
<!-- {/block} -->