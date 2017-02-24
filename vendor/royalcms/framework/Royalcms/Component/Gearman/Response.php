<?php

/**
 * @file
 *
 * 基于Grearman的响应类
 *
 * response
 *   #string  version   协议 默认'GEARMAN/1.0'
 *   #string  charset   编码 默认'UTF-8'
 *   #integer status    状态码     0为成功, 0-1000为系统状态, 1000+为应用级状态
 *   #string  message   状态描述
 *   #array   headers   头信息
 *   #mixed   data      数据主体
 *   #array   variables 应用配置
 *
 * 给Gearman的格式
 * array(
 *   response : (
 *     err_no  : integer
 *     err_msg : string
 *     results : (
 *       'data' : 数据主体
 *       'variables': 应用配置
 *     )
 *   )
 *   header : (
 *   )
 * )
 */

namespace Gearman\Component\Gearman;

/**
 * @usage
 *
 * $response = new Response($result);
 * $response->process();
 * echo $response;
 */
class Response {
    /**
     * 响应头信息
     */
    public $headers = array();

    /**
     * 数据主体
     */
    public $data;
    
    /**
     * 应用级配置等信息
     */
    public $variables = array();
    
    /**
     * 状态码
     */
    public $status;

    /**
     * 状态描述
     */
    public $message = '';

    /**
     * 协议
     */
    public $version = 'GEARMAN/1.0';

    /**
     * 编码
     */
    public $charset = 'UTF-8';

    /**
     * 常用状态描述数组
     */
    public static $messages = array(
        0   => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        204 => 'No Content',
        205 => 'Reset Content',
        301 => 'Moved Permanently',
        302 => 'Found',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        408 => 'Request Timeout',
        409 => 'Conflict',
        500 => 'Internal Server Error',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
    );


    /**
     * 析构函数
     *
     * @param mixed   $content
     * @param integer $status
     * @param array   $headers
     *
     * @api
     */
    public function __construct($data = null, $variables = array(), $headers = array(), $status = 0, $message = null) {
        $this->setData($data);
        $this->setVariables($variables);
        $this->setHeaders($headers);
        $this->setStatus($status, $message);              
    }

    /**
     * 设置状态码和状态描述
     *
     * @param integer $status
     *    状态码
     * @param string $message
     *    状态描述
     *
     * @api
     */
    public function setStatus($status, $message = null) {
        $this->status = (int) $status;
        if ($message === null) {
            $this->message = isset(self::$messages[$status]) ? self::$messages[$status] : '';
        }
        else {
            $this->message = (string) $message;
        }

        return $this;
    }

    /**
     * 获取状态码
     *
     * @api
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * 获取状态描述
     *
     * @api
     */
    public function getStatusText() {
        return $this->message;
    }

    /**
     * 设置响应正文
     *
     * @api
     */
    public function setData($data) {
        $this->data = $data;

        return $this;
    }

    /**
     * 获取响应正文
     *
     * @api
     */
    public function getData() {
        return $this->data;
    }

    /**
     * 设置头信息
     *
     * @api
     */
    public function setHeaders(array $headers) {
        $this->headers = $headers + $this->headers;

        return $this;
    }
    
    /**
     * 设置头信息
     *
     * @api
     */
    public function setHeader($key, $value) {
        if ($value === null) {
            unset($this->headers[$key]);
        } else {
            $this->headers[$key] = $value;
        }
        return $this;
    }
    
    /**
     * 设置variables信息
     *
     * @api
     */
    public function setVariables($variables = array()) {
        $this->variables = (array) $variables + $this->variables;

        return $this;
    }
    
    /**
     * 设置variable信息
     *
     * @api
     */
    public function setVariable($key, $value) {
        if ($value === null) {
            unset($this->variables[$key]);
        } else {
            $this->variables[$key] = $value;
        }
        return $this;
    }
    
    /**
     * 获取variables信息
     *
     * @api
     */
    public function getVariables() {
        return $this->variables;
    }
    
    /**
     * 获取某条variables信息
     *
     * @api
     */
    public function getVariable($key, $default = null) {
        return isset($this->variables[$key]) ? $this->variables[$key] : $default;
    }
    
    /**
     * 获取头信息
     *
     * @api
     */
    public function getHeaders() {
        return $this->headers;
    }
    
    /**
     * 获取头信息某个元素
     *
     * @api
     */
    public function getHeader($key, $default = null) {
        return isset($this->headers[$key]) ? $this->headers[$key] : $default;
    }

    /**
     * 拼装结果
     *
     * @api
     */
    public function process() {
        return array(
            'version'   => $this->version,
            'charset'   => $this->charset,
            'status'    => $this->status,
            'message'   => $this->message,
            'headers'   => $this->headers,
            'data'      => $this->data,
            'variables' => $this->variables,
        );
    }
    
    /**
     * 发送给Gearman的返回结果
     *
     * @api
     */
    public function send() {
        return serialize(array(
            'response' => array(
                'err_no'    => $this->status,
                'err_msg'   => $this->message,
                'results'   => $this->data,
                'variables' => $this->variables,
            ),
            'header' => array(
                
            ),            
        ));
    }

    /**
     * 魔术方法
     *
     * @api
     */
    public function __toString() {
        return var_export($this->process(), true);
    }

    //自身迭代
    public static function create($data = null, $variables = array(), $headers = array(), $status = 0, $message = null) {
        return new static($data, $variables, $headers, $status, $message);
    }

}
