<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta  name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=0, minimal-ui">
    <title>{$page_title}</title>
    <style>
        {literal}
        body{margin:0; padding:0; font-family: "微软雅黑"; margin: 0 auto; max-width: 640px;}
        .pic .icon{width: 24%; padding-top: 50%; padding-left: 40%;}
		.pic p{font-size: 1.2em; text-align: left; margin: 0 5%; padding-top: 5%; padding-bottom: 5%; line-height: 1.6em; text-indent: 2em;}
        .btns {background-color: #148ac3; height: auto; padding: 10px 0 35px 0;}
        .btns a {width: 100%;}
        .btns img{height: auto; width: 80%; margin: auto 10%; display: block; border: 0 none; margin-top: 35px;}
        .close {display:block; cursor:pointer; position:absolute; top:0; right:0; width:1.2em; height:1.2em; padding: 0 0 0.2em 0.2em; 
        	text-align:center; border-bottom-left-radius:1em; font-size:1.2em; color:#fff; background:#148ac3; text-decoration: none;}
        {/literal}
    </style>
</head>
<body>
    <div class="pic" style="background: url('{$front_url}/image/download_bj.png') 45% 0 no-repeat; min-height: 400px; background-size: 150%;">
        <div class="icon">
        	<img width="100%" src="{$shop_app_icon}" />
        </div>
        <div><p>{$shop_app_description}</p></div>
        <a class="close" href="{$shop_url}">x</a>
    </div>
    {if $shop_android_download neq '' || $shop_iphone_download neq '' || $shop_ipad_download neq ''}
    <div class="btns">
        {if $shop_android_download neq ''}<a class="android downloadBtns" href="{$shop_android_download}"><img src="{$front_url}/image/android.png"/></a>{/if}
        {if $shop_iphone_download neq ''}<a class="iphone downloadBtns" href="{$shop_iphone_download}"><img src="{$front_url}/image/iphone.png"/></a>{/if}
        {if $shop_ipad_download neq ''}<a class="ipad downloadBtns" href="{$shop_ipad_download}"><img src="{$front_url}/image/ipad.png"/></a>{/if}
    </div>
    {/if}
</body>
