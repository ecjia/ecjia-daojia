<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-platform.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.platform.wechat_qrcodeshare_list.init();
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

<div class="alert alert-light alert-dismissible mb-2" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">×</span>
	</button>
	<h4 class="alert-heading mb-2">{t domain="wechat"}操作提示{/t}</h4>
	<p>{t domain="wechat"}推荐二维码：即管理员可以使用网站已有会员生成带推荐功能的二维码（默认永久二维码），让新用户扫码关注，即与推荐人形成上下级关系。{/t}</p>
	<p>{t domain="wechat"}添加用户推荐二维码，需要开通插件"mp_qrcode"后，通过公众号里菜单或输入命令"qrcode"获取每个用户的推荐码。{/t}</p>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
			<div class="card-header">
                <h4 class="card-title">
                	{$ur_here}
                </h4>
            </div>
            <div class="col-md-12">
				<table class="table table-hide-edit">
					<thead>
						<tr>
							<th class="w150">{t domain="wechat"}推荐人{/t}</th>
							<th class="w150">{t domain="wechat"}功能{/t}</th>
							<th class="w100">{t domain="wechat"}扫码次数{/t}</th>
							<th class="w100">{t domain="wechat"}创建时间{/t}</th>
						</tr>
					</thead>
					<tbody>
						<!-- {foreach from=$listdb.share_list item=val} -->
						<tr>
							<td class="hide-edit-area">
								{$val.username}
					    		<div class="edit-list">
							     	{assign var=view_url value=RC_Uri::url('wechat/platform_qrcode/qrcode_get', "id={$val.id}")}
						      		<a class="ajaxwechat" href="{$view_url}" title='{t domain="wechat"}查看{/t}'>{t domain="wechat"}获取二维码{/t}</a>&nbsp;|&nbsp;
						      		<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg='{t domain="wechat"}您确定要删除该二维码吗？{/t}' href='{RC_Uri::url("wechat/platform_share/remove", "id={$val.id}")}' title='{t domain="wechat"}删除{/t}'>{t domain="wechat"}删除{/t}</a>
							    </div>
							</td>
							<td>
								{$val.function}
							</td>
							<td>
								{$val['scan_num']}
							</td>
							<td>
								{RC_Time::local_date('Y-m-d H:i', $val.endtime)}
							</td>
						</tr>
						<!--  {foreachelse} -->
						<tr><td class="no-records" colspan="4">{t domain="wechat"}没有找到任何记录{/t}</td></tr>
						<!-- {/foreach} -->
					</tbody>
				</table>
            </div>
            <!-- {$listdb.page} -->
        </div>
    </div>
</div>

<div class="modal fade text-left" id="show_qrcode">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title">{t domain="wechat"}推荐二维码{/t}</h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body text-center">
			</div>
		</div>
	</div>
</div>

<!-- {/block} -->