<?php


namespace Royalcms\Component\Url\BuildUrl;


use Royalcms\Component\Url\Url;

class QueryStringUrl
{
    protected $buildUrl;

    public function __construct(BuildUrl $buildUrl)
    {
        $this->buildUrl = $buildUrl;

    }


    /**
     * @return string
     */
    public function url()
    {

        list($module, $controller, $action) = explode('/', $this->buildUrl->getRoute());

        $key_module = config('route.module');
        $key_controller = config('route.controller');
        $key_action = config('route.action');

        $root_url = $this->buildRootUrl();

        $url = Url::fromString($root_url)
            ->withQueryParameter($key_module, $module)
            ->withQueryParameter($key_controller, $controller)
            ->withQueryParameter($key_action, $action);

        $args = $this->buildUrl->getArgs();
        foreach ($args as $key => $value) {
            $url = $url->withQueryParameter($key, $value);
        }

        return $url;
    }

    protected function buildRootUrl()
    {
        $root_url = $this->buildUrl->buildRootUrl();

        $root_url = $root_url . '/index.php' . '?';

        return $root_url;
    }

    public function __toString()
    {
        return (string) $this->url();
    }

}