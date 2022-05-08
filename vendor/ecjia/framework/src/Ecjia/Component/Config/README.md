## 新版用法

1. 获取所有的配置信息
```
ecjia_config::all()
```

2. 获取单个配置项的值
```
ecjia_config::get($key, $default = null)
```

3. 设置一个配置项的值，但不保存数据库
```
ecjia_config::set($key, $value)
```

4. 设置一个配置项的值，并保存数据库
```
ecjia_config::write($key, $value)
```

5. 判断是否有某个配置顶
```
ecjia_config::has($key)
```

6. 添加某个配置项
```
ecjia_config::add($group, $key, $value, $options = [])
```

7. 修改某个配置项
```
ecjia_config::change($group, $key, $value, $options = [])
```

8. 删除一个配置项
```
ecjia_config::delete($key)
```


## 旧版用法

1、load_config()

载入全部配置信息
```
ecjia_config::instance()->load_config()
```

2、clear_cache()

清除配置文件缓存
```
ecjia_config::instance()->clear_cache()
```

3、check_config()

检查配置项是否存在
```
1	$name	string	配置项名称

ecjia_config::instance()->check_config($name)
```

4、check_exists()

检查配置项是否存在
```
1	$name	string	配置项名称

ecjia_config::instance()->check_exists($name)
```

5、read_config()

读取某项配置

```
1	$name	string	配置项名称

ecjia_config::instance()->read_config($name)
```

6、write_config()

写入某项配置

```
1	$code	string	配置项名称
2	$value	unknown	该配置信息值

ecjia_config::instance()->write_config($code, $value)
```

7、insert_config()

插入一个配置信息
```
1	$parent	string	分组的code
2	$code	string	该配置信息的唯一标识
3	$value	string	该配置信息值
4	$options	array	其他项

ecjia_config::instance()->insert_config($parent, $code, $value, $options = array())
```

8、delete_config()

删除配置项
```
1	$name	string	配置项名称

ecjia_config::instance()->delete_config($name)
```

9、get_addon_config()

获取插件的配置项
```
1	$code	string	插件代码
2	$unserialize	boolean	是否序列化
3	$use_platform	boolean	是否使用平台

ecjia_config::instance()->get_addon_config($code, $unserialize = false, $use_platform = false)
```

10、set_addon_config()

更新插件的配置项
```
1	$code	string	插件代码
2	$unserialize	boolean	是否序列化
3	$use_platform	boolean	是否使用平台

ecjia_config::instance()->set_addon_config($code, $value, $serialize = false, $use_platform = false)
```
