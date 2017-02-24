<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.message_list.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
	</h3>
</div>

<div class="row-fluid">

	<div class="chat_box" data-url='{url path="@admin_message/insert" args="chat_id={$smarty.get.chat_id}"}'>
		<div class="span8 chat_content">
			<div class="chat_heading clearfix">
				{t}交谈管理员: {/t}<span class="act_users">{if $smarty.get.chat_id eq 0}{t}所有管理员{/t}{else}{$chat_name}{/if}</span>
			</div>

			<div class="msg_window">
				<div class="chat_msg clearfix">
					<div class="chat_msg_heading t_c"><a class="readed_message" href="javascript:;" data-id="{$smarty.session.admin_id}" data-chatid="{$smarty.get.chat_id}" data-lastid="{$message_lastid}" data-href="{url path='@admin_message/readed_message'}">{t}查看更早的留言信息{/t}</a></div>
				</div>
				<!-- {foreach from=$message_list item=msg} -->
				<div class="chat_msg clearfix{if $msg.sender_id eq $smarty.session.admin_id} chat-msg-mine{else} chat-msg-other{/if}">
					<div class="chat_msg_heading"><span class="chat_msg_date">{$msg.sent_time}</span><span class="chat_user_name">{$msg.user_name}</span></div>
					<div class="chat_msg_body">{$msg.message}</div>
				</div>
				<!-- {/foreach} -->
				<div class="chat_msg clearfix chat-msg-mine msg_clone" style="display:none">
					<div class="chat_msg_heading"><span class="chat_msg_date"></span><span class="chat_user_name"></span></div>
					<div class="chat_msg_body"></div>
				</div>

			</div>

			<div class="chat_editor_box">
				<textarea class="span12" name="chat_editor" id="chat_editor" cols="30" rows="3"></textarea>
				<div class="btn-group send_btns">
					<a class="btn btn-mini btn-info send_msg" href="javascript:;">{t}发送{/t}</a>
				</div>

				<input type="hidden" name="chat_user" id="chat_user" value="{$smarty.session.admin_name}" />
			</div>
		</div>

		<div class="span4 chat_sidebar">
			<div class="chat_heading clearfix">
				<div class="btn-group pull-right">
					<a class="btn btn-mini ttip_t data-pjax" title="{t}刷新{/t}" href='{url path="@admin_message/init" args="chat_id={$smarty.get.chat_id}"}'><i class="icon-refresh"></i></a>
					<a class="btn btn-mini ttip_t" title="Options" href="javascript:;" disabled ><i class="icon-cog"></i></a>
					<!--  dropdown-toggle data-toggle="dropdown"<ul class="dropdown-menu">
						<li><a href="javascript:;">{t}全部标为已读{/t}</a></li>
						<li><a href="javascript:;">{t}当前留言标为已读{/t}</a></li>
					</ul> -->
				</div>
				{t}管理员列表{/t}
			</div>
			<ul class="chat_user_list">
				<li class="{if $smarty.get.chat_id eq 0} active{/if}"><!-- offline -->
					<a class="data-pjax" href='{url path="@admin_message/init" args="chat_id=0"}'>
						<img src="{RC_Uri::admin_url('statics/images/humanoidsIcon_online.png')}" alt="" width="30" height="30" />
						{t}管理员群聊{/t}
					</a>
				</li>
				<!-- {foreach from=$admin_list item=admin} -->
				<li class="{if $admin.is_online}online{else}offline{/if} {if $admin.user_id eq $smarty.get.chat_id} active{/if}"><!-- offline -->
					<a class="data-pjax" href='{url path="@admin_message/init" args="chat_id={$admin.user_id}"}'>
						<img src="{$admin.icon}" alt="" width="30" height="30" />
						{$admin.user_name} {if $admin.user_id eq $smarty.session.admin_id}<span>(you)</span>{/if}
					</a>
				</li>
				<!-- {/foreach} -->
			</ul>
		</div>
	</div>
</div>
<!-- {/block} -->