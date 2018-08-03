<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<!-- {/block} -->

<!-- {block name="main_content"} -->
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
					<!-- {foreach from=$activity_list item=act} -->
						<div class="outline">
							<a style=""class="data-pjax"  href='{RC_Uri::url("market/admin/activity_detail", "code={$act.code}")}' >
								<div class="outline-left"><img src="{$act.icon}" /></div>
								<div class="outline-right">
									<h3>{$act.name}</h3>
									<span>{$act.description}</span>
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