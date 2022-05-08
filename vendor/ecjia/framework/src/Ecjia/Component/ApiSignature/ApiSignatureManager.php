<?php


namespace Ecjia\Component\ApiSignature;


class ApiSignatureManager
{
    /**
     * API版本
     * @var float
     */
    protected $api_version;

    /**
     * API签名兼容模式
     * @var bool
     */
    protected $api_sign_compatible;

    protected $api_secret;

    public function __construct($api_version = null)
    {
        if (is_null($api_version)) {
            $this->api_version = 2.0;
        }

        $this->api_sign_compatible = config('system.api_sign_compatible');
        $this->api_secret = config('system.api_secret', '');
    }

    public function checkSignature($url)
    {
        if (! $this->api_sign_compatible && !version_compare($this->api_version, '1.7', '>')) {
            //检测API签名是否通过
            $api_signature = new ApiSignature($this->api_secret, $url);
            if ($api_secret && ! $api_signature->ckeckSignature()) {
                return new ecjia_error('signature_invalid', 'API signature verification invalid.');
            }
        }

        return true;
    }

}