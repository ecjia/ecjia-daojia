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
	<!-- {if $type neq 2} -->
		<div class="alert alert-error">
			<strong>{lang key='wechat::wechat.label_notice'}</strong>{$type_error}
		</div>
	<!-- {/if} -->
<!-- {/if} -->	

{platform_account::getAccountSwtichDisplay('wechat')}

<div>
	<h3 class="heading">
		{lang key='wechat::wechat.chat_record_synchro'}
	</h3>
</div>
	
<div style="margin-left: 20px;">
	<div><button type="button" class="ajaxmenu btn" data-url='{RC_Uri::url("wechat/admin_record/get_customer_record")}' data-value="get_record">{lang key='wechat::wechat.get_message_record'}</button><span style="margin-left: 20px;">{lang key='wechat::wechat.get_message_record_notice'}</span></div><br/>
</div>
	
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
	</h3>
</div>

<ul class="nav nav-pills">
	<li class="{if $list.filter.status eq 1}active{/if}"><a class="data-pjax" href='{url path="wechat/admin_record/init" args="status=1{if $smarty.get.kf_account}&kf_account={$smarty.get.kf_account}{/if}"}'>{lang key='wechat::wechat.last_five_days'}<span class="badge badge-info">{$list.filter.last_five_days}</span></a></li>
	<li class="{if $list.filter.status eq 2}active{/if}"><a class="data-pjax" href='{url path="wechat/admin_record/init" args="status=2{if $smarty.get.kf_account}&kf_account={$smarty.get.kf_account}{/if}"}'>{lang key='wechat::wechat.today'}<span class="badge badge-info">{$list.filter.today}</span></a></li>
	<li class="{if $list.filter.status eq 3}active{/if}"><a class="data-pjax" href='{url path="wechat/admin_record/init" args="status=3{if $smarty.get.kf_account}&kf_account={$smarty.get.kf_account}{/if}"}'>{lang key='wechat::wechat.yesterday'}<span class="badge badge-info">{$list.filter.yesterday}</span></a></li>
	<li class="{if $list.filter.status eq 4}active{/if}"><a class="data-pjax" href='{url path="wechat/admin_record/init" args="status=4{if $smarty.get.kf_account}&kf_account={$smarty.get.kf_account}{/if}"}'>{lang key='wechat::wechat.the_day_before_yesterday'}<span class="badge badge-info">{$list.filter.the_day_before_yesterday}</span></a></li>
	<li class="{if $list.filter.status eq 5}active{/if}"><a class="data-pjax" href='{url path="wechat/admin_record/init" args="status=5{if $smarty.get.kf_account}&kf_account={$smarty.get.kf_account}{/if}"}'>{lang key='wechat::wechat.earlier'}<span class="badge badge-info">{$list.filter.earlier}</span></a></li>
	
	<div class="choost_list f_r" data-url="{$action}">
		<select name="kf_account" class="w250">
			<option value="-1">{lang key='wechat::wechat.all_customer'}</option>
			<!-- {foreach from=$kf_list item=v} -->
			<option value="{$v.kf_account}" {if $v.kf_account eq $smarty.get.kf_account}selected{/if}>{t}{$v.kf_nick}（{$v.kf_account}）{/t}</option>
			<!-- {/foreach} -->
		</select>
	</div>
</ul>

<div class="row-fluid list-page">
	<table class="table table-striped smpl_tbl table-hide-edit">
		<thead>
			<tr>
				<th class="w130">{lang key='wechat::wechat.user_info'}</th>
				<th>{lang key='wechat::wechat.message_content'}</th>
			</tr>
		</thead>
		<tbody>
			<!-- {foreach from=$list.item item=val} -->
			<tr>
				<td class="big">
					<a tabindex="0" class="user_info" title="{lang key='wechat::wechat.detail_info'}" data-toggle="popover" data-uid="{$val.uid}" data-trigger="focus" data-url='{RC_Uri::url("wechat/admin_record/get_user_info", "uid={$val.uid}")}'>
						<img class="thumbnail" src="{if $val.headimgurl}{$val.headimgurl}{else}{RC_Uri::admin_url('statics/images/nopic.png')}{/if}">
					</a>
					<div class="w80 m_t5 ecjiaf-tac">{$val.nickname}</div>
					<div id="popover-content_{$val.uid}" class="hide"></div>
				</td>
				<td class="hide-edit-area">	
					<div>{lang key='wechat::wechat.send_at'}{$val.time}</div>
					<span class="ecjiaf-pre">{$val.text}</span>
					<div class="edit-list">
						<a class="data-pjax" href='{RC_Uri::url("wechat/admin_record/record_message", "uid={$val.uid}&status={$list.filter.status}{if $smarty.get.kf_account}&kf_account={$smarty.get.kf_account}{/if}{if $smarty.get.page}&page={$smarty.get.page}{/if}")}' title="{lang key='system::system.view'}">{lang key='system::system.view'}</a>
					</div>
				</td>
			</tr>
			<!--  {foreachelse} -->
			<tr>
				<td class="no-records" colspan="2">{lang key='system::system.no_records'}</td>
			</tr>
			<!-- {/foreach} -->
		</tbody>
	</table>
	<!-- {$list.page} -->
</div> 
<!-- {/block} -->