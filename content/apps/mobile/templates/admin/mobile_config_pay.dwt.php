<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="mobile_config_parent.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
ecjia.admin.mobile_config.info();
</script>

<!-- {/block} -->

<!-- {block name="main_right_content"} -->
<div class="tabbable">

    <!-- {ecjia:hook id=mobile_platform_client_menus} -->

    <div class="list-div list media_captcha wookmark warehouse" id="listDiv">
        {if $pay_list}
        <ul>
            <!-- {foreach from=$pay_list item=val} -->
            <li class='thumbnail'>
                <div class="bd {if $val.enabled eq 1}pay_open{else}pay_close{/if}">
                    <div class="merchants_name">
                        {$val.pay_name}<br>
                        <div class="title">{$val.pay_code}</div><br>
                        <span class="ecjiaf-fs1">
						{if $val.enabled eq 0}
							<a class="switch" href="javascript:;" data-url='{RC_Uri::url("mobile/admin_mobile_config/enable", "pay_code={$val.pay_code}&code={$code}&app_id={$app_id}")}' title="启用">点击启用</a>
						{else}
							<a class="switch" href="javascript:;" data-url='{RC_Uri::url("mobile/admin_mobile_config/disable", "pay_code={$val.pay_code}&code={$code}&app_id={$app_id}")}' title="禁用">点击禁用</a>
							&nbsp;&nbsp;|&nbsp;&nbsp;<a target="_blank" href='{url path="payment/admin_plugin/edit" args="code={$val.pay_code}"}'>插件配置</a></span>
                        {/if}
                    </div>
                </div>
            </li>
            <!-- {/foreach} -->
        </ul>
        {else}
        <pre class="sepH_c" style="background-color: #fbfbfb; height:80px;line-height:80px;">{t domain="mobile"}没有找到任何记录，需进行安装相关支付插件。{/t}</pre>
        {/if}
    </div>
</div>
<!-- {/block} -->