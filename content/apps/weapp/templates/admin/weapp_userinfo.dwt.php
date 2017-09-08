<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->
<!-- {block name="footer"} -->

<script type="text/javascript">
	ecjia.admin.weapp.init();
</script>

<!-- {/block} -->

<!-- {block name="main_content"} -->

<!-- {if $errormsg} -->
	    <div class="alert alert-error">
            <strong>{lang key='wechat::wechat.label_notice'}</strong>{$errormsg}
        </div>
<!-- {/if} -->

<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a class="data-pjax btn plus_or_reply" id="sticky_a" href="{$action_link.href}"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>
<div class="row-fluid">
	<div class="span12">
		<form class="form-horizontal" id="form-privilege" name="theForm" action="{$form_action}" method="post" enctype="multipart/form-data" >
			<fieldset>
				<div class="control-group formSep">
					<label class="control-label">{t}用户头像：{/t}</label>
					<div class="controls thumbnail-new">
						{if $info['headimgurl']}
							<img class="thumbnail" src="{$info.headimgurl}" alt="{$info.nickname}"/>
						{else}
							<img class="thumbnail" src="{RC_Uri::admin_url('statics/images/nopic.png')}">
						{/if}
					</div>
				</div>
				<div class="control-group formSep">
					<label class="control-label">{t}昵称：{/t}</label>
					<div class="controls l_h30">
						<span class="p_l10">{$info.nickname}</span>
					</div>
				</div>
				<div class="control-group formSep">
					<label class="control-label">{t}备注名：{/t}</label>
					<div class="controls l_h30">
						<span class="p_l10">
							{if $info.remark}
								<span class="remark_info p_r5">{$info.remark}</span>
							{/if}
							{if ($info.group_id neq 1) && ($info.subscribe neq 0)}
								<a class="edit_remark_icon" href="javascript:;"><i class="fontello-icon-edit"></i></a>
							{/if}
							<span class="remark" style="display:none;"><input class="remark w100" type="text" name="remark" value="{$info.remark}" maxlength="30"><a class="edit_remark_url" href="javascript:;" data-page="{$smarty.get.page}" data-remark="{$info.remark}" data-uid="{$info.uid}" data-openid="{$info.openid}" data-url="{RC_Uri::url('weapp/admin/edit_remark')}"><i class="fontello-icon-ok remark_ok"></i><i class="fontello-icon-cancel remark_cancel"></i></a></span>
						</span>
					</div>
				</div>
				<div class="control-group formSep">
					<label class="control-label">{t}性别：{/t}</label>
					<div class="controls l_h30">
						<span class="p_l10">{if $info.sex == 1}{lang key='weapp::weapp.male'}{else if $info.sex == 2}{lang key='weapp::weapp.female'}{/if}</span>
					</div>
				</div>
				<div class="control-group formSep">
					<label class="control-label">{t}省市：{/t}</label>
					<div class="controls l_h30">
						<span class="p_l10">{$info.province} - {$info.city}</span>
					</div>
				</div>
				<div class="control-group formSep">
					<label class="control-label">{t}用户标签：{/t}</label>
					<div class="controls l_h30">
						<span class="p_l10">{if $info.group_id eq 1}{else}{if $info.tag_name}{$info.tag_name}{else}{lang key='weapp::weapp.no_tag'}{/if}{/if}</span>
						<!-- {if $info.group_id neq 1 && $info.subscribe neq 0} -->
						<a class="set-label-btn" data-openid="{$info.openid}" data-uid="{$info.uid}" data-url="{$get_checked}" href="javascript:;"><i class="fontello-icon-tags"></i></a>
						<!-- {/if} -->
					</div>
				</div>
				<div class="control-group formSep">
					<label class="control-label">{t}关注时间：{/t}</label>
					<div class="controls l_h30">
						<span class="p_l10">{$info.subscribe_time}</span>
					</div>
				</div>
				<div class="control-group formSep">
					<label class="control-label">{t}绑定用户：{/t}</label>
					<div class="controls l_h30">
						<span class="p_l10">{if $info.user_name}{$info.user_name}{else}{lang key='weapp::weapp.not_bind_yet'}{/if}</span>
					</div>
				</div>
				<div class="control-group">
					<label class="label-title"></label>
					<div class="controls l_h30">
						<!-- {if $info.group_id eq 1} -->
						<a class="ajaxremove no-underline btn m_t14" data-toggle="ajaxremove" data-msg="{lang key='weapp::weapp.remove_blacklist_confirm'}" href='{RC_Uri::url("weapp/admin/backlist","uid={$info.uid}&openid={$info.openid}&type=remove_out&page={$smarty.get.page}")}' title="{lang key='weapp::weapp.remove_blacklist'}">{lang key='weapp::weapp.remove_blacklist'}</a>
						<!-- {else} -->
							<!-- {if $info.subscribe eq 0} -->
							<a class="btn m_t14" disabled>{lang key='weapp::weapp.add_blacklist'}</a>
							<!-- {else} -->
							<a class="ajaxremove no-underline btn m_t14" data-toggle="ajaxremove" data-msg="{lang key='weapp::weapp.add_blacklist_confirm'}" href='{RC_Uri::url("weapp/admin/backlist","uid={$info.uid}&openid={$info.openid}&page={$smarty.get.page}")}' title="{lang key='weapp::weapp.add_blacklist'}">{lang key='weapp::weapp.add_blacklist'}</a>
							<!-- {/if} -->
						<!-- {/if} -->
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</div>

<div class="modal hide fade" id="set_label">
	<div class="modal-header">
		<button class="close" data-dismiss="modal">×</button>
		<h3>{lang key='weapp::weapp.set_tag'}</h3>
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
					<span class="help-block m_b5">{lang key='weapp::weapp.up_tag_count'}</span>
				</div>
				<input type="hidden" name="openid" />
				<input type="hidden" name="uid" />
				<div class="popover_bar"><a href="javascript:;" class="btn btn-gebo set_label" {if $errormsg}disabled{/if}>{lang key='weapp::weapp.ok'}</a>&nbsp;</div>
	   		</div>
	   	</form>
	</div>
</div>
<!-- {/block} -->