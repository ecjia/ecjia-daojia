<?php defined('IN_ECJIA') or exit('No permission resources.'); ?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.merchant.promotion_info.init();
</script>
<!-- {/block} -->
<!-- {block name="home-content"} -->

<div class="page-header">
    <div class="pull-left">
        <h2><!-- {if $ur_here}{$ur_here}{/if} --></h2>
    </div>
    <div class="pull-right">
        <!-- {if $action_link} -->
        <a class="btn btn-primary data-pjax" href="{$action_link.href}" id="sticky_a"><i class="fa fa-reply"></i> {$action_link.text}</a>
        <!-- {/if} -->
    </div>
    <div class="clearfix"></div>
</div>

<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <div class="panel-body">
                <form class="form-horizontal" name="theForm" method="post" action="{$form_action}">
                    {if $id}
                    <div class="form-group">
                        <label class="control-label col-lg-2">{t domain="promotion"}活动状态：{/t}</label>
                        <div class="col-lg-6 l_h30">
                            <span class="promote-status {$goods.promote_status}">{$goods.promote_status_label}</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-lg-2">{t domain="promotion"}活动范围：{/t}</label>
                        <div class="col-lg-6 l_h30">{$goods.range_label}</div>
                    </div>
                    {/if}
                    <div class="form-group">
                        <label class="control-label col-lg-2">{t domain="promotion"}活动时间：{/t}</label>
                        <div class="col-lg-6">
                            <div class="wright">
                                <div class="wright_wleft">
                                    <input class="form-control date" name="start_time" type="text" placeholder='{t domain="promotion"}请选择活动开始时间{/t}' value="{if $id}{$goods.promote_start_date}{else}{$date.sdate}{/if}"/>
                                </div>
                                <div class="wright_wcenter">{t domain="promotion"}至{/t}</div>
                                <div class="wright_wleft">
                                    <input class="form-control date" name="end_time" type="text" placeholder='{t domain="promotion"}请选择活动结束时间{/t}' value="{if $id}{$goods.promote_end_date}{else}{$date.edate}{/if}"/>
                                </div>
                            </div>
                            <div class="help-block">{t domain="promotion"}活动到期后将自动失效，时间精确到：分{/t}</div>
                        </div>
                        <span class="input-must">*</span>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-lg-2">{t domain="promotion"}参与活动商品：{/t}</label>
                        <div class="col-lg-9">
                            <a data-toggle="modal" data-backdrop="static" href="#addModal" class="choose_goods {if $goods.goods_id}hide{/if}">
                                <div class="choose-btn">
                                    <span>+</span>
                                    {t domain="promotion"}去选择{/t}
                                </div>
                            </a>
                            <a data-toggle="modal" data-backdrop="static" href="#addModal" class="change_goods {if !$goods.goods_id}hide{/if}">
                                <div class="btn btn-primary">{t domain="promotion"}更换商品{/t}</div>
                            </a>

                            <div class="goods-temp-content">
                                {if $goods}
                                <!-- #BeginLibraryItem "/library/goods.lbi" --><!-- #EndLibraryItem -->
                                {/if}
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-6">
                            <input type="hidden" name="id" value="{$goods.goods_id}"/>
                            <!-- {if $id} -->
                            <input type="hidden" name="old_id" value="{$goods.goods_id}"/>
                            <input type="submit" value='{t domain="promotion"}更新{/t}' class="btn btn-info"/>
                            <a data-toggle="ajaxremove" class="btn btn-danger m_l5" data-msg='{t domain="promotion"}您确定要删除该促销活动吗？{/t}' href='{RC_Uri::url("promotion/merchant/remove", "id={$goods.goods_id}")}&from=edit' title='{t domain="promotion"}删除{/t}'>{t domain="promotion"}删除{/t}</a>
                            <!-- {else} -->
                            <input type="submit" value='{t domain="promotion"}确定{/t}' class="btn btn-info"/>
                            <!-- {/if} -->
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
</div>

<div class="modal fade" id="addModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" data-dismiss="modal">×</button>
                <h3>{t domain="promotion"}选择活动商品{/t}</h3>
            </div>

            <div class="modal-body">
                <div class="alert alert-info">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                        <i class="fa fa-times" data-original-title="" title=""></i></button>
                    <strong>{t domain="promotion"}温馨提示：{/t}</strong>{t domain="promotion"}1、先搜索需要参与活动的商品；2、在左侧选中参与活动商品；3、预览商品基本信息后“确定”；{/t}
                </div>

                <div class="form-horizontal h475 searchForm" data-href="{$search_action}">
                    <div class="form-group">
                        <div class="col-lg-12">
                            <div class="f_l m_r10">
                                <select class="w130" name="merchant_cat_id">
                                    <option value="0">{t domain="promotion"}所有分类{/t}</option>
                                    <!-- {$merchant_cat} -->
                                </select>
                            </div>
                            <div class="f_l m_r10">
                                <input type="text" class="form-control" name="goods_keywords" value="{$smarty.get.goods_keywords}" placeholder='{t domain="promotion"}请输入商品名称{/t}'>
                            </div>
                            <div class="f_l m_r10">
                                <input type="text" class="form-control" name="goods_sn" value="{$smarty.get.goods_sn}" placeholder='{t domain="promotion"}请输入商品货号{/t}'>
                            </div>
                            <a class="btn btn-primary searchGoods" type="button">
                                <i class="fa fa-search"></i> {t domain="promotion"}搜索{/t}
                            </a>
                        </div>
                    </div>

                    <div class="row draggable">
                        <div class="ms-container" id="ms-custom-navigation">
                            <div class="ms-selectable">
                                <div class="search-header">
                                    <input class="form-control" id="ms-search" type="text" placeholder='{t domain="promotion"}筛选搜索到的商品信息{/t}' autocomplete="off">
                                </div>
                                <ul class="ms-list nav-list-ready" data-url="{RC_Uri::url('promotion/merchant/get_goods_info')}">
                                    <li class="ms-elem-selectable disabled">
                                        <span>{t domain="promotion"}暂无内容{/t}</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="ms-selection">
                                <div class="custom-header custom-header-align">{t domain="promotion"}预览基本信息{/t}</div>
                                <ul class="ms-list nav-list-content">

                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-lg-4"></label>
                        <div class="controls col-lg-6">
                            <input type="button" value='{t domain="promotion"}确定{/t}' class="btn btn-info select-goods-btn"/>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- {/block} -->