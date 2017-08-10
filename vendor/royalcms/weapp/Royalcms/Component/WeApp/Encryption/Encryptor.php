<?php

/**
 * Encryptor.php.
 *
 */

namespace Royalcms\Component\WeApp\Encryption;

use Royalcms\Component\WeChat\Encryption\EncryptionException;
use Royalcms\Component\WeChat\Encryption\Encryptor as BaseEncryptor;
use Exception;

class Encryptor extends BaseEncryptor
{
    /**
     * Decrypt data.
     *
     * @param string $sessionKey
     * @param string $iv
     * @param string $encrypted
     *
     * @return array
     */
    public function decryptData($sessionKey, $iv, $encrypted)
    {
        try {
            $decrypted = openssl_decrypt(
                base64_decode($encrypted, true), 'aes-128-cbc', base64_decode($sessionKey, true),
                OPENSSL_RAW_DATA | OPENSSL_NO_PADDING, base64_decode($iv, true)
            );
        } catch (Exception $e) {
            throw new EncryptionException($e->getMessage(), EncryptionException::ERROR_DECRYPT_AES);
        }

        if (is_null($result = json_decode($this->decode($decrypted), true))) {
            throw new EncryptionException('ILLEGAL_BUFFER', EncryptionException::ILLEGAL_BUFFER);
        }

        return $result;
    }
}
