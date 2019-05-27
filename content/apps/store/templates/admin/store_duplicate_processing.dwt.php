<?php defined('IN_ECJIA') or exit('No permission resources.'); ?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.admin.store_list.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->

<div class="alert alert-info">
    <a class="close" data-dismiss="alert">×</a>
    <strong>
        <p>{t domain="store"}复制店铺{/t}</p>
    </strong>
    <p>{t domain="store"}用于店铺开分店，重新上传产品、设置店铺相关信息又太过于麻烦，使用复制功能，可以轻松处理，一键克隆。{/t}</p>
</div>

<div class="alert alert-warning">
    <a class="close" data-dismiss="alert">×</a>
    <strong>
        <p>{t domain="store"}温馨提示{/t}</p>
    </strong>
    <p>{t domain="store"}以下所有数据，为了避免复制错误导致店铺出现异常，请按显示顺序逐一复制。{/t}</p>
    <p>{t domain="store"}若出现复制错误导致店铺出现异常，请删除该店铺所有数据后重新复制。{/t}</p>
</div>

<div>
    <h3 class="heading">
        {$ur_here}
        <!-- {if $action_link} -->
        <a class="btn plus_or_reply data-pjax" href="{$action_link.href}"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
        <!-- {/if} -->

    </h3>
</div>


<div class="row-fluid ecjia-delete-store">
    <div class="span12">
        <div class="form-horizontal">


            {foreach from=$handles item=val}
            <div class="control-group formSep">
                <label class="control-label">{$val->getName()}</label>
                <div class="controls p_t4">
                    {$val->handlePrintData()}
                    <span class="controls-info-right f_r">
                        {if $val->handleCount() > 0}
                            <a class="btn btn-gebo" {if $val->isCheckFinished()} disabled href="javascript:;" {else} data-toggle="store_ajaxduplicate" href="{$duplicate_item_link.href}&handle={$val->getCode()}" {/if}>{if $val->isCheckFinished()} 已复制 {else} {$duplicate_item_link.text}{/if}</a>
                        {/if}
                    </span>
                </div>
            </div>
            {/foreach}

            <div class="control-group">
                <a class="btn btn-gebo"
                   data-toggle="store_ajaxremove"
                   data-msg='{t domain="store"}您确定要【完成】吗？一旦操作后，您将不可再复制数据到店铺{/t}'
                   data-confirm='{t domain="store"}你真的确定要【完成复制】吗{/t}'
                   href="{$duplicate_finish_link.href}">
                {$duplicate_finish_link.text}
                </a>
            </div>

        </div>
    </div>
</div>

<!-- {/block} -->