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
    	<strong>{lang key='orders::order.notice_order_sn'}</strong>
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-times" data-original-title="" title=""></i></button>
    	</div>
	<div class="span12 ">
		<form class="form-horizontal" id="form-privilege" name="theForm" method="post" action="{$form_action}" data-pjax-url='{url path="orders/merchant/merge"}'>
			<fieldset>
				<div class="control-group formSep">	
					<div class="form-inline form-group">
					   <label class="control-label col-lg-2">{lang key='orders::order.to_order_sn'}</label>
					   <input class="form-control " name="to_order_sn" type="text" id="to_order_sn" class="f_l m_r5"/>
					   <div class="form-group order-query">
    					   <div class="col-lg-11">
        					   <select class="panel-body w250" name="to_list" id="to_list" >
        					       <option value="">{lang key='system::system.select_please'}</option>
                				   <!-- {foreach from=$order_list item=order} -->
            						    <option value="{$order.order_sn}">{$order.order_sn} {if $order.user_name}[{$order.user_name}]{else}[匿名]{/if}</option>
                				   <!-- {/foreach} -->
        					   </select>
    					   </div>
					   <span class="input-must">{lang key='system::system.require_field'}</span>
					   </div>
					   <span class="help-block" {if $help_open}style="display:block" {else} style="display:none" {/if} id="noticeOrderSn">{lang key='orders::order.notice_order_sn'}</span>
			       </div>
			   </div>
			   
				<div class="control-group formSep">
				    <div class="form-inline form-group">
    					<label class="control-label col-lg-2">{lang key='orders::order.from_order_sn'}</label>
						<input class="form-control" name="from_order_sn" type="text" id="from_order_sn" class="f_l m_r5"/>
						<div class="form-group order-query">
    					   <div class="col-lg-11">
        						<select class="panel-body w250" name="from_list" id="from_list" >
        							<option value="">{lang key='system::system.select_please'}</option>
        							<!-- {foreach from=$order_list item=order} -->
        							     <option value="{$order.order_sn}">{$order.order_sn} {if $order.user_name}[{$order.user_name}]{else}[匿名]{/if}</option>
        							<!-- {/foreach} -->
        						</select>
							</div>
							<span class="input-must">{lang key='system::system.require_field'}</span>
						</div>
    				</div>	
				</div>
				<div class="control-group formSep">
    				<div class="form-inline form-group">
    				   <label class="col-lg-2"></label>
				       <button class="btn btn-info" type="submit">{lang key='orders::order.merge'}</button>
    				</div>
				</div>
			</fieldset>
		</form>
	</div>
</div>
<!-- {/block} -->