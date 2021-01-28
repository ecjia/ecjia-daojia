<?php


namespace Ecjia\Component\AutoLogin;

use Illuminate\Encryption\Encrypter;

class AuthLoginEncrypt
{
    /**
     * @var Encrypter
     */
    protected $encrypter;

    /**
     * @var array
     */
    protected $params;

    /**
     * AuthLoginEncrypt constructor.
     * @param array $params
     * @param AuthEncrypterInterface|null $encrypter
     */
    public function __construct($params, AuthEncrypterInterface $encrypter = null)
    {
        $this->params = $params;

        if (is_null($encrypter)) {
            $this->encrypter = app('encrypter');
        }
        else {
            $this->encrypter = $encrypter->getEncrypter();
        }
    }


    public function encrypt()
    {
        $gm_timestamp = mktime(gmdate("H"), gmdate("i"), gmdate("s"), gmdate("m"), gmdate("d"), gmdate("Y")); // UTC time
        $this->params['time'] = $gm_timestamp;

        $authcode_str = http_build_query($this->params);
        $authcode = $this->encrypter->encrypt($authcode_str);

        return $authcode;
    }


}