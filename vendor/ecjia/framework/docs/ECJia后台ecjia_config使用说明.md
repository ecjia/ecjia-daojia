

### 后台_config使用说明

#### 方法列表



| 编号 |       方法名       |      简单描述      |
| :--: | :----------------: | :----------------: |
|  1   |   load_config()    |  载入全部配置信息  |
|  2   |   clear_cache()    |  清除配置文件缓存  |
|  3   |   check_config()   | 检查配置项是否存在 |
|  4   |   check_exists()   | 判断配置项值是否空 |
|  5   |   read_config()    |    读取某项配置    |
|  6   |   write_config()   |    写入某项配置    |
|  7   |  insert_config()   |  插入一个配置信息  |
|  8   |  delete_config()   |     删除配置项     |
|  9   | get_addon_config() |  获取插件的配置项  |
|  10  | set_addon_config() |  更新插件的配置项  |

#### 方法详细说明

1、load_config()

- 载入全部配置信息

```php
ecjia_config::instance()->load_config()
```

2、clear_cache()

- 清除配置文件缓存

```php
ecjia_config::instance()->clear_cache()
```

3、check_config()

- 检查配置项是否存在

```
ecjia_config::instance()->check_config($name)
```

| 1    | $name | string | 配置项名称 |
| ---- | ----- | ------ | ---------- |
|      |       |        |            |

4、check_exists()

- 检查配置项是否存在

```
ecjia_config::instance()->check_exists($name)
```

| 1    | $name | string | 配置项名称 |
| ---- | ----- | ------ | ---------- |
|      |       |        |            |

5、read_config()

- 读取某项配置

```
ecjia_config::instance()->read_config($name)
```

| 1    | $name | string | 配置项名称 |
| ---- | ----- | ------ | ---------- |
|      |       |        |            |

6、write_config()

- 写入某项配置

```
ecjia_config::instance()->write_config($code, $value)
```

| 1    | $code  | string  | 配置项名称   |
| ---- | ------ | ------- | ------------ |
| 2    | $value | unknown | 该配置信息值 |

7、insert_config()

- 插入一个配置信息

```
ecjia_config::instance()->insert_config($parent, $code, $value, $options = array())
```

| 1    | $parent  | string | 分组的code           |
| ---- | -------- | ------ | -------------------- |
| 2    | $code    | string | 该配置信息的唯一标识 |
| 3    | $value   | string | 该配置信息值         |
| 4    | $options | array  | 其他项               |

8、delete_config()

- 删除配置项

```
ecjia_config::instance()->delete_config($name)
```

| 1    | $name | string | 配置项名称 |
| ---- | ----- | ------ | ---------- |
|      |       |        |            |

9、get_addon_config()

- 获取插件的配置项

```
ecjia_config::instance()->get_addon_config($code, $unserialize = false, $use_platform = false)
```

| 1    | $code         | string  | 插件代码     |
| ---- | ------------- | ------- | ------------ |
| 2    | $unserialize  | boolean | 是否序列化   |
| 3    | $use_platform | boolean | 是否使用平台 |

10、set_addon_config()

- 更新插件的配置项

```
ecjia_config::instance()->set_addon_config($code, $value, $serialize = false, $use_platform = false)
```

| 1    | $code         | string  | 插件代码     |
| ---- | ------------- | ------- | ------------ |
| 2    | $unserialize  | boolean | 是否序列化   |
| 3    | $use_platform | boolean | 是否使用平台 |