<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.merchant.keywords.init();
</script>
<!-- {/block} -->
<!-- {block name="home-content"} -->
<!--搜索-->
<div class="page-header">
	<div class="pull-left">
		<h3><!-- {if $ur_here}{$ur_here}{/if} --></h3>
  	</div>
	<!-- {if $action_link} -->
	<div class="pull-right">
	  <a class="btn btn-primary" id="sticky_a" href="{$action_link.href}&start_date={$start_date}&end_date={$end_date}"><i class="glyphicon glyphicon-download-alt"></i> {t}{$action_link.text}{/t}</a>
	</div>
	<!-- {/if} -->
	<div class="clearfix"></div>
</div>

<div class="row">
	<div class="col-lg-12 panel-heading">
    	<form class="form-inline pull-right" action="{$search_action}" method="post" name="theForm">
			<span>{lang key='stats::statistic.start_date'}</span>
			<input class="form-control start_date w110" name="start_date" type="text" placeholder="{lang key='stats::statistic.start_date_msg'}" value="{$start_date}">
			<span>{lang key='stats::statistic.end_date'}</span>
			<input class="form-control end_date w110" name="end_date" type="text" placeholder="{lang key='stats.statistic.end_date_msg'}" value="{$end_date}">
			<button class="btn btn-primary screen-btn" type="submit"><i class="fa fa-search" data-original-title="" title=""></i> {lang key='system::system.button_search'}</button>
    	</form>
	</div>
</div>
	
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
        	<table class="table table-striped table-hover" id="smpl_tbl">
        		<thead>
        			<tr>
        				<th>{lang key='stats::statistic.keywords'}</th>
        				<th class="w120">{lang key='stats::statistic.hits'}</th>
        				<th class="w100">{lang key='stats::statistic.date'}</th>
        			</tr>
        		</thead>
        		<tbody>
        			<!-- {foreach from=$keywords_data.item item=list} -->
        			<tr>
        				<td>{$list.keyword}</td>
        				<td>{$list.count}</td>
        				<td>{$list.date}</td>
        			</tr>
        			<!-- {foreachelse} -->
        	    	<tr><td class="dataTables_empty" colspan="3">{lang key='system::system.no_records'}</td></tr>
        	  		<!-- {/foreach} -->
        		</tbody>
        	</table>
    	</section>
    	<!-- {$keywords_data.page} -->
	</div>
</div>
<!-- {/block} -->