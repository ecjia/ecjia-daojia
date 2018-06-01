<?php

/**
 * Your package config would go here
 */

return [
    
    // Websocket hostname
    'host'  => '127.0.0.1', //localhost
    
    // Port at which websocket server is listening on
    'port'  => '8000',
    
    // Need to use ssl for wss connections
    'ssl'   => false,
    
    'pem_file' => realpath(__DIR__ . '/../certificates/server.pem'),
    'pem_passphrase' => 'shinywss',
    
    'queue_name' => 'websocket',
    
    'handler' => '\Royalcms\Component\Websocket\Handles\WebsocketHandle',
    
    'actions' => [
        'remote_ssh' => '\Royalcms\Component\Websocket\Actions\RemoteSSHAction',
    ],
    
    
];
