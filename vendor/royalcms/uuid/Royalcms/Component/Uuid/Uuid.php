<?php namespace Royalcms\Component\Uuid;

/**
 * Uuid
 */
class Uuid {

    /**
     * 创建uuid实例
     */
    public static function make() {
        static $generator;
        
        if ( !isset($generator) ) 
        {
            if (function_exists('uuid_create') && !function_exists('uuid_make')) 
            {
                $class = '\Royalcms\Component\Uuid\Provider\Pecl';
            } 
            elseif (function_exists('com_create_guid')) 
            {
                $class = '\Royalcms\Component\Uuid\Provider\Com';
            } 
            else 
            {
                $class = '\Royalcms\Component\Uuid\Provider\Php';
            }
            $generator = new $class();
        }
        
        return $generator;
    }
    
    /**
     * 生成一个uuid
     */
    public static function generate() {
        return self::make()->generate();
    }
    
    /**
     * 验证是否符合uuid规范
     */
    public static function isValid($uuid) {
        return preg_match("/^[0-9a-f]{8}-([0-9a-f]{4}-){3}[0-9a-f]{12}$/", $uuid);
    }

}
