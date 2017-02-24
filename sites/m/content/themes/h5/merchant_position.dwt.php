<?php 
/*
Name: 店铺位置
Description: 这是店铺位置地图页面
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->
<!-- {block name="footer"} -->
<style type="text/css">
.ecjia{
	height: 100%;
	max-width: 640px;
}
.ecjia #allmap{
	width: 100%;
	height: 100%;
}
</style>
<script charset="utf-8" src="https://map.qq.com/api/js?v=2.exp"></script>
<script type="text/javascript">
var address = '{$shop_address}';
var geocoder,map,marker = null;
map = new qq.maps.Map(document.getElementById('allmap'),{
    zoom: 18
});
var info = new qq.maps.InfoWindow({
    map: map
});
//调用地址解析类
geocoder = new qq.maps.Geocoder({
    complete : function(result){
        map.setCenter(result.detail.location);
        var marker = new qq.maps.Marker({
            map:map,
            position: result.detail.location
        });

        //默认显示标记提示 
        info.open();
        info.setContent('<div style="width:auto;height:20px;">'+
            result.detail.address+'</div>');
        info.setPosition(result.detail.location);
        
        //添加监听事件 当标记被点击了  设置图层
        qq.maps.event.addListener(marker, 'click', function() {
            info.open();
            info.setContent('<div style="width:auto;height:20px;">'+
                result.detail.address+'</div>');
            info.setPosition(result.detail.location);
        });
    }
});
geocoder.getLocation(address);
</script>
<!-- {/block} -->
<!-- {block name="main-content"} -->
<div id="allmap">
</div>
<!-- {/block} -->