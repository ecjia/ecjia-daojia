<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-platform.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.platform.admin_subscribe.init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->

<!-- {if $unionid eq 1} -->
<div class="alert alert-warning">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true"><span aria-hidden="true">×</span></button>
	<strong>{t domain="wechat"}温馨提示：{/t}</strong>{t domain="wechat"}无法获取unionid字段，若需获取该字段，请将公众号绑定到微信开放平台帐号。{/t}
</div>
<!-- {/if} -->

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

<div class="alert alert-light alert-dismissible mb-2" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">×</span>
	</button>
	<h4 class="alert-heading mb-2">{t domain="wechat"}操作提示{/t}</h4>
	<p>{t domain="wechat"}粉丝管理：显示已经关注微信公众号的用户信息，未关注的不显示。{/t}</p>
	<p>{t domain="wechat"}1.搜索功能支持通过用户昵称、省、市搜索。{/t}</p>
	<p>{t domain="wechat"}2.发送客服消息，可以单独发送微信消息给微信用户（只有48小时内和公众号有过互动的粉丝才能接收到信息，否则会发送失败）应用场景 例如，通知用户中奖领取奖品等事宜。{/t}</p>
	<p>{t domain="wechat"}★ 注意事项：在对用户进行发送消息，打标签等操作之前，请及时点击获取用户信息按钮，以便同步微信公众号平台的用户分组（标签）与数量。{/t}</p>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">
                    {t domain="wechat"}粉丝管理同步操作{/t}
                </h4>
            </div>
            <div class="card-body">
				<div><button type="button" class="ajaxmenu btn btn-outline-primary" data-url='{RC_Uri::url("wechat/platform_subscribe/get_userinfo")}' data-value="get_userinfo">{t domain="wechat"}获取用户信息{/t}</button><span style="margin-left: 20px;">{t domain="wechat"}通过点击该按钮可以获取微信端用户信息到本地。{/t}</span></div><br/>
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
				<!-- {if $smarty.get.type neq 'unsubscribe' && $smarty.get.type neq 'blacklist'} -->
				<button type="button" class="btn btn-outline-primary set-label-btn" data-url="{$get_checked}"><i class="fa fa-tag"></i> {t domain="wechat"}打标签{/t}</button>
				<!-- {/if} -->
				<div class="form-inline float-right">
					<form class="form-inline" method="post" action="{$form_action}{if $smarty.get.type}&type={$smarty.get.type}{/if}" name="search_from">
		          		<input type="text" name="keywords" value="{$smarty.get.keywords}" class="form-control m_r5" placeholder='{t domain="wechat"}请输入昵称/省/市搜索{/t}'>
		            	<button type="submit" class="btn btn-outline-primary search-btn">{t domain="wechat"}搜索{/t}</button>
		        	</form>
				</div>
			</div>
			
            <div class="col-md-12">
                <div class="content-detached content-left col-md-12">
					<table class="table table-hide-edit">
						<thead>
							<tr>
								<th class="table_checkbox w30">
									<input type="checkbox" data-toggle="selectall" data-children=".checkbox" id="customCheck"/>
									<label for="customCheck"></label>
								</th>
								<th class="w100">{t domain="wechat"}头像{/t}</th>
								<th class="w150">{t domain="wechat"}昵称{/t}</th>
								<th class="w100">{t domain="wechat"}省（直辖市）{/t}</th>
								<th class="w100">{t domain="wechat"}绑定用户{/t}</th>
								<th class="w180">{t domain="wechat"}关注时间{/t}</th>
							</tr>
						</thead>
						<tbody>
							<!-- {foreach from=$list.item item=val key=key} -->
							<tr class="big">
								<td>
									<input class="checkbox" type="checkbox" name="checkboxes[]" value="{$val.openid}" id="checkbox_{$key}" />
									<label for="checkbox_{$key}"></label>
								</td>
								<td>
									{if $val.headimgurl}
									<img class="thumbnail" src="{$val.headimgurl}">
									{else}
									<img class="thumbnail" src="{RC_Uri::admin_url('statics/images/nopic.png')}">
									{/if}
								</td>
								<td class="hide-edit-area">
									<span class="ecjaf-pre">
										{$val['nickname']}{if $val['sex'] == 1}{t domain="wechat"}（男）{/t}{else if $val.sex == 2}{t domain="wechat"}（女）{/t}{/if}<br/>{if $val.group_id eq 1 || $val.subscribe eq 0}{else}{if $val.tag_name eq ''}{t domain="wechat"}无标签{/t}{else}{$val.tag_name}{/if}{/if}<br>
										{$val.remark}
									</span>
									<div class="edit-list">
										<!-- {if $val.group_id neq 1 && $val.subscribe neq 0} -->
											<a class="set-label-btn cursor_pointer" href="javascript:;" data-openid="{$val.openid}" data-uid="{$val.uid}" data-url="{$get_checked}">{t domain="wechat"}打标签{/t}</a>&nbsp;|&nbsp;
										<!-- {/if} -->
										{if $customer_list}
										<a class="create_session cursor_pointer" href="javascript:;" data-openid="{$val.openid}">{t domain="wechat"}创建会话{/t}</a>&nbsp;|&nbsp;
										{/if}
										
										<a class="data-pjax" href='{url path="wechat/platform_subscribe/subscribe_message" args="uid={$val.uid}{if $smarty.get.page}&page={$smarty.get.page}{/if}"}' title='{t domain="wechat"}消息记录{/t}'>{t domain="wechat"}消息记录{/t}</a>&nbsp;|&nbsp;
										<a class="ajaxremove cursor_pointer" href='{RC_Uri::url("wechat/platform_subscribe/black_user","openid={$val.openid}&from=list&page={$smarty.get.page}")}' title='{t domain="wechat"}加入黑名单{/t}' data-toggle="ajaxremove" data-msg='{t domain="wechat"}您确定要将该用户加入黑名单吗？{/t}'>{t domain="wechat"}加入黑名单{/t}</a>
									</div>
								</td>
								<td>{$val['province']} - {$val['city']}</td>
								<td>{if $val['user_name']}{$val.user_name}{else}<span class="unbind_user">{t domain="wechat"}未绑定{/t}</span>{/if}</td>
								<td>{date('Y-m-d H:i:s', ($val['subscribe_time']))}</td>
							</tr>
							<!--  {foreachelse} -->
							<tr><td class="no-records" colspan="6">{t domain="wechat"}没有找到任何记录{/t}</td></tr>
							<!-- {/foreach} -->
						</tbody>
					</table>						
				</div>
            </div>
            <!-- {$list.page} -->
        </div>
    </div>
