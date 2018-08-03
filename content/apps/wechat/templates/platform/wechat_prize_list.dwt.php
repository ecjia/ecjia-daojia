<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-platform.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.platform.prize_list.init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->

<!-- {if $errormsg} -->
<div class="alert alert-danger">
	<strong>{lang key='wechat::wechat.label_notice'}</strong>{$errormsg}
</div>
<!-- {/if} -->
	
<div class="row">
    <div class="col-12">
        <div class="card">
			<div class="card-header">
                <h4 class="card-title">{$ur_here}</h4>
            </div>
     		<div class="card-body">
	   			<form class="form-inline" method="post" action="{$form_action}" name="form">
					<select name="activity_type" class="select2 form-control">
						<option value="">{lang key='wechat::wechat.select_activity_type'}</option>
						<option value="mp_zjd" {if $smarty.get.type eq 'mp_zjd'}selected="selected"{/if}>{lang key='wechat::wechat.smash_egg'}</option>
						<option value="mp_dzp" {if $smarty.get.type eq 'mp_dzp'}selected="selected"{/if}>{lang key='wechat::wechat.big_dial'}</option>
						<option value="mp_ggl" {if $smarty.get.type eq 'mp_ggl'}selected="selected"{/if}>{lang key='wechat::wechat.scratch_off'}</option>
					</select>
					<input type="button" value="{lang key='wechat::wechat.filtrate'}" class="btn btn-outline-primary m_l5 screen-btn">
				</form>
			</div>
			
            <div class="col-md-12">
				<table class="table table-hide-edit">
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
						    		<a class="send_message" href="javascript:;" data-nickname="{$val.nickname}" data-uid="{$val.uid}" data-openid="{$val.openid}" title="{lang key='wechat::wechat.inform_user'}">{lang key='wechat::wechat.inform_user'}</a>&nbsp;|&nbsp;
						        	<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg="{t}您确定要删除该获奖名单[{$val.nickname}]吗？{/t}" href='{RC_Uri::url("wechat/platform_prize/remove","id={$val.id}")}' title="{lang key='wechat::wechat.delete'}">{lang key='wechat::wechat.delete'}</a>
								</div>
						    </td>
							<td>{$val.prize_name}</td>
							<td>{if is_array($val['winner'])}{lang key='wechat::wechat.lable_name'}{$val['winner']['name']}<br />{lang key='wechat::wechat.lable_mobile'}{$val['winner']['phone']}<br />{lang key='wechat::wechat.lable_address'}{$val['winner']['address']}{/if}</td>
							<td>
								{if $val['issue_status'] eq 1}
						    	<a class="ajaxissue" href='{RC_Uri::url("wechat/platform_prize/winner_issue","id={$val.id}&cancel=1{if $smarty.get.type}&type={$smarty.get.type}{/if}")}'><i class="fontello-icon-ok"></i></a>
						    	{else}
						    	<a class="ajaxissue" href='{RC_Uri::url("wechat/platform_prize/winner_issue","id={$val.id}{if $smarty.get.type}&type={$smarty.get.type}{/if}")}'><i class="fontello-icon-cancel"></i></a>
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
        </div>
    </div>
</div>

<div class="modal fade text-left" id="send_message">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title">{lang key='wechat::wechat.inform_user'}</h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">×</span>
				</button>
			</div>

			<!-- {if $errormsg} -->
			    <div class="alert alert-danger">
		            <strong>{lang key='wechat::wechat.label_notice'}</strong>{$errormsg}
		        </div>
			<!-- {/if} -->
			
			<!-- {if $warn && $type eq 0} -->
				<div class="alert alert-danger">
					<strong>{lang key='wechat::wechat.label_notice'}</strong>{$type_error}
				</div>
			<!-- {/if} -->

			<form class="form" method="post" name="the_form" action="{url path='wechat/platform_prize/send_message'}">
				<div class="card-body">
					<div class="form-body">
						<div class="form-group row">
							<label class="col-md-4 label-control text-right">{lang key='wechat::wechat.label_message_content'}</label>
							<div class="col-md-8 controls">
								<textarea name="message_content" class="form-control"></textarea>
								<div class="help-block">{lang key='wechat::wechat.tip_info'}</div>
							</div>
							<label class="input-must">*</label>
						</div>
						<div class="form-group row">
							<label class="col-md-4 label-control text-right">{lang key='wechat::wechat.label_nickname'}</label>
							<div class="col-md-8 nickname"></div>
						</div>
						
						
						<div class="form-group row">
							<label class="col-md-4 label-control text-right">{lang key='wechat::wechat.weixin_only_identification'}</label>
							<div class="col-md-8 openid"></div>
						</div>
					</div>
				</div>

				<div class="modal-footer justify-content-center">
					<input class="btn btn-outline-primary" type="submit" {if $errormsg}disabled{/if} value="{lang key='wechat::wechat.ok'}" />
                    <input type="hidden" name="wechat_type" value="{$type}">
                	<input type="hidden" name="uid"/>
           		 	<input type="hidden" name="openid"/>
				</div>
			</form>

		</div>
	</div>
</div>
<!-- {/block} -->