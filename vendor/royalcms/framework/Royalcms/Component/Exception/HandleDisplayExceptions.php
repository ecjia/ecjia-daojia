<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/8/24
 * Time: 9:45 AM
 */

namespace Royalcms\Component\Exception;


class HandleDisplayExceptions
{

    /**
     * The plain exception displayer.
     *
     * @var \Royalcms\Component\Exception\ExceptionDisplayerInterface
     */
    protected $plainDisplayer;

    /**
     * The debug exception displayer.
     *
     * @var \Royalcms\Component\Exception\ExceptionDisplayerInterface
     */
    protected $debugDisplayer;

    /**
     * Indicates if the application is in debug mode.
     *
     * @var bool
     */
    protected $debug;

    /**
     * Create a new error handler instance.
     *
     * @param  \Royalcms\Component\Exception\ExceptionDisplayerInterface  $plainDisplayer
     * @param  \Royalcms\Component\Exception\ExceptionDisplayerInterface  $debugDisplayer
     * @return void
     */
    public function __construct(ExceptionDisplayerInterface $plainDisplayer,
                                ExceptionDisplayerInterface $debugDisplayer,
                                $debug = false)
    {
        $this->debug = $debug;
        $this->plainDisplayer = $plainDisplayer;
        $this->debugDisplayer = $debugDisplayer;
    }

    /**
     * Set the debug level for the handler.
     *
     * @param  bool  $debug
     * @return void
     */
    public function setDebug($debug)
    {
        $this->debug = $debug;
    }

    /**
     * Display the given exception to the user.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function displayException($exception)
    {
        $displayer = $this->debug ? $this->debugDisplayer : $this->plainDisplayer;

        return $displayer->display($exception);
    }





}