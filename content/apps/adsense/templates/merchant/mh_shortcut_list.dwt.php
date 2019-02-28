<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.merchant.mh_shortcut.shortcut_list();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->
{if $cycimage_config}
	<div class="alert alert-info">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-times" data-original-title="" title=""></i></button>
		<strong>{t domain="adsense"}温馨提示：{/t}</strong>{t domain="adsense"}请您先启用菜单组。{/t}
	</div>
{/if}

<div class="row">
    <div class="col-lg-12">
        <div class="tab-content">
            <div class="panel">
                <div class="panel-body">
                	<div class="col-lg-3">
						<div class="setting-group">
					        <span class="setting-group-title"><i class="fa fa-gear"></i> {t domain="adsense"}菜单组{/t}</span>
					        <!-- {if $data} -->
					        <ul class="nav nav-list m_t10 change">
						        <!-- {foreach from=$data item=val} -->
						        	<li><a class="setting-group-item data-pjax {if $position_id eq $val.position_id}llv-active{/if}" href='{url path="adsense/mh_shortcut/init" args="position_id={$val.position_id}"}'>{$val.position_name}</a></li>
						        <!-- {/foreach} -->
					        </ul>
					        <!-- {/if} -->
						</div>
					</div>
					
					<div class="col-lg-9">
						<div class="panel-body panel-body-small">
							<h2 class="page-header">
								{if $ur_here}{$ur_here}{/if}{if $position_code}（{$position_code}）{/if}
								<div class="pull-right">
								 		<a href='{RC_Uri::url("adsense/mh_shortcut/edit_group","position_id={$position_id}")}' class="btn btn-primary data-pjax" title='{t domain="adsense"}编辑{/t}'><i class="fa fa-edit"></i> {t domain="adsense"}编辑菜单组{/t}</a>
									{if $cycimage_config}
										<a id="ajaxstart" href='{RC_Uri::url("adsense/mh_shortcut/insert_group")}' class="btn btn-primary" title='{t domain="adsense"}启用{/t}'><i class="fa fa-check-square-o"></i> {t domain="adsense"}启用菜单组{/t}</a>
									{else}
										<a data-toggle="ajaxremove" class="ajaxremove btn btn-primary"  data-msg='{t domain="adsense"}您要关闭该菜单组么？{/t}'  href='{RC_Uri::url("adsense/mh_shortcut/delete_group","position_id={$position_id}")}' title='{t domain="adsense"}关闭{/t}'><i class="fa fa-minus-square"></i> {t domain="adsense"}关闭菜单组{/t}</a>
									{/if}
								</div>
							</h2>

							<!-- {if $available_clients} -->
							<ul class="nav nav-pills pull-left">
						 		<!-- {foreach from=$available_clients key=key item=val} -->
									<li class="{if $show_client eq $client_list.$key}active{/if}"><a class="data-pjax" href='{url path="adsense/mh_shortcut/init" args="show_client={$client_list.$key}&position_id={$position_id}"}'>{$key}<span class="badge badge-info">{$val}</span></a></li>
								<!-- {/foreach} -->
							</ul>
							<!-- {/if} -->
							
							<section class="panel">
								<table class="table table-striped table-hover table-hide-edit ecjiaf-tlf">
									<thead>
										<tr>
											<th class="w150">{t domain="adsense"}缩略图{/t}</th>
											<th>{t domain="adsense"}图片链接{/t}</th>
											<th class="w100">{t domain="adsense"}是否开启{/t}</th>
											<th class="w50">{t domain="adsense"}排序{/t}</th>
										</tr>
									</thead>
									<tbody>
										<!-- {foreach from=$shortcut_list item=item key=key} -->
										<tr>
											<td>
												{if $item.ad_code}
													<img src="{RC_Upload::upload_url()}/{$item.ad_code}" width="100" height="90">
												{/if}
											</td>
											<td class="hide-edit-area">
												<span><a href="{$item.ad_link}" target="_blank">{$item.ad_link}</a></span><br>
												{$item.ad_name}
												<div class="edit-list">
													<a class="data-pjax" href='{RC_Uri::url("adsense/mh_shortcut/edit", "id={$item.ad_id}&show_client={$show_client}")}' title='{t domain="adsense"}编辑{/t}'>{t domain="adsense"}编辑{/t}</a>&nbsp;|&nbsp;
													<a data-toggle="ajaxremove" class="ajaxremove ecjiafc-red" data-msg='{t domain="adsense"}您要删除该菜单么？{/t}' href='{RC_Uri::url("adsense/mh_shortcut/delete", "id={$item.ad_id}&position_id={$position_id}")}' title='{t domain="adsense"}删除{/t}'>{t domain="adsense"}删除{/t}</a>
											    </div>
											</td>
											<td>
										    	<i class="cursor_pointer fa {if $item.enabled}fa-check {else}fa-times{/if}" data-trigger="toggleState" data-url='{RC_Uri::url("adsense/mh_shortcut/toggle_show","position_id={$position_id}&show_client={$show_client}")}' data-id="{$item.ad_id}"></i>
											</td>
											<td>
												<span class="cursor_pointer" data-trigger="editable" data-placement="left" data-url='{RC_Uri::url("adsense/mh_shortcut/edit_sort", "position_id={$position_id}&show_client={$show_client}")}' data-name="sort_order" data-pk="{$item.ad_id}" data-title='{t domain="adsense"}请输入排序序号{/t}'>
												{$item.sort_order}
												</span>
											</td>
										</tr>
										<!-- {foreachelse} -->
										   <tr><td class="no-records" colspan="4">{t domain="adsense"}没有找到任何记录{/t}</td></tr>
										<!-- {/foreach} -->
									</tbody>
								</table>
							</section>
							{if !$cycimage_config}
								<a href='{RC_Uri::url("adsense/mh_shortcut/add","position_id={$position_id}")}' class="btn btn-primary data-pjax"><i class="fa fa-plus"></i> {t domain="adsense"}添加菜单{/t}</a>
							{/if}
						</div>
					</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- {/block} -->