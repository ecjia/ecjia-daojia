<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-platform.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
</script>
<!-- {/block} -->
<!-- {block name="home-content"} -->

<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
                <h4 class="card-title">
                	{$ur_here}
                </h4>
            </div>
	        <div class="col-md-12">
				<div class="tab-content">
					<div class="active">
						<div class="row-fluid">
							<!-- {foreach from=$activity_list item=act} -->
								<div class="outline">
									<a class="data-pjax"  href='{RC_Uri::url("market/platform/activity_detail", "code={$act.code}")}' >
										<div class="outline-left"><img class="icon-extend" src="{if $act.icon}{$act.icon}{else}{$img_url}setting_shop.png{/if}" /></div>
										<div class="outline-right">
											<p>{$act.name}</p>
											<span>{$act.description}</span>
										</div>
									</a>
								</div>
							<!-- {foreachelse} -->
							<div class="no-records">{t domain="market"}没有找到任何记录{/t}</div>
							<!-- {/foreach} -->
						</div>	
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- {/block} -->