<?php
//
//    ______         ______           __         __         ______
//   /\  ___\       /\  ___\         /\_\       /\_\       /\  __ \
//   \/\  __\       \/\ \____        \/\_\      \/\_\      \/\ \_\ \
//    \/\_____\      \/\_____\     /\_\/\_\      \/\_\      \/\_\ \_\
//     \/_____/       \/_____/     \/__\/_/       \/_/       \/_/ /_/
//
//   上海商创网络科技有限公司
//
//  ---------------------------------------------------------------------------------
//
//   一、协议的许可和权利
//
//    1. 您可以在完全遵守本协议的基础上，将本软件应用于商业用途；
//    2. 您可以在协议规定的约束和限制范围内修改本产品源代码或界面风格以适应您的要求；
//    3. 您拥有使用本产品中的全部内容资料、商品信息及其他信息的所有权，并独立承担与其内容相关的
//       法律义务；
//    4. 获得商业授权之后，您可以将本软件应用于商业用途，自授权时刻起，在技术支持期限内拥有通过
//       指定的方式获得指定范围内的技术支持服务；
//
//   二、协议的约束和限制
//
//    1. 未获商业授权之前，禁止将本软件用于商业用途（包括但不限于企业法人经营的产品、经营性产品
//       以及以盈利为目的或实现盈利产品）；
//    2. 未获商业授权之前，禁止在本产品的整体或在任何部分基础上发展任何派生版本、修改版本或第三
//       方版本用于重新开发；
//    3. 如果您未能遵守本协议的条款，您的授权将被终止，所被许可的权利将被收回并承担相应法律责任；
//
//   三、有限担保和免责声明
//
//    1. 本软件及所附带的文件是作为不提供任何明确的或隐含的赔偿或担保的形式提供的；
//    2. 用户出于自愿而使用本软件，您必须了解使用本软件的风险，在尚未获得商业授权之前，我们不承
//       诺提供任何形式的技术支持、使用担保，也不承担任何因使用本软件而产生问题的相关责任；
//    3. 上海商创网络科技有限公司不对使用本产品构建的商城中的内容信息承担责任，但在不侵犯用户隐
//       私信息的前提下，保留以任何方式获取用户信息及商品信息的权利；
//
//   有关本产品最终用户授权协议、商业授权与技术服务的详细内容，均由上海商创网络科技有限公司独家
//   提供。上海商创网络科技有限公司拥有在不事先通知的情况下，修改授权协议的权力，修改后的协议对
//   改变之日起的新授权用户生效。电子文本形式的授权协议如同双方书面签署的协议一样，具有完全的和
//   等同的法律效力。您一旦开始修改、安装或使用本产品，即被视为完全理解并接受本协议的各项条款，
//   在享有上述条款授予的权力的同时，受到相关的约束和限制。协议许可范围以外的行为，将直接违反本
//   授权协议并构成侵权，我们有权随时终止授权，责令停止损害，并保留追究相关责任的权力。
//
//  ---------------------------------------------------------------------------------
//
defined('IN_ECJIA') or exit('No permission resources.');

/* 用户登录语言项 */
$LANG['empty_username_password'] = '对不起，您必须完整填写用户名和密码。';
$LANG['shot_message']            = "短消息";

/* 公共语言项 */
$LANG['tips_message']               = "提示消息";
$LANG['no_data']                    = '暂无数据';
$LANG['sys_msg']                    = '系统提示';
$LANG['catalog']                    = '目录';
$LANG['please_view_order_detail']   = '商品已发货，详情请到用户中心订单详情查看';
$LANG['user_center']                = '用户中心';
$LANG['shop_closed']                = '本店盘点中，请您稍后再来...';
$LANG['shop_register_closed']       = '该网店暂停注册';
$LANG['shop_upgrade']               = "本店升级中，管理员从 <a href=\"admin/\">管理中心</a> 登录后，系统会自动完成升级";
$LANG['js_languages']['process_request'] = '正在处理您的请求...';
$LANG['process_request']            = '正在处理您的请求...';
$LANG['please_waiting']             = '请稍等, 正在载入中...';
$LANG['icp_number']                 = 'ICP备案证书号';
$LANG['plugins_not_found']          = "插件 %s 无法定位";
$LANG['home']                       = '首页';
$LANG['back_up_page']               = '返回';
$LANG['close_window']               = '关闭窗口';
$LANG['back_home']                  = '返回首页';
$LANG['ur_here']                    = '当前位置:';
$LANG['all_goods']                  = '全部商品';
$LANG['all_recommend']              = "全部推荐";
$LANG['all_attribute']              = "全部";
$LANG['promotion_goods']            = '促销商品';
$LANG['best_goods']                 = '精品推荐';
$LANG['new_goods']                  = '新品上市';
$LANG['hot_goods']                  = '热销商品';
$LANG['view_cart']                  = '查看购物车';
$LANG['catalog']                    = '所有分类';
$LANG['regist_login']               = '注册/登录';
$LANG['profile']                    = '个人资料';
$LANG['query_info']                 = "共执行 %d 个查询，用时 %f 秒，在线 %d 人";
$LANG['gzip_enabled']               = '，Gzip 已启用';
$LANG['gzip_disabled']              = '，Gzip 已禁用';
$LANG['memory_info']                = '，占用内存 %0.3f MB';
$LANG['cart_info']                  = '您的购物车中有 %d 件商品，总计金额 %s。';
$LANG['shopping_and_other']         = '购买过此商品的人还购买过';
$LANG['bought_notes']               = '购买记录';
$LANG['later_bought_amounts']       = '近期成交数量';
$LANG['bought_time']                = '购买时间';
$LANG['turnover']                   = '成交';
$LANG['no_notes']                   = '还没有人购买过此商品';
$LANG['shop_price']                 = '本店售价：';
$LANG['market_price']               = '市场价格：';
$LANG['goods_brief']                = '商品描述';
$LANG['goods_album']                = '商品相册';
$LANG['promote_price']              = "促销价：";
$LANG['fittings_price']             = '配件价格：';
$LANG['collect']                    = '加入收藏夹';
$LANG['add_to_cart']                = '加入购物车';
$LANG['return_to_cart']             = '放回购物车';
$LANG['search_goods']               = '商品搜索';
$LANG['search']                     = '搜索';
$LANG['wholesale_search']           = '搜索批发商品';
$LANG['article_title']              = '文章标题';
$LANG['article_author']             = '作者';
$LANG['article_add_time']           = '添加日期';
$LANG['relative_file']              = '[ 相关下载 ]';
$LANG['category']                   = '分类';
$LANG['brand']                      = '品牌';
$LANG['price_min']                  = '最小价格';
$LANG['price_max']                  = '最大价格';
$LANG['goods_name']                 = '商品名称';
$LANG['goods_attr']                 = '商品属性';
$LANG['goods_price_ladder']         = '价格阶梯';
$LANG['ladder_price']               = '批发价格';
$LANG['shop_prices']                = '本店价';
$LANG['market_prices']              = '市场价';
$LANG['deposit']                    = '团购保证金';
$LANG['amount']                     = '商品总价';
$LANG['number']                     = '购买数量';
$LANG['handle']                     = '操作';
$LANG['add']                        = '添加';
$LANG['edit']                       = '编辑';
$LANG['drop']                       = '删除';
$LANG['view']                       = '查看';
$LANG['modify']                     = '修改';
$LANG['is_cancel']                  = '取消';
$LANG['amend_amount']               = '修改数量';
$LANG['end']                        = '结束';
$LANG['require_field']              = '必填';
$LANG['search_result']              = '搜索结果';
$LANG['order_number']               = '订单号';
$LANG['consignment']                = '发货单';
$LANG['activities']                 = '商品正在进行的活动';
$LANG['remark_package']             = '超值礼包';
$LANG['old_price']                  = '原  价：';
$LANG['package_price']              = '礼包价：';
$LANG['then_old_price']             = '节  省：';
$LANG['free_goods']                 = '免运费商品';

