<?php

if (! function_exists('curl_reset')) {
    /**
     * curl_reset — 重置一个 libcurl 会话句柄的所有的选项
     * 兼容php5.5以下没有这个函数的使用
     *
     * @param  resource  $value 由 curl_init() 返回的 cURL 句柄。
     */
    function curl_reset(& $ch)
    {
        $ch = curl_init();
    }
}

if (! function_exists('curl_file_create')) {
    /**
     * curl_file_create — 创建一个 CURLFile 对象
     * 兼容php5.5以下没有这个函数的使用
     *
     * @param  resource  $value
     */
    function curl_file_create($filename, $mimetype = '', $postname = '') {
        return "@$filename;filename="
        . ($postname ?: basename($filename))
        . ($mimetype ? ";type=$mimetype" : '');
    }
}

if ( !function_exists('array_column') )
{
    /**
     * Pluck a certain field out of each object in a list.
     *
     * This has the same functionality and prototype of
     * array_column() (PHP 5.5) but also supports objects.
     *
     * @since 3.2.0 $index_key parameter added.
     *
     * @param array      $input      List of objects or arrays
     * @param int|string $column_key     Field from the object to place instead of the entire object
     * @param int|string $index_key Optional. Field from the object to use as keys for the new array.
     *                              Default null.
     * @return array Array of found values. If $index_key is set, an array of found values with keys
     *               corresponding to $index_key.
     */
    function array_column( $input, $column_key, $index_key = null ) {
        if ( ! $index_key ) {
            /*
             * This is simple. Could at some point wrap array_column()
            * if we knew we had an array of arrays.
            */
            foreach ( $input as $key => $value ) {
                if ( is_object( $value ) ) {
                    $list[ $key ] = $value->$column_key;
                } else {
                    $list[ $key ] = $value[ $column_key ];
                }
            }
            return $list;
        }

        /*
         * When index_key is not set for a particular item, push the value
        * to the end of the stack. This is how array_column() behaves.
        */
        $newlist = array();
        foreach ( $list as $value ) {
            if ( is_object( $value ) ) {
                if ( isset( $value->$index_key ) ) {
                    $newlist[ $value->$index_key ] = $value->$column_key;
                } else {
                    $newlist[] = $value->$column_key;
                }
            } else {
                if ( isset( $value[ $index_key ] ) ) {
                    $newlist[ $value[ $index_key ] ] = $value[ $column_key ];
                } else {
                    $newlist[] = $value[ $column_key ];
                }
            }
        }

        return $newlist;
    }
}