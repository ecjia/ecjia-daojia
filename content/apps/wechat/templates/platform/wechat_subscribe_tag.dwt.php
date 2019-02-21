<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-platform.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.platform.admin_subscribe.init();
</script>
<!-- {/block} -->
<!-- {block name="home-content"} -->

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
	<p>{t domain="wechat"}标签管理，一个公众号，最多可以创建100个标签。每个公众号可以为用户打上最多20个标签。{/t}</p>
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
				<div>
                    <button type="button" class="ajaxmenu btn btn-outline-primary" data-url='{RC_Uri::url("wechat/platform_subscribe/get_usertag")}' data-value="get_usertag">{t domain="wechat"}获取用户标签{/t}</button>
                    <span style="margin-left: 20px;">{t domain="wechat"}通过点击该按钮可以获取微信端用户标签到本地。{/t}</span>
                </div><br/>
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
	               	{if $action_link}
					<a class="btn btn-outline-primary plus_or_reply data-pjax float-right subscribe-icon-plus" href="{$action_link.href}" id="sticky_a"><i class="fa fa-plus"></i> {$action_link.text}</a>
					{/if}
                </h4>
            </div>
            <div class="col-md-12">
				<table class="table table-hide-edit">
					<thead>
						<tr>
							<th class="w150">{t domain="wechat"}标签名称{/t}</th>
							<th class="w150">{t domain="wechat"}用户数{/t}</th>
							<th class="w100">{t domain="wechat"}操作{/t}</th>
						</tr>
					</thead>
					<tbody>
						
						<!-- {foreach from=$list.item item=val} -->
						<tr>
							<td><a href="{RC_Uri::url('wechat/platform_subscribe/init')}&tag_id={$val.tag_id}" target="__blank">{$val.name}</a></td>
							<td>{$val.count}</td>
							<td>
								{if $val['tag_id'] != 0  && $val['tag_id'] != 1 && $val['tag_id'] != 2}
								<a class="subscribe-icon-edit {if $val.id eq $smarty.get.id}white{/if}" title='{t domain="wechat"}编辑用户标签{/t}' data-name="{$val.name}" value="{$val.id}"><i class="ft-edit f_s15"></i></a>
								<a class="ajaxremove no-underline {if $val.id eq $smarty.get.id}white{/if}" data-toggle="ajaxremove" data-msg='{t domain="wechat"}您确定要删除该标签吗？{/t}' href='{RC_Uri::url("wechat/platform_subscribe/remove","id={$val.id}&tag_id={$val.tag_id}")}' title='{t domain="wechat"}删除用户标签{/t}'><i class="ft-trash-2 f_s15 m_l5"></i></a>
								{/if}
							</td>
						</tr>
						<!--  {foreachelse} -->
						<tr><td class="no-records" colspan="3">{t domain="wechat"}没有找到任何记录{/t}</td></tr>
						<!-- {/foreach} -->
					</tbody>
				</table>						
            </div>
            <!-- {$list.page} -->
        </div>
    </div>
</div>

<div class="modal fade text-left" id="add_tag">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title">{t domain="wechat"}添加用户标签{/t}</h3>
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

			<form class="form" method="post" name="add_tag" action="{url path='wechat/platform_subscribe/edit_tag'}">
				<div class="card-body">
					<div class="form-body">
						<div class="form-group row">
							<label class="col-md-3 label-control new_tag_name text-right">{t domain="wechat"}标签名称：{/t}</label>
							<div class="col-md-8 controls">
								<input class="form-control" type="text" name="new_tag" autocomplete="off"/>
							</div>
							<div class="col-md-1"><span class="input-must">*</span></div>
						</div>
					</div>
				</div>

				<div class="modal-footer justify-content-center">
			   		<input type="hidden" name="openid" />
					<input type="submit" class="btn btn-outline-primary" {if $errormsg}disabled{/if} value='{t domain="wechat"}确定{/t}' />
				</div>
			</form>

		</div>
	</div>
</div>

<div class="modal fade text-left" id="edit_tag">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title">{t domain="wechat"}编辑用户标签{/t}</h3>
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

			<form class="form" method="post" name="edit_tag" action="{url path='wechat/platform_subscribe/edit_tag'}">
				<div class="card-body">
					<div class="form-body">

						<div class="form-group row">
							<label class="col-md-3 label-control old_tag_name text-right">{t domain="wechat"}原标签名：{/t}</label>
							<div class="col-md-8">
								<span class="old_tag"></span>
							</div>
						</div>

						<div class="form-group row">
							<label class="col-md-3 label-control text-right">{t domain="wechat"}新标签名：{/t}</label>
							<div class="col-md-8 controls">
								<input class="form-control" type="text" name="new_tag" autocomplete="off" />
							</div>
							<div class="col-md-1"><span class="input-must">*</span></div>
						</div>
						
					</div>
				</div>

				<div class="modal-footer justify-content-center">
			   		<input type="hidden" name="id" />
					<input type="submit" class="btn btn-outline-primary" {if $errormsg}disabled{/if} value='{t domain="wechat"}确定{/t}' />
				</div>
			</form>

		</div>
	</div>
</div>

<!-- {/block} -->