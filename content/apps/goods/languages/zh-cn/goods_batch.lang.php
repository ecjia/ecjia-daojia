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
 * ECJIA 商品批量上传、修改语言文件
 */
$LANG['select_method'] = '选择商品的方式：';
$LANG['by_cat'] = '根据商品分类、品牌';
$LANG['by_sn'] = '根据商品货号';
$LANG['select_cat'] = '选择商品分类：';
$LANG['select_brand'] = '选择商品品牌：';
$LANG['goods_list'] = '商品列表：';
$LANG['src_list'] = '待选列表：';
$LANG['dest_list'] = '选定列表：';
$LANG['input_sn'] = '输入商品货号：<br />（每行一个）';
$LANG['edit_method'] = '编辑方式：';
$LANG['edit_each'] = '逐个编辑';
$LANG['edit_all'] = '统一编辑';
$LANG['go_edit'] = '进入编辑';

$LANG['notice_edit'] = '会员价格为-1表示会员价格将根据会员等级折扣比例计算';

$LANG['goods_class'] = '商品类别';
$LANG['g_class'][G_REAL] = '实体商品';
$LANG['g_class'][G_CARD] = '虚拟卡';

$LANG['goods_sn'] = '货号';
$LANG['goods_name'] = '商品名称';
$LANG['market_price'] = '市场价格';
$LANG['shop_price'] = '本店价格';
$LANG['integral'] = '积分购买';
$LANG['give_integral'] = '赠送积分';
$LANG['goods_number'] = '库存';
$LANG['brand'] = '品牌';

$LANG['batch_edit_ok'] = '批量修改成功';

$LANG['export_format'] = '数据格式';
$LANG['export_ecshop'] = 'ECSJia支持数据格式';
$LANG['export_taobao'] = '淘宝助理支持数据格式';
$LANG['export_taobao46'] = '淘宝助理4.6支持数据格式';
$LANG['export_paipai'] = '拍拍助理支持数据格式';
$LANG['export_paipai3'] = '拍拍助理3.0支持数据格式';
$LANG['goods_cat'] = '所属分类：';
$LANG['csv_file'] = '上传批量csv文件：';
$LANG['notice_file'] = '（CSV文件中一次上传商品数量最好不要超过1000，CSV文件大小最好不要超过500K.）';
$LANG['file_charset'] = '文件编码：';
$LANG['download_file'] = '下载批量CSV文件（%s）';
$LANG['use_help'] = '使用说明：' .
        '<ol>' .
          '<li>根据使用习惯，下载相应语言的csv文件，例如中国内地用户下载简体中文语言的文件，港台用户下载繁体语言的文件；</li>' .
          '<li>填写csv文件，可以使用excel或文本编辑器打开csv文件；<br />' .
              '碰到“是否精品”之类，填写数字0或者1，0代表“否”，1代表“是”；<br />' .
              '商品图片和商品缩略图请填写带路径的图片文件名，其中路径是相对于 [根目录]/images/ 的路径，例如图片路径为[根目录]/images/200610/abc.jpg，只要填写 200610/abc.jpg 即可；<br />' .
               '<font style="color:#FE596A;">如果是淘宝助理格式请确保cvs编码为在网站的编码，如编码不正确，可以用编辑软件转换编码。</font></li>' .
          '<li>将填写的商品图片和商品缩略图上传到相应目录，例如：[根目录]/images/200610/；<br />'.
              '<font style="color:#FE596A;">请首先上传商品图片和商品缩略图再上传csv文件，否则图片无法处理。</font></li>' .
          '<li>选择所上传商品的分类以及文件编码，上传csv文件</li>' .
        '</ol>';

$LANG['js_languages']['please_select_goods'] = '请您选择商品';
$LANG['js_languages']['please_input_sn'] = '请您输入商品货号';
$LANG['js_languages']['goods_cat_not_leaf'] = '请选择底级分类';
$LANG['js_languages']['please_select_cat'] = '请您选择所属分类';
$LANG['js_languages']['please_upload_file'] = '请您上传批量csv文件';

// 批量上传商品的字段
$LANG['upload_goods']['goods_name'] = '商品名称';
$LANG['upload_goods']['goods_sn'] = '商品货号';
$LANG['upload_goods']['brand_name'] = '商品品牌';   // 需要转换成brand_id
$LANG['upload_goods']['market_price'] = '市场售价';
$LANG['upload_goods']['shop_price'] = '本店售价';
$LANG['upload_goods']['integral'] = '积分购买额度';
$LANG['upload_goods']['original_img'] = '商品原始图';
$LANG['upload_goods']['goods_img'] = '商品图片';
$LANG['upload_goods']['goods_thumb'] = '商品缩略图';
$LANG['upload_goods']['keywords'] = '商品关键词';
$LANG['upload_goods']['goods_brief'] = '简单描述';
$LANG['upload_goods']['goods_desc'] = '详细描述';
$LANG['upload_goods']['goods_weight'] = '商品重量（kg）';
$LANG['upload_goods']['goods_number'] = '库存数量';
$LANG['upload_goods']['warn_number'] = '库存警告数量';
$LANG['upload_goods']['is_best'] = '是否精品';
$LANG['upload_goods']['is_new'] = '是否新品';
$LANG['upload_goods']['is_hot'] = '是否热销';
$LANG['upload_goods']['is_on_sale'] = '是否上架';
$LANG['upload_goods']['is_alone_sale'] = '能否作为普通商品销售';
$LANG['upload_goods']['is_real'] = '是否实体商品';

$LANG['batch_upload_ok'] = '批量上传成功';
$LANG['goods_upload_confirm'] = '批量上传确认';

// end