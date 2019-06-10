<?php


namespace Ecjia\System\Frameworks\Component\ShowMessage\Responses;


use RC_Response;

class AlterResponse extends ResponseAbstract
{

    /**
     * 响应
     */
    public function __invoke()
    {

        header("Content-type: text/html; charset=utf-8");
        $alert_msg = "alert('$msg');";
        if (empty($url)) {
            $gourl = 'history.go(-1);';
        } else {
            $gourl = ($parent ? 'parent' : 'window') . ".location.href = '{$url}'";
        }

        $script = "<script>" . PHP_EOL;
        $script .= $alert_msg . PHP_EOL;
        $script .= $gourl . PHP_EOL;
        $script .= "</script>" . PHP_EOL;

        $cookies = royalcms('response')->headers->getCookies();
        $response = RC_Response::make($script);
        foreach ($cookies as $cookie)
        {
            $response->withCookie($cookie);
        }

        royalcms()->instance('response', $response);

        return $response; //直接返回response对象，不再send
    }


}