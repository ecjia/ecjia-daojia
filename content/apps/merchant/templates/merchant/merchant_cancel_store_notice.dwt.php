<?php defined('IN_ECJIA') or exit('No permission resources.'); ?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

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
        <section class="panel">
            <div class="merchant-cancel-three">
                <div class="merchant-cancel-active"><img src="{$cancel_png}" alt=""></div>
                <p class="bold">{t domain="merchant"}已成功激活！可继续使用您的店铺{/t}</p>
                <div>
                    <a class="btn btn-info" href="{RC_Uri::url('merchant/dashboard/init')}">{t domain="merchant"}完成{/t}</a>
                </div>
            </div>
        </section>
    </div>
</div>
<!-- {/block} -->
