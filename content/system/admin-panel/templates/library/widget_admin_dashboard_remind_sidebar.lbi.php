<?php defined('IN_ECJIA') or exit('No permission resources.');?>

<!-- {if $remind} -->
<ul class="unstyled">
	<!-- {foreach from=$remind item=item} -->
	<li>
		<span class="act act-{$item.style}">{$item.total}</span>
		<strong>{$item.label}</strong>
	</li>
	<!-- {/foreach} -->
</ul>
<!-- {/if} -->