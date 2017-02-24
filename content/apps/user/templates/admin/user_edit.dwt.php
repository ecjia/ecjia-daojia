<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.user_edit.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a href="{$action_link.href}" class="btn plus_or_reply data-pjax" ><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>	
</div>	

<!-- 表单开始  -->
<form id="form-privilege"  class="form-horizontal {$form_act}"  name="theForm" action="{$form_action}" method="post" data-edit-url="{url path='user/admin/edit'}" >
	<fieldset>
		<div class="row-fluid edit-page editpage-rightbar">
			<div class="left-bar">
				<div class="control-group formSep">
					<label class="control-label">{lang key='user::users.user_names'}</label>
					<div class="controls l_h30">
						{if $action eq 'edit'}
						{$user.user_name}
						<input type="hidden" name="username" value="{$user.user_name}" />
						{else}
						<input class="w350" type="text" name="username"  value="{$user.user_name}" />
						<span class="input-must">{lang key='system::system.require_field'}</span>
						{/if}
					</div>
				</div>

				<div class="control-group formSep">
					<label class="control-label">{lang key='user::users.label_email'}</label>
					<div class="controls">
						<input class="w350" type="text" name="email" value="{$user.email}" />
						<span class="input-must">{lang key='system::system.require_field'}</span>
					</div>
				</div>
				<!-- {if $form_act eq "insert"} -->
				<div class="control-group formSep">
					<label class="control-label">{lang key='user::users.label_password'}</label>
					<div class="controls">
						<input class="w350" type="password" name="password" id="password"/>
						<span class="input-must">{lang key='system::system.require_field'}</span>
					</div>
				</div>
				<!-- {elseif  $form_act eq "update"} -->
				<div class="control-group formSep">
					<label class="control-label">{lang key='user::users.label_newpass'}</label>
					<div class="controls">
						<input class="w350" name="newpassword" type="password" id="newpassword"/>
						<span class="input-must">{lang key='system::system.require_field'}</span>
					</div>
				</div>
				<!-- {/if} -->
				<div class="control-group formSep">
					<label class="control-label">{lang key='user::users.label_confirm_password'}</label>
					<div class="controls">
						<input class="w350" type="password" name="confirm_password" />
						<span class="input-must">{lang key='system::system.require_field'}</span>
					</div>
				</div>
				<div class="control-group formSep">
					<label class="control-label">{lang key='user::users.label_user_rank'}</label>
					<div class="controls">
						<select class="w350" name="user_rank">
							<option value="0">{lang key='user::users.not_special_rank'}</option>
							<!-- {html_options options=$special_ranks selected=$user.user_rank} -->
						</select>
					</div>
				</div>

				<div class="control-group">
					<div class="controls">
						<button class="btn btn-gebo" type="submit">{lang key='system::system.button_submit'}</button>
						<input type="hidden" name="id" value="{$user.user_id}" />  
					</div>
				</div>
			</div>
			<div class="right-bar move-mod">
				<div class="foldable-list move-mod-group">
					<div class="accordion-group">
						<div class="accordion-heading">
							<a class="accordion-toggle acc-in move-mod-head" data-toggle="collapse" data-target="#telescopic1"><strong>{lang key='user::users.member_basic_information'}</strong></a>
						</div>
						<div class="accordion-body in collapse" id="telescopic1">
							<div class="accordion-inner">
								<div class="control-group control-group-small">
									<label class="control-label">{lang key='user::users.label_gender'}</label>
									<div class="span8 chk_radio">
										<!-- {foreach from=$lang_sex item=sex key=key} -->
										<input type="radio" name="sex" value="{$key}" {if $key eq $user.sex}checked="checked"{/if} /><span>{$sex}</span>
										<!-- {/foreach} -->
									</div>
								</div>
								<div class="control-group control-group-small">
									<label class="control-label">{lang key='user::users.label_birthday'}</label>
									<div class="span8 chk_radio">
										<input name="birthday" class="date" type="text" value="{if $user.birthday eq 0 }{else}{$user.birthday}{/if}" placeholder="{lang key='user::users.select_date'}">
									</div>
								</div>
								<div class="control-group control-group-small">
									<label class="control-label">{lang key='user::users.label_credit_line'}</label>
									<div class="span8">
										<input name="credit_line" type="text" value="{$user.credit_line}"  />
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<!-- {if $extend_info_list} -->
				<div class="foldable-list move-mod-group">
					<div class="accordion-group">
						<div class="accordion-heading">
							<a class="accordion-toggle acc-in move-mod-head" data-target="#collapseTwo" data-toggle="collapse"><strong>{lang key='user::users.membership_details'}</strong></a>
						</div>
						<div class="accordion-body in collapse" id="collapseTwo">
							<div class="accordion-inner">
								<!-- {foreach from=$extend_info_list item=field} -->
								<div class="control-group control-group-small">
									<label class="control-label">{$field.reg_field_name}：</label>
									<div class="span8">
										<input name="extend_field{$field.id}" type="text" value="{$field.content}"  />
									</div>
								</div>
								<!-- {/foreach} -->
							</div>
						</div>
					</div>
				</div>
				<!-- {/if} -->
			</div>
		</div>
	</fieldset>
</form>
<!-- {/block} -->