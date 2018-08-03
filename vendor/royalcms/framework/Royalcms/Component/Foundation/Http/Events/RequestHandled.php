<?php

namespace Royalcms\Component\Foundation\Http\Events;

class RequestHandled
{
    /**
     * The request instance.
     *
     * @var \Royalcms\Component\Http\Request
     */
    public $request;

    /**
     * The response instance.
     *
     * @var \Royalcms\Component\Http\Response
     */
    public $response;

    /**
     * Create a new event instance.
     *
     * @param  \Royalcms\Component\Http\Request  $request
     * @param  \Royalcms\Component\Http\Response  $response
     * @return void
     */
    public function __construct($request, $response)
    {
        $this->request = $request;
        $this->response = $response;
    }
}
