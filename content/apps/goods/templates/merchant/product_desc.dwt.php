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
			<!-- {if $ur_here}{$ur_here}{/if} --> <font style="color: #999;font-size:16px">（{$goods_name}）</font>
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
            <div class="panel-body">
                <div class="col-lg-3">
                    <div class="setting-group">
                        <span class="setting-group-title"><i class="fontello-icon-cog"></i>{t domain="goods"}货品（SKU）{/t}</span>
                        <ul class="nav nav-list m_t10">
                            <li class="nav-header">{t domain="goods"}切换查看{/t}</li>
                            <!-- {foreach from=$product_list item=product} -->
                            <li><a class="setting-group-item {if $smarty.get.id eq $product.product_id} llv-active{/if  }" href="{RC_Uri::url('goods/merchant/product_edit')}&id={$product.product_id}&goods_id={$product.goods_id}">{foreach from=$product.goods_attr item=attr}{$attr} {/foreach}</a></li>
                            <!--{/foreach}-->
                        </ul>
                    </div>
                </div>

                <div class="col-lg-9">
                    <div class="panel-body panel-body-small">
                        <ul class="nav nav-tabs">
                            <li {if $nav_tag eq ''} class="active"{/if}><a class="data-pjax" {if $nav_tag eq ''} href="javascript:;"{else} data-toggle="alertgo" data-message="{t domain="goods"}是否放弃本页面修改？{/t}" href='{RC_Uri::url('goods/merchant/product_edit')}&id={$info.product_id}&goods_id={$info.goods_id}'{/if}>{t domain="goods"}基本信息{/t}</a></li>
                            <li {if $nav_tag eq 'gallery'} class="active"{/if}><a class="data-pjax" {if $nav_tag eq 'gallery'} href="javascript:;"{else} data-toggle="alertgo" data-message="{t domain="goods"}是否放弃本页面修改？{/t}" href='{RC_Uri::url('goods/mh_gallery_product/init')}&id={$info.product_id}&goods_id={$info.goods_id}'{/if}>{t domain="goods"}相册{/t}</a></li>
                            <li {if $nav_tag eq 'desc'} class="active"{/if}><a class="data-pjax" {if $nav_tag eq 'desc'} href="javascript:;"{else} data-toggle="alertgo" data-message="{t domain="goods"}是否放弃本页面修改？{/t}" href='{RC_Uri::url('goods/merchant/product_desc_edit')}&id={$info.product_id}&goods_id={$info.goods_id}'{/if}>{t domain="goods"}图文详情{/t}</a></li>
                        </ul>
                    </div>
                    <div class="panel-body panel-body-small">
                        <form class="form-horizontal" enctype="multipart/form-data" action="{$form_action}" method="post" name="theForm">
                            <div class="row-fluid control-group m_b20"><span class="help-block">{t domain="goods"}注：图文详情非必填项，若不设置，默认使用主商品图文详情内容。{/t}</span></div>
                            <div class="row-fluid control-group">
                                <div class="span12">
                                    {ecjia:editor content=$info.product_desc textarea_name='product_desc' is_teeny=0}
                                </div>
                            </div>

                            <div class="t_c m_t10">
                                {if $step}
                                <button class="btn btn-info" type="submit">{t domain="goods"}下一步{/t}</button>

                                <button class="btn btn-info complete m_l5" type="submit" data-url='{url path="goods/merchant/edit"}'>{t domain="goods"}直接完成{/t}</button>
                                <input type="hidden" name="step" value="{$step}" />
                                {else}
                                <button class="btn btn-info" type="submit">{t domain="goods"}保存{/t}</button>
                                {/if}

                                <input type="hidden" name="goods_id" value="{$goods_id}" />
                                <input type="hidden" name="id" value="{$info.product_id}" />
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
	</div>
</div>
<!-- {/block} -->