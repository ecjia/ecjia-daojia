<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.mobile_street.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		{if $action_link}
		<a class="btn plus_or_reply data-pjax" href="{$action_link.href}" id="sticky_a" ><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		{/if}
		{if $action_linkedit}
		<a class="btn plus_or_reply data-pjax" href="{$action_linkedit.href}" id="sticky_a" ><i class="fontello-icon-edit"></i>{$action_linkedit.text}</a>
		{/if}
	</h3>	
</div>

<div class="row-fluid goods_preview">
	<div class="span12 ">
		<div class="section-one">
			<div class="mobile-img-div">
				<img class="mobile-img" src="{$app_url}/mobile_img.png" />
			</div>
			<div class="street-info">
				<div class="ec-icon-info">
					<img class="ec-icon-img" src="{$app_url}/ec_icon.png">
					<div class="literal">{t domain="mobile"}ECJia云店{/t}</div>
				</div>
				<div class="street-decription">
                    {t domain="mobile"}ECJia云店到家是一款免费的到家APP，拿起APP直接扫码便可体验原生到家手机APP，1分钟简单操作就能开启属于你的电商之旅，还提供了各种尺寸的店铺二维码图片，让宣传更加方便。{/t}
				</div>
				<div class="qrcode-apiaddress-info">
					<div class="street-qrcode-info">
						<a href="{$small_qrcode}" target="_blank"><img class="street-qrcode" src="{$small_qrcode}"></a>
						<div class="scanning">{t domain="mobile"}扫一下下载体验免费APP{/t}</div>
					</div>
					<div class="api-address-info">
						<div class="apiaddress">{t domain="mobile"}API地址：{/t}</div>
						<div class="api-url">{$api_url}</div>
						<div style="padding-bottom:5px;">{t domain="mobile"}您选择可以扫一扫添加店铺，也可以选择手动输入API地址进行添加{/t}</div>
						<a class="toggle_view btn filter-btn" href='{url path="mobile/admin_street/refresh"}'  data-val="allow" >{t domain="mobile"}刷新二维码{/t}</a>
					</div>	
				</div>
			</div>
		</div>
		
	</div>
	<div class="span12" style="margin-left:0;">
		<div class="qrcode-size-download">{t domain="mobile"}二维码更多尺寸下载：{/t}</div>
		<table class="table table-striped smpl_tbl table-hide-edit">
			<thead>
				<tr>
					<th>{t domain="mobile"}二维码边长（cm）{/t}</th>
					<th>{t domain="mobile"}建议扫描距离（米）{/t}</th>
					<th class="w100">{t domain="mobile"}下载链接{/t}</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>8cm</td>
					<td>0.5cm</td>
					<td><a class=" no-underline" href='{url path="mobile/admin_street/download" args="size=8cm"}' title="下载"><i class="icon-download"></i></a></td>
				</tr>
				<tr>
					<td>12cm</td>
					<td>0.8cm</td>
					<td><a class=" no-underline" href='{url path="mobile/admin_street/download" args="size=12cm"}' title="下载"><i class="icon-download"></i></a></td>
				</tr>
				<tr>
					<td>15cm</td>
					<td>1cm</td>
					<td><a class=" no-underline" href='{url path="mobile/admin_street/download" args="size=15cm"}' title="下载"><i class="icon-download"></i></a></td>
				</tr>
				<tr>
					<td>30cm</td>
					<td>1.5cm</td>
					<td><a class=" no-underline" href='{url path="mobile/admin_street/download" args="size=30cm"}' title="下载"><i class="icon-download"></i></a></td>
				</tr>
				<tr>
					<td>50cm</td>
					<td>2.5cm</td>
					<td><a class=" no-underline" href='{url path="mobile/admin_street/download" args="size=50cm"}' title="下载"><i class="icon-download"></i></a></td>
				</tr>
			</tbody>
		</table>
		<div><span class="warning"></span><span style="display:inline-block;margin-left:22px;">{t domain="mobile"}二维码尺寸请按照4.3像素的整数倍数缩放，以保持最佳效果{/t}</span></div>
		<div class="daojia-info border">
			<div class="daojia">
				<div class="daojia-literal">{t domain="mobile"}ECJia云店APP下载{/t}</div>
				<div class="daojia-qrcode">
					<img src="{$app_url}/cloudshop.png">
				</div>
				<div class="download">
					<a class="btn-apple" target="_blank" style="background-color:#009FE8;" href="https://itunes.apple.com/us/app/ec-%E5%BA%97%E9%93%BA%E8%A1%97/id990510286?mt=8"><span class="apple-icon"></span><span style="color:#fff;">{t domain="mobile"}iPhone端下载{/t}</span></a>&nbsp;&nbsp;&nbsp;&nbsp;
					<a class="btn-android" target="_blank" style="background-color:#53B958;" href="http://a.app.qq.com/o/simple.jsp?pkgname=com.ecjia.street"><span class="android-icon"></span><span style="color:#fff;">{t domain="mobile"}Android端下载{/t}</span></a>
				</div>
			</div>
		</div>
		<div class="daojia-info border">
			<div class="daojia">
				<div class="daojia-literal">{t domain="mobile"}ECJia掌柜APP下载{/t}</div>
				<div class="daojia-qrcode">
					<img src="{$app_url}/zhanggui.png">
				</div>
				<div class="download">
					<a class="btn-apple" target="_blank" style="background-color:#009FE8;" href="https://itunes.apple.com/cn/app/ec-%E6%8E%8C%E6%9F%9C/id1015857619?mt=8"><span class="apple-icon"></span><span style="color:#fff;">{t domain="mobile"}iPhone端下载{/t}</span></a>&nbsp;&nbsp;&nbsp;&nbsp;
					<a class="btn-android" target="_blank" style="background-color:#53B958;" href="http://a.app.qq.com/o/simple.jsp?pkgname=com.ecjia.shopkeeper"><span class="android-icon"></span><span style="color:#fff;">{t domain="mobile"}Android端下载{/t}</span></a>
				</div>
			</div>
		</div>
		<div class="daojia-info border-last">
			<div class="daojia">
				<div class="daojia-literal">{t domain="mobile"}ECJia配送员APP下载{/t}</div>
				<div class="daojia-qrcode">
					<img src="{$app_url}/peisong.png">
				</div>
				<div class="download">
					<a class="btn-apple" target="_blank" style="background-color:#009FE8;" href="https://itunes.apple.com/cn/app/ec-%E9%85%8D%E9%80%81%E5%91%98/id1198119772?mt=8"><span class="apple-icon"></span><span style="color:#fff;">{t domain="mobile"}iPhone端下载{/t}</span></a>&nbsp;&nbsp;&nbsp;&nbsp;
					<a class="btn-android" target="_blank" style="background-color:#53B958;" href="http://a.app.qq.com/o/simple.jsp?pkgname=com.ecjia.express"><span class="android-icon"></span><span style="color:#fff;">{t domain="mobile"}Android端下载{/t}</span></a>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- {/block} -->