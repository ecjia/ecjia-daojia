<?php

namespace Royalcms\Component\Support;

trait ArrayHelperTrait
{

    /**
     * 将数组中的值全部转为大写或小写
     *
     * @param array $arr            
     * @param int $type 类型 'upper'=>大写 'lower'=>小写
     * @return array
     */
    public static function transform_value_case($arr, $type = 'lower')
    {
        $function = $type ? 'strtoupper' : 'strtolower';
        $new_arr = array(); // 格式化后的数组
        foreach ($arr as $k => $v) {
            if (is_array($v)) {
                $new_arr[$k] = self::transform_value_case($v, $type);
            } else {
                $new_arr[$k] = $function($v);
            }
        }
        
        return $new_arr;
    }

    /**
     * 将字符串转换为数组 string_to_array
     *
     * @param string $data            
     * @return array
     */
    public static function string2array($data)
    {
        if ($data == '')
            return array();
        $array = array();
        eval("\$array = $data;");
        return $array;
    }

    /**
     * 将对象到数组转换 object_to_array
     *
     * @param object $obj            
     * @return array
     */
    public static function object2array($obj)
    {
        if (! is_object($obj) && ! is_array($obj)) {
            return $obj;
        }
        $arr = array();
        foreach ($obj as $k => $v) {
            $arr[$k] = self::object2array($v);
        }
        return $arr;
    }

    /**
     * 将数组转换为字符串 array_to_string
     *
     * @param array $data            
     * @param bool $isformdata            
     * @return string
     */
    public static function array2string($data, $isformdata = 1)
    {
        if ($data == '')
            return '';
        if ($isformdata)
            $data = rc_stripslashes($data);
        return rc_addslashes(var_export($data, true));
    }

    /**
     * 获取某个数组的内存大小
     *
     * @param array $arr
     * @return number
     */
    public static function array_size($arr)
    {
        ob_start();
        print_r($arr);
        $mem = ob_get_contents();
        ob_end_clean();
        $mem = preg_replace("/\n +/", "", $mem);
        $mem = strlen($mem);
        return $mem;
    }

    /**
     * 对数据进行编码转换
     *
     * @param array/string $data 数组
     * @param string $input 需要转换的编码
     * @param string $output 转换后的编码
     */
    public static function array_iconv($data, $input = 'gbk', $output = 'utf-8')
    {
        if (! is_array($data)) {
            return iconv($input, $output, $data);
        } else {
            foreach ($data as $key => $val) {
                if (is_array($val)) {
                    $data[$key] = self::array_iconv($val, $input, $output);
                } else {
                    $data[$key] = iconv($input, $output, $val);
                }
            }
            return $data;
        }
    }
}

// end