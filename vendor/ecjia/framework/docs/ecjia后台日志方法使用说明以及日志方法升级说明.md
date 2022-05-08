### ecjia后台日志方法使用说明以及日志方法升级说明

#### 日志方法定义更新

旧： 定义在global.func.php文件下。

示例： 如adsense模块，定义在adsense/functions/global.func.php文件：

```
 /**
  * 添加管理员记录日志操作对象
  */
function assign_adminlog_content()
{
    ecjia_admin_log::instance()->add_object('group_cycleimage', '轮播组');
    ecjia_admin_log::instance()->add_action('move', '转移');
}
```

新： 在指定模块下classes文件夹新建一个Helper.php文件

示例： 如adsense模块，在adsense/classes/目录下新建一个Helper.php文件，内容如下：

```
namespace Ecjia\App\Adsense;  //Adsense为该模块app名称，首字母大写

use ecjia_admin_log;
use RC_Lang;

class Helper
{ 
    /**
     * 添加管理员记录日志操作对象
     */
    public static function assign_adminlog_content() {
        ecjia_admin_log::instance()->add_object('group_cycleimage', '轮播组');
        ecjia_admin_log::instance()->add_action('move', '转移');
    } 
}
```

#### 控制器文件中日志方法调用更新

旧： 先加载globla文件，再调用日志方法。

示例： 如adsense模块调用日志方法：

```
RC_Loader::load_app_func('global', 'adsense'); //adsense为该模块app名称
assign_adminlog_content();
```

新：

示例： 如adsense模块调用日志方法：

```
Ecjia\App\Adsense\Helper::assign_adminlog_content(); //Adsense为该模块app名称，首字母大写
```