$LANG['searchkeywords_notice']      = '匹配多个关键字全部，可用 "空格" 或 "AND" 连接。如 win32 AND unix<br />匹配多个关键字其中部分，可用"+"或 "OR" 连接。如 win32 OR unix';
$LANG['hidden_outstock']            = '隐藏已脱销的商品';
$LANG['keywords']                   = '关键字';
$LANG['sc_ds']                      = '搜索简介';
$LANG['button_search']              = '立即搜索';
$LANG['no_search_result']           = '无法搜索到您要找的商品！';
$LANG['all_category']               = '所有分类';
$LANG['all_brand']                  = '所有品牌';
$LANG['all_option']                 = '请选择';
$LANG['extension']                  = '扩展选项';
$LANG['gram']                       = '克';
$LANG['kilogram']                   = '千克';
$LANG['goods_sn']                   = '商品货号：';
$LANG['goods_brand']                = '商品品牌：';
$LANG['goods_weight']               = '商品重量：';
$LANG['goods_number']               = '商品库存：';
$LANG['goods_give_integral']        = '购买此商品赠送：';
$LANG['goods_integral']             = '购买此商品可使用：';
$LANG['goods_bonus']                = '购买此商品可获得红包：';
$LANG['goods_free_shipping']        = '此商品为免运费商品，计算配送金额时将不计入配送费用';
$LANG['goods_rank']                 = '用户评价：';
$LANG['goods_compare']              = '商品比较';
$LANG['properties']                 = '商品属性：';
$LANG['brief']                      = '简要介绍：';
$LANG['add_time']                   = '上架时间：';
$LANG['residual_time']              = '剩余时间：';
$LANG['day']                        = '天';
$LANG['hour']                       = '小时';
$LANG['minute']                     = '分钟';
$LANG['compare']                    = '比较';
$LANG['volume_price']               = '购买商品达到以下数量区间时可享受的优惠价格';
$LANG['number_to']                  = '数量';
$LANG['article_list']               = '文章列表';
$LANG['article_detail']             = '问题详情';
$LANG['piece']                      = '件';

$LANG['goods_category']             = "商品分类";
$LANG['menu']                       = "菜单";
$LANG['goods_detail']               = "商品详情";
$LANG['detail_intro']               = "详细介绍";
$LANG['order_detail']               = "订单确认";
$LANG['order_submit']               = "订单提交";
$LANG['select_shipping_method']     = "请选择配送方式";
$LANG['select_payment_method']      = "请选择支付方式";
$LANG['check_out']                  = "立即结算";
$LANG['show_favourable']            = "查看优惠活动";
$LANG['empty_shopping']             = "购物车什么都没有，赶快去购物吧";
$LANG['go_shopping']                = "去购物";
$LANG['shopping_cart']              = "购物车";
$LANG['total_number']               = "件商品";
$LANG['goods_price']                = "总价(不含运费)";
$LANG['favourable_mz']              = "赠";
$LANG['favourable_mj']              = "减";
$LANG['favourable_zk']              = "折";
$LANG['group_buy_act']              = "团";
$LANG['snatch_act']                 = "夺";
$LANG['auction_act']                = "拍卖";

/* 分类展示页  */
$LANG['sort_default']       = '默认';
$LANG['sort_sales']         = '销量';
$LANG['sort_popularity']    = '人气';
$LANG['sort_price']         = '价格';
$LANG['like_num']           = '人喜欢';
$LANG['like']               = '喜欢';
$LANG['like_last']          = '个';
$LANG['scan_num']           = '次浏览';
$LANG['button_submit']      = '确定';
$LANG['clear_filter']       = '清空';

/* 商品比较JS语言项 */
$LANG['compare_js']['button_compare']       = '比较选定商品';
$LANG['compare_js']['exist']                = '您已经选择了%s';
$LANG['compare_js']['count_limit']          = '最多只能选择4个商品进行对比';
$LANG['compare_js']['goods_type_different'] = '\"%s\"和已选择商品类型不同无法进行对比';

$LANG['bonus']                      = '优惠券：';
$LANG['no_comments']                = '暂时还没有任何用户评论';
$LANG['give_comments_rank']         = '给出';
$LANG['comments_rank']              = '评价';
$LANG['comment_num']                = "用户评论 %d 条记录";
$LANG['login_please']               = '由于您还没有登录，因此您还不能使用该功能。';
$LANG['collect_existed']            = '该商品已经存在于您的收藏夹中。';
$LANG['collect_success']            = '该商品已经成功地加入了您的收藏夹。';
$LANG['uncollect_success']          = '该商品已经从您的收藏夹中移除。';
$LANG['copyright']                  = "&copy; 2005-%s %s 版权所有，并保留所有权利。";
$LANG['no_ads_id']                  = '没有指定广告的ID以及跳转的URL地址!';
$LANG['remove_collection_confirm']  = '您确定要从收藏夹中删除选定的商品吗？';
$LANG['err_change_attr']            = '没有找到指定的商品或者没有找到指定的商品属性。';

$LANG['collect_goods']  = '收藏商品';
$LANG['plus']           = '加';
$LANG['minus']          = '减';
$LANG['yes']            = '是';
$LANG['no']             = '否';

$LANG['same_attrbiute_goods'] = '相同%s的商品';

/* TAG */
$LANG['button_submit_tag']  = '添加我的标记';
$LANG['tag_exists']         = '您已经为该商品添加过一个标记，请不要重复提交.';
$LANG['tag_cloud']          = '标签云';
$LANG['tag_anonymous']      = '对不起，只有注册会员并且正常登录以后才能提交标记。';
$LANG['tag_cloud_desc']     = '标签云（Tag cloud）是用以表示一个网站中的内容标签。 标签（tag、关键词）是一种更为灵活、有趣的商品分类方式，您可以为每个商品添加一个或多个标签，那么可以通过点击这个标签查看商品其他会员提交的与您的标签一样的商品,能够让您使用最快的方式查找某一个标签的所有网店商品。比方说点击“红色”这个标签，就可以打开这样的一个页面，显示所有的以“红色” 为标签的网店商品';

/* AJAX 相关 */
$LANG['invalid_captcha']        = '对不起，您输入的验证码不正确。';
$LANG['goods_exists']           = '对不起，您的购物车中已经存在相同的商品。';
$LANG['fitting_goods_exists']   = '对不起，您的购物车中已经添加了该配件。';
$LANG['invalid_number']         = '对不起，您输入了一个非法的商品数量。';
$LANG['not_on_sale']            = '对不起，该商品已经下架。';
$LANG['no_basic_goods']         = '对不起，您希望将该商品做为配件购买，可是购物车中还没有该商品的基本件。';
$LANG['cannt_alone_sale']       = '对不起，该商品不能单独销售。';
$LANG['shortage']               = "对不起，该商品已经库存不足暂停销售。\n你现在要进行缺货登记来预订该商品吗？";
$LANG['shortage_little']        = "该商品已经库存不足。已将您的购货数量修改为 %d。\n您现在要去购物车吗？";
$LANG['oos_tips']               = '该商品已经库存不足。您现在要进行缺货登记吗？';

