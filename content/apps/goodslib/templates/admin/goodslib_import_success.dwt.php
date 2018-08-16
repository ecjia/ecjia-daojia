<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!--{extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.goods_info.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div class="alert alert-info">
	<a class="close" data-dismiss="alert">×</a>
	<p><strong>温馨提示：</strong></p>
	<p>1.您将通过上传的Excel文件，快速导入商品信息至平台商品库中；</p>
	<p>2.请先添加好商品库分类、品牌、规格；</p>
	<p>3.在导入商品信息前，请务必先下载商品导入模版，填写完成后再上传表格；</p>
	<p>4.商品货号和货品号如重复此条信息不导入，或可留空自动生成。</p>
</div>
<div>
	<h3 class="heading"> 
		<!-- {if $ur_here}{$ur_here}{/if} --> 
		{if $action_link}
		<a href="{$action_link.href}" class="btn plus_or_reply data-pjax" id="sticky_a">
			<i class="fontello-icon-reply"></i>{$action_link.text}
		</a>{/if}
	</h3>
</div>

<div class="row-fluid ">
    <div class="span12 ">
    	{if $error}<div class="row-fluid"><h4><i class="splashy-error_small"></i>异常数据</h4></div>{/if}
    	<div class="row-fluid p_t20" style=" margin: 0 auto">
    		<!-- {foreach from=$error item=item}-->
    			<p style=" padding-left: 16px;">{$item.message}</p>
            <!-- {/foreach}-->	
    	</div>
	</div>
	<div class="span12 text-center m_t10">
		
		<div class="row-fluid ">
			<h3><i class="splashy-check"></i> 导入成功！</h3>
		</div>
		<div class="row-fluid ">
			<a class="btn btn-info" href="{url path='goodslib/admin/init'}">查看商品列表</a>
		</div>
	</div>
</div>
<!-- {/block} -->