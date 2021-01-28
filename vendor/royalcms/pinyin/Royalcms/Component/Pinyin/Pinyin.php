<?php

namespace Royalcms\Component\Pinyin;

use Royalcms\Component\Pinyin\Converter\Pinyin as PinyinConverter;

class Pinyin
{

    const POLICY_CAMEL = 1;

    const POLICY_STUDLY = 2;

    const POLICY_UNDERSCORE = 3;

    const POLICY_HYPHEN = 4;

    const POLICY_BLANK = 5;

    const POLICY_SHRINK = 6;

    protected static $defaultPolicy = self::POLICY_STUDLY;

    protected static $defaultUppercase = false;

    public static function setDefaultPolicy($policy)
    {
        self::$defaultPolicy = $policy;
    }

    public static function setDefaultUpperCase($upper)
    {
        self::$defaultUppercase = $upper;
    }

    /**
     * @param $s
     *
     * @return string
     */
    protected static function getGBKString($s)
    {
        $s = mb_convert_encoding($s, 'GBK', mb_detect_encoding($s));
        return $s;
    }

    /**
     * Convert String To PinYin
     *
     * @param      $string
     * @param null $policy
     * @param null $uppercase
     *
     * @return string
     */
    public function convert($string, $policy = null, $uppercase = null)
    {
        if (is_null($policy)) {
            $policy = self::$defaultPolicy;
        }
        if (is_null($uppercase)) {
            $uppercase = self::$defaultUppercase;
        }
        $components = self::getPinyinComponents($string);
        $py         = $this->applyPolicy($components, $policy);
        $uppercase && $py = strtoupper($py);
        return $py;
    }

    /**
     * Get First Pinyin Letter
     *
     * @param      $string
     * @param bool $uppercase
     *
     * @return string
     */
    public function first($string, $uppercase = true)
    {
        $firstChar = mb_substr($string, 0, 1, 'UTF-8');
        $py        = $this->convert($firstChar);
        $firstPy   = substr($py, 0, 1);
        if ($uppercase) {
            $firstPy = strtoupper($firstPy);
        } else {
            $firstPy = strtolower($firstPy);
        }
        return $firstPy;
    }

    public function firstEach($string, $uppercase = true)
    {
        $components = self::getPinyinComponents($string);
        $chars      = array();
        foreach ($components as $component) {
            $chars[] = substr($component, 0, 1);
        }
        $ret = implode('', $chars);
        if ($uppercase) {
            $ret = strtoupper($ret);
        }
        return $ret;
    }

    private static function getPinyinComponents($s)
    {
        $pinyinObj  = new PinyinConverter();
        $s          = trim($s);
        $s          = preg_replace('/\s/is', '_', $s);
        $s          = self::getGBKString($s);
        $han        = '';
        $components = array();
        for ($i = 0; $i < strlen($s); $i++) {
            if (ord($s[$i]) > 128) {
                $char = $pinyinObj->asc2ToPinyin(ord($s[$i]) + ord($s[$i + 1]) * 256);
                $han .= $char;
                $components[] = $han;
                $han          = '';
                $i++;
            } elseif ($i < (strlen($s) - 1)) {
                if (ord($s[$i]) == 95) {
                    $components[] = $han;
                    $han          = '';
                } elseif (ord($s[$i + 1]) <= 128) {
                    $han .= $s[$i];
                } else {
                    $han .= $s[$i];
                    $components[] = $han;
                    $han          = '';
                }
            } else {
                $han .= $s[$i];
            }
        }
        $components[] = $han;
        $components   = array_filter($components);
        return $components;
    }

    private function applyPolicy($components, $policy)
    {
        $string = implode('-', $components);
        $string = strtolower($string);
        if ($policy == self::POLICY_CAMEL) {
            $string = camel_case($string);
        } elseif ($policy == self::POLICY_UNDERSCORE) {
            $string = camel_case($string);
            $string = snake_case($string, '_');
        } elseif ($policy == self::POLICY_HYPHEN) {
            $string = snake_case($string, '-');
        } elseif ($policy == self::POLICY_STUDLY) {
            $string = studly_case($string);
        } elseif ($policy == self::POLICY_BLANK) {
            $string = preg_replace('#\-#', ' ', $string);
        } elseif ($policy == self::POLICY_SHRINK) {
            $string = preg_replace('#[\s\-]#', '', $string);
        }
        $string = trim($string);
        return $string;
    }
}