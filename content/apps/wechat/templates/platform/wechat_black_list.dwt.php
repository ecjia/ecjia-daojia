<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-platform.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.platform.admin_subscribe.init();
</script>
<!-- {/block} -->
<!-- {block name="home-content"} -->

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">
                	黑名单同步操作
                </h4>
            </div>
            <div class="card-body">
				<div><button type="button" class="ajaxmenu btn btn-outline-primary" data-url='{RC_Uri::url("wechat/platform_subscribe/get_blackuserinfo")}' data-value="get_userinfo">{lang key='wechat::wechat.get_user_info'}</button><span style="margin-left: 20px;">{lang key='wechat::wechat.get_user_info_notice'}</span></div><br/>
			</div>
		</div>
	</div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
			<div class="card-header">
				<h4 class="card-title">
                	{$ur_here}
                </h4>
            </div>
			<div class="card-body">
				<div class="form-inline float-right">
					<form class="form-inline" method="post" action="{$form_action}{if $smarty.get.type}&type={$smarty.get.type}{/if}" name="search_from">
		          		<input type="text" name="keywords" value="{$smarty.get.keywords}" class="form-control m_r5" placeholder="{lang key='wechat::wechat.search_user_placeholder'}">
		            	<button type="submit" class="btn btn-outline-primary search-btn">{lang key='wechat::wechat.search'}</button>
		        	</form>
				</div>
			</div>
            <div class="col-md-12">
				<table class="table table-hide-edit">
					<thead>
						<tr>
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
								{if $val.headimgurl}
								<img class="thumbnail" src="{$val.headimgurl}">
								{else}
								<img class="thumbnail" src="{RC_Uri::admin_url('statics/images/nopic.png')}">
								{/if}
							</td>
							<td class="hide-edit-area">
								<span class="ecjaf-pre">
									{$val['nickname']}{if $val['sex'] == 1}{lang key='wechat::wechat.male_sign'}{else if $val.sex == 2}{lang key='wechat::wechat.female_sign'}{/if}<br/>{if $val.group_id eq 1 || $val.subscribe eq 0}{else}{if $val.tag_name eq ''}{lang key='wechat::wechat.no_tag'}{else}{$val.tag_name}{/if}{/if}
								</span>
								<div class="edit-list">
									<!-- {if $val.group_id eq 1} -->
									<a class="ajaxremove cursor_pointer" href='{RC_Uri::url("wechat/platform_subscribe/unblack_user","openid={$val.openid}")}' title="{lang key='wechat::wechat.remove_blacklist'}" data-toggle="ajaxremove" data-msg="{lang key='wechat::wechat.remove_blacklist_confirm'}">取消黑名单</a>
									<!-- {/if} -->
								</div>
							</td>
							<td>{$val['province']} - {$val['city']}</td>
							<td>{if $val['user_name']}{$val.user_name}{else}未绑定{/if}</td>
							<td>{RC_Time::local_date('Y-m-d H:i:s', ($val['subscribe_time']-8*3600))}</td>
						</tr>
						<!--  {foreachelse} -->
						<tr><td class="no-records" colspan="5">{lang key='system::system.no_records'}</td></tr>
						<!-- {/foreach} -->
					</tbody>
				</table>						
            </div>
            <!-- {$list.page} -->
        </div>
    </div>
</div>
<!-- {/block} -->