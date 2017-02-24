<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.admin_role.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a class="data-pjax btn plus_or_reply" href="{$action_link.href}" id="sticky_a"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>
<div class="row-fluid">
	<div class="span12">
		<form class="form-horizontal" name="theForm" method="post" action='{url path="@admin_role/{$form_act}"}' data-pjaxurl="{$pjaxurl}">
			<fieldset>
				<div class="control-group formSep">
					<label class="control-label" for="user_name">{t}角色名：{/t}</label>
					<div class="controls">
						<input class="input-xlarge span6" type="text" name="user_name" id="user_name" autocomplete="off" maxlength="20" value="{$user.role_name|escape}" size="34"/><span class="input-must">{lang key='system::system.require_field'}</span>
					</div>
				</div>
				<div class="control-group formSep">
					<label class="control-label" for="role_describe">{t}角色描述：{/t}</label>
					<div class="controls">
						<textarea class="input-xlarge span6" name="role_describe" id="role_describe" cols="31" rows="6">{$user.role_describe|escape}</textarea>
					</div>
				</div>
				<div class="row-fluid priv_list">
					<div class="control-group formSep checkall">
						<label class="cuni-checkbox">
							<input name="checkall" data-toggle="selectall" data-children=".checkbox" type="checkbox" value="checkbox" autocomplete="off" />{t}全选{/t}
						</label>
					</div>
					<!-- {foreach from=$priv_group item=group} -->
					<div class="control-group formSep">
						<div class="check">
							<label><input class="checkbox" name="chkGroup" data-toggle="selectall" data-children=".{$group.group_code} .checkbox" type="checkbox" value="checkbox" autocomplete="off" />
								<!-- {$group.group_name} -->
							</label>
						</div>
						<div class="controls {$group.group_code}">
							<!-- {foreach from=$group.group_purview key=priv_key item=list} -->
							<div class="choose">
								<label><input class="checkbox" type="checkbox" name="action_code[]" value="{$list.action_code}" id="{$priv_key}" {if $list.cando eq 1} checked="true" {/if} title="{$list.relevance}" autocomplete="off" />
									<!-- {$list.action_name} -->
								</label>
							</div>
							<!-- {/foreach} -->
						</div>
					</div>
					<!-- {/foreach} -->
				</div>
				<div class="control-group">
					<div class="controls">
						<input class="btn btn-gebo" type="submit" value="{t}确定{/t}" />&nbsp;&nbsp;&nbsp;
						<input class="btn" type="reset" value="{t}重置{/t}" />
						<input type="hidden" name="id" value="{$user.role_id}" />
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</div>
<!-- {/block} -->