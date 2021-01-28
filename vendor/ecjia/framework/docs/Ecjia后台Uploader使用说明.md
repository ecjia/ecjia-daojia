### Ecjia后台Uploader使用说明

#### 方法列表

| 编号 |      方法名称       |            简单描述            |
| :--: | :-----------------: | :----------------------------: |
|  1   |      upload()       |          上传单个文件          |
|  2   |   batch_upload()    |            批量上传            |
|  3   | check_upload_file() |         检查上传的文件         |
|  4   |   allowed_type()    |     设定允许添加的文件类型     |
|  5   |   allowed_mime()    |       允许的文件MIME类型       |
|  6   |   allowed_size()    |           允许的大小           |
|  7   |   get_position()    |       获取指定的文件Path       |
|  8   |      remove()       |          删除指定文件          |
|  9   |   upload_single()   |          单个文件上传          |
|  10  |       save()        |          保存指定文件          |
|  11  |   format_files()    |    将上传文件整理为标准数组    |
|  12  |     check_ext()     |   检查上传的文件后缀是否合法   |
|  13  |    check_size()     |      检查文件大小是否合法      |
|  14  |    check_mime()     | 检查上传的文件MIME类型是否合法 |

#### 方法详细说明

- 调用uploader方法，调用示例：

```
$upload = RC_Upload::uploader('image', array('save_path' => 'data/image', 'auto_sub_dirs' => false));
```

1、upload()

- 上传单个文件
- return array 上传成功后的文件信息

```
$upload->upload($file);
```

| 1    | $file | array | 文件数组 |
| ---- | ----- | ----- | -------- |
|      |       |       |          |

2、batch_upload()

- 批量上传文件

```
$upload->batch_upload($files);
```

| 1    | $files | array | 文件信息数组，通常是 $_FILES数组 |
| ---- | ------ | ----- | -------------------------------- |
|      |        |       |                                  |

3、check_upload_file()

- 检查上传的文件

```
$upload->check_upload_file($file);
```

| 1    | $file | array | 文件数组 |
| ---- | ----- | ----- | -------- |
|      |       |       |          |

4、allowed_type()

- 设定允许添加的文件类型

```
$upload->allowed_type($type);
```

| 1    | $type | string | 文件类型，（小写）示例：gif,jpg,jpeg,png |
| ---- | ----- | ------ | ---------------------------------------- |
|      |       |        |                                          |

5、allowed_mime()

- 允许的文件MIME类型

```
$upload->allowed_mime($mime);
```

| 1    | $mime | string | 文件mime类型，示例：'image/jpeg', 'image/png', 'image/gif', 'image/x-png', 'image/pjpeg' |
| ---- | ----- | ------ | ------------------------------------------------------------ |
|      |       |        |                                                              |

6、allowed_size()

- 允许的大小

```
$upload->allowed_size($size);
```

| 1    | $size | int  | 单位kb |
| ---- | ----- | ---- | ------ |
|      |       |      |        |

7、get_position()

- 获取指定文件的path

```
$upload->get_position($info, $relative=true);
```

| 1    | $info     | array | 文件信息数组 |
| ---- | --------- | ----- | ------------ |
| 2    | $relative | bool  | 是否相对     |

8、remove()

- 删除指定的文件

```
$upload->remove($file);
```

| 1    | $info | array | 上传目录的文件相对路径 |
| ---- | ----- | ----- | ---------------------- |
|      |       |       |                        |

9、upload_single()

- 单个文件上传

```
$upload->upload_single($file);
```

| 1    | $file | array | 文件数组 |
| ---- | ----- | ----- | -------- |
|      |       |       |          |

10、save()

- 保存指定的文件

```
$upload->save($file, $replace = true);
```

| 1    | $info    | array | 保存的文件信息   |
| ---- | -------- | ----- | ---------------- |
| 1    | $replace | bool  | 同名文件是否覆盖 |

11、format_files()

- 将上传文件整理为标准数组

```
$upload->format_files($files);
```

| 1    | $files | array | 文件信息 |
| ---- | ------ | ----- | -------- |
|      |        |       |          |

12、check_ext()

- 检查上传的文件后缀是否合法

```
$upload->check_ext($file);
```

| 1    | $ext | string | 后缀 |
| ---- | ---- | ------ | ---- |
|      |      |        |      |

13、check_size()

- 检查文件大小是否合法

```
$upload->check_size($file);
```

| 1    | $size | int  | 单位kb |
| ---- | ----- | ---- | ------ |
|      |       |      |        |

14、check_mime()

- 检查文件大小是否合法

```
$upload->check_mime($mime);
```

| 1    | $mime | string | mime类型 |
| ---- | ----- | ------ | -------- |
|      |       |        |          |