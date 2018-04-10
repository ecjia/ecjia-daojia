<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.merchant.fund.init();
</script>
<!-- {/block} -->
<!-- {block name="home-content"} -->
{if $replying}
<div class="alert alert-danger">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-times"></i></button>
	<strong>注：</strong>提现订单还未审核的情况下，不能再申请提现，只有审核通过，才可以进行第二次提现。
</div>
{/if}

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
			<div class="panel-body">
				<div class="form">
					<form class="cmxform form-horizontal tasi-form" name="fundForm" method="post" action="{$form_action}">
						<div class="form-group">
							<label class="control-label col-lg-2">可用金额：</label>
							<div class="col-lg-6 l_h30">
								<span class="price">{$data.formated_amount_available}</span>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-lg-2">提现金额：</label>
							<div class="col-lg-6">
								<input class="form-control" type="text" name="money" />
								<span class="help-block">提现金额必须大于0，但是不得大于您的【可用金额】</span>
							</div>
							<span class="input-must">*</span>
							<a class="set_value no-underline" href="javascript:;" data-money="{$data.amount_available}">全部提现</a>
						</div>

						<div class="form-group">
							<label class="control-label col-lg-2">提现银行卡：</label>
							{if $bank_info && $bank_info.bank_account_number neq ''}
								<div class="col-lg-6 bank_account">
									<div class="bank_name">{$bank_info.bank_name}</div>
									<div class="bank_account_number">{$bank_info.bank_account_number}</div>
									<a class="change_bank" href='{url path="merchant/mh_franchisee/receipt_edit"}' target="__blank">更改</a>
								</div>
							{else}
								<div class="col-lg-6 add_bank_card"><a class="btn btn-primary" href='{url path="merchant/mh_franchisee/receipt_edit"}' target="__blank">添加银行卡</a></div>		
							{/if}
						</div>
						
						<div class="form-group">
							<label class="control-label col-lg-2">备注：</label>
							<div class="col-lg-6">
								<textarea class="form-control" rows="3" name="desc" placeholder="请输入备注内容"></textarea>
								<span class="help-block">输入提现内容，此项为必填项</span>
							</div>
							<span class="input-must">*</span>
						</div>
						
						<div class="form-group">
							<div class="col-lg-offset-2 col-lg-6">
								<input type="submit" value="提交" class="btn btn-info" {if $replying}disabled{/if} />
							</div>
						</div>
					</form>
				</div>
			</div>
		</section>
	</div>
</div>
<!-- {/block} -->