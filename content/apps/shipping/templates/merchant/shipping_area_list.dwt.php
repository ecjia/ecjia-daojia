<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.merchant.area_info.init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->
<div class="page-header">
	<div class="pull-left">
		<h2><!-- {if $ur_here}{$ur_here}{/if} --></h2>
  	</div>
  	<div class="pull-right">
  		<a href="{$shipping_method.href}" class="btn btn-primary data-pjax"><i class="fa fa-reply"></i> {$shipping_method.text}</a>
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
	        <div class='col-lg-12 panel-heading form-inline'>
        		<div class="btn-group form-group ">
        			<button data-toggle="dropdown" class="btn btn-primary dropdown-toggle btnSubmit" >
						<i class="fa fa-cogs"></i>
						{lang key='shipping::shipping_area.batch'}
						<span class="caret"></span>
					</button>
					<ul class="dropdown-menu">
						<li><a class="button_remove" data-name="area_ids" data-noselectmsg="{lang key='shipping::shipping_area.select_drop_area'}" data-url="{$form_action}" data-msg="{lang key='shipping::shipping_area.batch_drop_confirm'}" data-idclass=".checkbox:checked" data-toggle="ecjiabatch"  href="javascript:;"><i class="fa fa-trash-o"></i> {lang key='system::system.drop'}</a></li>
					</ul>
				</div>
				
				<form class="form-inline pull-right" action="{$form_action}" method="post" name="listForm">
        			<div class="form-group">
        				<input class="form-control" type="text" name="keywords" value="{$areas.filter.keywords}" placeholder="{lang key='shipping::shipping_area.area_name_keywords'}"/>
        			</div>
        			<button class="btn btn-primary" type="button" id="search_btn" onclick='javascript:ecjia.merchant.shippingObj.shipping_area_list_search("{$search_action}")'><i class="fa fa-search"></i> {lang key='shipping::shipping_area.search'}</button>
        		</form>
        		<input type="hidden" name="shipping_id" value="{$shipping_id}" />
				<input type="hidden" name="code" value="{$code}" />
    		</div>
			<div class="panel-body">
				<div class="row-fluid">
					<section class="panel">
						<table class="table table-striped table-hide-edit">
							<thead>
								<tr>
									<th class="table_checkbox check-list w30">
	        							<div class="check-item">
	        								<input id="checkall" type="checkbox" name="select_rows" data-toggle="selectall" data-children=".checkbox"/>
	        								<label for="checkall"></label>
	        							</div>
							        </th>	
								
									<th class="w150">{lang key='shipping::shipping_area.shipping_area_name'}</th>
									<th>{lang key='shipping::shipping_area.shipping_area_regions'}</th>
									<th class="w100">{lang key='system::system.handler'}</th>
								</tr>
							</thead>
							<tbody>
								<!-- {foreach from=$areas.areas_list item=area} -->
								<tr>
									<td class="check-list">
		    							<div class="check-item">
		    								<input id="check_{$area.shipping_area_id}" class="checkbox" type="checkbox" name="checkboxes[]" value="{$area.shipping_area_id}"/>
		    								<label for="check_{$area.shipping_area_id}"></label>
		    							</div>
						            </td>
									<td>{$area.shipping_area_name|escape:"html"}</td>
									<td>{$area.shipping_area_regions}</td>
									<td>
										<a class="data-pjax no-underline" href='{RC_Uri::url("shipping/mh_area/edit", "id={$area.shipping_area_id}&shipping_id={$shipping_id}&code={$code}")}' class="sepV_a" title="{lang key='system::system.edit'}"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></button></a>
										<a class="ajaxremove  no-underline" data-toggle="ajaxremove" data-msg="{lang key='shipping::shipping_area.drop_area_confirm'}" href='{RC_Uri::url("shipping/mh_area/remove_area","id={$area.shipping_area_id}")}' title="{lang key='system::system.remove'}"><button class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></button></a>
									</td>
								</tr>
								<!-- {foreachelse} -->
							    <tr><td class="no-records" colspan="4">{lang key='system::system.no_records'}</td></tr>
								<!-- {/foreach} -->
							</tbody>
						</table>
						<!-- {$areas.page} -->
					</section>
				</div>
			</div>
		</div>	
	</div>				
</div>						
<!-- {/block} -->