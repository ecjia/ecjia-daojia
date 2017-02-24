<?php
defined('IN_ROYALCMS') or exit('No permission resources.');
/**
 * @file Request
 */
class Component_HttpFoundation_Request
{
    
    // POST
    public $post;
    
    // GET
    public $get;
    
    // SERVER
    public $server;
    
    // FILES
    public $files;
    
    // COOKIE
    public $cookies;
    
    // params
    public $params;
    
    // route
    public $route;
    
    // CONTENT
    protected $content;
    
    // SESSION
    protected $session;

    /**
     * 初始化属性
     */
    public function __construct($get = array(), $post = array(), $params = array(), $cookies = array(), $files = array(), $server = array(), $content = null)
    {
        $this->get = new Component_HttpFoundation_ParameterBag($get);
        $this->post = new Component_HttpFoundation_ParameterBag($post);
        $this->cookies = new Component_HttpFoundation_ParameterBag($cookies);
        $this->params = new Component_HttpFoundation_ParameterBag($params);
        $this->server = new Component_HttpFoundation_ServerBag($server);
        $this->files = new Component_HttpFoundation_ParameterBag($files);
        $this->content = $content;
    }

    /**
     * 获取内容
     *
     * @return resource string
     */
    public function getContent($asResource = false)
    {
        if (false === $this->content || (true === $asResource && null !== $this->content)) {
            throw new LogicException('getContent() can only be called once when using the resource return type.');
        }
        if (true === $asResource) {
            $this->content = false;
            return fopen('php://input', 'rb');
        }
        if (null === $this->content) {
            $this->content = file_get_contents('php://input');
        }
        
        return $this->content;
    }
    
    /**
     * 从globals创建request
     */
    public static function createFromGlobals()
    {
        return new self($_GET, $_POST, array(), $_COOKIE, $_FILES, $_SERVER);
    }
    
    /**
     * 获取一个元素 优先顺序为: params get post
     */
    public function get($key, $default = null)
    {
        return $this->params->getParameter($key, $this->get->getParameter($key, $this->post->getParameter($key)));
    }
    
    /**
     * 获取执行的脚本文件
     */
    public function getScriptName()
    {
        return $this->server->getParameter('SCRIPT_NAME', $this->server->getParameter('ORIG_SCRIPT_NAME', ''));
    }
    
    /**
     * 获取客户端IP
     */
    public function getIp()
    {
        return $this->server->getInfo('ip');
    }
    
    /**
     * 获取PathInfo 总是以/开头
     */
    public function getPathInfo()
    {
        return $this->server->getInfo('pathinfo');
    }
    
    /**
     * 获取BasePath
     */
    public function getBasePath()
    {
        return $this->server->getInfo('basepath');
    }
    
    /**
     * 获取BaseUrl
     */
    public function getBaseUrl()
    {
        return $this->server->getInfo('baseurl');
    }
    
    /**
     * 获取Scheme
     */
    public function getScheme()
    {
        return $this->server->getInfo('scheme');
    }
    
    /**
     * 获取Host
     */
    public function getHttpHost()
    {
        return $this->server->getInfo('host');
    }
    
    /**
     * 获取Port
     */
    public function getPort()
    {
        return $this->server->getInfo('port');
    }
    
    /**
     * 获取Scheme和HttpHost
     */
    public function getSchemeAndHttpHost()
    {
        return $this->getScheme() . '://' . $this->getHttpHost();
    }
    
    /**
     * 获取path
     */
    public function getUriForPath($path = '')
    {
        return $this->getSchemeAndHttpHost() . $this->getBaseUrl() . $path;
    }
    
    /**
     * 获取uri
     */
    public function getUri()
    {
        if (null !== $qs = $this->getQueryString()) {
            $qs = '?' . $qs;
        }
        return $this->getSchemeAndHttpHost() . $this->getBaseUrl() . $this->getPathInfo() . $qs;
    }
    
    /**
     * 获取QueryString
     */
    public function getQueryString()
    {
        $qs = self::normalizeQueryString($this->server->getParameter('QUERY_STRING'));
        return '' === $qs ? null : $qs;
    }
    
    /**
     * 格式QueryString
     */
    public static function normalizeQueryString($qs)
    {
        if ('' == $qs) {
            return '';
        }
        $parts = array();
        $order = array();
        foreach (explode('&', $qs) as $param) {
            if ('' === $param || '=' === $param[0]) {
                continue;
            }
            $keyValuePair = explode('=', $param, 2);
            $parts[] = isset($keyValuePair[1]) ? rawurlencode(urldecode($keyValuePair[0])) . '=' . rawurlencode(urldecode($keyValuePair[1])) : rawurlencode(urldecode($keyValuePair[0]));
            $order[] = urldecode($keyValuePair[0]);
        }
        array_multisort($order, SORT_ASC, $parts);
        return implode('&', $parts);
    }
}
