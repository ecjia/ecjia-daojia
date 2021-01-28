<?php


namespace Ecjia\System\Hookers;


class Handle403ErrorAction
{

    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle($exception)
    {
        /**
         * @var \Illuminate\Http\Request $request
         */
        $request = royalcms('request');
        $pathInfo = $request->getPathInfo();

        if (str_contains($pathInfo, '/content/uploads/')) {
            rc_die(sprintf("File %s not found!", $pathInfo));
        }

    }

}