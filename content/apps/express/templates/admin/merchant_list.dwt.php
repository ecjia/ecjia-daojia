<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.merchant_list.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
	</h3>
</div>


<div class="row-fluid batch" >
	<ul class="nav nav-pills">
		<li class="{if $smarty.get.cat_id eq ''}active{/if}">
			<a class="data-pjax" href='{url path="express/admin_merchant/init" args="{if $smarty.get.keyword}keyword={$smarty.get.keyword}{/if}"}'>全部 
				<span class="badge badge-info">{if $allnumber}{$allnumber}{else}0{/if}</span>
			</a>
		</li>
		
		<!-- {foreach from=$cat_list item=val} -->
			<li class="{if $smarty.get.cat_id eq $val.cat_id}active{/if}">
				<a class="data-pjax" href='{url path="express/admin_merchant/init" args="cat_id={$val.cat_id}{if $smarty.get.keyword}&keyword={$smarty.get.keyword}{/if}"}'>{$val.cat_name}
					<span class="badge badge-info">{if $val.number}{$val.number}{else}0{/if}</span>
				</a>
			</li>
		<!-- {/foreach} -->
	
		<form method="post" action="{$search_action}{if $smarty.get.cat_id}&cat_id={$smarty.get.cat_id}{/if}" name="searchForm">
			<div class="choose_list f_r">
				<input type="text" name="keyword" value="{$smarty.get.keyword}" placeholder="请输入商家名称"/> 
				<button class="btn search_merchant" type="button">搜索</button>
			</div>
		</form>
	</ul>
</div>

<div class="row-fluid">
	<div class="span12">
		<div class="merchant_box">
			{if $data.list}
				<ul class="merchant_list">
					<!-- {foreach from=$data.list item=list} -->
						<li>
							<a href='{url path="express/admin_merchant/detail" args="store_id={$list.store_id}"}'>
								<div class="bd">
									<div class="list-top">
										<img src="{if $list.img}{RC_Upload::upload_url()}/{$list.img}{else}{RC_Uri::admin_url('statics/images/nopic.png')}{/if}"><span>{$list.merchants_name}</span>
									</div>
									<div class="list-mid">
										<p><font class="ecjiafc-red">{$list.wait_grab}</font><br>待抢单</p>
										<p><font class="ecjiafc-red">{$list.wait_pickup}</font><br>待取货</p>
										<p><font class="ecjiafc-red">{$list.delivery}</font><br>配送中</p>
									</div>
									
									<div class="list-bot">
										<div><label>营业时间：</label>{$list.shop_trade_time.start}-{$list.shop_trade_time.end}</div>
										<div><label>商家电话：</label>{$list.shop_kf_mobile}</div>
										<div><label>商家地址：</label>{$list.district}{$list.street}{$list.address}</div>
									</div>
								</div>
							</a>
						</li>
					<!-- {/foreach} -->
				</ul>
				<!-- {$data.page} -->
			{else}
				<pre style=" background-color: #fbfbfb; height:80px;line-height:80px;text-align:center;">{lang key='system::system.no_records'}</pre>
			{/if}
		</div>
	</div>
</div>
<!-- {/block} -->