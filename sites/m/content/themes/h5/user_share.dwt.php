<?php
/*
Name: 分享推荐模板
Description: 这是分享推荐页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">ecjia.touch.goods.init(); ecjia.touch.user.init();</script>
<script>
window._bd_share_config = {
	common : {
		bdText : '{$shopdesc}',
		bdUrl : '{$shopurl}',
		bdPic : "{url path='user/user_share/create_qrcode' args="value={$base64_shopurl}"}"
	},
	share : [{
		"bdSize" : 32
	}]
}
with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?cdnversion='+~(-new Date()/36e5)];
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<!-- #BeginLibraryItem "/library/page_header.lbi" -->
<!-- #EndLibraryItem -->

<div class="user-share commont-show-active user-share-show">
	<div class="hd">
		{t}分享积分说明{/t}
		<i class="iconfont icon-jiantou-bottom ecjiaf-fr"></i>
	</div>
	<div class="bd">
		<table class="u-table">
			<thead>
				<tr>
					<td>{$lang.affiliate_lever}</td>
					<td>{$lang.affiliate_num}</td>
					<td>积分分成</td>
					<td>现金分成</td>
				</tr>
			</thead>
			<tbody>
				<!-- {foreach from=$affdb key=level item=val name=affdb} -->
				<tr>
					<td>{$level}</td>
					<td>{$val.num}</td>
					<td>{$val.point}</td>
					<td>{$val.money}</td>
				</tr>
				<!-- {/foreach} -->
			</tbody>
		</table>
	</div>
	<div class="bdsharebuttonbox" data-tag="share_1">
		<a class="bds_qzone iconfont" data-cmd="qzone"></a>
		<a class="bds_tsina iconfont" data-cmd="tsina"></a>
		<a class="bds_bdhome iconfont" data-cmd="bdhome"></a>
		<a class="bds_renren iconfont" data-cmd="renren"></a>
	</div>
</div>
<div class="ecjia-list">
	<ul>
		<!-- {foreach from=$logdb item=val name=logdb} -->
		<tr>
			<td bgcolor="#ffffff">{$val.order_sn}</td>
			<td bgcolor="#ffffff">{$val.money}</td>
			<td bgcolor="#ffffff">{$val.point}</td>
			<td bgcolor="#ffffff">
				<!-- {if $val.separate_type == 1 || $val.separate_type === 0} -->
				{$lang.affiliate_type.$val.separate_type}
				<!-- {else} -->
				{$lang.affiliate_type.$affiliate_type}
				<!-- {/if} -->
			</td>
			<td bgcolor="#ffffff">{$lang.affiliate_stats[$val.is_separate]}</td>
		</tr>
		<!-- {foreachelse} -->
		<div class="ecjia-nolist">
			<i class="iconfont icon-fenxiang"></i>
			<p>{t}暂时没有分享记录{/t}</p>
		</div>
		<!-- {/foreach} -->
	</ul>
</div>
<!-- {/block} -->