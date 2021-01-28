<?php


namespace Ecjia\Component\ApiSignature;


class ApiSignature
{
    protected $timestamp;

    protected $api_secret;

    protected $sign;

    protected $nonce;

    protected $url;

    /**
     * 接口POST提交数据
     * @var array $post
     */
    protected $post = array();

    /**
     * ApiSignature constructor.
     * @param $api_secret
     * @param $url
     * @param int $timestamp
     * @param null $signature
     * @param null $nonce
     */
    public function __construct($api_secret, $url, $timestamp = SYS_TIME, $signature = null, $nonce = null)
    {
        $this->url = $url;
        $this->api_secret = $api_secret;
        $this->timestamp = $timestamp;
        $this->sign = $signature;
        $this->nonce = $nonce;
    }

    /**
     * @return int|mixed
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @param int|mixed $timestamp
     * @return ApiSignature
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * @return mixed|string
     */
    public function getSign()
    {
        return $this->sign;
    }

    /**
     * @param mixed|string $sign
     * @return ApiSignature
     */
    public function setSign($sign)
    {
        $this->sign = $sign;
        return $this;
    }

    /**
     * @return mixed|string
     */
    public function getNonce()
    {
        return $this->nonce;
    }

    /**
     * @param mixed|string $nonce
     * @return ApiSignature
     */
    public function setNonce($nonce)
    {
        $this->nonce = $nonce;
        return $this;
    }


    /**
     * 获取签名
     * @return boolean
     */
    public function ckeckSignature()
    {
        $params = array(
            'url'       => $this->url,
            'timestamp' => $this->timestamp,
            'nonce'     => $this->nonce
        );

        $sign = $this->makeSignature($params, $this->api_secret);
        if ((abs(SYS_TIME - $this->timestamp) > 120) || $sign !== $this->sign) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * 生成签名，$args为请求参数，$key为私钥
     * @return string
     */
    protected function makeSignature(array $params, $key)
    {
        ksort($params, SORT_STRING);

        $requestString = '';
        foreach ($params as $k => $v) {
            $requestString .= $k . $v;
        }

        $sign = HmacHash::hash($key, $requestString);
        return $sign;
    }

}