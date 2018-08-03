<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-platform.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.platform.admin_record.init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->

<!-- {if $errormsg} -->
<div class="alert mb-2 alert-danger">
	<strong>{lang key='wechat::wechat.label_notice'}</strong>{$errormsg}
</div>
<!-- {/if} -->

<!-- {if $warn && $type neq 2} -->
<div class="alert alert-danger">
	<strong>{lang key='wechat::wechat.label_notice'}</strong>{$type_error}
</div>
<!-- {/if} -->

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">
                	{lang key='wechat::wechat.chat_record_synchro'}
                </h4>
            </div>
            <div class="card-body">
            	<div>
            		<button type="button" class="ajaxmenu btn btn-outline-primary" data-url='{RC_Uri::url("wechat/platform_record/get_customer_record")}' data-value="get_record">
            			{lang key='wechat::wechat.get_message_record'}
            		</button>
                    <span style="margin-left: 20px;">通过点击该按钮可以获取客服<strong>{$time.start_time}</strong> 至 <strong>{$time.end_time}</strong>的聊天记录到本地。</span>
            	</div><br/>
			</div>
		</div>
	</div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
			<div class="card-header">
                <h4 class="card-title">{$ur_here}</h4>
            </div>
     		<div class="card-body">
     			<ul class="nav nav-pills float-left">
     				<li class="nav-item">
						<a class="nav-link data-pjax {if $list.filter.status eq 1}active{/if}" href='{url path="wechat/platform_record/init" args="
					status=1{if $smarty.get.kf_account}&kf_account={$smarty.get.kf_account}{/if}"}'>{lang key='wechat::wechat.last_five_days'}
						<span class="badge badge-pill badge-glow badge-default badge-primary ml-1">{if $list.filter.last_five_days}{$list.filter.last_five_days}{else}0{/if}</span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link data-pjax {if $list.filter.status eq 2}active{/if}" href='{url path="wechat/platform_record/init" args="status=2{if $smarty.get.kf_account}&kf_account={$smarty.get.kf_account}{/if}"}'>{lang key='wechat::wechat.today'}<span class="badge badge-pill badge-glow badge-default badge-primary ml-1">{if $list.filter.today}{$list.filter.today}{else}0{/if}</span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link data-pjax {if $list.filter.status eq 3}active{/if}" href='{url path="wechat/platform_record/init" args="status=3{if $smarty.get.kf_account}&kf_account={$smarty.get.kf_account}{/if}"}'>{lang key='wechat::wechat.yesterday'}<span class="badge badge-pill badge-glow badge-default badge-primary ml-1">{if $list.filter.yesterday}{$list.filter.yesterday}{else}0{/if}</span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link data-pjax {if $list.filter.status eq 4}active{/if}" href='{url path="wechat/platform_record/init" args="status=4{if $smarty.get.kf_account}&kf_account={$smarty.get.kf_account}{/if}"}'>{lang key='wechat::wechat.the_day_before_yesterday'}<span class="badge badge-pill badge-glow badge-default badge-primary ml-1">{if $list.filter.the_day_before_yesterday}{$list.filter.the_day_before_yesterday}{else}0{/if}</span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link data-pjax {if $list.filter.status eq 5}active{/if}" href='{url path="wechat/platform_record/init" args="status=5{if $smarty.get.kf_account}&kf_account={$smarty.get.kf_account}{/if}"}'>{lang key='wechat::wechat.earlier'}<span class="badge badge-pill badge-glow badge-default badge-primary ml-1">{if $list.filter.earlier}{$list.filter.earlier}{else}0{/if}</span></a>
					</li>
				</ul>
				
				<div class="choost_list float-right" data-url="{$action}">
					<select name="kf_account" class="select2 w250 form-control">
						<option value="-1">{lang key='wechat::wechat.all_customer'}</option>
						<!-- {foreach from=$kf_list item=v} -->
						<option value="{$v.kf_account}" {if $v.kf_account eq $smarty.get.kf_account}selected{/if}>{t}{$v.kf_nick}（{$v.kf_account}）{/t}</option>
						<!-- {/foreach} -->
					</select>
				</div>
			</div>
			
            <div class="col-md-12">
				<table class="table table-hide-edit">
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
								<a tabindex="0" class="user_info" title="{lang key='wechat::wechat.detail_info'}" data-toggle="popover" data-uid="{$val.uid}" data-trigger="focus" data-url='{RC_Uri::url("wechat/platform_record/get_user_info", "uid={$val.uid}")}'>
									<img class="thumbnail" src="{if $val.headimgurl}{$val.headimgurl}{else}{RC_Uri::admin_url('statics/images/nopic.png')}{/if}">
								</a>
								<div class="w80 m_t5 ecjiaf-tac">{$val.nickname}</div>
								<div id="popover-content_{$val.uid}" class="hide"></div>
							</td>
							<td class="hide-edit-area">	
								<div>{lang key='wechat::wechat.send_at'}{$val.time}</div>
								<span class="ecjiaf-pre">{$val.text}</span>
								<div class="edit-list">
									<a class="data-pjax" href='{RC_Uri::url("wechat/platform_record/record_message", "uid={$val.uid}&status={$list.filter.status}{if $smarty.get.kf_account}&kf_account={$smarty.get.kf_account}{/if}{if $smarty.get.page}&page={$smarty.get.page}{/if}")}' title="{lang key='system::system.view'}">{lang key='system::system.view'}</a>
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
        </div>
    </div>
</div>

<!-- {/block} -->