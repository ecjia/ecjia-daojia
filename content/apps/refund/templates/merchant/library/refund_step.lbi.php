<?php defined('IN_ECJIA') or exit('No permission resources.');?> 
<div class="panel panel-body">
	<div class="refund-time-base">
		<ul>
			<li class="step-first">
				<div class="{if $refund_info.status eq '0'}step-cur{else}step-done{/if}">
					<div class="step-no">{if $refund_info.status eq '0'}1{/if}</div>
					<div class="m_t5">买家申请退款<br><font class="ecjiafc-blue">{if $refund_info.add_time}{$refund_info.add_time}{/if}</font></div>	
				</div>
			</li>
			
			<li>
				<div class="{if $refund_info.refund_status eq '1' or $refund_info.status eq '11'}step-cur{elseif $refund_info.status gt '0'}step-done{/if}">
					{if $refund_info.status eq '11'}
						<div class="step-failed">{if $refund_info.refund_status neq '2'}2{/if}</div>
					{else}
						<div class="step-no">{if $refund_info.refund_status neq '2'}2{/if}</div>
					{/if}
					<div class="m_t5">商家处理退款申请<br><font class="ecjiafc-blue">{if $action_mer_msg.log_time}{$action_mer_msg.log_time}{/if}</font></div>
				</div>
			</li>

			<li class="step-last">
				<div class="{if $refund_info.refund_status eq '2'}step-cur{/if}">
					<div class="step-no">3</div>
					<div class="m_t5">平台审核、退款完成<br><font class="ecjiafc-blue">{if $refund_info.refund_time}{$refund_info.refund_time}{/if}</font></div>
				</div>
			</li>
		</ul>
	</div>
</div>
