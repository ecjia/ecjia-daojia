<?php

// migrations and seeds paths should have trailing /

return array(
    'remote' => array(
        'name'          => 'production',
        'migrations'    => '/home/htdocs/testing/migrations/',
        'seeds'         => '/home/htdocs/testing/seeds/'
    ),
    
    'export_path' => array(
        'migrations'    => database_path('migrations').'/',
        'seeds'         => database_path('seeds').'/'
    )
);
