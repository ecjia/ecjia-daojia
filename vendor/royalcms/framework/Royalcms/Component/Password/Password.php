<?php

/**
 * @file
 *
 * Password
 */

namespace Royalcms\Component\Password;

/**
 * 1-3  $S$
 * 4    迭代次数
 * 5-12 salt
 */
class Password {
    
    /**
     * hash前缀
     */
    const HASH_PREFIX = '$S$';
    
    /**
     * hash长度
     */
    const HASH_LENGTH = 64;
    
    /**
     * 64字符mapping
     */
    protected static $ITOA64 = './0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    
    /**
     * 根据密码生成一个hash
     */
    public static function hash($password) {
        return static::crypt('sha512', $password, static::generateSalt());
    }

    /**
     * 验证密码
     */
    public static function verify($password, $hash) {
        $prefix = substr($hash, 0, 3);
        switch ($prefix) {
            case static::HASH_PREFIX:
                $newHash = static::crypt('sha512', $password, $hash);
                break;
            default:
                return false;
        }
        
        return ($newHash && $newHash == $hash);
    }
    
    /**
     * 是否符合hash规范
     */
    public static function needsRehash($hash) {
        if (strlen($hash) != static::HASH_LENGTH || substr($hash, 0, 3) != static::HASH_PREFIX) {
            return true;
        }
    }
    
    //生成盐
    protected static function generateSalt() {
        $count = mt_rand(1,63);
        return static::HASH_PREFIX . static::$ITOA64[$count] . substr(hash('sha256',microtime(true)),0,8);
    }
    
    //执行hash的生成
    protected static function crypt($algo, $password, $string) {
        $setting = substr($string, 0, 12);
        if ($setting[0] != '$' || $setting[2] != '$') {
            return false;
        }
        $count = strpos(static::$ITOA64, $setting[3]);
        $salt  = substr($setting, 4, 8);
        $hash  = hash($algo, $salt . $password);
        while ($count--) {
            $hash = hash($algo, $hash . $password);
        }
        $output = $setting . $hash;
        
        return substr($output, 0, static::HASH_LENGTH);
    }

}
