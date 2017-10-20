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
					<label class="control-label">订单号：</label>
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
					<label class="control-label">买单优惠类型：</label>
					<div class="controls" >
						<select class="w350" name="activity_type">
							<option value="0">请选择……</option>
							<!-- {foreach from =$type_list item = list key=key} -->
							<option value="{$key}">{$list}</option>
							<!-- {/foreach} -->
						</select>
					</div>
				</div>
				
				<div class="control-group formSep">
					<label class="control-label">买单时间：</label>
					<div class="controls">
						<div class="controls-split">
							<div class="ecjiaf-fl wright_wleft">
								<input name="start_time" class="date wspan12" type="text" placeholder="{lang key='orders::order.start_time'}"/>
							</div>
							<div class="ecjiaf-fl p_t5 wmidden">{lang key='orders::order.to'}</div>
							<div class="ecjiaf-fl wright_wleft">
								<input name="end_time" class="date wspan12" type="text" placeholder="{lang key='orders::order.end_time'}"/>
							</div>
						</div>
					</div>
				</div>
				
				<div class="form-group formSep">
					<label class="control-label">购买者姓名：</label>
					<div class="controls">
						<input class="w350" type="text" name="user_name" />
					</div>
				</div>
				
				<div class="form-group formSep">
					<label class="control-label">购买者手机号：</label>
					<div class="controls">
						<input class="w350" type="text" name="user_mobile" />
					</div>
				</div>
				
				<div class="form-group">
					<div class="controls">
						<button class="btn btn-gebo" type="submit">查询</button>
						<button class="btn" type="reset">重置</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
			
<!-- {/block} -->