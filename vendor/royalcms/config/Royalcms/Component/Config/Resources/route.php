<?php

return array(
    
    /**
     * 应用模块变量名
     */
    'module'       => 'm',
    
    /**
     * 控制器变量名
     */
    'controller'   => 'c',
    
    /**
     * 动作变量名
     */
    'action'       => 'a',
    
    /**
     * 兼容模式GET变量
     */
    'route'        => 'r',

    /**
     * 页数变量名
     */
    'page'         => 'page',

    /**
     * 语言变量名
     */
    'lang'         => 'lang',
    
    
    /**
     * 路由配置文件
     * 默认配置为default如下：
     * 'default'=>array(
     * 'm'=>'royalcms',
     * 'c'=>'index',
     * 'a'=>'init',
     * 'data'=>array(
     * 'POST'=>array(
     * 'catid'=>1
     * ),
     * 'GET'=>array(
     * 'contentid'=>1
     * )
     * ),
     * 'rule'=>array(),
     * )
     * 基中“m”为应用,“c”为控制器，“a”为事件，“data”为其他附加参数。
     * data为一个二维数组，可设置POST和GET的默认参数。POST和GET分别对应PHP中的$_POST和$_GET两个超全局变量。在程序中您可以使用$_POST['catid']来得到data下面POST中的数组的值。
     * data中的所设置的参数等级比较低。如果外部程序有提交相同的名字的变量，将会覆盖配置文件中所设置的值。如：
     * 外部程序POST了一个变量catid=2那么你在程序中使用$_POST取到的值是2，而不是配置文件中所设置的1。
     */
	'default' => array(
	    'm' => '', 
	    'c' => '', 
	    'a' => ''
	),
);

// end