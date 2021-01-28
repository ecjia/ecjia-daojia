<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="main_content"} -->
<div class="row-fluid">
	<div class="span12 errorpage alert {$page_state.class}">
		<div class="msg-icon">
			<i class="{$page_state.icon}"></i>
			<p>{$page_state.msg}</p>
		</div>
		<div class="msg-info">
			<p class="info">{$msg_detail}</p>
			
			<!-- {if $links} -->
			<p><strong>{t}您可以试试下面的链接：{/t}</strong></p>
			<!-- {foreach from=$links item=link key=key name=link_list} -->
				<a class="ecjiaf-ib ecjiaf-fl m_r10" href="{$link.href}"><i class="fontello-icon-link"></i>{$link.text}</a>
			<!-- {/foreach} -->
			<!-- {/if} -->
		</div>
	</div>
</div>
<!-- {/block} -->