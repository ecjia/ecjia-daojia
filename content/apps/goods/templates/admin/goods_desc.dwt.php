<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->
<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.goods_info.init();
</script>
<!-- {/block} -->
<!-- {block name="main_content"} --> 
{if $step eq '2'}
<!-- #BeginLibraryItem "/library/goods_step.lbi" --><!-- #EndLibraryItem -->
{/if}
<div>
	<h3 class="heading">
	<!-- {if $ur_here}{$ur_here}{/if} -->
	<!-- {if $action_link} -->
	<a class="btn plus_or_reply data-pjax" id="sticky_a" href="{$action_link.href}"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
	<!-- {/if} -->
	</h3>
</div>
<div class="row-fluid edit-page">
	<div class="span12">
		<div class="tabbable">
			{if !$step}
			<ul class="nav nav-tabs">
				<!-- {foreach from=$tags item=tag} -->
				<li{if $tag.active} class="active"{/if}><a{if $tag.active} href="javascript:;"{else}{if $tag.pjax} class="data-pjax"{/if} href='{$tag.href}'{/if}><!-- {$tag.name} --></a></li>
				<!-- {/foreach} -->
			</ul>
			{/if}
			<form class="form-horizontal" enctype="multipart/form-data" action="{$form_action}" method="post" name="theForm">
				<div class="row-fluid control-group">
					<div class="span12">
						{ecjia:editor content=$goods.goods_desc textarea_name='goods_desc' is_teeny=0}
					</div>
				</div>
				<fieldset class="t_c">
					{if $step}
					<button class="btn btn-gebo" type="submit">{lang key='goods::goods.next_step'}</button>
					<input type="hidden" name="step" value="{$step}"/>
					{else}
					<button class="btn btn-gebo" type="submit">{lang key='goods::goods.save'}</button>
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