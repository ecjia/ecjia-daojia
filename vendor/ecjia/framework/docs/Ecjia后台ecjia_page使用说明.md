### Ecjia后台ecjia_page使用说明

#### 方法列表

| 编号 |  方法名称   |   简单描述   |
| :--: | :---------: | :----------: |
|  1   |    pre()    |    上一页    |
|  2   |   next()    |    下一页    |
|  3   | text_list() | 文字页码列表 |
|  4   | pic_list()  | 图标页码列表 |
|  5   |  select()   |   选项列表   |
|  6   |   input()   |    输入框    |
|  7   |   pres()    |    前几页    |
|  8   |   nexts()   |    后几页    |
|  9   |   first()   |     首页     |
|  10  |    end()    |     末页     |
|  11  | now_page()  |  当前页记录  |
|  12  |   count()   |  count统计   |
|  13  | page_desc() | 分页文字描述 |
|  14  |   show()    |   显示页码   |

#### 方法详细说明

14、show()

- 显示页码

```
 public function show($style = '', $page_row = null)
```

| 1    | $style    | string | 风格         |
| ---- | --------- | ------ | ------------ |
| 2    | $page_row | string | 页码显示行数 |