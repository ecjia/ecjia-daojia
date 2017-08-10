<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<a class="btn plus_or_reply data-pjax" href="{$action_link.href}"  id="sticky_a"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
	</h3>
</div>

<div class="row-fluid ">
	<div class="span12">
		<div class="container_list">
			<ul>
				<!-- 默认 -->
				<li>
					<p style="text-align: right;">
						<img src="{$ok_img}" />
					</p>
					<h2>默认</h2>
					<h3></h3>
					<p style="margin-top:25px;">Code：{$config.code}</p>
					<p style="margin-top:25px;">
						{if $config.code eq 'ecjia-cityo2o-h5'}
							<img src="{$h5}"/>
						{elseif $config.code eq 'ecjia-shop-weapp'}
							<img src="{$wechant_client}" />
						{else}
							<img src="{$Android_img}" /><img src="{$iPhone_img}" />
						{/if}
					</p>
					<p style="margin-top:60px;">
						<a style="cursor:pointer;"  class="data-pjax" href='{RC_Uri::url("mobile/admin_mobile_config/config_push", "code={$config.code}")}'><span>配置</span></a>
					</p>
				</li>
				
				<!-- {foreach from=$data item=list} -->
					<li>
					    {if $list.app_id}
						    <p style="text-align: right;">
								{if $list.status eq 1}<img src="{$ok_img}" />{else}<img src="{$error_img}" />{/if}
							</p>
							<h2>{$list.app_name}</h2>
							<h3></h3>
							<p style="margin-top:25px;">{$list.device_name}</p>
							<p style="margin-top:25px;">
								{if $list.device_client eq 'android'}
									<img src="{$Android_img}" />
								{elseif $list.device_client eq 'iphone'}
									<img src="{$iPhone_img}" />
								{elseif $list.device_client eq 'h5'}
							 		<img src="{$h5}" />
							 	{else}
							 	    <img src="{$wechant_client}" />
							 	{/if}
							</p>
							<p style="margin-top:60px;">
								<a style="cursor:pointer;"  class="data-pjax" href='{RC_Uri::url("mobile/admin_mobile_manage/edit", "code={$config.code}&id={$list.app_id}")}'>查看</a>
								<a style="cursor:pointer;"  class="data-pjax" href='{RC_Uri::url("mobile/admin_mobile_config/config_push", "code={$config.code}&app_id={$list.app_id}")}'>配置</a>
							</p>
					    {else}
						    <p style="text-align: right;"><img src="{$error_img}" /></p>
							<h2>未激活</h2>
							<h3></h3>
							<p style="margin-top:72px;">
								{if $list.device_client eq 'android'}
									<img src="{$Android_img}" />
								{elseif $list.device_client eq 'iphone'}
									<img src="{$iPhone_img}" />
								{elseif $list.device_client eq 'h5'}
							 		<img src="{$h5}" />
							 	{else}
							 	    <img src="{$wechant_client}" />
							 	{/if}
							</p>
							<p style="margin-top:60px;">
							<a style="cursor:pointer;" class="data-pjax"  href='{RC_Uri::url("mobile/admin_mobile_manage/open", "code={$config.code}&device_code={$list.device_code}&device_client={$list.device_client}")}'>激活</a>
							</p>
					    {/if}
					</li>
				<!-- {/foreach} -->
			</ul>
		</div>
	</div>
</div>
<!-- {/block} -->