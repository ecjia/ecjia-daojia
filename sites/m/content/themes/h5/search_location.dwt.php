<?php 
/*
Name: 关键词搜索地址
Description: 关键词搜索地址
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.touch.address_list();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<div id="ecjia-zs" data-type="index" data-url="{url path='touch/index/init'}">
	<div class="ecjia-zs">
      	<div class="ecjia-zt al">
			<a href="{url path='location/index/select_city' args="type=search{if $smarty.get.city_id}&city_id={$smarty.get.city_id}{else}&city_id=52{/if}"}">
				<h2 class="ecjia-zu">{if $smarty.get.city}{$smarty.get.city}{/if}</h2>
           	</a>
           <input class="ecjia-zv" type="text" id="search_location_list" data-toggle="search-address" data-url="{url path='location/index/search_list'}"  name="address" placeholder="小区，写字楼，学校" maxlength="50" >
      	</div>
		<div class="ecjia-address_list">
			<ul class="nav-list-ready ecjia-location-list-wrap"></ul>    
		</div>
	</div>
</div>
<!-- {/block} -->