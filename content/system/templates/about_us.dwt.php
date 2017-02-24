<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->
<!-- {block name="main_content"} -->
<div class="row-fluid">
	<div class="span12">
		<!-- {ecjia:hook id=admin_about_welcome} -->
		<ul class="nav nav-tabs">
			<li class="active"><a href="javascript:;">{t}关于ECJia{/t}</a></li>
			<li><a class="data-pjax" href="{url path='admincp/index/about_team'}">{t}ECJia团队{/t}</a></li>
			<li><a class="data-pjax" href="{url path='admincp/index/about_system'}">{t}系统信息{/t}</a></li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active" id="aboutus">
				<div class="row-fluid">
					<div class="span4 outline">
						<div class="outline-left"><img src="{RC_Uri::admin_url('statics/images/appplus.png')}" /></div>
						<div class="outline-right">
							<h3>{t}系统应用{/t}</h3>
							<span>{t}系统核心推出了灵活的应用+插件扩展机制，快速提供接口，多种主题，一指布局，满足众多需求只在一瞬间。 {/t}</span>
						</div>
					</div>
					<div class="span4 outline">
						<div class="outline-left"><img src="{RC_Uri::admin_url('statics/images/app.png')}" /></div>
						<div class="outline-right">
							<h3>{t}应用扩展{/t}</h3>
							<span>{t}提出全新的应用模式进行扩展，完全满足您的个性化需求，商品、订单、购物车、会员、等众多的应用。 {/t}</span>
						</div>
					</div>
					<div class="span4 outline">
						<div class="outline-left"><img src="{RC_Uri::admin_url('statics/images/plugin.png')}" /></div>
						<div class="outline-right">
							<h3>{t}插件扩展{/t}</h3>
							<span>{t}ECJia推出多种插件，支付、物流为ECJia中的组件赋予了“生命” 。{/t}</span>
						</div>
					</div>	
				</div>
				<div class="row-fluid">
					<div class="span4 outline">
						<div class="outline-left"><img src="{RC_Uri::admin_url('statics/images/language.png')}" /></div>
						<div class="outline-right">
							<h3>{t}多种语言{/t}</h3>
							<span>{t}多国语言支持，可同时建立多种语言站点，系统默认带有中、英文两种最常用的语言包，最多可扩展至同时开通 255 种语言的网站。{/t}</span>
						</div>
					</div>
					<div class="span4 outline">
						<div class="outline-left"><img src="{RC_Uri::admin_url('statics/images/theme.png')}" /></div>
						<div class="outline-right">
							<h3>{t}主题多样{/t}</h3>
							<span>{t}打造了多种风格的主题，在线随意切换您喜欢的主题包。{/t}</span>
						</div>
					</div>
					<div class="span4 outline">
						<div class="outline-left"><img src="{RC_Uri::admin_url('statics/images/ui.png')}" /></div>
						<div class="outline-right">
							<h3>{t}超炫UI设计{/t}</h3>
							<span>{t}友好的后台操作界面，点对点的操作帮助，体验愉快、简单的建站过程，请你轻松上手。{/t}</span>
						</div>
					</div>
				</div>
				<div class="row-fluid">
					<div class="span4 outline">
						<div class="outline-left"><img src="{RC_Uri::admin_url('statics/images/ec.png')}" /></div>
						<div class="outline-right">		
							<h3>{t}订单管理{/t}</h3>
							<span>{t}方便快捷订单管理模块，支持财付通、支付宝等多家平台支付接口，购物车、在线充值等方便快捷功能。{/t}</span>
						</div>
					</div>
					
					<div class="span4 outline">
						<div class="outline-left"><img src="{RC_Uri::admin_url('statics/images/cooperate.png')}" /></div>
						<div class="outline-right">	
							<h3>{t}交互协作{/t}</h3>
							<span>{t}管理员支持分类角色，支持自定义权限分配，支持栏目分配。以及通过管理员、客户留言实行更好的交互。{/t}</span>
						</div>
					</div>
					
					<div class="span4 outline">
						<div class="outline-left"><img src="{RC_Uri::admin_url('statics/images/smtp.png')}" /></div>
						<div class="outline-right">	
							<h3>{t}邮件SMTP{/t}</h3>
							<span>{t}支持邮件发送功能，一般用在会员忘记密码或者红包等提醒部分。{/t}</span>
						</div>
					</div>
				</div>
				<div class="row-fluid">
					<div class="span4 outline">
						<div class="outline-left"><img src="{RC_Uri::admin_url('statics/images/log.png')}" /></div>
						<div class="outline-right">
							<h3>{t}操作日志{/t}</h3>
							<span>{t}日志管理的推出，对各个管理员所进行的操作一目了然。{/t}</span>
						</div>
					</div>	
					<div class="span4 outline">
						<div class="outline-left"><img src="{RC_Uri::admin_url('statics/images/file.png')}" /></div>
						<div class="outline-right">
							<h3>{t}多文件上传{/t}</h3>
							<span>{t}采用HTML5方式多文件上传、并支持附件管理。{/t}</span>
						</div>
					</div>
					<div class="span4 outline">
						<div class="outline-left"><img src="{RC_Uri::admin_url('statics/images/code.png')}" /></div>
						<div class="outline-right">
							<h3>{t}数据库多源化{/t}</h3>
							<span>{t}同时可以连接多个数据库任意操作的强大功能，解决数据量问题的不二选择。{/t}</span>
						</div>
					</div>	
				</div>
			</div>
		</div>
	</div>
</div>
<!-- {/block} -->