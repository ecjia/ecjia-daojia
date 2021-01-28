<?php

return [

    // database 连接池名称
    'database_connection'    => 'cashier',


    //收银员登录是否验证登录的收银设备是不是当前店铺的
    'signin_validate_device' => env('CASHIER_SIGNIN_VALIDATE_DEVICE', true),

];