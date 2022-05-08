<?php


namespace Ecjia\Component\AutoLogin;


use Illuminate\Encryption\Encrypter;

class AuthEncrypter implements AuthEncrypterInterface
{
    /**
     * @var string
     */
    protected $auth_key;

    /**
     * @var string
     */
    protected $cipher;

    /**
     * AuthEncrypter constructor.
     * @param string|null $authkey
     * @param string|null $cipher
     */
    public function __construct(?string $auth_key = null, ?string $cipher = null)
    {
        $this->auth_key = $auth_key ?: config('app.auth_key');
        $this->cipher  = $cipher ?: config('app.cipher');
    }

    /**
     * @return string
     */
    public function getAuthKey(): string
    {
        return $this->auth_key;
    }

    /**
     * @param string $auth_key
     */
    public function setAuthKey(string $auth_key): void
    {
        $this->auth_key = $auth_key;
    }

    /**
     * @return string
     */
    public function getCipher(): string
    {
        return $this->cipher;
    }

    /**
     * @param string $cipher
     * @return AuthEncrypter
     */
    public function setCipher(string $cipher): AuthEncrypter
    {
        $this->cipher = $cipher;
        return $this;
    }

    /**
     * @return Encrypter
     */
    public function getEncrypter()
    {
        return new Encrypter($this->auth_key, $this->cipher);
    }

}