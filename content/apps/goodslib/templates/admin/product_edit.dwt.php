<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.product.init();
    ecjia.admin.product_info.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->

<div>
    <h3 class="heading">
        <!-- {if $ur_here}{$ur_here}{/if} --><font style="color: #999;font-size:14px">（{$goods_name}）</font>
        <!-- {if $action_link} -->
        <a class="btn plus_or_reply data-pjax" href="{$action_link.href}" id="sticky_a"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
        <!-- {/if} -->
    </h3>
</div>

<div class="row-fluid product-edit">
    <div class="span3">
        <div class="setting-group">
            <span class="setting-group-title">{t domain="goodslib"}货品（SKU）{/t}</span>
            <ul class="nav nav-list m_t10">
                <li class="nav-header">{t domain="goodslib"}切换查看{/t}</li>
                <!-- {foreach from=$product_list item=product} -->
                <li><a class="setting-group-item {if $smarty.get.id eq $product.product_id} llv-active{/if  }" href="{RC_Uri::url('goodslib/admin/product_edit')}&id={$product.product_id}&goods_id={$product.goods_id}">{foreach from=$product.goods_attr item=attr}{$attr} {/foreach}</a></li>
                <!--{/foreach}-->
            </ul>
        </div>
    </div>
    <div class="span9">
        <ul class="nav nav-tabs">
            <li {if $nav_tag eq ''} class="active"{/if}><a class="data-pjax" {if $nav_tag eq ''} href="javascript:;"{else} data-toggle="alertgo" data-message="{t domain="goodslib"}是否放弃本页面修改？{/t}" href='{RC_Uri::url('goodslib/admin/product_edit')}&id={$info.product_id}&goods_id={$info.goods_id}'{/if}>{t domain="goodslib"}基本信息{/t}</a></li>
            <li {if $nav_tag eq 'gallery'} class="active"{/if}><a class="data-pjax" {if $nav_tag eq 'gallery'} href="javascript:;"{else} data-toggle="alertgo" data-message="{t domain="goodslib"}是否放弃本页面修改？{/t}" href='{RC_Uri::url('goodslib/admin_gallery_product/init')}&id={$info.product_id}&goods_id={$info.goods_id}'{/if}>{t domain="goodslib"}相册{/t}</a></li>
            <li {if $nav_tag eq 'desc'} class="active"{/if}><a class="data-pjax" {if $nav_tag eq 'desc'} href="javascript:;"{else} data-toggle="alertgo" data-message="{t domain="goodslib"}是否放弃本页面修改？{/t}" href='{RC_Uri::url('goodslib/admin/product_desc_edit')}&id={$info.product_id}&goods_id={$info.goods_id}'{/if}>{t domain="goodslib"}图文详情{/t}</a></li>
        </ul>

        <div class="panel-body panel-body-small edit-page">
            <div class="form">
                <form class="form-horizontal" enctype="multipart/form-data" action="{$form_action}" method="post" name="theForm">
                    <div class="left-bar">
                        <div class="control-group control-group-small m_t10">
                            <label class="control-label">{t domain="goodslib"}商品名称：{/t}</label>
                            <div class="controls">
                                <input class="form-control w330" name="product_name" type="text" value="{$info.product_name|escape}" style="color:{$goods_name_color};"/>
                                <span class="help-block">{t domain="goodslib"}非必填，若不填则默认使用主商品名称{/t}</span>
                            </div>
                        </div>

                        <div class="control-group control-group-small">
                            <label class="control-label">{t domain="goodslib"}商品货号：{/t}</label>
                            <div class="controls">
                                <input class="form-control w280" name="product_sn" type="text" value="{$info.product_sn|escape}" />
                                <span class="help-block">{t domain="goodslib"}非必填，系统默认自动生成{/t}</span>
                            </div>
                        </div>
                        <div class="control-group control-group-small">
                            <label class="control-label">{t domain="goodslib"}价格：{/t}</label>
                            <div class="controls">
                                <input class="form-control w280" name="product_shop_price" type="text" value="{$info.product_shop_price}" />
                                <span class="help-block">{t domain="goodslib"}非必填，若不填则默认使用主商品价格{/t}</span>
                            </div>
                        </div>
                        <div class="control-group control-group-small">
                            <label class="control-label">{t domain="goodslib"}条形码：{/t}</label>
                            <div class="controls">
                                <input class="form-control w280" name="product_bar_code" type="text" value="{$info.product_bar_code|escape}" />
                                <span class="help-block">{t domain="goodslib"}非必填，可手动输入或修改{/t}</span>
                            </div>
                        </div>

                        <div class="control-group control-group-small">
                            <input name="product_id" type="hidden" value="{$info.product_id}">
                            <label class="control-label"> </label>
                            <input type="submit" name="submit" value="{t domain="goodslib"}完成{/t}" class="btn btn-gebo" />
                        </div>
                    </div>
                    <div class="right-bar">
                        <div class="foldable-list move-mod-group" id="goods_info_sort_img">
                            <div class="accordion-group">
                                <div class="accordion-heading">
                                    <a class="accordion-toggle collapsed move-mod-head" data-toggle="collapse" data-target="#goods_info_area_img">
                                        <strong>{t domain="goodslib"}商品图片{/t}</strong>
                                    </a>
                                </div>
                                <div class="accordion-body in collapse" id="goods_info_area_img">
                                    <div class="accordion-inner">
                                        <div class="control-group">
                                            <label>{t domain="goodslib"}上传商品图片：{/t}</label>
                                            <div class="ecjiaf-db">
                                                <div class="goods_img">
                                                    <span {if $info.product_img}class="btn fileupload-btn fileupload-btn-product preview-img" style="background-image: url({$info.product_img});"{else}class="btn fileupload-btn fileupload-btn-product"{/if}>
                                                    <span class="fileupload-exists"><i class="fontello-icon-plus"></i></span>
                                                    </span>
                                                    <input class="hide" type="file" name="goods_img" onchange="ecjia.admin.goods_info.previewImage(this)"/>
                                                </div>
                                                <div class="thumb_img{if !$info.product_thumb} hide{/if}">
                                                    <label>{t domain="goodslib"}商品缩略图：{/t}</label>
                                                    <span {if $info.product_thumb}class="btn fileupload-btn preview-img" style="background-image: url({$info.product_thumb});"{else}class="btn fileupload-btn"{/if}>
                                                    <span class="fileupload-exists"><i class="fontello-icon-plus"></i></span>
                                                    </span>
                                                    <input class="hide" type="file" name="thumb_img" onchange="ecjia.admin.goods_info.previewImage(this)"/>
                                                </div>
                                                <div>
                                                    <span class="help-inline">{t domain="goodslib"}点击更换商品图片或商品缩略图。{/t}</span>
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
<!-- {/block} -->