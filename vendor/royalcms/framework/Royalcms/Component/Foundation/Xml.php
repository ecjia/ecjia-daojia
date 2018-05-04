<?php namespace Royalcms\Component\Foundation;
defined('IN_ROYALCMS') or exit('No permission resources.');

/**
 * xml处理类
 *
 * @package tools_class
 */
class Xml extends RoyalcmsObject
{

    /**
     * 解析XML文件
     *
     * @param type $xml            
     * @return type
     */
    private static function _compile($xml)
    {
        $xml_res = xml_parser_create('utf-8');
        xml_parser_set_option($xml_res, XML_OPTION_SKIP_WHITE, 1);
        xml_parser_set_option($xml_res, XML_OPTION_CASE_FOLDING, 0);
        xml_parse_into_struct($xml_res, $xml, $arr, $index);
        xml_parser_free($xml_res);
        return $arr;
    }

    /**
     * 格式化XML文件
     *
     * @param object $data            
     * @return string
     */
    private static function _format_xml($data)
    {
        if (is_object($data)) {
            $data = get_object_vars($data);
        }
        $xml = '';
        foreach ($data as $k => $v) {
            if (is_numeric($k)) {
                $k = "item id=\"$k\"";
            }
            $xml .= "<$k>";
            if (is_object($v) || is_array($v)) {
                $xml .= self::_format_xml($v);
            } else {
                $xml .= str_replace(array(
                    "&",
                    "<",
                    ">",
                    "\"",
                    "'",
                    "-"
                ), array(
                    "&amp;",
                    "&lt;",
                    "&gt;",
                    "&quot;",
                    "&apos;",
                    "&#45;"
                ), $v);
            }
            list ($k, ) = explode(" ", $k);
            $xml .= "</$k>";
        }
        return $xml;
    }

    /**
     * 解析编译后的内容为数组
     *
     * @param array $arrData
     *            数组数据
     * @param int $i
     *            层级
     * @return array 数组
     */
    private static function _get_data($arr_data, &$i)
    {
        $data = array();
        for ($i; $i < count($arr_data); $i ++) {
            $name = $arr_data[$i]['tag'];
            $type = $arr_data[$i]['type'];
            switch ($type) {
                case "attributes":
                    $data[$name]['att'][] = $arr_data[$i]['attributes'];
                    break;
                case "complete": // 内容标签
                    $data[$name][] = isset($arr_data[$i]['value']) ? $arr_data[$i]['value'] : '';
                    break;
                case "open": // 块标签
                    $k = isset($data[$name]) ? count($data[$name]) : 0;
                    $data[$name][$k] = self::_get_data($arr_data, ++ $i);
                    break;
                case "close":
                    return $data;
            }
        }
        return $data;
    }

    /**
     * 创建xml文件
     *
     * @param array $data
     *            数据
     * @param string $root
     *            根据节点
     * @param string $encoding
     *            编码
     * @return string XML字符串
     */
    public static function create($data, $root = null, $encoding = "UTF-8")
    {
        $xml = '';
        $root = is_null($root) ? "root" : $root;
        $xml .= "<?xml version=\"1.0\" encoding=\"$encoding\"?>";
        $xml .= "<$root>";
        $xml .= self::_format_xml($data);
        $xml .= "</$root>";
        return $xml;
    }

    /**
     * 将XML字符串或文件转为数组
     *
     * @param string $xml
     *            XML字符串或XML文件
     * @return array 解析后的数组
     */
    public static function to_array($xml)
    {
        $arr_data = self::_compile($xml);
        $arr = array();
        $k = 1;
        return $arr_data ? self::_get_data($arr_data, $k) : false;
        return $arr;
    }
}

// end