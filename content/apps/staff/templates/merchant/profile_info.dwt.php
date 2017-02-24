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
                    <li class="active"><a href="#photos">个人资料</a></li>
                    <li class=""><a class="data-pjax" href='{url path="staff/mh_profile/setting"}'>账户设置</a></li>
                    <li class=""><a class="data-pjax" href='{url path="staff/mh_profile/avatar"}'>头像设置</a></li>
                </ul>
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade active in" id="photos">  
                       <form method="post" name="profileForm" id="profileForm" action="{$form_action}">
                       		<br>
                            <div class="form-group controls">
                                <label>用户编号</label>
                                <input class="form-control" id="user_ident" name="user_ident" type="text" value="{$user_info.user_ident}" />
                            </div>
                            
                            <div class="form-group controls">
                                <label>用户姓名</label>
                                <input class="form-control" id="name" name="name" type="text" value="{$user_info.name}" />
                            </div>
                            
                            <div class="form-group controls">
                                <label>用户昵称</label>
                                 <input class="form-control" id="nick_name" name="nick_name" type="text" value="{$user_info.nick_name}"/>
                            </div>
                            
                            <div class="form-group controls">
                                <label>自我介绍</label>
                                <textarea class="form-control" id="introduction" name="introduction">{$user_info.introduction}</textarea>
                            </div>

                            {if $user_info.parent_id eq 0}
                            <div class="form-group">
                                <label>备注</label>
                                <textarea class="form-control" id="todolist" name="todolist">{$user_info.todolist}</textarea>
                                <p class="help-block">该备注仅店长可见</p>
                            </div>
                            {/if}
                            
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">提交</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- {/block} -->