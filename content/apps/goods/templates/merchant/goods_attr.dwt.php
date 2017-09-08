<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} --> 
<script type="text/javascript">
	ecjia.merchant.goods_attr.init();
</script> 
<!-- {/block} --> 

<!-- {block name="home-content"} -->

{if $step}
<!-- #BeginLibraryItem "/library/goods_step.lbi" --><!-- #EndLibraryItem -->
{/if}

<div class="page-header">
	<div class="pull-left">
		<h2> 
			<!-- {if $ur_here}{$ur_here}{/if} --> 
		</h2>	
	</div>
	<div class="pull-right">
		{if $action_link} 
		<a href="{$action_link.href}" class="btn btn-primary data-pjax" id="sticky_a">
		<i class="fa fa-reply"></i> {$action_link.text}</a> 
		{/if}
	</div>
	<div class="clearfix"></div>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="panel">
			{if !$step}
           	<div class="panel-body panel-body-small">
				<ul class="nav nav-tabs">
					<!-- {foreach from=$tags item=tag} -->
					<li {if $tag.active} class="active"{/if}><a {if $tag.active} href="javascript:;"{else}{if $tag.pjax} class="data-pjax"{/if} href='{$tag.href}'{/if}><!-- {$tag.name} --></a></li>
					<!-- {/foreach} -->
				</ul>
			</div>
			{/if}
				
			<div class="panel-body">
                <div class="tab-content">
                	<div class="form">
						<form class="form-horizontal" action="{$form_action}" method="post" name="theForm">
							<fieldset>
								<div class="form-group">
									<label class="control-label col-lg-2">{lang key='goods::goods.label_goods_spec'}</label>
									<div class="col-lg-4">
										<select class="form-control m-bot15" name="goods_type" autocomplete="off" data-toggle="get_attr_list" data-url='{url path="goods/merchant/get_attr" args="goods_id={$goods_id}"}'>
											<option value="0">{lang key='goods::goods.sel_goods_spec'}</option>
											<!-- {$goods_type_list} -->
										</select>
										<span class="help-block">{lang key='goods::goods.notice_goods_spec'}</span> 
									</div>
								</div>
								<div id="tbody-goodsAttr"> 
									<!-- {if $goods_attr_html}{$goods_attr_html}{/if}  -->
								</div>
							
								<div class="form-group">
									<div class="col-lg-offset-2 col-lg-6">
									{if $step}
									<button class="btn btn-info" type="submit">{lang key='goods::goods.next_step'}</button>
									<input type="hidden" name="step" value="{$step}" />
									{else}
									<button class="btn btn-info" type="submit">{lang key='goods::goods.save'}</button>
									{/if}
									
									<input type="hidden" name="goods_id" value="{$goods_id}" />
									{if $code neq ''}
									<input type="hidden" name="extension_code" value="{$code}" />
									{/if}
									<input type="hidden" id="type" value="{$link.type}" />
									</div>
								</div>
							</fieldset>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- {/block} -->