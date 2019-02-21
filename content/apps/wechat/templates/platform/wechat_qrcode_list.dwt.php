<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-platform.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.platform.wechat_qrcode_list.init();
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
	<h4 class="alert-heading mb-2">操作提示</h4>
	<p>{t domain="wechat"}渠道二维码。可生成临时二维码或永久二维码 用于线下某些场景展示，让用户扫描关注，效果类似关注微信公众号。{/t}</p>
	<p>{t domain="wechat"}临时二维码，是有过期时间的，最长可以设置为在二维码生成后的30天（即2592000秒）后过期，但能够生成较多数量。临时二维码主要用于帐号绑定等不要求二维码永久保存的业务场景。{/t}</p>
	<p>{t domain="wechat"}永久二维码，是无过期时间的，但数量较少（目前为最多10万个）。永久二维码主要用于适用于帐号绑定、用户来源统计等场景。{/t}</p>
	<p>{t domain="wechat"}应用场景值ID，为整型时：临时二维码时为32位非0整型（100001-4294967295），永久二维码时最大值为100000（目前参数只支持1--100000），为字符串类型时：长度限制为1到64。{/t}</p>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
			<div class="card-header">
                <h4 class="card-title">
                	{$ur_here}
	               	{if $action_link}
					<a class="btn btn-outline-primary plus_or_reply data-pjax float-right" href="{$action_link.href}{if isset($smarty.get.type)}&type={$smarty.get.type}{/if}" id="sticky_a"><i class="ft-plus"></i> {$action_link.text}</a>
					{/if}
                </h4>
            </div>
            
            <div class="col-lg-12">
	            <ul class="nav nav-pills float-left">
					<li class="nav-item">
						<a class="nav-link data-pjax {if $smarty.get.type eq '' || $smarty.get.type eq '1'}active{/if}" href='{url path="wechat/platform_qrcode/init"}&type=1{if $listdb.filter.keywords}&keywords={$listdb.filter.keywords}{/if}'>
                            {t domain="wechat"}永久二维码{/t}<span class="badge badge-pill badge-glow badge-default badge-primary ml-1">{$listdb.count.forever}</span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link data-pjax {if $smarty.get.type eq '0'}active{/if}" href='{url path="wechat/platform_qrcode/init" args="type=0{if $listdb.filter.keywords}&keywords={$listdb.filter.keywords}{/if}"}'>
                            {t domain="wechat"}临时二维码{/t}<span class="badge badge-pill badge-glow badge-default badge-primary ml-1">{$listdb.count.temporary}</span></a>
					</li>
				</ul>
			</div>
					
            <div class="card-body">
	            <div class="heading-elements float-left">
					<button type="button" class="btn btn-outline-primary dropdown-toggle" data-toggle="dropdown"><i class="ft-settings"></i> {t domain="wechat"}批量操作{/t}</button>
					<div class="dropdown-menu">
						<a class="dropdown-item button_remove" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url='{url path="wechat/platform_qrcode/batch"}{if isset($smarty.get.type)}&type={$smarty.get.type}{/if}' data-msg='{t domain="wechat"}您确定要删除该二维码吗？{/t}' data-noSelectMsg='{t domain="wechat"}请先选中要删除的二维码{/t}' data-name="id" href="javascript:;"><i class="ft-trash-2"></i> {t domain="wechat"}删除二维码{/t}</a>
					</div>
				</div>
				<div class="form-inline float-right">
					<form class="form-inline" method="post" action="{$search_action}" name="searchForm">
		          		<input type="text" name="keywords" value="{$listdb.filter.keywords}" class="form-control m_r5" placeholder='{t domain="wechat"}请输入功能关键字{/t}'>
		            	<button type="button" class="btn btn-outline-primary search_qrcode">{t domain="wechat"}搜索{/t}</button>
		        	</form>
				</div>
			</div>
			
            <div class="col-md-12">
				<table class="table table-hide-edit">
					<thead>
						<tr>
							<th class="table_checkbox w30">
								<input type="checkbox" data-toggle="selectall" data-children=".checkbox" id="customCheck"/>
								<label for="customCheck"></label>
							</th>
							<th class="w200">{t domain="wechat"}应用场景{/t}</th>
							<th class="w150">{t domain="wechat"}功能{/t}</th>
							<th class="w200">{t domain="wechat"}过期时间{/t}</th>
							<th class="w100">{t domain="wechat"}扫码次数{/t}</th>
							<th class="w150">{t domain="wechat"}状态{/t}</th>
							<th class="w100">{t domain="wechat"}排序{/t}</th>
						</tr>
					</thead>
					<tbody>
						<!-- {foreach from=$listdb.qrcode_list item=val key=key} -->
						<tr>
							<td>
								<input class="checkbox" type="checkbox" name="checkboxes[]" value="{$val.id}" id="checkbox_{$key}" />
								<label for="checkbox_{$key}"></label>
							</td>
							<td class="hide-edit-area">
								{$val.scene_id}
					    		<div class="edit-list">
							     	{assign var=view_url value=RC_Uri::url('wechat/platform_qrcode/qrcode_get',"id={$val.id}")}
						      		<a class="ajaxwechat" href="{$view_url}">{t domain="wechat"}获取二维码{/t}</a>&nbsp;|&nbsp;
						      		<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg='{t domain="wechat"}您确定要删除该二维码吗？{/t}' href='{RC_Uri::url("wechat/platform_qrcode/remove", "id={$val.id}")}'>{t domain="wechat"}删除{/t}</a>
							    </div>
							</td>
							<td>
								{$val.function}
							</td>
							<td>
								{RC_Time::local_date('Y-m-d H:i', $val.endtime)}
							</td>
							<td>{$val.scan_num}</td>
							<td>
                                <i class="{if $val.status eq 1}fa fa-check{else}fa fa-times{/if} cursor_pointer" data-trigger="toggleState" data-url="{RC_Uri::url('wechat/platform_qrcode/toggle_show')}" data-id="{$val.id}" ></i>
							</td>
							<td><span class="cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('wechat/platform_qrcode/edit_sort')}" data-name="sort" data-pk="{$val.id}" data-title='{t domain="wechat"}编辑二维码排序{/t}'>{$val.sort}</span></td>
						</tr>
						<!--  {foreachelse} -->
						<tr><td class="no-records" colspan="7">{t domain="wechat"}没有找到任何记录{/t}</td></tr>
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
				<h3 class="modal-title">{t domain="wechat"}渠道二维码{/t}</h3>
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