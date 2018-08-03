<?php

namespace Royalcms\Component\Error;

class ErrorDisplay
{

    /**
     * 404错误
     *
     * @param string $code
     *            http状态码
     * @param string $msg
     *            提示信息
     * @param string $url
     *            跳转url
     */
    public static function http_error($code, $msg = '')
    {
        _http_status($code);
        
        if ($code == '404') {
            echo self::error_display('404', 'Not Found', 'You can see this page because the URL you are accessing cannot be
			found.');
        } elseif ($code == '500') {
            echo self::error_display('500', 'Internal Server Error', 'Something has gone horribly wrong.');
        } else {
            echo self::error_display($code, '', $msg);
        }
        exit(0);
    }
    
    /**
     * @since 3.6
     * @param unknown $code
     * @param unknown $msg
     * @param unknown $desc
     * @return string
     */
    public static function error_display($code, $msg, $desc) {
        return  <<<ERR
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>{$code} - {$msg}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    </head>
    <style media="screen">
        body{background-color:#38a7dc;color:#fff;font:100% "Lato",sans-serif;font-size:1.8rem;font-weight:300}a{color:#75c6d9;text-decoration:none}.center{text-align:center}.header{font-size:13rem;font-weight:700;margin:13% 0 0 0;text-shadow:0 3px 0 #7f8c8d}.error{margin:-1rem 0 -0.5rem 0;font-size:6rem;text-shadow:0 3px 0 #7f8c8d;font-weight:100}@media(max-width:800px){html{font-size:60%}}@media(max-width:580px){html{font-size:40%}.header{margin-top:45%}}
    </style>
    <body>
        <section class="center">
            <article>
                <h1 class="header">{$code}</h1>
                <p class="error">{$msg}</p>
            </article>
            <article>
                <p>{$desc}</p>
            </article>
        </section>
    </body>
</html>    
ERR;
    }
    
    /**
     * @deprecated 3.6
     * @param unknown $msg
     */
    public static function halt($msg) {
        rc_die($msg);
    }

}


// end