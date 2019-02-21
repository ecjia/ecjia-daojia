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
		</div>
	</div>
</div>
<!-- {/block} -->