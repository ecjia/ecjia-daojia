<?php namespace Royalcms\Component\Xmlrpc;
/**
 * Royalcms\Component\Xmlrpc\Base64
 *
 * @package XMLRPC
 * @since 1.5
 */
class Base64
{
    var $data;

    function __construct($data)
    {
        $this->data = $data;
    }

    function getXml()
    {
        return '<base64>'.base64_encode($this->data).'</base64>';
    }
}

// end