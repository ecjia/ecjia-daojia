<?php

namespace Royalcms\Component\Aliyun\OSS\Utilities;

abstract class OSSResponseParserFactory {
    public static function factory() {
        return new OSSSXParserFactory();
    }
    
    public abstract function createParser($name);
    public abstract function createErrorParser();
}
 