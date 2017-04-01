<?php namespace Royalcms\Component\WeChat;

use Exception;

/**
 * @file
 *
 * AES 
 */

class Prpcrypt {
    
    public static $size = 32;
    
    protected $key;
    
    public function __construct($aeskey) {
        $this->key = base64_decode($aeskey . '=');
    }
    
    public function encrypt($text, $appid = '') {
        try {
            $random = substr(md5(time()), 0, 16);
            $text = $random . pack('N', strlen($text)) . $text . $appid;
            $size = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
            $td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');
            $iv = substr($this->key, 0, 16);
            $text = self::PKCS7Encode($text);
            mcrypt_generic_init($td, $this->key, $iv);
            $encrypted = mcrypt_generic($td, $text);
            mcrypt_generic_deinit($td);
            mcrypt_module_close($td);
            return base64_encode($encrypted);
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), ErrorCode::$EncryptAESError);
        }
    }

    public function decrypt($encrypted, $appid = '') {
        try {
            $encrypted = base64_decode($encrypted);
            $td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');
            $iv = substr($this->key, 0, 16);
            mcrypt_generic_init($td, $this->key, $iv);
            $decrypted = mdecrypt_generic($td, $encrypted);
            mcrypt_generic_deinit($td);
            mcrypt_module_close($td);
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), ErrorCode::$DecryptAESError);
        }
        try {
            $result = self::PKCS7Decode($decrypted);
            if (strlen($result) < 16) {
                throw new Exception('PKCS7Decode length less than 16', ErrorCode::$IllegalBuffer);
            }
            $content = substr($result, 16);
            $lenlist = unpack('N', substr($content, 0, 4));
            $xmlLen  = $lenlist[1];
            $xmlData = substr($content, 4, $xmlLen);
            $fromId  = substr($content, $xmlLen + 4);
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), ErrorCode::$IllegalBuffer);
        }
        if ($fromId != $appid) {
            throw new Exception('Unvalidated Appid.', ErrorCode::$ValidateAppidError);
        } else {
            return $xmlData;
        }
    }

    public static function PKCS7Encode($text) {
        $len = strlen($text);
        $pad = self::$size - $len % self::$size;
        if ($pad == 0) {
            $pad = self::$size;
        }
        $chr = chr($pad);
        return $text . str_repeat($chr, $pad);
    }

    public static function PKCS7Decode($text) {
        $pad = ord(substr($text, -1));
        if ($pad < 1 || $pad > 32) {
            $pad = 0;
        }
        return substr($text, 0, (strlen($text) - $pad));
    }

}