<?php defined('IN_ECJIA') or exit('No permission resources.'); ?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
    <h3 class="heading">
        <!-- {if $ur_here}{$ur_here}{/if} -->
        <!-- {if $action_link} -->
        <a class="btn plus_or_reply data-pjax" href="{$action_link.href}" id="sticky_a"><i
                    class="{$action_link.icon}"></i>{$action_link.text}</a>
        <!-- {/if} -->
    </h3>
</div>

<div class="row-fluid">
    <div class="span3">
        <!-- {ecjia:hook id=admin_api_group_nav arg=$current_code} -->
    </div>
    <div class="span9">
        <form method="POST" action="{$form_action}" name="listForm">
            <div class="row-fluid">
                <table class="table table-striped smpl_tbl table-hide-edit">
                    <thead>
                    <tr>
                        
                        <th class="" style="width: 3%">{t domain="api"}序号{/t}</th>
                        <th class="" style="width: 10%">{t domain="api"}APP{/t}</th>
                        <th class="" style="width: 20%">{t domain="api"}API名称{/t}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <!-- {foreach from=$apis item=api key=index} -->
                    <tr>
                        <td>{$index + 1}</td>
                        <td>{$api->getApp()}</td>
                        <td>{$api->getApi()}</td>
                    </tr>
                    <!-- {foreachelse} -->
                    <tr>
                        <td class="no-records" colspan="5">{t domain="api"}没有找到任何记录{/t}</td>
                    </tr>
                    <!-- {/foreach} -->
                    </tbody>
                </table>
            </div>
        </form>
    </div>
</div>

<!-- {/block} -->