<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->
<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.admin.store_edit.init();
</script>
<!-- {/block} -->
<!-- {block name="main_content"} -->
<div>
    <h3 class="heading">
        <!-- {if $ur_here}{$ur_here}{/if} -->
        <!-- {if $action_link} -->
        <a class="data-pjax btn plus_or_reply" id="sticky_a" href="{$action_link.href}"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
        <!-- {/if} -->
    </h3>
</div>

<div class="row-fluid">
    <div class="span3">
        <!-- {ecjia:hook id=display_admin_store_menus} -->
    </div>
    <div class="span9">
        <div class="tab-content tab_merchants">
            <div class="tab-pane active" style="min-height:300px;">
                <form class="form-horizontal" method="post" action='{$form_action}' name="theForm">
                    <h3 class="heading">员工数量设置</h3>
                    <div class="control-group formSep">
                        <label class="control-label">{t}员工数量：{/t}</label>
                        <div class="controls">
                            <input type="text" name="merchant_staff_max_number" value="{$store.merchant_staff_max_number}" />
                            <span class="help-block">设置当前商家可添加员工的数量，比如设置10，则商家最多只可添加10名员工</span>
                        </div>
                    </div>

                    <div class="control-group">
                        <div class="controls">
                            <input type="submit" value="{t}确定{/t}" class="btn btn-gebo" />
                            <input type="hidden" name="store_id" value="{$store.store_id}">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- {/block} -->