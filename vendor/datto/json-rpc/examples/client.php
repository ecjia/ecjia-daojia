<?php

use Datto\JsonRpc\Client;
use Datto\JsonRpc\Responses\ErrorResponse;
use Datto\JsonRpc\Responses\ResultResponse;

require_once dirname(__DIR__) . '/vendor/autoload.php';


// Example 1. Send a single query:
$client = new Client();
$client->query(1, 'add', array(1, 2));
$message = $client->encode();

echo "Example 1. Send a single query:\n",
    "   \$client = new Client();\n",
    "   \$client->query(1, 'add', array(1, 2));\n",
    "   \$message = \$client->encode();\n",
    "   // message: {$message}\n\n";
        // message: {"jsonrpc":"2.0","method":"add","params":[1,2],"id":1}


// Example 2. Send multiple queries together in a batch:
$client = new Client();
$client->query(1, 'add', array(1, 2));
$client->query(2, 'add', array('a', 'b'));
$message = $client->encode();

echo "Example 2. Send multiple queries together in a batch:\n",
    "   \$client = new Client();\n",
    "   \$client->query(1, 'add', array(1, 2));\n",
    "   \$client->query(2, 'add', array('a', 'b'));\n",
    "   \$message = \$client->encode();\n",
    "   // message: {$message}\n\n";
        // message: [{"jsonrpc":"2.0","id":1,"method":"add","params":[1,2]},{"jsonrpc":"2.0","id":2,"method":"add","params":["a","b"]}]


// Example 3. Send a notification (where no response is required):
$client = new Client();
$client->notify('add', array(1, 2));
$message = $client->encode();

echo "Example 3. Send a notification (where no response is required):\n",
    "   \$client = new Client();\n",
    "   \$client->notify('add', array(1, 2));\n",
    "   \$message = \$client->encode();\n",
    "   // message: {$message}\n\n";
        // message: {"jsonrpc":"2.0","method":"add","params":[1,2]}


// Example 4. Receive a single response:
$client = new Client();
$reply = '{"jsonrpc":"2.0","id":1,"result":3}';
$responses = $client->decode($reply);

echo "Example 4. Receive a single response:\n",
    "   \$client = new Client();\n",
    "   \$reply = '{\"jsonrpc\":\"2.0\",\"id\":1,\"result\":3}';\n",
    "   \$responses = \$client->decode(\$reply);\n",
    "   // responses: [new ResultResponse(1, 3)]\n\n";

// Example 5. Receive a batch of responses:
$client = new Client();
$reply = '[{"jsonrpc":"2.0","id":1,"result":3},{"jsonrpc":"2.0","id":2,"error":{"code":-32602,"message":"Invalid params"}}]';
$responses = $client->decode($reply);


echo "Example 5. Receive a batch of responses:\n",
    "   \$client = new Client();\n",
    "   \$reply = '[{\"jsonrpc\":\"2.0\",\"id\":1,\"result\":3},{\"jsonrpc\":\"2.0\",\"id\":2,\"error\":{\"code\":-32602,\"message\":\"Invalid params\"}}]';\n",
    "   \$responses = \$client->decode(\$reply);\n",
    "   // responses: [new ResultResponse(1, 3), new ErrorResponse(2, 'Invalid params', -32602)]\n";

foreach ($responses as $response) {
    if ($response instanceof ResultResponse) {
        $result = [
            'id' => $response->getId(),
            'value' => $response->getValue()
        ];
    } elseif ($response instanceof ErrorResponse) {
        $error = [
            'id' => $response->getId(),
            'message' => $response->getMessage(),
            'code' => $response->getCode(),
            'data' => $response->getData()
        ];
    }
}