</div>

<div class="modal fade text-left" id="set_label">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title">{t domain="wechat"}打标签{/t}</h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">×</span>
				</button>
			</div>
			<!-- {if $errormsg} -->
		    <div class="alert alert-danger">
	            <strong>{t domain="wechat"}温馨提示：{/t}</strong>{$errormsg}
	        </div>
			<!-- {/if} -->
			
			<!-- {if $warn} -->
				<!-- {if $type eq 0} -->
				<div class="alert alert-danger">
					<strong>{t domain="wechat"}温馨提示：{/t}</strong>{$type_error}
				</div>
				<!-- {/if} -->
			<!-- {/if} -->
			<form class="form" method="post" action="{$label_action}&action=set_label" name="label_form">
				<div class="modal-body tag_popover">
					<div class="popover_inner p_b0">
						<div class="popover_content">
							<div class="popover_tag_list">
							</div>
							<span class="label_block hide ecjiafc-red">{t domain="wechat"}最多只能选择3个标签{/t}</span>
						</div>
			   		</div>
		   		</div>
		   	
			   	<div class="modal-footer justify-content-center">
			   		<input type="hidden" name="openid" />
					<button type="button" class="btn btn-outline-primary set_label" {if $errormsg}disabled{/if}>{t domain="wechat"}确定{/t}</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade text-left" id="create_session">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title">{t domain="wechat"}创建会话{/t}</h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">×</span>
				</button>
			</div>
			<!-- {if $errormsg} -->
		    <div class="alert alert-danger">
	            <strong>{t domain="wechat"}温馨提示：{/t}</strong>{$errormsg}
	        </div>
			<!-- {/if} -->
			
			<!-- {if $type neq 2} -->
			<div class="alert alert-danger">
				<strong>{t domain="wechat"}温馨提示：{/t}</strong>{$custom_type_error}
			</div>
			<!-- {/if} -->
			
			<form class="form" method="post" action="{RC_Uri::url('wechat/platform_customer/create_session')}" name="session_form">
				<div class="modal-body height200">
					<div class="card-body">
						<div class="form-group row">
							<label class="col-lg-3 label-control text-right">{t domain="wechat"}选择客服：{/t}</label>
							<div class="col-lg-8 controls">
								<select name="kf_account" class="select2 form-control w250">
									<option value="">{t domain="wechat"}请选择客服...{/t}</option>
									<!-- {foreach from=$customer_list item=list} -->
									<option value="{$list.kf_account}">{$list.kf_nick}</option>
									<!-- {/foreach} -->
								</select>
							</div>
						</div>
					</div>
		   		</div>
		   	
			   	<div class="modal-footer justify-content-center">
			   		<input type="hidden" name="openid" />
					<button type="submit" class="btn btn-outline-primary" {if $errormsg || $type neq 2}disabled{/if}>{t domain="wechat"}确定{/t}</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- {/block} -->