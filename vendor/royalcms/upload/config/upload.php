<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Filesystem Upload Options
    |--------------------------------------------------------------------------
    |
    | path  附件本地保存相对位置，相对于上传目录的位置
    | url_path 附件访问url
    | use_yearmonth_folders 上传使用年/月文件夹
    | max_size 允许上传大小限制Bytes 2M
    */
    'path'                  => '',
    'url_path'              => '',
    'use_yearmonth_folders' => false,
    'max_size'              => '2097152',

    //默认上传文件类型
    'default_file_types'    => array(
        'rar'  => 'application/x-rar-compressed',
        'zip'  => 'application/zip',
        'txt'  => 'text/plain',
        'pdf'  => 'application/pdf',
        'doc'  => 'application/msword',
        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'xls'  => 'application/vnd.ms-excel',
        'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'ppt'  => 'application/vnd.ms-powerpoint',
        'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
        'jpg'  => 'image/jpg',
        'jpeg' => 'image/jpeg',
        'png'  => 'image/png',
        'gif'  => 'image/x-png',
        'bmp'  => 'image/pjpeg',
    ),

);
