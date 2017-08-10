<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->
	
<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.about_team.init();
</script>
<!-- {/block} -->
	
<!-- {block name="main_content"} -->
<div class="row-fluid">
	<div class="span12">
		<!-- {ecjia:hook id=admin_about_welcome} -->
		<ul class="nav nav-tabs">
			<li><a class="data-pjax" href="{url path='admincp/index/about_us'}">{t}关于ECJia{/t}</a></li>
			<li class="active"><a href="javascript:;">{t}ECJia团队{/t}</a></li>
			<li><a class="data-pjax" href="{url path='admincp/index/about_system'}">{t}系统信息{/t}</a></li>
		</ul>
		<div class="vcard">
			<ul style="margin-left: 0px;">
			    <li class="v-heading">
					{t}ECJia 版权信息{/t}
				</li>
				<li>
					<span class="item-key">{t}版权所有:{/t}</span>
					<div class="vcard-item"><a href="http://about.ecmoban.com" target="_blank">{t}上海商创网络科技有限公司{/t}</a></div>
				</li>
				<li>
					<span class="item-key">{t}公司网站:{/t}</span>
					<div class="vcard-item"><a href="http://www.ecmoban.com" target="_blank">http://www.ecmoban.com</a></div>
				</li>
				
				<li class="v-heading">
					{t}ECJia 官方网站{/t}
				</li>
				<li>
					<span class="item-key">{t}产品网站:{/t}</span>
					<div class="vcard-item"><a href="https://ecjia.com" target="_blank">https://ecjia.com</a></div>
				</li>
				<li>
					<span class="item-key">{t}帮助手册:{/t}</span>
					<div class="vcard-item"><a href="https://ecjia.com/wiki" target="_blank">https://ecjia.com/wiki</a></div>
				</li>
				<li>
					<span class="item-key">{t}授权中心:{/t}</span>
					<div class="vcard-item"><a href="https://license.ecjia.com" target="_blank">https://license.ecjia.com</a></div>
				</li>
				
				<li class="v-heading">
					{t}ECJia 开发团队{/t}
				</li>
				<li>
					<span class="item-key">{t}创始人、项目领导者:{/t}</span>
					<div class="vcard-item">
						<ul class="list_a">
						    <li>Zhengdong Wang</li>
						</ul>
					</div>
				</li>
				
				<li>
					<span class="item-key">{t}产品团队:{/t}</span>
					<div class="vcard-item">
						<ul class="list_a">
						    <li>Zhengdong Wang</li>
							<li>Dandan Xiang</li>
							<li>Ting Yang</li>
						</ul>
					</div>
				</li>
				
				<li>
					<span class="item-key">{t}开发领头人:{/t}</span>
					<div class="vcard-item">
						<ul class="list_a">
							<li>Zhengdong Wang</li>
							<li>Qianqian Song</li>
							<li>Yuyuan Huang</li>
							<li>Ming Le</li>
							<li>Chao Li</li>
						</ul>
					</div>
				</li>
				
				<li>
					<span class="item-key">{t}核心开发者:{/t}</span>
					<div class="vcard-item">
						<ul class="list_a">
							<li>Tifang Wu</li>
							<li>Ruili Zhou</li>
							<li>Xiang Jin</li>
							<li>Wenbiao Xu</li>
						</ul>
					</div>
				</li>
				<li>
					<span class="item-key">{t}贡献开发者:{/t}</span>
					<div class="vcard-item">
						<ul class="list_a">
							<li>Yazhou Shi</li>
							<li>Pei Yang</li>
							<li>Yongrui Guan</li>
							<li>Xingsheng Liang</li>
							<li>Huan Yuan</li>
							<li>Dong Wei</li>
							<li>Fei Zhao</li>
							<li>Dong Cheng</li>
							<li>Hongfei Ji</li>
							<li>Zhejun Chen</li>
							<li>Lei Zhang</li>
							<li>Shaohua Song</li>
						</ul>
					</div>
				</li>
				
				<li>
					<span class="item-key">{t}界面设计:{/t}</span>
					<div class="vcard-item">
						<ul class="list_a">
							<li>Gaoxuan Xu</li>
							<li>Dandan Xiang</li>
							<li>Ting Yang</li>
						</ul>
					</div>
				</li>

				<li class="v-heading">
					{t}发展历程{/t}
				</li>
				
				<li>
					<ul class="unstyled sepH_b item-list">
						<li><i class="fontello-icon-comment-empty sepV_b"></i><span>{t}2017.07.25{/t}</span>{t}ECJia推出到家门店APP{/t}</li>
						<li><i class="fontello-icon-comment-empty sepV_b"></i><span>{t}2017.07.20{/t}</span>{t}ECJia推出到家门店小程序{/t}</li>
						<li><i class="fontello-icon-comment-empty sepV_b"></i><span>{t}2017.05.24{/t}</span>{t}ECJia推出免费EC+配送员APP支持到家{/t}</li>
						<li><i class="fontello-icon-comment-empty sepV_b"></i><span>{t}2017.05.11{/t}</span>{t}ECJia推出免费EC+掌柜APP支持到家{/t}</li>
						<li><i class="fontello-icon-comment-empty sepV_b"></i><span>{t}2017.05.04{/t}</span>{t}ECJia推出到家PC端{/t}</li>
						<li><i class="fontello-icon-comment-empty sepV_b"></i><span>{t}2017.04.01{/t}</span>{t}ECJia推出免费EC+店铺街APP支持到家{/t}</li>
						<li class="item-list-more"><i class="fontello-icon-comment-empty sepV_b"></i><span>{t}2017.02.14{/t}</span>{t}ECJia推出免费开源的O2O移动电商系统【ECJia到家】{/t}</li>
						<li class="item-list-more"><i class="fontello-icon-comment-empty sepV_b"></i><span>{t}2016.12.30{/t}</span>{t}ECJia推出到家H5版微信商城{/t}</li>
						<li class="item-list-more"><i class="fontello-icon-comment-empty sepV_b"></i><span>{t}2016.11.11{/t}</span>{t}ECJia推出到家商城系统支持商家入驻管理{/t}</li>
						<li class="item-list-more"><i class="fontello-icon-comment-empty sepV_b"></i><span>{t}2016.07.15{/t}</span>{t}ECJia推出原生开发手机APP到家系统{/t}</li>
						<li class="item-list-more"><i class="fontello-icon-comment-empty sepV_b"></i><span>{t}2016.06.21{/t}</span>{t}ECJia推出首款大屏电视应用，ECJiaTV{/t}</li>
						<li class="item-list-more"><i class="fontello-icon-comment-empty sepV_b"></i><span>{t}2016.03.01{/t}</span>{t}ECJia Web上线{/t}</li>
						<li class="item-list-more"><i class="fontello-icon-comment-empty sepV_b"></i><span>{t}2016.02.06{/t}</span>{t}ECJia 标准版更名为移动商城{/t}</li>
						<li class="item-list-more"><i class="fontello-icon-comment-empty sepV_b"></i><span>{t}2016.02.05{/t}</span>{t}ECJia 尊享版上线{/t}</li>
						<li class="item-list-more"><i class="fontello-icon-comment-empty sepV_b"></i><span>{t}2016.01.08{/t}</span>{t}ECJia 微店上线{/t}</li>
						<li class="item-list-more"><i class="fontello-icon-comment-empty sepV_b"></i><span>{t}2015.11.27{/t}</span>{t}推出ECJia 公众平台{/t}</li>
						<li class="item-list-more"><i class="fontello-icon-comment-empty sepV_b"></i><span>{t}2015.11.20{/t}</span>{t}推出ECJia收银台产品{/t}</li>
						<li class="item-list-more"><i class="fontello-icon-comment-empty sepV_b"></i><span>{t}2015.09.18{/t}</span>{t}推出ECJia Touch多商户产品{/t}</li>
						<li class="item-list-more"><i class="fontello-icon-comment-empty sepV_b"></i><span>{t}2015.09.18{/t}</span>{t}ECJia 多商户上线{/t}</li>
						<li class="item-list-more"><i class="fontello-icon-comment-empty sepV_b"></i><span>{t}2015.08.26{/t}</span>{t}ECJia 轻装版上线{/t}</li>
						<li class="item-list-more"><i class="fontello-icon-comment-empty sepV_b"></i><span>{t}2015.07.22{/t}</span>{t}ECJia 掌柜上线{/t}</li>
						<li class="item-list-more"><i class="fontello-icon-comment-empty sepV_b"></i><span>{t}2015.07.17{/t}</span>{t}ECJia Touch上线{/t}</li>
						<li class="item-list-more"><i class="fontello-icon-comment-empty sepV_b"></i><span>{t}2015.05.31{/t}</span>{t}适应 Apple Watch{/t}</li>
						<li class="item-list-more"><i class="fontello-icon-comment-empty sepV_b"></i><span>{t}2015.03.15{/t}</span>{t}ECJia 智能后台上线{/t}</li>
						<li class="item-list-more"><i class="fontello-icon-comment-empty sepV_b"></i><span>{t}2015.01.13{/t}</span>{t}EC+官网上线{/t}</li>
						<li class="item-list-more"><i class="fontello-icon-comment-empty sepV_b"></i><span>{t}2015.01.08{/t}</span>{t}ECJia iPhone端APP上线{/t}</li>
						<li class="item-list-more"><i class="fontello-icon-comment-empty sepV_b"></i><span>{t}2014.11.28{/t}</span>{t}ECJia iPad端APP上线{/t}</li>
						<li class="item-list-more"><i class="fontello-icon-comment-empty sepV_b"></i><span>{t}2014.10.23{/t}</span>{t}ECJia Android端APP上线{/t}</li>
						<li class="item-list-more"><i class="fontello-icon-comment-empty sepV_b"></i><span>{t}2014.08.29{/t}</span>{t}ECJia 框架研发完毕{/t}</li>
						<li class="item-list-more"><i class="fontello-icon-comment-empty sepV_b"></i><span>{t}2013.11.01{/t}</span>{t}ECJia开始研发{/t}</li>
						<li class="item-list-more"><i class="fontello-icon-comment-empty sepV_b"></i><span>{t}2013.10.13{/t}</span>{t}商讨产品规划{/t}</li>
						<li class="item-list-more"><i class="fontello-icon-comment-empty sepV_b"></i><span>{t}2013.05.06{/t}</span>{t}产品提案{/t}</li>
					</ul>
					<a href="index.php-uid=1&page=user_static.html#" data-items="5" class="item-list-show btn btn-mini">{t}再显示5条{/t}</a>
				</li>
			</ul>
		</div>
	</div>
</div>
<!-- {/block} -->