<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
	<title>Print</title>
	<meta name="robots" content="noindex, nofollow">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta http-equiv="Cache-Control" content="public">
	<link rel="stylesheet" id="bootstrap-css" href="{RC_Uri::content_url('system/statics/lib/bootstrap/css/bootstrap.min.css')}" type="text/css" media="all" />
	<script type="text/javascript" src="{RC_Uri::content_url('system/statics/js/jquery.min.js')}"></script>
	<script type="text/javascript" src="{RC_Uri::content_url('system/statics/js/jquery-pjax.min.js')}"></script>
	<script type="text/javascript" src="{RC_Uri::content_url('system/statics/lib/jquery-form/jquery.form.min.js')}"></script>
	<script type="text/javascript" src="{RC_Uri::content_url('system/statics/lib/bootstrap/js/bootstrap.min.js')}"></script>

	<script language="JavaScript">
	<!--
	// 这里把JS用到的所有语言都赋值到这里
	{foreach from=$lang_js_languages key=key item=item}
	var {$key} = "{$item}";
	{/foreach}
//-->
</script>
<style type="text/css">
body {
	background-color: #ffffff;
	padding: 0px;
	margin: 0px;
}

body,td {
	font-family: Arial, Verdana, sans-serif;
	font-size: 12px;
}

#top-row td {
	padding-top: 5px;
}

.table_box {
	border: #ccc 1px solid;
	table-layout: fixed;
}

table #header {
	background: -moz-linear-gradient(center top, #ffffff 0%, #f5f5f5 100%)
	repeat scroll 0 0 rgba(0, 0, 0, 0);
	border-radius: 4px;
}

