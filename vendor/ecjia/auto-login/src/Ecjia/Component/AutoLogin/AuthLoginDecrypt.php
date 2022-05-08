<?php


namespace Ecjia\Component\AutoLogin;

use Illuminate\Encryption\Encrypter;

class AuthLoginDecrypt
{
    /**
     * @var Encrypter
     */
    protected $encrypter;

    /**
     * @var string
     */
    protected $authcode;

    /**
     * @var integer
     */
    protected $timeout;

    /**
     * AuthLoginDecrypt constructor.
     * @param $authcode
     * @param AuthEncrypterInterface|null $encrypter
     * @param int $timeout
     */
    public function __construct($authcode, AuthEncrypterInterface $encrypter = null, $timeout = 30)
    {
        $this->authcode = $authcode;
        $this->timeout = $timeout;

        if (is_null($encrypter)) {
            $this->encrypter = app('encrypter');
        }
        else {
            $this->encrypter = $encrypter->getEncrypter();
        }
    }

    /**
     * @return array
     * @throws AutoLoginException
     */
    public function decrypt()
    {
        $authcode_decrypt = $this->encrypter->decrypt($this->authcode);
        $params   = array();

        parse_str($authcode_decrypt, $params);

        $start_time = $params['time'];

        $gm_timestamp = mktime(gmdate("H, i, s, m, d, Y"));
        $time_gap = $gm_timestamp - $start_time;

        if (intval($time_gap) > $this->timeout) {
            throw new AutoLoginException('抱歉！请求超时。');
        }

        return $params;
    }

}