<?php
/*
Name: 分类模板
Description: 分类页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.touch.category.init();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<div class="ecjia-mod category">
	<!-- #BeginLibraryItem "/library/index_header.lbi" --><!-- #EndLibraryItem -->
    <ul class="ecjia-list category_left">
        <!--{foreach from=$data item=cat}-->
        <li{if $cat.id eq $cat_id} class="active"{/if}><a href="javascript:;" data-rh="1" data-val="{$cat.id}">{$cat.name|escape:html}</a></li>
        <!--{/foreach}-->
    </ul>
    <div class="category_right">
		<!--{foreach from=$data item=children}-->
			<div class="cat_list ecjia-category-list {if $cat_id eq $children.id}show{else}hide{/if}" id="category_{$children.id}">
	            <a href="{if $children.url}{$children.url}{else}{RC_Uri::url('goods/category/store_list')}&cid={$children.id}{/if}">
	            	<img src="{$children.image}" alt="{$children.name}">
	            </a>
	            <!-- {foreach from=$children.children item=val} -->
	            <div>
		            <div class="hd">
		                <h5>
		                    <span class="line"></span>
		                    <a href="{if $val.url}{$val.url}{else}{RC_Uri::url('goods/category/store_list')}&cid={$val.id}{/if}">
		                    	<span class="goods-index-title"><span class="point"></span>{$val.name}<span class="iconfont icon-jiantou-right"></span></span>
		                    </a>
		                </h5>
		            </div>
		            <ul class="ecjia-margin-t">
		            	<!-- {if $val.children} -->
		                <!--{foreach from=$val.children item=cat}-->
		                <li>
		                    <a href="{if $cat.url}{$cat.url}{else}{RC_Uri::url('goods/category/store_list')}&cid={$cat.id}{/if}">
		                        <div class="cat-img">
		                            <img src="{if $cat.image}{$cat.image}{else}{$theme_url}images/default-goods-pic.png{/if}" alt="{$cat.name}">
		                        </div>
		                        <div class="child_name">{$cat.name}</div>
		                    </a>
		                </li>
			           	<!--{/foreach}-->
			           	<!-- {else} -->
			           	<li>
		                    <a href="{if $val.url}{$val.url}{else}{RC_Uri::url('goods/category/store_list')}&cid={$val.id}{/if}">
		                        <div class="cat-img">
		                            <img src="{if $val.image}{$val.image}{else}{$theme_url}images/default-goods-pic.png{/if}" alt="{$val.name}">
		                        </div>
		                        <div class="child_name">{$val.name}</div>
		                    </a>
		                </li>
		                <!-- {/if} -->
		            </ul>
				</div>
		    	<!-- {/foreach} -->  
            </div>
    	<!--{/foreach}-->
    </div>
</div>
<!-- #BeginLibraryItem "/library/model_bar.lbi" --><!-- #EndLibraryItem -->
<!-- {/block} -->