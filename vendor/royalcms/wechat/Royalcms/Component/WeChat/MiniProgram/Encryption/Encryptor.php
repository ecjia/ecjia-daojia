<?php

/**
 * Encryptor.php.
 *
 */

namespace Royalcms\Component\WeChat\MiniProgram\Encryption;

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

            $aesKey = base64_decode($sessionKey, true);

            $aesIV = base64_decode($iv, true);

            $aesCipher = base64_decode($encrypted, true);

            $decrypted = openssl_decrypt(
                $aesCipher, 'aes-128-cbc', $aesKey,
                OPENSSL_RAW_DATA | OPENSSL_NO_PADDING, $aesIV
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
