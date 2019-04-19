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
								{if $has_goods_type eq 1}
									<div class="form-group">
										<label class="control-label col-lg-2 ">{t domain="goods"}商品规格：{/t}</label>
										<div class="col-lg-4 l_h30">
											{$goods_type_name}
										</div>
										<input type="hidden" name="goods_type" value="{$goods_type}" />
									</div>
								{else}
									<div class="form-group">
										<label class="control-label col-lg-2">{t domain="goods"}商品规格：{/t}</label>
										<div class="col-lg-4">
											<select class="form-control m-bot15" name="goods_type" autocomplete="off" data-toggle="get_attr_list" data-url='{url path="goods/merchant/get_attr" args="goods_id={$goods_id}"}'>
												<option value="0">{t domain="goods"}请选择商品规格{/t}</option>
												<!-- {$goods_type_list} -->
											</select>
											<span class="help-block">{t domain="goods"}请选择商品的所属规格，进而完善此商品的属性{/t}</span>
										</div>
									</div>
								{/if}
								<div id="tbody-goodsAttr"> 
									<!-- {if $goods_attr_html}{$goods_attr_html}{/if}  -->
								</div>
							
								<div class="form-group">
									<div class="col-lg-offset-2 col-lg-6">
									{if $step}
									<button class="btn btn-info" type="submit">{t domain="goods"}下一步{/t}</button>
									<input type="hidden" name="step" value="{$step}" />
									{else}
									<button class="btn btn-info" type="submit">{t domain="goods"}保存{/t}</button>
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
						{if $invaliable_goods_attr_list}
							<div class="accordion-group panel panel-default">
								<div class="panel-heading">
				                    <a data-toggle="collapse" data-parent="#accordion">
				                        <h4 class="panel-title">
				                            <strong>{t domain="goods"}无效属性{/t}</strong>
				                        </h4>
				                    </a>
				                </div>
				                <div class="accordion-body in collapse">
				                	<table class="table table-striped m_b0">
										<thead>
											<tr>
												<th class="w150"><strong>{t domain="goods"}属性名{/t}</strong></th>
												<th class="w180"><strong>{t domain="goods"}属性价格{/t}</strong></th>
												<th class="w150"><strong>{t domain="goods"}操作{/t}</strong></th>
											</tr>
										</thead>
										<tbody>
											<!-- {foreach from=$goods_attr_list item=attr} -->
											<tr>
												<td>{$attr.attr_value}</td>
												<td>{$attr.attr_price}</td>
												<td>
													 <a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg='{t domain="goods"}您确定要删除该属性吗？{/t}' href='{url path="goods/merchant/remove_goods_attr" args="goods_attr_id={$attr.goods_attr_id}"}' title='{t domain="goods"}删除无效属性{/t}'>{t domain="goods"}移除{/t}</a>
												</td>
											</tr>
											<!-- {/foreach} -->
										</tbody>
									</table>
				                </div>
							</div>
						{/if}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- {/block} -->