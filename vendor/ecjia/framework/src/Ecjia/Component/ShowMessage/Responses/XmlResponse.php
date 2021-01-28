<?php


namespace Ecjia\Component\ShowMessage\Responses;


use RC_Response;

class XmlResponse extends ResponseAbstract
{

    /**
     * 响应
     */
    public function __invoke()
    {
        $data = $this->showMessage->getOption()->toArray();

        $cookies = royalcms('response')->headers->getCookies();
        $response = RC_Response::json($data);
        foreach ($cookies as $cookie)
        {
            $response->withCookie($cookie);
        }

        royalcms()->instance('response', $response);

        return $response; //直接返回response对象，不再send
    }


}