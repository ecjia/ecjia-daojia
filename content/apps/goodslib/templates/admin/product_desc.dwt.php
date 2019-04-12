<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.admin.goods_info.init();
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

        <div class="panel-body panel-body-small">
            <div class="m_b10 help-block">注：图文详情非必填项，若不设置，默认使用主商品图文详情内容。</div>
            <div class="form">
                <form class="form-horizontal" enctype="multipart/form-data" action="{$form_action}" method="post" name="theForm">
                    <div class="row-fluid control-group">
                        <div class="span12">
                            {ecjia:editor content=$info.product_desc textarea_name='product_desc' is_teeny=0}
                        </div>
                    </div>
                    <fieldset class="t_c">

                        <button class="btn btn-gebo" type="submit">{t domain="goodslib"}保存{/t}</button>
                        <input type="hidden" name="goods_id" value="{$goods_id}"/>
                        <input type="hidden" name="id" value="{$product_id}"/>
                        {if $code neq ''}
                        <input type="hidden" name="extension_code" value="{$code}"/>
                        {/if}
                        <input type="hidden" id="type" value="{$link.type}"/>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- {/block} -->