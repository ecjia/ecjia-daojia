<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.merchant.profile_info.init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->
<div class="row">
	<div class="col-lg-12">
		<h2 class="page-header">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		{if $action_link}
		<a class="btn btn-info data-pjax pull-right" href="{$action_link.href}" id="sticky_a"><i class="fa fa-reply"></i> {$action_link.text} </a>
		{/if}
		</h2>
	</div>
</div>

<div class="row" id="real-estates-detail">
	<!-- #BeginLibraryItem "/library/profile_setting.lbi" --><!-- #EndLibraryItem -->
    <div class="col-lg-8 col-md-8 col-xs-12">
        <div class="panel">
            <div class="panel-body">
                <ul id="myTab" class="nav nav-pills">
                    <li class="active"><a href="#photos">{t domain="staff"}个人资料{/t}</a></li>
                    <li class=""><a class="data-pjax" href='{url path="staff/mh_profile/setting"}'>{t domain="staff"}账户设置{/t}</a></li>
                    <li class=""><a class="data-pjax" href='{url path="staff/mh_profile/avatar"}'>{t domain="staff"}头像设置{/t}</a></li>
                </ul>
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade active in" id="photos">  
                       <form method="post" name="profileForm" id="profileForm" action="{$form_action}">
                       		<br>
                            <div class="form-group controls">
                                <label>{t domain="staff"}用户编号{/t}</label>
                                <input class="form-control" id="user_ident" name="user_ident" type="text" value="{$user_info.user_ident}" />
                            </div>
                            
                            <div class="form-group controls">
                                <label>{t domain="staff"}用户姓名{/t}</label>
                                <input class="form-control" id="name" name="name" type="text" value="{$user_info.name}" />
                            </div>
                            
                            <div class="form-group controls">
                                <label>{t domain="staff"}用户昵称{/t}</label>
                                 <input class="form-control" id="nick_name" name="nick_name" type="text" value="{$user_info.nick_name}"/>
                            </div>
                            
                            <div class="form-group controls">
                                <label>{t domain="staff"}自我介绍{/t}</label>
                                <textarea class="form-control" id="introduction" name="introduction">{$user_info.introduction}</textarea>
                            </div>

                            {if $user_info.parent_id eq 0}
                            <div class="form-group">
                                <label>{t domain="staff"}备注{/t}</label>
                                <textarea class="form-control" id="todolist" name="todolist">{$user_info.todolist}</textarea>
                                <p class="help-block">{t domain="staff"}该备注仅店长可见{/t}</p>
                            </div>
                            {/if}
                            
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">{t domain="staff"}提交{/t}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- {/block} -->