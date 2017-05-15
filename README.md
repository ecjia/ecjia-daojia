ECJia到家
===

开发语言：PHP

数据库：MySQL

开发框架：ecjia

模板引擎：smarty

Github: https://github.com/ecjia/ecjia-daojia

官方网站
===

官方网站：https://ecjia.com

专题介绍：https://ecjia.com/daojia.html

帮助文档：https://ecjia.com/wiki/

演示网站：https://cityo2o.ecjia.com

ECJia到家官方交流QQ群：***372623746***


简介
===

EC+（ecjia）到家是由上海商创网路科技有限公司推出的，一款可开展O2O业务的移动电商
系统。它包含：移动端APP，采用原生模式开发，覆盖使用iOS及Android系统的移
动终端；后台系统，针对平台日常运营维护的平台后台，针对入驻店铺管理的商家
后台，独立并行；移动端H5，能够灵活部署于微信及其他APP、网页等。官方网址：[https://ecjia.com](https://ecjia.com)。

ECJia到家是一款符合当下及未来发展的新电商系统，主打三个新：新模式，新框架，
新技术。

* **【新模式】**结合线上线下互通，LBS定位，最后一公里配送，完美打造到店+到家+配
送+商家入驻，一体化的零售与服务平台，满足新零售，商圈业态，同城电商浪潮，
最终打造成**B2B2C+O2O**商业生态；
* **【新框架】**模板堂10年底层框架开发经验，专为电商打造的EC+框架，包含：核心层，
系统层，应用层，插件层，主题层，五层架构，满足可扩展性与模块化，组件化开发
模式，未来将与百万开发者合作共赢；
* **【新技术】**EC+专注移动互联网，通过原生App与微商城双轨驱动，多端同步，数据完
美对接，通过不断更新迭代的技术来驱动电商行业未来。

五层架构
===

* **【核心层】**核心层是EC+的核心驱动，集成基础PHP函数、Composer组件的封装，支持缓存机制、多驱动机制、多数据源连接、多国语言方案、Hook机制、OSS云存储、Memcache、Redis。
* **【系统层】**系统层是EC+的模块化扩展机制的核心，驱动着EC+所有应用和插件的调度与扩展。
* **【应用层】**应用层是EC+的业务的分离后的模块，每个应用对应一个业务模块，可以根据需求无限的扩展应用，后台可轻易安装、卸载、移除应用。
* **【插件层】**插件层是EC+的业务的扩展，根据业务的不同场景下的需求不同，可以轻松通过插件对应用的扩展进行业务逻辑补充。后台可轻易安装、卸载、移除插件。
* **【主题层】**主题层是EC+的对外前端界面，通过**“主题框架”**展示多样的前面功能，推出了颠覆性的模块制作方式，秉承**“界面决定业务功能”**架构方式，可以满足你任何一款模板的制作，没有任何限制。后台可轻易安装、卸载、移除主题。

框架特性
===

- 灵活和完善的角色权限控制体系，权限粒度支持到方法的权限设置。
- 支持RBAC（基于角色的权限设计）和UBAC（基于用户的权限设计）
- 全部模块化的功能应用机制，可单独安装卸载单个应用
- 随意可扩展功能和完善的插件机制
- 缓存支持-提供包括文件、数据库、Memcache、Redis等多种类型的缓存支持
- Session支持，提供包括文件、数据库、Memcache、Redis等多种类型的Session存储
- 强大的Hook机制，轻松植入，轻松调用
- 支持Gettext国际化的多语言方案

应用列表
===

<table style="width:100%;text-align:center;border-radius:10px;">
   <tr>
      <td width="15%">应用名称</td>
      <td width="10%">版本</td>
      <td width="5%">目录</td>
      <td width="10%">ID</td>
      <td width="50%">描述</td>
      <td width="10%">备注</td>
   </tr>
   <tr>
      <td>账号链接</td>
      <td>1.2.0</td>
      <td>connect</td>
      <td>ecjia.connect</td>
      <td>使用第三方帐号登录功能，第三方登录插件管理与控制。</td>
      <td></td>
   </tr>
   <tr>
      <td>公众平台</td>
      <td>1.1.0</td>
      <td>platform</td>
      <td>ecjia.platform</td>
      <td>使用公众平台对企业公众号进行管理</td>
      <td></td>
   </tr>
   <tr>
      <td>微信公众</td>
      <td>1.1.0</td>
      <td>wechat</td>
      <td>ecjia.wechat</td>
      <td>使用公众平台对微信公众号进行管理</td>
      <td></td>
   </tr>
   <tr>
      <td>日志查找</td>
      <td>1.0.0</td>
      <td>logviewer</td>
      <td>ecjia.logviewer</td>
      <td>无需在再一级一级找到日志文件打开进行查看了，该应用把所有的日志文件分类详细的排列出来，方便用户查看。</td>
      <td></td>
   </tr>
   <tr>
      <td>消息推送</td>
      <td>1.3.0</td>
      <td>push</td>
      <td>ecjia.push</td>
      <td>消息推送应用是手机端应用的消息推送在后台的管理与发送，通过定期传送用户需要的信息来减少信息过载，减少用于网络上搜索的时间。</td>
      <td></td>
   </tr>
   <tr>
      <td>短信</td>
      <td>1.3.0</td>
      <td>sms</td>
      <td>ecjia.sms</td>
      <td>短信是最直接又不会过分影响消费者的信息推送方式，商家可以查看、管理短信记录，用短信模板更便捷编辑短信，自主配置短信相关设置，享受完善的短信解决方案。</td>
      <td></td>
   </tr>
   <tr>
      <td>移动应用</td>
      <td>1.3.0</td>
      <td>mobile</td>
      <td>ecjia.mobile</td>
      <td>针对移动应用对其基本参数、规则进行快捷设置，便捷商家操作流程的无线管理的应用，常规整合整合、告别繁琐。</td>
      <td></td>
   </tr>
   <tr>
      <td>推荐分成</td>
      <td>1.3.0</td>
      <td>affiliate</td>
      <td>ecjia.mobile</td>
      <td>访问者点击某推荐人的网址后，在此时间段内注册、下单，均认为是该推荐人的所介绍的，进行奖励</td>
      <td></td>
   </tr>
   <tr>
      <td>H5应用</td>
      <td>1.0.0</td>
      <td>touch</td>
      <td>ecjia.touch</td>
      <td>采用APP方式设计，标准通用标记语言下的一个应用超文本标记语言(HTML)重大突破。</td>
      <td></td>
   </tr>
   <tr>
      <td>PC站入口</td>
      <td>2.1.0</td>
      <td>main</td>
      <td>ecjia.main</td>
      <td>ECJia在PC端展示的主应用，主要是App的功能介绍，截图展示，提供二维码下载。</td>
      <td></td>
   </tr>
   <tr>
      <td>配送信息</td>
      <td>1.0.0</td>
      <td>express</td>
      <td>ecjia.express</td>
      <td></td>
      <td></td>
   </tr>
   <tr>
      <td>开店向导</td>
      <td>1.0.0</td>
      <td>shopguide</td>
      <td>ecjia.shopguide</td>
      <td></td>
      <td></td>
   </tr>
   <tr>
      <td>安装器</td>
      <td>1.0.0</td>
      <td>installer</td>
      <td>ecjia.installer</td>
      <td>用来安装ECJia项目的安装器。</td>
      <td></td>
   </tr>
   <tr>
      <td>优惠活动</td>
      <td>1.3.0</td>
      <td>favorable</td>
      <td>ecjia.favorable</td>
      <td>优惠活动，主要回馈网站用户。为确保更多消费者享受到优惠，活动将分期举行。</td>
      <td></td>
   </tr>
   <tr>
      <td>促销商品</td>
      <td>1.1.0</td>
      <td>promotion</td>
      <td>ecjia.promotion</td>
      <td>促销方式，ECJia整合折扣购买、购买赠送、互动抽奖、关联促销、积分、团购等多种促销方式，充分发挥促销市场价值，帮助商家通过促销实现全面、长远的销售目标。</td>
      <td></td>
   </tr>
   <tr>
      <td>API接口</td>
      <td>2.1.0</td>
      <td>api</td>
      <td>ecjia.api</td>
      <td>ECJia API具备分享、标准、去中心化、开放、模块化特点，集成ECJia、耦合移动应用、第三方应用，向开发者提供接口标准供其使用开发，通过开放API来让ECJIA拥有更大的用户群和访问量。</td>
      <td></td>
   </tr>
   <tr>
      <td>配送方式</td>
      <td>1.3.0</td>
      <td>shipping</td>
      <td>ecjia.shipping</td>
      <td>商品配送是商家与顾客交付产品的方式，ECJIA团队开发配送方式插件，为商家带来更便捷操作，商家可对物流配送进行快捷编辑，报价费用，一键切换是否启用，打印等，配置添加配送区域。</td>
      <td></td>
   </tr>
   <tr>
      <td>商家入驻</td>
      <td>1.3.0</td>
      <td>franchisee</td>
      <td>ecjia.franchisee</td>
      <td></td>
      <td></td>
   </tr>
   <tr>
      <td>商家结算</td>
      <td>1.0.0</td>
      <td>commission</td>
      <td>ecjia.commission</td>
      <td>商家查询结算账单和结算明细</td>
      <td></td>
   </tr>
   <tr>
      <td>红包类型</td>
      <td>1.0.0</td>
      <td>bonus</td>
      <td>ecjia.bonus</td>
      <td>红包是为商家提供的增值服务，用于商品交易的虚拟优惠券。遵循管理简单简单、方式多样原则设计，商家可以自行控制优惠金额，运用多种方式给客户发放红包，。</td>
      <td></td>
   </tr>
   <tr>
      <td>我的店铺</td>
      <td>1.1.2</td>
      <td>merchant</td>
      <td>ecjia.merchant</td>
      <td>我的店铺，可以进行设置店铺基本信息、橱窗、导航栏以及自定义设置，让商家更好展示自身，让消费者更快找到心仪商品。</td>
      <td></td>
   </tr>
   <tr>
      <td>购物车</td>
      <td>1.0.0</td>
      <td>cart</td>
      <td>ecjia.cart</td>
      <td>购物车，顾客用于暂时或长期存放所选商品，对商品进行、增、删、改、查操作，集成购物和订单结算（选支付方式、收货地址、配送方式等）。</td>
      <td></td>
   </tr>
   <tr>
      <td>员工管理</td>
      <td>1.1.2</td>
      <td>staff</td>
      <td>ecjia.staff</td>
      <td>对商家后台每个员工进行管理以及分配权限。</td>
      <td></td>
   </tr>
   <tr>
      <td>广告</td>
      <td>1.3.0</td>
      <td>adsense</td>
      <td>ecjia.adsense</td>
      <td>广告是随着人类经济活动的发展而产生并不断更新；广告提高企业竞争实力促进企业经济效益的作用；广告对于消费者消费观念，消费心理和消费行为的趋向具有导引作用。</td>
      <td></td>
   </tr>
   <tr>
      <td>设置</td>
      <td>2.1.0</td>
      <td>setting</td>
      <td>ecjia.setting</td>
      <td>我们可以完成商店的几乎所有的设置，包括的设置有网店信息基本设置、显示设置、购物流程、商品显示设置 等，这个部分可以说是网店系统的核心配置。</td>
      <td></td>
   </tr>
   <tr>
      <td>报表统计</td>
      <td>1.3.0</td>
      <td>stats</td>
      <td>ecjia.stats</td>
      <td>报表统计是商城管理、发展分析的重要功能，进行流量分析，客户、订单统计，可查看销售概况、会员排行、销售明细/排行等，为商城的规划、建设提供数据支撑。</td>
      <td></td>
   </tr>
   <tr>
      <td>支付方式</td>
      <td>1.3.0</td>
      <td>payment</td>
      <td>ecjia.payment</td>
      <td>为更高效的管理支付方式，ECJIA将支付方式作为应用，每个不同支付方式则是一个插件，商家可以对支付方式进行启用、停用、费用编辑等。</td>
      <td></td>
   </tr>
   <tr>
      <td>文章</td>
      <td>1.3.0</td>
      <td>article</td>
      <td>ecjia.article</td>
      <td>文章管理涉及文章编写和发布文章，多个模块和应用的软文撰写发布，是系统不可缺少的软文管理应用，提供文章分类、列表、网店帮助、网店信息等核心功能。</td>
      <td></td>
   </tr>
   <tr>
      <td>计划任务</td>
      <td>1.3.0</td>
      <td>cron</td>
      <td>ecjia.cron</td>
      <td>是ECJIA管理系统提供的一项使系统在您设定的时刻,自动执行某项任务的功能。</td>
      <td></td>
   </tr>
   <tr>
      <td>商品</td>
      <td>1.0.0</td>
      <td>goods</td>
      <td>ecjia.goods</td>
      <td>商品应用，含商品添加、商品编辑、商品组合、商品类型、商品分类等功能模块，通过高效便捷操作管理，保证商城营销/促销活动开展，及时向顾客提供满意商品，达成既定销售目标。</td>
      <td></td>
   </tr>
   <tr>
      <td>入驻商管理</td>
      <td>1.0.0</td>
      <td>store</td>
      <td>ecjia.store</td>
      <td>管理多个商家。</td>
      <td></td>
   </tr>
   <tr>
      <td>订单</td>
      <td>1.0.0</td>
      <td>orders</td>
      <td>ecjia.orders</td>
      <td>订单应用，含订单处理，订单确认，订单添加、订单状态管理等模块；与库存管理连接，订单库存数据同步；与会员管理连接，可查询订单历史及执行情况，将处理信息反馈给用户。</td>
      <td></td>
   </tr>
   <tr>
      <td>推荐分成</td>
      <td>1.3.0</td>
      <td>affiliate</td>
      <td>ecjia.affiliate</td>
      <td>推荐分成，访问者点击某推荐人的网址后，在此时间段内注册、下单，均认为是该推荐人的所介绍的，可以获取一定的奖励。</td>
      <td></td>
   </tr>
   <tr>
      <td>轮播图</td>
      <td>1.2.0</td>
      <td>cycleimage</td>
      <td>ecjia.cycleimage</td>
      <td>轮播图是电商时代必备的广告工具，轮播图应用提供图片、flash、代码、文字类型的广告设置，可选择系统默认或自定义设置，并实时点击预览实际效果。</td>
      <td></td>
   </tr>
   <tr>
      <td>通知</td>
      <td>1.0.0</td>
      <td>notification</td>
      <td>ecjia.notification</td>
      <td>通知描述</td>
      <td></td>
   </tr>
   <tr>
      <td>邮件</td>
      <td>1.3.0</td>
      <td>mail</td>
      <td>ecjia.mail</td>
      <td>邮件应用，针对商城用户对商品订阅、关注来接收最新邮件动态，商家通过邮件向全体、指定用户群发促销，打折，红包、杂志等促销信息，管理监控邮件发送的过程。</td>
      <td></td>
   </tr>
   <tr>
      <td>会员</td>
      <td>1.0.0</td>
      <td>user</td>
      <td>ecjia.user</td>
      <td>会员应用，统计并储存管理会员信息，实现对会员资料、会员订单、充值/提现、注册项等方面的有效管理。</td>
      <td></td>
   </tr>
   <tr>
      <td>验证码</td>
      <td>1.3.0</td>
      <td>captcha</td>
      <td>ecjia.captcha</td>
      <td>验证码，提供安全防护作用，能有效防止恶意破解密码、刷票、论坛灌水、刷页等行为。可添加不同验证码实时点击预览效果，自定义验证码宽度、高度及验证码使用范围、机制等。</td>
      <td></td>
   </tr>
</table>

插件列表
===

<table style="width:100%;text-align:center;border-radius:10px;">
   <tr>
      <td width="25%">应用名称</td>
      <td width="10%">版本</td>
      <td width="10%">目录/ID</td>
      <td width="45%">描述</td>
      <td width="10%">备注</td>
   </tr>
   <tr>
      <td>EMS 国内邮政特快专递</td>
      <td>1.0.0</td>
      <td>ship_sms</td>
      <td>EMS 国内邮政特快专递描述内容</td>
      <td></td>
   </tr>
   <tr>
      <td>o2o速递</td>
      <td>1.0.0</td>
      <td>ship_o2o_express</td>
      <td>o2o速递</td>
      <td></td>
   </tr>
   <tr>
      <td>ROYALCMS验证码</td>
      <td>1.0.0</td>
      <td>scaptcha_royalcms</td>
      <td>ROYALCMS的验证码风格</td>
      <td></td>
   </tr>
   <tr>
      <td>UEditor富文本编辑器</td>
      <td>1.0.0</td>
      <td>ueditor</td>
      <td>UEditor富文本编辑器，来自百度编辑器</td>
      <td></td>
   </tr>
   <tr>
      <td>圆通速递</td>
      <td>1.0.0</td>
      <td>ship_yto</td>
      <td>上海圆通物流，多年快速发展，在中国速递行业中处于领先地位。</td>
      <td></td>
   </tr>
   <tr>
      <td>中通速递</td>
      <td>1.0.0</td>
      <td>ship_zto</td>
      <td>中通快递，保价费按照申报价值的2％交纳，保价费不低于100元，保价金额不得高于10000元，保价金额超过10000元的，超过的部分无效。</td>
      <td></td>
   </tr>
   <tr>
      <td>QQ帐号登录</td>
      <td>1.0.0</td>
      <td>sns_qq</td>
      <td>使用QQ第三方帐号登录。</td>
      <td></td>
   </tr>
   <tr>
      <td>余额支付</td>
      <td>1.0.0</td>
      <td>pay_balance</td>
      <td>使用帐户余额支付。只有会员才能使用，通过设置信用额度，可以透支。</td>
      <td></td>
   </tr>
   <tr>
      <td>微信帐号登录</td>
      <td>1.0.0</td>
      <td>sns_chat</td>
      <td>使用微信第三方帐号登录。</td>
      <td></td>
   </tr>
   <tr>
      <td>余额支付</td>
      <td>1.0.0</td>
      <td>pay_balance</td>
      <td>使用帐户余额支付。只有会员才能使用，通过设置信用额度，可以透支。</td>
      <td></td>
   </tr>
   <tr>
      <td>积分查询</td>
      <td>1.0.0</td>
      <td>mp_jfcx</td>
      <td>使用插件可以在微信上查询您的积分。</td>
      <td></td>
   </tr>
   <tr>
      <td>订单查询</td>
      <td>1.0.0</td>
      <td>mp_orders</td>
      <td>使用插件可以在微信上查询您的订单信息。</td>
      <td></td>
   </tr>
   <tr>
      <td>用户绑定</td>
      <td>1.0.0</td>
      <td>mp_uesrbind</td>
      <td>使用插件可以将微信公众平台用户绑定到本站会员上。</td>
      <td></td>
   </tr>
   <tr>
      <td>多客服转接</td>
      <td>1.0.0</td>
      <td>mp_kefu</td>
      <td>使用插件可以玩转客服。</td>
      <td></td>
   </tr>
   <tr>
      <td>刮刮卡</td>
      <td>1.0.0</td>
      <td>mp_ggk</td>
      <td>使用插件可以让微信公众平台用户参加刮刮卡活动。</td>
      <td></td>
   </tr>
   <tr>
      <td>大转盘</td>
      <td>1.0.0</td>
      <td>mp_dzp</td>
      <td>使用插件可以让微信公众平台用户参加大转盘活动。</td>
      <td></td>
   </tr>
   <tr>
      <td>砸金蛋</td>
      <td>1.0.0</td>
      <td>mp_zjd</td>
      <td>使用插件可以让微信公众平台用户参加砸金蛋活动。</td>
      <td></td>
   </tr>
   <tr>
      <td>签到</td>
      <td>1.0.0</td>
      <td>mp_checkin</td>
      <td>使用插件可以让微信公众平台用户签到获取积分。</td>
      <td></td>
   </tr>
   <tr>
      <td>浏览日志删除</td>
      <td>1.0.0</td>
      <td>cron_ipedl</td>
      <td>删除浏览日志</td>
      <td></td>
   </tr>
   <tr>
      <td>商品推荐</td>
      <td>1.0.0</td>
      <td>mp_goods</td>
      <td>商品推荐，获得商城的商品信息。</td>
      <td></td>
   </tr>
   <tr>
      <td>市内快递</td>
      <td>1.0.0</td>
      <td>ship_flat</td>
      <td>固定运费的配送方式内容</td>
      <td></td>
   </tr>
   <tr>
      <td>浏览日志删除</td>
      <td>1.0.0</td>
      <td>cron_ipedl</td>
      <td>删除浏览日志</td>
      <td></td>
   </tr>
   <tr>
      <td>计算器</td>
      <td>1.0.0</td>
      <td>calculator</td>
      <td>小巧、方便、功能强大的后台管理员使用的计算器。</td>
      <td></td>
   </tr>
   <tr>
      <td>货到付款</td>
      <td>1.0.0</td>
      <td>pay_cod</td>
      <td>需设置开通城市：×××货到付款区域：×××</td>
      <td></td>
   </tr>
   <tr>
      <td>微信支付</td>
      <td>2.0.0</td>
      <td>pay_wxpay</td>
      <td>微信支付(wx.qq.com) 是国内先进的网上支付平台。</td>
      <td></td>
   </tr>
   <tr>
      <td>运费到付</td>
      <td>1.0.0</td>
      <td>ship_fpd</td>
      <td>所购商品到达即付运费</td>
      <td></td>
   </tr>
   <tr>
      <td>支付宝</td>
      <td>2.0.0</td>
      <td>pay_alipay</td>
      <td>支付宝网站(www.alipay.com) 是国内先进的网上支付平台。支付宝收款接口：在线即可开通，零预付，免年费，单笔阶梯费率，无流量限制。</td>
      <td></td>
   </tr>
   <tr>
      <td>顺丰速运</td>
      <td>1.0.0</td>
      <td>ship_sf_express</td>
      <td>江、浙、沪地区首重15元/KG，续重2元/KG，其余城市首重20元/KG</td>
      <td></td>
   </tr>
   <tr>
      <td>申通快递</td>
      <td>1.0.0</td>
      <td>ship_sto_express</td>
      <td>江、浙、沪地区首重为15元/KG，其他地区18元/KG， 续重均为5-6元/KG， 云南地区为8元</td>
      <td></td>
   </tr>
   <tr>
      <td>测试计划任务</td>
      <td>1.0.0</td>
      <td>cron_testlog</td>
      <td>测试计划任务，生成日志</td>
      <td></td>
   </tr>
   <tr>
      <td>现金支付</td>
      <td>1.0.0</td>
      <td>pay_cash</td>
      <td>现金支付</td>
      <td></td>
   </tr>
   <tr>
      <td>自动处理</td>
      <td>1.0.0</td>
      <td>cron_auto_manage</td>
      <td>自动处理商品的上架下架,和文章的发布取消</td>
      <td></td>
   </tr>
   <tr>
      <td>商家结算帐单按日生成</td>
      <td>1.0.0</td>
      <td>cron_bill_day</td>
      <td>自动按日生成商家结算帐单</td>
      <td></td>
   </tr>
   <tr>
      <td>商家结算帐单按月生成</td>
      <td>1.0.0</td>
      <td>cron_bill_month</td>
      <td>自动按月生成商家结算帐单</td>
      <td></td>
   </tr>
   <tr>
      <td>自动关闭未付款订单</td>
      <td>1.0.0</td>
      <td>cron_unpayed</td>
      <td>计划任务-自动关闭未付款订单</td>
      <td></td>
   </tr>
   <tr>
      <td>自动确认收货</td>
      <td>1.0.0</td>
      <td>cron_order_receive</td>
      <td>计划任务-订单自动确认收货</td>
      <td></td>
   </tr>
   <tr>
      <td>银行转帐</td>
      <td>2.0.0</td>
      <td>pay_bank</td>
      <td>银行名称，收款人信息：全称 ××× ；帐号或地址 ××× ；开户行 ×××。注意事项：办理电汇时，请在电汇单“汇款用途”一栏处注明您的订单号。</td>
      <td></td>
   </tr>
</table>


环境要求
===

- 操作系统须 Linux（开发环境下，Windows也可以）
- PHP环境须5.4或更高版本
- MySQL环境须5.5或更高版本


搭建步骤
===

1. 创建数据库。如使用MySQL，字符集选择为“utf8”或者“utf8mb4”（支持更多特殊字符，推荐）
2. 创建一个空数据库
3. 访问网站地址，如 **[http://localhost](http://localhost)** 或其它可访问程序的地址
4. 运行安装程序，填写相关配置信息，安装
5. 安装完成，访问系统。

	
安装产品后可以通过以下地址访问各个页面：
例如安装地址是：[http://demodaojia.ecjia.com](http://demodaojia.ecjia.com)，可以更换为自己的访问地址。

- ECJia到家首页：http://demodaojia.ecjia.com
- ECJia到家H5端：http://demodaojia.ecjia.com/sites/m/
- ECJia到家平台后台：http://demodaojia.ecjia.com/sites/admincp/
- ECJia到家商家后台：http://demodaojia.ecjia.com/sites/merchant/
- ECJia到家API地址：http://demodaojia.ecjia.com/sites/api/
- ECJia到家公众平台地址：http://demodaojia.ecjia.com/sites/platform/

安装文档
===

为帮助您学习了解ECJia到家，方便使用ECJia到家，快速开始ECJia到家研究开发， 我们提供以下文档资料及技术支持。

- ECJia到家环境部署说明： [https://ecjia.com/wiki/ECJiaWiki:ECJia到家环境部署说明](https://ecjia.com/wiki/ECJiaWiki:ECJia到家环境部署说明)
- ECJia到家安装流程指导： [https://ecjia.com/wiki/ECJiaWiki:ECJia到家安装流程指导](https://ecjia.com/wiki/ECJiaWiki:ECJia到家安装流程指导)
- ECJia到家Linux环境安装流程指导： [https://ecjia.com/wiki/ECJiaWiki:ECJia到家Linux环境安装流程指导](https://ecjia.com/wiki/ECJiaWiki:ECJia到家Linux环境安装流程指导)
- 关于MySQL不支持InnoDB的解决方案： [https://ecjia.com/wiki/ECJiaWiki:关于MySQL不支持InnoDB的解决方案](https://ecjia.com/wiki/ECJiaWiki:关于MySQL不支持InnoDB的解决方案)
- Windows环境下Phpstudy开启OpenSSL扩展： [https://ecjia.com/wiki/ECJiaWiki:Windows环境下Phpstudy开启OpenSSL扩展](https://ecjia.com/wiki/ECJiaWiki:Windows环境下Phpstudy开启OpenSSL扩展)


使用配置
===

- ECJia到家帮助文档地址：[http://ecjia.com/wiki/帮助:ECJia到家](http://ecjia.com/wiki/帮助:ECJia到家)
- 如何为H5及APP配置支付宝支付：[https://ecjia.com/wiki/常见问题:如何为H5及APP配置支付宝支付](https://ecjia.com/wiki/常见问题:如何为H5及APP配置支付宝支付)
- ECJia后台中如何配置微信公众平台：[https://ecjia.com/wiki/常见问题:ECJia后台中如何配置微信公众平台](https://ecjia.com/wiki/常见问题:ECJia后台中如何配置微信公众平台)
- ECJia到家商家入驻申请流程：[https://ecjia.com/wiki/ECJiaWiki:ECJia到家商家入驻申请流程](https://ecjia.com/wiki/ECJiaWiki:ECJia到家商家入驻申请流程)


开发文档
===

- ECJia到家H5路由清单：[https://ecjia.com/wiki/ECJiaWiki:ECJia到家H5路由清单](https://ecjia.com/wiki/ECJiaWiki:ECJia到家H5路由清单)
- ECJia到家API接口列表：[https://ecjia.com/wiki/ECJiaWiki:ECJia到家API接口列表](https://ecjia.com/wiki/ECJiaWiki:ECJia到家API接口列表)
- ECJia到家数据库表结构说明：[https://ecjia.com/wiki/ECJiaWiki:ECJia到家数据库表结构说明](https://ecjia.com/wiki/ECJiaWiki:ECJia到家数据库表结构说明)
- ECJia到家后台配置文件解析：[https://ecjia.com/wiki/ECJiaWiki:ECJia到家后台配置文件解析](https://ecjia.com/wiki/ECJiaWiki:ECJia到家后台配置文件解析)
- ECJia到家数据库之查询构建器：[https://ecjia.com/wiki/ECJiaWiki:ECJia到家RC_DB-数据库之查询构建器](https://ecjia.com/wiki/ECJiaWiki:ECJia到家RC_DB-数据库之查询构建器)


产品截图
===

#### ECJia到家首页
![](http://file.ecjia.com/images/daojia/ECJia到家_PC首页.png)

![](http://file.ecjia.com/images/daojia/ECJia到家_首页.png)

#### ECJia到家平台后台
![](http://file.ecjia.com/images/daojia/ECJia到家_平台后台.png)

#### ECJia到家商家后台
![](http://file.ecjia.com/images/daojia/ECJia到家_商家后台.png)

#### ECJia到家平台登录
![](http://file.ecjia.com/images/daojia/ECJia到家_平后登录.png)

#### ECJia到家商家登录
![](http://file.ecjia.com/images/daojia/ECJia到家_商家登录.png)

#### ECJia到家商家入驻
![](http://file.ecjia.com/images/daojia/ECJia到家_商家入驻.png)

#### ECJia到家H5首页
![](http://file.ecjia.com/images/daojia/ECJia到家_H5首页.png)

