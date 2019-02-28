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
		<h2><!-- {if $ur_here}{$ur_here}{/if} --></h2>
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
			<span>{t domain="stats"}开始日期：{/t}</span>
			<input class="form-control start_date w110" name="start_date" type="text" placeholder="{t domain="stats"}开始日期{/t}" value="{$start_date}">
			<span>{t domain="stats"}结束日期：{/t}</span>
			<input class="form-control end_date w110" name="end_date" type="text" placeholder="{t domain="stats"}结束时间{/t}" value="{$end_date}">
			<button class="btn btn-primary screen-btn" type="submit"><i class="fa fa-search" data-original-title="" title=""></i> {t domain="stats"}搜索{/t}</button>
    	</form>
	</div>
</div>
	
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
        	<table class="table table-striped table-hover" id="smpl_tbl">
        		<thead>
        			<tr>
        				<th>{t domain="stats"}关键词{/t}</th>
        				<th class="w120">{t domain="stats"}搜索次数{/t}</th>
        				<th class="w100">{t domain="stats"}日期{/t}</th>
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
        	    	<tr><td class="dataTables_empty" colspan="3">{t domain="stats"}没有找到任何记录{/t}</td></tr>
        	  		<!-- {/foreach} -->
        		</tbody>
        	</table>
    	</section>
    	<!-- {$keywords_data.page} -->
	</div>
</div>
<!-- {/block} -->