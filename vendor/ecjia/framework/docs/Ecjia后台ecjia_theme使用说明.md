### Ecjia后台ecjia_theme使用说明

#### 方法列表

| 编号 |       方法名称       |               简单描述               |
| :--: | :------------------: | :----------------------------------: |
|  1   | get_template_files() |          可以设置内容的模板          |
|  2   |   get_page_libs()    |       每个模板允许设置的库项目       |
|  3   |   get_libraries()    |            读取库项目列表            |
|  4   |     get_setted()     |   获得指定库项目在模板中的设置内容   |
|  5   |    load_library()    |            载入库项目内容            |
|  6   |   update_library()   |            更新库项目内容            |
|  7   |  restore_library()   |              还原库项目              |
|  8   |   get_theme_info()   |            获得模版的信息            |
|  9   |  read_theme_style()  |           读取模板风格列表           |
|  10  |   get_dyna_libs()    | 获取指定主题某个模板的主题的动态模块 |
|  11  |  available_themes()  |            获得可用的主题            |
|  12  | clear_not_actived()  |         清除不需要的模板设置         |

#### 方法详细说明

2、get_page_libs()

- 每个模板允许设置的库项目

```
 public function get_page_libs($filename)
```

| 1    | $filename | string | 模板名称 |
| ---- | --------- | ------ | -------- |
|      |           |        |          |

4、get_setted()

- 获得指定库项目在模板中的设置内容

```
public function get_setted($lib, &$arr)
```

| 1    | $lib  | string | 库项目             |
| ---- | ----- | ------ | ------------------ |
| 2    | &$arr | array  | 包含设定内容的数组 |

5、load_library()

- 载入库项目内容

```
public function load_library($lib_name)
```

| 1    | $lib_name | string | 库项目名称 |
| ---- | --------- | ------ | ---------- |
|      |           |        |            |

6、update_library()

- 更新库项目内容

```
public function update_library($lib_name, $content)
```

| 1    | $lib_name | string | 库项目名称   |
| ---- | --------- | ------ | ------------ |
| 2    | $content  | string | 项目库的内容 |

7、restore_library()

- 还原库项目

```
public function restore_library($lib_name)
```

| 1    | $lib_name | string | 库项目名称 |
| ---- | --------- | ------ | ---------- |
|      |           |        |            |

8、get_theme_info()

- 获得模版的信息

```
public function get_theme_info($template_style = '')
```

| 1    | $template_style | string | 模版风格名 |
| ---- | --------------- | ------ | ---------- |
|      |                 |        |            |

9、read_theme_style()

- 读取模板风格列表

```
function read_theme_style($flag = 1)
```

| 1    | $flag | init | 1.AJAX数据；2.Array |
| ---- | ----- | ---- | ------------------- |
|      |       |      |                     |

10、get_dyna_libs()

- 获取指定主题某个模板的主题的动态模块

```
public function get_dyna_libs($tmp)
```

| 1    | $tmp | string | 模板名称 |
| ---- | ---- | ------ | -------- |
|      |      |        |          |