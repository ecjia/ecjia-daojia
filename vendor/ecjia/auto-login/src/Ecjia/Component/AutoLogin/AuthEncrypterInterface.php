<?php


namespace Ecjia\Component\AutoLogin;


interface AuthEncrypterInterface
{

    /**
     * @return Encrypter
     */
    public function getEncrypter();

}