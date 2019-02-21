<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.order_search.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->

<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
        {if $action_link}
        <a class="btn plus_or_reply data-pjax" href="{$action_link.href}" id="sticky_a" ><i class="fontello-icon-reply"></i> {$action_link.text}</a>
        {/if}
	</h3>
</div>

<div class="row-fluid ">
	<div class="span12">
		<div class="tabbable">
			<form id="form-privilege" class="form-horizontal" name="theForm" action="{$form_action}" method="post" >
				<div class="form-group formSep">
					<label class="control-label">{t domain="quickpay"}订单号：{/t}</label>
					<div class="controls">
						<input class="w350" type="text" name="order_sn" />
					</div>
				</div>
				
<!-- 						<div class="form-group"> -->
<!-- 							<label class="control-label">订单状态：</label> -->
<!-- 							<div class="controls"> -->
<!-- 								<select class="form-control" name="order_status" id="select9" > -->
<!-- 									<option value="-1">请选择……</option> -->
							<!-- {foreach from = $os_list item = list key=key} -->
<!-- 									<option value="{$key}">{$list}</option> -->
							<!-- {/foreach} -->
<!-- 								</select> -->
<!-- 							</div> -->
<!-- 						</div> -->
				
				<div class="control-group formSep">
					<label class="control-label">{t domain="quickpay"}买单优惠类型：{/t}</label>
					<div class="controls" >
						<select class="w350" name="activity_type">
							<option value="0">{t domain="quickpay"}请选择……{/t}</option>
							<!-- {foreach from =$type_list item = list key=key} -->
							<option value="{$key}">{$list}</option>
							<!-- {/foreach} -->
						</select>
					</div>
				</div>
				
				<div class="control-group formSep">
					<label class="control-label">{t domain="quickpay"}买单时间：{/t}</label>
					<div class="controls">
						<div class="controls-split">
							<div class="ecjiaf-fl wright_wleft">
								<input name="start_time" class="date wspan12" type="text" placeholder='{t domain="quickpay"}开始时间{/t}'/>
							</div>
							<div class="ecjiaf-fl p_t5 wmidden">{t domain="quickpay"}至{/t}</div>
							<div class="ecjiaf-fl wright_wleft">
								<input name="end_time" class="date wspan12" type="text" placeholder='{t domain="quickpay"}结束时间{/t}'/>
							</div>
						</div>
					</div>
				</div>
				
				<div class="form-group formSep">
					<label class="control-label">{t domain="quickpay"}购买者姓名：{/t}</label>
					<div class="controls">
						<input class="w350" type="text" name="user_name" />
					</div>
				</div>
				
				<div class="form-group formSep">
					<label class="control-label">{t domain="quickpay"}购买者手机号：{/t}</label>
					<div class="controls">
						<input class="w350" type="text" name="user_mobile" />
					</div>
				</div>
				
				<div class="form-group">
					<div class="controls">
						<button class="btn btn-gebo" type="submit">{t domain="quickpay"}查询{/t}</button>
						<button class="btn" type="reset">{t domain="quickpay"}重置{/t}</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
			
<!-- {/block} -->