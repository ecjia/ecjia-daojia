<?php

use Datto\JsonRpc\Server;
use Datto\JsonRpc\Examples\Api;

require_once __DIR__ . '/../vendor/autoload.php';

// Example 1. Send a reply:
$server = new Server(new Api());
$reply = $server->reply('{"jsonrpc":"2.0","id":1,"method":"add","params":[1,2]}');

echo "Example 1. Send a reply:\n",
    "   \$server = new Server(new Api());\n",
    "   \$reply = \$server->reply('{\"jsonrpc\":\"2.0\",\"id\":1,\"method\":\"add\",\"params\":[1,2]}');\n",
    "   // reply: {$reply}\n";
        // reply: {"jsonrpc":"2.0","id":1,"result":3}
