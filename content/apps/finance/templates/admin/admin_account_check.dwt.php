<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.account_check.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a class="btn plus_or_reply data-pjax" href="{$action_link.href}"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>

<div class="row-fluid">
	<div class="span12">
		<div class="accordion-group">
			<div class="accordion-heading">
				<div class="accordion-toggle acc-in" data-toggle="collapse" data-target="#telescopic1">
					<strong>{lang key='user::user_account.user_information'}</strong>
				</div>
			</div>
			<div class="accordion-body in collapse" id="telescopic1">
				<table class="table table-oddtd m_b0">
					<tbody class="first-td-no-leftbd">
						<tr>
							<td><div align="right"><strong>{lang key='user::user_account.label_user_id'}</strong></div></td>
							<td>
								<!-- {if $user_name} -->
								{$user_name}
								<!-- {else} -->
								{lang key='user::user_account.anonymous_member'}
								<!-- {/if} -->
							</td>
							<td><div align="right"><strong>{lang key='user::user_account.label_surplus_amount'}</strong></div></td>
							<td>￥{$surplus.amount}{lang key='user::user_account.yuan'}</td>				
						</tr>
						<tr>
							<td><div align="right"><strong>{lang key='user::user_account.label_process_type'}</strong></div></td>
							<td>
								<!-- {if $surplus.process_type eq 0} -->
								<b class="ecjiafc-f00">{lang key='user::user_account.deposit'}</b>
								<!-- {else} -->
								{lang key='user::user_account.withdraw'}
								<!-- {/if} -->
							</td>
							<td><div align="right"><strong>{lang key='user::user_account.label_pay_mothed'}</strong></div></td>
							<td>
								<!-- {if $surplus.payment} -->
								{$surplus.payment}
								<!-- {/if} -->
							</td>
						</tr>
						<!-- {if $is_check} -->
						<tr>
							<td><div align="right"><strong>{lang key='user::user_account.label_surplus_desc'}</strong></div></td>
							<td colspan="3">{$surplus.user_note}</td>
						</tr>
						<!-- {/if} -->
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<div class="row-fluid">
	<div class="span12">
	<div class="accordion-group">
			<div class="accordion-heading">
				<div class="accordion-toggle acc-in" data-toggle="collapse" data-target="#telescopic2">
					<strong>{if $is_check}{lang key='user::user_account.check'}{else}{lang key='user::user_account.edit_remark'}{/if}</strong>
				</div>
			</div>
			<div class="accordion-body in collapse" id="telescopic2">
				<form class="form-horizontal" method="post" action="{if $is_check}{$check_action}{else}{$form_action}{/if}" name="theForm">
					<table class="table table-oddtd m_b0">
						<tbody class="first-td-no-leftbd">
							<!-- {if !$is_check} -->
							<tr>
								<td><div align="right"><strong>{lang key='user::user_account.label_surplus_desc'}</strong></div></td>
								<td colspan="3">
									<textarea class="span10" name="user_note" cols="55" rows="6">{$surplus.user_note}</textarea>
								</td>
							</tr>
							<!-- {/if} -->
							<tr>
								<td><div align="right"><strong>{lang key='user::user_account.label_surplus_notic'}</strong></div></td>
								<td colspan="3">
									<textarea class="span10" name="admin_note" cols="55" rows="6">{$surplus.admin_note}</textarea>
								</td>
							</tr>
							<tr>
								<td><div align="right"><strong>{lang key='user::user_account.label_status'}</strong></div></td>
								<td>
									<input type="radio" name="is_paid" value="0" {if $surplus.is_paid eq 0}checked="true"{/if} {if !$is_check}disabled="true"{/if} /><span>{lang key='user::user_account.unconfirm'}</span>
									<input type="radio" name="is_paid" value="1" {if $surplus.is_paid eq 1}checked="true"{/if} {if !$is_check}disabled="true"{/if} /><span>{lang key='user::user_account.confirm'}</span>
									<input type="radio" name="is_paid" value="2" {if $surplus.is_paid eq 2}checked="true"{/if} {if !$is_check}disabled="true"{/if} /><span>{lang key='user::user_account.cancel'}</span>
								</td>
							</tr>
							<tr>
								<td><div align="right"></div></td>
								<td>
								{if $id}
									<input type="hidden" name="id" value="{$id}" />
									<input type="hidden" name="user_name" value="{$user_name}" />
									<input class="btn btn-gebo" type="submit" value="{lang key='user::user_account.submit_update'}" />
								{else}
									<input class="btn btn-gebo" type="submit" value="{lang key='system::system.button_submit'}" />
								{/if}
								
								</td>
							</tr>
						</tbody>
					</table>
				</form>	
			</div>
		</div>
	</div>
</div>

<!-- {/block} -->