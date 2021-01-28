<?php

namespace Royalcms\Component\Shouqianba\PayVendor\Shouqianba;

use RC_Http;
use RC_Log;
use RC_Error;
use Royalcms\Component\Pay\Exceptions\GatewayException;

class Support
{

    /**
     * Shouqianba gateway.
     *
     * @var string
     */
    protected $baseUri = 'https://api.shouqianba.com';

    /**
     * Instance.
     *
     * @var Support
     */
    private static $instance;

    /**
     * Bootstrap.
     */
    private function __construct()
    {
    }

    /**
     * Get instance.
     *
     * @return Support
     */
    public static function getInstance()
    {
        if (!(self::$instance instanceof self)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Alipay gateway.
     *
     * @param string $mode
     *
     * @return string
     */
    public static function baseUri($mode = null)
    {
        switch ($mode) {
            case 'dev':
                self::getInstance()->baseUri = 'https://api.shouqianba.com';
                break;

            default:
                break;
        }

        return self::getInstance()->baseUri;
    }

    /**
     * 激活支付终端设备
     *
     * @param $url
     * @param $params
     * @param $vendorSn
     * @param $vendorKey
     */
    public static function activateTerminal($url, $params, $vendorSn, $vendorKey)
    {
        $sign = self::generateSign($params, $vendorKey);

        $json_params = json_encode($params);

        $result = self::requestApi($url, $json_params, $sign, $vendorSn);

        return $result;
    }

    /**
     * 发送支付请求
     *
     * @param $url
     * @param $params
     * @param $terminalSn
     * @param $terminalKey
     * @return Collection
     */
    public static function sendRequest($url, $params, $terminalSn, $terminalKey)
    {
        $sign = self::generateSign($params, $terminalKey);

        $json_params = json_encode($params);

        $result = self::requestApi($url, $json_params, $sign, $terminalSn);

        return $result;
    }

    public static function getClientSn($length = 19)
    {
        $str_sn = '';
        for ($i = 0; $i < $length; $i++) {
            if ($i == 0) {
                $str_sn .= rand(1, 9); // first field will not start with 0.
            }
            else {
                $str_sn .= rand(0, 9);
            }
        }

        return $str_sn;
    }

    /**
     * Generate sign.
     *
     * @param array  $params
     * @param string $privateKey
     *
     * @return string
     */
    public static function generateSign(array $params, $privateKey = null)
    {
        $json_params = json_encode($params);

        $md5 = md5($json_params . $privateKey);

        return $md5;
    }

    /**
     * Get Alipay API result.
     *
     * @param array  $data
     * @param string $publicKey
     *
     * @throws GatewayException
     *
     * @return Collection
     */
    public static function requestApi($endpoint, $body, $sign, $terminalSn)
    {
        $url = self::baseUri(config('shouqianba::pay.mode', 'normal')) . $endpoint;
        RC_Log::debug('Request To Shouqianba Api', [$url, $body]);

        if (is_array($body)) {
            $body = array_filter($body, function ($value) {
                return ($value == '' || is_null($value)) ? false : true;
            });
        }

        $header = array(
            'Format' => 'json',
            'Content-Type' => 'application/json',
            'Authorization' => $terminalSn . ' ' . $sign,
        );

        $postdata = [
            'headers' => $header,
            'timeout' => 30,
            'body' => $body
        ];

        $response = RC_Http::remote_post($url, $postdata);

        if (RC_Error::is_error($response)) {
            self::warningLog($url, $postdata, $response->get_error_message());
            throw new GatewayException(
                'Get Shouqianba API Request Error:'.$response->get_error_message(),
                $response,
                20000
            );
        }

        $body = json_decode($response['body'], true);

        if (array_get($body, 'result_code') != '200') {
            self::warningLog($url, $postdata, $body['error_message']);
            throw new GatewayException(
                $body['error_message'],
                $body,
                20001
            );
        }

        return $body['biz_response'];
    }

    /**
     * @param $url
     * @param $postfield
     * @param $response
     */
    public static function warningLog($url, $postfield, $response)
    {
        RC_Log::warning('Shouqianba used RC_Http Request FAILED', ['url' => $url, 'postfield' => $postfield, 'response' => $response]);
    }

}