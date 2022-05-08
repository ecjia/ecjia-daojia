<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.privilege.edit();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<h3 class="heading">
	<!-- {if $ur_here}{$ur_here}{/if} -->
	<!-- {if $action_link} -->
	<a class="btn data-pjax plus_or_reply" id="sticky_a" href="{$action_link.href}"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
	<!-- {/if} -->
</h3>

<form class="form-horizontal {$action}" id="form-privilege" name="theForm" action="{$form_action}" method="post">
	<div class="row-fluid">
		<div class="span12">
			<fieldset>
				<div class="control-group formSep">
					<label class="control-label" for="user_name">{t}用户名：{/t}</label>
					<div class="controls">
						<input class="input-xlarge" name="user_name" type="text" id="user_name" value="{$user.user_name|escape}" {if $action eq "modif"}disabled="disabled"{/if}  autocomplete="off" /><span class="input-must">*</span>
					</div>
				</div>
				<div class="control-group formSep">
					<label class="control-label" for="email">{t}Email地址：{/t}</label>
					<div class="controls">
						<input class="input-xlarge" name="email" type="text" id="email" value="{$user.email|escape}" autocomplete="off" /><span class="input-must">*</span>
					</div>
				</div>
				<!-- {if $action eq "add"} -->
				<div class="control-group formSep">
					<label class="control-label" for="password">{t}密  码：{/t}</label>
					<div class="controls">
						<input class="input-xlarge" type="password" name="password" id="password" maxlength="32" size="34" autocomplete="off" /><span class="input-must">*</span>
					</div>
				</div>
				<div class="control-group formSep">
					<label class="control-label" for="pwd_confirm">{t}确认密码：{/t}</label>
					<div class="controls">
						<input class="input-xlarge" type="password" name="pwd_confirm" id="pwd_confirm" maxlength="32" size="34" autocomplete="off" /><span class="input-must">*</span>
					</div>
				</div>
				<!-- {/if} -->
				<!-- {if $action neq "add"} -->
				<div class="control-group{if $no_oldpwd} hide{/if}">
					<label class="control-label" for="old_password">{t}旧密码：{/t}</label>
					<div class="controls">
						<div class="sepH_b">
							<input class="input-xlarge" name="old_password" type="password" id="old_password" size="34" autocomplete="off" />
							<span class="help-block" id="passwordNotic">{t}如果要修改密码,请先填写旧密码,如留空,密码保持不变{/t}</span>
						</div>
					</div>
				</div>
				<div class="control-group formSep{if !$no_oldpwd} hide{/if}" id="change-password">
					<label class="control-label" for="new_password">{t}新密码：{/t}</label>
					<div class="controls">
						<div class="sepH_b">
							<input class="input-xlarge" name="new_password" type="password" id="new_password" maxlength="32" size="34" autocomplete="off" />
						</div>
					</div>
				</div>
                <div class="control-group formSep{if !$no_oldpwd} hide{/if}">
                    <label class="control-label">{t}确认密码：{/t}</label>
                    <div class="controls">
                        <div class="sepH_b">
                            <input class="input-xlarge" name="pwd_confirm" type="password" id="s_password_re" value="" size="34" autocomplete="off" />
                        </div>
                         </div>
                </div>
				<!-- {if $user.agency_name} -->
				<div class="control-group">
					<label class="control-label" for="user_name">{t}负责的办事处：{/t}</label>
					<div class="controls">{$user.agency_name}</div>
				</div>
				<!-- {/if} -->
				<!-- {/if} -->

				<!-- {if $select_role} -->
				<div class="control-group">
					<label class="control-label" for="select_role">{t}角色选择：{/t}</label>
					<div class="controls">
						<select class="input-xlarge" name="select_role" id="select_role" style="width:285px;">
							<option value="">{t}请选择...{/t}</option>
							<!-- {foreach from=$select_role.list item=list} -->
							<option value="{$list.role_id}" {if $list.role_id eq $user.role_id} selected="selected" {/if} >{$list.role_name}</option>
							<!-- {/foreach} -->
						</select>
					</div>
				</div>
				<!-- {/if} -->
				<div class="control-group">
					<div class="controls">
						<button class="btn btn-gebo" type="submit">{t}保存{/t}</button>
						<input type="hidden" name="id" value="{$user.user_id}" />
					</div>
				</div>
			</fieldset>
		</div>
	</div>
</form>
<!-- {/block} -->
