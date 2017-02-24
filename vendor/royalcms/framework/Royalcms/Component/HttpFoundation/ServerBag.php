<?php
defined('IN_ROYALCMS') or exit('No permission resources.');
/**
 * @file ServerBag
 */
class Component_HttpFoundation_ServerBag extends Component_HttpFoundation_ParameterBag
{
    
    /**
     * 常用数据 @var array
     */
    protected $info = array(
        'scheme' => 'cli',
        'host' => '127.0.0.1',
        'port' => 80,
        'basepath' => '',
        'pathinfo' => '/',
        'ip' => '127.0.0.1',
        'filename' => '',
        'baseurl' => ''
    );

    /**
     * 构造函数
     *
     * @param array $params            
     */
    public function __construct(array $params = array())
    {
        $this->params = $params;
        $this->prepareInfo($params);
    }

    /**
     * 获取常用数据
     * @api
     */
    public function getInfo($key = null, $default = '')
    {
        if ($key === null) {
            return $this->info;
        }
        $key = strtolower($key);
        return isset($this->info[$key]) ? $this->info[$key] : $default;
    }
    
    /**
     * 处理常用数据
     * @param unknown $params
     */
    protected function prepareInfo($params)
    {
        if (isset($params['SERVER_PROTOCOL'])) {
            $protocol = explode('/', $params['SERVER_PROTOCOL']);
            $this->info['scheme'] = strtolower(array_shift($protocol));
        }
        if (isset($params['HTTP_HOST'])) {
            $this->info['host'] = strtolower($params['HTTP_HOST']);
        }
        if (isset($params['SERVER_PORT'])) {
            $this->info['port'] = (int) $params['SERVER_PORT'];
        }
        if ($this->info['scheme'] == 'https') {
            $this->info['port'] = 443;
        }
        
        $requestUri = $this->getParameter('REQUEST_URI', '');
        $pos = strpos($requestUri, '?');
        if ($pos) {
            $requestUri = substr($requestUri, 0, $pos);
        }
        $baseUrl = $this->prepareBaseUrl($params, $requestUri);
        $fileName = $this->info['filename'];
        $this->info['baseurl'] = $baseUrl;
        if (basename($baseUrl) === $fileName) {
            $this->info['basepath'] = strtr(dirname($baseUrl), '\\', '/');
        } else {
            $this->info['basepath'] = $baseUrl;
        }
        $this->info['basepath'] = rtrim($this->info['basepath'], '/');
        if (strpos($requestUri, $this->info['baseurl']) === 0) {
            $pathinfo = substr($requestUri, strlen($this->info['baseurl']));
            if ($pathinfo) {
                $this->info['pathinfo'] = $pathinfo;
            } else {
                $this->info['pathinfo'] = '/';
            }
        } else {
            $this->info['pathinfo'] = $requestUri;
        }
        
        if (isset($params['REMOTE_ADDR'])) {
            $this->info['ip'] = $params['REMOTE_ADDR'];
        }
    }
    
    /**
     * 获取BaseUrl
     * @param unknown $params
     * @param string $requestUri
     * @return string
     */
    protected function prepareBaseUrl($params, $requestUri = '')
    {
        $baseUrl = '';
        if (isset($params['SCRIPT_FILENAME'])) {
            $filename = basename($params['SCRIPT_FILENAME']);
            $this->info['filename'] = $filename;
            if (basename($this->getParameter('SCRIPT_NAME')) === $filename) {
                $baseUrl = $this->getParameter('SCRIPT_NAME');
            } elseif (basename($this->getParameter('PHP_SELF')) === $filename) {
                $baseUrl = $this->getParameter('PHP_SELF');
            } elseif (basename($this->getParameter('ORIG_SCRIPT_NAME')) === $filename) {
                $baseUrl = $this->getParameter('ORIG_SCRIPT_NAME');
            } else {
                $path = $this->getParameter('PHP_SELF', '');
                $file = $this->getParameter('SCRIPT_FILENAME', '');
                $segs = explode('/', trim(strtr($file, '\\', '/'), '/'));
                $segs = array_reverse($segs);
                $index = 0;
                $last = count($segs);
                do {
                    $seg = $segs[$index];
                    $baseUrl = '/' . $seg . $baseUrl;
                    ++ $index;
                } while ($last > $index && strpos($path, $baseUrl));
            }
            // 取左基准最长公共字串
            $baseUrlDir = dirname($baseUrl);
            if ('\\' === DIRECTORY_SEPARATOR) {
                $baseUrlDir = strtr($baseUrlDir, '\\', '/');
            }
            if ($baseUrl && false !== $prefix = $this->getUrlencodedPrefix($requestUri, $baseUrl)) {
                $baseUrl = $prefix;
            } elseif ($baseUrl && false !== $prefix = $this->getUrlencodedPrefix($requestUri, $baseUrlDir)) {
                $baseUrl = $prefix;
            } elseif (strlen($requestUri) > strlen($baseUrl) && ($pos = strpos($requestUri, $baseUrl))) {
                $baseUrl = substr($requestUri, 0, $pos + strlen($baseUrl));
            } elseif (strpos($requestUri, basename($baseUrl)) === false) {
                $baseUrl = $baseUrlDir;
            }
        }
        
        return rtrim($baseUrl, '/');
    }
    
    /**
     * 左基准最长公共字串
     * @param string $string
     * @param string $prefix
     * @return boolean|unknown
     */
    private function getUrlencodedPrefix($string, $prefix)
    {
        if (0 !== strpos(rawurldecode($string), $prefix)) {
            return false;
        }
        $len = strlen($prefix);
        if (preg_match("#^(%[[:xdigit:]]{2}|.){{$len}}#", $string, $match)) {
            return $match[0];
        }
        return false;
    }
}
// end