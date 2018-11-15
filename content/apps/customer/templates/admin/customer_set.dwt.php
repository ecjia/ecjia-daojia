<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
ecjia.admin.customer_set.init();
</script>
<style>
	 .fields{
	       padding-top:0px;
	       width:83px;
	       float: left;
	       text-align: right;
	    }
	 .func{
	       padding-top:0px;
	       float: left;
	       text-align: right;
	    }
    .shi{
		width:36px;
    }
    .quanbu{
		width:100px;
    }
	.wei{
		width:118px;
	    }
</style>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div class="alert alert-info">	
	提示：开启客户池功能后，根据系统设置的回收范围，以及回收周期，超过回收周期，还没有联系的客户，系统将自动回收。回收后的客户，将进入公共客户池，人人都可以领用该客户。
</div>
<div>
	<h3 class="heading">
		{t}客户池设置{/t}
	</h3>
</div>

<div class="row-fluid edit-page priv_list">
	<div class="span12">
		<form method="post" class="form-horizontal" action="{$form_action}" name="theForm"  >
			<fieldset>
				<div class="control-group formSep">
					<label class="control-label">{t}是否开启客户池功能：{/t}</label>
					<div class="controls">
						<label for="shi" class="func shi">
							<input type="radio" id="shi" name="customer_pool_isopen" value="1" {if $customer_pool_isopen == 1 } checked="true" {/if}/>{t}是{/t}
						</label>
						<label for="fou" class="func" style="width:60px;">
							<input type="radio" id="fou" name="customer_pool_isopen" value="0"{if $customer_pool_isopen == 0} checked="true" {/if}/>{t}否{/t}   
						</label>
					</div>
				</div>
				<div class="control-group formSep">
					<label class="control-label">{t}客户回收范围：{/t}</label>
					<div class="controls system">
						<!-- {foreach from=$customer_type_list  item=list} -->
						<div class="choose">
							<label for="quanbu{$list.state_id}">
								<input type="checkbox" id="quanbu{$list.state_id}" name="customer_pool_range[]" value="{$list.state_id}" {if $list.checked} checked="true" {/if}/>{t}{$list.state_name}{/t}
							</label>
						</div>
						<!-- {/foreach} -->
					</div>
				</div>
				<div class="control-group formSep">
					<label class="control-label">{t}回收周期：{/t}</label>
					<div class="controls">
						<input type="text" name='customer_pool_period' value="{$customer_pool_period}" class="w350" />&nbsp;&nbsp;<span>天</span> 
					</div>
				</div>
				<div class="control-group formSep">
					<label class="control-label">{t}最大限制：{/t}</label>
					<div class="controls">
						<input type="text" name='customer_pool_gain_max' value="{$customer_pool_gain_max}" class="w350" />&nbsp;&nbsp;<span>个</span>
						<span class="help-block">指可领取客户数的最大限制</span> 
					</div>
				</div>
				<div class="control-group formSep">
					<label class="control-label">{t}每日限制：{/t}</label>
					<div class="controls">
						<input type="text" name='customer_pool_gain_max_day' value="{$customer_pool_gain_max_day}" class="w350" />&nbsp;&nbsp;<span>个</span>
						<span class="help-block">指每日可领取客户数的最大限制</span> 
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<button class="btn btn-gebo" id="set1" type="submit">{t}确定{/t}</button>&nbsp;&nbsp;&nbsp;
						<button class="btn" type="reset">{t}重置{/t}</button>
					</div>
				</div>
				<div>
					<h3 class="heading">
						{t}客户验证设置{/t}
					</h3>
				</div>
				<div class="control-group formSep">
					<label class="control-label">{t}验证字段是否开启：{/t}</label>
					<div class="controls chk_radio">
						<!-- {foreach from=$exists_fields  item=list} -->
						<div class="choose">
							<label for="bitian{$list.exists_fields_id}" class="func" style="padding-right: 15px;">
								<input type="checkbox" id="bitian{$list.exists_fields_id}" name="exists_fields_name[]" value="{$list.exists_fields_id}" {if $list.is_open eq '1'} checked="true" {/if}/>{t}{$list.field_name}{/t}
							</label>
						</div>
						<!-- {/foreach} -->
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<button class="btn btn-gebo" id="set2" type="submit">{t}确定{/t}</button>&nbsp;&nbsp;&nbsp;
						<button class="btn" type="reset">{t}重置{/t}</button>
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</div>

<!-- {/block} -->