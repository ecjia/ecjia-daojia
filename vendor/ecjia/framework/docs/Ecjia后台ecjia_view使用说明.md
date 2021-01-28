### Ecjia后台ecjia_view使用说明

#### 方法列表

| 编号 |         方法名称          |                  简单描述                   |
| :--: | :-----------------------: | :-----------------------------------------: |
|  1   | get_admin_template_dir()  |              获得后台模板目录               |
|  2   | get_admin_template_file() |              获得后台模版文件               |
|  3   | get_front_template_file() |              获得前台模版文件               |
|  4   |         display()         |                  显示视图                   |
|  5   |          fetch()          | 获得视图显示内容 用于生成静态或生成缓存文件 |
|  6   |      fetch_string()       |   使用字符串作为模板，获取解析后输出内容    |
|  7   |        is_cached()        |              模板缓存是否过期               |
|  8   |       clear_cache()       |              清除单个模板缓存               |
|  9   |     clear_all_cache()     |                清除全部缓存                 |
|  10  |         assign()          |               向模版注册变量                |
|  11  |       assign_lang()       |            重新向模版注册语言包             |
|  12  |  clear_compiled_files()   |              清除模版编译文件               |
|  13  |    clear_cache_files()    |                清除缓存文件                 |

#### 方法详细说明

1、get_admin_template_dir()

- 获得后台模板目录

2、get_admin_template_file()

- 获得后台模版文件

```
public function get_admin_template_file($file)
```

| 1    | $file | string | 文件名称 |
| ---- | ----- | ------ | -------- |
|      |       |        |          |

3、get_front_template_file()

- 获得前台模版文件

```
public function get_front_template_file($file)
```

| 1    | $file | string | 文件名称 |
| ---- | ----- | ------ | -------- |
|      |       |        |          |

4、display()

- 显示视图

```
public function isplay($resource_name, $cache_id = null, $show = true, $options = array())
```

| 1    | $resource_name | string | 资源名称 |
| ---- | -------------- | ------ | -------- |
| 2    | $cache_id      | string | 缓存id   |
| 3    | $show          | bool   | 是否显示 |
| 4    | $options       | array  | 其他项   |

5、fetch()

- 获得视图显示内容 用于生成静态或生成缓存文件

```
public function fetch($tpl_file = null, $cache_id = null, $options = array())
```

| 1    | $tpl_file | string | 模板文件 |
| ---- | --------- | ------ | -------- |
| 2    | $cache_id | string | 缓存id   |
| 3    | $options  | array  | 其他项   |

6、fetch_string()

- 使用字符串作为模板，获取解析后输出内容

```
public function fetch_string($tpl_string = null, $cache_id = null, $options = array())
```

| 1    | $tpl_string | string | 模板字符串 |
| ---- | ----------- | ------ | ---------- |
| 2    | $cache_id   | string | 缓存id     |
| 3    | $options    | array  | 其他项     |

7、is_cached()

- 模板缓存是否过期

```
public function is_cached($resource_name, $cache_id = null, $options = array())
```

| 1    | $resource_name | string | 资源名称 |
| ---- | -------------- | ------ | -------- |
| 2    | $cache_id      | string | 缓存id   |
| 3    | $options       | array  | 其他项   |

8、clear_cache()

- 清除单个模板缓存

```
public function clear_cache($resource_name, $cache_id = null, $options = array())
```

| 1    | $resource_name | string | 资源名称 |
| ---- | -------------- | ------ | -------- |
| 2    | $cache_id      | string | 缓存id   |
| 3    | $options       | array  | 其他项   |

9、clear_all_cache()

- 清除全部缓存

```
public function clear_all_cache($cache_time = null, $options = array())
```

| 1    | $cache_time | string | 缓存时间 |
| ---- | ----------- | ------ | -------- |
| 2    | $options    | array  | 其他项   |

10、assign()

- 向模版注册变量

```
public function assign($name, $value = null)
```

| 1    | $name  | string | 名称 |
| ---- | ------ | ------ | ---- |
| 2    | $value | array  | 值   |

11、assign_lang()

- 向模版注册变量

```
public function assign_lang($lang = array())
```

| 1    | $lang | array | 语言包 |
| ---- | ----- | ----- | ------ |
|      |       |       |        |

12、clear_compiled_files()

- 清除模版编译文件

13、clear_cache_files()

- 清除缓存文件