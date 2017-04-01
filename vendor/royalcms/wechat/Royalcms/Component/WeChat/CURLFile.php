<?php namespace Royalcms\Component\WeChat;

/**
 * @file
 *
 * CURLFile
 * php5.5+
 */

class CURLFile {
    
    public static function realpath($file) {
        if (class_exists('\CURLFile')) {
            return new \CURLFile(realpath($file));
        } else {
            return '@' . realpath($file);
        }
    }

}
