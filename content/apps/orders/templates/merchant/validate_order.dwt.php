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
				<h4 class="modal-title">{t domain="orders"}基本信息{/t}</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" method="post" name="validateForm" action='{url path="orders/mh_validate_order/validate_to_ship"}'>
					<div class="form-group">
						<label class="control-label col-lg-3">{t domain="orders"}验证码：{/t}</label>
						<div class="col-lg-3 controls p_top pickup_code">
							
						</div>
						 <div class="btn-new">{t domain="orders"}未验单{/t}</div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-3">{t domain="orders"}姓名：{/t}</label>
						<div class="col-lg-6 controls p_top user_name">
							
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-3">{t domain="orders"}手机号码：{/t}</label>
						<div class="col-lg-6 controls p_top mobile">
							
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-3">{t domain="orders"}支付金额：{/t}</label>
						<div class="col-lg-6 controls p_top total_fee">
							
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-3">{t domain="orders"}支付方式：{/t}</label>
						<div class="col-lg-6 controls p_top pay_name">
							
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-3">{t domain="orders"}订单编号：{/t}</label>
						<div class="col-lg-6 controls p_top order_sn">
							
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-3">{t domain="orders"}下单时间：{/t}</label>
						<div class="col-lg-6 controls p_top add_time">
							
						</div>
					</div>
					<div class="form-group">
                     <div class="col-lg-offset-2-new col-lg-3">
                        <button class="btn btn-info" type="submit">{t domain="orders"}确认验证{/t}</button>
                        <input type="hidden" name="order_id" value="" />
                     </div>
                     <a class="btn btn-info-new" href='' target='_blank'><span style="color:#737373;">{t domain="orders"}查看详情{/t}</span></a>
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
		<a href="{$action_link.href}" class="btn btn-primary nopjax">
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
                     <label for="firstname" class="control-label col-lg-2">{t domain="orders"}验证码：{/t}</label>
                     <div class="col-lg-3 controls">
                          <input class="form-control" name="pickup_code" type="text" value=""/>
                          <span class="help-block">{t domain="orders"}请输入用户手机收到的提货验证码{/t}</span>
                     </div>
                     <span class="input-must">*</span>
                </div>          
				<div class="form-group">
                     <div class="col-lg-offset-2 col-lg-3">
                        <button class="btn btn-info" type="submit">{t domain="orders"}验单{/t}</button>
                     </div>
                </div>
			</fieldset>
		</form>
	</div>
</div>
<!-- {/block} -->