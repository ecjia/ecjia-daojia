<?php

namespace Royalcms\Component\Support;


class Str extends \Illuminate\Support\Str
{
    use StrHelperTrait;

    /**
     * Generate a more truly "random" bytes.
     *
     * @param  int  $length
     * @return string
     */
    public static function randomBytes($length = 16)
    {
        return random_bytes($length);
    }

    /**
     * Generate a "random" alpha-numeric string.
     *
     * Should not be considered sufficient for cryptography, etc.
     *
     * @param  int  $length
     * @return string
     */
    public static function quickRandom($length = 16)
    {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        return static::substr(str_shuffle(str_repeat($pool, $length)), 0, $length);
    }

    /**
     * Compares two strings using a constant-time algorithm.
     *
     * Note: This method will leak length information.
     *
     * Note: Adapted from Symfony\Component\Security\Core\Util\StringUtils.
     *
     * @param  string  $knownString
     * @param  string  $userInput
     * @return bool
     */
    public static function equals($knownString, $userInput)
    {
        if (! is_string($knownString)) {
            $knownString = (string) $knownString;
        }

        if (! is_string($userInput)) {
            $userInput = (string) $userInput;
        }

        if (function_exists('hash_equals')) {
            return hash_equals($knownString, $userInput);
        }

        $knownLength = mb_strlen($knownString, '8bit');

        if (mb_strlen($userInput, '8bit') !== $knownLength) {
            return false;
        }

        $result = 0;

        for ($i = 0; $i < $knownLength; ++$i) {
            $result |= (ord($knownString[$i]) ^ ord($userInput[$i]));
        }

        return 0 === $result;
    }

}
