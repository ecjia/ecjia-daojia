<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.merchant.fund.init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->
<div class="page-header">
	<div class="pull-left">
		<h2><!-- {if $ur_here}{$ur_here}{/if} --></h2>
  	</div>
	<!-- {if $action_link} -->
	<div class="pull-right">
	  <a class="btn btn-primary data-pjax" href="{$action_link.href}"><i class="fa fa-reply"></i> {t}{$action_link.text}{/t}</a>
	</div>
	<!-- {/if} -->
	<div class="clearfix"></div>
</div>
 
<div class="row">
	<div class="col-lg-12">
      	<section class="panel">
	      	<ul class="nav nav-pills pull-left panel-heading">
    			<li class="{if !$smarty.get.type}active{/if}">
    				<a class="data-pjax" href="{RC_uri::url('commission/merchant/fund_record')}{if $filter.start_time}&start_time={$filter.start_time}{/if}{if $filter.end_time}&end_time={$filter.end_time}{/if}{if $filter.keywords}&keywords={$filter.keywords}{/if}">全部
    					<span class="badge badge-info">{$type_count.count_all}</span>
    				</a>
    			</li>
    			
    			<li class="{if $smarty.get.type eq 'passed'}active{/if}">
    				<a class="data-pjax" href="{RC_uri::url('commission/merchant/fund_record')}&type=passed{if $filter.start_time}&start_time={$filter.start_time}{/if}{if $filter.end_time}&end_time={$filter.end_time}{/if}{if $filter.keywords}&keywords={$filter.keywords}{/if}">已通过
    					<span class="badge badge-info use-plugins-num">{$type_count.passed}</span>
    				</a>
    			</li>
    			
    			<li class="{if $smarty.get.type eq 'refused'}active{/if}">
    				<a class="data-pjax" href="{RC_uri::url('commission/merchant/fund_record')}&type=refused{if $filter.start_time}&start_time={$filter.start_time}{/if}{if $filter.end_time}&end_time={$filter.end_time}{/if}{if $filter.keywords}&keywords={$filter.keywords}{/if}">已拒绝
    					<span class="badge badge-info use-plugins-num">{$type_count.refused}</span>
    				</a>
    			</li>

    			<li class="{if $smarty.get.type eq 'wait_check'}active{/if}">
    				<a class="data-pjax" href="{RC_uri::url('commission/merchant/fund_record')}&type=wait_check{if $filter.start_time}&start_time={$filter.start_time}{/if}{if $filter.end_time}&end_time={$filter.end_time}{/if}{if $filter.keywords}&keywords={$filter.keywords}{/if}">待审核
    					<span class="badge badge-info unuse-plugins-num">{$type_count.wait_check}</span>
    				</a>
    			</li>
    		</ul>
            <div class="col-lg-12 panel-heading form-inline">
                <form class="form-inline pull-right" action='{RC_uri::url("commission/merchant/fund_record")}{if $smarty.get.type}&type={$smarty.get.type}{/if}' method="post" name="searchForm">
        			<div class="form-group">
        				申请时间：
        				<input type="text" class="form-control fund_time" name="start_time" value="{$filter.start_time}" placeholder="请选择开始时间">
        				&nbsp;至&nbsp;
        				<input type="text" class="form-control fund_time" name="end_time" value="{$filter.end_time}" placeholder="请选择结束时间">
        			    <input type="text" class="form-control" name="keywords" value="{$filter.keywords}" placeholder="请输入提现流水号">
        			</div>
        			<button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> {lang key='system::system.button_search'} </button>
        		</form>
    		</div>
    		
			<div class="panel-body">
				<section class="panel">
					<table class="table table-striped table-hover table-hide-edit">
	        			<thead>
	        				<tr>
	        					<th>流水号</th>
	        					<th>提现金额</th>
	        					<th>提现方式</th>
	        					<th>收款账号</th>
	        					<th>申请时间</th>
	        					<th>审核状态</th>
	        				</tr>
	        			</thead>
	        			<tbody>
	        				<!-- {foreach from=$data.item key=key item=list} -->
	        				<tr>
								<td class="hide-edit-area">
									{$list.order_sn}
									<div class="edit-list">
										<a href='{url path="commission/merchant/fund_detail" args="id={$list.id}"}' class="data-pjax" title="查看详情">{t}查看详情{/t}</a>
									</div>
								</td>
								<td>{$list.amount}</td>
								<td>
									{if $list.account_type eq 'bank'}
										银行卡
									{else if $list.account_type eq 'alipay'}
										支付宝
									{/if}
								</td>
								<td>
									{$list.account_number}<br>
									{$list.bank_name}
								</td>
								<td>{$list.add_time}</td>
								<td>
									{if $list.status eq 1}
										待审核
									{else if $list.status eq 2}
										已通过
									{else if $list.status eq 3}
										已拒绝
									{/if}
								</td>
	        				</tr>
	        				<!-- {foreachelse} -->
	        		    	<tr><td class="dataTables_empty" colspan="6">没有找到任何记录</td></tr>
	        		  		<!-- {/foreach} -->
	        			</tbody>
	        		</table>
				</section>
				<!-- {$data.page} -->
			</div>
		</section>
	</div>
</div>
<!-- {/block} -->