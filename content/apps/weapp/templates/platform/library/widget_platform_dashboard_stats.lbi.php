<?php defined('IN_ECJIA') or exit('No permission resources.'); ?>
<div class="card weui-desktop-panel weui-desktop-panel_overview">
    <div class="card-header">
        <h4 class="card-title">{t domain="weapp"}账号整体情况{/t}</h4>
    </div>
    <div class="cart-body weui-desktop-panel__bd">
        <ul class="weui-desktop-data-overview-list weui-desktop-home-overview">
            <li class="weui-desktop-data-overview">
		 		<span class="weui-desktop-data-overview__title">
			 		<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
						<path d="M5.882 15.931A8.366 8.366 0 0 0 10 17c4.418 0 8-3.358 8-7.5C18 5.358 14.418 2 10 2S2 5.358 2 9.5c0 2.028.859 3.869 2.254 5.219l-.274 1.35a.5.5 0 0 0 .74.533l1.162-.67zm.074 2.26L2.664 19.48a.8.8 0 0 1-1.077-.896l.603-3.15C.82 13.807 0 11.743 0 9.5 0 4.253 4.477 0 10 0s10 4.253 10 9.5S15.523 19 10 19c-1.44 0-2.807-.289-4.044-.809z"></path>
					</svg>
					{t domain="weapp"}新访客用户{/t}
				</span>
                <em class="weui-desktop-data-overview__desc">
                    <a href="{RC_Uri::url('weapp/platform_user/init')}">{$count.new_cancel_user}</a>
                </em>
            </li>
            <li class="weui-desktop-data-overview">
				<span class="weui-desktop-data-overview__title">
					<svg width="23" height="15" viewBox="0 0 23 15" xmlns="http://www.w3.org/2000/svg">
						<path d="M19.405 2.667L14 8.845l-5-3-9 8 1 1 8-7 5 3 6.505-7.318 2.279 1.78L22.488 0l-5.22.997 2.137 1.67z"></path>
					</svg>
					{t domain="weapp"}新增人数{/t}
				</span>
                <em class="weui-desktop-data-overview__desc">
                    <a href="{RC_Uri::url('weapp/platform_user/init')}">{$count.new_user}</a>
                </em>
            </li>
            <li class="weui-desktop-data-overview">
				<span class="weui-desktop-data-overview__title">
					<svg width="21" height="20" viewBox="0 0 21 20" xmlns="http://www.w3.org/2000/svg">
						<path d="M6.221 10.526c-.81-.905-1.08-2.952-1.08-3.526V4.21C5.14 1.915 7.82 0 10.445 0s5.304 2.105 5.304 4.21V7c0 2.297-.749 3-1.08 3.526L13.393 12c-.174.352.23.915 1.276 1.684 1.22.562 2.105 1 2.655 1.316 1.008.579 1.959.947 2.949 2 .99 1.053.982 3-.105 3H.722c-.779 0-1.088-2-.105-3 .983-1 1.586-1.183 2.948-2 .448-.268 1.334-.707 2.656-1.316 1.046-.77 1.45-1.333 1.276-1.684L6.22 10.526zM8 10c.63.632.963.912 1 .842.092.199.092 1.251 0 3.158-5.176 2.667-7.56 4-7.151 4H18l-6-4c-.091-1.906-.091-2.959 0-3.158.128.035.475-.263 1.041-.895.36-.402.73-1.105.85-1.947.162-1.142 0-2.505 0-3.421C13.89 2.989 12 2 10 2S7 4 7 5c0 .845-.156 1.91 0 3a3.362 3.362 0 0 0 1 2z"></path>
					</svg>
					{t domain="weapp"}总用户数{/t}
				</span>
                <em class="weui-desktop-data-overview__desc">
                    <a href="{RC_Uri::url('weapp/platform_user/init')}">{$count.user_count}</a>
                </em>
            </li>
        </ul>
    </div>
</div>
