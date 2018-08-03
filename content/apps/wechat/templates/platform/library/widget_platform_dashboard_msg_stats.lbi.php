<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<div class="card weui-desktop-panel weui-desktop-panel_overview">
 	<div class="card-header">
        <h4 class="card-title">用户发送消息</h4>
    </div>
    <div class="cart-body weui-desktop-panel__bd">
		<ul id="list" class="weui-desktop-mass">
			<!-- {foreach from=$arr key=key item=val} -->
			<li class="weui-desktop-mass__item">
				<!-- {foreach from=$val item=v key=k} -->
				{if $k eq 0}
				<div class="weui-desktop-mass__overview">
					<em class="weui-desktop-mass__time">{$v.send_time_formated}</em>
				</div>
				{/if}

				<div class="weui-desktop-mass__content">
					<a href="{RC_Uri::url('wechat/platform_subscribe/subscribe_message')}&uid={$v.uid}" target="_blank">
						<div class="weui-desktop-mass-media weui-desktop-mass-appmsg">
							<div class="weui-desktop-mass-appmsg__hd">
								<i class="weui-desktop-mass-appmsg__thumb" style="background-image: url({$v.headimgurl});"></i>
							</div>
							<div class="weui-desktop-mass-appmsg__bd"><span class="weui-desktop-mass-appmsg__title">{$v.msg}</span></div>
							<div class="weui-desktop-mass-media__data-list"><span class="weui-desktop-mass-appmsg__title">{$v.send_time_detail}</span></div>
						</div>
					</a>
					</span>
				</div>
				<!-- {/foreach} -->
			</li>
			<!-- {/foreach} -->
		</ul>
	</div>
 </div>
