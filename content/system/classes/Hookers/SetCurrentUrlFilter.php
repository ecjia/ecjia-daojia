<?php


namespace Ecjia\System\Hookers;


class SetCurrentUrlFilter
{

    /**
     * Handle the event.
     *
     * @return string
     */
    public function handle($current_url)
    {
        $request = request();

        $query = $this->getQueryString();

        $question = $request->getBaseUrl().$request->getPathInfo() === '/' ? '/?' : '?';

        return $query ? $request->url().$question.$query : $request->url();
    }

    private function getQueryString()
    {
        $request = request();

        $qs = $request->server->get('QUERY_STRING');

        return '' === $qs ? null : $qs;
    }

}