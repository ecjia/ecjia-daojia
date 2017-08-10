<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
ecjia.admin.mobile_config.info();
</script>

<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a class="btn plus_or_reply data-pjax" href="{$action_link.href}" id="sticky_a"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>

<div class="row-fluid">
	<div class="span12">
	<div class="tabbable">
		<ul class="nav nav-tabs">
			<li><a class="data-pjax" href='{url path="mobile/admin_mobile_config/config_push" args="code={$code}&app_id={$app_id}"}'>推送配置</a></li>
			<li class="active"><a href='javascript:;'>支付配置</a></li>
		</ul>
		
		<div class="list-div list media_captcha wookmark warehouse" id="listDiv">
			{if $pay_list}
			  	<ul>
				<!-- {foreach from=$pay_list item=val} -->
					<li class='thumbnail'>
						<div class="bd {if $val.enabled eq 1}pay_open{else}pay_close{/if}">
							<div class="merchants_name">
								{$val.pay_name}<br>
								<div class="title">{$val.pay_code}</div><br>
								<span class="ecjiaf-fs1">
								{if $val.enabled eq 0}
									<a class="switch" href="javascript:;" data-url='{RC_Uri::url("mobile/admin_mobile_config/enable", "pay_code={$val.pay_code}&code={$code}&app_id={$app_id}")}' title="启用">点击启用</a>
								{else}
									<a class="switch" href="javascript:;" data-url='{RC_Uri::url("mobile/admin_mobile_config/disable", "pay_code={$val.pay_code}&code={$code}&app_id={$app_id}")}' title="禁用">点击禁用</a>
									&nbsp;&nbsp;|&nbsp;&nbsp;<a target="_blank" href='{url path="payment/admin/edit" args="code={$val.pay_code}"}'>插件配置</a></span>
								{/if}
							</div>
						</div>
					</li>
				<!-- {/foreach} -->
				</ul>
			{else}
				<pre class="sepH_c" style="background-color: #fbfbfb; height:80px;line-height:80px;">没有找到任何记录，需进行安装相关支付插件。</pre>
			{/if}
		</div>
	</div>
	</div>
</div>
<!-- {/block} -->