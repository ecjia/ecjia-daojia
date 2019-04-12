<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.admin.goods_photo.init();
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

<div class="row-fluid">
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

        <div class="row-fluid">
            <div class="span12">
                <div class="m_b10 help-block">
                    注：相册非必填项，若不上传，默认使用主商品相册图。
                </div>
                <div class="fileupload" data-action="{$form_action}" data-remove="{url path='goodslib/admin_gallery/drop_image'}">
                </div>
            </div>
        </div>
        <div class="row-fluid goods-photo-list{if !$img_list} hide{/if}">
            <div class="span12">
                <div class="m_b20">
                    <span class="help-inline">{t domain="goodslib"}排序后请点击“保存排序”{/t}</span>
                </div>
                <div class="wmk_grid ecj-wookmark wookmark_list">
                    <ul class="wookmark-goods-photo move-mod nomove">
                        <!-- {foreach from=$img_list item=img} -->
                        <li class="thumbnail move-mod-group">
                            <div class="attachment-preview">
                                <div class="ecj-thumbnail">
                                    <div class="centered">
                                        <a class="bd" href="{$img.img_url}" title="{$img.img_desc}">
                                            <img data-original="{$img.img_original}" src="{$img.img_url}" alt=""/>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <p>
                                <a href="javascript:;" title="{t domain="goodslib"}取消{/t}" data-toggle="sort-cancel" style="display:none;"><i class="fontello-icon-cancel"></i></a>
                                <a href="javascript:;" title="{t domain="goodslib"}保存{/t}" data-toggle="sort-ok" data-imgid="{$img.img_id}" data-saveurl="{url path='goodslib/admin_gallery/update_image_desc'}" style="display:none;"><i class="fontello-icon-ok"></i></a>
                                <a class="ajaxremove" data-imgid="{$img.img_id}" data-toggle="ajaxremove" data-msg="{t domain="goodslib"}您确定要删除这张相册图片吗？{/t}" href='{url path="goodslib/admin_gallery/drop_image" args="img_id={$img.img_id}&goods_id={$smarty.get.goods_id}"}' title="{t domain="goodslib"}删除{/t}"><i class="icon-trash"></i></a>
                                <a class="move-mod-head" href="javascript:void(0)" title="{t domain="goodslib"}移动{/t}"><i class="icon-move"></i></a>
                                <a href="javascript:;" title="{t domain="goodslib"}编辑{/t}" data-toggle="edit"><i class="icon-pencil"></i></a>
                                <span class="edit_title">{if $img.img_desc}{$img.img_desc}{else}{t domain="goodslib"}无标题{/t}{/if}</span>
                            </p>
                        </li>
                        <!-- {/foreach} -->
                    </ul>
                </div>
            </div>
            <a class="btn btn-info save-sort" data-sorturl="{url path='goodslib/admin_gallery/sort_image'}">{t domain="goodslib"}保存排序{/t}</a>
        </div>
    </div>
</div>
<!-- {/block} -->