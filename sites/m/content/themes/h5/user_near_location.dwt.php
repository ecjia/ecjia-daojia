<?php 
/*
Name: 搜索位置
Description: 
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.touch.address_list();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<div id="ecjia-zs" data-type="address" data-url="{$action_url}{if $referer_url}&referer_url={$referer_url|escape:"url"}{/if}">
<div class="ecjia-zu" style="display:none"><span>{if $temp.tem_city_name}{$temp.tem_city_name}{else}{$smarty.cookies.city_name}{/if}</span></div>
    <div class="ecjia-zs">
      <div class="ecjia-zt al">
           <input class="ecjia-zv" type="text" id="search_location_list"
            data-toggle="search-address" data-url="{url path='location/index/search_list'}"
             name="address" placeholder="小区，写字楼，学校" maxlength="50" style="width: 100%;left:0;right:0;top:0; position:relative" >
      </div>
      <div class="ecjia-address_list">
           <ul class="nav-list-ready ecjia-location-list-wrap"></ul>    
      </div>
</div>
<!-- {/block} -->
{/nocache}