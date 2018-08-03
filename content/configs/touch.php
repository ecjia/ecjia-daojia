<?php


return [
    
    /*
     |--------------------------------------------------------------------------
     | Touch Cache Driver
     |--------------------------------------------------------------------------
     |
     | This option controls the default cache "driver" that will be used when
     | using the Caching library. Of course, you may use other drivers any
     | time you wish. This is the default when another is not specified.
     |
     | Supported: "file", "database", "apc", "memcached", "redis", "array"
     |
     */
    'cache_driver' => env('TOUCH_CACHE_DRIVER', 'file'), 
    
    
];
