<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->
<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.admin.store_edit.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<style>
.heading .btn { margin-top:-3px;}
</style>
<div>
    <h3 class="heading">
        <!-- {if $ur_here}{$ur_here}{/if} -->
        <!-- {if $action_link} -->
        <a class="data-pjax btn plus_or_reply" id="sticky_a" href="{$action_link.href}"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
        <!-- {/if} -->
        <a class="data-pjax btn f_r" href='{RC_Uri::url("merchant/admin_store_setting/edit","store_id={$smarty.get.store_id}")}'><i class="fontello-icon-edit"></i>{t domain="merchant"}编辑{/t}</a>
    </h3>
</div>

<div class="row-fluid">
    <div class="span3">
        <!-- {ecjia:hook id=display_admin_store_menus} -->
    </div>
    <div class="span9">
        <form method="post" class="form-horizontal" action="{$form_action}" name="theForm" enctype="multipart/form-data">
            <div class="tab-content tab_merchants">
                <div class="tab-pane active" id="tab1">
                    <div class="foldable-list move-mod-group">
                        <div class="accordion-group">
                            <div class="accordion-heading accordion-heading-url">
                                <div class="accordion-toggle acc-in" data-toggle="collapse" data-target="#info">
                                    <strong>{t domain="merchant"}店铺设置{/t}</strong>
                                </div>
                            </div>
                            <div class="accordion-body in collapse" id="info">
                                <table class="table table-oddtd m_b0">
                                    <tbody class="first-td-no-leftbd">
                                        <tr>
                                            <td><div align="right"><strong>{t domain="merchant"}店铺LOGO：{/t}</strong></div></td>
                                            <td colspan="3"><img src="{$store_info.shop_logo}" alt="" style="max-width:120px;"/></td>
                                        </tr>
                                        <tr>
                                            <td><div align="right"><strong>{t domain="merchant"}店铺顶部Banner图：{/t}</strong></div></td>
                                            <td colspan="3"><img src="{$store_info.shop_banner_pic}" alt="" style="max-width:120px;"/></td>
                                        </tr>
                                        <tr>
                                            <td><div align="right"><strong>{t domain="merchant"}店铺导航背景图：{/t}</strong></div></td>
                                            <td colspan="3"><img src="{$store_info.shop_nav_background}" alt="" style="max-width:300px;" /></td>
                                        </tr>
                                        <tr>
                                            <td><div align="right"><strong>{t domain="merchant"}营业时间：{/t}</strong></div></td>
                                            <td>{$store_info.shop_trade_time}</td>
                                            <td><div align="right"><strong>{t domain="merchant"}客服电话：{/t}</strong></div></td>
                                            <td>{$store_info.shop_kf_mobile}</td>
                                        </tr>
                                        <tr>
                                            <td><div align="right"><strong>{t domain="merchant"}店铺简介：{/t}</strong></div></td>
                                            <td colspan="3">{$store_info.shop_description}</td>
                                        </tr>
                                        <tr>
                                            <td><div align="right"><strong>{t domain="merchant"}店铺公告：{/t}</strong></div></td>
                                            <td colspan="3">{$store_info.shop_notice}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- {/block} -->