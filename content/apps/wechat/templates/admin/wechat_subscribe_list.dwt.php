<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.admin_subscribe.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<!-- {if $unionid eq 1} -->
<div class="alert alert-warning">
	<a class="close" data-dismiss="alert">×</a>
	<strong>{lang key='wechat::wechat.label_notice'}</strong>{lang key='wechat::wechat.unionid_error_info'}
</div>
<!-- {/if} -->
	
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
	
{platform_account::getAccountSwtichDisplay('wechat')}
    
<div>
	<h3 class="heading">
	{lang key='wechat::wechat.user_manage_synchro'}
	</h3>
</div>
	
<div style="margin-left: 20px;">
	<div><button type="button" class="ajaxmenu btn" data-url='{RC_Uri::url("wechat/admin_subscribe/get_usertag")}' data-value="get_usertag">{lang key='wechat::wechat.get_user_tag'}</button><span style="margin-left: 20px;">{lang key='wechat::wechat.get_user_tag_notice'}</span></div><br/>
	<div><button type="button" class="ajaxmenu btn" data-url='{RC_Uri::url("wechat/admin_subscribe/get_userinfo")}' data-value="get_userinfo">{lang key='wechat::wechat.get_user_info'}</button><span style="margin-left: 20px;">{lang key='wechat::wechat.get_user_info_notice'}</span></div><br/>
</div>
	
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
	</h3>
</div>

<div class="row-fluid">
	<!-- {if $smarty.get.type neq 'unsubscribe' && $smarty.get.type neq 'blacklist'} -->
	<a class="set-label-btn btn" data-url="{$get_checked}"><i class="fontello-icon-tags"></i>{lang key='wechat::wechat.set_tag'}</a>
	<!-- {/if} -->
	<div class="choost_list f_r">
		<form class="form-inline" method="post" action="{$form_action}{if $smarty.get.type}&type={$smarty.get.type}{/if}" name="search_from">
			<input class="w180" type="text" name="keywords" value="{$smarty.get.keywords}" placeholder="{lang key='wechat::wechat.search_user_placeholder'}"/>
			<input type="submit" value="{lang key='wechat::wechat.search'}" class="btn search-btn">
		</form>
	</div>
</div>
	
<div class="row-fluid list-page chat_box">
	<div class="span9 chat_content">	
		<table class="table table-striped smpl_tbl table-hide-edit subscribe_group_table">
			<thead>
				<tr>
					<th class="table_checkbox w30"><input type="checkbox" data-toggle="selectall" data-children=".checkbox"/></th>
					<th class="w80">{lang key='wechat::wechat.headimg_url'}</th>
					<th class="w150">{lang key='wechat::wechat.nickname'}</th>
					<th class="w100">{lang key='wechat::wechat.province'}</th>
					<th class="w80">{lang key='wechat::wechat.subscribe_time'}</th>
					<th class="w100">{lang key='wechat::wechat.bind_user'}</th>
				</tr>
			</thead>
			<tbody>
				<!-- {foreach from=$list.item item=val} -->
				<tr class="big">
					<td><input class="checkbox" type="checkbox" name="checkboxes[]" value="{$val.openid}" /></td>
					<td>
						{if $val.headimgurl}
						<img class="thumbnail" src="{$val.headimgurl}">
						{else}
						<img class="thumbnail" src="{RC_Uri::admin_url('statics/images/nopic.png')}">
						{/if}
					</td>
					<td class="hide-edit-area">
						<span class="ecjaf-pre">
							{$val['nickname']}{if $val['sex'] == 1}{lang key='wechat::wechat.male_sign'}{else if $val.sex == 2}{lang key='wechat::wechat.female_sign'}{/if}<br/>{if $val.group_id eq 1 || $val.subscribe eq 0}{else}{if $val.tag_name eq ''}{lang key='wechat::wechat.no_tag'}{else}{$val.tag_name}{/if}{/if}<br>
							{$val.remark}
						</span>
						<div class="edit-list">
							<!-- {if $val.group_id neq 1 && $val.subscribe neq 0} -->
								<a class="set-label-btn cursor_pointer" data-openid="{$val.openid}" data-uid="{$val.uid}" data-url="{$get_checked}">{lang key='wechat::wechat.set_tag'}</a>&nbsp;|&nbsp;
							<!-- {/if} -->
							<a class="data-pjax" href='{url path="wechat/admin_subscribe/subscribe_message" args="uid={$val.uid}{if $smarty.get.page}&page={$smarty.get.page}{/if}"}' title="{lang key='wechat::wechat.message_record'}">{lang key='wechat::wechat.message_record'}</a>
						</div>
					</td>
					<td>{$val['province']} - {$val['city']}</td>
					<td>{RC_Time::local_date('Y-m-d H:i:s', ($val['subscribe_time']-8*3600))}</td>
					<td class="ecjiaf-pre">{if $val['user_name']}{$val['user_name']}{else}{lang key='wechat::wechat.not_bind_yet'}{/if}</td>
				</tr>
				<!--  {foreachelse} -->
				<tr><td class="no-records" colspan="6">{lang key='system::system.no_records'}</td></tr>
				<!-- {/foreach} -->
			</tbody>
		</table>
	</div>
	
	<div class="span3 chat_sidebar">
		<div class="chat_heading clearfix">
			<div class="btn-group pull-right">
				<a class="btn btn-mini ttip_t subscribe-icon-plus" title="{lang key='wechat::wechat.add_user_tag'}" data-toggle="modal" href="#add_tag" ><i class="fontello-icon-plus"></i></a>
			</div>
			{lang key='wechat::wechat.user_tag_list'}
		</div>
		<ul class="chat_user_list">
			<li {if $smarty.get.type eq 'all'}class="active"{/if}>
				<a class="f_l data-pjax no-underline" href='{url path="wechat/admin_subscribe/init" args="&type=all"}'>{lang key='wechat::wechat.all_user'}
					<t class="badge badge-info">{$tag_arr.all}</t>
				</a>
			</li>
			<!-- {if $tag_arr || $num} -->
				<!-- {if $tag_arr} -->
					<!-- {foreach from=$tag_arr.item item=val} -->
					<li class="{if $val.id eq $smarty.get.id}active{/if}">
						<a class="{if $val.tag_id neq 1}second_tag{/if} f_l data-pjax no-underline" href='{url path="wechat/admin_subscribe/init" args="id={$val.id}&tag_id={$val.tag_id}&type=blacklist{if $val.tag_id neq 1}&type=subscribed{/if}"}'>
							{$val.name}
							<t class="badge badge-info">{$val.count}</t>
						</a>
						{if $val['tag_id'] != 0  && $val['tag_id'] != 1 && $val['tag_id'] != 2}
						<span>
							<a class="subscribe-icon-edit" data-toggle="modal" href="#edit_tag" title="{lang key='wechat::wechat.edit_user_tag'}" data-name="{$val.name}" value="{$val.id}"><i class="fontello-icon-edit f_s15"></i></a>
							<a class="ajaxremove no-underline" data-toggle="ajaxremove" data-msg="{lang key='wechat::wechat.remove_tag_confirm'}" href='{RC_Uri::url("wechat/admin_subscribe/remove","id={$val.id}&tag_id={$val.tag_id}")}' title="{lang key='wechat::wechat.remove_user_tag'}"><i class="fontello-icon-trash f_s15 ecjiafc-red"></i></a>
						</span>
						{/if}
					</li>
					<!-- {/foreach} -->
				<!-- {/if} -->
				
				<!-- {if $num} -->
					<li {if $smarty.get.type eq 'unsubscribe' && !$smarty.get.tag_id}class="active"{/if}>
						<a class="f_l data-pjax no-underline" href='{url path="wechat/admin_subscribe/init" args="type=unsubscribe"}'>{lang key='wechat::wechat.cancel_subscribe'}
							<t class="badge badge-info">{$num}</t>
						</a>
					</li>
				<!-- {/if} -->
			<!-- {/if} -->
		</ul>
	</div>
