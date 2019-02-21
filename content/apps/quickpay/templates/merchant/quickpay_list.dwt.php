<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.merchant.quickpay_list.init();
</script>
<!-- {/block} -->


<!-- {block name="home-content"} -->

{if $quickpay_enabled}
<div class="alert alert-info">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-times" ></i></button>
	<strong>{t domain="quickpay"}温馨提示：{/t}</strong>{t domain="quickpay"}您已开启了买单活动，目前正在使用中。{/t}
</div>
{/if}

<div class="row">
	<div class="col-lg-12">
		<h2 class="page-header">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<div class="pull-right">
			{if $quickpay_enabled}
				<a id="ajaxclose" data-msg ='{t domain="quickpay"}你确定关闭买单吗？{/t}'data-href='{RC_Uri::url("quickpay/merchant/close")}'  class="btn btn-primary" title='{t domain="quickpay"}关闭买单{/t}'><i class="fa fa-minus-square"></i> {t domain="quickpay"}关闭买单{/t}</a>
			{else}
				<a id="ajaxopen" href='{RC_Uri::url("quickpay/merchant/open")}'  class="btn btn-primary" title='{t domain="quickpay"}开启买单{/t}'><i class="fa fa-check-square-o"></i> {t domain="quickpay"}开启买单{/t}</a>
			{/if}	
		</div>
		</h2>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="panel">
			<div class="panel-body panel-body-small">
				<form class="form-inline pull-left" name="selectFrom" action="{$search_action}" method="post">
					<div class="screen f_l">
						<div class="form-group">
							<select class="w200" name='activity_type'>
								<option value="0">{t domain="quickpay"}买单优惠类型{/t}</option>
								<!-- {foreach from=$type_list item=list key=key} -->
								<option value="{$key}" {if $key eq $smarty.get.activity_type}selected="selected"{/if}>{$list}</option>
								<!-- {/foreach} -->
							</select>
						</div>
						<button class="btn btn-primary screen-btn" type="submit"><i class="fa fa-search"></i> {t domain="quickpay"}筛选{/t}</button>
					</div>
				</form>
				
				<form class="form-inline pull-right" name="searchForm" method="post" action="{$search_action}">
					<div class="form-group">
						<!-- 关键字 -->
						<input type="text" class="form-control" name="keywords" value="{$smarty.get.keywords}" placeholder='{t domain="quickpay"}请输入买单名称{/t}'/> 
						<button class="btn btn-primary" type="submit">{t domain="quickpay"}搜索{/t}</button>
					</div>
				</form>
			</div>
			<div class="panel-body panel-body-small">
				<section class="panel">
					<table class="table table-striped table-hover table-hide-edit">
						<thead>
							<tr>
								<th class="w200">{t domain="quickpay"}买单标题{/t}</th>
								<th class="w200">{t domain="quickpay"}买单优惠类型{/t}</th>
								<th class="w150">{t domain="quickpay"}开始时间{/t}</th>
								<th class="w150">{t domain="quickpay"}结束时间{/t}</th>
								<th class="w50">{t domain="quickpay"}状态{/t}</th>
							</tr>
						</thead>
						<tbody>
							<!-- {foreach from=$quickpay_list.list item=list} -->
							<tr>
								<td class="hide-edit-area">
		                           {$list.title}
		                           <div class="edit-list">
		                               <a class="data-pjax" href='{url path="quickpay/merchant/edit" args="id={$list.id}"}' title='{t domain="quickpay"}编辑{/t}'>{t domain="quickpay"}编辑{/t}</a>&nbsp;|&nbsp;
		                               <a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg="你确定要删除该优惠买单规则吗？" href='{url path="quickpay/merchant/remove" args="id={$list.id}"}' title='{t domain="quickpay"}删除{/t}'>{t domain="quickpay"}删除{/t}</a>&nbsp;|&nbsp;
		                               <a target="_blank" href='{url path="quickpay/mh_order/init" args="act_id={$list.id}"}' title='{t domain="quickpay"}查看订单{/t}'>{t domain="quickpay"}查看订单{/t}</a>
		                           </div>
		                        </td>
								<td>{if $list.activity_type eq 'discount'}{t domain="quickpay"}价格折扣{/t}{elseif $list.activity_type eq 'everyreduced'}{t domain="quickpay"}每满多少减多少，最高减多少{/t}{else $list.activity_type eq 'reduced'}{t domain="quickpay"}满多少减多少{/t}{/if}</td>
								<td>{$list.start_time}</td>
								<td>{$list.end_time}</td>
								<td>{if $now lt $list.start_time}未开始{elseif $now gt $list.end_time}{t domain="quickpay"}已结束{/t}{else}{t domain="quickpay"}进行中{/t}{/if}</td>
							</tr>
							<!-- {foreachelse} -->
							   <tr><td class="no-records" colspan="5">{t domain="quickpay"}没有找到任何记录{/t}</td></tr>
							<!-- {/foreach} -->
						</tbody>
					</table>
					<br/>
					<a href="{$action_link.href}" class="btn btn-primary data-pjax"><i class="fa fa-plus"></i> {$action_link.text}</a>
					<br/><br/>
				</section>
			<!-- {$quickpay_list.page} -->
			</div>
		</div>
	</div>
</div>
<!-- {/block} -->