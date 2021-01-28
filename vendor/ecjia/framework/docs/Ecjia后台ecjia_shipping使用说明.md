### Ecjia后台ecjia_shipping使用说明

#### 方法列表

| 编号 |            方法名            |                  简单描述                  |
| :--: | :--------------------------: | :----------------------------------------: |
|  1   |       getEnableList()        |       获取数据库中启用的配送插件列表       |
|  2   |     getPluginDataById()      |       通过ID获取数据库中配送插件数据       |
|  3   |    getPluginDataByCode()     |      通过code获取数据库中配送插件数据      |
|  4   |    getPluginDataByName()     |      通过name获取数据库中配送插件数据      |
|  5   |         configData()         |     获取数据中的Config配置数据，并处理     |
|  6   |       defaultChannel()       |              获取默认插件实例              |
|  7   |          channel()           |           获取某个插件的实例对象           |
|  8   |        areaChannel()         |       获取指定配送区域插件的实例对象       |
|  9   |         pluginData()         |              取得配送方式信息              |
|  10  |            fee()             |                  计算运费                  |
|  11  |         insureFee()          |           获取指定配送的保价费用           |
|  12  |   availableUserShippings()   |         取得用户可用的配送方式列表         |
|  13  | availableMerchantShippings() |         取得商家可用的配送方式列表         |
|  14  |        shippingArea()        | 取得某配送方式对应于指定收货地址的区域信息 |

#### 方法详细说明

1、getEnableList()

- 获取数据库中启用的插件列表

```
ecjia_shipping::getEnableList();
```

2、getPluginDataById()

- 通过ID获取数据库中配送插件数据

```
ecjia_shipping::getPluginDataById($id);
```

| 1    | $id  | int  | 配送id |
| ---- | ---- | ---- | ------ |
|      |      |      |        |

3、getPluginDataByCode()

- 通过code获取数据库中配送插件数据

```
ecjia_shipping::getPluginDataByCode($code);
```

| 1    | $code | string | 配送方式代码 |
| ---- | ----- | ------ | ------------ |
|      |       |        |              |

4、getPluginDataByName()

- 通过name获取数据库中配送插件数据

```
ecjia_shipping::getPluginDataByName($name);
```

| 1    | $name | string | 配送方式名称 |
| ---- | ----- | ------ | ------------ |
|      |       |        |              |

5、configData()

- 获取数据中的Config配置数据，并处理

```
ecjia_shipping::configData($code);
```

| 1    | $code | string | 配送方式代码 |
| ---- | ----- | ------ | ------------ |
|      |       |        |              |

6、defaultChannel()

- 获取默认插件实例

```
ecjia_shipping::defaultChannel();
```

7、channel()

- 获取某个插件的实例对象

```
ecjia_shipping::channel($code);
```

| 1    | $code | string/int | 类型为string时是配送方式code，类型是int时是配送方式id |
| ---- | ----- | ---------- | ----------------------------------------------------- |
|      |       |            |                                                       |

8、areaChannel()

- 获取指定配送区域插件的实例对象

```
ecjia_shipping::areaChannel($areaId);
```

| 1    | $areaId | int  | 配送区域id |
| ---- | ------- | ---- | ---------- |
|      |         |      |            |

9、pluginData()

- 取得配送方式信息

```
ecjia_shipping::pluginData($shippingCode);
```

| 1    | $shippingCode | string | 配送方式代码 |
| ---- | ------------- | ------ | ------------ |
|      |               |        |              |

10、fee()

- 计算运费

```
ecjia_shipping::fee($areaId, $goodsWeight, $goodsAmount, $goodsNumber);
```

| 1    | $areaId      | int   | 配送区域id |
| ---- | ------------ | ----- | ---------- |
| 2    | $goodsWeight | float | 商品重量   |
| 3    | $goodsAmount | float | 商品金额   |
| 4    | $goodsNumber | float | 商品数量   |

11、insureFee()

- 获取指定配送的保价费用

```
ecjia_shipping::insureFee($shippingCode, $goodsAmount, $insure);
```

| 1    | $shippingCode | string | 配送方式代码 |
| ---- | ------------- | ------ | ------------ |
| 2    | $goodsAmount  | float  | 保价金额     |
| 3    | $insure       | mix    | 保价比例     |

12、availableUserShippings()

- 取得用户可用的配送方式列表

```
ecjia_shipping::availableUserShippings($region_id, $store_id);
```

| 1    | $region_id | string | 区域代号 |
| ---- | ---------- | ------ | -------- |
| 2    | $store_id  | int    | 店铺id   |

13、availableMerchantShippings()

- 取得商家可用的配送方式列表

```
ecjia_shipping::availableMerchantShippings($region_id, $store_id);
```

| 1    | $region_id | string | 区域代号 |
| ---- | ---------- | ------ | -------- |
| 2    | $store_id  | int    | 店铺id   |

14、shippingArea()

- 取得某配送方式对应于指定收货地址的区域信息

```
ecjia_shipping::shippingArea($shippingCode, $region_id, $store_id);
```

| 1    | $shippingCode | string | 配送方式代码 |
| ---- | ------------- | ------ | ------------ |
| 2    | $region_id    | string | 区域代号     |
| 3    | $store_id     | int    | 店铺id       |