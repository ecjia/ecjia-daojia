<?php

return array (
    /* ============================================
     * Memcache驱动，有Memcached、Memcache、Server。
    * 为null时，会优先选择 Memcached > Memcache > Server
    * ============================================
    */
    'driver'                  => null,  
    
    'connection_timeout'      => 1,
    
    'max_item_dump'           => '100',
    
    'servers'                 => array (
        '127.0.0.1:11211' => array (
            'hostname' => '127.0.0.1',
            'port' => '11211',
        ),
  ),
    
);

// end