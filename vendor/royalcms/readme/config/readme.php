<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Readme File Name
    |--------------------------------------------------------------------------
    |
    | Package's default readme file name.
    |
    */
    'filename' => 'readme.md',

    /*
    |--------------------------------------------------------------------------
    | Route
    |--------------------------------------------------------------------------
    |
    | Default route config.
    | This will register a route as:
    | RC_Route::get('/readme/{packageName?}','Royalcms\Component\Readme\Controllers\ReadmeController@index')->name('readme.index');
    |
    */
    'route' => [
        'prefix' => '/readme/{packageName?}',
        'action' => 'Royalcms\Component\Readme\Controllers\ReadmeController@index',
        'name' => 'readme.index',
    ],
];