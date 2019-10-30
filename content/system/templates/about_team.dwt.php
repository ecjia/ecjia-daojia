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
			<li><a class="data-pjax" href="{url path='@about/about_us'}">{t}关于ECJia{/t}</a></li>
			<li class="active"><a href="javascript:;">{t}ECJia团队{/t}</a></li>
			<li><a class="data-pjax" href="{url path='@about/about_system'}">{t}系统信息{/t}</a></li>
		</ul>
		<div class="vcard">
			<ul style="margin-left: 0px;">
			    <li class="v-heading">
					{t}ECJia 版权信息{/t}
				</li>
				<li>
					<span class="item-key">{t}版权所有：{/t}</span>
					<div class="vcard-item"><a href="http://about.ecmoban.com" target="_blank">{t}上海商创网络科技有限公司{/t}</a></div>
				</li>
				<li>
					<span class="item-key">{t}公司网站：{/t}</span>
					<div class="vcard-item"><a href="http://www.ecmoban.com" target="_blank">http://www.ecmoban.com</a></div>
				</li>
				
				<li class="v-heading">
					{t}ECJia 官方网站{/t}
				</li>
				<li>
					<span class="item-key">{t}产品网站：{/t}</span>
					<div class="vcard-item"><a href="https://ecjia.com" target="_blank">https://ecjia.com</a></div>
				</li>
				<li>
					<span class="item-key">{t}帮助手册：{/t}</span>
					<div class="vcard-item"><a href="https://ecjia.com/wiki" target="_blank">https://ecjia.com/wiki</a></div>
				</li>
				<li>
					<span class="item-key">{t}授权中心：{/t}</span>
					<div class="vcard-item"><a href="https://license.ecjia.com" target="_blank">https://license.ecjia.com</a></div>
				</li>
				
				<li class="v-heading">
					{t}ECJia 开发团队{/t}
				</li>
				<li>
					<span class="item-key">{t}创始人、项目领导者：{/t}</span>
					<div class="vcard-item">
						<ul class="list_a">
						    <li>Zhengdong Wang</li>
						</ul>
					</div>
				</li>
				
				<li>
					<span class="item-key">{t}产品团队：{/t}</span>
					<div class="vcard-item">
						<ul class="list_a">
						    <li>Zhengdong Wang</li>
							<li>Dandan Xiang</li>
							<li>Ting Yang</li>
						</ul>
					</div>
				</li>
				
				<li>
					<span class="item-key">{t}开发领头人：{/t}</span>
					<div class="vcard-item">
						<ul class="list_a">
							<li>Zhengdong Wang</li>
                            <li>Yuyuan Huang</li>
                            <li>Chunchen Zhang</li>
                            <li>Ruili Zhou</li>
                            <li>Ming Le</li>
                            <li>Dishan Fang</li>
                            <li>Changhui Li</li>
						</ul>
					</div>
				</li>
				
				<li>
					<span class="item-key">{t}核心开发者：{/t}</span>
					<div class="vcard-item">
						<ul class="list_a">
							<li>Tifang Wu</li>
                            <li>Qianqian Song</li>
							<li>Xiang Jin</li>
							<li>Wenbiao Xu</li>
                            <li>Chao Li</li>
						</ul>
					</div>
				</li>
				<li>
					<span class="item-key">{t}贡献开发者：{/t}</span>
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
					<span class="item-key">{t}界面设计：{/t}</span>
					<div class="vcard-item">
						<ul class="list_a">
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
					    <li><i class="fontello-icon-comment-empty sepV_b"></i><span>2019.01.23</span>ECJia推出城市代理招商平台</li>
						<li><i class="fontello-icon-comment-empty sepV_b"></i><span>2019.01.14</span>ECJia推出收银通APP</li>
						<li><i class="fontello-icon-comment-empty sepV_b"></i><span>2019.01.14</span>ECJia推出到家PC电商平台</li>
						<li><i class="fontello-icon-comment-empty sepV_b"></i><span>2018.11.27</span>ECJia推出到家PC会员中心</li>
						<li><i class="fontello-icon-comment-empty sepV_b"></i><span>2018.05.29</span>ECJia推出到家门店H5微商城</li>
						<li><i class="fontello-icon-comment-empty sepV_b"></i><span>2017.12.19</span>ECJia推出到家小票打印机</li>
                        <li class="item-list-more"><i class="fontello-icon-comment-empty sepV_b"></i><span>2017.10.31</span>ECJia推出收银POS机</li>
						<li class="item-list-more"><i class="fontello-icon-comment-empty sepV_b"></i><span>2017.07.25</span>ECJia推出到家门店APP</li>
						<li class="item-list-more"><i class="fontello-icon-comment-empty sepV_b"></i><span>2017.07.20</span>ECJia推出到家门店小程序</li>
						<li class="item-list-more"><i class="fontello-icon-comment-empty sepV_b"></i><span>2017.05.24</span>ECJia推出免费EC+配送员APP支持到家</li>
						<li class="item-list-more"><i class="fontello-icon-comment-empty sepV_b"></i><span>2017.05.11</span>ECJia推出免费EC+掌柜APP支持到家</li>
						<li class="item-list-more"><i class="fontello-icon-comment-empty sepV_b"></i><span>2017.05.04</span>ECJia推出到家PC端</li>
						<li class="item-list-more"><i class="fontello-icon-comment-empty sepV_b"></i><span>2017.04.01</span>ECJia推出免费EC+店铺街APP支持到家</li>
						<li class="item-list-more"><i class="fontello-icon-comment-empty sepV_b"></i><span>2017.02.14</span>ECJia推出免费开源的O2O移动电商系统【ECJia到家】</li>
						<li class="item-list-more"><i class="fontello-icon-comment-empty sepV_b"></i><span>2016.12.30</span>ECJia推出到家H5版微信商城</li>
						<li class="item-list-more"><i class="fontello-icon-comment-empty sepV_b"></i><span>2016.11.11</span>ECJia推出到家商城系统支持商家入驻管理</li>
						<li class="item-list-more"><i class="fontello-icon-comment-empty sepV_b"></i><span>2016.07.15</span>ECJia推出原生开发手机APP到家系统</li>
						<li class="item-list-more"><i class="fontello-icon-comment-empty sepV_b"></i><span>2016.06.21</span>ECJia推出首款大屏电视应用，ECJiaTV</li>
						<li class="item-list-more"><i class="fontello-icon-comment-empty sepV_b"></i><span>2016.03.01</span>ECJia Web上线</li>
						<li class="item-list-more"><i class="fontello-icon-comment-empty sepV_b"></i><span>2016.02.06</span>ECJia 标准版更名为移动商城</li>
						<li class="item-list-more"><i class="fontello-icon-comment-empty sepV_b"></i><span>2016.02.05</span>ECJia 尊享版上线</li>
						<li class="item-list-more"><i class="fontello-icon-comment-empty sepV_b"></i><span>2016.01.08</span>ECJia 微店上线</li>
						<li class="item-list-more"><i class="fontello-icon-comment-empty sepV_b"></i><span>2015.11.27</span>推出ECJia 公众平台</li>
						<li class="item-list-more"><i class="fontello-icon-comment-empty sepV_b"></i><span>2015.11.20</span>推出ECJia收银台产品</li>
						<li class="item-list-more"><i class="fontello-icon-comment-empty sepV_b"></i><span>2015.09.18</span>推出ECJia Touch多商户产品</li>
						<li class="item-list-more"><i class="fontello-icon-comment-empty sepV_b"></i><span>2015.09.18</span>ECJia 多商户上线</li>
						<li class="item-list-more"><i class="fontello-icon-comment-empty sepV_b"></i><span>2015.08.26</span>ECJia 轻装版上线</li>
						<li class="item-list-more"><i class="fontello-icon-comment-empty sepV_b"></i><span>2015.07.22</span>ECJia 掌柜上线</li>
						<li class="item-list-more"><i class="fontello-icon-comment-empty sepV_b"></i><span>2015.07.17</span>ECJia Touch上线</li>
						<li class="item-list-more"><i class="fontello-icon-comment-empty sepV_b"></i><span>2015.05.31</span>适应 Apple Watch</li>
						<li class="item-list-more"><i class="fontello-icon-comment-empty sepV_b"></i><span>2015.03.15</span>ECJia 智能后台上线</li>
						<li class="item-list-more"><i class="fontello-icon-comment-empty sepV_b"></i><span>2015.01.13</span>EC+官网上线</li>
						<li class="item-list-more"><i class="fontello-icon-comment-empty sepV_b"></i><span>2015.01.08</span>ECJia iPhone端APP上线</li>
						<li class="item-list-more"><i class="fontello-icon-comment-empty sepV_b"></i><span>2014.11.28</span>ECJia iPad端APP上线</li>
						<li class="item-list-more"><i class="fontello-icon-comment-empty sepV_b"></i><span>2014.10.23</span>ECJia Android端APP上线</li>
						<li class="item-list-more"><i class="fontello-icon-comment-empty sepV_b"></i><span>2014.08.29</span>ECJia 框架研发完毕</li>
						<li class="item-list-more"><i class="fontello-icon-comment-empty sepV_b"></i><span>2013.11.01</span>ECJia开始研发</li>
						<li class="item-list-more"><i class="fontello-icon-comment-empty sepV_b"></i><span>2013.10.13</span>商讨产品规划</li>
						<li class="item-list-more"><i class="fontello-icon-comment-empty sepV_b"></i><span>2013.05.06</span>产品提案</li>
					</ul>
					<a href="index.php-uid=1&page=user_static.html#" data-items="5" class="item-list-show btn btn-mini">{t}再显示5条{/t}</a>
				</li>
			</ul>
		</div>
	</div>
</div>
<!-- {/block} -->