.table_line {
	border: #3993ba 1px solid;
}
input {
	display: inline;
	width: auto;
	cursor: pointer;
	outline: medium none !important;
}
.display_no {
	display: none;
}
.div_play_aray {
	border-style: #77776F 1px solid;
	margin: 0;
	height: 100%;
	width: 100%;
	overflow: auto;
}
.file-group{
	height: 32px;
	overflow: hidden;
	position: relative;
	width: 290px;
}
div.file-group input[type="button"] {
	bottom: 0;
	float: right;
	position: absolute;
	right: 0;
	top: 0;
	width: 50px;
}
div.file-group input[type="file"] {
	bottom: 0;
	float: left;
	opacity: 0;
	position: absolute;
	left: 0;
	top: 0;
	width: 240px;
}
div.file-group span.uni-filename {
	border-right: 1px solid #567c91;
	color: #777;
	display: block;
	float: left;
	font-size: 12px;
	height: 22px;
	line-height: 22px;
	margin-bottom: 0;
	overflow: hidden;
	padding: 4px;
	text-align:center;
	text-overflow: ellipsis;
	white-space: nowrap;
	width: 164px;
	-moz-border-bottom-colors: none;
	-moz-border-left-colors: none;
	-moz-border-right-colors: none;
	-moz-border-top-colors: none;
	border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #b3b3b3;
	border-image: none;
	border-style: solid;
	border-width: 1px;
	box-shadow: 0 1px 0 rgba(255, 255, 255, 0.2) inset, 0 1px 2px
	rgba(0, 0, 0, 0.05);
}
div.file-group span.uni-action:hover{
	background-color:#31b0d5;
}
div.file-group span.uni-action {
	cursor: pointer;
	float: left;
	overflow: hidden;
	width: 60px;
	color: #fff;
	-moz-border-bottom-colors: none;
	-moz-border-left-colors: none;
	-moz-border-right-colors: none;
	-moz-border-top-colors: none;
	background-color: #5bc0de;
	background-image: linear-gradient(to bottom, #5bc0de, #46b8da);
	background-repeat: repeat-x;
	border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #b3b3b3;
	border-image: none;
	border-style: solid;
	border-width: 1px;
	box-shadow: 0 1px 0 rgba(255, 255, 255, 0.2) inset, 0 1px 2px
	rgba(0, 0, 0, 0.05);
	cursor: pointer;
	display: inline-block;
	font-size: 14px;
	line-height: 22px;
	margin-bottom: 0;
	padding: 4px;
	text-align: center;
	vertical-align: middle;
}
</style>
</head>
<body>
	<form action="{$post_links.print_img_upload}" enctype="multipart/form-data" method="post" name="theForm"   id="theForm">
		<input type="hidden" name="shipping_id" value="{$shipping_id}">
		<input type="hidden" name="config_lable" value=""> 
		<input type="hidden" name="print_model" value="2">
		<input type="hidden" name="shipping_name" value="{$shipping.shipping_name}">
		<!--菜单栏 start-->
		<table id="header" width="100%" cellpadding="0" cellspacing="0" border="0" height="50">
			<tr id="top-row">
				<td align="left">
					<div class="btn-group">
						<button class="btn dropdown-toggle" data-toggle="dropdown">	
							{lang key='shipping::shipping.lable_select_notice'}<span id="label_select" class="caret"></span>
						</button>
						<ul class="dropdown-menu">
							<li><a class="batch-del-btn add-lable" data-val="" data-text="" href="javascript:;"> <i class="fontello-icon-trash"></i>
								{lang key='shipping::shipping.lable_select_notice'}
							</a></li>
							<!-- {foreach from=$lang_lable_box key=Key item=lable_box} -->
							<li><a class="batch-del-btn add-lable" data-text="{$lable_box}"
								data-val="{$Key}" href="javascript:;"> <i
								class="fontello-icon-trash"></i> {$lable_box}
							</a></li>
							<!-- {/foreach} -->
						</ul>
					</div> 
					<button class="btn" type="button" name="del" id="del" onclick="javascript:pintObj.call_flash('lable_del', this);">{lang key='shipping::shipping.del_lable'}</button>
				</td>
				<td id="pic_control_upload" {if $shipping.print_bg !=''} class="display_no"{/if}>
					<div class="btn-group file-group" style="margin-top: 5px;">
						<input type="file" onchange='checkFileType(this.value);' class="btn_file" name="bg" id="bg" {if $shipping.print_bg !=''} disabled="disabled"{/if}>
						<span id="uni-filename" class="uni-filename" style="-moz-user-select: none;">{lang key='shipping::shipping.upload_shipping_bg'},{lang key='shipping::shipping.file_empty'}</span>
						<span class="uni-action" style="-moz-user-select: none;">{lang key='shipping::shipping.select_image'}</span>
						<input type="button" class="btn btn-primary" name="upload" id="upload" value="{lang key='shipping::shipping.upload'}" data-url="{$post_links.print_img_upload}"
						onclick="javascript:pintObj.bg_upload(this);" {if $shipping.print_bg !=''} disabled="disabled"{/if}> 
					</div> 
					<iframe id="bg_upload_hidden" name="bg_upload_hidden" frameborder="0" scrolling="no" class="display_no"></iframe>
				</td>
				<td id="pic_control_del" {if $shipping.print_bg== '' } class="display_no"{/if}>
					<input type="button" name="upload_del" class="btn" id="upload_del" value="{lang key='shipping::shipping.del_shipping_bg'}" data-url="{$post_links.print_img_del}"
					onclick="javascript:pintObj.bg_del(this);" {if $shipping.print_bg== ''} disabled="disabled"{/if}>
				</td>
				<td align="right" style="margin-right: 5px;">
					<button class="btn" type="button" data-url="{$post_links.do_edit}" onclick="javascript:pintObj.save(this);">{lang key='shipping::shipping.save_setting'}</button>&nbsp;&nbsp;
					<button class="btn" type="button" data-url="{$post_links.recovery}" onclick="javascript:pintObj.recovery_default(this);">{lang key='shipping::shipping.recovery_default'}</button>
				</td>
			</tr>
			<tr>
				<td colspan="3">&nbsp;</td>
			</tr>
		</table>
		<table width="100%" cellpadding="0" cellspacing="0" border="0" class="table_box">
			<tr>
				<td style="overflow: hidden;">
					<table width="100%" cellpadding="0" cellspacing="0" border="0"
					class="table_line">
					<tr style="display: none">
						<td colspan="3"></td>
					</tr>
				</table>
			</td>
		</tr>
		<!--编辑区 start-->
		<tr>
			<td id="xEditingArea" valign="top" height="620" width="100%"><div
				class="div_play_aray">
				<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000"
				codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0"
				width="1024" height="600" id="test">
				<param name="movie" value="{RC_App::apps_url('shipping/statics/print/pint.swf')}">
				<param name="quality" value="high">
				<param name="menu" value="false">
				<param name="wmode" value="transparent">
				<param name="FlashVars" value="bcastr_config_bg={$shipping.print_bg}&swf_config_lable={$shipping.config_lable}">
				<param name="allowScriptAccess" value="sameDomain" />
				<embed src="{RC_App::apps_url('shipping/statics/print/pint.swf')}" wmode="transparent"
				FlashVars="bcastr_config_bg={$shipping.print_bg}&swf_config_lable={$shipping.config_lable}"
				menu="false" quality="high" width="1024" height="600"
				type="application/x-shockwave-flash"
				pluginspage="http://www.macromedia.com/go/getflashplayer"
				allowScriptAccess="sameDomain" name="test" swLiveConnect="true" />
			</object>
		</div></td>
	</tr>
	<!--编辑区 end-->
</form>
</table>

</body>
</html>

<script type="text/javascript">
var Browser = new Object();

Browser.isMozilla = (typeof document.implementation != 'undefined') && (typeof document.implementation.createDocument != 'undefined') && (typeof HTMLDocument != 'undefined');
Browser.isIE = window.ActiveXObject ? true : false;
Browser.isFirefox = (navigator.userAgent.toLowerCase().indexOf("firefox") != - 1);
Browser.isSafari = (navigator.userAgent.toLowerCase().indexOf("safari") != - 1);
Browser.isOpera = (navigator.userAgent.toLowerCase().indexOf("opera") != - 1);

var display_yes = (Browser.isIE) ? 'block' : 'table-row-group';

window.onload = function() {
	//   callFromFlash();
}
$(document).ready(function(){
	$(document).on('click','.add-lable',function(){
		pintObj.call_flash('lable_add', this);
	});
});
/***文件上传验证***/
var html=document.getElementById('uni-filename').innerHTML; 
function resetFile(){ 
	document.getElementById('uni-filename').innerHTML=html; 
}
function checkFileType(str){
	var pos = str.lastIndexOf("."); 
	var lastname = str.substring(pos+1,str.length); 
	var resultName=lastname.toLowerCase(); 
	var allow_suffix = ['jpg', 'png', 'jpeg']; 
	if($.inArray(resultName.toString(), allow_suffix) < 0){
		alert('只能上传jpg,png,jpeg文件，您上传的文件类型为'+lastname+'，请重新上传'); 
		resetFile(); 
	}else{
		document.getElementById('uni-filename').innerHTML=str;
	}
}

var pintObj ={
	/** * 恢复默认 */
	recovery_default : function (btn_f){
		if (!confirm(recovery_default_suer)) {
				return false; //中止执行
			}
			this.submit(btn_f, false);
		}
		/*** 保存 */
		, save : function(btn_f){
			//获取表单对象
			var the_form = this.this_obj("theForm");
			if (typeof(the_form) == "undefined") {
				return false; //程序错误
			}
			the_form.config_lable.value = this.call_flash('lable_Location_info', ''); 
			this.submit(btn_f, false);
			return true;
		}	
		/*** 打印单背景图片删除 */
		, bg_del : function(btn_f){
			if (!confirm(upload_del_confirm)) {
				return false; //中止执行
			}
			this.submit(btn_f, this.bg_del_call_back);
			// 		  var params = 'shipping=' + the_form.shipping.value;
			// 		  Ajax.call('index.php?m=shipping&c=admin&a=init&is_ajax=1&act=print_del', params, this.bg_del_call_back, 'GET', 'JSON');		
		}
		, bg_del_call_back : function(){
			pintObj.call_flash('bg_delete', '');
		}
		/*** 打印单背景图片上传 */
		, bg_upload : function (btn_f){
			//获取表单对象
			var the_form = this.this_obj("theForm");
			if (typeof(the_form) == "undefined") {
				return false; //程序错误
			}
			//判断是否选取了上传文件
			if (the_form.bg.value == '') {
				alert(no_select_upload);
				return false;
			}
			the_form.target = '_parent';
			the_form.submit();
			  // this.submit(btn_f, false);
			}
			/** * 与模板Flash编辑器通信 */
			,call_flash : function(type, currt_obj){
			//获取flash对象
			var obj = this.this_obj("test");
			//执行操作
			switch (type) {
				case 'bg_delete': //删除打印单背景图片
				var result_del = obj.bg_delete();
					//执行成功 修改页面上传窗口为显示 生效
					if (result_del) {
						document.getElementById('pic_control_upload').style.display = display_yes;
						document.getElementById('pic_control_del').style.display = 'none';

						var the_form = this.this_obj("theForm");
						the_form.bg.disabled = "";
						the_form.bg.value = "";
						the_form.upload.disabled = "";
						the_form.upload_del.disabled = "disabled";
// 						$("#print_bg_default_info")[0].html('要删除的图片是默认图片，恢复模板可再次使用');
					}
					break;
			    case 'bg_add': //添加打印单背景图片
			    var result_add = obj.bg_add(currt_obj);
					//执行成功 修改页面上传窗口为隐藏 失效
					if (result_add) {
						document.getElementById('pic_control_upload').style.display = 'none';
						document.getElementById('pic_control_del').style.display = display_yes;

						var the_form = this.this_obj("theForm");
						the_form.bg.disabled = "disabled";
						the_form.upload.disabled = "disabled";
						the_form.upload_del.disabled = "";
// 						$("#print_bg_default_info")[0].disabled = "disabled";
					}
					break;
					case 'lable_add': 
					if (typeof(currt_obj) != 'object'){
						return false;
					}
					if ($(currt_obj).attr('data-val') == '') {
						alert(no_select_lable);
						return false;
					}
					var result = obj.lable_add('t_' + $(currt_obj).attr('data-val'), $(currt_obj).attr('data-text'), 150, 50, 20, 100, 'b_' + $(currt_obj).attr('data-val'));
					if (!result) {
						alert(no_add_repeat_lable);
						return false;
					}
					break;
					case 'lable_del': 
					var result_del = obj.lable_del();
					if (result_del) {
					}
					else {
						alert(no_select_lable_del);
					}
					break;
					case 'lable_Location_info':
					var result_info = obj.lable_Location_info();
					return result_info;
					break;
				}
				return true;
			}
			/*** 获取页面Flash编辑器对象*/
			, this_obj : function(flash_name){
				var _obj; 
				if (Browser.isIE) {
					_obj = window[flash_name];
				} else {
					_obj = document[flash_name];
				}
				if (typeof(_obj) == "undefined") {
					_obj = document[flash_name];
				}
				return _obj;
			},
			/* 提交数据到后台 */
			submit : function(btn_f,callback){
			//获取表单对象
			var the_form = this.this_obj("theForm");
			if (typeof(the_form) == "undefined") {
				return false; //程序错误
			}
			the_form.target = '_parent';
			var arr = jQuery(the_form).serializeArray(); 
			$.ajax({
				url: $(btn_f).attr('data-url'),
				dataType : "JSON",
				type : "POST",
				data : $.param(arr),
				success : function (data){
					if(callback) {
						callback();
					}
					alert(data.message);
					if(data.refresh_url!=undefined) {
						pintObj.pjax(data.refresh_url);
					}
				}
			});
			return true;
		},
		pjax :function(url){
			top.document.location.href = url;
		}
	};
</script>