<?php defined('IN_ECJIA') or exit('No permission resources.');?> 
<div class="panel panel-body">
	<div class="payrecord-time-base">
		<ul>
			<li class="step-first">
				<div class="{if $refund_info.refund_status eq '2'}step-done{else}step-cur{/if}">
					<div class="step-no">{if $refund_info.refund_status neq '2'}1{/if}</div>
					<div class="m_t5">{t domain="refund"}商家提交退款申请{/t}<br><font class="ecjiafc-blue">{if $payrecord_info.add_time}{$payrecord_info.add_time}{/if}</font></div>	
				</div>
			</li>

			<li class="step-last">
				<div class="{if $refund_info.refund_status eq '2'}step-cur{/if}">
					<div class="step-no">2</div>
					<div class="m_t5">{t domain="refund"}退款成功{/t}<br><font class="ecjiafc-blue">{if $payrecord_info.action_back_time}{$payrecord_info.action_back_time}{/if}</font></div>
				</div>
			</li>
		</ul>
	</div>
</div>
