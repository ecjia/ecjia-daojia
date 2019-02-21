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
	  <a class="btn btn-primary data-pjax" href="{$action_link.href}"><i class="fa fa-reply"></i> {t domain="commission"}{$action_link.text}{/t}</a>
	</div>
	<!-- {/if} -->
	<div class="clearfix"></div>
</div>
 
<div class="row">
	<div class="col-lg-12">
      	<section class="panel">
	      	<ul class="nav nav-pills pull-left panel-heading">
    			<li class="{if !$smarty.get.type}active{/if}">
    				<a class="data-pjax" href="{RC_uri::url('commission/merchant/fund_record')}{if $filter.start_time}&start_time={$filter.start_time}{/if}{if $filter.end_time}&end_time={$filter.end_time}{/if}{if $filter.keywords}&keywords={$filter.keywords}{/if}">{t domain="commission"}全部{/t}
    					<span class="badge badge-info">{$type_count.count_all}</span>
    				</a>
    			</li>
    			
    			<li class="{if $smarty.get.type eq 'passed'}active{/if}">
    				<a class="data-pjax" href="{RC_uri::url('commission/merchant/fund_record')}&type=passed{if $filter.start_time}&start_time={$filter.start_time}{/if}{if $filter.end_time}&end_time={$filter.end_time}{/if}{if $filter.keywords}&keywords={$filter.keywords}{/if}">{t domain="commission"}已通过{/t}
    					<span class="badge badge-info use-plugins-num">{$type_count.passed}</span>
    				</a>
    			</li>
    			
    			<li class="{if $smarty.get.type eq 'refused'}active{/if}">
    				<a class="data-pjax" href="{RC_uri::url('commission/merchant/fund_record')}&type=refused{if $filter.start_time}&start_time={$filter.start_time}{/if}{if $filter.end_time}&end_time={$filter.end_time}{/if}{if $filter.keywords}&keywords={$filter.keywords}{/if}">{t domain="commission"}已拒绝{/t}
    					<span class="badge badge-info use-plugins-num">{$type_count.refused}</span>
    				</a>
    			</li>

    			<li class="{if $smarty.get.type eq 'wait_check'}active{/if}">
    				<a class="data-pjax" href="{RC_uri::url('commission/merchant/fund_record')}&type=wait_check{if $filter.start_time}&start_time={$filter.start_time}{/if}{if $filter.end_time}&end_time={$filter.end_time}{/if}{if $filter.keywords}&keywords={$filter.keywords}{/if}">{t domain="commission"}待审核{/t}
    					<span class="badge badge-info unuse-plugins-num">{$type_count.wait_check}</span>
    				</a>
    			</li>
    		</ul>
            <div class="col-lg-12 panel-heading form-inline">
                <form class="form-inline pull-right" action='{RC_uri::url("commission/merchant/fund_record")}{if $smarty.get.type}&type={$smarty.get.type}{/if}' method="post" name="searchForm">
        			<div class="form-group">
                        {t domain="commission"}申请时间：{/t}
        				<input type="text" class="form-control fund_time" name="start_time" value="{$filter.start_time}" placeholder="{t domain="commission"}请选择开始时间{/t}">
        				&nbsp;{t domain="commission"}至{/t}&nbsp;
        				<input type="text" class="form-control fund_time" name="end_time" value="{$filter.end_time}" placeholder="{t domain="commission"}请选择结束时间{/t}">
        			    <input type="text" class="form-control" name="keywords" value="{$filter.keywords}" placeholder="{t domain="commission"}请输入提现流水号{/t}">
        			</div>
        			<button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> {t domain="commission"}搜索{/t} </button>
        		</form>
    		</div>
    		
			<div class="panel-body">
				<section class="panel">
					<table class="table table-striped table-hover table-hide-edit">
	        			<thead>
	        				<tr>
	        					<th>{t domain="commission"}流水号{/t}</th>
	        					<th>{t domain="commission"}提现金额{/t}</th>
	        					<th>{t domain="commission"}提现方式{/t}</th>
	        					<th>{t domain="commission"}收款账号{/t}</th>
	        					<th>{t domain="commission"}申请时间{/t}</th>
	        					<th>{t domain="commission"}审核状态{/t}</th>
	        				</tr>
	        			</thead>
	        			<tbody>
	        				<!-- {foreach from=$data.item key=key item=list} -->
	        				<tr>
								<td class="hide-edit-area">
									{$list.order_sn}
									<div class="edit-list">
										<a href='{url path="commission/merchant/fund_detail" args="id={$list.id}"}' class="data-pjax" title="{t domain="commission"}查看详情{/t}">{t domain="commission"}查看详情{/t}</a>
									</div>
								</td>
								<td>{$list.amount}</td>
								<td>
									{if $list.account_type eq 'bank'}
                                    {t domain="commission"}银行卡{/t}
									{else if $list.account_type eq 'alipay'}
                                    {t domain="commission"}支付宝{/t}
									{/if}
								</td>
								<td>
									{$list.account_number}<br>
									{$list.bank_name}
								</td>
								<td>{$list.add_time}</td>
								<td>
									{if $list.status eq 1}
                                    {t domain="commission"}待审核{/t}
									{else if $list.status eq 2}
                                    {t domain="commission"}已通过{/t}
									{else if $list.status eq 3}
                                    {t domain="commission"}已拒绝{/t}
									{/if}
								</td>
	        				</tr>
	        				<!-- {foreachelse} -->
	        		    	<tr><td class="dataTables_empty" colspan="6">{t domain="commission"}没有找到任何记录{/t}</td></tr>
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