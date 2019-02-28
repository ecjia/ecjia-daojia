<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<style>

</style>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<!-- {foreach $pruduct_data as $key => $group} -->
<div>
	<h3 class="heading">
		<!-- {$group.label} -->
	</h3>
</div>

<div class="row-fluid">
	<div class="span12">
		<div class="tab-content">
			<div class="active">
				<div class="row-fluid">
                    <!-- {foreach from=$group.data item=list} -->
						<div class="outline {if in_array($list->getCode(), $activation_list)}outline-select{/if}">
							<a class="data-pjax"  href='{RC_Uri::url("mobile/admin_mobile_manage/client_list", "code={$list->getCode()}")}' >
								<div class="outline-left"><img src="{$list->getIcon()}" /></div>
								<div class="outline-right">
									<h3>{$list->getName()}</h3>
									<span>{$list->getDescription()}</span>
								</div>
							</a>
						</div>
					<!-- {/foreach} -->
				</div>	
			</div>
		</div>
		
	</div>
</div>
<!-- {/foreach} -->
<!-- {/block} -->