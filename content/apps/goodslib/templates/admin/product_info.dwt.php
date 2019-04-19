<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.product.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
{if $step eq '8'}
<!-- #BeginLibraryItem "/library/goods_step.lbi" --><!-- #EndLibraryItem -->
{/if}
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
        	{if !$step}
            <ul class="nav nav-tabs">
                <!-- {foreach from=$tags item=tag} -->
                <li{if $tag.active} class="active"{/if}><a{if $tag.active} href="javascript:;"{else}{if $tag.pjax} class="data-pjax"{/if} href='{$tag.href}'{/if}><!-- {$tag.name} --></a></li>
                <!-- {/foreach} -->
            </ul>
            {/if}

            <form class="form-horizontal" action="{$form_action}{if $code}&extension_code={$code}{/if}" method="post" enctype="multipart/form-data" name="theForm">
                <div class="row-fluid">
                    <div class="control-group formSep">
                        <table class="table table-striped table-hide-edit product_list">
                            <thead>
                                <tr>
                                    <th><!-- {foreach from=$attribute item=attribute_value} -->
                                    {$attribute_value.attr_name} {if $attribute_value@last}{else}/{/if}
                                    <!--  {/foreach} --></th>
                                    <th class="product_sn">{t domain="goodslib"}货号{/t}</th>
                                    <th class="w100">{t domain="goodslib"}操作{/t}</td>
                                </tr>
                            </thead>
                            
                            <tbody>
                                {foreach from=$product_list item=product}
                                <tr>
                                    <td>{foreach from=$product.goods_attr item=goods_attr}
                                    {$goods_attr} {if $goods_attr@last}{else}/{/if}
                                    {/foreach}</td>
                                    <td class="product_sn">
	                                    <span class="cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('goodslib/admin/edit_product_sn')}" data-name="edit_product_sn" data-pk="{$product.product_id}" data-title="{t domain="goodslib"}编辑货品货号{/t}">
	                                    {$product.product_sn}
	                                    </span>
                                    </td>
                                    <td>
                                        <a class="data-pjax" href="{url path="goodslib/admin/product_edit" args="id={$product.product_id}&goods_id={$goods_id}"}"><i class="fontello-icon-edit"></i></a>
                                        <a class="ecjiafc-red ajax-remove" data-toggle="ajaxremove" data-msg="{t domain="goodslib"}确定要删除吗？{/t}" href='{url path="goodslib/admin/product_remove" args="id={$product.product_id}"}' title="{t domain="goodslib"}删除{/t}"><i class="fontello-icon-trash ecjiafc-red"></i></a></td>
                                </tr>
                                {/foreach}
                                
                                <tr class="attr_row">
                                    <td><!-- {foreach from=$attribute item=attribute_value key=attribute_key} -->
                                        <div class="f_l m_r5">
                                        <select name="attr[{$attribute_value.attr_id}][]" class="w150">
                                            <option value="0" selected>{t domain="goodslib"}请选择...{/t}</option>
                                            <!-- {foreach from=$attribute_value.attr_values item=value} -->
                                                <option value="{$value}">{$value}</option>
                                            <!-- {/foreach} -->
                                        </select>
                                        </div>
                                    <!-- {/foreach} --></td>
                                    <td><input class="w150" type="text" name="product_sn[]" value="" size="20"/></td>
                                    <td><a class="no-underline ecjiafc-red" data-toggle="remove_product" data-parent=".attr_row" href="javascript:;"><i class="fontello-icon-minus"></i></a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <a class="m_l5 l_h30 add_item" href="javascript:;">{t domain="goodslib"}再添加一项{/t}</a>
                </div>
                <div class="t_c">
                	{if $step}
                	<input type="hidden" name="step" value="{$step}" />
                	<input type="submit" name="submit" value="{t domain="goodslib"}完成{/t}" class="btn btn-gebo" />
                	{else}
                	<input type="submit" name="submit" value="{t domain="goodslib"}保存{/t}" class="btn btn-gebo" />
                	{/if}
                	<input type="hidden" name="goods_id" value="{$goods_id}" />
                	<input type="hidden" name="act" value="product_add_execute" />
                </div>
            </form>
        </div>
        
        <div class="hide">
            <table class="clone_div">
                <tr class="attr_row">
                    <td><!-- {foreach from=$attribute item=attribute_value key=attribute_key} -->
                        <div class="f_l m_r5">
                        <select name="attr[{$attribute_value.attr_id}][]" class="w150">
                            <option value="0" selected>{t domain="goodslib"}请选择...{/t}</option>
                            <!-- {foreach from=$attribute_value.attr_values item=value} -->
                                <option value="{$value}">{$value}</option>
                            <!-- {/foreach} -->
                        </select>
                        </div>
                    <!-- {/foreach} --></td>
                    <td><input class="w150" type="text" name="product_sn[]" value="" size="20"/></td>
                    <td><a class="no-underline" data-toggle="clone_product" data-parent=".attr_row" href="javascript:;"><i class="fontello-icon-plus"></i></a> </td>
                </tr>
            </table>
        </div>
    </div>
</div>
<!-- {/block} -->