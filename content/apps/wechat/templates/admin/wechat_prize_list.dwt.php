<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.prize_list.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<!-- {if $errormsg} -->
	<div class="alert alert-error">
    	<strong>{lang key='wechat::wechat.label_notice'}</strong>{$errormsg}
	</div>
<!-- {/if} -->
	
{platform_account::getAccountSwtichDisplay('wechat')}

<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
	</h3>
</div>

<div class="row-fluid">
	<div class="choost_list f_l">
		<form class="form-inline" method="post" action="{$form_action}" name="form">
			<select name="activity_type">
				<option value="">{lang key='wechat::wechat.select_activity_type'}</option>
				<option value="mp_zjd" {if $smarty.get.type eq 'mp_zjd'}selected="selected"{/if}>{lang key='wechat::wechat.smash_egg'}</option>
				<option value="mp_dzp" {if $smarty.get.type eq 'mp_dzp'}selected="selected"{/if}>{lang key='wechat::wechat.big_dial'}</option>
				<option value="mp_ggl" {if $smarty.get.type eq 'mp_ggl'}selected="selected"{/if}>{lang key='wechat::wechat.scratch_off'}</option>
			</select>
			<input type="button" value="{lang key='wechat::wechat.filtrate'}" class="btn m_l5 screen-btn">
		</form>
	</div>
</div>

<div class="row-fluid list-page">
	<table class="table table-striped smpl_tbl table-hide-edit">
		<thead>
			<tr>
				<th class="w150">{lang key='wechat::wechat.weixin_alias'}</th>
				<th class="w150">{lang key='wechat::wechat.prize'}</th>
				<th class="w150">{lang key='wechat::wechat.prize_user_info'}</th>
				<th class="w100">{lang key='wechat::wechat.sure_grant'}</th>
				<th class="w100">{lang key='wechat::wechat.prize_time'}</th>
			</tr>
		</thead>
		<tbody>
			<!-- {foreach from=$list.prize_list item=val} -->
			<tr>							
				<td class="hide-edit-area hide_edit_area_bottom"> 
			    	<span>{$val.nickname}</span>
			    	<div class="edit-list">
			    		<a class="send_message" data-toggle="modal" href="#send_message" data-nickname="{$val.nickname}" data-uid="{$val.uid}" data-openid="{$val.openid}" title="{lang key='wechat::wechat.inform_user'}">{lang key='wechat::wechat.inform_user'}</a>&nbsp;|&nbsp;
			        	<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg="{t}您确定要删除该获奖名单[{$val.nickname}]吗？{/t}" href='{RC_Uri::url("wechat/admin_prize/remove","id={$val.id}")}' title="{lang key='wechat::wechat.delete'}">{lang key='wechat::wechat.delete'}</a>
					</div>
			    </td>
				<td>{$val.prize_name}</td>
				<td>{if is_array($val['winner'])}{lang key='wechat::wechat.lable_name'}{$val['winner']['name']}<br />{lang key='wechat::wechat.lable_mobile'}{$val['winner']['phone']}<br />{lang key='wechat::wechat.lable_address'}{$val['winner']['address']}{/if}</td>
				<td>
					{if $val['issue_status'] eq 1}
			    	<a class="ajaxissue" href='{RC_Uri::url("wechat/admin_prize/winner_issue","id={$val.id}&cancel=1{if $smarty.get.type}&type={$smarty.get.type}{/if}")}'><i class="fontello-icon-ok"></i></a>
			    	{else}
			    	<a class="ajaxissue" href='{RC_Uri::url("wechat/admin_prize/winner_issue","id={$val.id}{if $smarty.get.type}&type={$smarty.get.type}{/if}")}'><i class="fontello-icon-cancel"></i></a>
			    	{/if}
				</td>
				<td>{$val.dateline}</td>
			</tr>
			<!--  {foreachelse} -->
			<tr><td class="no-records" colspan="5">{lang key='system::system.no_records'}</td></tr>
			<!-- {/foreach} -->
		</tbody>
	</table>
	<!-- {$list.page} -->
</div>

<div class="modal hide fade" id="send_message">
    <div class="modal-header">
        <button class="close" data-dismiss="modal">×</button>
        <h3>{lang key='wechat::wechat.inform_user'}</h3>
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
                <form class="form-horizontal" method="post" name="the_form" action="{url path='wechat/admin_prize/send_message'}">
                    <fieldset>
                        <div class="control-group formSep">
                            <label class="control-label">{lang key='wechat::wechat.label_message_content'}</label>
                            <div class="controls">
                                <textarea name="message_content"></textarea>
                                <span class="input-must">*</span>
                                <span class="help-block">{lang key='wechat::wechat.tip_info'}</span>
                            </div>
                        </div>    
                        
                        <div class="control-group formSep">
                            <label class="control-label">{lang key='wechat::wechat.label_nickname'}</label>
                            <div class="controls nickname">
                            </div>
                        </div>
                        
                        <div class="control-group formSep">
                            <label class="control-label">{lang key='wechat::wechat.weixin_only_identification'}</label>
                            <div class="controls openid">
                            </div>
                        </div>

                        <div class="control-group t_c m_b0">
                            <button class="btn btn-gebo" type="submit" {if $errormsg}disabled{/if}>{lang key='wechat::wechat.ok'}</button>
                            <input type="hidden" name="wechat_type" value="{$type}">
                            <input type="hidden" name="uid"/>
                            <input type="hidden" name="openid"/>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- {/block} -->