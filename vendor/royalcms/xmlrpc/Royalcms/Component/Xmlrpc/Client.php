<?php namespace Royalcms\Component\Xmlrpc;
/**
 * Royalcms\Component\Xmlrpc\Client
 *
 * @package XMLRPC
 * @since 1.5
 *
 */
class Client
{
    var $server;
    var $port;
    var $path;
    var $useragent;
    var $response;
    var $message = false;
    var $debug = false;
    var $timeout;

    // Storage place for an error message
    var $error = false;

    function __construct($server, $path = false, $port = 80, $timeout = 15)
    {
        if (!$path) {
            // Assume we have been given a URL instead
            $bits = parse_url($server);
            $this->server = $bits['host'];
            $this->port = isset($bits['port']) ? $bits['port'] : 80;
            $this->path = isset($bits['path']) ? $bits['path'] : '/';

            // Make absolutely sure we have a path
            if (!$this->path) {
                $this->path = '/';
            }
        } else {
            $this->server = $server;
            $this->path = $path;
            $this->port = $port;
        }
        $this->useragent = 'The Incutio XML-RPC PHP Library';
        $this->timeout = $timeout;
    }

    function query()
    {
        $args = func_get_args();
        $method = array_shift($args);
        $request = new Request($method, $args);
        $length = $request->getLength();
        $xml = $request->getXml();
        $r = "\r\n";
        $request  = "POST {$this->path} HTTP/1.0$r";

        // Merged from WP #8145 - allow custom headers
        $this->headers['Host']          = $this->server;
        $this->headers['Content-Type']  = 'text/xml';
        $this->headers['User-Agent']    = $this->useragent;
        $this->headers['Content-Length']= $length;

        foreach( $this->headers as $header => $value ) {
            $request .= "{$header}: {$value}{$r}";
        }
        $request .= $r;

        $request .= $xml;

        // Now send the request
        if ($this->debug) {
            echo '<pre class="ixr_request">'.htmlspecialchars($request)."\n</pre>\n\n";
        }

        if ($this->timeout) {
            $fp = @fsockopen($this->server, $this->port, $errno, $errstr, $this->timeout);
        } else {
            $fp = @fsockopen($this->server, $this->port, $errno, $errstr);
        }
        if (!$fp) {
            $this->error = new Error(-32300, 'transport error - could not open socket');
            return false;
        }
        fputs($fp, $request);
        $contents = '';
        $debugContents = '';
        $gotFirstLine = false;
        $gettingHeaders = true;
        while (!feof($fp)) {
            $line = fgets($fp, 4096);
            if (!$gotFirstLine) {
                // Check line for '200'
                if (strstr($line, '200') === false) {
                    $this->error = new Error(-32300, 'transport error - HTTP status code was not 200');
                    return false;
                }
                $gotFirstLine = true;
            }
            if (trim($line) == '') {
                $gettingHeaders = false;
            }
            if (!$gettingHeaders) {
                // merged from WP #12559 - remove trim
                $contents .= $line;
            }
            if ($this->debug) {
                $debugContents .= $line;
            }
        }
        if ($this->debug) {
            echo '<pre class="ixr_response">'.htmlspecialchars($debugContents)."\n</pre>\n\n";
        }
       
        // Now parse what we've got back
        $this->message = new Message($contents);
        if (!$this->message->parse()) {
            // XML error
            $this->error = new Error(-32700, 'parse error. not well formed');
            return false;
        }

        // Is the message a fault?
        if ($this->message->messageType == 'fault') {
            $this->error = new Error($this->message->faultCode, $this->message->faultString);
            return false;
        }

        // Message must be OK
        return true;
    }

    function getResponse()
    {
        // methodResponses can only have one param - return that
        return $this->message->params[0];
    }

    function isError()
    {
        return (is_object($this->error));
    }

    function getErrorCode()
    {
        return $this->error->code;
    }

    function getErrorMessage()
    {
        return $this->error->message;
    }
}

// end