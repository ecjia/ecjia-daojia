<?php
/*
Name: 支付提示模板
Description: 
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=0, minimal-ui">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="format-detection" content="telephone=no" />
<title>{$page_title}</title>
<!-- {block name="ready_meta"} --><!-- {/block} -->
<style type="text/css">
{literal}
/**
 * 全局 CSS
 * 
 * ecjia-nav
 * 扩展列表nav下划线
 * 依赖:ecjia-list、ecjia-list-three（+）
 */
html,
body {font-family: Helvetica, '宋体', Arial, sans-serif; background: #efeff4; color: #555;height:100%;}
body, ul, ol, li, p, h1, h2, h3, h4, h5, h6, form, fieldset, table, td, img, div, dl, dt, dd { margin: 0; padding: 0; border: 0; }
body { font-size: 18px; margin: 0 auto; max-width: 640px; }
a, a:link, a:active, a:hover, a:visited { text-decoration: none;color: #555; }
input[type=text], input[type=number], textarea { border-radius: 5px;  -webkit-appearance: none; padding: 0 0.5em; box-shadow:none; }
@media only screen and (max-width:310px) and (min-width:300px) {
    body { font-size: 10px }
}
@media only screen and (max-width:320px) and (min-width:310px) {
    body { font-size: 10px }
}
@media only screen and (max-width:360px) and (min-width:320px) {
    body { font-size: 12px }
}
@media only screen and (max-width:360px) and (min-width:350px) {
    body { font-size: 12px }
}
@media only screen and (max-width:480px) and (min-width:360px) {
    body { font-size: 14px }
}
@media only screen and (max-width:480px) and (min-width:470px) {
    body { font-size: 14px }
}
@media only screen and (max-width:560px) and (min-width:480px) {
    body { font-size: 16px }
}
@media only screen and (max-width:570px) and (min-width:560px) {
    body { font-size: 16px }
}
@media only screen and (max-width:640px) and (min-width:570px) {
    body { font-size: 18px }
}
@media only screen and (max-width:640px) and (min-width:630px) {
    body { font-size: 18px }
}
ul, li, dl, dt, dd, p, h1, h2, h3, h4, h5, form, img, div { margin: 0; padding: 0; list-style: none; border: 0 none; }
.con { overflow: hidden; }
.h4-list { font-size: 1.4em; padding: 0.6em; }
.star { width: 7em; height: auto; }
a, a:link, a:active, a:hover, a:visited { text-decoration: none; }
input[type=text], textarea{
	border: 1px solid #ccc;
}
h1, .h1, h2, .h2 { font-size: 1.4em; }
del { color: #bbb; }
.con { background: #efeff4; }
.ecjiaf-bt{border-top-color:#ddd;}
a[type=button] { color: #fff !important; }
a, a:link, a:active, a:hover, a:visited { text-decoration: none; }
input[type=text], textarea {
	border:1px solid #ccc;
	background: #fff;
}
html, body {
    background: #f7f7f7;
    color: #555;
	height: 100%;
}
.fl {float:left}
.fr {float:right}
.fl,.fr{display:block;}
.ecjia-color-green {
    color: #47AA4D;
}
.ecjia-fz-big {
    font-size: 1.2em;
}
.ecjiaf-tac {
    text-align: center;
}
.two-btn {
    overflow: hidden;
    padding: 0 1em;
    text-align: center;
}
.ecjia-margin-b {
    margin-bottom: 1em;
}
.ecjia-margin-t {
    margin-top: 1em;
}
.btn {
    display: inline-block;
    padding: 6px 12px;
    margin-bottom: 0;
    font-size: 14px;
    font-weight: normal;
    line-height: 1.42857143;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    -ms-touch-action: manipulation;
    touch-action: manipulation;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    background-image: none;
    border: 1px solid transparent;
    border-radius: 4px;
}
.btn, .btn:link, .btn:hover, .btn:active, .btn:visited {
    border-color: #47aa4d;
    background: #47aa4d;
    color: #fff;
}
.two-btn .btn, .two-btn .btn:link, .two-btn .btn:hover, .two-btn .btn:active, .two-btn .btn:visited {
    display: inline-block;
    font-size: 1.2em;
    line-height: 1.4em;
    width: 30%;
    margin: 0;
    margin: 0 1%;
    text-align: center;
}

.ecjia-header {
    background: #47aa4d;
    height: 3.5em;
    line-height: 3.5em;
    position: relative;
    text-align: center;
    top: 0;
    width: 100%;
    max-width: 640px;
    z-index: 2;
    overflow: hidden;
	color: #fff;
}
.ecjia-header .ecjia-header-title {
    position: absolute;
    top: 0;
    left: 4em;
    right: 4em;
    bottom: 0;
    font-size: 1.4em;
}

.ecjia-flow-done .flow-success {
	text-align:center;
    margin: 4em 0 2em;
}
.ecjia-flow-done .flow-success p {
    line-height: 4em;
    margin: 0 auto;
    position: relative;
}
.ecjia-flow-done .flow-success p::before {
    background: #50ad0b;
}
.ecjia-flow-done .flow-success p::before {
    content: '';
    position: absolute;
    left: 0;
    display: inline-block;
    width: 4em;
    height: 4em;
    border-radius: 100%;
}
.ecjia-flow-done .flow-success p::after {
    content: '';
    position: absolute;
    left: 1.3em;
    top: 0.5em;
    width: 1.5em;
    height: 2.5em;
    border-right: 2px solid #fff;
    border-bottom: 2px solid #fff;
    border-radius: 0 0 5px 0;
    transform: rotate(45deg);
}
.ecjia-flow-done ul {display:block;    overflow: hidden;}
.ecjia-flow-done ul li {clear:both;padding:0 3em;font-size:1em;line-height:2em;}
.ecjia-flow-done ul .fl{color:#999}
.ecjia-flow-done .two-btn {clear:both; border-top:1px solid #ddd; padding-top:1.5em;width:80%;margin:1em auto;}
.ecjia-flow-done .two-btn .btn {
    font-size: 1.1em;
    line-height: 1.3em;
}
.ecjia-flow-done .two-btn .btn {
    background: none;
    color: #47AA4D;
}
{/literal}
</style>
</head>
<body>
{nocache}
	<div class="ecjia">
	    <header class="ecjia-header">
        	<div class="ecjia-header-title">支付提示</div>
    	</header>
		<div class="ecjia-flow-done">
            <div class="flow-success">
                <p style="width:4em;height:4em;"></p>
                <!-- <div><img alt="" src="{$theme_url}images/pay_response.png"></div> -->
                <div class="ecjia-margin-t ecjiaf-tac ecjia-fz-big ecjia-color-green">{if $msg}{$msg}{else}支付成功！{/if}</div>
            </div>
            <ul>
                {if $info.pay_name}<li><div class="fl">支付方式：</div><div class="fr">{$info.pay_name}</div></li>{/if}
                {if $info.amount}<li><div class="fl">付款金额：</div><div class="fr">{$info.amount}</div></li>{/if}
            </ul>
            
            <div class="ecjia-margin-t ecjia-margin-b two-btn">
                {if $url.index}<a class="btn" href="{$url.index}">返回首页</a>{/if}
                {if $info.order_type != 'surplus'}
                    {if $url.order}<a class="btn btn-hollow" href="{$url.order}">查看订单</a>{/if}
                {/if}
            </div>
        </div>
	</div>
{/nocache}
</body>
</html>