$LANG['addto_cart_success_1'] = "该商品已添加到购物车，您现在还需要继续购物吗？\n如果您希望马上结算，请点击“确定”按钮。\n如果您希望继续购物，请点击“取消”按钮。";
$LANG['addto_cart_success_2'] = "该商品已添加到购物车，您现在还需要继续购物吗？\n如果您希望继续购物，请点击“确定”按钮。\n如果您希望马上结算，请点击“取消”按钮。";
$LANG['no_keywords']          = "请输入搜索关键词！";
$LANG['art_no_keywords']      = "输入问题关键字搜索！";
/* 分页排序 */
$LANG['exchange_sort']['goods_id']          = '按上架时间排序';
$LANG['exchange_sort']['exchange_integral'] = '按积分排序';
$LANG['exchange_sort']['last_update']       = '按更新时间排序';
$LANG['sort']['goods_id']                   = '按上架时间排序';
$LANG['sort']['shop_price']                 = '按价格排序';
$LANG['sort']['last_update']                = '按更新时间排序';
$LANG['order']['DESC']                      = '倒序';
$LANG['order']['ASC']                       = '正序';
$LANG['pager_1']                            = '总计 ';
$LANG['pager_2']                            = ' 个记录';
$LANG['pager_3']                            = '，共 ';
$LANG['pager_4']                            = ' 页。';
$LANG['page_first']                         = '第一页';
$LANG['page_prev']                          = '上一页';
$LANG['page_next']                          = '下一页';
$LANG['page_last']                          = '最末页';
$LANG['btn_display']                        = '显示方式';

/* 投票 */
$LANG['vote_times']     = '参与人次';
$LANG['vote_ip_same']   = '对不起，您已经投过票了!';
$LANG['submit_vote']    = '投票';
$LANG['submit_reset']   = '重选';
$LANG['vote_success']   = '恭喜你，投票成功';

/* 评论 */
$LANG['cmt_submit_done']                = '您的评论已成功发表, 感谢您的参与!';
$LANG['cmt_submit_wait']                = "您的评论已成功发表, 请等待管理员的审核!";
$LANG['cmt_lang']['cmt_empty_username'] = '请输入您的用户名称';
$LANG['cmt_lang']['cmt_empty_email']    = '请输入您的电子邮件地址';
$LANG['cmt_lang']['cmt_error_email']    = '电子邮件地址格式不正确';
$LANG['cmt_lang']['cmt_empty_content']  = '您没有输入评论的内容';
$LANG['cmt_spam_warning']               = '您至少在30秒后才可以继续发表评论!';
$LANG['cmt_lang']['captcha_not_null']   = '验证码不能为空!';
$LANG['cmt_lang']['cmt_invalid_comments'] = '无效的评论内容!';
$LANG['invalid_comments']               = '无效的评论内容!';
$LANG['error_email']                    = '电子邮件地址格式不正确!';
$LANG['admin_username']                 = "管理员：";
$LANG['reply_comment']                  = '回复';
$LANG['comment_captcha']                = '验证码';
$LANG['comment_login']                  = '只有注册会员才能发表评论，请您登录后再发表评论';
$LANG['comment_custom']                 = '评论失败。只有在本店购买过商品的注册会员才能发表评论。';
$LANG['comment_brought']                = '评论失败。只有购买过此商品的注册用户才能评论该商品。';
$LANG['anonymous']                      = '匿名用户';

$LANG['five_stars']  = '非常好';
$LANG['four_stars']  = '很好';
$LANG['three_stars'] = '一般';
$LANG['two_stars']   = '不行';
$LANG['one_stars']   = '很差';

$LANG['all_comment']       = '全部';
$LANG['favorable_comment'] = '好评';
$LANG['medium_comment']    = '中评';
$LANG['bad_comment']       = '差评';
/* 其他信息 */
$LANG['js_languages']['goodsname_not_null'] = '商品名不能为空！';

/* 商品比较 */
$LANG['compare_remove']   = '移除';
$LANG['compare_no_goods'] = '您没有选定任何需要比较的商品或者比较的商品数少于 2 个。';

$LANG['no_user_name']   = '该用户名不存在';
$LANG['undifine_rank']  = '没有定义会员等级';
$LANG['not_login']      = '您还没有登录';
$LANG['half_info']      = '信息不全，请填写所有信息';
$LANG['no_id']          = '没有商品ID';
$LANG['save_success']   = '修改成功';
$LANG['drop_consignee_confirm'] = '您确定要删除该收货人信息吗？';

/* 夺宝奇兵 */
$LANG['snatch_js']['price_not_null']    = '价格不能为空';
$LANG['snatch_js']['price_not_number']  = '价格只能是数字';
$LANG['snatch_list']                    = '夺宝奇兵列表';
$LANG['not_in_range']                   = '你只能在%d到%d之间出价';
$LANG['also_bid']                       = '你已经出过价格 %s 了';
$LANG['lack_pay_points']                = '你积分不够，不能出价';
$LANG['snatch']                         = '夺宝奇兵';
$LANG['snatch_is_end']                  = '活动已经结束';
$LANG['snatch_start_time']              = '本次活动从 %s 到 %s 截止';
$LANG['price_extent']                   = '出价范围为';
$LANG['user_to_use_up']                 = '用户可多次出价，每次消耗';
$LANG['snatch_victory_desc']            = '当本期活动截止时，系统将从所有竞价奖品的用户中，选出在所有竞价中出价最低、且没有其他出价与该价格重复的用户（即最低且唯一竞价），成为该款奖品的获胜者.';
$LANG['price_less_victory']             = '如果用户获胜的价格低于';
$LANG['price_than_victory']             = '将能按当期竞拍价购得该款奖品；如果用户获胜的价格高于';
$LANG['or_can']                         = '则能以';
$LANG['shopping_product']               = '购买该款奖品';
$LANG['victory_price_product']          = '获胜用户将能按当期竞拍价购得该款奖品.';
$LANG['now_not_snatch']                 = '当前没有活动';
$LANG['my_integral']                    = '我的积分';
$LANG['bid']                            = '出价';
$LANG['me_bid']                         = '我要出价';
$LANG['me_now_bid']                     = '我的出价';
$LANG['only_price']                     = '唯一价格';
$LANG['view_snatch_result']             = '活动结果';
$LANG['victory_user']                   = '获奖用户';
$LANG['price_bid']                      = '所出价格';
$LANG['bid_time']                       = '出价时间';
$LANG['not_victory_user']               = '没有获奖用户';
$LANG['snatch_log']                     = '参加夺宝奇兵%s ';
$LANG['not_for_you']                    = '你不是获胜者，不能购买';
$LANG['order_placed']                   = '您已经下过订单了，如果您想重新购买，请先取消原来的订单';

/* 购物流程中的前台部分 */
$LANG['select_spe'] = '请选择商品属性';

/* 购物流程中的订单部分 */
$LANG['price']                  = '价格';
$LANG['name']                   = '名称';
$LANG['describe']               = '描述';
$LANG['fee']                    = '费用';
$LANG['free_money']             = '免费额度';
$LANG['img']                    = '图片';
$LANG['no_pack']                = '不要包装';
$LANG['no_card']                = '不要贺卡';
$LANG['bless_note']             = '祝福语';
$LANG['use_integral']           = '使用积分';
$LANG['can_use_integral']       = '您当前的可用积分为';
$LANG['noworder_can_integral']  = '本订单最多可以使用';
$LANG['use_surplus']            = '余额付款';
$LANG['your_surplus']           = '您当前的可用余额为';
$LANG['pay_fee']                = '支付手续费';
$LANG['insure_fee']             = '保价费用';
$LANG['need_insure']            = '配送是否需要保价';
$LANG['cod']                    = '配送决定';

