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
/**
 * ECJia 后台日志管理类
 * @author royalwang
 *
 */
class ecjia_admin_log {
    /**
     * 日志动作
     * @var array
     */
    private $log_action;
    /**
     * 日志对象
     * @var array
     */
    private $log_object;
    
    
    private static $instance = null;
    
    /**
     * 返回当前终级类对象的实例
     *
     * @param $cache_config 缓存配置
     * @return object
     */
    public static function instance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function __construct() {
        $this->log_action = array(
            'add'               => __('添加'),
            'edit'              => __('编辑'),
        	'use'            	=> __('启用'),
        	'stop'            	=> __('停用'),
            'remove'            => __('删除'),
            'install'           => __('安装'),
            'uninstall'         => __('卸载'),
            'setup'             => __('设置'),
            'trash'             => __('回收'),
            'restore'           => __('还原'),
            'merge'             => __('合并'),
            'batch_remove'      => __('批量删除'),
            'batch_trash'       => __('批量回收'),
            'batch_restore'     => __('批量还原'),
            'batch_upload'      => __('批量上传'),
            'batch_edit'        => __('批量编辑'),
        	'batch_stop'        => __('批量停用'),
        );
        
        
        $this->log_object = array(
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
     * 添加日志动作
     * @param string $code
     * @param string $name
     */
    public function add_action($code, $name) {
        if ($code && $name) {
            $this->log_action[$code] = $name;
        }
    }
    
    /**
     * 判断是否有这个日志动作
     * @param unknown $code
     * @return boolean
     */
    public function has_action($code) {
        if (isset($this->log_action[$code]) && $this->log_action[$code]) {
            return true;
        }
        return false;
    }
    
    /**
     * 添加日志对象
     * @param string $code
     * @param string $name
     */
    public function add_object($code, $name) {
        if ($code && $name) {
            $this->log_object[$code] = $name;
        }
    }

    /**
     * 判断是否有这个日志对象
     * @param unknown $code
     * @return boolean
     */
    public function has_object($code) {
        if (isset($this->log_object[$code]) && $this->log_action[$code]) {
            return true;
        }
        return false;
    }
    
    /**
     * 记录管理员的操作内容
     * @param   string      $sn         数据的唯一值
     * @param   string      $action     操作的类型
     * @param   string      $content    操作的内容
     * @return  string
     */
    public function get_message($sn, $action, $content) {
        if ($this->log_action[$action] && $this->log_object[$content]) {
            $log_info = $this->log_action[$action] .' '. $this->log_object[$content] .': '. addslashes($sn);
        } else {
            $log_info = addslashes($sn);
        }

        return $log_info;
    } 
}

// end