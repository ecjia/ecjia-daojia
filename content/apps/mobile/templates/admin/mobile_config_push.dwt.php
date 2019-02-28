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

    <div class="tab-content">
        <form class="form-horizontal" id="form-privilege" name="theForm" action="{$form_action}" method="post"  >
            <fieldset>
                <h3 class="heading">{t domain="mobile"}APP推送{/t}</h3>

                <div class="control-group formSep">
                    <label class="control-label">{t domain="mobile"}推送环境：{/t}</label>
                    <div class="controls">
                        <input type="radio" name="push_umeng[environment]" value="develop" checked="true"{if $data.option_value.environment eq 'develop'} checked="true" {/if} />{t domain="mobile"}开发环境{/t}
                        <input type="radio" name="push_umeng[environment]" value="online" {if $data.option_value.environment eq 'online'} checked="true" {/if} />{t domain="mobile"}生产环境{/t}
                        <span class="help-block">{t domain="mobile"}App上线运行请务必切换置生产环境{/t}</span>
                    </div>
                </div>

                <div class="control-group formSep">
                    <label class="control-label">App Key：</label>
                    <div class="controls">
                        <input class="span6" name="push_umeng[app_key]" type="text" value="{$data.option_value.app_key}" />
                        <span class="input-must"><span class="require-field" style="color:#FF0000,">*</span></span>
                    </div>
                </div>

                <div class="control-group formSep">
                    <label class="control-label">App Secret：</label>
                    <div class="controls">
                        <input class="span6" name="push_umeng[app_secret]" type="text" value="{$data.option_value.app_secret}" />
                        <span class="input-must"><span class="require-field" style="color:#FF0000,">*</span></span>
                    </div>
                </div>

                <div class="control-group">
                    <div class="controls">
                        <input type="hidden" name="app_id"   value="{$app_id}">
                        <input type="hidden" name="code" value="{$code}">
                        <button class="btn btn-gebo" type="submit">{t domain="mobile"}确定{/t}</button>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>
<!-- {/block} -->