<?php namespace Royalcms\Component\Xmlrpc;
/**
 * Royalcms\Component\Xmlrpc\ClientMulticall
 *
 * @package XMLRPC
 * @since 1.5
 */
class ClientMulticall extends Client
{
    var $calls = array();

    function __construct($server, $path = false, $port = 80)
    {
        parent::__construct($server, $path, $port);
        $this->useragent = 'The Incutio XML-RPC PHP Library (multicall client)';
    }

    function addCall()
    {
        $args = func_get_args();
        $methodName = array_shift($args);
        $struct = array(
            'methodName' => $methodName,
            'params' => $args
        );
        $this->calls[] = $struct;
    }

    function query()
    {
        // Prepare multicall, then call the parent::query() method
        return parent::query('system.multicall', $this->calls);
    }
}

// end