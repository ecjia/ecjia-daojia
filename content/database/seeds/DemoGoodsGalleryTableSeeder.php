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
 * 插入数据 `ecjia_goods_gallery` 商品相册
 */
use Royalcms\Component\Database\Seeder;

class DemoGoodsGalleryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            array(
                'img_id'        => '1650',
                'goods_id'      => '617',
                'img_url'       => 'images/201610/goods_img/617_P_1459128638008.jpg',
                'img_desc'      => '9288692936286320_300.jpg',
                'thumb_url'     => 'images/201610/goods_img/617_P_1459128638008.jpg',
                'img_original'  => 'images/201610/goods_img/617_P_1459128638008.jpg',
            ),
            array(
                'img_id'        => '1871',
                'goods_id'      => '466',
                'img_url'       => 'images/201610/goods_img/466_P_1459217956197.jpg',
                'img_desc'      => '9288693067817079_500.jpg',
                'thumb_url'     => 'images/201610/goods_img/466_P_1459217956197.jpg',
                'img_original'  => 'images/201610/goods_img/466_P_1459217956197.jpg',
            ),
            array(
                'img_id'        => '1872',
                'goods_id'      => '466',
                'img_url'       => 'images/201610/goods_img/466_P_1459217957133.jpg',
                'img_desc'      => '9288693067849847_500.jpg',
                'thumb_url'     => 'images/201610/goods_img/466_P_1459217957133.jpg',
                'img_original'  => 'images/201610/goods_img/466_P_1459217957133.jpg',
            ),
            array(
                'img_id'        => '1880',
                'goods_id'      => '460',
                'img_url'       => 'images/201610/goods_img/460_P_1459218374020.jpg',
                'img_desc'      => '9288691846881331_500.jpg',
                'thumb_url'     => 'images/201610/goods_img/460_P_1459218374020.jpg',
                'img_original'  => 'images/201610/goods_img/460_P_1459218374020.jpg',
            ),
            array(
                'img_id'        => '1881',
                'goods_id'      => '460',
                'img_url'       => 'images/201610/goods_img/460_P_1459218374758.jpg',
                'img_desc'      => '9288691846914099_500.jpg',
                'thumb_url'     => 'images/201610/goods_img/460_P_1459218374758.jpg',
                'img_original'  => 'images/201610/goods_img/460_P_1459218374758.jpg',
            ),
            array(
                'img_id'        => '1886',
                'goods_id'      => '461',
                'img_url'       => 'images/201610/goods_img/461_P_1459218616992.jpg',
                'img_desc'      => '151010141737717_10957_500.jpg',
                'thumb_url'     => 'images/201610/goods_img/461_P_1459218616992.jpg',
                'img_original'  => 'images/201610/goods_img/461_P_1459218616992.jpg',
            ),
            array(
                'img_id'        => '1887',
                'goods_id'      => '461',
                'img_url'       => 'images/201610/goods_img/461_P_1459218616392.jpg',
                'img_desc'      => '151010141736843_10957_500.jpg',
                'thumb_url'     => 'images/201610/goods_img/461_P_1459218616392.jpg',
                'img_original'  => 'images/201610/goods_img/461_P_1459218616392.jpg',
            ),
            array(
                'img_id'        => '1888',
                'goods_id'      => '468',
                'img_url'       => 'images/201610/goods_img/468_P_1459218724322.jpg',
                'img_desc'      => '9288692894343278_500.jpg',
                'thumb_url'     => 'images/201610/goods_img/468_P_1459218724322.jpg',
                'img_original'  => 'images/201610/goods_img/468_P_1459218724322.jpg',
            ),
            array(
                'img_id'        => '1889',
                'goods_id'      => '468',
                'img_url'       => 'images/201610/goods_img/468_P_1459218725630.jpg',
                'img_desc'      => '9288692894310510_500.jpg',
                'thumb_url'     => 'images/201610/goods_img/468_P_1459218725630.jpg',
                'img_original'  => 'images/201610/goods_img/468_P_1459218725630.jpg',
            ),
            array(
                'img_id'        => '1890',
                'goods_id'      => '433',
                'img_url'       => 'images/201610/goods_img/433_P_1459218758797.jpg',
                'img_desc'      => '1510220245069750.jpg',
                'thumb_url'     => 'images/201610/goods_img/433_P_1459218758797.jpg',
                'img_original'  => 'images/201610/goods_img/433_P_1459218758797.jpg',
            ),
            array(
                'img_id'        => '1891',
                'goods_id'      => '433',
                'img_url'       => 'images/201610/goods_img/433_P_1459218760341.jpg',
                'img_desc'      => '1510220245045032.jpg',
                'thumb_url'     => 'images/201610/goods_img/433_P_1459218760341.jpg',
                'img_original'  => 'images/201610/goods_img/433_P_1459218760341.jpg',
            ),
            array(
                'img_id'        => '1892',
                'goods_id'      => '395',
                'img_url'       => 'images/201610/goods_img/395_P_1459218832155.jpg',
                'img_desc'      => '9288691275014038_500.jpg',
                'thumb_url'     => 'images/201610/goods_img/395_P_1459218832155.jpg',
                'img_original'  => 'images/201610/goods_img/395_P_1459218832155.jpg',
            ),
            array(
                'img_id'        => '1893',
                'goods_id'      => '395',
                'img_url'       => 'images/201610/goods_img/395_P_1459218832027.jpg',
                'img_desc'      => '9288691274981270_500.jpg',
                'thumb_url'     => 'images/201610/goods_img/395_P_1459218832027.jpg',
                'img_original'  => 'images/201610/goods_img/395_P_1459218832027.jpg',
            ),
            array(
                'img_id'        => '1894',
                'goods_id'      => '617',
                'img_url'       => 'images/201610/goods_img/617_P_1459218982585.jpg',
                'img_desc'      => '9288692936351856_500.jpg',
                'thumb_url'     => 'images/201610/goods_img/617_P_1459218982585.jpg',
                'img_original'  => 'images/201610/goods_img/617_P_1459218982585.jpg',
            ),
            array(
                'img_id'        => '1895',
                'goods_id'      => '617',
                'img_url'       => 'images/201610/goods_img/617_P_1459218984856.jpg',
                'img_desc'      => '9288692936384624_500.jpg',
                'thumb_url'     => 'images/201610/goods_img/617_P_1459218984856.jpg',
                'img_original'  => 'images/201610/goods_img/617_P_1459218984856.jpg',
            ),
            array(
                'img_id'        => '2989',
                'goods_id'      => '430',
                'img_url'       => 'images/201610/goods_img/430_P_1459971655453.jpg',
                'img_desc'      => '9288691428761503_500.jpg',
                'thumb_url'     => 'images/201610/goods_img/430_P_1459971655453.jpg',
                'img_original'  => 'images/201610/goods_img/430_P_1459971655453.jpg',
            ),
            array(
                'img_id'        => '2990',
                'goods_id'      => '430',
                'img_url'       => 'images/201610/goods_img/430_P_1459971660784.jpg',
                'img_desc'      => '9288691428827039_500.jpg',
                'thumb_url'     => 'images/201610/goods_img/430_P_1459971660784.jpg',
                'img_original'  => 'images/201610/goods_img/430_P_1459971660784.jpg',
            ),
            array(
                'img_id'        => '2991',
                'goods_id'      => '430',
                'img_url'       => 'images/201610/goods_img/430_P_1459971660723.jpg',
                'img_desc'      => '9288691428794271_500.jpg',
                'thumb_url'     => 'images/201610/goods_img/430_P_1459971660723.jpg',
                'img_original'  => 'images/201610/goods_img/430_P_1459971660723.jpg',
            ),
            array(
                'img_id'        => '3444',
                'goods_id'      => '1046',
                'img_url'       => 'images/201610/goods_img/1046_P_1476914172383.jpg',
                'img_desc'      => '1-370x370-13738-23CKHT1U.jpg',
                'thumb_url'     => 'images/201610/thumb_img/1046_P_1476914172383.jpg',
                'img_original'  => 'images/201610/source_img/1046_P_1476914172383.jpg?999',
            ),
            array(
                'img_id'        => '3503',
                'goods_id'      => '1082',
                'img_url'       => 'images/201610/goods_img/1082_P_1477690581028.jpg',
                'img_desc'      => '9288695038550230_500.jpg',
                'thumb_url'     => 'images/201610/thumb_img/1082_P_1477690581028.jpg',
                'img_original'  => 'images/201610/source_img/1082_P_1477690581028.jpg?999',
            ),
            array(
                'img_id'        => '3504',
                'goods_id'      => '1082',
                'img_url'       => 'images/201610/goods_img/1082_P_1477690594283.jpg',
                'img_desc'      => '9288695038615766_500.jpg',
                'thumb_url'     => 'images/201610/thumb_img/1082_P_1477690594283.jpg',
                'img_original'  => 'images/201610/source_img/1082_P_1477690594283.jpg?999',
            ),
            array(
                'img_id'        => '3560',
                'goods_id'      => '1103',
                'img_url'       => 'images/201610/goods_img/1103_P_1477698555019.jpg',
                'img_desc'      => '1-270x270-12249-9XUK3KKT.jpg',
                'thumb_url'     => 'images/201610/thumb_img/1103_P_1477698555019.jpg',
                'img_original'  => 'images/201610/source_img/1103_P_1477698555019.jpg?999',
            ),
            array(
                'img_id'        => '3561',
                'goods_id'      => '1103',
                'img_url'       => 'images/201610/goods_img/1103_P_1477698610958.jpg',
                'img_desc'      => '1-370x370-12249-393U54AX.jpg',
                'thumb_url'     => 'images/201610/thumb_img/1103_P_1477698610958.jpg',
                'img_original'  => 'images/201610/source_img/1103_P_1477698610958.jpg?999',
            ),
            array(
                'img_id'        => '3589',
                'goods_id'      => '1046',
                'img_url'       => 'images/201611/goods_img/1046_P_1477960890510.jpg',
                'img_desc'      => '2-370x370-13738-C2XY61W1.jpg',
                'thumb_url'     => 'images/201611/thumb_img/1046_P_1477960890510.jpg',
                'img_original'  => 'images/201611/source_img/1046_P_1477960890510.jpg?999',
            ),
            array(
                'img_id'        => '3590',
                'goods_id'      => '1046',
                'img_url'       => 'images/201611/goods_img/1046_P_1477960893217.jpg',
                'img_desc'      => '3-370x370-13738-C2XY61W1.jpg',
                'thumb_url'     => 'images/201611/thumb_img/1046_P_1477960893217.jpg',
                'img_original'  => 'images/201611/source_img/1046_P_1477960893217.jpg?999',
            ),
            array(
                'img_id'        => '3692',
                'goods_id'      => '393',
                'img_url'       => 'images/201610/goods_img/393_P_1478818603045.jpg',
                'img_desc'      => '1-370x370-4394-9Y2YD8RY.jpg',
                'thumb_url'     => 'images/201610/goods_img/393_P_1478818603045.jpg',
                'img_original'  => 'images/201610/goods_img/393_P_1478818603045.jpg',
            ),
            array(
                'img_id'        => '3693',
                'goods_id'      => '393',
                'img_url'       => 'images/201610/goods_img/393_P_1478818607871.jpg',
                'img_desc'      => '3-370x370-12059-XSFUA856.jpg',
                'thumb_url'     => 'images/201610/goods_img/393_P_1478818607871.jpg',
                'img_original'  => 'images/201610/goods_img/393_P_1478818607871.jpg',
            ),
        );

        RC_DB::table('goods_gallery')->truncate();
        RC_DB::table('goods_gallery')->insert($data);
    }
}