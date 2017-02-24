<?php namespace Royalcms\Component\Xmlrpc;
/**
 * Royalcms\Component\Xmlrpc\Request
 *
 * @package XMLRPC
 * @since 1.5
 */
class Request
{
    var $method;
    var $args;
    var $xml;

    public function __construct($method, $args)
    {
        $this->method = $method;
        $this->args = $args;
        $this->xml = <<<EOD
<?xml version="1.0"?>
<methodCall>
<methodName>{$this->method}</methodName>
<params>

EOD;
        foreach ($this->args as $arg) {
            $this->xml .= '<param><value>';
            $v = new Value($arg);
            $this->xml .= $v->getXml();
            $this->xml .= "</value></param>\n";
        }
        $this->xml .= '</params></methodCall>';
    }

    public function getLength()
    {
        return strlen($this->xml);
    }

    public function getXml()
    {
        return $this->xml;
    }
}

// end