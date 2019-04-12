
<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.merchant.goods_photo.init();
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
                        <div class="row">
                            <div class="col-lg-12"><span class="help-block">{t domain="goods"}注：相册非必填项，若不上传，默认使用主商品相册图。{/t}</span></div>
                            <div class="col-lg-12">
                                <div class="panel">
                                    <div class="panel-body fileupload" data-action="{$form_action}" data-remove="{url path='goods/mh_gallery_product/drop_image'}"></div>
                                    {if $step && !$img_list}
                                    <div class="t_c m_t10 m_b10">
                                        <button class="btn btn-info complete m_l5" data-url='{if $code}{url path="goods/merchant/init" args="extension_code={$code}"}{else}{url path="goods/merchant/init"}{/if}'>{t domain="goods"}完成{/t}</button>
                                        <input type="hidden" name="step" value="{$step}" />
                                    </div>
                                    {/if}
                                </div>
                            </div>
                        </div>

                        {if $img_list && 0}
                        <div class="page-header">
                            <div class="pull-left">
                                <h2>{t domain="goods"}商品相册{/t}<small>{t domain="goods"}（编辑、排序、删除）{/t}</small></h2>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        {/if}

                        <div class="row {if !$img_list} hide{/if}">
                            <div class="col-lg-12">
                                <div class="panel">
                                    <div class="panel-body">
                                        <div class="{if !$img_list} hide{/if}">
                                            <div class="goods-photo-list">
                                                <div class="m_b20"><span class="help-block">{t domain="goods"}上传后，可左右拖拽排序，排序后，请点击“保存排序”{/t}</span></div>
                                                <div class="wmk_grid ecj-wookmark wookmark_list">
                                                    <ul class="wookmark-goods-photo move-mod nomove p_l5">
                                                        <!-- {foreach from=$img_list item=img} -->
                                                        <li class="thumbnail move-mod-group">
                                                            <div class="attachment-preview">
                                                                <div class="ecj-thumbnail">
                                                                    <div class="centered">
                                                                        <a class="bd" href="{$img.img_url}" title="{$img.img_desc}">
                                                                            <img data-original="{$img.img_original}" src="{$img.img_url}" alt="" />
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <p>
                                                                <a href="javascript:;" title="{t domain="goods"}取消{/t}" data-toggle="sort-cancel" style="display:none;"><i class="glyphicon glyphicon-remove"></i></a>
                                                                <a href="javascript:;" title="{t domain="goods"}保存{/t}" data-toggle="sort-ok" data-imgid="{$img.img_id}" data-saveurl="{url path='goods/mh_gallery_product/update_image_desc'}" style="display:none;"><i class="glyphicon glyphicon-ok"></i></a>
                                                                <a class="ajaxremove" data-imgid="{$img.img_id}" data-toggle="ajaxremove" data-msg="{t domain="goods"}您确定要删除这张相册图片吗？{/t}" href='{url path="goods/mh_gallery_product/drop_image" args="img_id={$img.img_id}&goods_id={$smarty.get.goods_id}&id={$smarty.get.id}"}' title="{t domain="goods"}删除{/t}"><i class="glyphicon glyphicon-trash"></i></a>
                                                                <a class="move-mod-head" href="javascript:void(0)" title="{t domain="goods"}移动{/t}"><i class="glyphicon glyphicon-move"></i></a>
                                                                <a href="javascript:;" title="{t domain="goods"}编辑{/t}" data-toggle="edit"><i class="glyphicon glyphicon-pencil"></i></a>
                                                                <span class="edit_title">{if $img.img_desc}{$img.img_desc}{else}{t domain="goods"}无标题{/t}{/if}</span>
                                                            </p>
                                                        </li>
                                                        <!-- {/foreach} -->
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>

                                            <div class="t_l m_t10">
                                                {if $img_list}
                                                <a class="btn btn-info save-sort" data-sorturl="{url path='goods/mh_gallery_product/sort_image'}">{t domain="goods"}保存排序{/t}</a>
                                                {/if}
                                            </div>
                                        </div>

                                        {if $step}
                                        <div class="t_c m_t10">
                                            <button class="btn btn-info complete m_l5" data-url='{url path="goods/merchant/edit" args="goods_id={$goods_id}"}'>{t domain="goods"}完成{/t}</button>
                                            <input type="hidden" name="step" value="{$step}" />
                                        </div>
                                        {/if}
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
<!-- {/block} -->
