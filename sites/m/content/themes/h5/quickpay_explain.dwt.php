<?php
/*
Name: 优惠说明
Description: 这是优惠说明页面
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
// 	ecjia.touch.user.init();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<div class="quickpay ecjia-margin-t">
    <div class="checkout">
		<div class="item_list">
			<div class="quickpay_div content">
	            <li class="explain_title"><span><b>{t}买单说明{/t}</b></span></li>
	            <li class="quickpay_list m_b0">
	                <p>{t}1、优惠买单仅限于到店消费后使用，请勿提前支付；{/t}</p>
	                <p>{t}2、请在输入买单金额前与商家确认门店信息和消费金额；{/t}</p>
	                <p>{t}3、遇节假日能否享受优惠，请详细咨询商家；{/t}</p>
	                <p>{t}4、请咨询商家能否与店内其他优惠同享；{/t}</p>
	                <p>{t}5、如需发票，请您在消费时向商家咨询；{/t}</p>
	            </li>
        	</div>
        </div>
        
        {if $data.activity_list}
        <div class="item_list ecjia-margin-t">
	        <div class="quickpay_div background_fff">
	            <li class="explain_title"><span><b>{t}买单优惠{/t}</b></span></li>
	            <div class="before_two line">
	            	<!-- {foreach from=$data.activity_list item=list} -->
	                <li class="outher_d explain_d">
	                    <div class="explain_info">
	                        <p class="explain_info_top">
	                        	<span class="explain_name">{$list.title}</span>
	                        	{if RC_Time::gmtime() lt $list.end_time && RC_Time::gmtime() gt $list.start_time}
	                        	<span class="explain_status">进行中</span>
	                        	{/if}
	                        </p>
	                        {if $list.limit_time_weekly neq '0' && $list.limit_time_weekly neq ''}
	                        <p class="explain_info_top">使用时间：{$list.limit_time_weekly}</p>
	                        {/if}
	                        {if $list.limit_time_exclude}
	                        <p class="explain_info_top">不可用时间：{$list.limit_time_exclude}</p>
	                        {/if}
	                        <p class="explain_info_top">{t}有效日期：{$list.formated_start_time}至{$list.formated_end_time}{/t}</p>
	                    </div>
	                </li>
	                <!-- {/foreach} -->
	            </div>
	        </div>
        </div>
        {/if}
        
    </div>
</div>
<!-- {/block} -->