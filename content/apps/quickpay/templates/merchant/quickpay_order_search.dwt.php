<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.merchant.order_search.init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->

<div class="row">
    <div class="col-lg-12">
        <h2 class="page-header">
        <!-- {if $ur_here}{$ur_here}{/if} -->
        {if $action_link}
        <a class="btn btn-primary data-pjax" href="{$action_link.href}" id="sticky_a" style="float:right;margin-top:-3px;"><i class="fa fa-reply"></i> {$action_link.text}</a>
        {/if}
        </h2>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="tab-content">
            <div class="panel">
                <div class="panel-body">
					<form id="form-privilege" class="form-horizontal panel" name="theForm" action="{$form_action}" method="post" >
						<div class="form-group">
							<label class="control-label col-lg-2">{t domain="quickpay"}订单号：{/t}</label>
							<div class="col-lg-6">
								<input class="form-control" type="text" name="order_sn" />
							</div>
						</div>
						
<!-- 						<div class="form-group"> -->
<!-- 							<label class="control-label col-lg-2">订单状态：</label> -->
<!-- 							<div class="col-lg-6"> -->
<!-- 								<select class="form-control" name="order_status" id="select9" > -->
<!-- 									<option value="-1">请选择……</option> -->
									<!-- {foreach from = $os_list item = list key=key} -->
<!-- 									<option value="{$key}">{$list}</option> -->
									<!-- {/foreach} -->
<!-- 								</select> -->
<!-- 							</div> -->
<!-- 						</div> -->
						
						<div class="form-group">
							<label class="control-label col-lg-2">{t domain="quickpay"}买单优惠类型：{/t}</label>
							<div class="col-lg-6">
								<select class="form-control" name="activity_type" id="select9" >
									<option value="0">{t domain="quickpay"}请选择……{/t}</option>
									<!-- {foreach from =$type_list item = list key=key} -->
									<option value="{$key}">{$list}</option>
									<!-- {/foreach} -->
								</select>
							</div>
						</div>
						
						<div class="form-group form-inline order-query">
							<label class="control-label col-lg-2">{t domain="quickpay"}买单时间：{/t}</label>
							<div class="col-lg-10"> 
								<div class="form-group ">
									<input name="start_time" class="date form-control w-form-control" type="text" placeholder='{t domain="quickpay"}开始时间{/t}'/>
								</div>
								<div class="form-group">{t domain="quickpay"}至{/t}</div>
								<div class="form-group">
									<input name="end_time" class="date form-control w-form-control" type="text" placeholder='{t domain="quickpay"}结束时间{/t}'/>
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-lg-2">{t domain="quickpay"}购买者姓名：{/t}</label>
							<div class="col-lg-6">
								<input class="form-control" type="text" name="user_name" />
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-lg-2">{t domain="quickpay"}购买者手机号：{/t}</label>
							<div class="col-lg-6">
								<input class="form-control" type="text" name="user_mobile" />
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-lg-2"></label>
							<div class="col-lg-6">
								<button class="btn btn-info" type="submit">{t domain="quickpay"}查询{/t}</button>
								<button class="btn btn-info" type="reset">{t domain="quickpay"}重置{/t}</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
					
<!-- {/block} -->