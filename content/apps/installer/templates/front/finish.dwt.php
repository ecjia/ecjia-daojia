{nocache}
<!DOCTYPE html>
<html>
	<head lang="zh-CN">
	    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>ECJIA到家安装程序</title>
		<link rel="stylesheet" type="text/css" href="{$front_url}/css/normalize.css" />
		<link rel="stylesheet" type="text/css" href="{$front_url}/css/grid.css" />
		<link rel="stylesheet" type="text/css" href="{$front_url}/css/style.css" />
		
		<link rel="stylesheet" type="text/css" href="{$front_url}/css/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="{$system_statics_url}/lib/bootstrap/css/bootstrap-responsive.min.css" />
	</head>
	
	<body id="maincontainer" style="height:auto;">
		{include file="./library/header.lbi.php"}
		<div class="container">
		    <div class="row">
		        <div class="col-mb-12 col-tb-8 col-tb-offset-2">
		            <div class="column-14 start-06 ecjia-install-complete">
                        <h3 class="typecho-install-title">{$finish_message}</h3>
		                <div class="typecho-install-body">
		                	{if $locked_message}
		                	<h5>{$locked_message}</h5>
		                	{/if}
		                	
		                 	{if !$locked_message}
		             		<div class="message success">
								您的用户名是：<strong class="mono">{$admin_name}</strong><br>
								您的密码是：<strong class="mono">{$admin_password}</strong>
			                </div>
			                {/if}
		
		                    <div class="p message notice">
		                   		<a target="_blank" href="https://ecjia.com/wiki/%E5%B8%AE%E5%8A%A9:ECJia%E5%88%B0%E5%AE%B6">前往ECJIA WIKI，查看帮助文档，使您快速上手。</a>
		                    </div>
		
		                    <div class="session">
		                    <p>您可以将下面链接保存到您的收藏夹哦</p>
		                    <ul>  
		                    	<li><a target="_blank" href="{$index_url}">点击这里进入ECJIA到家首页</a></li>
		                    	<li><a target="_blank" href="{$h5_url}">点击这里进入ECJIA到家H5端</a></li>
		                    	<li><a target="_blank" href="{$admin_url}">点击这里进入ECJIA到家平台后台</a></li>
		                        <li><a target="_blank" href="{$merchant_url}">点击这里进入ECJIA到家商家后台</a></li>
		                    </ul>
		                    </div>
		                    <p>各种体验，希望您能尽情享用ECJIA到家带来的乐趣！</p>
		                </div>
					</div>
				</div>
			</div>
		</div>	
		
		{include file="./library/footer.lbi.php"}
		
	</body>
</html>
{/nocache}