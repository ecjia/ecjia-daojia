<?php
/*
Name: 闪惠红包
Description: 闪惠红包页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
ecjia.touch.user.init();
</script>
<!-- {/block} -->
<!-- {block name="main-content"} -->
<form id="theForm" name="theForm" action='{url path="user/quickpay/init" args="store_id={$store_id}"}' method="post">
	<div class="quickpay ecjia-select">
	    <div class="checkout">
	        <div class="before_two">
	        	<!-- {foreach from=$activity.bonus_list item=list} -->
	           	<div class="quickpay_div content">
	            	<li class="outher_d">
	                	<span class="radio-height radio-ml-t">
	                       	<label class="ecjia-check ecjiaf-fl"><input name="bonus" type="radio" value="{$list.bonus_id}" id="{$list.bonus_id}" {if $temp.bonus eq $list.bonus_id}checked{/if}></label>
	                   	</span>
	                   	<span class="ecjia-margin-l">{$list.type_name}</span>
	                   	<span class="ecjiaf-fr">{$list.bonus_money_formated}</span>
	               </li>
				</div>
	           	<!-- {foreachelse} -->
	           	<label class="select-item">
	           		<li>
	                    <span class="ecjia-color-999">暂无可用红包</span>
	                </li>
	          	</label>
	           	<!-- {/foreach} -->
	    	</div>
	    </div>
	    
		<div class="save_discard">
	    	<input class="btn mag-t1" name="bonus_update" type="submit" value="保存">
	        <input class="btn btn-hollow-danger mag-t1" name="bonus_clear" type="submit" value="清空">
	    </div>
	</div>
</form>
<!-- {/block} -->
{/nocache}