$LANG['curr_stauts']            = '当前状态';
$LANG['use_bonus']              = '使用红包';
$LANG['no_use_bonus']           = '不使用红包';
$LANG['use_bonus_kill']         = '使用线下红包';
$LANG['invoice']                = '开发票';
$LANG['invoice_type']           = '发票类型';
$LANG['invoice_title']          = '发票抬头';
$LANG['please_invoice_title']   = '请输入发票抬头';
$LANG['invoice_content']        = '发票内容';
$LANG['order_postscript']       = '订单附言';
$LANG['please_order_postscript'] = '请输入订单附言';
$LANG['booking_process']        = '缺货处理';
$LANG['complete_acquisition']   = '该订单完成后，您将获得';
$LANG['with_price']             = '以及价值';
$LANG['de']                     = '的';
$LANG['bonus']                  = '红包';
$LANG['goods_all_price']        = '商品总价';
$LANG['discount']               = '折扣';
$LANG['tax']                    = '发票税额';
$LANG['shipping_fee']           = '配送费用';
$LANG['pack_fee']               = '包装费用';
$LANG['card_fee']               = '贺卡费用';
$LANG['total_fee']              = '应付款金额';
$LANG['self_site']              = '本站';
$LANG['order_gift_integral']    = '订单 %s 赠送的积分';
$LANG['order_payed_sms']        = '订单 %s 付款了。收货人：%s；电话：%s。';

/* 缺货处理 */
$LANG['oos'][OOS_WAIT]      = '等待所有商品备齐后再发';
$LANG['oos'][OOS_CANCEL]    = '取消订单';
$LANG['oos'][OOS_CONSULT]   = '与店主协商';

/* 评论部分 */
$LANG['username']           = '用户名';
$LANG['email']              = '电子邮件地址';
$LANG['comment_rank']       = '评价等级';
$LANG['comment_content']    = '评论内容';
$LANG['submit_comment']     = '提交评论';
$LANG['button_reset']       = '重置表单';
$LANG['goods_comment']      = '商品评论';
$LANG['article_comment']    = '文章评论';
$LANG['comment_num']        = '人评价';

/* 支付确认部分 */
$LANG['pay_status']         = '支付状态';
$LANG['pay_not_exist']      = '此支付方式不存在或者参数错误！';
$LANG['pay_disabled']       = '此支付方式还没有被启用！';
$LANG['pay_success']        = '您此次的支付操作已成功！';
$LANG['pay_fail']           = '支付操作失败，请返回重试！';

/* 文章部分 */
$LANG['shophelp']               = '服务中心';
$LANG['new_article']            = '最新文章';
$LANG['shop_notice']            = '商店公告';
$LANG['order_already_received'] = '此订单已经确认过了，感谢您在本站购物，欢迎再次光临。';
$LANG['order_invalid']          = '您提交的订单不正确。';
$LANG['act_ok']                 = '谢谢您通知我们您已收到货，感谢您在本站购物，欢迎再次光临。';
$LANG['receive']                = '收货确认';
$LANG['buyer']                  = '买家';
$LANG['next_article']           = '下一篇';
$LANG['prev_article']           = '上一篇';

/* 虚拟商品 */
$LANG['virtual_goods_ship_fail'] = '自动发货失败，请尽快联系商家重新发货';

/* 选购中心 */
$LANG['pick_out']           = '选购中心';
$LANG['fit_count']          = "共有 %s 件商品符合条件";
$LANG['goods_type']         = "商品类型";
$LANG['remove_all']         = '移除所有';
$LANG['advanced_search']    = '高级搜索';
$LANG['activity']           = '本商品正在进行';
$LANG['order_not_exists']   = "非常抱歉，没有找到指定的订单。请和网站管理员联系。";

$LANG['promotion_time'] = '活动时间：%s ～ %s';

/* 倒计时 */
$LANG['goods_js']['day']    = '天';
$LANG['goods_js']['hour']   = '小时';
$LANG['goods_js']['minute'] = '分钟';
$LANG['goods_js']['second'] = '秒';
$LANG['goods_js']['end']    = '结束';

$LANG['favourable'] = '优惠活动';

/* 团购部分语言项 */
$LANG['group_buy']              = '团购活动';
$LANG['group_buy_goods']        = '团购商品';
$LANG['gb_goods_name']          = '团购商品：';
$LANG['gb_start_date']          = '开始时间：';
$LANG['gb_end_date']            = '结束时间：';
$LANG['gbs_pre_start']          = '该团购活动尚未开始，请继续关注。';
$LANG['gbs_under_way']          = '该团购活动正在火热进行中，距离结束时间还有：';
$LANG['gbs_finished']           = '该团购活动已结束，正在等待处理...';
$LANG['gbs_succeed']            = '该团购活动已成功结束！';
$LANG['gbs_fail']               = '该团购活动已结束，没有成功。';
$LANG['gb_price_ladder']        = '价格阶梯：';
$LANG['gb_ladder_amount']       = '数量';
$LANG['gb_ladder_price']        = '价格';
$LANG['gb_deposit']             = '保证金：';
$LANG['gb_restrict_amount']     = '限购数量：';
$LANG['gb_gift_integral']       = '赠送积分：';
$LANG['gb_cur_price']           = '当前价格：';
$LANG['gb_valid_goods']         = '当前定购数量：';
$LANG['gb_final_price']         = '成交价格：';
$LANG['gb_final_amount']        = '成交数量：';
$LANG['gb_notice_login']        = '提示：您需要先注册成为本站会员并且登录后，才能参加商品团购!';
$LANG['gb_error_goods_lacking'] = '对不起，商品库存不足，请您修改数量！';
$LANG['gb_error_status']        = '对不起，该团购活动已经结束或尚未开始，现在不能参加！';
$LANG['gb_error_login']         = '对不起，您没有登录，不能参加团购，请您先登录！';
$LANG['group_goods_empty']      = '当前没有团购活动';

/* 拍卖部分语言项 */
$LANG['auction']                = '拍卖活动';
$LANG['act_status']             = '活动状态';
$LANG['au_current_price']       = '当前价格';
$LANG['act_start_time']         = '开始时间';
$LANG['act_end_time']           = '结束时间';
$LANG['au_start_price']         = '起拍价';
$LANG['au_end_price']           = '一口价';
$LANG['au_amplitude']           = '加价幅度';
$LANG['au_deposit']             = '保证金';
$LANG['no_auction']             = '当前没有拍卖活动';
$LANG['au_pre_start']           = '该拍卖活动尚未开始';
$LANG['au_under_way']           = '该拍卖活动正在进行中，距离结束时间还有：';
$LANG['au_under_way_1']         = '该拍卖活动正在进行中';
$LANG['au_bid_user_count']      = '已出价人数';
$LANG['au_last_bid_price']      = '最后出价';
$LANG['au_last_bid_user']       = '最后出价的买家';
$LANG['au_last_bid_time']       = '最后出价时间';
$LANG['au_finished']            = '该拍卖活动已结束';
$LANG['au_bid_user']            = '买家';
$LANG['au_bid_price']           = '出价';
$LANG['au_bid_time']            = '时间';
$LANG['au_bid_status']          = '状态';
$LANG['no_bid_log']             = '暂时没有买家出价';
$LANG['au_bid_ok']              = '领先';
$LANG['au_i_want_bid']          = '我要出价';
$LANG['button_bid']             = '出价';
$LANG['button_buy']             = '立即购买';
$LANG['au_not_under_way']       = '拍卖活动已结束，不能再出价了';
$LANG['au_bid_price_error']     = '请输入正确的价格';
$LANG['au_bid_after_login']     = '您只有注册成为会员并且登录之后才能出价';
$LANG['au_bid_repeat_user']     = '您已经是这个商品的最高出价人了';
$LANG['au_your_lowest_price']   = '您的出价不能低于 %s';
$LANG['au_user_money_short']    = '您的可用资金不足，请先到用户中心充值';
$LANG['au_unfreeze_deposit']    = '解冻拍卖活动的保证金：%s';
$LANG['au_freeze_deposit']      = '冻结拍卖活动的保证金：%s';
$LANG['au_not_finished']        = '该拍卖活动尚未结束，不能购买';
$LANG['au_order_placed']        = '您已经下过订单了，如果您想重新购买，请先取消原来的订单';
$LANG['au_no_bid']              = '该拍卖活动没有人出价，不能购买';
$LANG['au_final_bid_not_you']   = '您不是最高出价者，不能购买';
$LANG['au_buy_after_login']     = '请您先登录';
$LANG['au_is_winner']           = '恭喜您，您已经赢得了该商品的购买权。请点击下面的购买按钮将您的宝贝买回家吧。';

