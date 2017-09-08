<?php
/*
Name:  会员中心：编辑个人资料模板
Description:  会员中心：编辑个人资料首页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">ecjia.touch.user.init();</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<div class="ecjia-user ecjia-account">
    <div class="ecjia-user ecjia-user-head ecjia-account">
        <ul class="ecjia-list list-short nmargin-t">
            <li class="account-phone">
            	<span class="icon-name margin-no-l">头像 </span>
        		<div class="user-img-text"><img src="{$user_img}"></div>
            </li>
            <li class="height-3">
               <a href="{url path='user/profile/modify_username'}">
            		<span class="icon-name margin-no-l">用户名 </span>
            		<span class="icon-price text-color">{$user.name}</span>
            		<i class="iconfont icon-jiantou-right  margin-r-icon"></i>
        	   </a>
            </li>
            <li class="ecjia-user-border-b height-3">
                <a>
            	<span class="icon-name margin-no-l">用户等级</span>
        		<span class="icon-price text-color">{$user.rank_name}</span></a>
            </li>
        </ul>
    </div>
    <div class="ecjia-list list-short">
        <li>
            <a href="{url path="user/profile/{if $user.mobile_phone}bind_info{else}account_bind{/if}" args='type=mobile'}">
        		<span class="icon-name margin-no-l">绑定手机</span>
        		<span class="icon-price">{if $user.mobile_phone}{$user.mobile_phone}{else}未绑定{/if}</span>
        		<i class="iconfont  icon-jiantou-right  margin-r-icon"></i>
    		</a>
       </li>
       <li>
            <a href="{url path="user/profile/{if $user.email}bind_info{else}account_bind{/if}" args='type=email'}">
        		<span class="icon-name margin-no-l">绑定邮箱</span>
        		<span class="icon-price">{if $user.email}{$user.email}{else}未绑定{/if}</span>
        		<i class="iconfont  icon-jiantou-right  margin-r-icon"></i>
    		</a>
       </li>
       <li>
            <a href="{url path='user/profile/edit_password'}">
        		<span class="icon-name margin-no-l">修改密码</span>
        		<span class="icon-price"></span>
        		<i class="iconfont  icon-jiantou-right  margin-r-icon"></i>
    		</a>
       </li>
   </div>
</div>
<!-- {if !$is_weixin} -->
<div class="ecjia-button-top-list">
	<input class="btn btn-info nopjax external" name="logout" type="submit" data-url="{url path='user/privilege/logout'}" value="退出登录">
</div>
<!-- {/if} -->
<!-- {/block} -->