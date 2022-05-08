## Ecjia后台ecjia_admin使用说明

#### 方法列表

| 编号 |      方法名       |             简单描述             |
| :--: | :---------------: | :------------------------------: |
|  1   |    admin_log()    |       记录管理员的操作内容       |
|  2   |   admin_priv()    | 判断管理员对某一个操作是否有权限 |
|  3   |    redirect()     |             直接跳转             |
|  4   | make_admin_menu() |        生成admin_menu对象        |

#### 方法详细说明

1、admin_log()

- 记录管理员的操作内容

```
ecjia_admin::admin_log($sn, $action, $content)
```

| 1    | $sn      | string | 数据的唯一值 |
| ---- | -------- | ------ | ------------ |
| 2    | $action  | string | 操作的类型   |
| 3    | $content | string | 操作的内容   |

2、admin_priv()

- 判断管理员对某一个操作是否有权限

```
ecjia_admin::admin_priv($priv_str, $msg_type = ecjia::MSGTYPE_HTML , $msg_output = true)
```

| 1    | $priv_str   | string  | 操作对应的priv_str     |
| ---- | ----------- | ------- | ---------------------- |
| 2    | $msg_type   | string  | 返回的类型 html,json   |
| 3    | $msg_output | boolean | 消息是否输出，默认true |

3、redirect()

- 直接跳转

```
ecjia_admin::redirect($url, $code)
```

| 1    | $url  | string | 跳转链接   |
| ---- | ----- | ------ | ---------- |
| 2    | $code | int    | http返回码 |

4、make_admin_menu()

- 生成admin_menu对象，创建后台app菜单

```
ecjia_admin::make_admin_menu($action, $name, $link, $sort = 99, $target = '_self')
```

| 1    | $action | string | 操作的类型                           |
| ---- | ------- | ------ | ------------------------------------ |
| 2    | $name   | string | 名称                                 |
| 3    | $link   | string | 跳转链接                             |
| 4    | $sort   | int    | 排序                                 |
| 5    | $target | string | 窗口打开方式，默认在当前窗体打开链接 |