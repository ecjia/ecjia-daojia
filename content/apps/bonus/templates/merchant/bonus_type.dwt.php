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
		                        <option value=''  {if $type_list.filter.send_type eq '' } selected{/if}>{lang key='bonus::bonus.all_send_type'}</option>
		                        <option value='0' {if $type_list.filter.send_type eq '0'} selected{/if}>{lang key='bonus::bonus.send_by.0'}</option>
		                        <option value='1' {if $type_list.filter.send_type eq '1'} selected{/if}>{lang key='bonus::bonus.send_by.1'}</option>
		                        <option value='2' {if $type_list.filter.send_type eq '2'} selected{/if}>{lang key='bonus::bonus.send_by.2'}</option>
		                        <option value='3' {if $type_list.filter.send_type eq '3'} selected{/if}>{lang key='bonus::bonus.send_by.3'}</option>
		                    </select>
		                </div>
		                <button class="btn btn-primary screen-btn" type="button"><i class='fa fa-search'></i> {lang key='bonus::bonus.filter'}</button>
		            </div>
		        </form>
    		</div>
    		<div class="panel-body panel-body-small">
		        <section class="panel">
		            <table class="table table-striped table-hover table-hide-edit">
		                <thead>
		                    <tr>
		                        <th>{lang key='bonus::bonus.type_name'}</th>
		                        <th class="w150">{lang key='bonus::bonus.send_type'}</th>
		                        <th class="w150">{lang key='bonus::bonus.type_money'}</th>
		                        <th class="w150">{lang key='bonus::bonus.min_amount'}</th>
		                        <th class="w130">{lang key='bonus::bonus.send_count'}</th>
		                        <th class="w100">{lang key='bonus::bonus.use_count'}</th>
		                    </tr>
		                </thead>
		                <tbody>
		                    <!-- {foreach from=$type_list.item item=type} -->
		                    <tr>
		                        <td class="hide-edit-area">
		                            <span class="cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('bonus/merchant/edit_type_name')}" data-name="type_name" data-pk="{$type.type_id}" data-title="{lang key='bonus::bonus.edit_bonus_type_name'}">{$type.type_name}</span>
		                            <br/>
		                            <div class="edit-list">
		                                <a class="data-pjax" href='{RC_Uri::url("bonus/merchant/bonus_list", "bonus_type={$type.type_id}")}' title="{lang key='bonus::bonus.view_bonus'}">{lang key='bonus::bonus.view_bonus'}</a>&nbsp;|&nbsp;
		                                <a class="data-pjax" href='{RC_Uri::url("bonus/merchant/edit", "type_id={$type.type_id}")}' title="{lang key='system::system.edit'}">{lang key='system::system.edit'}</a> &nbsp;|&nbsp;
		                                <a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg="{lang key='bonus::bonus.remove_bonustype_confirm'}" href='{RC_Uri::url("bonus/merchant/remove","id={$type.type_id}")}' title="{lang key='system::system.remove'}">{lang key='system::system.drop'}</a>
		                                {if $type.send_type neq 2 && $type.send_type neq 4}
		                                &nbsp;|&nbsp;<a class="data-pjax" href='{RC_Uri::url("bonus/merchant/send", "id={$type.type_id}&send_by={$type.send_type}")}' title="{lang key='bonus::bonus.send_bonus'}">{lang key='bonus::bonus.send_bonus'}</a>
		                                {/if}
		                                {if $type.send_type eq 3}
		                                &nbsp;|&nbsp;<a href='{RC_Uri::url("bonus/merchant/gen_excel", "tid={$type.type_id}")}' title="{lang key='bonus::bonus.gen_excel'}">{lang key='bonus::bonus.gen_excel'}</a>
		                                {/if}
		                            </div>
		                        </td>
		                        <td>{$type.send_by}</td>
		                        <td>
		                            <span class="cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('bonus/merchant/edit_type_money')}" data-name="type_money" data-pk="{$type.type_id}" data-title="{lang key='bonus::bonus.edit_bonus_money'}">{$type.type_money}</span>
		                        </td>
		                        <td>
		                        	<!-- {if $type.send_type eq 2} -->
		                            <span class="cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('bonus/merchant/edit_min_amount')}" data-name="min_amount" data-pk="{$type.type_id}" title="{lang key='bonus::bonus.edit_order_limit'}">{$type.min_amount}</span>
		                        	<!-- {else} -->
									0.00
									<!-- {/if} -->
		                        </td>
		                        <td>{$type.send_count}</td>
		                        <td>{$type.use_count}</td>
		                    </tr>
		                    <!-- {foreachelse} -->
		                    <tr><td class="no-records" colspan="6">{lang key='system::system.no_records'}</td></tr>
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