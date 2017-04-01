<?php namespace Royalcms\Component\WeChat;

use LogicException;

/*
 * @file
 *
 * WeChat Request
 */

class Request extends ParameterBag {
   
    /**
     * 原始数据
     *
     * @var string
     */
    protected $content;
    
    /**
     * WeChat实例
     */
    public $wechat;

    /**
     * 析构函数
     */
    public function __construct($xmlData = '') {
        $this->initialize($xmlData);
    }

    /**
     * 初始化数据
     *
     * @return array|mixed
     */
    public function initialize($xmlData, $replace = true) {
        $this->content = $xmlData;
        $xml = @simplexml_load_string($xmlData, 'SimpleXMLElement', LIBXML_NOCDATA | LIBXML_NOBLANKS);
        $params = (array) self::extractXML($xml);
        $params += array_change_key_case($params, CASE_LOWER);
        if ($replace) {
            parent::replace($params);
        } else {
            parent::setParameters($params);
        }
    }

    /**
     * 获取内容
     *
     * @return resource|string
     */
    public function getContent($asResource = false) {
        if (false === $this->content || (true === $asResource && null !== $this->content)) {
            throw new LogicException('getContent() can only be called once when using the resource return type.');
        }
        if (true === $asResource) {
            $this->content = false;
            return fopen('php://input', 'rb');
        }
        if (null === $this->content) {
            $this->content = file_get_contents('php://input');
        }

        return $this->content;
    }

    /*
     * 从GLOBALS创建Request
     *
     * @return request
     */
    public static function createFromGlobals() {
        return new static(file_get_contents('php://input'));
    }
    
    //解析XML
    protected static function extractXML($xml = false) {
        if ($xml === false) {
            return false;
        }
        if (!($xml->children())) {
            return (string) $xml;
        }
        foreach ($xml->children() as $child) {
            $name = $child->getName();
            if (count($xml->$name) == 1) {
                $element[$name] = self::extractXML($child);
            } else {
                $element[][$name] = self::extractXML($child);
            }
        }

        return $element;
    }

}