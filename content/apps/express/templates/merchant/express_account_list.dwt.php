<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.merchant.account_list.init()
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->

<div class="page-header">
	<div class="pull-left">
		<h3><!-- {if $ur_here}{$ur_here}{/if} --><small>（当前配送员：{$name}）</small></h3>
	</div>
  	<div class="pull-right">  		
  		{if $action_link}
		<a href="{$action_link.href}" class="btn btn-primary data-pjax">
			<i class="fa fa-reply"></i> {$action_link.text}
		</a>
		{/if}
  	</div>
	<div class="clearfix">
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<section class="panel" >
			<header class="panel-heading">
				<div class="all">
					<div class="sale_desc">当前账户余额：<strong><font class="ecjiafc-red">{$user_money}</font></strong> 元</div>
					<div class="form-group choose_list">
						<form class="form-inline" action="{$form_action}" method="post" name="searchForm">
							<span>按时间段查询：</span>
	                    	<input class="form-control date w110" name="start_date" type="text" placeholder="开始时间" value="{$start_date}">
	    					<span class="">-</span>
	    					<input class="form-control date w110" name="end_date" type="text" placeholder="结束时间" value="{$end_date}">
	    					<input class="btn btn-primary select-button" type="button" value="查询">
	    					<input type="hidden" name="user_id" value="{$user_id}">
						</form>
					</div>
				</div>
			</header>
		</section>
		
		<section class="panel">
			<div class="panel-body">
				<section id="unseen">
					<table class="table table-striped table-advance table-hover">
						<thead>
							<tr>
								<th class="w150">账户变动时间</th>
								<th>账户变动原因</th>
								<th class="w100">可用资金账户</th>
							</tr>
						</thead>
						<tbody>
							<!-- {foreach from=$log_list.list item=list} -->
								<tr>
									<td>{$list.change_time}</td>
									<td>{$list.change_desc}</td>
									<td>+ {$list.user_money}</td>
								</tr>
								<!-- {foreachelse} -->
								<tr>
									<td class="dataTables_empty" colspan="3">没有找到任何记录</td>
								</tr>
							<!-- {/foreach} -->
						</tbody>
					</table>
					<!-- {$sale_list_data.page} -->
				</section>
			</div>
		</section>
	</div>
</div>
<!-- {/block} -->