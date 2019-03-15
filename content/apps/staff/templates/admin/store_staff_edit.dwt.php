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
            <div class="tab-pane active " style="min-height:300px;">
                <form class="form-horizontal" id="form-privilege" name="theForm" action="{$form_action}" method="post" enctype="multipart/form-data" >
                    <fieldset>
                        <div class="control-group formSep">
                            <label class="control-label">{t domain="staff"}编号：{/t}</label>
                            <div class="controls">
                                <input class="span6" name="user_ident" type="text" value="{$info.user_ident}" />
                            </div>
                        </div>
                        <div class="control-group formSep">
                            <label class="control-label">{t domain="staff"}姓名：{/t}</label>
                            <div class="controls">
                                <input class="span6" name="user_name" type="text" value="{$info.name}" />
                                <span class="input-must"><span class="require-field" style="color:#FF0000,">*</span></span>
                            </div>
                        </div>
                        <div class="control-group formSep">
                            <label class="control-label">{t domain="staff"}昵称：{/t}</label>
                            <div class="controls">
                                <input class="span6" name="nick_name" type="text" value="{$info.nick_name}" />
                            </div>
                        </div>
                        <div class="control-group formSep">
                            <label class="control-label">{t domain="staff"}联系手机：{/t}</label>
                            <div class="controls">
                                <input class="span6" name="contact_mobile" type="text" value="{$info.mobile}" />
                                <span class="input-must"><span class="require-field" style="color:#FF0000,">*</span></span>
                            </div>
                        </div>
                        <div class="control-group formSep">
                            <label class="control-label">{t domain="staff"}电子邮箱：{/t}</label>
                            <div class="controls">
                                <input class="span6" name="email" type="text" value="{$info.email}" />
                                <span class="input-must"><span class="require-field" style="color:#FF0000,">*</span></span>
                            </div>
                        </div>
                        <div class="control-group formSep">
                            <label class="control-label">{t domain="staff"}介绍：{/t}</label>
                            <div class="controls">
                                <input class="span6" name="introduction" type="text" value="{$info.introduction}" />
                            </div>
                        </div>

                        <div class="control-group">
                            <div class="controls">
                                <input type="hidden"  name="store_id" value="{$store.store_id}" />
                                <input type="hidden"  name="staff_id" value="{$info.user_id}" />
                                <button class="btn btn-gebo" type="submit">{t domain="staff"}更新{/t}</button>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- {/block} -->
