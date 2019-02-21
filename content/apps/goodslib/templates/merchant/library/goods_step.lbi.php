<?php defined('IN_ECJIA') or exit('No permission resources.');?> 

<div class="panel panel-body">
	<div class="goods-time-base m_b20">
		<ul>
			<li class="step-first">
				<div class="{if $step eq '1'}step-cur{else}step-done{/if}">
					<div class="step-no">{if $step lt '2'}1{/if}</div>
					<div class="m_t5">{t domain="goodslib"}选择商品分类{/t}</div>
				</div>
			</li>
			<li>
				<div class="{if $step eq '2'}step-cur{elseif $step gt '2'}step-done{/if}">
					<div class="step-no">{if $step lt '3'}2{/if}</div>
					<div class="m_t5">{t domain="goodslib"}选择商品{/t}</div>
				</div>
			</li>
			<li class="step-last">
				<div class="{if $step eq '3'}step-cur{elseif $step gt '3'}step-done{/if}">
					<div class="step-no">{if $step lt '4'}3{/if}</div>
					<div class="m_t5">{t domain="goodslib"}导入完成{/t}</div>
				</div>
			</li>
		</ul>
	</div>
</div>
