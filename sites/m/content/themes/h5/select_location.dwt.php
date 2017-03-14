<?php 
/*
Name:选择定位模板
Description: 选择定位模板，当前和搜索关键词
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">ecjia.touch.region_change();</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<div class="ecjia-zs">
	<a href="{url path='location/index/search_location'}" >
		<div class="ecjia-zt a1">
			<input class="ecjia-zv defaultWidth" type="text" placeholder="小区， 写字楼， 学校" maxlength="50">
		</div>
	</a>
	<div class="ecjia-zw">
		<a class="external" href="{$my_location}">
			<div class="ecjia-zx"><i></i><p>点击定位当前地点</p></div>
		</a>
	</div>
	{if $login}
	<div class="ecjia-list ecjia-address-list ecjia-select-address">
		<div class="address-backgroundw"><span>我的收货地址</span></div>
		{if $address_list}
		<ul class="list-one">
			<!-- {foreach from=$address_list item=value} 循环地址列表 -->
			<li>
				<a data-toggle="choose_address" href="{RC_Uri::url('user/address/choose_address')}&address_id={$value.id}{if $referer_url}&referer_url={$referer_url}{/if}">
					<div class="circle"></div>
					<div class="list">
						<div>
							<p class="ecjiaf-fl ecjia-mw6">{$value.consignee}</p>
							<p class="ecjiaf-fl ecjia-margin-l ecjia-address-mobile">{$value.mobile}</p>
						</div><br />
						<div class="ecjia-margin-top address ecjiaf-wwb">{$value.address}{$value.address_info}</div>	
					</div>
				</a>
			</li>
			<!-- {/foreach} -->
		</ul>
		{/if}
		<div class="address-list-center">
			<a type="botton" href="{url path='user/address/address_list'}">
				<i class="iconfont icon-roundadd"></i> {t}管理收货地址{/t}
			</a>
		</div>
	</div>
	{/if}
</div>
<!-- {/block} -->