<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="meta"} -->
<title>
商家入驻 - {ecjia::config('shop_name')}
</title>
<!-- {/block} -->

<!-- {block name="title"} -->
商家入驻 - {ecjia::config('shop_name')}
<!-- {/block} -->

<!-- {block name="common_header"} -->
<!-- #BeginLibraryItem "/library/franchisee_nologin_header.lbi" --><!-- #EndLibraryItem -->
<!-- {/block} -->

<!-- {block name="home-content"} -->
<div class="container settled-container" style="">
	<div class="sett-banner" style="background:url({$static_url}franchisee_index.jpg) center center no-repeat;">
		<div class="banner-auto" style="width: 1100px;">
			<div class="s-b-tit">
				<h3>马上入驻 开向未来</h3>
				<div class="s-b-line">
				</div>
			</div>
			<div class="s-b-btn">
				<a href="{RC_Uri::url('franchisee/merchant/join')}" class="im-sett">我要入驻</a>
				<a href="{RC_Uri::url('franchisee/merchant/view')}" class="view-prog">入驻进度查询</a>
			</div>
		</div>
	</div>
	<div class="sett-section s-section-step">
		<div class="w w1100">
			<div class="sett-title">
				<div class="zw-tit">
					<h3>入驻流程</h3>
					<span class="line"></span>
				</div>
				<span class="yw-tit">ADVANCE REGISTRATION PROCESS</span>
			</div>
			<div class="sett-warp">
				<div class="item item-one">
					<div class="item-i">
						<i></i>
					</div>
					<div class="tit">
						1 提交入驻资料
					</div>
					<span>选择店铺类型/品牌</span>
					<span>填写入驻信息</span>
				</div>
				<em class="item-jt"></em>
				<div class="item item-two">
					<div class="item-i">
						<i></i>
					</div>
					<div class="tit">
						2 商家等待审核
					</div>
					<span>平台审核入驻信息</span>
					<span>通知商家</span>
				</div>
				<em class="item-jt"></em>
				<div class="item item-three">
					<div class="item-i">
						<i></i>
					</div>
					<div class="tit">
						3 完善店铺信息
					</div>
					<span>登录商家后台</span>
					<span>完善店铺信息</span>
				</div>
				<em class="item-jt"></em>
				<div class="item item-four">
					<div class="item-i">
						<i></i>
					</div>
					<div class="tit">
						4 店铺上线
					</div>
					<span>上传商品</span>
					<span>发布销售</span>
				</div>
			</div>
		</div>
	</div>

	{if $cat_list}
	<div class="sett-section s-section-cate">
		<div class="w w1100">
			<div class="sett-title">
				<div class="zw-tit">
					<h3>热招类目</h3>
					<span class="line"></span>
				</div>
				<span class="yw-tit">BUSINESS CATEGORY</span>
			</div>
			<div class="sett-warp">
				<!-- {foreach from=$cat_list item=val} -->
				<div class="item">
					{if $val.cat_image eq ''}
					<i style="background:url({$static_url}cat-icon.png) center center no-repeat;background-size:100%;"></i><span>{$val.cat_name}</span>
					{else}
					<i style="background:url({$val.cat_image}) center center no-repeat;background-size:100%;"></i><span>{$val.cat_name}</span>
					{/if}
				</div>
				<!-- {/foreach} -->

			</div>
		</div>
	</div>
	{/if}

	{if $shortcutDatas}
	<div class="sett-section s-section-case">
		<div class="w w1100">
			<div class="sett-title">
				<div class="zw-tit">
					<h3>成功案例</h3>
					<span class="line"></span>
				</div>
				<span class="yw-tit">SUCCESSFUL CASE</span>
			</div>
			<div class="sett-warp">
				<!-- {foreach from=$shortcutDatas key=k item=val} -->
				<div class="item item{$k+1}">
					<div class="item-top">
						<a href="{$val.url}" target="_blank"><img src="{$val.image}" width="250" height="200"></a>
					</div>
					<div class="item-bot">
						<div class="desc">
							{$val.text}
						</div>
					</div>
				</div>
				<!-- {/foreach} -->
			</div>
		</div>
	</div>
	{/if}

	{if $ecjia_merchant_shopinfo_list}
	<div class="sett-section s-section-help">
		<div class="w w1100">
			<div class="sett-title">
				<div class="zw-tit">
					<h3>常见问题</h3>
					<span class="line"></span>
				</div>
				<span class="yw-tit">COMMON PROBLEM</span>
			</div>
			<div class="sett-warp">
				<!-- {foreach from=$ecjia_merchant_shopinfo_list key=k item=val} -->
				<div class="item">
					<div class="number">
						{if $k lt 9}0{/if}{$k+1}
					</div>
					<div class="info">
						<div class="name">
							<div class="tit">
								<a target="_blank" href='{url path="merchant/merchant/shopinfo" args="id={$val.article_id}"}'>{$val.title}</a>
							</div>
							<div class="desc">
							</div>
						</div>
					</div>
				</div>
				<!-- {/foreach} -->
			</div>
		</div>
	</div>
	{/if}
</div>

{if ecjia::config('stats_code')}
	{stripslashes(ecjia::config('stats_code'))}
{/if}
<!-- {/block} -->
