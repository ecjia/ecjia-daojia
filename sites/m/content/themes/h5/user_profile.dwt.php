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
    <div class="ecjia-list list-short height-3">
       <li>
            <a href="{url path='user/profile/edit_password'}">
    		<span class="icon-name margin-no-l">修改密码</span>
    		<span class="icon-price"></span>
    		<i class="iconfont  icon-jiantou-right  margin-r-icon"></i>
    		</a>
       </li>
   </div>
</div>
<div class="ecjia-bonus-top-list">
	<input class="btn btn-info nopjax" name="logout" type="submit" data-url="{url path='user/privilege/logout'}" value="退出登录">
</div>
<!-- {/block} -->