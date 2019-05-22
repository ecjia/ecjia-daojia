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
								<div class="template_box">
									{if $has_template}
										<div class="box_content">
											<div class="form-group">
												<label class="control-label col-lg-2 ">{t domain="goods"}参数模板：{/t}</label>
												<div class="col-lg-6 l_h35">
													{$template_info.cat_name}
													<span class="m_l10">
														<a href='{url path="goods/mh_category/edit" args="cat_id={$goods_info.merchant_cat_id}"}'><button type="button" class="btn btn-info" >{t domain="goods"}更换模板{/t}</button></a>
													</span>
												</div>
											</div>
											
											<hr>
											
											<div id="tbody-goodsAttr"> 
												{if $goods_attr_html}{$goods_attr_html}{/if}
											</div>
										</div>
									{else}
										<div class="box_content">
											<div class="form-group">
												<label class="control-label col-lg-2 ">{t domain="goods"}参数模板：{/t}</label>
												<div class="col-lg-6 l_h35">
													<span class="badge bg-important">!</span> <span class="ecjiafc-red">您当前还未绑定任何参数模板，请先绑定后，再来设置</span>
												</div>
											</div>
											
											<div class="form-group">
												<div class="col-lg-offset-2 col-lg-6">
													<a href='{url path="goods/mh_category/edit" args="cat_id={$goods_info.merchant_cat_id}"}'><button type="button" class="btn btn-info" >{t domain="goods"}绑定模板{/t}</button></a>
												</div>
											</div>
										</div>
									{/if}
								</div>

		
							
								{if $has_template}
									<div class="form-group">
										<div class="col-lg-offset-2 col-lg-6 m_t10">
											<button class="btn btn-info" type="submit">{t domain="goods"}保存{/t}</button>
											<input type="hidden" name="mer_cat_id" value="{$goods_info.merchant_cat_id}" />
											<input type="hidden" name="goods_id" value="{$goods_info.goods_id}" />
											<input type="hidden" name="template_id" value="{$template_id}" />
										</div>
									</div>
								{/if}
							</fieldset>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- {/block} -->