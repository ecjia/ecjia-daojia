<?php namespace Royalcms\Component\Xmlrpc;
/**
 * Royalcms\Component\Xmlrpc\Server
 *
 * @package XMLRPC
 * @since 1.5
 */
class Server
{
    var $data;
    var $callbacks = array();
    var $message;
    var $capabilities;

    public function __construct($callbacks = false, $data = false, $wait = false)
    {
        $this->setCapabilities();
        if ($callbacks) {
            $this->callbacks = $callbacks;
        }
        $this->setCallbacks();
        if (!$wait) {
            $this->serve($data);
        }
    }

    public function serve($data = false)
    {
        if (!$data) {
            if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] !== 'POST') {
                header('Content-Type: text/plain'); // merged from WP #9093
                die('XML-RPC server accepts POST requests only.');
            }

            global $HTTP_RAW_POST_DATA;
            if (empty($HTTP_RAW_POST_DATA)) {
                // workaround for a bug in PHP 5.2.2 - http://bugs.php.net/bug.php?id=41293
                $data = file_get_contents('php://input');
            } else {
                $data =& $HTTP_RAW_POST_DATA;
            }
        }
        $this->message = new Message($data);
        if (!$this->message->parse()) {
            $this->error(-32700, 'parse error. not well formed');
        }
        if ($this->message->messageType != 'methodCall') {
            $this->error(-32600, 'server error. invalid xml-rpc. not conforming to spec. Request must be a methodCall');
        }
        $result = $this->call($this->message->methodName, $this->message->params);

        // Is the result an error?
        if (is_a($result, '\Royalcms\Component\Xmlrpc\Error')) {
            $this->error($result);
        }

        // Encode the result
        $r = new Value($result);
        $resultxml = $r->getXml();

        // Create the XML
        $xml = <<<EOD
<methodResponse>
  <params>
    <param>
      <value>
      $resultxml
      </value>
    </param>
  </params>
</methodResponse>

EOD;
        // Send it
        $this->output($xml);
    }

    public function call($methodname, $args)
    {
        if (!$this->hasMethod($methodname)) {
            return new Error(-32601, 'server error. requested method '.$methodname.' does not exist.');
        }
        $method = $this->callbacks[$methodname];

        // Perform the callback and send the response
        if (count($args) == 1) {
            // If only one paramater just send that instead of the whole array
            $args = $args[0];
        }

        // Are we dealing with a function or a method?
        if (is_string($method) && substr($method, 0, 5) == 'this:') {
            // It's a class method - check it exists
            $method = substr($method, 5);
            if (!method_exists($this, $method)) {
                return new Error(-32601, 'server error. requested class method "'.$method.'" does not exist.');
            }

            //Call the method
            $result = $this->$method($args);
        } else {
            // It's a function - does it exist?
            if (is_array($method)) {
                if (!method_exists($method[0], $method[1])) {
                    return new Error(-32601, 'server error. requested object method "'.$method[1].'" does not exist.');
                }
            } else if (!function_exists($method)) {
                return new Error(-32601, 'server error. requested function "'.$method.'" does not exist.');
            }
            
            // Call the function
            $result = call_user_func($method, $args);
        }
        return $result;
    }

    public function error($error, $message = false)
    {
        // Accepts either an error object or an error code and message
        if ($message && !is_object($error)) {
            $error = new Error($error, $message);
        }
        $this->output($error->getXml());
    }

    public function output($xml)
    {
        $xml = '<?xml version="1.0"?>'."\n".$xml;
        $length = strlen($xml);
        header('Connection: close');
        header('Content-Length: '.$length);
        header('Content-Type: text/xml');
        header('Date: '.date('r'));
        echo $xml;
        exit;
    }

    public function hasMethod($method)
    {
        return in_array($method, array_keys($this->callbacks));
    }

    public function setCapabilities()
    {
        // Initialises capabilities array
        $this->capabilities = array(
            'xmlrpc' => array(
                'specUrl' => 'http://www.xmlrpc.com/spec',
                'specVersion' => 1
            ),
            'faults_interop' => array(
                'specUrl' => 'http://xmlrpc-epi.sourceforge.net/specs/rfc.fault_codes.php',
                'specVersion' => 20010516
            ),
            'system.multicall' => array(
                'specUrl' => 'http://www.xmlrpc.com/discuss/msgReader$1208',
                'specVersion' => 1
            ),
        );
    }

    public function getCapabilities($args)
    {
        return $this->capabilities;
    }

    public function setCallbacks()
    {
        $this->callbacks['system.getCapabilities'] = 'this:getCapabilities';
        $this->callbacks['system.listMethods'] = 'this:listMethods';
        $this->callbacks['system.multicall'] = 'this:multiCall';
    }

    public function listMethods($args)
    {
        // Returns a list of methods - uses array_reverse to ensure user defined
        // methods are listed before server defined methods
        return array_reverse(array_keys($this->callbacks));
    }

    public function multiCall($methodcalls)
    {
        // See http://www.xmlrpc.com/discuss/msgReader$1208
        $return = array();
        foreach ($methodcalls as $call) {
            $method = $call['methodName'];
            $params = $call['params'];
            if ($method == 'system.multicall') {
                $result = new Error(-32600, 'Recursive calls to system.multicall are forbidden');
            } else {
                $result = $this->call($method, $params);
            }
            if (is_a($result, '\Royalcms\Component\Xmlrpc\Error')) {
                $return[] = array(
                    'faultCode' => $result->code,
                    'faultString' => $result->message
                );
            } else {
                $return[] = array($result);
            }
        }
        return $return;
    }
}

// end