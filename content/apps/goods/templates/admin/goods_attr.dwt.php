<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->
<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.goods_attr.init();
</script>
<!-- {/block} -->
<!-- {block name="main_content"} -->
{if $step eq '3'}
<!-- #BeginLibraryItem "/library/goods_step.lbi" --><!-- #EndLibraryItem -->
{/if}
<div>
	<h3 class="heading">
	<!-- {if $ur_here}{$ur_here}{/if} --> 
		{if $action_link} 
	<a href="{$action_link.href}" class="btn plus_or_reply data-pjax" id="sticky_a"><i class="fontello-icon-reply"></i>{$action_link.text}</a> {/if}
	</h3>
</div>
<div class="row-fluid">
	<div class="span12">
		<div class="tabbable">
			{if !$step}
			<ul class="nav nav-tabs">
				<!-- {foreach from=$tags item=tag} -->
				<li{if $tag.active} class="active"{/if}><a{if $tag.active} href="javascript:;"{else}{if $tag.pjax} class="data-pjax"{/if} href='{$tag.href}'{/if}><!-- {$tag.name} --></a></li>
				<!-- {/foreach} -->
			</ul>
			{/if}
			<form class="form-horizontal" action="{$form_action}" method="post" name="theForm">
				<fieldset>
					{if $has_goods_type eq 1}
						<div class="control-group formSep">
							<label class="control-label">{t domain="goods"}商品规格：{/t}</label>
							<div class="controls l_h30">
								{$goods_type_name}
							</div>
							<input type="hidden" name="goods_type" value="{$goods_type}"/>
						</div>
					{else}
						<div class="control-group formSep">
							<label class="control-label">{t domain="goods"}商品规格：{/t}</label>
							<div class="controls">
								<select name="goods_type" autocomplete="off" data-toggle="get_attr_list" data-url='{url path="goods/admin/get_attr" args="goods_id={$goods_id}"}'>
									<option value="0">{t domain="goods"}请选择商品规格{/t}</option>
									<!-- {$goods_type_list} -->
								</select>
								<br/>
								<br/>
								<span class="help-block">{t domain="goods"}请选择商品的所属规格，进而完善此商品的属性{/t}</span>
							</div>
						</div>
					{/if}
					<div id="tbody-goodsAttr">
						<!-- {if $goods_attr_html}{$goods_attr_html}{/if}  -->
					</div>
				</fieldset>
				<fieldset class="t_c">
					{if $step}
					<button class="btn btn-gebo" type="submit">{t domain="goods"}下一步{/t}</button>
					<input type="hidden" name="step" value="{$step}"/>
					{else}
					<button class="btn btn-gebo" type="submit">{t domain="goods"}保存{/t}</button>
					{/if}
					<input type="hidden" name="goods_id" value="{$goods_id}"/>
					{if $code neq ''}
					<input type="hidden" name="extension_code" value="{$code}"/>
					{/if}
					<input type="hidden" id="type" value="{$link.type}"/>
				</fieldset>
			</form>
			{if $invaliable_goods_attr_list}
				<div class="accordion-group" style="margin-top:35px;">
					<div class="accordion-heading">
						<a class="accordion-toggle acc-in move-mod-head" data-toggle="collapse">
							<strong>{t domain="goods"}无效规格属性{/t}</strong>
						</a>
					</div>
					<div class="accordion-body in collapse">
						<table class="table table-striped m_b0">
							<thead>
								<tr>
									<th class="w250">
										<strong>{t domain="goods"}属性名{/t}</strong>
									</th>
									<th class="w180">
										<strong>{t domain="goods"}属性价格{/t}</strong>
									</th>
									<th class="w180">
										<strong>{t domain="goods"}操作{/t}</strong>
									</th>
								</tr>
							</thead>
							<tbody>
								{foreach from=$goods_attr_list item=attr}
								<tr>
									<td>{$attr.attr_value}</td>
									<td>{$attr.attr_price}</td>
									<td><a class="ecjiafc-red ajax-remove" data-toggle="ajaxremove" data-msg='{t domain="goods"}您确定要把该属性删除吗？{/t}' href='{url path="goods/admin/remove_goods_attr" args="goods_attr_id={$attr.goods_attr_id}"}' title='{t domain="goods"}删除无效属性{/t}'>{t domain="goods"}移除{/t}</a></td>
								</tr>
								{/foreach}
							</tbody>
						</table>
					</div>
				</div>
			{/if}
		</div>
	</div>
</div>
<!-- {/block} -->