<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	var data = '{$data}';
	ecjia.merchant.order_stats.init();
	{if $smarty.get.type neq 'shipping'}
    	{if $is_multi eq ''}
    	ecjia.merchant.chart.order_general();
    	{else if $is_multi eq 1}
    	ecjia.merchant.chart.order_status();
    	{/if}
    {else if $smarty.get.type eq 'shipping'}
        {if $is_multi eq ''}
        ecjia.merchant.chart.ship_status();
    	{else if $is_multi eq 1}
    	ecjia.merchant.chart.ship_stats();
    	{/if}
	{/if}
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->
	<!-- 订单统计 -->
	<div class="alert alert-info">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-times" data-original-title="" title=""></i></button>
		<strong>温馨提示：</strong>订单统计图表默认显示为按时间段查询
	</div>
	<div class="page-header">
    	<div class="pull-left">
    		<h3><!-- {if $ur_here}{$ur_here}{/if} --></h3>
      	</div>
      	<!-- {if !$is_multi} -->
        	<!-- {if $action_link} -->
        	<div class="pull-right">
        	  <a class="btn btn-primary" id="sticky_a" href="{$action_link.href}&start_date={$start_date}&end_date={$end_date}"><i class="glyphicon glyphicon-download-alt"></i> {t}{$action_link.text}{/t}</a>
        	</div>
        	<!-- {/if} -->
    	<!-- {/if} -->
    	<div class="clearfix"></div>
    </div>
	<!-- <div class="row">
        <div class="col-lg-12">
            <section class="panel">
				<table class="table table-striped">
				    <thead>
				        <th colspan="4">订单统计信息</th>
				    </thead>
					<tbody class="first-td-no-leftbd">
						<tr>
							<td align="right">{t}有效订单总金额：{/t}</td>
							<td>{$total_turnover}</td>
							<td align="right">{t}总点击数：{/t}</td>
							<td>{$click_count}</td>
						</tr>
						
						<tr>
							<td align="right">{t}每千点击订单数：{/t}</td>
							<td>{$click_ordernum}</td>
							<td align="right">{t}每千点击购物额：{/t}</td>
							<td>{$click_turnover}</td>
						</tr>
					</tbody>
				</table>
            </section>
        </div>
    </div> -->
    <div class="row">
      <div class="col-lg-12">
          <section class="panel">
              <header class="panel-heading">订单统计信息</header>
              <div class="panel-body">
                  <section id="unseen">
                    <table class="table table-bordered table-striped table-condensed">
    					<tbody class="first-td-no-leftbd">
    						<tr>
    							<td align="right" width="30%">{t}有效订单总金额：{/t}</td>
    							<td width="20%">{$total_turnover}</td>
    							<td align="right" width="30%">{t}总点击数：{/t}</td>
    							<td width="20%">{$click_count}</td>
    						</tr>
    						<tr>
    							<td align="right">{t}每千点击订单数：{/t}</td>
    							<td>{$click_ordernum}</td>
    							<td align="right">{t}每千点击购物额：{/t}</td>
    							<td>{$click_turnover}</td>
    						</tr>
    					</tbody>
                    </table>
                  </section>
              </div>
          </section>
      </div>
  </div>

  <div class="row">
      <div class="col-lg-12">
          <section class="panel">
              <header class="panel-heading">
                  <div class="form-group t_r">
                    <form class="form-inline" action='{RC_Uri::url("orders/mh_order_stats/init", "{if $smarty.get.type}&type={$smarty.get.type}{/if}")}' method="post" name="searchForm">
                        <span>按时间段查询：</span>
                        <input type="text" class="form-control start_date w110" name="start_date" value="{$start_date}" placeholder="开始时间"/>
                        <span>-</span>
                        <input type="text" class="form-control end_date w110" name="end_date" value="{$end_date}" placeholder="结束时间"/>
                        <input type="submit" name="submit" value="查询" class="btn btn-primary screen-btn" />
                    </form>
                  </div>
                  <div>
                    <form class="form-inline t_r" action='{RC_Uri::url("orders/mh_order_stats/init", "{if $smarty.get.type}&type={$smarty.get.type}{/if}")}' method="post" name="selectForm">
            			<span>按月份查询：</span>
            			<!-- {foreach from=$start_date_arr item=sta key=k} -->
            				<input type="text" name="year_month" value="{$sta}" class="form-control year_month w110"/>
            				 <!-- {if $k < 3} --><span class="">-</span><!-- {/if} -->
            			<!-- {/foreach} -->
        				<input type="hidden" name="is_multi" value="1" />
            			<input type="submit" name="submit" value="查询" class="btn btn-primary screen-btn1" />
        			</form>
    			  </div>
              </header>
              
              <div class="panel-body">
                  <section id="unseen">
                    <ul class="nav nav-tabs">
    					<li {if $smarty.get.type neq 'shipping'}class="active"{/if}>
    					<!-- {if $is_multi eq ''} -->
    					<a href='{RC_Uri::url("orders/mh_order_stats/init","{if $start_date}&start_date={$start_date}{/if}{if $end_date}&end_date={$end_date}{/if}{if $is_multi}{/if}")}' class="data-pjax">{t}订单概况{/t}</a>
    					<!-- {elseif $is_multi eq 1} -->
    					<a href='{RC_Uri::url("orders/mh_order_stats/init","is_multi=1&year_month={$year_month}")}' class="data-pjax">{t}订单概况{/t}</a>
    					<!-- {/if} -->
    					</li>
    					<li {if $smarty.get.type eq 'shipping'}class="active"{/if}>
    					<!-- {if $is_multi eq ''} -->
    					<a href='{RC_Uri::url("orders/mh_order_stats/init","&type=shipping{if $start_date}&start_date={$start_date}{/if}{if $end_date}&end_date={$end_date}{/if}{if $is_multi}&is_multi={$is_multi}{/if}")}' class="data-pjax">配送方式</a>
    					<!-- {elseif $is_multi eq 1} -->
    					<a href='{RC_Uri::url("orders/mh_order_stats/init","&type=shipping{if $year_month}&year_month={$year_month}{/if}&is_multi={$is_multi}")}' class="data-pjax">配送方式</a>
    					<!-- {/if} -->
    					</li>
    				</ul>
    				<form class="form-horizontal">
    					<div class="tab-content">
    						<!--start订单概况  -->
    						{if $smarty.get.type neq 'shipping'}
    						<div class="tab-pane active" id="tab1">
    							<!-- {if $is_multi eq ''} -->
    							<div class="span12">
    								<div id="order_general" data-url='{RC_Uri::url("orders/mh_order_stats/get_order_general","start_date={$start_date}&end_date={$end_date}")}'>
    								    <div class="ajax_loading"><i class="fa fa-spin fa-spinner"></i>加载中...</div>
    								</div>
    							</div>
    							<!-- {elseif $is_multi eq 1} -->
    							<div class="span12 t_c m_t10">
    								<div id="order_status" data-url='{RC_Uri::url("orders/mh_order_stats/get_order_status","is_multi=1&year_month={$year_month}")}'>
    								    <div class="ajax_loading"><i class="fa fa-spin fa-spinner"></i>加载中...</div>
    								</div>
    								<div class="order_number">订单数(单位：个)</div>
    							</div>
    							<!-- {/if} -->
    						</div>
    						{/if}
    						<!--end订单概况  -->
    						
    						<!--start配送方式  -->
    						{if $smarty.get.type eq 'shipping'}
    						<div class="tab-pane active" id="tab2">
    							<!-- {if $is_multi eq ''} -->
    				          	<div class="span12">
    								<div id="ship_status" data-url='{RC_Uri::url("orders/mh_order_stats/get_ship_status","start_date={$start_date}&end_date={$end_date}")}'>
    								    <div class="ajax_loading"><i class="fa fa-spin fa-spinner"></i>加载中...</div>
    								</div>
    							</div>
    							<!-- {elseif $is_multi eq 1} -->
    							<div class="span12 t_c m_t10">
    								<div id="ship_stats" data-url='{RC_Uri::url("orders/mh_order_stats/get_ship_stats","is_multi=1&year_month={$year_month}")}'>
    								    <div class="ajax_loading"><i class="fa fa-spin fa-spinner"></i>加载中...</div>
    								</div>
    								<div class="ship_number">配送个数(单位：个)</div>
    							</div>
    							<!-- {/if} -->
    						</div>
    						{/if}
    						<!--end配送方式  -->
    					</div>
    				</form>
                  </section>
              </div>
          </section>
      </div>
  </div>
<!-- {/block} -->