/* 批发部分语言项 */
$LANG['ws_user_rank']               = '您的等级暂时无法查看批发方案';
$LANG['ws_login_please']            = '请您先登录';
$LANG['ws_return_home']             = '返回首页';
$LANG['wholesale']                  = '批发';
$LANG['no_wholesale']               = '没有批发商品';
$LANG['ws_price']                   = '批发价';
$LANG['ws_subtotal']                = '小计';
$LANG['ws_invalid_goods_number']    = '请输入正确的数量';
$LANG['ws_attr_not_matching']       = '您选择的商品属性不存在，请参照批发价格单选择';
$LANG['ws_goods_number_not_enough'] = '您购买的数量没有达到批发的最小数量，请参照批发价格单';
$LANG['ws_goods_attr_exists']       = '该商品已经在购物车中，不能再次加入';
$LANG['ws_remark']                  = '请输入您的联系方式、付款方式和配送方式等信息';
$LANG['ws_order_submitted']         = '您的订单已提交成功，请记住您的订单号: %s。';
$LANG['ws_price_list']              = '价格单';

/* 积分兑换部分语言项 */
$LANG['exchange']           = '积分商城';
$LANG['exchange_num']       = '兑换量';
$LANG['exchange_integral']  = '积分';
$LANG['exchange_goods']     = '立刻兑换';
$LANG['eg_error_login']     = '对不起，您没有登录，不能参加兑换，请您先登录！';
$LANG['eg_error_status']    = '对不起，该商品已经取消，现在不能兑换！';
$LANG['eg_error_integral']  = '对不起，您现有的积分值不够兑换本商品！';
$LANG['notice_eg_integral'] = '积分商城商品需要消耗积分：';
$LANG['eg_error_number']    = '对不起，该商品库存不足，现在不能兑换！';

/* 会员登录注册 */
$LANG['member_name']        = '会员';
$LANG['password']           = '密码';
$LANG['confirm_password']   = '确认密码';
$LANG['sign_up']            = '注册新会员';
$LANG['forgot_password']    = '忘记密码';
$LANG['hello']              = '您好';
$LANG['welcome_return']     = '欢迎您回来';
$LANG['now_account']        = '您的账户中现在有';
$LANG['balance']            = '余额';
$LANG['along_with']         = '以及';
$LANG['preferential']       = '优惠券';
$LANG['edit_user_info']     = '进入用户中心';
$LANG['logout']             = '退出';
$LANG['user_logout']        = '退出';
$LANG['welcome']            = '欢迎光临本店';
$LANG['user_login']         = '会员登录';
$LANG['login_now']          = '立即登录';
$LANG['login']              = '登录';
$LANG['bind_signin']        = '第三方登录';
$LANG['input_name']         = '请输入用户名';
$LANG['set_your_password']  = '请设置登录密码';
$LANG['name_or_mobile']     = '请输入用户名或手机号';
$LANG['input_passwd']       = '请输入密码';
$LANG['next']               = '下一步';
$LANG['reg_now']            = '立即注册';

/* 商品品牌页 */
$LANG['official_site']      = '官方网站：';
$LANG['brand_category']     = '分类浏览：';
$LANG['all_category']       = '所有分类';

/* 商品分类页 */
$LANG['goods_filter']       = '筛选';

/* cls_image类的语言项 */
$LANG['directory_readonly']         = '目录 % 不存在或不可写';
$LANG['invalid_upload_image_type']  = '不是允许的图片格式';
$LANG['upload_failure']             = '文件 %s 上传失败。';
$LANG['missing_gd']                 = '没有安装GD库';
$LANG['missing_orgin_image']        = '找不到原始图片 %s ';
$LANG['nonsupport_type']            = '不支持该图像格式 %s ';
$LANG['creating_failure']           = '创建图片失败';
$LANG['writting_failure']           = '图片写入失败';
$LANG['empty_watermark']            = '水印文件参数不能为空';
$LANG['missing_watermark']          = '找不到水印文件%s';
$LANG['create_watermark_res']       = '创建水印图片资源失败。水印图片类型为%s';
$LANG['create_origin_image_res']    = '创建原始图片资源失败，原始图片类型%s';
$LANG['invalid_image_type']         = '无法识别水印图片 %s ';
$LANG['file_unavailable']           = '文件 %s 不存在或不可读';

/* 邮件发送错误信息 */
$LANG['smtp_setting_error']     = '邮件服务器设置信息不完整';
$LANG['smtp_connect_failure']   = '无法连接到邮件服务器 %s';
$LANG['smtp_login_failure']     = '邮件服务器验证帐号或密码不正确';
$LANG['smtp_refuse']            = '服务器拒绝发送该邮件';
$LANG['sendemail_false']        = "邮件发送失败，请与网站管理员联系！";
$LANG['disabled_fsockopen']     = 'fsockopen函数被禁用';

$LANG['topic_goods_empty']  = '当前没有专题商品';
$LANG['email_list_ok']      = '订阅';
$LANG['email_list_cancel']  = '退订';
$LANG['email_invalid']      = '邮件地址非法！';
$LANG['email_alreadyin_list'] = '邮件地址已经存在于列表中！';
$LANG['email_notin_list']   = '邮件地址不在列表中！';
$LANG['email_re_check']     = '已经重新发送验证邮件，请查收并确认！';
$LANG['email_check']        = '请查收邮件进行确认操作！';
$LANG['email_not_alive']    = '此邮件地址是未验证状态，不需要退订！';
$LANG['check_mail']         = '验证邮件';
$LANG['check_mail_content'] = "%s 您好：<br><br>这是由%s发送的邮件订阅验证邮件,点击以下的链接地址,完成验证操作。<br><a href=\"%s\" target=\"_blank\">%s</a>\n<br><br>%s<br>%s";
$LANG['email_checked']      = '邮件已经被确认！';
$LANG['hash_wrong']         = '验证串错误！请核对验证串或输入email地址重新发送验证串！';
$LANG['email_canceled']     = '邮件已经被退定！';
$LANG['goods_click_count']  = '商品点击数';
$LANG['p_y']['link_start']  = '';
$LANG['p_y']['link_p']      = '';
$LANG['p_y']['link_r']      = '';
$LANG['p_y']['link_b']      = '';
$LANG['p_y']['main_start']  = '';
$LANG['p_y']['main_e']      = '';
$LANG['p_y']['main_c']      = '';
$LANG['p_y']['main_p']      = '';
$LANG['p_y']['v_s']         = '';
$LANG['p_y']['v']           = '';
$LANG['p_y']['link_end']    = '';

