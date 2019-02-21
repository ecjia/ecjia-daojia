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
                	{t domain="wechat"}黑名单同步操作{/t}
                </h4>
            </div>
            <div class="card-body">
				<div><button type="button" class="ajaxmenu btn btn-outline-primary" data-url='{RC_Uri::url("wechat/platform_subscribe/get_blackuserinfo")}' data-value="get_userinfo">{t domain="wechat"}获取用户信息{/t}</button><span style="margin-left: 20px;">{t domain="wechat"}通过点击该按钮可以获取微信端用户信息到本地。{/t}</span></div><br/>
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
		          		<input type="text" name="keywords" value="{$smarty.get.keywords}" class="form-control m_r5" placeholder='{t domain="wechat"}请输入昵称/省/市搜索{/t}'>
		            	<button type="submit" class="btn btn-outline-primary search-btn">{t domain="wechat"}搜索{/t}</button>
		        	</form>
				</div>
			</div>
            <div class="col-md-12">
				<table class="table table-hide-edit">
					<thead>
						<tr>
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
								{if $val.headimgurl}
								<img class="thumbnail" src="{$val.headimgurl}">
								{else}
								<img class="thumbnail" src="{RC_Uri::admin_url('statics/images/nopic.png')}">
								{/if}
							</td>
							<td class="hide-edit-area">
								<span class="ecjaf-pre">
									{$val['nickname']}{if $val['sex'] == 1}{t domain="wechat"}（男）{/t}{else if $val.sex == 2}{t domain="wechat"}（女）{/t}{/if}<br/>{if $val.group_id eq 1 || $val.subscribe eq 0}{else}{if $val.tag_name eq ''}{t domain="wechat"}无标签{/t}{else}{$val.tag_name}{/if}{/if}
								</span>
								<div class="edit-list">
									<!-- {if $val.group_id eq 1} -->
									<a class="ajaxremove cursor_pointer" href='{RC_Uri::url("wechat/platform_subscribe/unblack_user", "openid={$val.openid}")}' title='{t domain="wechat"}移出黑名单{/t}' data-toggle="ajaxremove" data-msg='{t domain="wechat"}您确定要将该用户移出黑名单吗？{/t}'>{t domain="wechat"}取消黑名单{/t}</a>
									<!-- {/if} -->
								</div>
							</td>
							<td>{$val['province']} - {$val['city']}</td>
							<td>{if $val['user_name']}{$val.user_name}{else}{t domain="wechat"}未绑定{/t}{/if}</td>
							<td>{RC_Time::local_date('Y-m-d H:i:s', ($val['subscribe_time']-8*3600))}</td>
						</tr>
						<!--  {foreachelse} -->
						<tr><td class="no-records" colspan="5">{t domain="wechat"}没有找到任何记录{/t}</td></tr>
						<!-- {/foreach} -->
					</tbody>
				</table>						
            </div>
            <!-- {$list.page} -->
        </div>
    </div>
</div>
<!-- {/block} -->