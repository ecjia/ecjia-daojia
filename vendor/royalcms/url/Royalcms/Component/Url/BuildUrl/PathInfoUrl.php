<?php


namespace Royalcms\Component\Url\BuildUrl;


use Royalcms\Component\Url\Url;

class PathInfoUrl
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

        $root_url = $this->buildRootUrl();
        $path = sprintf("%s/%s/%s", $module, $controller, $action);

        $url = Url::fromString($root_url)
            ->withPathinfo($path);

        $args = $this->buildUrl->getArgs();
        foreach ($args as $key => $value) {
            $url = $url->withQueryParameter($key, $value);
        }

        return $url;
    }

    protected function buildRootUrl()
    {
        $root_url = $this->buildUrl->buildRootUrl();

        if (config('system.url_rewrite')) {
            $root_url = $root_url . '/';
        } else {
            $root_url = $root_url . '/index.php/';
        }

        return $root_url;
    }


    public function __toString()
    {
        return (string) $this->url();
    }

}