<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title></title>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="Cache-Control" content="public">
<script src="{RC_Uri::admin_url('statics/js/jquery.js')}"></script>
<style type="text/css">
body{
	background-color: #ffffff;
	padding: 0px;
	margin: 0px;
	text-align:left;
}
.table_box {
	table-layout: fixed;
	text-align:center;
}
.display_no {
	display:none;
}
</style>
<!-- {if $print_part != 1} -->
<script type="text/javascript">
/**
* 创建快递单打印内容
*/
$(document).ready(function(){
//创建快递单
var print_div = $('<div id="print_bg"></div>');

print_div.css({
	'background-image' : "url({$shipping.print_bg})",
	'width' : '{$shipping.print_bg_size.width}px',
	'height' : '{$shipping.print_bg_size.height}px',
	'position' : 'relative',
});

$('#print').append(print_div);

//创建文本
var config_lable = '{$shipping.config_lable}';
var lable = config_lable.split("||,||");

if (lable.length <= 0) {
	return false; //未设置打印内容
}
for (var i = 0; i < lable.length; i++) {
	//获取标签参数
	var text = lable[i].split(",");
	if (text.length <= 0 || text[0] == null || typeof(text[0]) == "undefined" || text[0] == '') {
		continue;
	}
	text[4] -= 10;
	text[5] -= 10;

	create_printcontent(text[0], text[1], text[2], text[3], text[4], text[5]);
	}
});
/**
* 创建快递单文本
*/
function create_printcontent(id, content, width, height, x, y) {
	var text_box = $("<div id='id'></div>");
	$("#print_bg").append(text_box);
	text_box.css({
		'width' : width + "px",
		'height' : height + "px",
		'position' : 'absolute',
		'top' : y + "px",
		'left' : x + "px",
		'text-align' : 'left',
		'word-break' : 'break-all'
	});
	text_box.html(content);
	return true;
}
</script>
<!-- {/if} -->
</head>
<body id="print">
	<!--打印区 start--><!--打印区 end-->
</body>
</html>