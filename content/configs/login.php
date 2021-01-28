<?php

return [

    // 最大允许失败次数
    'max_failed_times' => 6,

    // 锁定时间，单位分钟
    'error_lock_minutes' => 5,
    
	//是否强制修改数据库32位非hash密码为64位hash密码（如果大商创是2.0的话关闭此设置，是X的话开启）
    'force_hash_password' => false,
];