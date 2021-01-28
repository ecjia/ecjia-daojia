### Ecjia产品term关联表使用情况说明

[跳到导航](http://wiki.shangchina.com/index.php?title=Ecjia产品term关联表使用情况说明#mw-head)[跳到搜索](http://wiki.shangchina.com/index.php?title=Ecjia产品term关联表使用情况说明#p-search)

#### term_meta[[编辑](http://wiki.shangchina.com/index.php?title=Ecjia产品term关联表使用情况说明&action=edit&section=1)]

|   object_type   |    object_group    |    object_id     |          meta_key          |       meta_value       |             描述             |  使用情况  |
| :-------------: | :----------------: | :--------------: | :------------------------: | :--------------------: | :--------------------------: | :--------: |
|   ecjia.user    |        user        |   变量:user_id   | signup_reward_receive_time |      变量:时间戳       |   新人有礼领取红包时间存储   |    o2o     |
| ecjia.affiliate |  user_invite_code  |   变量:user_id   |        invite_code         |       变量:code        |        用户推荐码存储        | b2c，b2b2c |
|  ecjia.article  |      article       | 变量:article_id  |          变量:key          |       变量:value       |      文章设置自定义栏目      | b2c，b2b2c |
|   ecjia.goods   |       goods        |  变量:goods_id   |          变量:key          |       变量:value       |      商品设置自定义栏目      | b2c，b2b2c |
|   ecjia.order   |       order        |  变量:order_id   |    receipt_verification    |    变量:收货验证码     |  下单付款后获取的收货验证码  | b2c，b2b2c |
|   ecjia.goods   | goods_bonus_coupon |  变量:goods_id   |       bonus_type_id        | 变量:红包id（type_id） | 优惠券限定商品时绑定的商品id |    b2c     |
|   ecjia.goods   |      category      | 变量:category_id |        category_img        |     变量:分类图片      |      商品分类的图片信息      |    b2c     |
|   ecjia.goods   |   category_image   | 变量:category_id |          tv_image          |     变量:分类图片      |      商品分类的图片信息      |    b2c     |
|   ecjia.goods   |       goods        |  变量:goods_id   |        sales_volume        |     变量:销量数字      |         商品销量统计         |    b2c     |
|   ecjia.goods   |      category      | 变量:category_id |        category_ad         |     变量:广告位id      |        商品分类广告位        |    o2o     |

#### term_relationship[[编辑](http://wiki.shangchina.com/index.php?title=Ecjia产品term关联表使用情况说明&action=edit&section=2)]

|  object_type   | object_group |  object_id  | item_key1 |  item_value1  |  item_key2   |                   item_value2                    | item_key3 |    item_value3    | item_key4 | item_value4 |         描述         |    使用情况     |
| :------------: | :----------: | :---------: | :-------: | :-----------: | :----------: | :----------------------------------------------: | :-------: | :---------------: | :-------: | :---------: | :------------------: | :-------------: |
| ecjia.merchant |   merchant   | 变量:ru_id  | longitude |   变量:经度   |   latitude   |                    变量:纬度                     |  geohash  | 变量:geohash_code |           |             | 储存入驻商经纬度信息 |      b2b2c      |
| ecjia.payment  |    paylog    | 变量:log_id | order_sn  | 变量:订单编号 | out_trade_no | 变量:订单编号+log_id（用于提交第三方的交易编号） |           |                   |           |             |   储存交易日志信息   | b2c，b2b2c，o2o |

#### term_attachment