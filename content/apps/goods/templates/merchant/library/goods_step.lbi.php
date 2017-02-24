<?php defined('IN_ECJIA') or exit('No permission resources.');?> 

<div class="panel panel-body">
	<div class="goods-time-base m_b20">
		<ul>
			<li class="step-first">
				<div class="{if $step eq '1'}step-cur{else}step-done{/if}">
					<div class="step-no">{if $step lt '2'}1{/if}</div>
					<div class="m_t5">{lang key='goods::goods.choose_goods_cat'}</div>
				</div>
			</li>
			<li>
				<div class="{if $step eq '2'}step-cur{elseif $step gt '2'}step-done{/if}">
					<div class="step-no">{if $step lt '3'}2{/if}</div>
					<div class="m_t5">{lang key='goods::goods.basic_info'}</div>
				</div>
			</li>
			<li>
				<div class="{if $step eq '3'}step-cur{elseif $step gt '3'}step-done{/if}">
					<div class="step-no">{if $step lt '4'}3{/if}</div>
					<div class="m_t5">{lang key='goods::goods.tab_detail'}</div>
				</div>
			</li>
			<li class="step-last">
				<div class="{if $step eq '4'}step-cur{/if}">
					<div class="step-no">{if $step lt '5'}4{/if}</div>
					<div class="m_t5">{lang key='goods::goods.tab_gallery'}</div>
				</div>
			</li>
		</ul>
	</div>
</div>
