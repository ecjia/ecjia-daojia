<?php defined('IN_ECJIA') or exit('No permission resources.');?> 
<!-- start:footer -->
<!-- <footer> -->
<!--     <div class="container"> -->
        
<!--     </div> -->
<!-- </footer> -->
<div class="footer-bottom">
    <div class="container">
        <div class="footer-bottom-widget">
            <div class="row">
                <div class="col-sm-6">
                    <p>
	                    <span class="sosmed-footer">
	                    	{if ecjia::config('shop_weibo_url')}
	                        <a target="__blank" href="{ecjia::config('shop_weibo_url')}"><i class="fa fa-weibo" title='{t domain="merchant"}新浪微博{/t}'></i></a>
	                        {/if}
	                        
	                    	{if ecjia::config('qq')}
	                    	<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin={ecjia::config('qq')}&site={$http_host}&menu=yes"><i class="fa fa-qq" title='{t domain="merchant"}腾讯QQ{/t}'></i></a>
	                        {/if}
	                        
	                        {if ecjia::config('shop_wechat_qrcode')}
	                        <a href="javascript:;" style="color:#333333;"><i class="fa fa-weixin" data-toggle="popover" data-placement="top" data-id="shop_wechat_qrcode" title='{t domain="merchant"}打开手机微信扫一扫{/t}'></i></a>
	                        {/if}
	                        
	                        {if ecjia::config('skype')}
	                        <a target="__blank" href="{ecjia::config('skype')}"><i class="fa fa-skype" title="Skype"></i></a>
	                        {/if}
	                        
	                        {if ecjia::config('mobile_iphone_qrcode')}
	                        <a href="javascript:;" style="color:#333333;"><i class="fa fa-apple" data-toggle="popover" data-placement="top" data-id="mobile_iphone_qrcode" title='{t domain="merchant"}打开手机扫描二维码下载{/t}'></i></a>
	                        {/if}
	                        
	                        {if ecjia::config('mobile_android_qrcode')}
	                        <a href="javascript:;" style="color:#333333;"><i class="fa fa-android" data-toggle="popover" data-placement="top" data-id="mobile_android_qrcode" title='{t domain="merchant"}打开手机扫描二维码下载{/t}'></i></a>
	                    	{/if}
	                    </span>
	                    
	                    {if ecjia::config('shop_wechat_qrcode')}
	                    <div class="hide" id="content_shop_wechat_qrcode">
                        	<div class="t_c"><img class="w100 h100" src="{RC_Upload::upload_url(ecjia::config('shop_wechat_qrcode'))}"></div>
                        </div>
                        {/if}
                        
                        {if ecjia::config('mobile_iphone_qrcode')}
                        <div class="hide" id="content_mobile_iphone_qrcode">
                        	<div class="t_c"><img class="w100 h100" src="{RC_Upload::upload_url(ecjia::config('mobile_iphone_qrcode'))}"></div>
                        </div>
                        {/if}
                        
                        {if ecjia::config('mobile_android_qrcode')}
                        <div class="hide" id="content_mobile_android_qrcode">
                        	<div class="t_c"><img class="w100 h100" src="{RC_Upload::upload_url(ecjia::config('mobile_android_qrcode'))}"></div>
                        </div>
                        {/if}
                    </p>
                </div>
                <div class="col-sm-6">
                    <p class="footer-bottom-links">
                    Copyright &copy; 2018 {ecjia::config('shop_name')} {if ecjia::config('icp_number', 2)}<a href="http://www.miibeian.gov.cn" target="_blank">{ecjia::config('icp_number')}</a>{/if}
                    </p>
                    <p class="footer-bottom-links">
                        {$shop_info_html}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
$("[data-toggle='popover']").popover({
	trigger: 'hover',
	html: true,
	content: function() {
        var id = $(this).attr('data-id');
        return $("#content_" + id).html();
	}
});
</script>

{if ecjia::config('stats_code')}
{stripslashes(ecjia::config('stats_code'))}
{/if}

<!-- end:footer -->
<div class="container">
<!-- {ecjia:hook id=admin_print_main_bottom} -->
</div>
