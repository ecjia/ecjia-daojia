<?php


namespace Royalcms\Component\Url\BuildUrl;



use RC_Uri;

class BuildUrl
{

    /**
     * 路由地址, 访问url
     * @var string
     */
    protected $route;

    /**
     * GET参数
     * @var array|string
     */
    protected $args;

    /**
     * QueryStringUrl constructor.
     * @param string $route m/c/a
     * @param array $args
     *  <code>
     *  $args = "nid=2&cid=1"
     *  $args = array("nid" => 2, "cid" => 1)
     *  </code>
     */
    public function __construct($route, $args = [])
    {
        $this->setRoute($route);
        $this->setArgs($args);
    }

    /**
     * @return string
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * @param string $route
     * @return BuildUrl
     */
    public function setRoute($route)
    {
        if (strpos($route, '@') === 0) {
            $route = str_replace('@', config('system.admin_entrance') . '/', $route);
        } elseif (strpos($route, '#') === 0) {
            $route = str_replace('#', ROUTE_M . '/', $route);
        }

        $routes = explode('/', $route);
        $count = count($routes);

        if ($count < 3) {
            $router = royalcms('default-router');
            $route_c = $router->matchDefaultRoute(config('route.controller'));
            $route_a = $router->matchDefaultRoute(config('route.action'));

            if ($count === 2) {
                $route .= '/' . $route_a;
            } elseif ($count === 1) {
                $route .= '/' . $route_c;
                $route .= '/' . $route_a;
            }
        }
        
        $this->route = trim($route);
        return $this;
    }

    /**
     * @return array|string
     */
    public function getArgs()
    {
        return $this->args;
    }

    /**
     * @param array|string $args
     * @return BuildUrl
     */
    public function setArgs($args)
    {
        /* 参数$args为字符串时转数组 */
        if (is_string($args)) {
            $args = urldecode($args);
            parse_str($args, $args);
        }

        $this->args = $args;
        return $this;
    }


    public function __toString()
    {
        /* normal pathinfo */
        $url_mode = config('system.url_mode');

        if ($url_mode == 'pathinfo') {
            $url = (new PathInfoUrl($this))->url();
        }
        else if ($url_mode == 'normal') {
            $url = (new QueryStringUrl($this))->url();
        }

        return (string) $url;
    }

    public function buildRootUrl()
    {
        $site_url = RC_Uri::site_url();

        return $site_url;
    }

}