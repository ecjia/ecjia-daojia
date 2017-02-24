<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="home-content"} -->
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-body errorpage alert">
			<div class="errorpage-content">
				<div class="msg-icon">
					<span class="{$page_state.icon} {$page_state.class}"></span>
					<p>{$page_state.msg}</p>
				</div>
				<div class="msg-info">
					<p class="info">{$msg_detail}</p>
					<!-- {if $links} -->
					<p class="m_t20"><strong>{t}您可以试试下面的链接：{/t}</strong></p>
					<!-- {foreach from=$links item=link key=key name=link_list} -->
						<a class="ecjiaf-ib ecjiaf-fl m_r10" href="{$link.href}"><i class="fontello-icon-link"></i>{$link.text}</a>
					<!-- {/foreach} -->
					<!-- {/if} -->
				</div>
			</div>
		</div>
	</div>
</div>
<!-- {/block} -->