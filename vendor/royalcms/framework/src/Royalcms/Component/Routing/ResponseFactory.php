<?php

namespace Royalcms\Component\Routing;

use JsonSerializable;
use Royalcms\Component\Support\Str;
use Royalcms\Component\Http\Response;
use Royalcms\Component\Http\JsonResponse;
use Illuminate\Support\Traits\Macroable;
use Royalcms\Component\Contracts\Support\Arrayable;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Royalcms\Component\Contracts\Routing\ResponseFactory as FactoryContract;

class ResponseFactory extends \Illuminate\Routing\ResponseFactory implements FactoryContract
{

    /**
     * Handle dynamic calls into Response macros.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     *
     * @throws \BadMethodCallException
     */
    public function __call($method, $parameters)
    {
        try {
            return parent::__call($method, $parameters);
        } catch (\BadMethodCallException $e) {
            return call_user_func_array([royalcms('response'), $method], $parameters);
        }
    }

    /**
     * Dynamically handle calls to the class.
     *
     * @param  string  $method
     * @param  array   $parameters
     * @return mixed
     *
     * @throws \BadMethodCallException
     */
    public static function __callStatic($method, $parameters)
    {
        try {
            return parent::__callStatic($method, $parameters);
        } catch (\BadMethodCallException $e) {
            return call_user_func_array([royalcms('response'), $method], $parameters);
        }
    }

}
