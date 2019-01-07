<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/10/16
 * Time: 4:07 PM
 */

namespace Ecjia\App\Ucserver\Utilities;

class Serialize
{

    public static function serialize($arr, $htmlon = 0)
    {
        return self::xml_serialize($arr, $htmlon);
    }


    public static function unserialize($arr, $htmlon = 0)
    {
        return self::xml_unserialize($arr, $htmlon);
    }


    public static function xml_unserialize(& $xml, $isnormal = false)
    {
        $xml_parser = new XML($isnormal);
        $data = $xml_parser->parse($xml);
        $xml_parser->__destruct();
        return $data;
    }

    public static function xml_serialize($arr, $htmlon = false, $isnormal = false, $level = 1)
    {
        $s = $level == 1 ? "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\r\n<root>\r\n" : '';
        $space = str_repeat("\t", $level);
        foreach($arr as $k => $v) {
            if(!is_array($v)) {
                $s .= $space."<item id=\"$k\">".($htmlon ? '<![CDATA[' : '').$v.($htmlon ? ']]>' : '')."</item>\r\n";
            } else {
                $s .= $space."<item id=\"$k\">\r\n".self::xml_serialize($v, $htmlon, $isnormal, $level + 1).$space."</item>\r\n";
            }
        }
        $s = preg_replace("/([\x01-\x08\x0b-\x0c\x0e-\x1f])+/", ' ', $s);
        return $level == 1 ? $s."</root>" : $s;
    }


}