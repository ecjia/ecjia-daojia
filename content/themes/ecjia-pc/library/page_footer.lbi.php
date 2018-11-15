<?php 
/*
 Name: PC端公用尾部模块
 Description: 这是PC端公用尾部模块
 */
defined('IN_ECJIA') or exit('No permission resources.');
?>
<div class="ecjia-page-footer">
	<div class="foot-top">
		<p>特色<span class="ecjia-green">到家</span>平台</p>
		<p class="">品类齐全，轻松购物，为您呈现不一样的生活服务平台</p>
		<div class="helper">
			<div class="mod" data-spm-ab="1">
				<div class="mod-wrap">
			  		<h4>
				 		<i class="icon-foot-1"></i>
				        <div>正品保障</div>
				        <div>正品行货，放心选购</div>
			      </h4>
				</div>
			</div>
			
			<div class="mod" data-spm-ab="2">
				<div class="mod-wrap">
			  		<h4>
				 		<i class="icon-foot-2"></i>
				        <div>产地直采</div>
				        <div>100%产地直采，放心低价</div>
			      </h4>
				</div>
			</div>
			
			<div class="mod" data-spm-ab="3">
				<div class="mod-wrap">
			  		<h4>
				 		<i class="icon-foot-3"></i>
				        <div>准时送达</div>
				        <div>收货时间，自主选择</div>
			      </h4>
				</div>
			</div>
			
			<div class="mod" data-spm-ab="4">
				<div class="mod-wrap">
			  		<h4>
				 		<i class="icon-foot-4"></i>
				        <div>售后无忧</div>
				        <div>客服全年无休，用户体验至上</div>
			      </h4>
				</div>
			</div>
		</div>
		{if $info.region_list}
		<div class="hot-city">
			<div class="hot-city-left">经营城市</div>
			<div class="hot-city-right">
				<!-- {foreach from=$info.region_list item=val} -->
					<!--{foreach from=$val item=v}-->
						<li class="position-li select-city-li" data-id="{$v.business_city}">{$v.business_city_alias}</li>
					<!-- {/foreach} -->
				<!-- {/foreach} -->
			</div>
		</div>
		{/if}
		
		{if $info.link_list.has_logo || $info.link_list.no_logo}
		<div class="friend-link">
			<div class="friend-link-title">合作伙伴</div>
			<div class="friend-link-content">
				<!-- {if $info.link_list.has_logo} -->
				<ul class="link-content">
				<!-- {foreach from=$info.link_list.has_logo item=val} -->
				<li><a href="{$val.link_url}" title="{$val.link_name}" target="{$val.link_target}"><img src="{$val.link_logo}" width="110" height="auto"></a></li>
				<!-- {/foreach} -->
				</ul>
				<!-- {/if} -->
				
				<!-- {if $info.link_list.no_logo} -->
				<ul class="link-content m_t0">
				<!-- {foreach from=$info.link_list.no_logo item=val} -->
				<li><a href="{$val.link_url}" title="{$val.link_name}" target="{$val.link_target}"><span>{$val.link_name}</span></a></li>
				<!-- {/foreach} -->
				</ul>
				<!-- {/if} -->
			</div>
		</div>
		{/if}
		
	</div>
</div>

<div class="page-footer">
	<div class="outlink">
		{if $info.shop_weibo_url}
        <span>
            <a class="blog-ico" href="{$info.shop_weibo_url}" target="_blank"></a>
        </span>
        {/if}
        {if $info.shop_wechat_qrcode}
		<span class="outlink-qrcode">
            <div class="wechat-code">
				<img src="{$info.shop_wechat_qrcode}">
				<span>打开微信扫一扫关注</span>
			</div>
			<a class="wechat" href="javascript:void(0)"></a>
		</span>
        {/if}
	</div>
	{if $info.shop_info_html}
    <div class="footer-links">
        <p>
            {$info.shop_info_html}
        </p>
    </div>
    {/if}
    <p>{if $info.company_name}{$info.company_name} 版权所有{/if} {if ecjia::config('icp_number')}&nbsp;&nbsp;<a href="http://www.miibeian.gov.cn" target="_blank"> {ecjia::config('icp_number')}</a>{/if}&nbsp;&nbsp;{$info.powered}</p>
    <p>{if $info.shop_address}地址：{$info.shop_address} {/if} {if $info.service_phone} 咨询热线：{$info.service_phone}{/if}</p>
</div>
{if ecjia::config('stats_code')}
	{stripslashes(ecjia::config('stats_code'))}
{/if}