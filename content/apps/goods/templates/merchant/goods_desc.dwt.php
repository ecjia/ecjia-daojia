<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.merchant.goods_info.init();
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


<div class="row edit-page">
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
				<form class="form-horizontal" enctype="multipart/form-data" action="{$form_action}" method="post" name="theForm">
					<div class="row-fluid control-group">
						<div class="span12">
							{ecjia:editor content=$goods.goods_desc textarea_name='goods_desc' is_teeny=0}
						</div>
					</div>
					
					<div class="t_c m_t10">
						{if $step}
						<button class="btn btn-info" type="submit">{lang key='goods::goods.next_step'}</button>
						
						<button class="btn btn-info complete m_l5" type="submit" data-url='{url path="goods/merchant/edit"}'>直接完成</button>
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
				</form>
			</div>
		</div>
	</div>
</div>
<!-- {/block} -->