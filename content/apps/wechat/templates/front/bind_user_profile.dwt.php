{nocache}
<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0"/>
<meta http-equiv="X-UA-Compatible" content="IE=8,IE=9,IE=10,IE=11"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<head lang="zh-CN">
		<title>{t domain="wechat"}用户中心{/t}</title>
        {ecjia:hook id=front_head}
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
	            		<span class="icon-name margin-no-l">{t domain="wechat"}用户名{/t} </span>
	            		<span class="icon-price text-color">{$user_info.user_name}</span>
		            </li>
		            <li>
		            	<span class="icon-name margin-no-l">{t domain="wechat"}用户等级{/t}</span>
		        		<span class="icon-price text-color">{$user_info.user_rank_name}</span>
		            </li>
		            <li>
		        		<span class="icon-name margin-no-l">{t domain="wechat"}绑定邮箱{/t}</span>
		        		<span class="icon-price">{if $user_info.email}{$user_info.email}{else}{t domain="wechat"}未绑定{/t}{/if}</span>
			        </li>
		        </ul>
		    </div>
		    <div class="ecjia-list list-short">
		     	<input name="mobile_value" type="hidden" value="{$user_info.mobile_phone}"/>
			    <ul class="ecjia-list list-short nmargin-t">
			    	<!-- {if $user_info.mobile_phone} -->
			    	 <li>
			            <a href="javascript:;">
			        		<span class="icon-name margin-no-l">{t domain="wechat"}绑定手机{/t}</span>
			        		<span class="icon-price">{$user_info.mobile_phone}</span>
			    		</a>
			        </li>
			    	<!-- {else} -->
			    	<li>
			            <a href='{url path="wechat/mobile_profile/bind_mobile"}'>
			        		<span class="icon-name margin-no-l">{t domain="wechat"}绑定手机{/t}</span>
			        		<span class="icon-price" style="margin-right: 16px;">{t domain="wechat"}未绑定{/t}</span>
			        		<div class="user-img-text">
								<img src="{$front_url}/images/arrow-right.png" />
							</div>
			    		</a>
			        </li>
			    	<!-- {/if} -->
			        <li>
			            <a href='{url path="wechat/mobile_profile/reset_get_code" args="mobile={$user_info.mobile_phone}"}' class="reset_pwd">
			        		<span class="icon-name margin-no-l">{t domain="wechat"}重设密码{/t}</span>
			        		<div class="user-img-text">
								<img src="{$front_url}/images/arrow-right.png" />
							</div>
			    		</a>
			        </li>
			   </ul>
		   </div>
		</div>

        {ecjia:hook id=front_print_footer_scripts}

        <script type="text/javascript">
       		 ecjia.bind.init();
        </script>
	</body>
</html>
{/nocache}