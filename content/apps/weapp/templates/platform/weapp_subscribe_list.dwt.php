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
	<strong>{lang key='wechat::wechat.label_notice'}</strong>{lang key='wechat::wechat.unionid_error_info'}
</div>
<!-- {/if} -->

<div class="alert alert-light alert-dismissible mb-2" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">×</span>
	</button>
	<h4 class="alert-heading mb-2">操作提示</h4>
	<p>用户管理：显示已经关注微信公众号的用户信息，未关注的不显示。</p>
	<p>1.搜索功能支持通过用户昵称、省、市搜索。</p>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
			<div class="card-header">
                <h4 class="card-title">{$ur_here}</h4>
            </div>
			<div class="card-body">
				<!-- {if $smarty.get.type neq 'unsubscribe' && $smarty.get.type neq 'blacklist'} -->
				<button type="button" class="btn btn-outline-primary set-label-btn" data-url="{$get_checked}"><i class="fa fa-tag"></i> 打标签</button>
				<!-- {/if} -->
				<div class="form-inline float-right">
					<form class="form-inline" method="post" action="{$form_action}{if $smarty.get.type}&type={$smarty.get.type}{/if}" name="search_from">
		          		<input type="text" name="keywords" value="{$smarty.get.keywords}" class="form-control m_r5" placeholder="{lang key='wechat::wechat.search_user_placeholder'}">
		            	<button type="submit" class="btn btn-outline-primary search-btn">{lang key='wechat::wechat.search'}</button>
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
								<th class="w100">{lang key='wechat::wechat.headimg_url'}</th>
								<th class="w150">{lang key='wechat::wechat.nickname'}</th>
								<th class="w100">{lang key='wechat::wechat.province'}</th>
								<th class="w100">{lang key='wechat::wechat.bind_user'}</th>
								<th class="w180">{lang key='wechat::wechat.subscribe_time'}</th>
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
										{$val['nickname']}{if $val['sex'] == 1}{lang key='wechat::wechat.male_sign'}{else if $val.sex == 2}{lang key='wechat::wechat.female_sign'}{/if}<br/>{if $val.group_id eq 1 || $val.subscribe eq 0}{else}{if $val.tag_name eq ''}{lang key='wechat::wechat.no_tag'}{else}{$val.tag_name}{/if}{/if}<br>
										{$val.remark}
									</span>
									<div class="edit-list">
										<!-- {if $val.group_id neq 1 && $val.subscribe neq 0} -->
											<a class="set-label-btn cursor_pointer" href="javascript:;" data-openid="{$val.openid}" data-uid="{$val.uid}" data-url="{$get_checked}">{lang key='wechat::wechat.set_tag'}</a>&nbsp;|&nbsp;
										<!-- {/if} -->
										
										<a class="data-pjax" href='{url path="weapp/platform_user/subscribe_message" args="uid={$val.uid}{if $smarty.get.page}&page={$smarty.get.page}{/if}"}' title="{lang key='wechat::wechat.message_record'}">消息记录</a>&nbsp;|&nbsp;
										
										<a class="ajaxremove cursor_pointer" href='{RC_Uri::url("weapp/platform_user/black_user","openid={$val.openid}&from=list&page={$smarty.get.page}")}' title="{lang key='wechat::wechat.add_blacklist'}" data-toggle="ajaxremove" data-msg="{lang key='wechat::wechat.add_blacklist_confirm'}">加入黑名单</a>
									</div>
								</td>
								<td>{$val['province']} - {$val['city']}</td>
								<td>{if $val['user_name']}{$val.user_name}{else}<span class="unbind_user">未绑定</span>{/if}</td>
								<td>{date('Y-m-d H:i:s', ($val['subscribe_time']))}</td>
							</tr>
							<!--  {foreachelse} -->
							<tr><td class="no-records" colspan="6">{lang key='system::system.no_records'}</td></tr>
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
				<h3 class="modal-title">{lang key='wechat::wechat.set_tag'}</h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">×</span>
				</button>
			</div>
			<!-- {if $errormsg} -->
		    <div class="alert alert-danger">
	            <strong>{lang key='wechat::wechat.label_notice'}</strong>{$errormsg}
	        </div>
			<!-- {/if} -->
			
			<form class="form" method="post" action="{$label_action}&action=set_label" name="label_form">
				<div class="modal-body tag_popover">
					<div class="popover_inner p_b0">
						<div class="popover_content">
							<div class="popover_tag_list">
							</div>
							<span class="label_block hide ecjiafc-red">{lang key='wechat::wechat.up_tag_count'}</span>
						</div>
			   		</div>
		   		</div>
		   	
			   	<div class="modal-footer justify-content-center">
			   		<input type="hidden" name="openid" />
					<button type="button" class="btn btn-outline-primary set_label" {if $errormsg}disabled{/if}>{lang key='wechat::wechat.ok'}</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade text-left" id="create_session">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title">创建会话</h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">×</span>
				</button>
			</div>
			<!-- {if $errormsg} -->
		    <div class="alert alert-danger">
	            <strong>{lang key='wechat::wechat.label_notice'}</strong>{$errormsg}
	        </div>
			<!-- {/if} -->
			
			<form class="form" method="post" action="{RC_Uri::url('weapp/platform_customer/create_session')}" name="session_form">
				<div class="modal-body height200">
					<div class="card-body">
						<div class="form-group row">
							<label class="col-lg-3 label-control text-right">选择客服：</label>
							<div class="col-lg-8 controls">
								<select name="kf_account" class="select2 form-control w250">
									<option value="">请选择客服...</option>
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
					<button type="submit" class="btn btn-outline-primary" {if $errormsg || $type neq 2}disabled{/if}>{lang key='wechat::wechat.ok'}</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- {/block} -->