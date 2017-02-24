<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.subscribe_message.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<!-- {if $errormsg} -->
	    <div class="alert alert-error">
            <strong>{lang key='wechat::wechat.label_notice'}</strong>{$errormsg}
        </div>
	<!-- {/if} -->

<!-- {if $warn} -->
	<!-- {if $type eq 0} -->
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
			<div class="foldable-list move-mod-group">
				<div class="accordion-group">
					<div class="chat_heading clearfix">
					<strong>{lang key='wechat::wechat.user_info'}</strong>
					</div>
					<div class="accordion-body in collapse">
						<div class="accordion-inner ecjiaf-border">
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
											<span class="remark_info p_r5">{$info.remark}</span>
										{/if}
										{if $info['group_id'] neq 1 && $info['subscribe'] neq 0}
										<a class="edit_remark_icon" href="javascript:;"><i class="fontello-icon-edit"></i></a>
										{/if}
										<span class="remark" style="display:none;"><input class="remark w100" type="text" name="remark" value="{$info.remark}" maxlength="30"><a class="edit_remark_url" href="javascript:;" data-page="{$smarty.get.page}" data-remark="{$info.remark}" data-uid="{$info.uid}" data-openid="{$info.openid}" data-url="{RC_Uri::url('wechat/admin_subscribe/edit_remark')}"><i class="fontello-icon-ok remark_ok"></i><i class="fontello-icon-cancel remark_cancel"></i></a></span>
									</span>
								</div>
							</div>
							
							<div class="control-group control-group-small formSep">
								<label class="label-title">{lang key='wechat::wechat.lable_sex'}</label>
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
								<label class="label-title">{lang key='wechat::wechat.label_user_tag'}</label>
								<div class="controls l_h30">
									<span class="p_l10">{if $info['group_id'] eq 1}{else}{if $info['tag_name']}{$info['tag_name']}{else}{lang key='wechat::wechat.no_tag'}{/if}{/if}</span>
									<!-- {if $info.group_id neq 1 && $info.subscribe neq 0} -->
									<a class="set-label-btn" data-openid="{$info.openid}" data-uid="{$info.uid}" data-url="{$get_checked}" href="javascript:;"><i class="fontello-icon-tags"></i></a>
									<!-- {/if} -->
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
							
							<div class="control-group control-group-small">
								<label class="label-title"></label>
								<div class="controls">
									<!-- {if $info.group_id eq 1} -->
									<a class="ajaxremove no-underline btn m_t14" data-toggle="ajaxremove" data-msg="{lang key='wechat::wechat.remove_blacklist_confirm'}" href='{RC_Uri::url("wechat/admin_subscribe/backlist","uid={$info.uid}&openid={$info.openid}&type=remove_out&page={$smarty.get.page}")}' title="{lang key='wechat::wechat.remove_blacklist'}">{lang key='wechat::wechat.remove_blacklist'}</a>
									<!-- {else} -->
										<!-- {if $info.subscribe eq 0} -->
										<a class="btn m_t14" disabled>{lang key='wechat::wechat.add_blacklist'}</a>
										<!-- {else} -->
										<a class="ajaxremove no-underline btn m_t14" data-toggle="ajaxremove" data-msg="{lang key='wechat::wechat.add_blacklist_confirm'}" href='{RC_Uri::url("wechat/admin_subscribe/backlist","uid={$info.uid}&openid={$info.openid}&page={$smarty.get.page}")}' title="{lang key='wechat::wechat.add_blacklist'}">{lang key='wechat::wechat.add_blacklist'}</a>
										<!-- {/if} -->
									<!-- {/if} -->
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal hide fade" id="set_label">
	<div class="modal-header">
		<button class="close" data-dismiss="modal">×</button>
		<h3>{lang key='wechat::wechat.set_tag'}</h3>
	</div>
	<div class="modal-body tag_popover">
		<form class="form-inline" method="post" action="{$label_action}&action=set_user_label" name="label_form">
			<div class="popover_inner">
				<div class="popover_content">
					<div class="popover_tag_list">
						<!-- {foreach from=$group_list.item item=val} -->
						<label class="frm_checkbox_label">
							{if $val.group_id neq 1}
							<input type="checkbox" class="frm_checkbox" name="group_id[]" value="{$val.group_id}">
							<span class="lbl_content">{$val.name}</span>
							{/if}
						</label>
						<!-- {/foreach} -->
					</div>
					<span class="help-block m_b5">{lang key='wechat::wechat.up_tag_count'}</span>
				</div>
				<input type="hidden" name="openid" />
				<input type="hidden" name="uid" />
				<div class="popover_bar"><a href="javascript:;" class="btn btn-gebo set_label" {if $errormsg}disabled{/if}>{lang key='wechat::wechat.ok'}</a>&nbsp;</div>
	   		</div>
	   	</form>
	</div>
</div>
<!-- {/block} -->