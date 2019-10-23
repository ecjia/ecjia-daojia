<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<!-- {/block} -->

<!-- {block name="home-content"} -->

<div class="page-header">
    <div class="pull-left">
        <h2><!-- {if $ur_here}{$ur_here}{/if} --></h2>
    </div>
    <div class="pull-right">
        {if $action_link}
        <a href="{$action_link.href}" class="btn btn-primary data-pjax">
            <i class="fa fa-reply"></i> {$action_link.text}
        </a>
        {/if}
    </div>
    <div class="clearfix"></div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-body">
            <div class="qrcode-content">
                <div class="left-side">
                    <div class="store-logo"><img src="{$merchant_info.shop_logo}"></div>
                    <div class="store-name">{$merchant_info.merchants_name}</div>
                    <div class="qrcode"><img src="{$merchant_info.collectmoney_qrcode}"></div>
                    <div class="info">{t domain="quickpay"}微信扫描二维码进行买单{/t}</div>
                </div>

                <div class="right-side">
                    <div class="right-head">收款二维码</div>
                    <div class="right-content">
                        <p>{t domain="quickpay"}此收款码用于商家收款使用，二维码收款是客户向商家转账的一种方式，客户在店内消费后使用微信“扫一扫”，则直接使用微信支付转账给商家，方便、快捷、减少客户等待时间，还可使用A4纸张打印机打印。{/t}</p>
                        <p>{t domain="quickpay"}打印尺寸：A4纸尺寸{/t}</p>
                        <p>{t domain="quickpay"}使用说明：先将二维码下载，用A4纸打印后裁切出来，可张贴在店铺内桌子、服务台等处，方便用户扫码。{/t}</p>
                    </div>
                    <div class="right-handle">
                        <a class="btn btn-primary" href="{$refresh_url}" data-toggle="ajaxremove" data-msg='{t domain="quickpay"}您确定要刷新该收款二维码吗？{/t}'>{t domain="quickpay"}刷新二维码{/t}</a>
                        <a class="btn btn-info m_l10 nopjax" target="_blank" href="{$download_url}">{t domain="quickpay"}下载素材{/t}</a>
                        <a class="btn btn-info m_l10 nopjax" target="_blank" href="{$print_url}">{t domain="quickpay"}打印二维码{/t}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="panel panel-body">
            <div class="qrcode-content">
                <div class="left-side">
                    <div class="store-logo"><img src="{$merchant_info.shop_logo}"></div>
                    <div class="store-name">{$merchant_info.merchants_name}</div>
                    <div class="qrcode"><img src="{$merchant_info.member_qrcode}"></div>
                    <div class="info">{t domain="quickpay"}扫描二维码与店铺绑定关系{/t}</div>
                </div>

                <div class="right-side">
                    <div class="right-head">推广二维码</div>
                    <div class="right-content">
                        <p>{t domain="quickpay"}此二维码用于商家推广使用，商家可以将带有店铺ID的二维码，应用到制作广告、印刷海报等需要用的地方，还可通 过朋友及朋友圈转发，让更多用户扫描该二维码后，快速与商家店铺绑定关系，帮助让会员的归属店铺划分更清楚。{/t}</p>
                        <p>{t domain="quickpay"}打印尺寸：A4纸尺寸{/t}</p>
                        <p>{t domain="quickpay"}使用说明：先将二维码下载，用A4纸打印后裁切出来，可张贴在店铺内桌子、服务台等处，方便用户扫码。{/t}</p>
                    </div>
                    <div class="right-handle">
                        <a class="btn btn-primary" href="{$refresh_url}&type=affiliate" data-toggle="ajaxremove" data-msg='{t domain="quickpay"}您确定要刷新该推广二维码吗？{/t}'>{t domain="quickpay"}刷新二维码{/t}</a>
                        <a class="btn btn-info m_l10 nopjax" target="_blank" href="{$download_url}&type=affiliate">{t domain="quickpay"}下载素材{/t}</a>
                        <a class="btn btn-info m_l10 nopjax" target="_blank" href="{$print_url}&type=affiliate">{t domain="quickpay"}打印二维码{/t}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- {/block} -->
