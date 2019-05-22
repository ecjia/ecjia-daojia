<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.merchant.product.init();
	ecjia.merchant.product_info.init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->

{if $step}
<!-- #BeginLibraryItem "/library/goods_step.lbi" --><!-- #EndLibraryItem -->
{/if}

<div class="page-header">
	<div class="pull-left">
		<h2><!-- {if $ur_here}{$ur_here}{/if} --><font style="color: #999;font-size:16px">（{$goods_name}）</font></h2>
	</div>
	<div class="pull-right">
		<!-- {if $action_link} -->
		<a class="btn btn-primary data-pjax" href="{$action_link.href}" id="sticky_a"><i class="fa fa-reply"></i> {$action_link.text}</a>
		<!-- {/if} -->
	</div>
  	<div class="clearfix"></div>
</div>

<div class="row-fluid">
    <div class="span12">
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
                        <div class="form">
                            <form class="form-horizontal" enctype="multipart/form-data" action="{$form_action}" method="post" name="theForm">
                                <div class="col-lg-7 pull-left">
                                    <div class="form-group m_t10">
                                        <label class="control-label col-lg-3">{t domain="goods"}商品名称：{/t}</label>
                                        <div class="controls col-lg-9">
                                            <input class="form-control" name="product_name" type="text" value="{$info.product_name|escape}" style="color:{$goods_name_color};"/>
                                            <span class="help-block">{t domain="goods"}非必填，若不填则默认使用主商品名称{/t}</span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-3">{t domain="goods"}商品货号：{/t}</label>
                                        <div class="controls col-lg-9">
                                            <input class="form-control" name="product_sn" type="text" value="{$info.product_sn|escape}" />
                                            <span class="help-block">{t domain="goods"}非必填，系统默认自动生成{/t}</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-lg-3">{t domain="goods"}价格：{/t}</label>
                                        <div class="controls col-lg-9">
                                            <input class="form-control" name="product_shop_price" type="text" value="{$info.product_shop_price}" />
                                            <span class="help-block">{t domain="goods"}非必填，若不填则默认使用主商品价格{/t}</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-lg-3">{t domain="goods"}条形码：{/t}</label>
                                        <div class="controls col-lg-9">
                                            <input class="form-control" name="product_bar_code" type="text" value="{$info.product_bar_code|escape}" />
                                            <span class="help-block">{t domain="goods"}非必填，可手动输入或修改{/t}</span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-3">{t domain="goods"}库存数量：{/t}</label>
                                        <div class="controls col-lg-8">
                                            <input class="form-control" name="product_number" type="text" value="{$info.product_number}" />
                                            <span class="help-block">{t domain="goods"}非必填，若不设置，用户无法购买{/t}</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input name="product_id" type="hidden" value="{$info.product_id}">
                                        <label class="control-label col-lg-3"> </label>
                                    <input type="submit" name="submit" value="{t domain="goods"}完成{/t}" class="btn btn-info" />
                                    </div>
                                </div>

                                <div class="col-lg-5 pull-left">
                                    <div class="panel-group">
                                        <div class="panel panel-info">
                                            <div class="panel-heading">
                                                <a data-toggle="collapse" data-parent="#accordionTwo" href="#collapseSix" class="accordion-toggle">
                                                    <span class="glyphicon"></span>
                                                    <h4 class="panel-title">{t domain="goods"}商品图片{/t}</h4>
                                                </a>
                                            </div>
                                            <div id="collapseSix" class="panel-collapse collapse in">
                                                <div class="panel-body">
                                                    <label>{t domain="goods"}上传商品图片：{/t}</label>
                                                    <div class="accordion-group">
                                                        <div class="accordion-body in collapse" id="goods_info_area_img">
                                                            <div class="accordion-inner">
                                                                <div class="control-group">
                                                                    <div class="ecjiaf-db">
                                                                        <div class="goods_img">
                                                                            <span {if $info.product_img}class="btn fileupload-btn fileupload-btn-product preview-img" style="background-image: url({$info.product_img});"{else}class="btn fileupload-btn"{/if}>
                                                                            <span class="fileupload-exists"><i class="glyphicon glyphicon-plus"></i></span>
                                                                            </span>
                                                                            <input class="hide" type="file" name="goods_img" onchange="ecjia.merchant.goods_info.previewImage(this)" />
                                                                        </div>
                                                                        <div class="thumb_img{if !$info.product_thumb} hide{/if}">
                                                                            <label class="ecjiaf-db">{t domain="goods"}商品缩略图：{/t}</label>
                                                                            <span {if $info.product_thumb}class="btn fileupload-btn fileupload-btn-product preview-img" style="background-image: url({$info.product_thumb});"{else}class="btn fileupload-btn"{/if}>
                                                                            <span class="fileupload-exists"><i class="fontello-icon-plus"></i></span>
                                                                            </span>
                                                                            <input class="hide" type="file" name="thumb_img" onchange="ecjia.merchant.goods_info.previewImage(this)" />
                                                                        </div>
                                                                        <div><span class="help-block">{t domain="goods"}非必填，若不上传则默认使用商品图片，点击更换。{/t}</span></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        
    </div>
</div>
<!-- {/block} -->