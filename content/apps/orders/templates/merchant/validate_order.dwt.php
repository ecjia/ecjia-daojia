<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.merchant.merchant_validate_order.init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->

<div class="modal fade" id="operate">
	<div class="modal-dialog" style="margin:120px auto">
    	<div class="modal-content">
			<div class="modal-header">
				<button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
				<h4 class="modal-title">基本信息</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" method="post" name="validateForm" action='{url path="orders/mh_validate_order/validate_to_ship"}'>
					<div class="form-group">
						<label class="control-label col-lg-3">验证码：</label>
						<div class="col-lg-3 controls p_top pickup_code">
							
						</div>
						 <div class="btn-new">未验单</div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-3">姓名：</label>
						<div class="col-lg-6 controls p_top user_name">
							
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-3">手机号码：</label>
						<div class="col-lg-6 controls p_top mobile">
							
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-3">支付金额：</label>
						<div class="col-lg-6 controls p_top total_fee">
							
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-3">支付方式：</label>
						<div class="col-lg-6 controls p_top pay_name">
							
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-3">订单编号：</label>
						<div class="col-lg-6 controls p_top order_sn">
							
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-3">下单时间：</label>
						<div class="col-lg-6 controls p_top add_time">
							
						</div>
					</div>
					<div class="form-group">
                     <div class="col-lg-offset-2-new col-lg-3">
                        <button class="btn btn-info" type="submit">确认验证</button>
                        <input type="hidden" name="order_id" value="" />
                     </div>
                     <a class="btn btn-info-new" href='' target='_blank'><span style="color:#737373;">查看详情</span></a>
                </div>
				</form>
           </div>
		</div>
	</div>
</div>

<div class="page-header">
	<div class="pull-left">
		<h2><!-- {if $ur_here}{$ur_here}{/if} --></h2>
  	</div>
  	<div class="pull-right">
  		{if $action_link}
		<a href="{$action_link.href}" class="btn btn-primary data-pjax">
			<i class="fa fa-reply"></i> {$action_link.text}
		</a>
		{/if}
  	</div>
  	<div class="clearfix"></div>
</div>

<div class="row-fluid panel panel-body">
	<div class="span12 ">
		<form class="form-horizontal" id="form-privilege" name="theForm" method="post" action="{$form_action}" data-pjax-url='{url path="orders/mh_validate_order/validate"}'>
			<fieldset>
				<div class="form-group ">
                     <label for="firstname" class="control-label col-lg-2">验证码：</label>
                     <div class="col-lg-3 controls">
                          <input class="form-control" name="pickup_code" type="text" value=""/>
                          <span class="help-block">请输入用户手机收到的提货验证码</span>
                     </div>
                     <span class="input-must">{lang key='system::system.require_field'}</span>
                </div>          
				<div class="form-group">
                     <div class="col-lg-offset-2 col-lg-3">
                        <button class="btn btn-info" type="submit">验单</button>
                     </div>
                </div>
			</fieldset>
		</form>
	</div>
</div>
<!-- {/block} -->