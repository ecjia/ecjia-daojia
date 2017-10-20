<?php defined('IN_ECJIA') or exit('No permission resources.');?> 

<div class="quickpay-time-base m_b20">
	<ul class="">
		<li class="step-first">
			<div class="{if $step lt '2'}step-cur{else}step-done{/if}">
				<div class="step-no">{if $step lt '2'}1{/if}</div>
				<div class="m_t5">提交订单</div>
				<div class="m_t5 ecjiafc-blue">{$order_info.add_time}</div>
			</div>
		</li>
		<li>
			<div class="{if $step eq '2'}step-cur{elseif $step gt '2'}step-done{/if}">
				<div class="step-no">{if $step lt '3'}2{/if}</div>
				<div class="m_t5">{if $step gt '2' || $step eq '2'}已付款{else}未付款{/if}</div>
				<div class="m_t5 ecjiafc-blue">{$order_info.pay_time}</div>
			</div>
		</li>
		<li class="step-last">
			<div class="{if $step eq '3'}step-cur{elseif $step gt '3'}step-done{/if}">
				<div class="step-no">{if $step lt '4'}3{/if}</div>
				<div class="m_t5">{if $step eq '3'}已核销{else}未核销{/if}</div>
				<div class="m_t5 ecjiafc-blue">{$order_info.verification_time}</div>
			</div>
		</li>
	</ul>
</div>
