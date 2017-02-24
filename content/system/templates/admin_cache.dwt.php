<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.admin.admin_cache.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
    <h3 class="heading">
        <!-- {if $ur_here}{$ur_here}{/if} -->
    </h3>
</div>
<div class="row-fluid">
    <div class="clear_cache span12">
        <form class="stepy-wizzard form-horizontal" id="validate_wizard" action="{url path='@index/update_cache'}" method="post">
            <fieldset title="{t}选择清除{/t}">
                <div class="control-group formSep">
                    <label class="check">
                        <input class="checkbox check_all" name="chkGroup" type="checkbox" value="checkbox" data-toggle="selectall" data-children=".priv_list .checkbox" autocomplete="off">{t}全选{/t}
                    </label>
                </div>
                <!-- {foreach from=$cache_list item=cache_group} -->
                <div class="control-group formSep priv_list">
                    <div class="check">
                        <label><input class="checkbox" name="chkGroup" type="checkbox" value="checkbox" data-toggle="selectall" data-children=".code_{$cache_group.group_code} .checkbox" autocomplete="off">{$cache_group.group_name}</label>
                    </div>
                    <div class="controls code_{$cache_group.group_code}">
                        <!-- {foreach from=$cache_group.group_resources item=cache} -->
                        <div class="choose">
                            <label><input class="checkbox" id="{$cache->getCode()}" name="cachekey" type="checkbox" value="{$cache->getCode()}" title="{$cache->getName()}" autocomplete="off" />{$cache->getName()}{if $cache->getDescription()}<i class="fontello-icon-info-circled ecjiafc-999" data-toggle="tooltip" data-original-title="{$cache->getDescription()}"></i>{/if}</label>
                        </div>
                        <!-- {/foreach} -->
                    </div>
                </div>
                <!-- {/foreach} -->
                <legend class="hide">{t}选择要清除的缓存{/t}&hellip;</legend>
            </fieldset>
            <fieldset title="{t}开始清除{/t}">
                <legend class="hide">{t}开始清除缓存{/t}&hellip;</legend>

                <div class="control-group">
                    <dl class="dl-horizontal cacheshow">
                    </dl>
                </div>
            </fieldset>
            <span class="finish"></span>
        </form>
    </div>
</div>
<!-- {/block} -->
