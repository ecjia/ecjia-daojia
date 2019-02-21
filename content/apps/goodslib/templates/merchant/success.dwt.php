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
		<h2><!-- {if $ur_here}{$ur_here}{/if} --><span class="f_s15 m_l5">{if $cat_html}{$cat_html}{/if}</span></h2>
	</div>
  	<div class="pull-right">
		<!-- {if $action_link} -->
			<a class="btn btn-primary data-pjax" id="sticky_a" href="{$action_link.href}"><i class="fa fa-reply"></i> {$action_link.text}</a>
		<!-- {/if} -->
	</div>
  	<div class="clearfix"></div>
</div>

<div class="row-fluid success-page">
   <div class="panel">
        <div class="panel-body text-center">
			<div class="panel-body ">
				<span class="glyphicon glyphicon-ok-sign"></span>
			</div>
			<div class="panel-body ">
				<h4>{t domain="goodslib"}恭喜您，导入成功！{/t}</h4>
			</div>
			<div class="panel-body ">
				<a class="btn btn-info" href="{url path='goods/merchant/init'}">{t domain="goodslib"}查看商品列表{/t}</a>
			</div>
		</div>
	</div>
</div>
<!-- {/block} -->