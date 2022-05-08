### Ecjia后台ecjia_region使用说明

#### 方法列表

| 编号 |         方法名          |                     简单描述                     |
| :--: | :---------------------: | :----------------------------------------------: |
|  1   |    defaultCountry()     |              获取当前国家代号 如CN               |
|  2   |  defaultCountryName()   |                 获取当前国家名称                 |
|  3   |    getCountryName()     |                   获取国家名称                   |
|  4   |     getProvinces()      |                 获取所有省份地区                 |
|  5   |      getSubarea()       |             获取指定城市的下一级地区             |
|  6   |       getRegion()       |                   获取地区信息                   |
|  7   |     getRegionName()     |                   获取地区名称                   |
|  8   |      getRegions()       |                 获取多个地区信息                 |
|  9   |   getRegionsByType()    | 获取地区信息，只能获取3级（含3级）以下的所有地区 |
|  10  |  getRegionsBySearch()   |   获取地区信息，根据城市名称搜索匹配的所有地区   |
|  11  | getSplitRegionWithKey() |         获取指定字符串的5级地区信息数组          |
|  12  |    getSplitRegion()     |                获取分割后地区数组                |

#### 方法详细说明

1、defaultCountry()

- 获取当前国家代号 如CN

```
ecjia_region::defaultCountry();
```

2、defaultCountryName()

- 获取当前国家名称

```
ecjia_region::defaultCountryName();
```

3、getCountryName()

- 获取国家名称

```
ecjia_region::getCountryName($country);
```

| 1    | $country | string | 国家代号 如CN |
| ---- | -------- | ------ | ------------- |
|      |          |        |               |

4、getProvinces()

- 获取所有省份地区

```
ecjia_region::getProvinces();
```

5、getSubarea()

- 获取指定城市的下一级地区

```
ecjia_region::getSubarea($regionId);
```

| 1    | $regionId | string | 地区代号 如CN1101 |
| ---- | --------- | ------ | ----------------- |
|      |           |        |                   |

6、getRegion()

- 获取地区信息

```
ecjia_region::getRegion($regionId);
```

| 1    | $regionId | string | 地区代号 如CN1101 |
| ---- | --------- | ------ | ----------------- |
|      |           |        |                   |

7、getRegionName()

- 获取地区名称

```
ecjia_region::getRegionName($regionId);
```

| 1    | $regionId | string | 地区代号 如CN1101 |
| ---- | --------- | ------ | ----------------- |
|      |           |        |                   |

8、getRegions()

- 获取多个地区信息

```
ecjia_region::getRegions($regionIds);
```

| 1    | $regionIds | array | 地区代号数组 |
| ---- | ---------- | ----- | ------------ |
|      |            |       |              |

9、getRegionsByType()

- 获取地区信息，只能获取3级（含3级）以下的所有地区

```
ecjia_region::getRegionsByType($type);
```

| 1    | $type | int  | 区域类型 |
| ---- | ----- | ---- | -------- |
|      |       |      |          |

10、getRegionsBySearch()

- 获取地区信息，只能获取3级（含3级）以下的所有地区

```
ecjia_region::getRegionsByType($name, $type = null);
```

| 1    | $name | string | 要搜索的区域名称 |
| ---- | ----- | ------ | ---------------- |
| 2    | $type | int    | 区域类型         |

11、getSplitRegionWithKey()

- 获取指定字符串的5级地区信息数组

```
ecjia_region::getSplitRegionWithKey($regionId);
```

| 1    | $regionId | string | 地区代号 如CN1101 |
| ---- | --------- | ------ | ----------------- |
|      |           |        |                   |

12、getSplitRegion()

- 获取分割后地区数组

```
ecjia_region::getSplitRegion($regionId);
```

| 1    | $regionId | string | 地区代号 如CN1101 |
| ---- | --------- | ------ | ----------------- |
|      |           |        |                   |