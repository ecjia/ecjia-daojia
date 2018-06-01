<?php

namespace Royalcms\Component\Scheduler;

use \Exception;

/**
 * CURL工具
 */
Class Curl 
{
    public   $debug = false; //调试模式
    public   $multiOn = false;  //多线程模式(使用yiled时必须开启)
    private  $_mh;
    private  $_ch;
    private  $_header;
    private  $_body;
    private  $_cookie  = array();
    private  $_options = array();
    private  $_url     = array();
    private  $_referer = array();
    private  $_optArray = array();

    public function __construct(array $config= [])
    {
        $this->setOption($config);
    }

    /**
     *  便捷请求方法
     */
    public static function request(...$param)
    {
        $object = new self();
        $object->multiOn = true;
        return $object->callWebServer(...$param);
    }

    /**
     * 调用外部url
     *
     * @param string $queryUrl
     * @param array $param 参数            
     * @param string $method            
     * @return bool|mixed
     */
    public function callWebServer($queryUrl, $param = '', $method = 'get', $is_json = false, $is_urlcode = true) 
    {
        if (empty($queryUrl)) {
            return false;
        }
        $method = strtolower($method);
        $ret    = '';
        $param  = empty($param) ? array() : $param;
        $this->_init();
        if ($method == 'get') {
            $ret = $this->_httpGet($queryUrl, $param);
        } elseif ($method == 'post') {
            $ret = $this->_httpPost($queryUrl, $param, $is_urlcode);
        }
        if ($this->multiOn) {
            return $ret;
        }
        if (!empty($ret)) {
            if ($is_json) {
                return json_decode($ret, true);
            } else {
                return $ret;
            }
        }
        return true;
    }

    public function setConfig($_optArray = array())
    {
        $this->_optArray = $_optArray;
    }

    private function setOption($optArray = array()) 
    {
        
        foreach ($optArray as $key => $value) {          
            curl_setopt($this->_ch, $key, $value);
        }
    }

    private function _init() 
    {

        $this->_ch = curl_init();
        if (!empty($this->_optArray)) {
            $this->setOption($this->_optArray);
        }
        curl_setopt($this->_ch, CURLOPT_HEADER, true);
        curl_setopt($this->_ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($this->_ch, CURLOPT_FRESH_CONNECT, true);
        if ($this->multiOn) {
            //多线程
            $this->_mh = curl_multi_init();
            curl_multi_add_handle($this->_mh, $this->_ch);
        }
    }

    private function _close() 
    {
        if (is_resource($this->_ch)) {
            curl_close($this->_ch);
        }

        return true;
    }

    private function _httpGet($url, $query = array()) 
    {
        if (!empty($query)) {
            $url .= (strpos($url, '?') === false) ? '?' : '&';
            $url .= is_array($query) ? http_build_query($query) : $query;
        }
        curl_setopt($this->_ch, CURLOPT_URL, $url);
        curl_setopt($this->_ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->_ch, CURLOPT_HEADER, 0);
        curl_setopt($this->_ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($this->_ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($this->_ch, CURLOPT_SSLVERSION, 1);

        if ($this->multiOn) {
            $ret = $this->_executeMulti();
        } else {
            $ret = $this->_execute();
        }
        $this->_close();
        return $ret;
    }

    private function _httpPost($url, $query = array(), $is_urlcode = true) 
    {
        if (is_array($query)) {
            foreach ($query as $key => $val) {
                if ($is_urlcode) {
                    $encode_key = urlencode($key);
                } else {
                    $encode_key = $key;
                }
                if ($encode_key != $key) {
                    unset($query[$key]);
                }
                if ($is_urlcode && is_string($val)) {
                    $query[$encode_key] = urlencode($val);
                } else {
                    $query[$encode_key] = $val;
                }
            }
        }
        
        curl_setopt($this->_ch, CURLOPT_URL, $url);
        curl_setopt($this->_ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->_ch, CURLOPT_HEADER, 0);
        curl_setopt($this->_ch, CURLOPT_POST, true);
        curl_setopt($this->_ch, CURLOPT_POSTFIELDS, $query);
        curl_setopt($this->_ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($this->_ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($this->_ch, CURLOPT_SSLVERSION, 1);
        if ($this->multiOn) {
            $ret = $this->_executeMulti();
        } else {
            $ret = $this->_execute();
        }
        
        $this->_close();
        return $ret;
    }

    private function _put($url, $query = array()) 
    {
        curl_setopt($this->_ch, CURLOPT_CUSTOMREQUEST, 'PUT');

        return $this->_httpPost($url, $query);
    }

    private function _delete($url, $query = array()) 
    {
        curl_setopt($this->_ch, CURLOPT_CUSTOMREQUEST, 'DELETE');

        return $this->_httpPost($url, $query);
    }

    private function _head($url, $query = array()) 
    {
        curl_setopt($this->_ch, CURLOPT_CUSTOMREQUEST, 'HEAD');

        return $this->_httpPost($url, $query);
    }

    private function _execute() 
    {
        $response = curl_exec($this->_ch);
        $errno    = curl_errno($this->_ch);
        if ($errno > 0 && $this->$debug) {
            throw new Exception(curl_error($this->_ch), $errno);
        }

        return $response;
    }

    private function _executeMulti()
    {
        do {
            $mrc = curl_multi_exec($this->_mh, $active);
            yield null;  //先去请求，不用等待结果
        } while ($active > 0); //active=0代表请求完成
        $response = curl_multi_getcontent($this->_ch);
        yield CustomCall::returnReust($response);
        return false;
    }

    public function __destruct()
    {
        if ($this->multiOn) {
            curl_multi_remove_handle($this->_mh, $this->_ch);
            curl_multi_close($this->_mh);
        }
    }
}
