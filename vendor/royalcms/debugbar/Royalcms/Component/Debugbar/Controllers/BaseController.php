<?php namespace Royalcms\Component\Debugbar\Controllers;

use Royalcms\Component\Foundation\Royalcms;

class BaseController extends \Royalcms\Component\Routing\Controller
{
    /**
     * The royalcms instance.
     *
     * @var \Royalcms\Component\Foundation\Royalcms
     */
    protected $royalcms;

    public function __construct(Royalcms $royalcms)
    {
        $this->royalcms = $royalcms;
    }
}