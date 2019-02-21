<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-platform.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.platform.wechat_customer.init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->

<!-- {if $warn && $type neq 2} -->
<div class="alert alert-danger">
	<strong>{t domain="wechat"}温馨提示：{/t}</strong>{$type_error}
</div>
<!-- {/if} -->		
		
<!-- {if $errormsg} -->
	<div class="alert alert-danger">
    	<strong>{t domain="wechat"}温馨提示：{/t}</strong>{$errormsg}
    </div>
<!-- {/if} -->

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">
                    {t domain="wechat"}客服会话同步操作{/t}
                </h4>
            </div>
            <div class="card-body">
            	<div><button type="button" class="ajaxmenu btn btn-outline-primary" data-url='{RC_Uri::url("wechat/platform_customer/get_customer_session")}&status={$smarty.get.status}' data-value="get_customer_session">{t domain="wechat"}获取客服会话{/t}</button><span style="margin-left: 20px;">{t domain="wechat"}通过点击该按钮可以获取未接入会话列表。{/t}</span></div><br/>
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
						<a class="nav-link data-pjax {if $smarty.get.status eq 2 || !$smarty.get.status}active{/if}" href='{url path="wechat/platform_customer/session" args="status=2"}'>{t domain="wechat"}待接入{/t}
						<span class="badge badge-pill badge-glow badge-default badge-primary ml-1">{$list.count.wait}</span></a>
					</li>
     				<li class="nav-item">
						<a class="nav-link data-pjax {if $smarty.get.status eq 1}active{/if}" href='{url path="wechat/platform_customer/session" args="status=1"}'>{t domain="wechat"}会话中{/t}
						<span class="badge badge-pill badge-glow badge-default badge-primary ml-1">{$list.count.going}</span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link data-pjax {if $smarty.get.status eq 3}active{/if}" href='{url path="wechat/platform_customer/session" args="status=3"}'>{t domain="wechat"}已关闭{/t}
						<span class="badge badge-pill badge-glow badge-default badge-primary ml-1">{$list.count.close}</span></a>
					</li>
				</ul>
			</div>

            <div class="col-md-12">
				<table class="table table-hide-edit">
					<thead>
						<tr>
							<th class="w130">{t domain="wechat"}客服账号{/t}</th>
							<th>{t domain="wechat"}用户昵称{/t}</th>
							<th>{t domain="wechat"}状态{/t}</th>
							<th>{t domain="wechat"}创建时间{/t}</th>
							<th>{t domain="wechat"}最后一条消息的时间{/t}</th>
							<th>{t domain="wechat"}操作{/t}</th>
						</tr>
					</thead>
					<tbody>
						<!-- {foreach from=$list.item item=val} -->
						<tr>
							<td>{if $val.kf_account}{$val.kf_account}{else}{t domain="wechat"}暂无{/t}{/if}</td>
							<td>{$val.nickname}</td>
							<td>
								{if $val.status eq 1}
                                {t domain="wechat"}会话中{/t}
								{elseif $val.status eq 2}
                                {t domain="wechat"}待接入{/t}
								{elseif $val.status eq 3}
                                {t domain="wechat"}已关闭{/t}
								{/if}
							</td>
							<td>
								{if $val.create_time}
								{date('Y-m-d H:i:s', ($val['create_time']))}
								{/if}
							</td>
							<td>
								{if $val.latest_time}
								{date('Y-m-d H:i:s', ($val['latest_time']))}
								{/if}
							</td>
							<td>
								{if $val.status neq 3}
									<a class="ajaxremove cursor_pointer" href='{RC_Uri::url("wechat/platform_customer/close_session", "id={$val.id}")}' title='{t domain="wechat"}关闭{/t}' data-toggle="ajaxremove" data-msg='{t domain="wechat"}您确定要关闭该会话吗？{/t}'>{t domain="wechat"}关闭会话{/t}</a>
								{/if}
							</td>
						</tr>
						<!--  {foreachelse} -->
						<tr>
							<td class="no-records" colspan="6">{t domain="wechat"}没有找到任何记录{/t}</td>
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