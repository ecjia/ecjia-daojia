<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript"></script>
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
		        <section class="panel">
		            <table class="table table-striped table-hover table-hide-edit">
		                <thead>
		                    <tr>
		                        <th class="w150">{lang key='express::express.express_sn'}</th>
		                        <th class="w150">{lang key='express::express.delivery_sn'}</th>
		                        <th class="w150">{lang key='express::express.consignee'}</th>
		                        <th class="w150">{lang key='express::express.mobile'}</th>
		                        <th class="w150">{lang key='express::express.address'}</th>
		                        <th class="w150">{lang key='express::express.add_time'}</th>
		                        <th class="w100">{lang key='express::express.from'}</th>
		                        <th class="w100">{lang key='express::express.express_status'}</th>
		                    </tr>
		                </thead>
		                <tbody>
		                    <!-- {foreach from=$express_list item=list} -->
		                    <tr>
		                        <td class="hide-edit-area">
		                            {$list.express_sn}
		                            <br/>
		                            <div class="edit-list">
		                                <a class="data-pjax" href='{RC_Uri::url("express/merchant/info", "express_id={$list.express_id}")}' title="{lang key='express::express.view_info'}">{lang key='express::express.view_info'}</a><!-- &nbsp;|&nbsp;
		                                <a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg="{lang key='bonus::bonus.remove_bonustype_confirm'}" href='{RC_Uri::url("bonus/merchant/remove","id={$type.type_id}")}' title="{lang key='system::system.remove'}">{lang key='system::system.drop'}</a> -->
		                            </div>
		                        </td>
		                        <td>{$list.delivery_sn}</td>
		                        <td>
		                            {$list.consignee}
		                        </td>
		                        <td>
		                            {$list.mobile}
		                        </td>
		                        <td>{$list.address}</td>
		                        <td>{$list.formatted_add_time}</td>
		                        <td>{$list.label_from}</td>
		                        <td>{$list.label_status}</td>
		                    </tr>
		                    <!-- {foreachelse} -->
		                    <tr><td class="no-records" colspan="8">{lang key='system::system.no_records'}</td></tr>
		                    <!-- {/foreach} -->
		                </tbody>
		            </table>
		        </section>
		        <!-- {$page} -->
		      </div>
	     </div>
    </div>
</div>
<!-- {/block} -->