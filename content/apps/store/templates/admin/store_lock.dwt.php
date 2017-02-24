<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.store_lock.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<style>
	.unlock{
		background:#62c462 -moz-linear-gradient(center bottom , #62c462, #51a351) repeat scroll 0 0;
	}
</style>

<div>
	<h3 class="heading">
		{if $ur_here}{$ur_here}{/if}
		{if $action_link}
		<a href="{$action_link.href}" class="btn data-pjax"  style="float:right;margin-top:-3px;"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		{/if}
	</h3>
</div>

<div class="row-fluid">
	<div class="span12">
		<div class="tabbable tabs-left">
		
			<ul class="nav nav-tabs tab_merchants_nav">
				<li><a href='{RC_Uri::url("store/admin/preview","store_id={$smarty.get.store_id}")}' class="pjax" >基本信息</a></li>
				<li><a href='{RC_Uri::url("store/admin_commission/edit","store_id={$smarty.get.store_id}")}' class="pjax" >设置佣金</a></li>
				<li><a href='{RC_Uri::url("commission/admin/init","store_id={$smarty.get.store_id}")}' class="pjax" >结算账单</a></li>
				<li><a href='{RC_Uri::url("store/admin/view_staff","store_id={$smarty.get.store_id}")}' class="pjax" >查看员工</a></li>
			</ul>
			
			<div class="tab-content tab_merchants">
				<div class="tab-pane active span6" style="min-height:300px;">
    				<form class="form-horizontal"  name="theForm" action="{$form_action}" method="post" >
            	    	{if $status eq 1}
            	    	 <div class="alert alert-block alert-error fade in">
            	            <h4 class="alert-heading">温馨提示!</h4>
            	            <ul>
            	                <li>锁定店铺后，商家后台无法进行登录</li>
            	                <li>所有商品即可下架</li>
            	                <li>所有订单即可无效</li>
            	                <li>所有员工有关及资金进行冻结</li>
            	                <li>所有权限都暂无权限</li>
            	            </ul>
            	            <br>
            	            <button type="submit" class="btn"><i class="splashy-lock_small_locked"></i>锁定</button>
            	        </div>
            	    	{else}
            	    	 <div class="alert alert-block alert-success fade in">
            	            <h4 class="alert-heading">温馨提示!</h4>
            	            <ul>
            	                <li>锁定解锁后，商家后台可进行登录</li>
            	               	<li>锁定解锁后，商家后台可进行登录</li>
            	                <li>锁定解锁后，商家后台可进行登录</li>
            	                <li>锁定解锁后，商家后台可进行登录</li>
            	                <li>锁定解锁后，商家后台可进行登录</li>
            	            </ul>
            	            <br>
            	            <button type="submit" class="btn"><i class="splashy-lock_small_unlocked"></i>解锁</button>
            	        </div>
            	    	{/if}
            	    </form>
			    </div>
			</div>
		</div>
	</div>
</div>

<!-- {/block} -->