<?php

namespace Royalcms\Component\Pay\PayVendor\Wechat;

use Royalcms\Component\Pay\Exceptions\GatewayException;
use Royalcms\Component\Pay\Exceptions\InvalidArgumentException;
use Royalcms\Component\Pay\Exceptions\InvalidSignException;
use Royalcms\Component\Pay\Log;
use Royalcms\Component\Pay\Traits\HasHttpRequest;
use Royalcms\Component\Support\Collection;

class Support
{
    use HasHttpRequest;

    /**
     * Wechat gateway.
     *
     * @var string
     */
    protected $baseUri = 'https://api.mch.weixin.qq.com/';

    /**
     * Instance.
     *
     * @var Support
     */
    private static $instance;

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

    public function setBaseUri($baseUri)
    {
        $this->baseUri = $baseUri;
    }

    public function getBaseUri()
    {
        return $this->baseUri;
    }

    /**
     * Request wechat api.
     *
     * @param string      $endpoint
     * @param array       $data
     * @param string|null $key
     * @param array       $cert
     *
     * @throws GatewayException
     * @throws InvalidArgumentException
     * @throws InvalidSignException
     *
     * @return Collection
     */
    public static function requestApi($endpoint, $data, $key = null, $cert = [], $baseUri = null)
    {
        Log::debug('Request To Wechat Api', [self::baseUri().$endpoint, $data]);

        if (! is_null($baseUri)) {
            self::getInstance()->setBaseUri($baseUri);
        }

        $result = self::getInstance()->post(
            $endpoint,
            self::toXml($data),
            $cert
        );

        $result = is_array($result) ? $result : self::fromXml($result);

        if (!isset($result['return_code']) || $result['return_code'] != 'SUCCESS' || $result['result_code'] != 'SUCCESS') {
            throw new GatewayException(
                'Get Wechat API Error:'.$result['return_msg'].(isset($result['err_code_des']) ? '(' . $result['err_code_des'] . ')' : ''),
                $result,
                20000
            );
        }

        if (strpos($endpoint, 'mmpaymkttransfers') !== false || self::generateSign($result, $key) === $result['sign']) {
            return new Collection($result);
        }
        else if (strpos($endpoint, 'risk/getpublickey') !== false) {
            return new Collection($result);
        }

        Log::warning('Wechat Sign Verify FAILED', $result);

        throw new InvalidSignException('Wechat Sign Verify FAILED', $result);
    }

    /**
     * Filter payload.
     *
     * @param array                      $payload
     * @param array|string               $order
     * @param \Royalcms\Component\Pay\Support\Config; $config
     *
     * @throws InvalidArgumentException
     *
     * @return array
     */
    public static function filterPayload($payload, $order, $config, $preserveNotifyUrl = false)
    {
        $payload = array_merge($payload, is_array($order) ? $order : ['out_trade_no' => $order]);

        $type = isset($order['type']) ? $order['type'].($order['type'] == 'app' ? '' : '_').'id' : 'app_id';
        $payload['appid'] = $config->get($type, '');

        if ($config->get('mode', Wechat::MODE_NORMAL) === Wechat::MODE_SERVICE) {
            $payload['sub_appid'] = $config->get('sub_'.$type, '');
        }

        unset($payload['trade_type'], $payload['type']);

        if (!$preserveNotifyUrl) {
            unset($payload['notify_url']);
        }

        $payload['sign'] = self::generateSign($payload, $config->get('key'));

        return $payload;
    }

    /**
     * Generate wechat sign.
     *
     * @param array       $data
     * @param null|string $key
     *
     * @throws InvalidArgumentException
     *
     * @return string
     */
    public static function generateSign($data, $key = null)
    {
        if (is_null($key)) {
            throw new InvalidArgumentException('Missing Wechat Config -- [key]');
        }

        ksort($data);

        $string = md5(self::getSignContent($data).'&key='.$key);

        return strtoupper($string);
    }

    /**
     * Generate sign content.
     *
     * @param array $data
     *
     * @return string
     */
    public static function getSignContent($data)
    {
        $buff = '';

        foreach ($data as $k => $v) {
            $buff .= ($k != 'sign' && $v != '' && !is_array($v)) ? $k.'='.$v.'&' : '';
        }

        return trim($buff, '&');
    }

    /**
     * Decrypt refund contents.
     *
     * @param string $contents
     * @param string $key
     *
     * @return string
     */
    public static function decryptRefundContents($contents, $key)
    {
        return openssl_decrypt(base64_decode($contents), 'AES-256-ECB', md5($key), OPENSSL_RAW_DATA);
    }

    /**
     * Convert array to xml.
     *
     * @param array $data
     *
     * @throws InvalidArgumentException
     *
     * @return string
     */
    public static function toXml($data)
    {
        if (!is_array($data) || count($data) <= 0) {
            throw new InvalidArgumentException('Convert To Xml Error! Invalid Array!');
        }

        $xml = '<xml>';
        foreach ($data as $key => $val) {
            $xml .= is_numeric($val) ? '<'.$key.'>'.$val.'</'.$key.'>' :
                                       '<'.$key.'><![CDATA['.$val.']]></'.$key.'>';
        }
        $xml .= '</xml>';

        return $xml;
    }

    /**
     * Convert xml to array.
     *
     * @param string $xml
     *
     * @throws InvalidArgumentException
     *
     * @return array
     */
    public static function fromXml($xml)
    {
        if (!$xml) {
            throw new InvalidArgumentException('Convert To Array Error! Invalid Xml!');
        }

        libxml_disable_entity_loader(true);

        return json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA), JSON_UNESCAPED_UNICODE), true);
    }

    /**
     * Wechat gateway.
     *
     * @param string $mode
     *
     * @return string
     */
    public static function baseUri($mode = null)
    {
        switch ($mode) {
            case Wechat::MODE_DEV:
                self::getInstance()->setBaseUri('https://api.mch.weixin.qq.com/sandboxnew/');
                break;

            case Wechat::MODE_HK:
                self::getInstance()->setBaseUri('https://apihk.mch.weixin.qq.com/');
                break;

            default:
                break;
        }

        return self::getInstance()->getBaseUri();
    }
}
