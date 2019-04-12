<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.change_password.init();
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
							<label class="control-label">{t domain="staff"}店长名称：{/t}</label>
							<div class="controls l_h30">
								{$info.name}（{$info.nick_name}）
							</div>
						</div>
		
						<div class="control-group formSep">
							<label class="control-label">{t domain="staff"}新密码：{/t}</label>
							<div class="controls">
								<input class="w350" type="password" name="new_password" id="new_password" />
								<span class="input-must">*</span>
							</div>
						</div>
						
						<div class="control-group formSep">
							<label class="control-label">{t domain="staff"}确认密码：{/t}</label>
							<div class="controls">
								<input class="w350" type="password"  name="confirm_password" />
								<span class="input-must">*</span>
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
