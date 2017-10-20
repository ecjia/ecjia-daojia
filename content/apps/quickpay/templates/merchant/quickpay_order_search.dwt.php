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
							<label class="control-label col-lg-2">订单号：</label>
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
							<label class="control-label col-lg-2">买单优惠类型：</label>
							<div class="col-lg-6">
								<select class="form-control" name="activity_type" id="select9" >
									<option value="0">请选择……</option>
									<!-- {foreach from =$type_list item = list key=key} -->
									<option value="{$key}">{$list}</option>
									<!-- {/foreach} -->
								</select>
							</div>
						</div>
						
						<div class="form-group form-inline order-query">
							<label class="control-label col-lg-2">买单时间：</label>
							<div class="col-lg-10"> 
								<div class="form-group ">
									<input name="start_time" class="date form-control w-form-control" type="text" placeholder="{t}开始时间{/t}"/>
								</div>
								<div class="form-group">至</div>
								<div class="form-group">
									<input name="end_time" class="date form-control w-form-control" type="text" placeholder="{t}结束时间{/t}"/>
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-lg-2">购买者姓名：</label>
							<div class="col-lg-6">
								<input class="form-control" type="text" name="user_name" />
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-lg-2">购买者手机号：</label>
							<div class="col-lg-6">
								<input class="form-control" type="text" name="user_mobile" />
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-lg-2"></label>
							<div class="col-lg-6">
								<button class="btn btn-info" type="submit">查询</button>
								<button class="btn btn-info" type="reset">重置</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
					
<!-- {/block} -->