{nocache}
<!DOCTYPE html>
<html>
	<head lang="zh-CN">
	    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>ECJIA到家安装程序</title>
		<link rel="stylesheet" type="text/css" href="{$front_url}/css/normalize.css" />
		<link rel="stylesheet" type="text/css" href="{$front_url}/css/grid.css" />
		<link rel="stylesheet" type="text/css" href="{$front_url}/css/style.css" />
		
		<link rel="stylesheet" type="text/css" href="{$system_statics_url}/styles/ecjia.ui.css" />
		<link rel="stylesheet" type="text/css" href="{$front_url}/css/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="{$system_statics_url}/lib/bootstrap/css/bootstrap-responsive.min.css" />
		<link rel="stylesheet" type="text/css" href="{$system_statics_url}/lib/chosen/chosen.css" />
		<link rel="stylesheet" type="text/css" href="{$system_statics_url}/lib/uniform/Aristo/uniform.aristo.css" />
	</head>
	
	<body id="maincontainer" style="height:auto;">
		{include file="./library/header.lbi.php"}
		<div class="container">
		    <div class="row">
		        <div class="col-mb-12 col-tb-8 col-tb-offset-2">
					<div class="column-14 start-06 ecjia-install">
		             	<form method="post" action='{RC_Uri::url("installer/index/detect")}'>
			                <h3 class="ecjia-install-title">欢迎使用ECJIA到家</h3>
			                <div class="ecjia-install-body">
				                <h4>安装说明</h4>
				                <p><strong>本安装程序将自动检测服务器环境是否符合最低配置需求。如果不符合，将在上方出现提示信息，请按照提示信息检查您的主机配置。 如果服务器环境符合要求， 将在下方出现 "开始下一步" 的按钮， 点击此按钮即可一步完成安装。</strong></p>
				                <h4>许可及协议</h4>
				                <p>请您在安装前仔细阅读本协议内容。<br>
									感谢您选择上海商创网络科技有限公司（模板堂）独立研发ECJia到家O2O商城系统，即ECJia到家。在我们的不断努力中，为用户提供全新，功能强大，使用便捷的O2O产品。<br>
									模板堂是ECJia到家O2O商城系统的开发商，ECJia官方网站为 <a href="https://ecjia.com/" target="_blank">https://ecjia.com/</a>。<br>
									本授权协议适用且仅适用于ECJia到家V 1.3版本以及后续的升级版本，模板堂拥有对本授权协议的最终解释权。
				                </p>
				                <p>
				            	  一、使用许可和权利<br>
								   1. 在用户完全遵守本最终协议的基础上，可以将ECJia到家用于以下场景：非商业用途(包括个人用途：不具备法人资格的自然人，以个人名义从事电子商务活动；非盈利性用途：从事非盈利活动的商业机构及非盈利性组织，将ECJia到家系统用且仅用于产品的展示曝光，期间不存在任何利益环节和利益目的)。<br>
								   2. 用户可以在ECJia到家使用协议规定的范围内，对ECJia到家源代码或者界面设计进行相应的改动，以满足您对ECJia到家系统的使用需求（如有提供的话）。<br>
								   3. 用户拥有使用本产品中的全部内容资料、商品信息及其他信息的所有权，并独立承担与其内容相关的法律义务。<br>
								   4. 用户在购买商业授权后，即可将ECJia到家系统用于商业用途，满足用户获取盈利的需求。并且可以在授权协议购买的即刻起，享受在授权协议规定的时间内以及指定范围内的ECJia到家技术支持售后服务。<br><br>
								   
								  二、使用限制和义务<br>
								   1. ECJia到家系统不得用于商业用途（即商业活动为目的，通过商业行为从而获得收益。包括但不限于企业法人经营的电商网站、经营性网站、以盈利为目或实现盈利的网站、以盈利性为目的招募入驻商家等行为），否则一经查证，模板堂将始终保留法律追责的权力。<br>
								   2. 用户在没有购买官方ECJia到家授权之前，不得在ECJia到家系统的任意部分进行开发，以此产生的任何派生版本或者第三方版本，模板堂将始终保留法律追责的权力。<br>
								   3. 用户无法遵守本协议内容，将被终止授权使用，并取消所有使用许可和权利，并承担相应法律责任。<br><br>
								
								  三、有限担保和免责声明<br>
								   1. ECJia到家安装包及所附带的文件不包含任何明确或隐藏的赔偿、担保内容。<br>
								   2. 用户自愿下载使用本系统，必须了解使用风险，未购买官方ECJia到家授权之前，一律不对用户提供技术支持和担保，也不承担使用ECJia到家系统而产生任何问题的责任。<br>
								   3. 模板堂不对使用ECJia到家系统搭建的O2O电商平台的内容信息承担责任，但在不侵犯用户隐私信息的前提下，保留以任何方式获取用户信息及商品信息的权利。<br>
								</p>
								<p>有关本产品最终用户授权协议、商业授权与技术服务的详细内容，均由上海商创网络科技有限公司独家提供。上海商创网络科技有限公司拥有在不事先通知的情况下，修改授权协议的权力，修改后的协议对改变之日起的新授权用户生效。电子文本形式的授权协议如同双方书面签署的协议一样，具有完全的和等同的法律效力。您一旦开始修改、安装或使用本产品，即被视为完全理解并接受本协议的各项条款，在享有上述条款授予的权力的同时，受到相关的约束和限制。协议许可范围以外的行为，将直接违反本授权协议并构成侵权，我们有权随时终止授权，责令停止损害，并保留追究相关责任的权力。</p>
				                <p>ECJIA到家软件由上海商创网络科技有限公司提供支持，核心开发团队负责维护程序日常开发工作以及新特性的制定。如果您遇到使用上的问题，程序中的 BUG，以及期许的新功能，欢迎您在社区中交流或者直接向我们贡献代码。对于贡献突出者，他的名字将出现在贡献者名单中。</p>
			                </div>
			                <p class="description"><label><input type="checkbox" class="p" name="agree" id="agree">我已仔细阅读，并同意上述条款中的所有内容</label></p>
			                <p class="submit">
			                    <button type="submit" class="btn primary" id="ecjia_install" disabled="disabled">我准备好了，开始下一步 &raquo;</button>
			                </p>
		               	</form>
		            </div>
		        </div>
		    </div>
		</div>
		
		{include file="./library/footer.lbi.php"}
		
		<script src="{$system_statics_url}/js/jquery.min.js" type="text/javascript"></script>
        <script src="{$system_statics_url}/lib/ecjia-js/ecjia.js" type="text/javascript"></script>
        
        <script src="{$front_url}/js/ecjia-front.js" type="text/javascript"></script>
        <script src="{$front_url}/js/install.js" type="text/javascript"></script>
        
        <script src="{$system_statics_url}/lib/chosen/chosen.jquery.min.js" type="text/javascript"></script>
        <script src="{$system_statics_url}/js/jquery-migrate.min.js" type="text/javascript"></script>
        <script src="{$system_statics_url}/lib/uniform/jquery.uniform.min.js" type="text/javascript"></script>
        <script src="{$system_statics_url}/lib/smoke/smoke.min.js" type="text/javascript"></script>
        <script src="{$system_statics_url}/js/jquery-cookie.min.js" type="text/javascript"></script>
        <script type="text/javascript">
            ecjia.front.install.init();
        </script>
	</body>
</html>
{/nocache}