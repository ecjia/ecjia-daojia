<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">

</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->
<div class="page-header">
	<div class="pull-left">
		<h2><!-- {if $ur_here}{$ur_here}{/if} --></h2>
  	</div>
	<!-- {if $action_link} -->
	<div class="pull-right">
	  <a class="btn btn-primary data-pjax" href="{$action_link.href}">{t}{$action_link.text}{/t}</a>
	</div>
	<!-- {/if} -->
	<div class="clearfix"></div>
</div>

<div class="row">
	<div class="col-lg-12">
      	<section class="panel">
      		<div class="panel-body fund-title">
      			<span class="panel-item">账户余额：<span class="price">{$account.formated_money}</span></span>
      			{if $account.frozen_money neq 0}
      			<span class="panel-item">冻结资金：<span class="price">{$account.formated_frozen_money}</span></span>
      			{/if}
      			<span class="panel-item">保证金：<span class="price">{$account.formated_deposit}</span></span>
      			<span class="panel-item">可用余额：<span class="price">{$account.formated_amount_available}</span></span>
      			<span class="panel-item"><a class="btn btn-info data-pjax" href='{url path="commission/merchant/reply_fund"}'>申请提现</a></span>
      		</div>
      		<div class="fund-list-header">{$title}</div>
			<div class="panel-body">
				<section>
					<table class="table table-striped table-advance table-hover">
	        			<thead>
	        				<tr class="th-striped">
	        					<th>结算时间</th>
	        					<th>类型/单号</th>
	        					<th>收支金额（元）</th>
	        					<th>账户余额（元）</th>
	        				</tr>
	        			</thead>
	        			<tbody>
	        				<!-- {foreach from=$data.item key=key item=list} -->
	        				<tr>
								<td>{$list.change_time}</td>
								<td>
									{if $list.change_type eq 'charge'}
									充值
									{else if $list.change_type eq 'withdraw'}
									提现
									{else if $list.change_type eq 'bill'}
									结算
									{/if}
									&nbsp;
									{$list.change_desc}									
								</td>
								<td {if $list.change_type eq 'withdraw'}class="withdraw-price"{/if}>{$list.money}</td>
								<td>{$list.store_money}</td>
	        				</tr>
	        				<!-- {foreachelse} -->
	        		    	<tr><td class="dataTables_empty" colspan="5">没有找到任何记录</td></tr>
	        		  		<!-- {/foreach} -->
	        			</tbody>
	        		</table>
				</section>
			</div>
		</section>
      <!-- {$data.page} -->
	</div>
</div>
<!-- {/block} -->