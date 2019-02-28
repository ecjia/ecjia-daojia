<?php defined('IN_ECJIA') or exit('No permission resources.');?> 
<div class="panel panel-body">
	<div class="return-time-base">
		<ul>
			<li class="step-first">
				<div class="{if $refund_info.status eq '0'}step-cur{else}step-done{/if}">
					<div class="step-no">{if $refund_info.status eq '0'}1{/if}</div>
					<div class="m_t5">{t domain="refund"}买家申请退货退款{/t}<br><font class="ecjiafc-blue">{if $refund_info.add_time}{$refund_info.add_time}{/if}</font></div>	
				</div>
			</li>
			
			<li>
				<div class="{if $refund_info.return_status gt '1'}step-done{elseif $refund_info.status gt '0'}step-cur{/if}">
					{if $refund_info.status eq '11'}
						<div class="step-failed">{if $refund_info.return_status eq '1'}2{/if}</div>
					{else}
						<div class="step-no">{if $refund_info.return_status eq '1'}2{/if}</div>
					{/if}
					<div class="m_t5">{t domain="refund"}商家处理退款申请{/t}<br><font class="ecjiafc-blue">{if $action_mer_msg_return.log_time}{$action_mer_msg_return.log_time}{/if}</font></div>
				</div>
			</li>
			
			<li>
				<div class="{if $refund_info.return_status gt '2'}step-done{elseif $refund_info.return_status eq '2'}step-cur{/if}">
					<div class="step-no">{if $refund_info.return_status lt '3'}3{/if}</div>
					<div class="m_t5">{t domain="refund"}买家退货给商家{/t}<br><font class="ecjiafc-blue">{if $refund_info.return_time}{$refund_info.return_time}{/if}</font></div>
				</div>
			</li>
			
			<li>
				<div class="{if $refund_info.refund_status eq '2'}step-done{elseif $refund_info.return_status gt '2'}step-cur{/if}">
				    {if $refund_info.return_status eq '11'}
				    	<div class="step-failed">{if $refund_info.refund_status neq '2'}4{/if}</div>
				    {else}
				    	<div class="step-no">{if $refund_info.refund_status neq '2'}4{/if}</div>
				    {/if}
					<div class="m_t5">{t domain="refund"}商家确认收货{/t}<br><font class="ecjiafc-blue">{if $action_mer_msg_confirm.log_time}{$action_mer_msg_confirm.log_time}{/if}</font></div>
				</div>
			</li>

			<li class="step-last">
				<div class="{if $refund_info.refund_status eq '2'}step-cur{/if}">
					<div class="step-no">5</div>
					<div class="m_t5">{t domain="refund"}平台审核、退款完成{/t}<br><font class="ecjiafc-blue">{if $refund_info.refund_time}{$refund_info.refund_time}{/if}</font></div>
				</div>
			</li>
		</ul>
	</div>
</div>


