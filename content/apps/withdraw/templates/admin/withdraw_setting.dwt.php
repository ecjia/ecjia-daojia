<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="admin_shop_config.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.admin_config.init();
</script>
<!-- {/block} -->

<!-- {block name="admin_config_form"} -->
<div class="row-fluid priv_list">
	<form method="post" class="form-horizontal" action="{$form_action}" name="theForm">
		<fieldset>
			<div>
				<h3 class="heading">
					<!-- {if $ur_here}{$ur_here}{/if} -->
				</h3>
			</div>

			<div class="control-group formSep">
				<label class="control-label">{t domain="withdraw"}提现手续费：{/t}</label>
				<div class="controls">
					<input type="text" class="span5" name="withdraw_fee" value="{$withdraw_fee}" /> %
					<span class="help-block">{t domain="withdraw"}手续费按用户提现金额的百分比进行收取。如提现1000，手续费10%，则提现时，只能提取900。{/t}</span>
				</div>
			</div>

			<div class="control-group formSep">
				<label class="control-label">{t domain="withdraw"}最低提现金额：{/t}</label>
				<div class="controls">
					<input type="text" class="span5" name="withdraw_min_amount" value="{$withdraw_min_amount}" /> 元
					<span class="help-block">{t domain="withdraw"}当用户提现金时，最低提现金额不能小于此值。{/t}</span>
				</div>
			</div>

			<!-- {if $data} -->
			<div class="control-group formSep">
				<label class="control-label">{t domain="withdraw"}提现支持银行：{/t}</label>
				<div class="controls">
					<!-- {foreach from=$data item=list} -->
					<div class="choose">
						<label>
							<input class="checkbox" name="bank_en_short[]" {if $list.checked}checked{/if} type="checkbox" value="{$list.bank_en_short}">
							<img src="{$list.bank_icon}" width="25" height="25" />
							{$list.bank_name}
						</label>
					</div>
					<!-- {/foreach} -->
					<div class="clear_both"></div>
					<div class="help-block m_t10">{t domain="withdraw"}可多选，设置用户端提现时可使用的银行卡提现方式。{/t}</div>
				</div>
			</div>
			<!-- {/if} -->

			<div class="control-group">
				<div class="controls">
					<input type="submit" value='{t domain="withdraw"}确定{/t}' class="btn btn-gebo" />
				</div>
			</div>
		</fieldset>
	</form>
</div>
<!-- {/block} -->