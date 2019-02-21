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
	<strong>{t domain="wechat"}温馨提示：{/t}</strong>{$errormsg}
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
						<option value="">{t domain="wechat"}请选择活动类型{/t}</option>
						<option value="mp_zjd" {if $smarty.get.type eq 'mp_zjd'}selected="selected"{/if}>{t domain="wechat"}砸金蛋{/t}</option>
						<option value="mp_dzp" {if $smarty.get.type eq 'mp_dzp'}selected="selected"{/if}>{t domain="wechat"}大转盘{/t}</option>
						<option value="mp_ggl" {if $smarty.get.type eq 'mp_ggl'}selected="selected"{/if}>{t domain="wechat"}刮刮乐{/t}</option>
					</select>
					<input type="button" value='筛选' class="btn btn-outline-primary m_l5 screen-btn">
				</form>
			</div>
			
            <div class="col-md-12">
				<table class="table table-hide-edit">
					<thead>
						<tr>
							<th class="w150">{t domain="wechat"}微信昵称{/t}</th>
							<th class="w150">{t domain="wechat"}奖品{/t}</th>
							<th class="w150">{t domain="wechat"}中奖用户信息{/t}</th>
							<th class="w100">{t domain="wechat"}是否发放{/t}</th>
							<th class="w100">{t domain="wechat"}中奖时间{/t}</th>
						</tr>
					</thead>
					<tbody>
						<!-- {foreach from=$list.prize_list item=val} -->
						<tr>							
							<td class="hide-edit-area hide_edit_area_bottom"> 
						    	<span>{$val.nickname}</span>
						    	<div class="edit-list">
						    		<a class="send_message" href="javascript:;" data-nickname="{$val.nickname}" data-uid="{$val.uid}" data-openid="{$val.openid}" title='{t domain="wechat"}通知用户{/t}'>{t domain="wechat"}通知用户{/t}</a>&nbsp;|&nbsp;
						        	<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg='{t domain="wechat" 1={$val.nickname}}您确定要删除该获奖名单[%1]吗？{/t}' href='{RC_Uri::url("wechat/platform_prize/remove", "id={$val.id}")}' title='{t domain="wechat"}删除{/t}'>删除</a>
								</div>
						    </td>
							<td>{$val.prize_name}</td>
							<td>
                                {if is_array($val['winner'])}
                                {t domain="wechat"}姓名：{/t}{$val['winner']['name']}<br />
                                {t domain="wechat"}电话：{/t}{$val['winner']['phone']}<br />
                                {t domain="wechat"}地址：{/t}{$val['winner']['address']}
                                {/if}
                            </td>
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
						<tr><td class="no-records" colspan="5">{t domain="wechat"}没有找到任何记录{/t}</td></tr>
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
				<h3 class="modal-title">{t domain="wechat"}通知用户{/t}</h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">×</span>
				</button>
			</div>

			<!-- {if $errormsg} -->
			    <div class="alert alert-danger">
		            <strong>{t domain="wechat"}温馨提示：{/t}</strong>{$errormsg}
		        </div>
			<!-- {/if} -->
			
			<!-- {if $warn && $type eq 0} -->
				<div class="alert alert-danger">
					<strong>{t domain="wechat"}温馨提示：{/t}</strong>{$type_error}
				</div>
			<!-- {/if} -->

			<form class="form" method="post" name="the_form" action="{url path='wechat/platform_prize/send_message'}">
				<div class="card-body">
					<div class="form-body">
						<div class="form-group row">
							<label class="col-md-4 label-control text-right">{t domain="wechat"}消息内容：{/t}</label>
							<div class="col-md-8 controls">
								<textarea name="message_content" class="form-control"></textarea>
								<div class="help-block">{t domain="wechat"}（只有48小时内给公众号发送过信息的粉丝才能接收到信息）{/t}</div>
							</div>
							<label class="input-must">*</label>
						</div>
						<div class="form-group row">
							<label class="col-md-4 label-control text-right">{t domain="wechat"}昵称：{/t}</label>
							<div class="col-md-8 nickname"></div>
						</div>
						
						
						<div class="form-group row">
							<label class="col-md-4 label-control text-right">{t domain="wechat"}微信用户唯一标识(openid)：{/t}</label>
							<div class="col-md-8 openid"></div>
						</div>
					</div>
				</div>

				<div class="modal-footer justify-content-center">
					<input class="btn btn-outline-primary" type="submit" {if $errormsg}disabled{/if} value='{t domain="wechat"}确定{/t}' />
                    <input type="hidden" name="wechat_type" value="{$type}">
                	<input type="hidden" name="uid"/>
           		 	<input type="hidden" name="openid"/>
				</div>
			</form>

		</div>
	</div>
</div>
<!-- {/block} -->