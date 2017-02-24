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

/**
 * 商品操作类
 * @author royalwang
 */
class goods_method {
    
    private $goods_id;
    
    public function __construct($goods_id = '') {
        $this->goods_id = $goods_id;
    }
    
    /**
     * 插入或更新商品属性
     *
     * @param int $goods_id
     *            商品编号
     * @param array $id_list
     *            属性编号数组
     * @param array $is_spec_list
     *            是否规格数组 'true' | 'false'
     * @param array $value_price_list
     *            属性值数组
     * @return array 返回受到影响的goods_attr_id数组
     */
    function handle_goods_attr($id_list, $is_spec_list, $value_price_list) {
        $goods_id = $this->goods_id;
        
        $db = RC_Loader::load_app_model('goods_attr_model', 'goods');
    
        $goods_attr_id = array();
    
        /* 循环处理每个属性 */
        foreach ($id_list as $key => $id) {
            $is_spec = $is_spec_list [$key];
            if ($is_spec == 'false') {
                $value = $value_price_list [$key];
                $price = '';
            } else {
                $value_list = array();
                $price_list = array();
                if ($value_price_list [$key]) {
                    $vp_list = explode(chr(13), $value_price_list [$key]);
                    foreach ($vp_list as $v_p) {
                        $arr = explode(chr(9), $v_p);
                        $value_list [] = $arr [0];
                        $price_list [] = $arr [1];
                    }
                }
                $value = join(chr(13), $value_list);
                $price = join(chr(13), $price_list);
            }
    
            // 插入或更新记录
            $result_id = $db->where(array('goods_id' => $goods_id, 'attr_id' => $id, 'attr_value' => $value))->get_field('goods_attr_id');
            $result_id = $result_id ['goods_attr_id'];
            if (!empty ($result_id)) {
                $data = array(
                    'attr_value' => $value
                );
                $db->where(array('goods_id' => $goods_id, 'attr_id' => $id, 'goods_attr_id' => $result_id))->update($data);
                $goods_attr_id [$id] = $result_id;
            } else {
                $data = array(
                    'goods_id' => $goods_id,
                    'attr_id' => $id,
                    'attr_value' => $value,
                    'attr_price' => $price
                );
                $insert_id = $db->insert($data);
            }
            if ($goods_attr_id [$id] == '') {
                $goods_attr_id [$id] = $insert_id;
            }
        }
    
        return $goods_attr_id;
    }
}

// end