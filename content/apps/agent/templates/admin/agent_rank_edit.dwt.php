<?php defined('IN_ECJIA') or exit('No permission resources.'); ?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.admin.agent.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
    <h3 class="heading">
        <!-- {if $ur_here}{$ur_here}{/if} -->
        {if $action_link}
        <a class="btn plus_or_reply data-pjax" href="{$action_link.href}" id="sticky_a"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
        {/if}
    </h3>
</div>

<div class="row-fluid">
    <div class="span12">
        <form class="form-horizontal" action="{$form_action}" method="post" enctype="multipart/form-data" name="theForm">
            <div class="control-group formSep">
                <label class="control-label">{t domain="agent"}等级名称：{/t}</label>
                <div class="controls l_h30">{$data.rank_name}</div>
            </div>

            <div class="control-group formSep">
                <label class="control-label">{t domain="agent"}等级别名：{/t}</label>
                <div class="controls">
                    <input class="span6" type="text" name="rank_alias" value="{$data.rank_alias}" />
                    <span class="help-block">{t domain="agent"}您可将等级名称重新命名，未填写时直接显示本名，只影响到代理商的显示，不会对后台功能名称作影响{/t}</span>
                </div>
            </div>

            <div class="control-group formSep">
                <label class="control-label">{t domain="agent"}分红比例：{/t}</label>
                <div class="controls">
                    <input class="span6" type="text" name="affiliate_percent" value="{$data.affiliate_percent}" /> %
                    <span class="input-must"><span class="require-field" style="color:#FF0000,">*</span></span>
                    <span class="help-block">{t domain="agent"}请设置代理商的分红百分比{/t}</span>
                </div>
            </div>

            <div class="control-group">
                <div class="controls">
                    <input type="hidden" name="id" value="{$id}" />
                    <button class="btn btn-gebo" type="submit">{t domain="agent"}确定{/t}</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- {/block} -->