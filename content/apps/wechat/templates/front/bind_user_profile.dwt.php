{nocache}
<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0"/>
<meta http-equiv="X-UA-Compatible" content="IE=8,IE=9,IE=10,IE=11"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<head lang="zh-CN">
		<title>用户中心</title>
		<link rel="stylesheet" type="text/css" href="{$front_url}/css/touch.css" />
		<link rel="stylesheet" type="text/css" href="{$front_url}/css/style.css" />
	</head>
	
	<body>
		<div class="ecjia-user-info user-new-info ecjia-user">
	    	<div class="user-img ecjiaf-fl"><img src="{if $user_info.wechat_image}{$user_info.wechat_image}{else}{$icon_wechat_user}{/if}"></div>
	    	<div class="ecjiaf-fl ecjia-margin-l user-rank-name">
	    		<span class="ecjia-user-buttom">{$user_info.user_name}</span>
	    	</div>
	    </div>
    
		<div class="ecjia-user ecjia-account">
		    <div class="ecjia-user ecjia-user-head ecjia-account">
		        <ul class="ecjia-list list-short nmargin-t">
		            <li>
	            		<span class="icon-name margin-no-l">用户名 </span>
	            		<span class="icon-price text-color">{$user_info.user_name}</span>
		            </li>
		            <li>
		            	<span class="icon-name margin-no-l">用户等级</span>
		        		<span class="icon-price text-color">{$user_info.user_rank_name}</span>
		            </li>
		            <li>
		        		<span class="icon-name margin-no-l">绑定邮箱</span>
		        		<span class="icon-price">{if $user_info.email}{$user_info.email}{else}未绑定{/if}</span>
			        </li>
		        </ul>
		    </div>
		    <div class="ecjia-list list-short">
		     	<input name="mobile_value" type="hidden" value="{$user_info.mobile_phone}"/>
			    <ul class="ecjia-list list-short nmargin-t">
			    	<!-- {if $user_info.mobile_phone} -->
			    	 <li>
			            <a href="javascript:;">
			        		<span class="icon-name margin-no-l">绑定手机</span>
			        		<span class="icon-price">{$user_info.mobile_phone}</span>
			    		</a>
			        </li>
			    	<!-- {else} -->
			    	<li>
			            <a href='{url path="wechat/mobile_profile/bind_mobile"}'>
			        		<span class="icon-name margin-no-l">绑定手机</span>
			        		<span class="icon-price" style="margin-right: 16px;">未绑定</span>
			        		<div class="user-img-text">
								<img src="{$front_url}/images/arrow-right.png" />
							</div>
			    		</a>
			        </li>
			    	<!-- {/if} -->
			        <li>
			            <a href='{url path="wechat/mobile_profile/reset_get_code" args="mobile={$user_info.mobile_phone}"}' class="reset_pwd">
			        		<span class="icon-name margin-no-l">重设密码</span>
			        		<div class="user-img-text">
								<img src="{$front_url}/images/arrow-right.png" />
							</div>
			    		</a>
			        </li>
			   </ul>
		   </div>
		</div>
		<script src="{$system_statics_url}/js/jquery.min.js" type="text/javascript"></script>
        <script src="{$system_statics_url}/lib/ecjia-js/ecjia.js" type="text/javascript"></script>
        
        <script src="{$front_url}/js/bind.js" type="text/javascript"></script>
        
        <script src="{$system_statics_url}/lib/chosen/chosen.jquery.min.js" type="text/javascript"></script>
        <script src="{$system_statics_url}/js/jquery-migrate.min.js" type="text/javascript"></script>
        <script src="{$system_statics_url}/lib/uniform/jquery.uniform.min.js" type="text/javascript"></script>
        <script src="{$system_statics_url}/lib/smoke/smoke.min.js" type="text/javascript"></script>
        <script src="{$system_statics_url}/js/jquery-cookie.min.js" type="text/javascript"></script>
        <script type="text/javascript">
       		 ecjia.bind.init();
        </script>
	</body>
</html>
{/nocache}