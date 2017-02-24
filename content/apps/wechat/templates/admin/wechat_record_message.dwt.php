<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.admin_record.init();
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
			<strong>{lang key='wechat::wechat.label_notice'}</strong>{$type_info}
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
		<div class="span8 chat_content h550">
			<div class="chat_heading clearfix">
				{lang key='wechat::wechat.label_chat_user'}<span class="act_users">{$info.nickname}</span>
			</div>

			<div class="msg_windows">
				<div class="chat_msg clearfix">
					<div class="chat_msg_heading t_c"><a class="readed_message" href="javascript:;" data-chatid="{$info.openid}" data-lastid="{$message.last_id}" data-href="{$last_action}">{lang key='wechat::wechat.view_earlier_message'}</a></div>
				</div>
				<!-- {foreach from=$message.item item=msg} -->
				<div class="chat_msg clearfix{if $msg.opercode eq 2003} chat-msg-mine{else if $msg.opercode eq 2002} chat-msg-you{/if} last_chat">
					<div class="chat_msg_heading"><span class="chat_msg_date">{$msg.time}</span><span class="chat_user_name">{if $msg.opercode eq 2003}{$msg.nickname}{else if $msg.opercode eq 2002}{$msg.kf_account}{/if}</span></div>
					<div class="chat_msg_body">{$msg.text}</div>
				</div>
				<!-- {/foreach} -->
				<div class="chat_msg clearfix chat-msg-mine msg_clone" style="display:none">
					<div class="chat_msg_heading"><span class="chat_msg_date"></span><span class="chat_user_name"></span></div>
					<div class="chat_msg_body"></div>
				</div>
			</div>
		</div>
		
		<div class="span4 right-bar move-mod">
			<div class="foldable-list move-mod-group">
				<div class="accordion-group h550">
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
										<span class="remark_info p_r5">{$info.remark}</span>
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
								<label class="label-title">{lang key='wechat::wechat.lable_user_group'}</label>
								<div class="controls l_h30">
									<span class="p_l10">
										<!-- {foreach from=$group_list item=val} -->
											<!-- {if $val.group_id eq $info.group_id} -->
												<span class="group_info p_r5">{$val.name}</span>
											<!-- {/if} -->
										<!-- {/foreach} -->
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