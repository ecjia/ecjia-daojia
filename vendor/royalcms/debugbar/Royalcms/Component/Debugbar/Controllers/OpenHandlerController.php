<?php namespace Royalcms\Component\Debugbar\Controllers;

use DebugBar\OpenHandler;
use Royalcms\Component\Http\Response;

class OpenHandlerController extends BaseController
{
    public function handle()
    {
        $debugbar = $this->royalcms['debugbar'];

        if (!$debugbar->isEnabled()) {
            $this->royalcms->abort('500', 'Debugbar is not enabled');
        }

        $openHandler = new OpenHandler($debugbar);

        $data = $openHandler->handle(null, false, false);

        return new Response(
            $data, 200, array(
                'Content-Type' => 'application/json'
            )
        );
    }
}
