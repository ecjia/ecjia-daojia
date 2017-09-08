<?php defined('IN_ECJIA') or exit('No permission resources.');?>
{if !$smarty.session.staff_id}
<div class="header-top">
    <!-- start:navbar -->
    <nav class="navbar navbar-inverse navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="container">
            <!-- start:navbar-header -->
            <div class="navbar-header">
                <a class="navbar-brand" href="{if $shop_title_link}{$shop_title_link}{else}{RC_Uri::url('franchisee/merchant/init')}{/if}"><i class="fa fa-cubes"></i> <strong>{ecjia::config('shop_name')} - {if $shop_title}{$shop_title}{else}商家入驻{/if}</strong></a>
            </div>
            <!-- end:navbar-header -->
            <ul class="nav navbar-nav navbar-left top-menu">
                <!-- start dropdown 3 -->
                <!-- end dropdown 3 -->
            </ul>
            <ul class="nav navbar-nav navbar-right top-menu">
            	<a class="ecjiafc-white l_h30" href='{RC_Uri::home_url()}'><i class="fa fa-reply"></i> 网站首页</a>
            </ul>
        </div>
    </nav>
    <!-- end:navbar -->
</div>
<!-- start:header -->
<div id="header" {if $background_url}style="background: url({$background_url}) no-repeat center center fixed;"{/if}>
    <div class="overlay">
        <nav class="navbar" role="navigation">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="btn-block btn-drop navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                        <strong>MENU</strong>
                    </button>
                </div>
            
                <div class="collapse navbar-collapse navbar-ex1-collapse">
                    <ul class="nav navbar-nav m_t40">
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</div>
<!-- end:header -->
{else}
<div class="header-top">
    <!-- start:navbar -->
    <nav class="navbar navbar-inverse navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="container">
            <!-- start:navbar-header -->
            <div class="navbar-header">
                <a class="navbar-brand" href="{url path='merchant/dashboard/init'}"><i class="fa fa-cubes"></i> <strong>{$ecjia_merchant_cpname}</strong></a>
            </div>
            <!-- end:navbar-header -->
            <ul class="nav navbar-nav navbar-left top-menu">
                <!-- start dropdown 3 -->
                <li id="header_notification_bar" class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="javascript:;">
                        <i class="fa fa-bell-o"></i>
                        {if $ecjia_merchant_notice_count neq 0}
                        <span class="badge bg-warning">{$ecjia_merchant_notice_count}</span>
                        {/if}
                    </a>
                    <ul class="dropdown-menu extended notification">
                        <div class="notify-arrow notify-arrow-yellow"></div>
                        <li>
                            <p class="yellow">您有 {$ecjia_merchant_notice_count} 条新通知</p>
                        </li>
                  		<div class="mh300 ecjiaf-oa">
                        <!-- {foreach from=$ecjia_merchant_notice_list item=val} -->
                        <li>
                            <a href='{url path="notification/mh_notification/init" args="status=not_read"}'>
                                <div class="f_l">
	                                <span class="label label-info">
	                                	{if $val.type eq 'order_reminder'}
	                                	<i class="fa fa-bullhorn"></i>
	                                	{else if $val.type eq 'push_event'}
	                                	<i class="fa fa-comment"></i>
	                                	{else}
	                                	<i class="fa fa-bullhorn"></i>
	                                	{/if}
	                                </span>
                                </div>
                                <div class="f_l mw160">
                                	{$val.content}
                                </div>
                            </a>
                        </li>
                        <!-- {foreachelse} -->
                      	<li>
                            <a href='javascript:;'>
                                <span class="label label-info">
                                	<i class="fa fa-bullhorn"></i>
                                </span>
                                <span class="m_l5">暂无新通知</span>
                                <span class="small italic"></span>
                            </a>
                        </li>
                 		<!-- {/foreach} -->
                        </div>
                        <li {if $ecjia_merchant_notice_count gt 0}class="ecjiaf-bt"{/if}>
                            <a href="{url path='notification/mh_notification/init'}">查看所有通知</a>
                        </li>
                    </ul>
                </li>
                <!-- end dropdown 3 -->
            </ul>
            <ul class="nav navbar-nav navbar-right top-menu">
                <li class="dropdown">
                    <input type="text" class="form-control input-sm search_query" placeholder="搜索" data-toggle="dropdown">
                   	<ul class="dropdown-menu search-nav">
                   		<li class="search_query_none"><a href="javascript:;">{t}请先输入搜索信息{/t}</a></li>
						<!--{ecjia:hook id=merchant_sidebar_collapse_search}-->
                   	</ul>
                </li>
                <!-- user login dropdown start-->
                <li class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="index.html#">
                    	{if $ecjia_staff_logo}
                        <img alt="" width="30" height="30" src="{RC_Upload::upload_url()}/{$ecjia_staff_logo}">
                        {else}
                        <img alt="" width="30" height="30" src="{$ecjia_main_static_url}img/ecjia_avatar.jpg">
                        {/if}
                        <span class="username">{$smarty.session.staff_name}</span>
                        <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                        <div class="log-arrow-up"></div>
                        <li><a href="{url path='staff/mh_profile/init'}"><i class="fa fa-cog"></i> 个人设置</a></li>
                        <li><a href="{url path='notification/mh_notification/init'}"><i class="fa fa-bell-o"></i> 通知</a></li>
                        <li class="divider"></li>
                        <li><a href="{url path='staff/privilege/logout'}"><i class="fa fa-key"></i> 退出</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
    <!-- end:navbar -->
</div>
<!-- start:header -->
<div id="header" 
{if $background_url}
style="background: url({$background_url}) no-repeat center center fixed;	
-webkit-background-size: cover;
-moz-background-size: cover;
-ms-background-size: cover;
-o-background-size: cover;
background-size: cover;
border-bottom: 15px solid #f2f2f2;"
{/if}>
    <div class="overlay">
        <nav class="navbar" role="navigation">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="btn-block btn-drop navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                        <strong>MENU</strong>
                    </button>
                </div>
            
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse navbar-ex1-collapse">
                	<!-- {if $current_order} -->
                	<ul class="nav navbar-nav current-order-navbar">
	                	<div class="current-order-header">订单快速处理</div>
                	</ul>
                	<!-- {else} -->
                    <!-- {ecjia:hook id=merchant_print_header_nav} -->
                    <!-- {/if} -->
                </div><!-- /.navbar-collapse -->
            </div>
        </nav>
    </div>
</div>
<!-- end:header -->
{/if}