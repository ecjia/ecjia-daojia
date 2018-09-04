<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/8/24
 * Time: 2:48 PM
 */

namespace Royalcms\Component\HttpKernel;

use Royalcms\Component\Http\Request as RoyalcmsHttpRequest;

class Request extends RoyalcmsHttpRequest
{

    /**
     * Create an Royalcms request from a Symfony instance.
     *
     * @param  \Royalcms\Component\Http\Request  $request
     * @return \Royalcms\Component\HttpKernel\Request
     */
    public static function createMyFromBase(RoyalcmsHttpRequest $request)
    {
        if ($request instanceof static) {
            return $request;
        }

        $content = $request->content;

        $request = (new static)->duplicate(

            $request->query->all(), $request->request->all(), $request->attributes->all(),

            $request->cookies->all(), $request->files->all(), $request->server->all()
        );

        $request->content = $content;

        $request->request = $request->getInputSource();

        return $request;
    }

}