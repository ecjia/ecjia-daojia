<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.merchant.product.init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->

{if $step}
<!-- #BeginLibraryItem "/library/goods_step.lbi" --><!-- #EndLibraryItem -->
{/if}

<div class="page-header">
	<div class="pull-left">
		<h2><!-- {if $ur_here}{$ur_here}{/if} --></h2>
	</div>
	<div class="pull-right">
		<!-- {if $action_link} -->
		<a class="btn btn-primary data-pjax" href="{$action_link.href}" id="sticky_a"><i class="fa fa-reply"></i> {$action_link.text}</a>
		<!-- {/if} -->
	</div>
  	<div class="clearfix"></div>
</div>

<div class="row-fluid">
    <div class="span12">
        <div class="panel">
        	{if !$step}
       		<div class="panel-body panel-body-small">
				<ul class="nav nav-tabs">
					<!-- {foreach from=$tags item=tag} -->
					<li {if $tag.active} class="active"{/if}><a {if $tag.active} href="javascript:;"{else}{if $tag.pjax} class="data-pjax"{/if} href='{$tag.href}'{/if}><!-- {$tag.name} --></a></li>
					<!-- {/foreach} -->
				</ul>
			</div>
			{/if}
			
			<div class="panel-body">
	            <form class="form-inline" action="{$form_action}{if $code}&extension_code={$code}{/if}" method="post" enctype="multipart/form-data" name="theForm">
	                <div class="row-fluid">
	                    <div class="control-group formSep">
	                        <table class="table table-striped table-hide-edit product_list">
	                            <thead>
	                                <tr>
	                                    <!-- {foreach from=$attribute item=attribute_value} -->
	                                    <th class="w110">{$attribute_value.attr_name}</th>
	                                    <!--  {/foreach} -->
	                                    <th class="product_sn">{lang key='goods::goods.goods_sn'}</th>
	                                    <th>{lang key='goods::goods.goods_number'}</th>
	                                    <th class="w100">{lang key='system::system.handler'}</th>
	                                </tr>
	                            </thead>
	                            
	                            <tbody>
	                                <!-- {foreach from=$product_list item=product} -->
	                                <tr>
	                                    <!-- {foreach from=$product.goods_attr item=goods_attr} -->
	                                    <td>{$goods_attr}</td>
	                                    <!-- {/foreach} -->
	                                    <td class="product_sn">
		                                    <span class="cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('goods/merchant/edit_product_sn')}" data-name="edit_product_sn" data-pk="{$product.product_id}" data-title="{lang key='goods::goods.edit_product_sn'}">
		                                    {$product.product_sn}
		                                    </span>
	                                    </td>
	                                    <td>
	                                    	<span class="cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('goods/merchant/edit_product_number')}" data-name="edit_product_number" data-pk="{$product.product_id}" data-title="{lang key='goods::goods.edit_product_number'}">
	                                    	{$product.product_number}
	                                    	</span>
	                                    </td>
	                                    <td><a class="btn btn-danger btn-xs" data-toggle="ajaxremove" data-msg="{lang key='goods::goods.trash_product_confirm'}" href='{url path="goods/merchant/product_remove" args="id={$product.product_id}"}' title="{lang key='system::system.drop'}"><i class="fa fa-trash-o"></i></a></td>
	                                </tr>
	                                <!-- {/foreach} -->
	                                
	                                <tr class="attr_row">
	                                    <!-- {foreach from=$attribute item=attribute_value key=attribute_key} -->
	                                    <td>
	                                        <select name="attr[{$attribute_value.attr_id}][]" class="form-control">
	                                            <option value="0" selected>{lang key='system::system.select_please'}</option>
	                                            <!-- {foreach from=$attribute_value.attr_values item=value} -->
	                                                <option value="{$value}">{$value}</option>
	                                            <!-- {/foreach} -->
	                                        </select>
	                                    </td>
	                                    <!-- {/foreach} -->
	                                    <td><div class="col-lg-4"><input class="form-control" type="text" name="product_sn[]" value="" size="20"/></div></td>
	                                    <td><div class="col-lg-4"><input class="form-control" type="text" name="product_number[]" value="" size="10"/></div></td>
	                                    <td><a class="no-underline ecjiafc-red" data-toggle="remove_product" data-parent=".attr_row" href="javascript:;"><i class="fa fa-times"></i></a></td>
	                                </tr>
	                            </tbody>
	                        </table>
	                    </div>
	                    <a class="m_l5 l_h30 add_item" href="javascript:;">再添加一项</a>
	                </div>
	                <div class="t_c">
	                	{if $step}
	                	<input type="hidden" name="step" value="{$step}" />
	                	<input type="submit" name="submit" value="{lang key='goods::goods.complete'}" class="btn btn-info" />
	                	{else}
	                	<input type="submit" name="submit" value="{lang key='goods::goods.save'}" class="btn btn-info" />
	                	{/if}
	                	<input type="hidden" name="goods_id" value="{$goods_id}" />
	                	<input type="hidden" name="act" value="product_add_execute" />
	                </div>
	            </form>
	    	</div>
        </div>
        
        <div class="hide">
            <table class="clone_div">
                <tr class="attr_row">
                    <!-- {foreach from=$attribute item=attribute_value key=attribute_key} -->
                    <td>
                        <select name="attr[{$attribute_value.attr_id}][]" class="form-control">
                            <option value="0" selected>{lang key='system::system.select_please'}</option>
                            <!-- {foreach from=$attribute_value.attr_values item=value} -->
                                <option value="{$value}">{$value}</option>
                            <!-- {/foreach} -->
                        </select>
                    </td>
                    <!-- {/foreach} -->
                    <td><div class="col-lg-4"><input class="form-control" type="text" name="product_sn[]" value="" size="20"/></div></td>
                    <td><div class="col-lg-4"><input class="form-control" type="text" name="product_number[]" value="" size="10"/></div></td>
                    <td><a class="no-underline" data-toggle="clone_product" data-parent=".attr_row" href="javascript:;"><i class="fa fa-plus"></i></a> </td>
                </tr>
            </table>
        </div>
    </div>
</div>
<!-- {/block} -->