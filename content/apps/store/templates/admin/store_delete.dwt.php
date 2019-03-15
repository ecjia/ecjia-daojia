<?php defined('IN_ECJIA') or exit('No permission resources.'); ?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.admin.store_list.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->

<div>
    <h3 class="heading">
        <!-- {if $ur_here}{$ur_here}{/if} -->
        <!-- {if $action_link} -->
        <a class="btn plus_or_reply data-pjax" href="{$action_link.href}"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
        <!-- {/if} -->
    </h3>
</div>


<div class="row-fluid ecjia-delete-store">
    <div class="span12">
        <div class="form-horizontal">

            {if $count eq 0}
            <div class="alert alert-warning">
                <a class="close" data-dismiss="alert">×</a>
                <strong>
                    <p>{t domain="store"}温馨提示{/t}</p>
                </strong>
                <p>{t domain="store"}当前商家账户没有关联数据，您可以直接删除此商家账户。{/t}</p>
            </div>
            {else}
            <!-- {foreach from=$handles item=val} -->
            <div class="control-group formSep">
                <label class="control-label">{$val->getName()}</label>
                <div class="controls p_t4">
                    {$val->handlePrintData()}
                    {if $val->handleCanRemove()}
                    <span class="controls-info-right f_r">
                        <a class="btn btn-gebo" {if $disabled} disabled href="javascript:;" {else} data-toggle="store_ajaxremove" data-msg='{t domain="store"}您确定要【删除】吗？一旦操作后将不可恢复{/t}' data-confirm='{t domain="store"}你真的确定要【删除】吗？{/t}' href="{RC_Uri::url('store/admin/remove_item')}&id={$id}&handle={$val->getCode()}" {/if}>{t domain="store"}删除数据{/t}</a>
                    </span>
                    {/if}
                </div>
            </div>
            <!-- {/foreach} -->
            {/if}

            <div class="control-group">
                {if $delete_all && !$disabled}
                <a class="btn delete_confirm" data-msg='{t domain="store"}您确定要彻底删除该商家所有信息吗？{/t}' href="{RC_Uri::url('store/admin/remove_all')}&id={$id}">{t domain="store"}一键删除所有{/t}</a>
                <a class="btn btn-gebo delete_confirm m_l10" data-msg='{t domain="store"}您确定要彻底删除该商家吗？{/t}' href="{RC_Uri::url('store/admin/remove')}&id={$id}">{t domain="store"}删除商家{/t}</a>
                <div class="help-block">
                    <p>{t domain="store"}注：一键删除：点击后，会将以上所有有关当前账号的数据全部删除，一旦删除后将不可恢复。{/t}</p>
                    <p>{t domain="store"}删除商家：点击后，将当前商家账号彻底删除。{/t}</p>
                </div>
                {/if}
            </div>

        </div>
    </div>
</div>

<!-- {/block} -->