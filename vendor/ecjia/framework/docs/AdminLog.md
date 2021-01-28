## ecjia 管理员日志



### 操作方法

------------

	需要操作对象时，添加操作对象
	
	ecjia_admin_log::instance()->add_object('connect', '帐号连接');


​	

	需要动作时，添加动作，目前还没有需要自定义的动作
	
	ecjia_admin_log::instance()->add_action('add', '添加');
	
	添加日志的方法
	
	ecjia_admin::admin_log('xxxxxx', 'edit', 'shop_config');
	
		参数1：日志内容
		参数2：日志动作（类似添加、编辑、删除）
		参数3：日志对象（类似商品、文章、订单）


​	

### 示例

------------

	在每个App下，建立 functions 目录
	建立 global.func.php 文件
	
	function assign_adminlog_content() {
		ecjia_admin_log::instance()->add_object('connect', '帐号连接');
	}
	 
	在每个控制器中，构造函数中调用此方法，或者使用之前调用此方法


​	

### 示例解析

------------

> 设置商品：添加关联商品，被编辑商品名是{商品A}

	“设置” 是日志动作
	
	“商品” 是日志对象
	
	“添加关联商品，被编辑商品名是{商品A}” 是日志内容

完整格式如下：（中间冒号是分隔符）
	

	{日志动作}{日志对象}：{日志内容}

没有日志内容的情况下
	

	{日志动作}{日志对象}


​	

### 注明

------------

1. 尽量避免出现两个冒号

