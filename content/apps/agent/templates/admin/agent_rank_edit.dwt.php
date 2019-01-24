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
                <label class="control-label">等级名称：</label>
                <div class="controls l_h30">{$data.rank_name}</div>
            </div>

            <div class="control-group formSep">
                <label class="control-label">等级别名：</label>
                <div class="controls">
                    <input class="span6" type="text" name="rank_alias" value="{$data.rank_alias}" />
                    <span class="help-block">您可将等级名称重新命名，未填写时直接显示本名，只影响到代理商的显示，不会对后台功能名称作影响</span>
                </div>
            </div>

            <div class="control-group formSep">
                <label class="control-label">分红比例：</label>
                <div class="controls">
                    <input class="span6" type="text" name="affiliate_percent" value="{$data.affiliate_percent}" /> %
                    <span class="input-must">{lang key='system::system.require_field'}</span>
                    <span class="help-block">请设置代理商的分红百分比</span>
                </div>
            </div>

            <div class="control-group">
                <div class="controls">
                    <input type="hidden" name="id" value="{$id}" />
                    <button class="btn btn-gebo" type="submit">确定</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- {/block} -->