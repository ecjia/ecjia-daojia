<?php

return [

    'providers' => [

        /*
         * Package Service Providers...
         */
        Ecjia\Kernel\Providers\ArtisanServiceProvider::class,

        // 运行迁移命令
        Illuminate\Database\MigrationServiceProvider::class,


//        'Royalcms\Component\Database\SeedServiceProvider',
//        'Royalcms\Component\Database\MigrationServiceProvider',




    ],


];
