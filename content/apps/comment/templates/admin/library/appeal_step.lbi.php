<?php defined('IN_ECJIA') or exit('No permission resources.');?> 
<div class="panel panel-body">
	<div class="appeal-time-base m_b20">
		<ul>
			<li class="step-first">
				<div class="{if $appeal_info.check_status eq '-1'}step-cur{else}step-done{/if} m_b20  p_t5">
					<div class="step-no">{if $appeal_info.check_status lt '1'}1{/if}</div>
					<div class="m_t5">提交申诉<br>{$appeal_info.appeal_time}</div>
					
				</div>
			</li>
			
			<li class="under-review">
				<div class="{if $appeal_info.check_status eq '1'}step-cur{elseif $appeal_info.check_status gt '1'}step-done{/if} m_b20  p_t5">
					<div class="step-no m_b5">2</div>
					<div>审核中</div>
					{$appeal_info.appeal_time}
				</div>
			</li>

			<li class="step-last">
				{if $appeal_info.check_status eq '2'}
				<div class="{if $appeal_info.check_status eq '2'}step-cur{/if} m_b20  p_t5" >
					<div class="step-no m_b5">{if $appeal_info.check_status lt '3'}3{/if}</div>
					<div>申诉成功<br>{$appeal_info.process_time}</div>
				</div>
				{elseif $appeal_info.check_status eq '3' }
				<div class="{if $appeal_info.check_status eq '3'}step-cur{/if} m_b20  p_t5">
					<div class="step-failed m_b5">{if $appeal_info.check_status lt '4'}3{/if}</div>
					<div>申诉失败<br>{$appeal_info.process_time}</div>
				</div>
				{else}
				<div class="{if $appeal_info.check_status eq '2'}step-cur{/if} m_b20  p_t5">
					<div class="step-no m_b5">{if $appeal_info.check_status lt '3'}3{/if}</div>
					<div>申诉成功<br>{$appeal_info.process_time}</div>
				</div>
				{/if}
			</li>
		</ul>
	</div>
</div>
