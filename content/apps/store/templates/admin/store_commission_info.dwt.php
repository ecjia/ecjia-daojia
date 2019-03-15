<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->
<!-- {block name="footer"} -->
<script type="text/javascript">
ecjia.admin.commission.init();
</script>
<!-- {/block} -->
<!-- {block name="main_content"} -->
<div>
    <h3 class="heading">
        <!-- {if $ur_here}{$ur_here}{/if} -->
        <!-- {if $action_link}  -->
        <a class="btn plus_or_reply data-pjax" href="{$action_link.href}" id="sticky_a"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
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
                    <h3 class="heading">{t domain="store"}佣金比例{/t}</h3>
                    <div class="control-group formSep">
                        <label class="control-label">{t domain="store"}佣金比例：{/t}</label>
                        <div class="controls">
                            <select name="percent_id">
                                <option value="0">{t domain="store"}请选择{/t}</option>
                                <!-- {foreach from=$store_percent item=percent} -->
                                <option value="{$percent.percent_id}" {if $store_commission.percent_id eq $percent.percent_id} selected="selected" {/if}>{$percent.percent_value}%</option>
                                <!-- {/foreach} -->
                            </select>
                            <span class="input-must">*</span>
                        </div>
                    </div>
                    
                    <h3 class="heading">{t domain="store"}保证金{/t}</h3>
                    <div class="control-group formSep">
                        <label class="control-label">{t domain="store"}保证金：{/t}</label>
                        <div class="controls">
                            <input type="text" name="store_deposit" value="{$store_deposit}" /> {t domain="store"}元{/t}
    				        <span class="help-block">{t domain="store"}设置此商家需要向平台缴纳的保证金金额{/t}</span>
                        </div>
                    </div>

                    <div class="control-group " >
                        <div class="controls">
                            <input type="submit" value='{t domain="store"}确定{/t}' class="btn btn-gebo" />
                            <input type="hidden" name="store_id" value="{$store_id}">
                            <input type="hidden" name="id" value="{$id}">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- {/block} -->
