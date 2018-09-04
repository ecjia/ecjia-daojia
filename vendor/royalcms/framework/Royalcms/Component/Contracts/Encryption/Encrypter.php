<?php

namespace Royalcms\Component\Contracts\Encryption;

interface Encrypter
{
    /**
     * Encrypt the given value.
     *
     * @param  string  $value
     * @return string
     */
    public function encrypt($value);

    /**
     * Decrypt the given value.
     *
     * @param  string  $payload
     * @return string
     */
    public function decrypt($payload);
}
