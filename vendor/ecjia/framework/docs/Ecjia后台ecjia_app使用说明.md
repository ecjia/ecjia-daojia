### Ecjia后台ecjia_app使用说明

#### 方法列表

| 编号 |         方法名          |            简单描述            |
| :--: | :---------------------: | :----------------------------: |
|  1   |      app_floders()      |   获取所有安装的应用目录名称   |
|  2   | installed_app_floders() | 获取所有安装成功的应用目录名称 |
|  3   |  builtin_app_floders()  |    获取项目内置应用目录名称    |
|  4   |    builtin_bundles()    |   获取内置应用的bundles数组    |
|  5   |    extend_bundles()     |   获取扩展应用的bundles数组    |
|  6   |       get_app_dir       |       获取应用的目录名称       |
|  7   |    get_app_template     |      获取应用模板绝对路径      |
|  8   |  validate_application   |    判断某个应用模块是否存在    |
|  9   |   install_application   |            安装应用            |
|  10  |  uninstall_application  |            卸载应用            |

#### 方法详细说明

1、app_floders()

- 获取所有安装的应用目录名称

2、installed_app_floders()

- 获取所有安装成功的应用目录名称

3、builtin_app_floders()

- 获取项目内置应用目录名称

4、builtin_bundles()

- 获取内置应用的bundles数组

5、extend_bundles()

- 获取扩展应用的bundles数组

6、get_app_dir()

- 获取应用的目录名称

```
public static function get_app_dir($app_id)
```

| 1    | $app_id | string | 应用id |
| ---- | ------- | ------ | ------ |
|      |         |        |        |

7、get_app_template()

- 获取应用模板绝对路径

```
public static function get_app_template($path, $app, $is_admin = true)
```

| 1    | $path     | string | 模板文件路径                                            |
| ---- | --------- | ------ | ------------------------------------------------------- |
| 2    | $app      | string | app应用名称                                             |
| 3    | $is_admin | bool   | 是否为管理员，$is_admin = false不是，$is_admin = true是 |

8、validate_application()

- 判断某个应用模块是否存在

```
public static function validate_application($appdir)
```

| 1    | $appdir | string | 应用模块名称 |
| ---- | ------- | ------ | ------------ |
|      |         |        |              |

9、install_application()

- 安装应用

```
public static function install_application($app_id, $silent = false)
```

| 1    | $app_id | string | 应用id                   |
| ---- | ------- | ------ | ------------------------ |
| 2    | $silent | bool   | 默认为false,为不必填参数 |

10、uninstall_application()

- 卸载应用

```
public static function uninstall_application($app_id, $silent = false)
```

| 1    | $app_id | string | 应用id                   |
| ---- | ------- | ------ | ------------------------ |
| 2    | $silent | bool   | 默认为false,为不必填参数 |