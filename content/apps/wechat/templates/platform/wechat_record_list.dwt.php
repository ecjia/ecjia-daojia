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
	<strong>{t domain="wechat"}温馨提示：{/t}</strong>{$errormsg}
</div>
<!-- {/if} -->

<!-- {if $warn && $type neq 2} -->
<div class="alert alert-danger">
	<strong>{t domain="wechat"}温馨提示：{/t}</strong>{$type_error}
</div>
<!-- {/if} -->

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">
                    {t domain="wechat"}客服聊天记录同步操作{/t}
                </h4>
            </div>
            <div class="card-body">
            	<div>
            		<button type="button" class="ajaxmenu btn btn-outline-primary" data-url='{RC_Uri::url("wechat/platform_record/get_customer_record")}' data-value="get_record">
                        {t domain="wechat"}获取客服聊天记录{/t}
            		</button>
                    <span style="margin-left: 20px;">{t domain="wechat" escape=no 1={$time.start_time} 2={$time.end_time}}通过点击该按钮可以获取客服<strong>%1</strong> 至 <strong>%2</strong>的聊天记录到本地。{/t}</span>
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
					status=1{if $smarty.get.kf_account}&kf_account={$smarty.get.kf_account}{/if}"}'>{t domain="wechat"}最近五天{/t}
						<span class="badge badge-pill badge-glow badge-default badge-primary ml-1">{if $list.filter.last_five_days}{$list.filter.last_five_days}{else}0{/if}</span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link data-pjax {if $list.filter.status eq 2}active{/if}" href='{url path="wechat/platform_record/init" args="status=2{if $smarty.get.kf_account}&kf_account={$smarty.get.kf_account}{/if}"}'>{t domain="wechat"}今天{/t}<span class="badge badge-pill badge-glow badge-default badge-primary ml-1">{if $list.filter.today}{$list.filter.today}{else}0{/if}</span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link data-pjax {if $list.filter.status eq 3}active{/if}" href='{url path="wechat/platform_record/init" args="status=3{if $smarty.get.kf_account}&kf_account={$smarty.get.kf_account}{/if}"}'>{t domain="wechat"}昨天{/t}<span class="badge badge-pill badge-glow badge-default badge-primary ml-1">{if $list.filter.yesterday}{$list.filter.yesterday}{else}0{/if}</span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link data-pjax {if $list.filter.status eq 4}active{/if}" href='{url path="wechat/platform_record/init" args="status=4{if $smarty.get.kf_account}&kf_account={$smarty.get.kf_account}{/if}"}'>{t domain="wechat"}前天{/t}<span class="badge badge-pill badge-glow badge-default badge-primary ml-1">{if $list.filter.the_day_before_yesterday}{$list.filter.the_day_before_yesterday}{else}0{/if}</span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link data-pjax {if $list.filter.status eq 5}active{/if}" href='{url path="wechat/platform_record/init" args="status=5{if $smarty.get.kf_account}&kf_account={$smarty.get.kf_account}{/if}"}'>{t domain="wechat"}更早{/t}<span class="badge badge-pill badge-glow badge-default badge-primary ml-1">{if $list.filter.earlier}{$list.filter.earlier}{else}0{/if}</span></a>
					</li>
				</ul>
				
				<div class="choost_list float-right" data-url="{$action}">
					<select name="kf_account" class="select2 w250 form-control">
						<option value="-1">{t domain="wechat"}所有客服{/t}</option>
						<!-- {foreach from=$kf_list item=v} -->
						<option value="{$v.kf_account}" {if $v.kf_account eq $smarty.get.kf_account}selected{/if}>{$v.kf_nick}（{$v.kf_account}）</option>
						<!-- {/foreach} -->
					</select>
				</div>
			</div>
			
            <div class="col-md-12">
				<table class="table table-hide-edit">
					<thead>
						<tr>
							<th class="w130">{t domain="wechat"}用户信息{/t}</th>
							<th>{t domain="wechat"}消息内容{/t}</th>
						</tr>
					</thead>
					<tbody>
						<!-- {foreach from=$list.item item=val} -->
						<tr>
							<td class="big">
								<a tabindex="0" class="user_info" title='{t domain="wechat"}详细资料{/t}' data-toggle="popover" data-uid="{$val.uid}" data-trigger="focus" data-url='{RC_Uri::url("wechat/platform_record/get_user_info", "uid={$val.uid}")}'>
									<img class="thumbnail" src="{if $val.headimgurl}{$val.headimgurl}{else}{RC_Uri::admin_url('statics/images/nopic.png')}{/if}">
								</a>
								<div class="w80 m_t5 ecjiaf-tac">{$val.nickname}</div>
								<div id="popover-content_{$val.uid}" class="hide"></div>
							</td>
							<td class="hide-edit-area">	
								<div>{t domain="wechat"}发送于：{/t}{$val.time}</div>
								<span class="ecjiaf-pre">{$val.text}</span>
								<div class="edit-list">
									<a class="data-pjax" href='{RC_Uri::url("wechat/platform_record/record_message", "uid={$val.uid}&status={$list.filter.status}{if $smarty.get.kf_account}&kf_account={$smarty.get.kf_account}{/if}{if $smarty.get.page}&page={$smarty.get.page}{/if}")}' title='{t domain="wechat"}查看{/t}'>{t domain="wechat"}查看{/t}</a>
								</div>
							</td>
						</tr>
						<!--  {foreachelse} -->
						<tr>
							<td class="no-records" colspan="2">{t domain="wechat"}没有找到任何记录{/t}</td>
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