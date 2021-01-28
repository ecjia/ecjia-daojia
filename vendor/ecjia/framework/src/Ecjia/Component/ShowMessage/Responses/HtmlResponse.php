<?php


namespace Ecjia\Component\ShowMessage\Responses;


use RC_Response;
use RC_File;

class HtmlResponse extends ResponseAbstract
{

    /**
     * 响应
     */
    public function __invoke()
    {
        $option = $this->showMessage->getOption()->toArray();
        $url = $option['url'];
        $msg = $this->showMessage->getContent();

        $content = RC_File::getRequire($option['template_file']);

        $cookies = royalcms('response')->headers->getCookies();
        $response = RC_Response::make($content);
        foreach ($cookies as $cookie)
        {
            $response->withCookie($cookie);
        }

        royalcms()->instance('response', $response);

        return $response; //直接返回response对象，不再send
    }


}