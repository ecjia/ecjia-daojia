<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="plugin_config.dwt.php"} -->

<!-- {block name="footer"} -->
<!-- {/block} -->

<!-- {block name="admin_plugin_list"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
	</h3>
</div>

<div class="row-fluid">
	<div class="span12">
		<div class="tab-content">
			<div class="active">
				<div class="row-fluid">
					<!-- {foreach from=$data item=list} -->
						<div class="outline">
							<a style=""class="data-pjax"  href='{RC_Uri::url("maintain/admin/run", "code={$list.code}")}' title="{$list.name}">
								<div class="outline-left"><img src="{$list.icon}" /></div>
								<div class="outline-right">
									<h3>{$list.name}</h3>
									<span title="{$list.description}">{$list.description}</span>
								</div>
							</a>
						</div>
					<!-- {/foreach} -->
				</div>	
			</div>
		</div>
		
	</div>
</div>
<!-- {/block} -->