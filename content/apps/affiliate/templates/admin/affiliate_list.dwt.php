<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.admin.affiliate.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
    <h3 class="heading">
        <!-- {if $ur_here}{$ur_here}{/if} -->
        <!-- {if $add_percent} -->
        <!-- 添加佣金百分比 -->
        <a href="{$add_percent.href}" class="btn plus_or_reply data-pjax" id="sticky_b">
            <i class="fontello-icon-plus"></i>{$add_percent.text}
        </a>
        <!-- {/if} -->
    </h3>
</div>

<!-- {if $config.on eq 0} -->
<div class="alert alert-info">
    <strong>{t domain="affiliate"}推荐设置已关闭{/t}</strong>
</div>
<!-- {/if} -->

<div class="alert alert-warning"><a data-dismiss="alert" class="close">×</a>级别多于3个时，只取前3个级别进行分成</div>

<div class="row-fluid edit-page">
    <div class="span12">
        <table class="table table-striped" id="smpl_tbl">
            <thead>
            <tr>
                <th>{t domain="affiliate"}推荐人级别{/t}</th>
                <th>{t domain="affiliate"}现金分成比例{/t}</th>
                <th>{t domain="affiliate"}操作{/t}</th>
            </tr>
            </thead>
            <tbody>
            <!-- {foreach from=$config.item key=key item=val} -->
            <tr>
                <td>{$key+1}</td>
                <td align="left">
                    <span class="cursor_pointer editable-click" data-trigger="editable" data-url="{RC_Uri::url('affiliate/admin/edit_money')}" data-name="level_money" data-pk="{$key+1}" data-title='{t domain="affiliate"}编辑现金分成比例{/t}'>{$val.level_money}</span>
                </td>
                <td align="left">
                    <a class="data-pjax" href='{url path="affiliate/admin/edit" args="id={$key+1}"}' title='{t domain="affiliate"}编辑{/t}'><i class="fontello-icon-edit"></i></a>
                    <a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg='{t domain="affiliate"}您确定要删除吗？{/t}' href='{url path="affiliate/admin/remove" args="id={$key+1}"}' title='{t domain="affiliate"}删除{/t}'><i class="fontello-icon-trash"></i></a>
                </td>
            </tr>
            <!-- {foreachelse} -->
            <tr>
                <td class="dataTables_empty" colspan="4">{t domain="affiliate"}没有找到任何记录{/t}</td>
            </tr>
            <!-- {/foreach} -->
            </tbody>
        </table>
    </div>
</div>

<!-- {/block} -->