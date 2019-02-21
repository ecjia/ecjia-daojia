<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.merchant.bonus_type.type_list_init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->
<div class="page-header">
	<div class="pull-left">
		<h2><!-- {if $ur_here}{$ur_here}{/if} --></h2>
  	</div>
  	<div class="pull-right">
  		{if $action_link}
		<a href="{$action_link.href}" class="btn btn-primary data-pjax">
			<i class="fa fa-plus"></i> {$action_link.text}
		</a>
		{/if}
  	</div>
  	<div class="clearfix"></div>
</div>

<div class="row">
    <div class="col-lg-12">
    	<div class="panel">
    		<div class="panel-body panel-body-small">
    			<form class="form-inline pull-right" action="{RC_Uri::url('bonus/merchant/init')}{if $smarty.get.type}&type={$smarty.get.type}{/if}" method="post" name="filterForm">
		            <div class="screen f_r">
		                <div class="form-group">
		                    <select class="form-control" name="bonustype_id" id="select-bonustype">
		                        <option value=''  {if $type_list.filter.send_type eq '' } selected{/if}>{t domain="bonus"}所有发放类型{/t}</option>
		                        <option value='0' {if $type_list.filter.send_type eq '0'} selected{/if}>{t domain="bonus"}按用户发放{/t}</option>
		                        <option value='1' {if $type_list.filter.send_type eq '1'} selected{/if}>{t domain="bonus"}按商品发放{/t}</option>
		                        <option value='2' {if $type_list.filter.send_type eq '2'} selected{/if}>{t domain="bonus"}按订单金额发放{/t}</option>
		                        <option value='3' {if $type_list.filter.send_type eq '3'} selected{/if}>{t domain="bonus"}线下发放的红包{/t}</option>
		                    </select>
		                </div>
		                <button class="btn btn-primary screen-btn" type="button"><i class='fa fa-search'></i> {t domain="bonus"}筛选{/t}</button>
		            </div>
		        </form>
    		</div>
    		<div class="panel-body panel-body-small">
		        <section class="panel">
		            <table class="table table-striped table-hover table-hide-edit">
		                <thead>
		                    <tr>
		                        <th>{t domain="bonus"}类型名称{/t}</th>
		                        <th class="w150">{t domain="bonus"}发放类型{/t}</th>
		                        <th class="w150">{t domain="bonus"}红包金额{/t}</th>
		                        <th class="w150">{t domain="bonus"}最小订单金额{/t}</th>
		                        <th class="w130">{t domain="bonus"}发放数量{/t}</th>
		                        <th class="w100">{t domain="bonus"}使用数量{/t}</th>
		                    </tr>
		                </thead>
		                <tbody>
		                    <!-- {foreach from=$type_list.item item=type} -->
		                    <tr>
		                        <td class="hide-edit-area">
		                            <span class="cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('bonus/merchant/edit_type_name')}" data-name="type_name" data-pk="{$type.type_id}" data-title='{t domain="bonus"}编辑红包类型名称{/t}'>{$type.type_name}</span>
		                            <br/>
		                            <div class="edit-list">
		                                <a class="data-pjax" href='{RC_Uri::url("bonus/merchant/bonus_list", "bonus_type={$type.type_id}")}' title='{t domain="bonus"}查看红包{/t}'>{t domain="bonus"}查看红包{/t}</a>&nbsp;|&nbsp;
		                                <a class="data-pjax" href='{RC_Uri::url("bonus/merchant/edit", "type_id={$type.type_id}")}' title='{t domain="bonus"}编辑{/t}'>{t domain="bonus"}编辑{/t}</a> &nbsp;|&nbsp;
		                                <a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg='{t domain="bonus"}您确定要删除该红包类型吗？{/t}' href='{RC_Uri::url("bonus/merchant/remove","id={$type.type_id}")}' title='{t domain="bonus"}移除{/t}'>{t domain="bonus"}删除{/t}</a>
		                                {if $type.send_type neq 2 && $type.send_type neq 4}
		                                &nbsp;|&nbsp;<a class="data-pjax" href='{RC_Uri::url("bonus/merchant/send", "id={$type.type_id}&send_by={$type.send_type}")}' title='{t domain="bonus"}发放红包{/t}'>{t domain="bonus"}发放红包{/t}</a>
		                                {/if}
		                                {if $type.send_type eq 3}
		                                &nbsp;|&nbsp;<a href='{RC_Uri::url("bonus/merchant/gen_excel", "tid={$type.type_id}")}' title='{t domain="bonus"}导出报表{/t}'>{t domain="bonus"}导出报表{/t}</a>
		                                {/if}
		                            </div>
		                        </td>
		                        <td>{$type.send_by}</td>
		                        <td>
		                            <span class="cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('bonus/merchant/edit_type_money')}" data-name="type_money" data-pk="{$type.type_id}" data-title='{t domain="bonus"}编辑红包金额{/t}'>{$type.type_money}</span>
		                        </td>
		                        <td>
		                            <span class="cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('bonus/merchant/edit_min_amount')}" data-name="min_goods_amount" data-pk="{$type.type_id}" title='{t domain="bonus"}编辑最小订单金额{/t}'>{$type.min_goods_amount}</span>
		                        </td>
		                        <td>{$type.send_count}</td>
		                        <td>{$type.use_count}</td>
		                    </tr>
		                    <!-- {foreachelse} -->
		                    <tr><td class="no-records" colspan="6">{t domain="bonus"}没有找到任何记录{/t}</td></tr>
		                    <!-- {/foreach} -->
		                </tbody>
		            </table>
		        </section>
		         <!-- {$type_list.page} -->
		      </div>
	     </div>
    </div>
</div>
<!-- {/block} -->