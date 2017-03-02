<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->
<!-- {block name="footer"} -->
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a class="data-pjax btn plus_or_reply" id="sticky_a" href="{$action_link.href}"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>

<div class="row-fluid">
	<div class="span12">
		<div class="tabbable tabs-left">
		    {if $menu}
			<ul class="nav nav-tabs tab_merchants_nav">
                <!-- {foreach from=$menu item=val} -->
                <li {if $val.active}class="active"{/if}><a href="{$val.url}" {if $val.active}data-toggle="tab"{/if}>{$val.menu}</a></li>
                <!-- {/foreach} -->
			</ul>
			{/if}
			<div class="tab-content">
				<div class="tab-pane active">
				    <h3 class="ecjiaf-fwn">已启用<small class="ecjiaf-ff1">（删除配送区域即可关闭配送方式）</small></h3>
					<table class="table table-striped table-hide-edit">
	        		    <thead>
	        		      <tr>
	            		      <th class="w110">{lang key='shipping::shipping.shipping_name'}</th>
	    					  <th>{lang key='shipping::shipping.shipping_desc'}</th>
	    					  <th class="w80">{lang key='shipping::shipping.insure'}</th>
	    					  <th class="w100">{lang key='shipping::shipping.support_cod'}</th>
	        		      </tr>
	        		      
	        		    </thead>
	        		  	<tbody>
	        		  	<!-- {foreach from=$enabled item=module} -->
							<tr>
								<td>
									{$module.name}
								</td>
								<td class="hide-edit-area">
									{$module.desc|nl2br}
									<div class="edit-list">
										<a target="_blank" href='{RC_Uri::url("shipping/admin_area/init", "shipping_id={$module.id}&code={$module.code}&store_id={$store_id}")}'  title="{lang key='shipping::shipping.shipping_area'}">{lang key='shipping::shipping.set_shipping'}</a>
									</div>
								</td>
								<td>
									<!-- {if $module.is_insure } -->
										{$module.insure_fee}
									<!-- {else} -->
										{lang key='shipping::shipping.not_support'}
									<!-- {/if} -->
								</td>
								<td>
									{if $module.cod==1}
										{lang key='system::system.yes'}
									{else}
										{lang key='system::system.no'}
									{/if}
								</td>
							</tr>
						<!-- {foreachelse} -->
							<tr><td class="no-records" colspan="5">{lang key='system::system.no_records'}</td></tr>
						<!-- {/foreach} -->
	        			</tbody>
	        		</table>
	        		<h3 class="ecjiaf-fwn">未启用<small class="ecjiaf-ff1">（设置配送区域即可开启配送方式）</small></h3>
	        		<table class="table table-striped table-hide-edit">
	        		    <thead>
	        		      	<tr>
	            		      	<th class="w110">{lang key='shipping::shipping.shipping_name'}</th>
	    					  	<th>{lang key='shipping::shipping.shipping_desc'}</th>
	    					  	<th class="w80">{lang key='shipping::shipping.insure'}</th>
	    					  	<th class="w100">{lang key='shipping::shipping.support_cod'}</th>
	        		      	</tr>
	        		    </thead>
	        		  	<tbody>
	        		  	<!-- {foreach from=$disabled item=module} -->
						<tr>
							<td>
								{$module.name}
							</td>
							<td class="hide-edit-area">
								{$module.desc|nl2br}
								<div class="edit-list">
									<a target="_blank" href='{RC_Uri::url("shipping/admin_area/init", "shipping_id={$module.id}&code={$module.code}&store_id={$store_id}")}'  title="{lang key='shipping::shipping.shipping_area'}">{lang key='shipping::shipping.set_shipping'}</a>
								</div>
							</td>
							<td>
								<!-- {if $module.is_insure } -->
									{$module.insure_fee}
								<!-- {else} -->
									{lang key='shipping::shipping.not_support'}
								<!-- {/if} -->
							</td>
							<td>
								{if $module.cod==1}
									{lang key='system::system.yes'}
								{else}
									{lang key='system::system.no'}
								{/if}
							</td>
						</tr>
						<!-- {foreachelse} -->
						<tr><td class="no-records" colspan="4">{lang key='system::system.no_records'}</td></tr>
						<!-- {/foreach} -->
	        			</tbody>
	        		</table>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- {/block} -->