/* 虚拟卡 */
$LANG['card_sn']            = '卡片序号';
$LANG['card_password']      = '卡片密码';
$LANG['end_date']           = '截至日期';
$LANG['virtual_card_oos']   = '虚拟卡已缺货';

/* 订单状态查询 */
$LANG['invalid_order_sn']   = '无效订单号';
$LANG['order_status']       = '订单状态';
$LANG['shipping_date']      = '发货时间';
$LANG['query_order']        = '查询该订单号';
$LANG['order_query_toofast'] = '您的提交频率太高，歇会儿再查吧。';

$LANG['online_info']        = '当前共有 %s 人在线';

/* 按钮 */
$LANG['btn_direct_buy']     = '直接购买';
$LANG['btn_buy']            = '购买';
$LANG['btn_collect']        = '收藏';
$LANG['btn_add_to_cart']    = '加入购物车';
$LANG['btn_add_to_collect'] = '添加收藏';
$LANG['goods_booking']      = '商品无货';
$LANG['stock_up']           = '缺货';
$LANG['hot_search']         = '热门搜索';
$LANG['please_select_attr'] = '你加入购物车的商品有不同型号可选，你是否要立即跳转到商品详情选择型号？';

/* 促销信息栏 */
$LANG['snatch_promotion']       = '[夺宝]';
$LANG['group_promotion']        = '[团购]';
$LANG['auction_promotion']      = '[拍卖]';
$LANG['favourable_promotion']   = '[优惠]';
$LANG['wholesale_promotion']    = '[批发]';
$LANG['package_promotion']      = '[礼包]';

/* feed推送 */
$LANG['feed_user_buy']      = "购买了";
$LANG['feed_user_comment']  = "评论了";
$LANG['feed_goods_price']   = "商品价格";
$LANG['feed_goods_desc']    = "商品描述";

/* 留言板 */
$LANG['shopman_comment']    = '商品评论';
$LANG['message_ping']       = '评';
$LANG['message_board']      = "留言板";
$LANG['post_message']       = "我要留言";
$LANG['message_title']      = '主题';
$LANG['message_time']       = '留言时间';
$LANG['reply_time']         = '回复时间';
$LANG['shop_owner_reply']   = '店主回复';
$LANG['message_board_type'] = '留言类型';
$LANG['message_content']    = '留言内容';
$LANG['message_anonymous']  = '匿名留言';
$LANG['message_type'][M_MESSAGE]    = '留言';
$LANG['message_type'][M_COMPLAINT]  = '投诉';
$LANG['message_type'][M_ENQUIRY]    = '询问';
$LANG['message_type'][M_CUSTOME]    = '售后';
$LANG['message_type'][M_BUY]        = '求购';
$LANG['message_type'][M_BUSINESS]   = '商家留言';
$LANG['message_type'][M_COMMENT]    = '评论';

$LANG['message_board_js']['msg_empty_email']    = '请输入您的电子邮件地址';
$LANG['message_board_js']['msg_error_email']    = '电子邮件地址格式不正确';
$LANG['message_board_js']['msg_title_empty']    = '留言标题为空';
$LANG['message_board_js']['msg_content_empty']  = '留言内容为空';
$LANG['message_board_js']['msg_captcha_empty']  = '验证码为空';
$LANG['message_board_js']['msg_title_limit']    = '留言标题不能超过200个字';

$LANG['message_submit_wait']    = '您的留言已成功发表, 请等待管理员的审核!';
$LANG['message_submit_done']    = '发表留言成功';
$LANG['message_board_close']    = "暂停留言板功能";
$LANG['upload_file_limit']      = '文件大小超过了限制 %dKB';
$LANG['message_list_lnk']       = '返回留言列表';

/* 报价单 */
$LANG['quotation']       = "报价单";
$LANG['print_quotation'] = "打印报价单";
$LANG['goods_inventory'] = "库存";
$LANG['shopman_reply']   = '管理员回复';
$LANG['specifications']  = '规格';

/* 相册JS语言项 */
$LANG['gallery_js']['close_window'] = '您是否关闭当前窗口';
$LANG['submit']         = '提 交';
$LANG['reset']          = '重 置';
$LANG['order_query']    = '订单查询';
$LANG['shipping_query'] = '发货查询';
$LANG['view_history']   = '浏览历史';
$LANG['clear_history']  = '[清空]';
$LANG['no_history']     = '您已清空最近浏览过的商品';
$LANG['goods_tag']      = '商品标签';
$LANG['releate_goods']  = '猜你喜欢';
$LANG['goods_list']     = '商品列表';
$LANG['favourable_goods']    = '收藏该商品';
$LANG['accessories_releate'] = '相关配件';
$LANG['article_releate']     = '相关文章';
$LANG['email_subscribe']     = '邮件订阅';
$LANG['consignee_info']      = '收货人信息';
$LANG['user_comment']        = '用户评论';
$LANG['total']               = '共';
$LANG['user_comment']        = '评论';
$LANG['user_comment_num']    = '条';
$LANG['auction_goods']       = '拍卖商品';
$LANG['auction_goods_info']  = '拍卖商品详情';
$LANG['article_cat']         = '文章分类';
$LANG['online_vote']         = '在线调查';
$LANG['new_price']           = '最新出价';
$LANG['promotion_info']      = '促销信息';
$LANG['price_grade']         = '价格范围';
$LANG['your_choice']         = '您的选择';
$LANG['system_info']         = '系统信息';
$LANG['all_tags']            = '所有标签';
$LANG['activity_list']       = '活动列表';
$LANG['package_list']        = '礼包列表';
$LANG['treasure_info']       = '宝贝详情';
$LANG['activity_desc']       = '活动描述';
$LANG['activity_intro']      = '活动介绍';
$LANG['get_password']        = '找回密码';
$LANG['fee_total']           = '费用总计';
$LANG['other_info']          = '其它信息';
$LANG['user_balance']        = '会员余额';
$LANG['wholesale_goods_cart'] = '批发商品购物车';
$LANG['wholesale_goods_list'] = '批发商品列表';
$LANG['wholesale_goods_info'] = '批发商品';
$LANG['bid_record']          = '出价记录';
$LANG['shipping_method']     = '配送方式';
$LANG['payment_method']      = '支付方式';
$LANG['goods_package']       = '商品包装';
$LANG['goods_card']          = '祝福贺卡';
$LANG['groupbuy_intro']      = '团购说明';
$LANG['groupbuy_goods_info'] = '团购商品详情';
$LANG['act_time']            = '起止时间';
$LANG['top10']               = '销售排行';

/* 优惠活动 */
$LANG['label_act_name']     = '优惠活动名称：';
$LANG['label_start_time']   = '优惠开始时间：';
$LANG['label_end_time']     = '优惠结束时间：';
$LANG['label_user_rank']    = '享受优惠的会员等级：';
$LANG['not_user']           = '非会员';
$LANG['label_act_range']    = '优惠范围：';
$LANG['far_all']            = '全部商品';
$LANG['far_category']       = '以下分类';
$LANG['far_brand']          = '以下品牌';
$LANG['far_goods']          = '以下商品';
$LANG['label_min_amount']   = '金额下限：';
$LANG['label_max_amount']   = '金额上限：';
$LANG['notice_max_amount']  = '0表示没有上限';
$LANG['label_act_type']     = '优惠方式：';
$LANG['fat_goods']          = '享受赠品（特惠品）';
$LANG['fat_price']          = '享受现金减免';
$LANG['fat_discount']       = '享受价格折扣';
$LANG['orgtotal']           = '原始价格';
$LANG['heart_buy']          = '心动不如行动';

