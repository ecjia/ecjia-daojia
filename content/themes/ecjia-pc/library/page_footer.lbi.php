<?php 
/*
 Name: PC端公用尾部模块
 Description: 这是PC端公用尾部模块
 */
defined('IN_ECJIA') or exit('No permission resources.');
?>
<div class="ecjia-page-footer">
	<div class="foot-top">
		<p>{t domain="ecjia-pc"}特色{/t}<span class="ecjia-green">{t domain="ecjia-pc"}到家{/t}</span>{t domain="ecjia-pc"}平台{/t}</p>
		<p class="">{t domain="ecjia-pc"}品类齐全，轻松购物，为您呈现不一样的生活服务平台{/t}</p>
		<div class="helper">
			<div class="mod" data-spm-ab="1">
				<div class="mod-wrap">
			  		<h4>
				 		<i class="icon-foot-1"></i>
				        <div>{t domain="ecjia-pc"}正品保障{/t}</div>
				        <div>{t domain="ecjia-pc"}正品行货，放心选购{/t}</div>
			      </h4>
				</div>
			</div>
			
			<div class="mod" data-spm-ab="2">
				<div class="mod-wrap">
			  		<h4>
				 		<i class="icon-foot-2"></i>
				        <div>{t domain="ecjia-pc"}产地直采{/t}</div>
				        <div>{t domain="ecjia-pc"}100%产地直采，放心低价{/t}</div>
			      </h4>
				</div>
			</div>
			
			<div class="mod" data-spm-ab="3">
				<div class="mod-wrap">
			  		<h4>
				 		<i class="icon-foot-3"></i>
				        <div>{t domain="ecjia-pc"}准时送达{/t}</div>
				        <div>{t domain="ecjia-pc"}收货时间，自主选择{/t}</div>
			      </h4>
				</div>
			</div>
			
			<div class="mod" data-spm-ab="4">
				<div class="mod-wrap">
			  		<h4>
				 		<i class="icon-foot-4"></i>
				        <div>{t domain="ecjia-pc"}售后无忧{/t}</div>
				        <div>{t domain="ecjia-pc"}客服全年无休，用户体验至上{/t}</div>
			      </h4>
				</div>
			</div>
		</div>
		{if $info.region_list}
		<div class="hot-city">
			<div class="hot-city-left">{t domain="ecjia-pc"}经营城市{/t}</div>
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
			<div class="friend-link-title">{t domain="ecjia-pc"}合作伙伴{/t}</div>
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
				<span>{t domain="ecjia-pc"}打开微信扫一扫关注{/t}</span>
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
    <p>{if $info.company_name}{$info.company_name} {t domain="ecjia-pc"}版权所有{/t}{/if} {if ecjia::config('icp_number')}&nbsp;&nbsp;<a href="http://beian.miit.gov.cn" target="_blank"> {ecjia::config('icp_number')}</a>{/if}&nbsp;&nbsp;{$info.powered}</p>
    <p>{if $info.shop_address}{t domain="ecjia-pc"}地址：{/t}{$info.shop_address} {/if} {if $info.service_phone} {t domain="ecjia-pc"}咨询热线：{/t}{$info.service_phone}{/if}</p>
</div>
{if ecjia::config('stats_code')}
	{stripslashes(ecjia::config('stats_code'))}
{/if}