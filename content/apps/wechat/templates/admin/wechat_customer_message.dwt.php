<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.wechat_customer.init();
</script>
<!-- {/block} -->
<!-- {block name="main_content"} -->
<!-- {if $errormsg} -->
	<div class="alert alert-error">
		<strong>{lang key='wechat::wechat.label_notice'}</strong>{$errormsg}
	</div>
<!-- {/if} -->

<!-- {if $warn} -->
	<!-- {if $type neq 2} -->
		<div class="alert alert-error">
			<strong>{lang key='wechat::wechat.label_notice'}</strong>{$type_error}
		</div>
	<!-- {/if} -->
<!-- {/if} -->	

<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		{if $action_link}
		<a class="btn plus_or_reply data-pjax" href="{$action_link.href}" id="sticky_a"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		{/if}
	</h3>
</div>
	
<div class="row-fluid">
	<div class="chat_box table table-hide-edit" data-url='{$chat_action}'>
		<div class="span8 chat_content h600">
			<div class="chat_heading clearfix">
				{lang key='wechat::wechat.label_chat_user'}<span class="act_users">{$info.nickname}</span>
			</div>

			<div class="msg_window">
				<div class="chat_msg clearfix">
					<div class="chat_msg_heading t_c"><a class="readed_message" href="javascript:;" data-chatid="{$info.uid}" data-lastid="{$message.last_id}" data-href="{$last_action}">{lang key='wechat::wechat.view_readed_message'}</a></div>
				</div>
				<!-- {foreach from=$message.item item=msg} -->
				<div class="chat_msg clearfix{if $msg.iswechat eq 1} chat-msg-mine{else} chat-msg-you{/if} last_chat">
					<div class="chat_msg_heading"><span class="chat_msg_date">{$msg.send_time}</span><span class="chat_user_name">{$msg.nickname}</span></div>
					<div class="chat_msg_body">{$msg.msg}</div>
				</div>
				<!-- {/foreach} -->
				<div class="chat_msg clearfix chat-msg-mine msg_clone" style="display:none">
					<div class="chat_msg_heading"><span class="chat_msg_date"></span><span class="chat_user_name"></span></div>
					<div class="chat_msg_body"></div>
				</div>
			</div>

			<div class="chat_editor_box">
				<textarea class="span12" name="chat_editor" id="chat_editor" cols="30" rows="3" maxlength="600"></textarea>
				<div class="btn-group send_btns">
					<a class="btn btn-mini btn-info {if !$disabled}send_msg{/if}" {if $disabled}disabled="disabled"{/if} href="javascript:;">{lang key='wechat::wechat.send_msg'}</a>
				</div>
				<span class="tip_info">{lang key='wechat::wechat.tip_info'}</span>
				<span class="word_info">{lang key='wechat::wechat.word_info'}</span>
				<input type="hidden" name="chat_user" id="chat_user" value="{$info.uid}" />
				<input type="hidden" name="openid" id="openid" value="{$info.openid}" />
				<input type="hidden" name="nickname" id="nickname" value="{$info.nickname}" />
				<input type="hidden" name="platform_name" id="platform_name" value="{$info.platform_name}" />
			</div>
		</div>
		
		<div class="span4 right-bar move-mod">
			<div class="foldable-list move-mod-group" id="goods_info_sort_submit">
				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle collapsed move-mod-head" data-toggle="collapse" data-target="#customer_info">
							<strong>{lang key='wechat::wechat.user_info'}</strong>
						</a>
					</div>
					<div class="accordion-body in collapse" id="customer_info">
						<div class="accordion-inner">
							<div class="control-group control-group-small formSep">
								<label class="label-title">{lang key='wechat::wechat.label_user_headimgurl'}</label>
								<div class="controls big m_l100">
									{if $info['headimgurl']}
										<img class="thumbnail" src="{$info['headimgurl']}" alt="{$info['nickname']}"/>
									{else}
										<img class="thumbnail" src="{RC_Uri::admin_url('statics/images/nopic.png')}">
									{/if}
								</div>
							</div>
							
							<div class="control-group control-group-small formSep">
								<label class="label-title">{lang key='wechat::wechat.label_nickname'}</label>
								<div class="controls l_h30">
									<span class="p_l10">{$info.nickname}</span>
								</div>
							</div>
							
							<div class="control-group control-group-small formSep">
								<label class="label-title">{lang key='wechat::wechat.label_remark'}</label>
								<div class="controls l_h30">
									<span class="p_l10">
										{if $info.remark}
											<span class="remark_info p_r5">{$info.remark}</span><a class="edit_remark_icon" href="javascript:;"><i class="fontello-icon-edit"></i></a>
										{else}
											<a class="edit_remark_icon" href="javascript:;"><i class="fontello-icon-edit"></i></a>
										{/if}
										<span class="remark" style="display:none;"><input class="remark w100" type="text" name="remark" value="{$info.remark}" maxlength="30"><a class="edit_remark_url" href="javascript:;" data-page="{$smarty.get.page}" data-remark="{$info.remark}" data-uid="{$info.uid}" data-openid="{$info.openid}" data-url="{RC_Uri::url('wechat/admin_subscribe/edit_remark')}"><i class="fontello-icon-ok remark_ok"></i><i class="fontello-icon-cancel remark_cancel"></i></a></span>
									</span>
								</div>
							</div>
							
							<div class="control-group control-group-small formSep">
								<label class="label-title">{lang key='wechat::wechat.label_sex'}</label>
								<div class="controls l_h30">
									<span class="p_l10">{if $info['sex'] == 1}{lang key='wechat::wechat.male'}{else if $info.sex == 2}{lang key='wechat::wechat.female'}{/if}</span>
								</div>
							</div>
							
							<div class="control-group control-group-small formSep">
								<label class="label-title">{lang key='wechat::wechat.label_province'}</label>
								<div class="controls l_h30">
									<span class="p_l10">{$info['province']} - {$info['city']}</span>
								</div>
							</div>
							
							<div class="control-group control-group-small formSep">
								<label class="label-title">{lang key='wechat::wechat.label_user_group'}</label>
								<div class="controls l_h30">
									<span class="p_l10">
										<!-- {foreach from=$group_list item=val} -->
											<!-- {if $val.group_id eq $info.group_id} -->
												<span class="group_info p_r5">{$val.name}</span>
											<!-- {/if} -->
										<!-- {/foreach} -->
										<a class="edit_group_icon" href="javascript:;"><i class="fontello-icon-edit"></i></a>
										<span class="group" style="display:none;">
											<select name="group_id" class="w120">
											<!-- {foreach from=$group_list item=val} -->
												<option value="{$val.group_id}" {if $val.group_id eq $info.group_id}selected="selected"{/if}>{$val.name}</option>
											<!-- {/foreach} -->
											</select>
											<a class="edit_group_url" href="javascript:;" data-page="{$smarty.get.page}" data-group-id="{$info.group_id}" data-uid="{$info.uid}" data-openid="{$info.openid}" data-nickname="{$info.nickname}" data-url="{RC_Uri::url('wechat/admin_subscribe/edit_customer_group')}">
												<i class="fontello-icon-ok group_ok"></i><i class="fontello-icon-cancel group_cancel"></i>
											</a>
										</span>
									</span>
								</div>
							</div>
							
							<div class="control-group control-group-small formSep">
								<label class="label-title">{lang key='wechat::wechat.label_subscribe_time'}</label>
								<div class="controls l_h30">
									<span class="p_l10">{$info['subscribe_time']}</span>
								</div>
							</div>
							
							<div class="control-group control-group-small formSep">
								<label class="label-title">{lang key='wechat::wechat.label_bind_user'}</label>
								<div class="controls l_h30">
									<span class="p_l10">{if $info['user_name']}{$info['user_name']}{else}{lang key='wechat::wechat.not_bind_yet'}{/if}</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- {/block} -->