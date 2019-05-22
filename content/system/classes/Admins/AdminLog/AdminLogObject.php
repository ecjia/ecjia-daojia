<?php


namespace Ecjia\System\Admins\AdminLog;


class AdminLogObject
{

    protected $items;


    public function __construct()
    {

        $this->items = array(
            'privilege'         => __('权限管理'),
            'adminlog'          => __('操作日志'),
            'admin_message'     => __('管理员留言'),
            'area'              => __('地区'),
            'shop_config'       => __('商店设置'),


            'users'             => __('会员账号'),
            'shipping'          => __('配送方式'),
            'shipping_area'     => __('配送区域'),
            'area_region'       => __('配送区域中的地区'),

            'goods'             => __('商品'),
            'brand'             => __('品牌管理'),
            'category'          => __('商品分类'),
            'pack'              => __('商品包装'),
            'card'              => __('商品贺卡'),
            'attribute'         => __('属性'),
            'goods_type'        => __('商品类型'),


            'articlecat'        => __('文章分类'),
            'article'           => __('文章'),
            'shophelp'          => __('网店帮助文章'),
            'shophelpcat'       => __('网店帮助分类'),
            'shopinfo'          => __('网店信息文章'),


            'user_rank'         => __('会员等级'),
            'snatch'            => __('夺宝奇兵'),
            'bonustype'         => __('红包类型'),
            'userbonus'         => __('用户红包'),
            'vote'              => __('在线调查'),
            'friendlink'        => __('友情链接'),
            'payment'           => __('支付方式'),

            'order'             => __('订单'),
            'agency'            => __('办事处'),
            'auction'           => __('拍卖活动'),
            'favourable'        => __('优惠活动'),
            'wholesale'         => __('批发活动'),
            'feedback'          => __('留言反馈'),
            'users_comment'     => __('用户评论'),
            'ads_position'      => __('广告位置'),
            'ads'               => __('广告'),
            'group_buy'         => __('团购商品'),
            'booking'           => __('缺货登记管理'),
            'tag_manage'        => __('标签管理'),
            'languages'         => __('前台语言项'),
            'user_surplus'      => __('会员余额'),
            'message'           => __('会员留言'),
            'fckfile'           => __('FCK文件'),
            'db_backup'         => __('数据库备份'),
            'package'           => __('超值礼包'),
            'exchange_goods'    => __('积分可兑换的商品'),
            'suppliers'         => __('供货商管理'),
            'reg_fields'        => __('会员注册项'),

            'license'			=> __('授权证书'),
            'issuer'			=> __('信任机构'),
            'app'				=> __('应用'),
            'plugin'			=> __('插件'),
        );

    }


    /**
     * 添加日志对象
     *
     * @param string $code
     * @param string $name
     *
     * @return $this
     */
    public function addObject($code, $name)
    {
        if ($code && $name) {
            $this->items[$code] = $name;
        }

        return $this;
    }

    /**
     * 批量添加日志对象
     *
     * @param array $objects
     *
     * @return $this
     */
    public function addObjects(array $objects)
    {
        foreach ($objects as $code => $name) {
            $this->items[$code] = $name;
        }

        return $this;
    }


    /**
     * 判断是否有这个日志对象
     *
     * @param string $code
     *
     * @return boolean
     */
    public function hasObject($code)
    {
        return array_has($this->items, $code);
    }

    /**
     * 获取指定日志对象
     *
     * @param $code
     * @param null $default
     *
     * @return string
     */
    public function getObject($code, $default = null)
    {
        return array_get($this->items, $code, $default);
    }

}