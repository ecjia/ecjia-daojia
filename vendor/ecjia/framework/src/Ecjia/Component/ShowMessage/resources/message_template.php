<?php
/**
 * @var string $url
 * @var string $site_url
 * @var string $msg
 */
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>ECJIA - <?php echo __('操作提示', 'ecjia'); ?></title>
    <style type="text/css">
        * {
            margin: 0;
            padding: 0;
        }
        html {
            background: none repeat scroll 0 0 #f1f1f1;
        }
        body {
            background: none repeat scroll 0 0 #fff;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.13);
            color: #444;
            font-family: "Open Sans",sans-serif;
            margin: 2em auto;
            max-width: 700px;
            padding: 1em 2em;
        }
        #error-page {
            margin-top: 50px;
        }
        #error-page .error-message {
            font-size: 14px;
            line-height: 1.5;
            margin: 25px 0 20px;
        }
        #error-page h2{
            color: #666;
        }
        #error-page a,
        #error-page a:after {
            color: #08c;
            margin-right: 10px;
            text-decoration: none;
        }
        #error-page a:hover{
            text-decoration: underline;
        }
    </style>
</head>
<body id="error-page">
<div class="error-message">
    <h2><?php echo __('操作提示', 'ecjia'); ?></h2>
    <div>
        <p><?php echo $msg;?></p>
        <a href="javascript:<?php echo $url; ?>"><?php echo __('返回', 'ecjia'); ?></a>
        <a href="<?php echo $site_url; ?>"><?php echo __('返回首页', 'ecjia'); ?></a>
    </div>
</div>
</body>
</html>
