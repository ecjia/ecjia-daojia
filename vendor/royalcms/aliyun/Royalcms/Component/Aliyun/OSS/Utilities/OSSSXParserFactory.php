<?php

namespace Royalcms\Component\Aliyun\OSS\Utilities;

use Royalcms\Component\Aliyun\OSS\Parsers\SXParser\SXOSSErrorParser;

final class OSSSXParserFactory extends OSSResponseParserFactory {

    const PREFIX = 'SX';
    const PARSER_PATH = 'Royalcms\\Component\\Aliyun\\OSS\\Parsers\\SXParser\\';
    const EMPTY_PARSER_NAME = 'EmptyParser';

    public function createParser($commandName) {
        $className = self::PREFIX.ucfirst($commandName).'Parser';
        $class = self::PARSER_PATH.$className;
        if (!class_exists($class)) {
            $class = self::PARSER_PATH.self::PREFIX.self::EMPTY_PARSER_NAME;
        }
        return new $class();
    }
    
    public function createErrorParser() {
        return new SXOSSErrorParser();
    }
}
