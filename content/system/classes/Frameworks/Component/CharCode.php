<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/11/14
 * Time: 13:01
 */

namespace Ecjia\System\Frameworks\Component;


class CharCode
{

    protected $e = [
        97, 98, 99,
        100, 101, 102, 103, 104, 105, 106, 107, 108, 109,
        110, 111, 112, 113, 114, 115, 116, 117, 118, 119,
        120, 121, 122
    ];

    protected $link;

    public function __construct()
    {

        $this->link['href'] = $this->charArray(104, 116, 116, 112, 58, 47, 47, 119, 119, 119,46,
                101, 99, 106, 105, 97, 46, 99, 111, 109);
        $this->link['innerHTML'] = $this->charArray(
                80, 111, 119, 101, 114, 101, 100, 38, 110, 98, 115, 112, 59, 98,
                121,38, 110, 98, 115, 112, 59,60, 115, 116, 114, 111, 110, 103,
                62, 60,115, 112, 97, 110, 32, 115, 116, 121,108,101, 61, 34, 99,
                111, 108, 111, 114, 58, 32, 35, 51, 51, 54, 54, 70, 70, 34, 62,
                69, 67, 74, 105, 97, 60, 47, 115, 112, 97, 110, 62,60, 47,
                115, 116, 114, 111, 110, 103, 62);

        $this->link['text'] = $this->charArray(80, 111, 119, 101, 114, 101, 100, 32,
            98, 121, 32, 69, 67, 74, $this->e[8], $this->e[0]);

        $this->byLink();
    }

    protected function charArray()
    {
        $argc = func_get_args();
        $str = '';
        if (! empty($argc)) {
            foreach ($argc as $v) {
                $str .= chr($v);
            }
        }

        return $str;
    }


    public function byText()
    {
        return $this->link['text'];
    }


    public function byLink()
    {
        $text = [
            $this->charArray(60, 97, 32, 104, 114, 101, 102, 61, 34),
            null,
            $this->charArray(34, 32, 116, 97, 114, 103, 101, 116, 61, 34,
                95, 98, 108, 97, 110, 107, 34, 62),
            null,
            $this->charArray(60, 47, 97, 62),
        ];
        $text[1] = $this->link['href'];
        $text[3] = $this->link['innerHTML'];

        $str = '';
        foreach ($text as $v) {
            $str .= $v;
        }

        return $str;
    }

    /**
     * encoding and decoding using "chr" and "ord"
     *
     * @param $txtData
     * @param $Level
     * @return string
     */
    public function encode($txtData, $Level)
    {
        for ($j = 0; $j < $Level; $j++) {
            $tmpStr = '';
            for ($i = 0; $i < strlen($txtData); $i++) {
                $tmpStr .= ord(substr(strtoupper($txtData), $i, 1));
            }
            $txtData = $tmpStr;
        }
        return (strlen($Level)).$Level.$txtData;
    }

    /**
     * encoding and decoding using "chr" and "ord"
     *
     * @param $txtData
     * @return bool|string
     */
    public function decode($txtData)
    {
        $intLevel = substr($txtData, 1, substr($txtData, 0, 1));
        $startStr = substr($txtData, substr($txtData, 0, 1)+1, strlen($txtData));
        for ($j = 0; $j < $intLevel; $j++) {
            $tmpStr = '';
            for ($i = 0; $i<strlen($startStr); $i+=2) {
                $tmpStr .= chr(intval(substr($startStr, $i, 2)));
            }
            $startStr = $tmpStr;
        }
        return $startStr;
    }

}