<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.merchant.order_merge.init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->
<div class="page-header">
	<div class="pull-left">
		<h2><!-- {if $ur_here}{$ur_here}{/if} --></h2>
  	</div>
  	<div class="clearfix"></div>
</div>

<div class="row-fluid panel panel-body">
    <div class="alert alert-info">	
    	<strong>当两个订单不一致时，合并后的订单信息（如：支付方式、配送方式、包装、贺卡、红包等）以主订单为准。</strong>
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-times" data-original-title="" title=""></i></button>
    	</div>
	<div class="span12 ">
		<form class="form-horizontal" id="form-privilege" name="theForm" method="post" action="{$form_action}" data-pjax-url='{url path="orders/merchant/merge"}'>
			<fieldset>
				<div class="control-group formSep">	
					<div class="form-inline form-group">
					   <label class="control-label col-lg-2">主订单：</label>
					   <input class="form-control " name="to_order_sn" type="text" id="to_order_sn" class="f_l m_r5"/>
					   <div class="form-group order-query">
    					   <div class="col-lg-11">
        					   <select class="panel-body w250" name="to_list" id="to_list" >
        					       <option value="">请选择...</option>
                				   <!-- {foreach from=$order_list item=order} -->
            						    <option value="{$order.order_sn}">{$order.order_sn} {if $order.user_name}[{$order.user_name}]{else}[匿名]{/if}</option>
                				   <!-- {/foreach} -->
        					   </select>
    					   </div>
					   <span class="input-must">*</span>
					   </div>
					   <span class="help-block" {if $help_open}style="display:block" {else} style="display:none" {/if} id="noticeOrderSn">当两个订单不一致时，合并后的订单信息（如：支付方式、配送方式、包装、贺卡、红包等）以主订单为准。</span>
			       </div>
			   </div>
			   
				<div class="control-group formSep">
				    <div class="form-inline form-group">
    					<label class="control-label col-lg-2">从订单：</label>
						<input class="form-control" name="from_order_sn" type="text" id="from_order_sn" class="f_l m_r5"/>
						<div class="form-group order-query">
    					   <div class="col-lg-11">
        						<select class="panel-body w250" name="from_list" id="from_list" >
        							<option value="">请选择...</option>
        							<!-- {foreach from=$order_list item=order} -->
        							     <option value="{$order.order_sn}">{$order.order_sn} {if $order.user_name}[{$order.user_name}]{else}[匿名]{/if}</option>
        							<!-- {/foreach} -->
        						</select>
							</div>
							<span class="input-must">*</span>
						</div>
    				</div>	
				</div>
				<div class="control-group formSep">
    				<div class="form-inline form-group">
    				   <label class="col-lg-2"></label>
				       <button class="btn btn-info" type="submit">合并</button>
    				</div>
				</div>
			</fieldset>
		</form>
	</div>
</div>
<!-- {/block} -->