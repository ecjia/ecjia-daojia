<?php


namespace Ecjia\Component\ApiServer\Route;


use Ecjia\Component\ApiServer\Contracts\ApiParserInterface;

class ApiParseRoute
{
    /**
     * @var string
     */
    protected $api;

    /**
     * @var string
     */
    protected $router;

    /**
     * API解析类
     * @var ApiParserInterface
     */
    protected $parser;

    /**
     * API所在的APP
     * @var string
     */
    protected $appModule;

    protected $apiPath;

    /**
     * 解析Handler
     * @var array
     */
    protected $paserHandlers = [];

    /**
     * ApiParse constructor.
     * @param $api
     * @param $router
     */
    public function __construct($api, $router)
    {
        $this->api = $api;
        $this->router = $router;

        $this->parseRouter();
    }

    /**
     * @param string $paserHandler
     */
    public function addPaserHandler($paserHandler)
    {
        $this->paserHandlers[] = $paserHandler;
    }

    /**
     * 路由解析
     */
    protected function parseRouter()
    {
        $handler = explode('::', $this->router);

        $this->appModule = $handler[0];

        $this->apiPath = $handler[1];
    }

    /**
     * @return ecjia_error|mixed
     */
    public function getApihandler()
    {
        $handler = null;

        collect($this->paserHandlers)->each(function ($paserClass) use (& $handler) {
            if (class_exists($paserClass)) {
                $parser = new $paserClass($this->appModule, $this->apiPath);

                $handler = $parser->getApihandler();

                if (! is_ecjia_error($handler)) {
                    $this->parser = $parser;
                    return false;
                }
            }
        });

        return $handler;
    }

    /**
     * @return string
     */
    public function getApi()
    {
        return $this->api;
    }

    /**
     * 获取APP
     * @return string
     */
    public function getApp()
    {
        return $this->appModule;
    }

    /**
     * @return ApiParserInterface
     */
    public function getParser()
    {
        return $this->parser;
    }

}