/* 其他模板涉及常用语言项 */
$LANG['label_regist']       = '用户注册';
$LANG['label_login']        = '用户登录';
$LANG['label_profile']      = '用户信息';
$LANG['label_collection']   = '我的收藏';
$LANG['article_list']       = '文章列表';
$LANG['preferences_price']  = '优惠价格';
$LANG['divided_into']       = '分成规则';

/*------------------------------------------------------ */
//-- 操作类型
/*------------------------------------------------------ */
$LANG['log_action']['add']              = '添加';
$LANG['log_action']['remove']           = '删除';
$LANG['log_action']['edit']             = '编辑';
$LANG['log_action']['install']          = '安装';
$LANG['log_action']['uninstall']        = '卸载';
$LANG['log_action']['setup']            = '设置';
$LANG['log_action']['batch_remove']     = '批量删除';
$LANG['log_action']['trash']            = '回收';
$LANG['log_action']['restore']          = '还原';
$LANG['log_action']['batch_trash']      = '批量回收';
$LANG['log_action']['batch_restore']    = '批量还原';
$LANG['log_action']['batch_upload']     = '批量上传';
$LANG['log_action']['batch_edit']       = '批量编辑';

/*------------------------------------------------------ */
//-- 操作内容
/*------------------------------------------------------ */
$LANG['log_action']['users']            = '会员账号';
$LANG['log_action']['shipping']         = '配送方式';
$LANG['log_action']['shipping_area']    = '配送区域';
$LANG['log_action']['area_region']      = '配送区域中的地区';
$LANG['log_action']['brand']            = '品牌管理';
$LANG['log_action']['category']         = '商品分类';
$LANG['log_action']['pack']             = '商品包装';
$LANG['log_action']['card']             = '商品贺卡';
$LANG['log_action']['articlecat']       = '文章分类';
$LANG['log_action']['article']          = '文章';
$LANG['log_action']['shophelp']         = '网店帮助文章';
$LANG['log_action']['shophelpcat']      = '网店帮助分类';
$LANG['log_action']['shopinfo']         = '网店信息文章';
$LANG['log_action']['attribute']        = '属性';
$LANG['log_action']['privilege']        = '权限管理';
$LANG['log_action']['user_rank']        = '会员等级';
$LANG['log_action']['snatch']           = '夺宝奇兵';
$LANG['log_action']['bonustype']        = '红包类型';
$LANG['log_action']['userbonus']        = '用户红包';
$LANG['log_action']['vote']             = '在线调查';
$LANG['log_action']['friendlink']       = '友情链接';
$LANG['log_action']['goods']            = '商品';
$LANG['log_action']['payment']          = '支付方式';
$LANG['log_action']['order']            = '订单';
$LANG['log_action']['agency']           = '办事处';
$LANG['log_action']['auction']          = '拍卖活动';
$LANG['log_action']['favourable']       = '优惠活动';
$LANG['log_action']['wholesale']        = '批发活动';

$LANG['log_action']['adminlog']         = '操作日志';
$LANG['log_action']['admin_message']    = '管理员留言';
$LANG['log_action']['users_comment']    = '用户评论';
$LANG['log_action']['ads_position']     = '广告位置';
$LANG['log_action']['ads']              = '广告';
$LANG['log_action']['area']             = '地区';

$LANG['log_action']['group_buy']        = '团购商品';
$LANG['log_action']['goods_type']       = '商品类型';
$LANG['log_action']['booking']          = '缺货登记管理';
$LANG['log_action']['tag_manage']       = '标签管理';
$LANG['log_action']['shop_config']      = '商店设置';
$LANG['log_action']['languages']        = '前台语言项';
$LANG['log_action']['user_surplus']     = '会员余额';
$LANG['log_action']['message']          = '会员留言';
$LANG['log_action']['fckfile']          = 'FCK文件';

$LANG['log_action']['db_backup']        = '数据库备份';
$LANG['log_action']['package']          = '超值礼包';
$LANG['log_action']['exchange_goods']   = '积分可兑换的商品';
$LANG['log_action']['suppliers']        = '供货商管理';
$LANG['log_action']['reg_fields']       = '会员注册项';

/*------------------------------------------------------ */
//-- 购物流程
/*------------------------------------------------------ */
$LANG['flow_login_register']['username_not_null']   = '请您输入用户名。';
$LANG['flow_login_register']['username_invalid']    = '您输入了一个无效的用户名。';
$LANG['flow_login_register']['password_not_null']   = '请您输入密码。';
$LANG['flow_login_register']['email_not_null']      = '请您输入电子邮件。';
$LANG['flow_login_register']['email_invalid']       = '您输入的电子邮件不正确。';
$LANG['flow_login_register']['password_not_same']   = '您输入的密码和确认密码不一致。';
$LANG['flow_login_register']['password_lt_six']     = '密码不能小于6个字符。';

$LANG['regist_success'] = "恭喜您，%s 账号注册成功!";
$LANG['login_success']  = '恭喜！您已经成功登录本站！';
$LANG['order_list']     = '订单列表';

/* 购物车 */
$LANG['buy_now']                        = '立即购买';
$LANG['update_cart']                    = '更新购物车';
$LANG['back_to_cart']                   = '返回购物车';
$LANG['update_cart_notice']             = '购物车更新成功，请您重新选择您需要的赠品。';
$LANG['direct_shopping']                = '直接购买';
$LANG['goods_not_exists']               = '对不起，指定的商品不存在';
$LANG['drop_goods_confirm']             = '您确定要把该商品移出购物车吗？';
$LANG['goods_number_not_int']           = '请您输入正确的商品数量。';
$LANG['stock_insufficiency']            = '非常抱歉，您选择的商品 %s 的库存数量只有 %d，您最多只能购买 %d 件。';
$LANG['package_stock_insufficiency']    = '非常抱歉，您选择的超值礼包数量已经超出库存。请您减少购买量或联系商家。';
$LANG['shopping_flow']                  = '购物流程';
$LANG['username_exists']                = '您输入的用户名已存在，请换一个试试。';
$LANG['email_exists']                   = '您输入的电子邮件已存在，请换一个试试。';
$LANG['surplus_not_enough']             = '您使用的余额不能超过您现有的余额。';
$LANG['integral_not_enough']            = '您使用的积分不能超过您现有的积分。';
$LANG['integral_too_much']              = "您使用的积分不能超过%d";
$LANG['invalid_bonus']                  = "您选择的红包并不存在。";
$LANG['no_goods_in_cart']               = '您的购物车中没有商品！';
$LANG['not_submit_order']               = '您参与本次团购商品的订单已提交，请勿重复操作！';
$LANG['pay_success']                    = '本次支付已经成功，我们将尽快为您发货。';
$LANG['pay_fail']                       = '本次支付失败，请及时和我们取得联系。';
$LANG['pay_disabled']                   = '您选用的支付方式已经被停用。';
$LANG['pay_invalid']                    = '您选用了一个无效的支付方式。该支付方式不存在或者已经被停用。请您立即和我们取得联系。';
$LANG['flow_no_shipping']               = '您必须选定一个配送方式。';
$LANG['flow_no_payment']                = '您必须选定一个支付方式。';
$LANG['pay_not_exist']                  = '选用的支付方式不存在。';
$LANG['storage_short']                  = '库存不足';
$LANG['subtotal']                       = '小计';
$LANG['accessories']                    = '配件';
$LANG['largess']                        = '赠品';
$LANG['shopping_money']                 = '购物金额小计 %s';
$LANG['than_market_price']              = '比市场价 %s 节省了 %s (%s)';
$LANG['your_discount']                  = '根据优惠活动<span color=red>%s</span>，您可以享受折扣 %s';
$LANG['no']                             = '无';
$LANG['not_support_virtual_goods']      = '购物车中存在非实体商品,不支持匿名购买,请登录后在购买';
$LANG['not_support_insure']             = '不支持保价';
$LANG['clear_cart']                     = '清空购物车';
$LANG['drop_to_collect']                = '放入收藏夹';
$LANG['password_js']['show_div_text']   = '请点击更新购物车按钮';
$LANG['password_js']['show_div_exit']   = '关闭';
$LANG['goods_fittings']                 = '商品相关配件';
$LANG['parent_name']                    = '相关商品：';
$LANG['remark_package']                 = '礼包';