</div> 
<!-- {$list.page} -->

<div class="modal hide fade" id="edit_tag">
	<div class="modal-header">
		<button class="close" data-dismiss="modal">×</button>
		<h3>{lang key='wechat::wechat.edit_user_tag'}</h3>
	</div>
	<div class="modal-body" id="group_modal">
		<div class="row-fluid">
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
			<div class="span12">
			<form class="form-horizontal" method="post" name="edit_tag" action="{url path='wechat/admin_subscribe/edit_tag'}">
				<fieldset>
					<div class="control-group formSep">
						<label class="control-label old_tag_name" for="user_name">{lang key='wechat::wechat.label_old_tag_name'}</label>
						<div class="controls w200 ecjiaf-wwb">
							<span class="old_tag"></span>
						</div>
					</div>	
					<div class="control-group formSep">
						<label class="control-label new_tag_name" for="user_name">{lang key='wechat::wechat.label_new_tag_name'}</label>
						<div class="controls">
							<input type="text" name="new_tag" autocomplete="off"/>
							<span class="input-must">*</span>
						</div>
					</div>
					<div class="control-group t_c m_b0">
						<button class="btn btn-gebo" type="submit" {if $errormsg}disabled{/if}>{lang key='wechat::wechat.ok'}</button>
						<input type="hidden" name="id" />
					</div>
				</fieldset>
			</form>
			</div>
		</div>
	</div>
</div>
	
<div class="modal hide fade" id="add_tag">
	<div class="modal-header">
		<button class="close" data-dismiss="modal">×</button>
		<h3>{lang key='wechat::wechat.add_user_tag'}</h3>
	</div>
	<div class="modal-body" id="group_modal">
		<div class="row-fluid">
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
			<div class="span12">
			<form class="form-horizontal" method="post" name="add_tag" action="{url path='wechat/admin_subscribe/edit_tag'}">
				<fieldset>
					<div class="control-group formSep">
						<label class="control-label new_tag_name" for="user_name">{lang key='wechat::wechat.label_tag_name'}</label>
						<div class="controls">
							<input type="text" name="new_tag" autocomplete="off"/>
							<span class="input-must">*</span>
						</div>
					</div>
					<div class="control-group t_c m_b0">
						<button class="btn btn-gebo" type="submit" {if $errormsg}disabled{/if}>{lang key='wechat::wechat.ok'}</button>
					</div>
				</fieldset>
			</form>
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
		<form class="form-inline" method="post" action="{$label_action}&action=set_label" name="label_form">
			<div class="popover_inner">
				<div class="popover_content">
					<div class="popover_tag_list">
					</div>
					<span class="label_block hide ecjiafc-red">{lang key='wechat::wechat.up_tag_count'}</span>
				</div>
				<input type="hidden" name="openid" />
				<div class="popover_bar"><a href="javascript:;" class="btn btn-gebo set_label" {if $errormsg}disabled{/if}>{lang key='wechat::wechat.ok'}</a>&nbsp;</div>
	   		</div>
	   	</form>
	</div>
</div>
<!-- {/block} -->