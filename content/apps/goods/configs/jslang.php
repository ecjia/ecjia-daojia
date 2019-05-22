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
 * js语言包设置
 */

defined('IN_ECJIA') or exit('No permission resources.');

return array(
    //goods
    'attribute_page' => array(
        'spec_name_required' => __('请输入规格名称', 'goods'),
        'attr_name_required' => __('请输入属性名称', 'goods'),
        'cat_id_select'      => __('请选择所属商品类型！', 'goods'),
    ),
		
	'spec_product_page' => array(
		'tip_msg' => __('更换模板，会将之前已添加的相关规格属性以及货品进行清除，请谨慎操作，您确定要【清除】吗？', 'goods'),
		'ok'      => __('确定', 'goods'),
        'cancel'  => __('取消', 'goods'),
	),

    'auto_page' => array(
        'editable_miss_parameters' => __('editable缺少参数', 'goods'),
        'edit_info'                => __('编辑信息', 'goods'),
    ),

    'brand_page' => array(
        'brand_name_required' => __('请输入品牌名称', 'goods'),
    ),

    'category_page' => array(
        'sel_filter_attr'   => __('请选择筛选属性', 'goods'),
        'cat_name_required' => __('请输入分类名称', 'goods'),
        'no_select_ad'      => __('没有搜索到结果', 'goods'),
        'move_cat_confirm'  => __('您确定转移分类下的商品吗？', 'goods'),
        'ok'                => __('确定', 'goods'),
        'cancel'            => __('取消', 'goods'),
    ),

    'goods_list_page' => array(
        'ok'                       => __('确定', 'goods'),
        'cancel'                   => __('取消', 'goods'),
        'editable_miss_parameters' => __('editable缺少参数', 'goods'),
        'edit_info'                => __('编辑信息', 'goods'),

        'pls_select'          => __('请选择...', 'goods'),
        'search_empty'        => __('未找到搜索内容!', 'goods'),
        'choose_select_goods' => __('请选择需要转移的商品', 'goods'),

        'wait_check'      => __('待审核', 'goods'),
        'check_no_access' => __('审核未通过', 'goods'),
        'check_access'    => __('审核已通过', 'goods'),
        'check_no_need'   => __('无需审核', 'goods'),

        'import_goods'          => __('开始导入', 'goods'),
        'importing'             => __('导入中', 'goods'),
        'goods_name_required'   => __('请输入商品名称！', 'goods'),
        'shop_price_required'   => __('请输入商品价格！', 'goods'),
        'shop_price_limit'      => __('请输入正确价格格式！', 'goods'),
        'goods_number_required' => __('请输入库存！', 'goods'),
        'goods_number_limit'    => __('商品库存最小只能为0！', 'goods'),
        'category_id_select'    => __('请选择商品分类！', 'goods'),
        'enter_goods_sn'        => __('请输入商品货号', 'goods'),
        'product_sn_required'	=> __('请输入货号', 'goods'),
        'product_number_required' => __('请输入库存', 'goods'),
        'brand_name_empty'      => __('品牌名称不能为空', 'goods'),
        'cat_name_required'     => __('请输入类型名称', 'goods'),
        'not_calculate'           => __('未计算', 'goods'),
        'empty_data'           => __('暂无内容', 'goods'),


        'add_new_mate'       => __('添加新栏目', 'goods'),
        'back_select_mate'   => __('返回选择栏目', 'goods'),
        'select_goods_empty' => __('未搜索到商品信息', 'goods'),

        'modify_price'         => __('修改价格', 'goods'),
        'save'                 => __('保存', 'goods'),
        'price'                => __('价格', 'goods'),
        'select_article_empty' => __('未搜索到文章信息', 'goods'),
        'drag_here_upload'     => __('将图片拖动至此处上传', 'goods'),

        'change_connect' => __('切换关联', 'goods'),
        'single'         => __('单向关联', 'goods'),
        'double'         => __('双向关联', 'goods'),
        'give_up_confirm'		=> __('您确定放弃当前页面编辑的内容吗？', 'goods'),
        'add_goods_ok' 			=> __('添加商品成功', 'goods'),
        'cat_name_empty'		=> __('分类名称不能为空', 'goods'),
    ),


);
//end
