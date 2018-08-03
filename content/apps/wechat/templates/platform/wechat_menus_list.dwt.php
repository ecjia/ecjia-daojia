<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-platform.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.platform.wechat_menus_list.init();
</script>
<!-- {/block} -->
<!-- {block name="home-content"} -->

{if $warn && $type eq 0}
<div class="alert alert-danger">
	<strong>{lang key='wechat::wechat.label_notice'}</strong>{$type_error}
</div>
{/if}

{if $errormsg}
<div class="alert alert-danger">
	<strong>{lang key='wechat::wechat.label_notice'}</strong>{$errormsg}
</div>
{/if}

<div class="alert alert-light alert-dismissible mb-2" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">×</span>
	</button>
	<h4 class="alert-heading mb-2">操作提示</h4>
	<p>微信自定义菜单最多可添加3个一级菜单、5个二级菜单。</p>
	<p>微信自定义菜单分为发送消息，跳转网页，跳转小程序三种类型。发送消息是响应关键词指令，跳转网页则是直接跳转URL地址（填写绝对路径）。</p>
	<p>每次修改自定义菜单后，由于微信客户端缓存，需要24小时左右微信客户端才会显示生效。测试时可以尝试重新关注微信公众号，或者清除微信缓存。</p>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">
                	{lang key='wechat::wechat.wechat_menu'}
                </h4>
            </div>
            <div class="card-body">
				<div><button type="button" class="ajaxmenu btn btn-outline-primary" data-url='{RC_Uri::url("wechat/platform_menus/get_menu")}'>{lang key='wechat::wechat.get_menu'}</button><span style="margin-left: 20px;">{lang key='wechat::wechat.get_menu_notice'}</span></div><br/>
				<div><button type="button" class="ajaxmenu btn btn-outline-primary" data-url='{RC_Uri::url("wechat/platform_menus/delete_menu")}' data-msg="{lang key='wechat::wechat.clear_menu_confirm'}">{lang key='wechat::wechat.clear_menu'}</button><span style="margin-left: 20px;">{lang key='wechat::wechat.clear_menu_notice'}</span></div><br/>
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
            <div class="col-md-12">
				<div class="weixin-menu-content">
		            <div id="weixin-app-menu">
		                <div class="weixin-menu-right">
		                	<form class="form" name="the_form" method="post" action="{RC_Uri::url('wechat/platform_menus/update')}">
			                	<div class="weixin-menu-right-content">
			                		<div class="menu_initial_tips">点击左侧菜单进行编辑操作</div>
								</div>
							</form>
		                </div>
		                
		                <!-- 预览窗 -->
		                <div class="weixin-preview">
		                	<div class="mobile_menu_preview">
			                    <div class="weixin-hd">
			                        <div class="weixin-title">{$platformAccount->getAccountName()}</div>
			                    </div>
			                    <div class="weixin-bd">
			                        <ul class="weixin-menu" id="weixin-menu">
			                        	<!-- {foreach from=$menu_list item=list name=m} -->
			                            <li class="menu-item size_{$count}">
			                                <div class="menu-item-title" data-toggle="edit-menu" data-id="{$list.id}" data-pid="{$list.pid}">
			                                	{if $list.sub_button}
			                                	<i class="icon_menu_dot"></i>
			                                	{/if}
			                                    <span>{$list.name}</span>
			                                </div>
			                                
			                                <ul class="weixin-sub-menu hide">
			                                	<!-- {foreach from=$list.sub_button item=sub name=s} -->
			                                	<li class="menu-sub-item {if $id eq $sub.id}current{/if}">
			                                		<div class="menu-item-title" data-toggle="edit-menu" data-id="{$sub.id}" data-pid="{$sub.pid}">{$sub.name}</div>
			                                	</li>
			                                	<!-- {/foreach} -->
			                                	
			                                	{if $list.count lt 5}
			                                    <li class="menu-sub-item" data-toggle="add-menu" data-pid="{$list.id}" data-count="{$list.count}">
			                                        <div class="menu-item-title">
			                                            <a class="pre_menu_link" href="javascript:void(0);" title="最多添加5个子菜单"><i class="icon14_menu_add"></i></a>
			                                        </div>
			                                    </li>
			                                    {/if}
			                                    <i class="menu-arrow arrow_out"></i>
			                                    <i class="menu-arrow arrow_in"></i>
			                                </ul>
			                            </li>
			                            <!-- {/foreach} -->
			                            
			                            {if $count lt 3}
			                            <li class="menu-item size_{$count}" data-toggle="add-menu" data-pid="0"><a class="pre_menu_link" href="javascript:void(0);" title="最多添加3个一级菜单"> <i class="icon14_menu_add"></i> {if $count eq 0}<span>添加菜单</span>{/if}</a></li>
			                            {/if}
			                        </ul>
			                    </div>
			            	</div>
		                </div>
		                
		            </div>
		            
		            {if $menu_list}
		            <div class="weixin-btn-group">
		                <div data-toggle="btn-create" class="btn btn-outline-primary m_l20" data-url='{RC_Uri::url("wechat/platform_menus/sys_menu")}' data-msg="发布成功后会覆盖原版本，且将在24小时内对所有用户生效，确认发布？">发布</div>
		            </div>
		            {/if}
		            
		            <input type="hidden" name="add_url" value="{$form_action}" />
		            <input type="hidden" name="edit_url" value="{$edit_url}" />
		            <input type="hidden" name="del_url" value="{$del_url}" />
		            <input type="hidden" name="check_url" value="{$check_url}" />
		        </div>
            </div>
        </div>
    </div>
</div>
<!-- {/block} -->