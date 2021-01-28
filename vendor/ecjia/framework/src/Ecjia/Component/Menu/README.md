[Ecjia Component] ecjia-menu 
==============

ecjia-menu组件是用来生产菜单的管理对象，用于全站菜单对象的生成，支持可配置参数，对象化管理，方便数据调用。

- [创建菜单](#创建菜单)
- [绑定权限](#绑定权限)
  - [1. 添加权限](#1-添加权限)
  - [2. 移除权限](#2-移除权限)
  - [3. 查看权限](#3-查看权限)
- [添加子菜单](#添加子菜单)
  - [1. 添加子菜单](#1-添加子菜单)
  - [2. 移除子菜单](#2-移除子菜单)
  - [3. 查看所有子菜单](#3-查看所有子菜单)
  - [4. 判断是否含有子菜单](#4-判断是否含有子菜单)



## 创建菜单 

#### 方法一
最简单的创建菜单方式，就是直接实例化对象，只需要传递三个参数。
* $action 是菜单的一个标识符；
* $name 是菜单用于显示的名字；
* $link 是菜单的一个链接；
```$php
$menu = new Ecjia\Component\Menu($action, $name, $link);
```

如果想指定菜单的排序，可以使用第四个参数：
* $sort 是菜单的排序值，默认值是99。
```$php
$menu = new Ecjia\Component\Menu($action, $name, $link, $sort);
```

如果想指定菜单的打开方式，可以使用第五个参数：
* $target 是菜单的链接打开方式，如_self, _blank; 默认值是_self。
```$php
$menu = new Ecjia\Component\Menu($action, $name, $link, $sort， $target);
```
#### 方法二
别名类使用 `admin_menu`，参数一样：
```$php
$menu = new admin_menu($action, $name, $link, $sort， $target)
```

#### 方法三
`ecjia_admin::make_admin_menu` 静态方法类方便创建，参数一样：
```$php
$menu = ecjia_admin::make_admin_menu($action, $name, $link, $sort， $target)
```



## 绑定权限

### 1. 添加权限

#### 方法一

设置权限项，参数数组，一个权限值，也是数组传入，拥有该权限项的用户才可看见此菜单。
```$php
// 绑定一个权限项 goods_manager
$menu->setPurviews(['goods_manager']);

// 绑定两个权限项 goods_manager、orders_manager
$menu->setPurviews(['goods_manager', 'orders_manager']);
```

#### 方法二
添加单个权限项，到菜单已经绑定的权限组中，传入字符串或数组即可：
```$php
// 添加一个权限项
$menu->addPurview('goods_manager');

// 添加多个权限项
$menu->addPurview(['goods_manager', 'orders_manager']);
```

### 2. 移除权限
移除菜单不需要的权限，很简单
```$php
// 移除一个权限项
$menu->removePurview('goods_manager');
```

### 3. 查看权限
获取菜单绑定的所有权限项，无参数传入，获取的是一个权限项的数组。
```$php
$menu->getPurviews();
```



## 添加子菜单

### 1. 添加子菜单

#### 方法一
子菜单的创建跟普通菜单的创建方法是一样的，只是子菜单需要添加到某个主菜单上。
一次性设置所有的子菜单。
```$php
$menu->setSubmenus([
    new Ecjia\Component\Menu($action, $name, $link),
    new Ecjia\Component\Menu($action, $name, $link),
]);
```

#### 方法二
向已经存在的子菜单补充新的子菜单，可以使用`addSubmenus`方法。
```$php
// 追加单个子菜单
$menu->addSubmenus(new Ecjia\Component\Menu($action, $name, $link));

// 追加多个子菜单
$menu->addSubmenus([
    new Ecjia\Component\Menu($action, $name, $link),
    new Ecjia\Component\Menu($action, $name, $link),
]);
```
### 2. 移除子菜单
移除菜单不需要的子菜单，很简单，传入子菜单对象。
```$php
// 移除一个子菜单
$menu->removeSubmenu($submenu);
```

### 3. 查看所有子菜单
获取菜单绑定的所有子菜单，无参数传入，获取的是一个子菜单的数组。
```$php
$menu->getSubmenus();
```

### 4. 判断是否含有子菜单
判断菜单是否含有子菜单，只需要调用`hasSubmenus`方法。
```$php
$menu->hasSubmenus();
```