/* 优惠活动 */
$LANG['favourable_name']        = '活动名称：';
$LANG['favourable_period']      = '优惠期限：';
$LANG['favourable_range']       = '优惠范围：';
$LANG['far_ext'][FAR_ALL]       = '全部商品';
$LANG['far_ext'][FAR_BRAND]     = '以下品牌';
$LANG['far_ext'][FAR_CATEGORY]  = '以下分类';
$LANG['far_ext'][FAR_GOODS]     = '以下商品';
$LANG['favourable_amount']      = '金额区间：';
$LANG['favourable_type']        = '优惠方式：';
$LANG['fat_ext'][FAT_DISCOUNT]  = '享受 %d%% 的折扣';
$LANG['fat_ext'][FAT_GOODS]     = '从下面的赠品（特惠品）中选择 %d 个（0表示不限制数量）';
$LANG['fat_ext'][FAT_PRICE]     = '直接减少现金 %d';

$LANG['favourable_not_exist']       = '您要加入购物车的优惠活动不存在';
$LANG['favourable_not_available']   = '您不能享受该优惠';
$LANG['favourable_used']            = '该优惠活动已加入购物车了';
$LANG['pls_select_gift']            = '请选择赠品（特惠品）';
$LANG['gift_count_exceed']          = '您选择的赠品（特惠品）数量超过上限了';
$LANG['gift_in_cart']               = '您选择的赠品（特惠品）已经在购物车中了：%s';
$LANG['label_favourable']           = '优惠活动';
$LANG['label_collection']           = '我的收藏';
$LANG['collect_to_flow']            = '立即购买';

/* 登录注册 */
$LANG['forthwith_login']            = '登录';
$LANG['forthwith_register']         = '注册新用户';
$LANG['message_authentication_code'] = '请输入收到的短信验证码';
$LANG['input_verification']         = '输入验证码';
$LANG['return_verification']        = '获取验证码';
$LANG['invitation_code']            = '可输入好友的邀请码（选填）';
$LANG['login_finish']               = '完成';
$LANG['set_password']               = '设置密码';
$LANG['reset_new_password']         = '设置新密码';
$LANG['input_new_password']         = '请输入新密码';
$LANG['input_new_password_again']   = '请再次输入新密码';
$LANG['signin_failed']              = '对不起，登录失败，请检查您的用户名和密码是否正确';
$LANG['gift_remainder']             = '说明：在您登录或注册后，请到购物车页面重新选择赠品。';

/* 收货人信息 */
$LANG['flow_js']['consignee_not_null']  = '收货人姓名不能为空！';
$LANG['flow_js']['country_not_null']    = '请您选择收货人所在国家！';
$LANG['flow_js']['province_not_null']   = '请您选择收货人所在省份！';
$LANG['flow_js']['city_not_null']       = '请您选择收货人所在城市！';
$LANG['flow_js']['district_not_null']   = '请您选择收货人所在区域！';
$LANG['flow_js']['invalid_email']       = '您输入的邮件地址不是一个合法的邮件地址。';
$LANG['flow_js']['address_not_null']    = '收货人的详细地址不能为空！';
$LANG['flow_js']['tele_not_null']       = '电话不能为空！';
$LANG['flow_js']['shipping_not_null']   = '请您选择配送方式！';
$LANG['flow_js']['payment_not_null']    = '请您选择支付方式！';
$LANG['flow_js']['goodsattr_style']     = 1;
$LANG['flow_js']['tele_invaild']        = '电话号码不有效的号码';
$LANG['flow_js']['zip_not_num']         = '邮政编码只能填写数字';
$LANG['flow_js']['mobile_invaild']      = '手机号码不是合法号码';
$LANG['flow_js']['mobile_not_null']     = '手机号码不能为空';

$LANG['new_consignee_address']  = '新收货地址';
$LANG['consignee_address']      = '收货地址';
$LANG['consignee_name']         = '收货人姓名';
$LANG['country_province']       = '配送区域';
$LANG['please_select']          = '请选择';
$LANG['city_district']          = '城市/地区';
$LANG['email_address']          = '电子邮件地址';
$LANG['detailed_address']       = '详细地址';
$LANG['postalcode']             = '邮政编码';
$LANG['phone']                  = '电话';
$LANG['mobile']                 = '手机';
$LANG['backup_phone']           = '手机';
$LANG['sign_building']          = '标志建筑';
$LANG['deliver_goods_time']     = '最佳送货时间';
$LANG['default']                = '默认';
$LANG['default_address']        = '默认地址';
$LANG['confirm_submit']         = '确认提交';
$LANG['confirm_edit']           = '确认修改';
$LANG['country']                = '国家';
$LANG['province']               = '省份';
$LANG['city']                   = '城市';
$LANG['area']                   = '所在区域';
$LANG['consignee_add']          = '添加新收货地址';
$LANG['shipping_address']       = '配送至这个地址';
$LANG['address_amount']         = '您的收货地址最多只能是三个';
$LANG['not_fount_consignee']    = '对不起，您选定的收货地址不存在。';

/*------------------------------------------------------ */
//-- 订单提交
/*------------------------------------------------------ */

$LANG['goods_amount_not_enough'] = '您购买的商品没有达到本店的最低限购金额 %s ，不能提交订单。';
$LANG['balance_not_enough']      = '您的余额不足以支付整个订单，请选择其他支付方式';
$LANG['select_shipping']         = '您选定的配送方式为';
$LANG['select_payment']          = '您选定的支付方式为';
$LANG['change_payment']          = '或更换支付方式';
$LANG['order_amount']            = '您的应付款金额为';
$LANG['remember_order_number']   = '请记住您的订单号：';
$LANG['back_home']               = '返回首页';
$LANG['goto_user_center']        = '用户中心';
$LANG['order_submit_back']       = '您可以 %s 或去 %s';

$LANG['order_placed_sms']        = "您有新订单.收货人:%s 电话:%s";
$LANG['sms_paid']                = '已付款';

$LANG['notice_gb_order_amount']  = '（备注：团购如果有保证金，第一次只需支付保证金和相应的支付费用）';

$LANG['order_effective']        = '订单已生效';
$LANG['pay_order']              = '支付订单 %s';
$LANG['validate_bonus']         = '验证红包';
$LANG['input_bonus_no']         = '或者输入红包序列号';
$LANG['select_bonus']           = '选择已有红包';
$LANG['bonus_sn_error']         = '该红包序列号不正确';
$LANG['bonus_min_amount_error'] = '订单商品金额没有达到使用该红包的最低金额 %s';
$LANG['bonus_is_ok']            = '该红包序列号可以使用，可以抵扣 %s';

$LANG['shopping_myship']    = '我的配送';
$LANG['shopping_activity']  = '活动列表';
$LANG['shopping_package']   = '超值礼包列表';

//end