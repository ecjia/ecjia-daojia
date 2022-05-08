<?php


namespace Ecjia\Component\ShowMessage\Responses;


use Ecjia\Component\ShowMessage\ShowMessage;

abstract class ResponseAbstract
{

    /**
     * @var ShowMessage
     */
    protected $showMessage;

    /**
     * HtmlResponse constructor.
     * @param ShowMessage $showMessage
     */
    public function __construct(ShowMessage $showMessage)
    {
        $this->showMessage = $showMessage;
    }


    /**
     * Return http Response.
     */
    abstract public function __invoke();

}