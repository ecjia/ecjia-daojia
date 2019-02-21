<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-platform.dwt.php"} -->

<!-- {block name="home-content"} -->
<div class="row">
    <div class="col-12">
        <div class="card">
        	<div class="card-body errorpage">
				<div class="errorpage-content">
					<div class="msg-icon">
						<span class="{$page_state.icon} {$page_state.class}"></span>
						<p>{$page_state.msg}</p>
					</div>
					<div class="msg-info">
						<p class="text-center">{$msg_detail}</p>
						<!-- {if $links} -->
						<p class="m_t20"><strong>{t domain="platform"}您可以试试下面的链接：{/t}</strong></p>
						<!-- {foreach from=$links item=link key=key name=link_list} -->
							<a class="ecjiaf-ib ecjiaf-fl m_r10" href="{$link.href}"><i class="fontello-icon-link"></i>{$link.text}</a>
						<!-- {/foreach} -->
						<!-- {/if} -->
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- {/block} -->