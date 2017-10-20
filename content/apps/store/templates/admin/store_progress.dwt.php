<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->
<!-- {block name="footer"} -->
<!-- {/block} -->
<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
    	<a class="btn plus_or_reply data-pjax" id="sticky_a" href="{$action_link.href}"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
    	<!-- {/if} -->
	</h3>
</div>

<div class="row-fluid">
	<div class="span12 t_c">
		<image src="{if $type eq 'bill'}{$url}images/bill_progress.png{else if $type eq 'enter'}{$url}images/enter_progress.png{/if}" />
	</div>
</div>
<!-- {/block} -->
