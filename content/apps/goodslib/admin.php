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

use Ecjia\App\Goods\Models\GoodslibAttrModel;
use Ecjia\App\Goods\Category\CategoryLevel;
/**
 *  ECJIA 商品管理程序
 */
class admin extends ecjia_admin {
    
    private $db_goods;
    private $error;
    
    public function __construct()
    {
        parent::__construct();
        

        RC_Script::enqueue_script('goods_list', RC_App::apps_url('statics/js/goods_list.js', __FILE__), array('ecjia-utils', 'smoke', 'jquery-validate', 'jquery-form', 'bootstrap-placeholder', 'jquery-wookmark', 'jquery-imagesloaded', 'jquery-colorbox'), false, 1);
        RC_Script::enqueue_script('jquery-dropper', RC_Uri::admin_url('/statics/lib/dropper-upload/jquery.fs.dropper.js'), array(), false, 1);
        RC_Script::enqueue_script('jquery-chosen');
        RC_Style::enqueue_style('chosen');
        RC_Style::enqueue_style('goods-colorpicker-style', RC_Uri::admin_url() . '/statics/lib/colorpicker/css/colorpicker.css');
        RC_Script::enqueue_script('goods-colorpicker-script', RC_Uri::admin_url('/statics/lib/colorpicker/bootstrap-colorpicker.js'), array(), false, 1);
        
        RC_Script::enqueue_script('bootstrap-editable-script', RC_Uri::admin_url() . '/statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js', array(), false, 1);
        RC_Style::enqueue_style('bootstrap-editable-css', RC_Uri::admin_url() . '/statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css');
        
        RC_Style::enqueue_style('splashy-css', RC_Uri::admin_url() . '/statics/images/splashy/splashy.css');
        
        RC_Script::enqueue_script('jquery-uniform');
        RC_Script::enqueue_script('bootstrap-placeholder');
        RC_Style::enqueue_style('uniform-aristo');
        RC_Script::enqueue_script('jq_quicksearch', RC_Uri::admin_url() . '/statics/lib/multi-select/js/jquery.quicksearch.js', array('jquery'), false, 1);
        
        // 		RC_Style::enqueue_style('goodsapi', RC_Uri::home_url('content/apps/goods/statics/styles/goodsapi.css'));
//         RC_Script::enqueue_script('ecjia-region', RC_Uri::admin_url('statics/ecjia.js/ecjia.region.js'), array('jquery'), false, true);

        RC_Script::enqueue_script('product', RC_App::apps_url('statics/js/product.js', __FILE__), array(), false, 1);
        RC_Script::localize_script('goods_list', 'js_lang', config('app-goodslib::jslang.spec_product_page'));
        
        RC_Style::enqueue_style('goods', RC_App::apps_url('statics/styles/admin_goods.css', __FILE__), array());
        RC_Style::enqueue_style('product', RC_App::apps_url('statics/styles/product.css', __FILE__), array());
        
        RC_Loader::load_app_class('goods', 'goods', false );
        RC_Loader::load_app_class('goodslib', 'goodslib' );
        RC_Loader::load_app_class('goods_image_data', 'goodslib', false);
        RC_Loader::load_app_class('product_image_data', 'goodslib', false);
//         RC_Loader::load_app_class('goods_imageutils', 'goodslib', false);
        
        RC_Loader::load_app_func('admin_category', 'goods');
        RC_Loader::load_app_func('global', 'goods');
        RC_Loader::load_app_func('admin_goods', 'goods');
        RC_Loader::load_app_func('global', 'goodslib');
        
        RC_Loader::load_app_func('admin_user', 'user');
        $goods_list_jslang = array(
            'user_rank_list'	=> \Ecjia\App\User\UserRank\UserRankCollection::queryAllRanks(),
            'marketPriceRate'	=> ecjia::config('market_price_rate'),
            'integralPercent'	=> ecjia::config('integral_percent'),
        );
        RC_Script::localize_script( 'goods_list', 'admin_goodsList_lang', $goods_list_jslang );
        
        $goods_id = isset($_REQUEST['goods_id']) ? $_REQUEST['goods_id'] : 0;
//         $extension_code = isset($_GET['extension_code']) ? '&extension_code='.$_GET['extension_code'] : '';
        
        $this->tags = goodslib_get_goods_info_nav($goods_id);
        $this->tags[ROUTE_A]['active'] = 1;
        
        $this->db_goods = RC_Model::model('goods/goods_model');
        
        ecjia_admin_log::instance()->add_object('goodslib', __('商品库', 'goodslib'));
        ecjia_admin_log::instance()->add_object('goodslib_product', __('商品库货品', 'goodslib'));
    }
    
    /**
     * 商品列表
     */
    public function init() {
        $this->admin_priv('goodslib_manage');

        $cat_id = intval($this->request->input('cat_id', 0));
        $page = intval($this->request->input('page', 1));
        $brand_id = intval($this->request->input('brand_id', 0));
        $keywords = trim($this->request->input('keywords'));
        $review_status = intval($this->request->input('review_status', 0));
        $sort_by = trim($this->request->input('sort_by', 'sort_order'));
        $sort_order = trim($this->request->input('sort_order', 'ASC'));
        
        $this->assign('ur_here', __('商品库商品（SPU）', 'goodslib'));
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('商品库', 'goodslib')));
        
        $cat_list_option = \Ecjia\App\Goods\Category\CategoryFormSelectOption::buildTopCategorySelectOption()->render($cat_id);
        $this->assign('cat_list_option', $cat_list_option);

        $this->assign('brand_list', \Ecjia\App\Goods\Brand\BrandCollection::getBrandNameKeyBy());

        $input = [
            'is_real'		    => 1,
            'cat_id'            => $cat_id,
            'brand'             => $brand_id,
            'keywords'          => $keywords,
            'review_status'     => $review_status,
            'sort_by'           => [$sort_by => $sort_order, 'goods_id' => 'DESC'],
            'page'              => $page,
        ];
        $input = collect($input)->filter()->all(); //->merge($where)
        $input['is_delete'] = 0;
        $goods_list = $collection = (new \Ecjia\App\Goodslib\GoodsSearch\GoodsCollection($input))->getData();
        $this->assign('goods_list', $goods_list);
        $this->assign('filter', $goods_list['filter']);

        $this->assign('action_link',      	array('text' => __('添加商品', 'goodslib'), 'href' => RC_Uri::url('goodslib/admin/add')));
        $this->assign('form_action', RC_Uri::url('goodslib/admin/batch'));
        
        return $this->display('goodslib_list.dwt');
    }

    /**
     * 生成列表操作链接
     */
    public static function maker_goodslist_links($data)
    {
        $links = [
            '<a class="data-pjax" href="'.RC_Uri::url('goodslib/admin/edit', ['goods_id' => $data['goods_id']]).'">'.__('编辑', 'goodslib').'</a>',
            '<a class="data-pjax" href="'.RC_Uri::url('goodslib/admin_gallery/init', ['goods_id' => $data['goods_id']]).'">'.__('商品相册', 'goodslib').'</a>',
            '<a class="data-pjax" href="'.RC_Uri::url('goodslib/admin/edit_goods_parameter', ['goods_id' => $data['goods_id']]).'">'.__('商品参数', 'goodslib').'</a>',
            '<a class="data-pjax" href="'.RC_Uri::url('goodslib/admin/edit_goods_specification', ['goods_id' => $data['goods_id']]).'">'.__('规格/货品', 'goodslib').'</a>',
            '<a target="_blank" href="'.RC_Uri::url('goodslib/admin/preview', ['goods_id' => $data['goods_id']]).'">'.__('预览', 'goodslib').'</a>',
            '<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg="'.__('您确定要删除此商品吗？', 'goodslib').'" href="'.RC_Uri::url('goodslib/admin/remove', ['id' => $data['goods_id']]).'">'.__('删除', 'goodslib').'</a>',
        ];

        $links = RC_Hook::apply_filters('goodslib_maker_goodslist_links', $links, $data);

        return implode('&nbsp;|&nbsp;', $links);
    }

    public function goods_spec()
    {
        $this->admin_priv('goodslib_update');
        
        
        return $this->display('goods_list.dwt');
    }
    
    /**
     * 添加新商品
     */
    public function add() {
        $this->admin_priv('goodslib_update'); // 检查权限
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('商品库', 'goodslib'),  RC_Uri::url('goodslib/admin/init')));
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('添加商品', 'goodslib')));
        $this->assign('ur_here', __('添加商品库商品', 'goodslib'));
        $this->assign('action_link', array('href' =>  RC_Uri::url('goodslib/admin/init'), 'text' => __('商品列表', 'goodslib')));

        /* 默认值 */
        $goods = array(
            'goods_id'				=> 0,
            'goods_desc'			=> '',
            'cat_id'				=> 0,
            'brand_id'				=> 0,
            'goods_type'			=> 0, // 商品类型
            'shop_price'			=> 0,
            'market_price'			=> 0,
            'goods_weight'			=> 0,
        );
        /* 商品名称样式 */
        $goods_name_style = isset($goods['goods_name_style']) ? $goods['goods_name_style'] : '';
        
        /* 模板赋值 */
        $this->assign('tags', array('edit' => array('name' => __('通用信息', 'goodslib'), 'active' => 1, 'pjax' => 1, 'href' => RC_Uri::url('goodslib/admin/add'))));
        $this->assign('goods', $goods);
        $this->assign('goods_name_color', $goods_name_style);
        $this->assign('cat_list', cat_list(0, $goods['cat_id'], false));
        $this->assign('brand_list', get_brand_list());
        //$this->assign('unit_list',  goods::unit_list());
        $this->assign('unit_list', Ecjia\App\Cashier\BulkGoods::unit_list());
        $this->assign('form_action', RC_Uri::url('goodslib/admin/insert'));
        $this->assign_lang();
        
        return $this->display('goodslib_info.dwt');
    }
    
    public function insert() {
        $this->admin_priv('goodslib_update'); // 检查权限
        
        /* 检查货号是否重复 */
        if (trim($_POST['goods_sn'])) {
            $goods_sn = check_goodslib_goods_sn_exist($_POST['goods_sn']);
            if ($goods_sn) {
                return $this->showmessage(__('您输入的货号已存在，请换一个', 'goodslib'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
        }

        $upload = RC_Upload::uploader('newimage', array('save_path' => 'goodslib', 'auto_sub_dirs' => true));
        $upload->add_saving_callback('__return_true');

        /* 是否处理商品图 */
        $proc_goods_img = $this->request->hasFile('goods_img');
        $proc_thumb_img = $this->request->hasFile('thumb_img');

        if ($proc_goods_img) {
            $image_info = $upload->upload('goods_img');
            if (empty($image_info)) {
                return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
        }

        if ($proc_thumb_img) {
            $thumb_info = $upload->upload('thumb_img');
            if (empty($thumb_info)) {
                return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
        }

        /* 如果没有输入商品货号则自动生成一个商品货号 */
        if (empty($_POST['goods_sn'])) {
            //$max_id = $this->db_goods->join(null)->field('MAX(goods_id) + 1|max')->find();
            $max_id = RC_DB::table('goodslib')->select(RC_DB::raw('MAX(goods_id) + 1 as max'))->first();
            if (empty($max_id['max'])) {
                $goods_sn_bool = true;
                $goods_sn = '';
            } else {
                $goods_sn_bool = false;
                $goods_sn = generate_goodslib_goods_sn($max_id['max']);
            }
        } else {
            $goods_sn_bool = false;
            $goods_sn = $_POST['goods_sn'];
        }

            
        /* 处理商品数据 */
        $shop_price = !empty($_POST['shop_price']) ? $_POST['shop_price'] : 0;
        $market_price 	= !empty($_POST['market_price']) && is_numeric($_POST['market_price']) ? $_POST['market_price'] : 0;
        $cost_price = !empty($_POST['cost_price']) ? $_POST['cost_price'] : 0;

        $goods_weight = !empty($_POST['goods_weight']) ? $_POST['goods_weight'] : 0.000;
        $weight_unit  = !empty($_POST['weight_unit']) ? $_POST['weight_unit'] : 0.000;
        
        $goods_type = isset($_POST['goods_type']) ? $_POST['goods_type'] : 0;
        $goods_name = htmlspecialchars($_POST['goods_name']);
        $goods_name_style = htmlspecialchars($_POST['goods_name_color']);

        $catgory_id = empty($_POST['cat_id']) ? '' : intval($_POST['cat_id']);
        $brand_id = empty($_POST['brand_id']) ? '' : intval($_POST['brand_id']);

        if (empty($goods_name)) {
            return $this->showmessage(__('商品名称不能为空！', 'goodslib'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        if (empty($catgory_id)) {
            return $this->showmessage(__('请选择商品分类', 'goodslib'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        
        $cats= new CategoryLevel();
        $cat_ids = $cats->getParentCategoryIds($catgory_id);
        list($level1, $level2, $level3) = $cat_ids;
        
        $goods_barcode    = !empty($_POST['goods_barcode'])  ? trim($_POST['goods_barcode'])   : '';
        /* 入库 */
        $data = array(
            'goods_name'            => $goods_name,
            'goods_name_style'      => $goods_name_style,
            'goods_sn'              => empty($goods_sn) ? '' : $goods_sn,
        	'goods_barcode'         => $goods_barcode,
        	'cat_level1_id'         => empty($level1) ? 0 : $level1,
        	'cat_level2_id'         => empty($level2) ? 0 : $level2,
            'cat_id'                => $catgory_id,
            'brand_id'              => $brand_id,
            'shop_price'            => $shop_price,
            'market_price'          => $market_price,
            'cost_price'          	=> $cost_price,
            'keywords'              => $_POST['keywords'],
            'goods_brief'           => $_POST['goods_brief'],
            'goods_weight'          => $goods_weight,
        	'weight_unit'			=> $weight_unit,
            'goods_desc'            => !empty($_POST['goods_desc']) ? $_POST['goods_desc'] : '',
            'add_time'              => RC_Time::gmtime(),
            'last_update'           => RC_Time::gmtime(),
            'goods_type'            => $goods_type,
            'review_status'			=> 5,
            'is_display'			=> !empty($_POST['is_display']) ? intval($_POST['is_display']) : 0,
        );

        $insert_id = RC_DB::table('goodslib')->insertGetId($data);
        /* 商品编号 */
        $goods_id = $insert_id;

        if ($goods_sn_bool){
            $goods_sn = generate_goodslib_goods_sn($goods_id);
            $data = array('goods_sn' => $goods_sn);
            RC_DB::table('goodslib')->where('goods_id', $goods_id)->update($data);
        }
        /* 记录日志 */
        ecjia_admin::admin_log($_POST['goods_name'], 'add', 'goodslib');
            
            
        /* 更新上传后的商品图片 */
        if ($proc_goods_img) {
            if (!empty($image_info)) {

                $goods_image = new \Ecjia\App\Goodslib\GoodsImage\Goods\GoodsImage($goods_id, 0, $image_info);
                if ($proc_thumb_img) {
                    $goods_image->setAutoGenerateThumb(false);
                } else {
                    $goods_image->setAutoGenerateThumb(true);
                }

                $result = $goods_image->updateToDatabase($goods_id);
                if (is_ecjia_error($result)) {
                    return $this->showmessage($result->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                }
            }

        }

        /* 更新上传后的缩略图片 */
        if ($proc_thumb_img) {
            if (!empty($thumb_info)) {
                $thumb_image = new \Ecjia\App\Goodslib\GoodsImage\Goods\GoodsThumb($goods_id, 0, $thumb_info);
                $result = $thumb_image->updateToDatabase();
                if (is_ecjia_error($result)) {
                    return $this->showmessage($result->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                }
            }
        }
            
        /* 记录上一次选择的分类和品牌 */
        setcookie('ECSCP[last_choose]', $catgory_id . '|' . $brand_id, RC_Time::gmtime() + 86400);

        $links = ecjia_alert_links(array(
            'href' => RC_Uri::url('goodslib/admin/init'),
            'text' => __('商品列表', 'goodslib')
            ),
            array(
                'href' => RC_Uri::url('goodslib/admin/add'),
                'text' => __('继续添加', 'goodslib')
            ));

        return $this->showmessage(__('添加商品成功', 'goodslib'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array( 'pjaxurl' => RC_Uri::url('goodslib/admin/edit', "goods_id=$goods_id"), 'links' => $links, 'max_id' => $goods_id));
    }
    
    //导出
    public function export() {
        $this->admin_priv('goodslib_export');
        
        $filter['cat_id'] = empty($_GET['cat_id']) ? 0 : intval($_GET['cat_id']);
        $filter['brand_id'] = empty($_GET['brand_id']) ? 0 : intval($_GET['brand_id']);
        $filter['keywords'] = empty ($_GET['keywords']) ? '' : trim($_GET['keywords']);
        
        $goods_list = goodslib::get_export_goods_list(0);
        if(empty($goods_list['goods'])) {
            return $this->showmessage(__('暂无数据', 'goodslib'), ecjia::MSGTYPE_HTML| ecjia::MSGSTAT_ERROR);
        }
        $goods = $goods_list['goods'];
        //         $goods = [];
        //         foreach ($goods_list['goods'] as $row) {
        //             $goods[] = array(
        //                 'goods_sn' => $row['goods_sn'],
        //                 'goods_name' => $row['goods_name'],
        //                 'shop_price' => $row['shop_price'],
        //                 'market_price' => $row['market_price'],
        //                 'goods_weight' => $row['goods_weight'],
        //                 'keywords' => $row['keywords'],
        //                 'goods_brief' => $row['goods_brief'],
        //                 'goods_desc' => $row['goods_desc'],
        //                 'brand_id' => $row['goods_weight'],
        //                 'cat_id' => $row['goods_weight'],
        //             );
        //         }
        
//         RC_Excel::create(__('商品列表', 'goodslib').RC_Time::local_date('Ymd'), function($excel) use ($goods){
//             $excel->sheet('First sheet', function($sheet) use ($goods) {
//                 $sheet->setAutoSize(true);
//                 $sheet->setWidth('B', 20);
//                 $sheet->setWidth('C', 30);
//                 $sheet->setWidth('D', 15);
//                 $sheet->setWidth('E', 15);
//                 $sheet->setWidth('F', 15);
//                 $sheet->row(1, array(
//                     '货号', '商品名称', '价格', '市场价', '重量',
//                     '关键字', '简单描述', '商品描述', '品牌', '分类'
//                 ));
//                 foreach ($goods as $item) {
//                     $sheet->appendRow($item);
//                 }
//             });
//         })->download('xls');
        
        RC_Excel::load(RC_APP_PATH . 'goodslib' . DIRECTORY_SEPARATOR .'statics/files/goodslib.xls', function($excel) use ($goods){
            $excel->sheet('First sheet', function($sheet) use ($goods) {
                foreach ($goods as $key => $item) {
                    $sheet->appendRow($key+2, $item);
                }
            });
//             $excel->setTitle(__('商品库', 'goodslib'));
        })->download('xls');
    }
    
    public function import() {
        $this->admin_priv('goodslib_import');
        
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('商品库', 'goodslib'),  RC_Uri::url('goodslib/admin/init')));
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('导入商品', 'goodslib')));
        $this->assign('ur_here', __('导入商品', 'goodslib'));
        $this->assign('action_link', array('href' =>  RC_Uri::url('goodslib/admin/init'), 'text' => __('返回商品列表', 'goodslib')));
        $this->assign('form_action', RC_Uri::url('goodslib/admin/upload'));
        
        $this->assign('demo_url', RC_App::apps_url('statics/files/goodslib_demo.xls', __FILE__));
        
        return $this->display('goodslib_import.dwt');
    }

    public function upload() {
        $this->admin_priv('goodslib_import');
        
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('商品库', 'goodslib'),  RC_Uri::url('goodslib/admin/init')));
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('导入商品', 'goodslib')));
        $this->assign('ur_here', __('导入商品', 'goodslib'));

        if (!isset($_FILES['goodslib'])) {
            return $this->showmessage(__('请选择导入的文件', 'goodslib'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        
        $upload_status = true;
        $upload = RC_Upload::uploader('file', array('save_path' => 'temp', 'auto_sub_dirs' => true));
        //         $upload->allowed_mime(array('xls', 'xlsx'));
        $upload->allowed_mime(array('application/octet-stream', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'));
        if (!$upload->check_upload_file($_FILES['goodslib'])) {
            $upload_status = false;
            return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        if ($upload_status) {
            $info = $upload->upload($_FILES['goodslib']);
            if (empty($info)) {
                return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
        }
        
        $temp_file = RC_Upload::upload_path('temp/' . $info['savename']);
        
        $file = RC_Excel::load($temp_file, function($reader) {
            $reader = $reader->getSheet(0);//excel第一张sheet
            $results = $reader->toArray();
            unset($results[0]);unset($results[1]);//去除表头和规则
            if ($results)
            {
                $this->error = [];
                foreach ($results as $key => $value)
                {
                    if(empty($value)) {
                        unset($results[$key]);
                        continue;
                    }
                    if($value[0] == '' && $value[1] == '' && $value[2] == '' && $value[3] == '' && $value[4] == '') {
                        continue;
                    }
                    $data = [];
                    $data['goods_sn'] = $value[0] == null ? '':trim($value[0]);
                    $data['product_sn'] = $value[1] == null ? '':trim($value[1]);
                    $data['goods_name'] = $value[2] == null ? '' : trim($value[2]);
                    $data['shop_price'] = $value[3] == null ? '' : trim($value[3]);
                    $data['market_price'] = $value[4] == null ? '' : trim($value[4]);
                    $data['cost_price'] = $value[5] == null ? '' : trim($value[5]);
                    $data['goods_weight'] = $value[6] == null ? '' : trim($value[6]);
                    $data['keywords'] = $value[7] == null ? '' : trim($value[7]);
                    $data['goods_brief'] = $value[8] == null ? '' : trim($value[8]);
                    $data['goods_desc'] = $value[9] == null ? '' : trim($value[9]);
                    $data['brand_id'] = $value[10] == null ? '' : trim($value[10]);
                    $data['cat_id'] = $value[12] == null ? '' : trim($value[12]);
                    $data_ext['product'] = $value[15] == null ? '' : trim($value[15]);
                    $data_ext['specification'] = $value[14] == null ? '' : trim($value[14]);
                    $data_ext['parameter'] = $value[16] == null ? '' : trim($value[16]);

                    //货品$value[14]
                    if(!empty($data['goods_sn']) && !empty($data['product_sn'])) {
                        /*
                         * 电脑,内存,8G|电脑,硬盘,256G  */
                        if(empty($data_ext['product'])) {
                            continue;
                        }
                        $data_pro = [];
                        //$pro = explode(';', $value[14]);
                        $pro = $data_ext['product'];
                        //TODO判断货号
                        $count_product_sn = RC_DB::table('goodslib_products as p')
                            ->leftJoin('goodslib as g', RC_DB::raw('p.goods_id'), '=', RC_DB::raw('g.goods_id'))
                            ->where('product_sn', $data['product_sn'])->where('is_delete', 0)->count();
                        if($count_product_sn) {
                            $message = sprintf(__('第%s行，货品货号【%s】已存在。', 'goodslib'), $key+1, $data['product_sn']);
                            $this->error[] = array('state' => 'error', 'message' => $message);
                            continue;
                        }
                        $new_goods_id = RC_DB::table('goodslib')->where('goods_sn', $data['goods_sn'])->where('is_delete', 0)->pluck('goods_id');
                        if(empty($new_goods_id) || is_null($new_goods_id)) {
                            $message = sprintf(__('第%s行，货品货号【%s】找不到对应的主商品。', 'goodslib'), $key+1, $data['product_sn']);
                            $this->error[] = array('state' => 'error', 'message' => $message);
                            continue;
                        }

                        $pro_attr = explode('|', $pro);
                        if($pro_attr) {
                            $new_goods_attr = [];
                            foreach ($pro_attr as $v_attr) {
                                $v_attr = explode(',', $v_attr);//电脑,内存,8G
                                $type_row = RC_DB::table('goods_type')->where('store_id', 0)->where('cat_name', $v_attr[0])->where('cat_type', 'specification')->first();
                                if ($type_row) {
                                    $attr = RC_DB::table('attribute')->where('cat_id', $type_row['cat_id'])->where('attr_name', $v_attr[1])->first();
                                    if ($attr) {
                                        $goodslib_attr = RC_DB::table('goodslib_attr')->where('goods_id', $new_goods_id)->where('attr_id', $attr['attr_id'])->where('attr_value', $v_attr[2])->first();
                                        if ($goodslib_attr) {
                                            $new_goods_attr[] = $goodslib_attr['goods_attr_id'];
                                        } else {
                                            $message = sprintf(__('第%s行，货品属性【%s】不存在。', 'goodslib'), $key + 1, $v_attr[2]);
                                            $this->error[] = array('state' => 'error', 'message' => $message);
                                            $new_goods_attr = [];
                                            break;
                                        }
                                    } else {
                                        $message = sprintf(__('第%s行，货品属性【%s】不存在。', 'goodslib'), $key + 1, $v_attr[1]);
                                        $this->error[] = array('state' => 'error', 'message' => $message);
                                        $new_goods_attr = [];
                                        break;
                                    }
                                } else {
                                    $message = sprintf(__('第%s行，货品规格【%s】不存在。', 'goodslib'), $key + 1, $v_attr[0]);
                                    $this->error[] = array('state' => 'error', 'message' => $message);
                                    $new_goods_attr = [];
                                    break;
                                }
                            }

                            if($new_goods_attr) {
                                asort($new_goods_attr);
                                $data_pro['goods_attr'] = implode('|', $new_goods_attr);
                                $data_pro['goods_id'] = $new_goods_id;
                                $data_pro['product_sn'] = $data['product_sn'];
                                $data_pro['product_name'] = $data['goods_name'];
                                $data_pro['product_shop_price'] = $data['shop_price'];
                                $pro_id = RC_DB::table('goodslib_products')->insertGetId($data_pro);
//                            if (empty($pro[1])) {
//                                RC_DB::table('goodslib_products')->where('product_id', $pro_id)->update(array('product_sn' => $data['goods_sn'] . '_p' . $pro_id));
//                            }
                            }

                        } else {
                            $message = sprintf(__('第%s行，货品属性【%s】不存在。', 'goodslib'), $key+1, $pro);
                            $this->error[] = array('state' => 'error', 'message' => $message);
                            continue;
                        }
                        //货品 end

                        continue;
                    }

                    if(empty($data['goods_sn']) && !empty($data['product_sn'])) {
                        //异常货品导入
                        $message = sprintf(__('第%s行，导入货品，商品货号不能为空。', 'goodslib'), $key+1);
                        $this->error[] = array('state' => 'error', 'message' => $message);
                        continue;
                    }

                    if(empty($data['goods_name'])) {
                        $message = sprintf(__('第%s行，商品名称不能为空。', 'goodslib'), $key+1);
                        $this->error[] = array('state' => 'error', 'message' => $message);
                        continue;
                    }
                    if(is_null($data['shop_price'])) {
                        $message = sprintf(__('第%s行，商品价格不能为空。', 'goodslib'), $key+1);
                        $this->error[] = array('state' => 'error', 'message' => $message);
                        continue;
                    }
                    //判断货号
                    if ($data['goods_sn'] && empty($data['product_sn'])) {
                        $count_goods_sn = RC_DB::table('goodslib')->where('goods_sn', $data['goods_sn'])->where('is_delete', 0)->count();
                        if($count_goods_sn) {
                            $message = sprintf(__('第%s行，商品【%s】货号【%s】重复。。', 'goodslib'), $key+1, $data['goods_name'], $data['goods_sn']);
                            $this->error[] = array('state' => 'error', 'message' => $message);
                            continue;
                        }
                    } else {
                        //$max_id = $this->db_goods->join(null)->field('MAX(goods_id) + 1|max')->find();
                        $max_id = RC_DB::table('goodslib')->select(RC_DB::raw('MAX(goods_id) + 1 as max'))->first();
                        if (empty($max_id['max'])) {
                            $goods_sn_bool = true;
                            $data['goods_sn'] = '';
                        } else {
                            $goods_sn_bool = false;
                            $data['goods_sn'] = generate_goods_sn($max_id['max']);
                        }
                    }
                    unset($data['product_sn']);
                    $new_goods_id = RC_DB::table('goodslib')->insertGetId($data);
                    //规格属性$value[13]
                    /* 电脑;内存;32G;
                     * 电脑;内存;16G;500 */
                    if(!empty($data_ext['specification']) && $new_goods_id) {
                        $goods_attr = explode("\n", $data_ext['specification']);
                        foreach ($goods_attr as $k_a => $v_a) {
                            if (empty($v_a)) {
                                unset($goods_attr[$k_a]);
                                continue;
                            }
                            $attr = explode(';', $v_a);
                            $new_key = implode(',', array($attr[0], $attr[1], $attr[2]));
                            $new_attr[$new_key] = $attr;
                            $type_name = $attr[0];
                        }
                        $types = RC_DB::table('goods_type')->where('store_id', 0)->where('cat_name', $type_name)->where('cat_type', 'specification')->first();
                        foreach ($new_attr as $k_a => $v_a) {
                            $type_row = RC_DB::table('goods_type')->where('cat_id', $types['cat_id'])->where('store_id', 0)->where('cat_name', $v_a[0])->first();
                            if ($type_row) {
                                RC_DB::table('goodslib')->where('goods_id', $new_goods_id)->update(array('goods_type' => $type_row['cat_id']));
                                $attr = RC_DB::table('attribute')->where('cat_id', $types['cat_id'])->where('attr_name', $v_a[1])->first();
                                if ($attr) {
                                    $data_attr = [
                                        'cat_type'   => 'specification',
                                        'goods_id'   => $new_goods_id,
                                        'attr_id'    => $attr['attr_id'],
                                        'attr_value' => $v_a[2],
                                        //'color_value' => $v_a[3],//暂用不到
                                        'attr_price' => $v_a[3],
                                    ];
                                    $new_attr[$k_a]['goods_attr_id'] = RC_DB::table('goodslib_attr')->insertGetId($data_attr);
                                    RC_DB::table('goodslib')->where('goods_id', $new_goods_id)->update(['specification_id' => $types['cat_id']]);
                                } else {
                                    $message = sprintf(__('第%s行，，商品【%s】属性【%s】不存在。', 'goodslib'), $key + 1, $data['goods_name'], $v_a[1]);
                                    $this->error[] = array('state' => 'error', 'message' => $message);
                                    break;
                                }
                            } else {
                                $message = sprintf(__('第%s行，，商品【%s】规格【%s】不存在。', 'goodslib'), $key + 1, $data['goods_name'], $v_a[0]);
                                $this->error[] = array('state' => 'error', 'message' => $message);
                                break;
                            }
                        }
                    }

                    //商品参数$value[15]
                    /*电脑（商品规格名称）
                    商品产地:中国大陆
                    系统:OS X*/
                    if(!empty($data_ext['parameter']) && $new_goods_id) {
                        $goods_attr = explode("\n", $data_ext['parameter']);
                        $type_name = $goods_attr[0];//参数模板名
                        unset($goods_attr[0]);
                        $type_info = RC_DB::table('goods_type')->where('store_id', 0)->where('cat_name', $type_name)->where('cat_type', 'parameter')->first();
                        if($type_info) {
                            foreach ($goods_attr as $k_a => $v_a) {
                                if (empty($v_a)) {
                                    unset($goods_attr[$k_a]);
                                    continue;
                                }
                                $attr = explode(':', $v_a);//[商品产地，中国大陆]
                                $attr_info = RC_DB::table('attribute')->where('cat_id', $type_info['cat_id'])->where('attr_name', $attr[0])->first();
                                if($attr_info) {
                                    $data = [
                                        'cat_type' => 'parameter',
                                        'goods_id' => $new_goods_id,
                                        'attr_id' => $attr_info['attr_id'],
                                        'attr_value' => $attr[1],
                                    ];
                                    RC_DB::table('goodslib_attr')->insert($data);
                                    RC_DB::table('goodslib')->where('goods_id', $new_goods_id)->update(['parameter_id' => $type_info['cat_id']]);
                                } else {
                                    $message = sprintf(__('第%s行，，商品【%s】属性【%s】不存在。', 'goodslib'), $key + 1, $data['goods_name'], $attr[0]);
                                    $this->error[] = array('state' => 'error', 'message' => $message);
                                    break;
                                }

                            }
                        } else {
                            $message = sprintf(__('第%s行，，商品【%s】参数模板【%s】不存在。', 'goodslib'), $key + 1, $data['goods_name'], $type_name);
                            $this->error[] = array('state' => 'error', 'message' => $message);
                            break;
                        }

                    }

                }
            }
        });
        //导入成功后删除
        $upload->remove($temp_file);
        
        $link[] = array(
            'href' => RC_Uri::url('goodslib/admin/init'),
            'text' => __('商品列表', 'goodslib')
        );
        
        $this->assign('error', $this->error);
        return $this->display('goodslib_import_success.dwt');
//         return $this->showmessage('导入成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $link));
    }
    
    /**
     * 编辑商品
     */
    public function edit() {
        $this->admin_priv('goodslib_update');
        
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('商品库', 'goodslib'), RC_Uri::url('goodslib/admin/init')));
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('编辑商品', 'goodslib')));
        
        $this->assign('ur_here', __('编辑商品', 'goodslib'));
        $this->assign('action_link', array('href' => RC_Uri::url('goodslib/admin/init'), 'text' => __('商品列表', 'goodslib')));
        
        /* 商品信息 */
        $goods = RC_DB::table('goodslib')->where('goods_id', $_GET['goods_id'])->first();
        if (empty($goods)) {
            return $this->showmessage(__('未检测到此商品', 'goodslib'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => array(array('text' => __('返回上一页', 'goodslib'), 'href' => 'javascript:history.go(-1)'))));
        }
        
        /* 获取商品类型存在规格的类型 */
        $specifications = get_goods_type_specifications();
        if (isset($specifications[$goods['goods_type']])) {
            $goods['specifications_id'] = $specifications[$goods['goods_type']];
        }
        $_attribute = get_goods_specifications_list($goods['goods_id']);
        $goods['_attribute'] = empty($_attribute) ? '' : 1;
        
        if (empty($goods) === true) {
            /* 默认值 */
            $goods = array(
                'goods_id'				=> 0,
                'goods_desc'			=> '',
                'cat_id'				=> 0,
                'shop_price'			=> 0,
                'market_price'			=> 0,
                'goods_weight'			=> 0,
            );
        }
        /* 根据商品重量的单位重新计算 */
        if ($goods['goods_weight'] > 0) {
            $goods['goods_weight_by_unit'] = ($goods['goods_weight'] >= 1) ? $goods['goods_weight'] : ($goods['goods_weight']*1000);
        }
        
        if (!empty($goods['goods_brief'])) {
            $goods['goods_brief'] = $goods['goods_brief'];
        }
        if (!empty($goods['keywords'])) {
            $goods['keywords'] = $goods['keywords'];
        }
        
        /* 商品图片路径 */
        if (!empty($goods['goods_img'])) {
            $goods['goods_img'] = goods_imageutils::getAbsoluteUrl($goods['goods_img']);
            $goods['goods_thumb'] = goods_imageutils::getAbsoluteUrl($goods['goods_thumb']);
            $goods['original_img'] = goods_imageutils::getAbsoluteUrl($goods['original_img']);
        }
        
        /* 拆分商品名称样式 */
        $goods_name_style = explode('+', empty($goods['goods_name_style']) ? '+' : $goods['goods_name_style']);
        
        $cat_list = cat_list(0, $goods['cat_id'], false);
        
        foreach ($cat_list as $k => $v) {
            if (!empty($goods['other_cat']) && is_array($goods['other_cat'])){
                if (in_array($v['cat_id'], $goods['other_cat'])) {
                    $cat_list[$k]['is_other_cat'] = 1;
                }
            }
        }
        
        //商品重量存在，重量单位是0的情况
        if ($goods['goods_weight'] > 0) {
        	if (empty($goods['weight_unit'])) {
        		if ($goods['goods_weight'] >= 1 ) {
        			$goods['weight_unit'] = 2; //千克
        		} else {
        			$goods['weight_unit'] = 1; //克
        		}
        	} 
        }
        
        //设置选中状态,并分配标签导航
        $this->assign('action', 			ROUTE_A);
        $this->assign('tags', 				$this->tags);
        
        $this->assign('goods', 				$goods);
        $this->assign('goods_name_color', 	$goods_name_style[0]);
        $this->assign('cat_list', 			$cat_list);
        
        $this->assign('brand_list', 		get_brand_list());
        //$this->assign('unit_list', 			goods::unit_list());
        $this->assign('weight_unit', 		$goods['weight_unit']);
        $this->assign('unit_list', Ecjia\App\Cashier\BulkGoods::unit_list());
        
        $this->assign('cfg', 				ecjia::config());
        
        $this->assign('form_act', 			RC_Uri::url('goodslib/admin/edit'));
        $this->assign('form_tab', 			'edit');
        $this->assign('gd', 				RC_ENV::gd_version());
        $this->assign('thumb_width', 		ecjia::config('thumb_width'));
        $this->assign('thumb_height', 		ecjia::config('thumb_height'));
        
        /* 显示商品信息页面 */
        $this->assign('form_action', RC_Uri::url('goodslib/admin/update'));
        
        return $this->display('goodslib_info.dwt');
    }
    
    /**
     * 编辑商品
     */
    public function update() {
        $this->admin_priv('goodslib_update', ecjia::MSGTYPE_JSON);
        $goods_id = $_POST['goods_id'];
        $_POST['goods_sn'] = trim($_POST['goods_sn']);
        
        /* 检查货号是否重复 */
        if (!empty($_POST['goods_sn'])) {
            $count = check_goodslib_goods_sn_exist($_POST['goods_sn'], $goods_id);
            if ($count) {
                return $this->showmessage(__('您输入的货号已存在，请换一个', 'goodslib'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
        }


        $upload = RC_Upload::uploader('newimage', array('save_path' => 'images', 'auto_sub_dirs' => true));
        $upload->add_saving_callback('__return_true');

        /* 是否处理商品图 */
        $proc_goods_img = $this->request->hasFile('goods_img');
        $proc_thumb_img = $this->request->hasFile('thumb_img');

        if ($proc_goods_img) {
            $image_info = $upload->upload('goods_img');
            if (empty($image_info)) {
                return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
        }

        if ($proc_thumb_img) {
            $thumb_info = $upload->upload('thumb_img');
            if (empty($thumb_info)) {
                return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
        }
        
        /* 处理商品图片 */
        $goods_img = ''; // 初始化商品图片
        $goods_thumb = ''; // 初始化商品缩略图
        $img_original = ''; // 初始化原始图片
        
        /* 如果没有输入商品货号则自动生成一个商品货号 */
        if (empty($_POST['goods_sn'])) {
            $goods_sn = generate_goodslib_goods_sn($goods_id);
        } else {
            $goods_sn = trim($_POST['goods_sn']);
        }
        
        /* 处理商品数据 */
        $shop_price 	= !empty($_POST['shop_price']) 		? $_POST['shop_price'] 				: 0;
        $market_price 	= !empty($_POST['market_price']) && is_numeric($_POST['market_price']) ? $_POST['market_price'] : 0;
        $cost_price 	= !empty($_POST['cost_price']) 		? $_POST['cost_price'] 				: 0;
        
        $goods_weight 	= !empty($_POST['goods_weight']) && is_numeric($_POST['goods_weight']) ? $_POST['goods_weight'] : 0.000;
        $weight_unit	= !empty($_POST['weight_unit']) ? $_POST['weight_unit'] : 1;
        
        //$suppliers_id 	= isset($_POST['suppliers_id']) 	? intval($_POST['suppliers_id']) 	: '0';
        
        $goods_name 		= htmlspecialchars($_POST['goods_name']);
        $goods_name_style 	= htmlspecialchars($_POST['goods_name_color']);
        
        $catgory_id = empty($_POST['cat_id']) 	? 0 : intval($_POST['cat_id']);
        $brand_id 	= empty($_POST['brand_id']) ? 0 : intval($_POST['brand_id']);
        
        if (empty($catgory_id)) {
            return $this->showmessage(__('请选择商品分类', 'goodslib'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        
        if (empty($goods_name)) {
            return $this->showmessage(__('请输入商品名称', 'goodslib'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        
        $cats= new CategoryLevel();
        $cat_ids = $cats->getParentCategoryIds($catgory_id);
        list($level1, $level2, $level3) = $cat_ids;
        $goods_barcode    = !empty($_POST['goods_barcode'])  ? trim($_POST['goods_barcode'])   : '';
        $data = array(
            'goods_name'				=> rc_stripslashes($goods_name),
            'goods_name_style'	  		=> $goods_name_style,
            'goods_sn'			  		=> $goods_sn,
        	'goods_barcode'			  	=> $goods_barcode,
        	'cat_level1_id'         	=> empty($level1) ? 0 : $level1,
        	'cat_level2_id'         	=> empty($level2) ? 0 : $level2,
            'cat_id'					=> $catgory_id,
            'brand_id'			  		=> $brand_id,
            'shop_price'				=> $shop_price,
            'market_price'		  		=> $market_price,
        	'cost_price'		  		=> $cost_price,
//             'suppliers_id'		  		=> $suppliers_id,
            'is_real'			   		=> empty($code) ? '1' : '0',
            'extension_code'			=> $code,
            'keywords'			  		=> $_POST['keywords'],
            'goods_brief'		   		=> $_POST['goods_brief'],
            'goods_weight'		 		=> $goods_weight,
        	'weight_unit'				=> $weight_unit,
            'last_update'		   		=> RC_Time::gmtime(),
            'is_display'			    => !empty($_POST['is_display']) ? intval($_POST['is_display']) : 0,
        );
        RC_DB::table('goodslib')->where('goods_id', $goods_id)->update($data);
        /* 记录日志 */
        ecjia_admin::admin_log($_POST['goods_name'], 'edit', 'goodslib');

        /* 更新上传后的商品图片 */
        if ($proc_goods_img) {
            if (!empty($image_info)) {
                $goods_image = new \Ecjia\App\Goodslib\GoodsImage\Goods\GoodsImage($goods_id, 0, $image_info);
                if ($proc_thumb_img) {
                    $goods_image->setAutoGenerateThumb(false);
                } else {
                    $goods_image->setAutoGenerateThumb(true);
                }
                
                $result = $goods_image->updateToDatabase();
                if (is_ecjia_error($result)) {
                    return $this->showmessage($result->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                }
                
            }
        }
        
        /* 更新上传后的缩略图片 */
        if ($proc_thumb_img) {
            if (!empty($thumb_info)) {
                $thumb_image = new \Ecjia\App\Goodslib\GoodsImage\Goods\GoodsThumb($goods_id, 0, $thumb_info);
                $result = $thumb_image->updateToDatabase();
                if (is_ecjia_error($result)) {
                    return $this->showmessage($result->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                }
            }
        }
        
        /* 记录上一次选择的分类和品牌 */
        setcookie('ECSCP[last_choose]', $catgory_id . '|' . $brand_id, RC_Time::gmtime() + 86400);
        
        $links = ecjia_alert_links(array(
            'href' => RC_Uri::url('goodslib/admin/init'),
            'text' => __('商品列表', 'goodslib')
        ));
        
        return $this->showmessage(__('编辑商品成功', 'goodslib'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links, 'pjaxurl' => RC_Uri::url('goodslib/admin/edit', array('goods_id' => $goods_id))));
    }
    
    /**
     * 检查商品货号
     */
    public function check_goods_sn() {
        $this->admin_priv('goodslib_update', ecjia::MSGTYPE_JSON);
        
        $goods_id = intval($_REQUEST['goods_id']);
        $goods_sn = htmlspecialchars(trim($_REQUEST['goods_sn']));
        
        $query_goods_sn = RC_DB::table('goodslib')->where('goods_sn', $goods_sn)->where('goods_id', '!=', $goods_id)->pluck('goods_id');
        
        if ($query_goods_sn) {
            return $this->showmessage(__('您输入的货号已存在，请换一个', 'goodslib'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        /* 检查是否重复 */
        if (!empty($goods_sn)) {
            $query = RC_DB::table('goodslib_products')->where('product_sn', $goods_sn)->pluck('goods_id');
            if ($query) {
                return $this->showmessage(__('您输入的货号已存在，请换一个', 'goodslib'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
        }
        
        return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => ''));
    }
    
    /**
     * 放入回收站
     */
    public function remove() {
        $this->admin_priv('goodslib_delete', ecjia::MSGTYPE_JSON);
        
        $goods_id = intval($_GET['id']);
        $goods_name = RC_DB::table('goodslib')->where('goods_id', $goods_id)->pluck('goods_name');
        
        RC_DB::table('goodslib')->where('goods_id', $goods_id)->update(array('is_delete' => 1));
        
        ecjia_admin::admin_log(addslashes($goods_name), 'trash', 'goodslib');
        return $this->showmessage(__('商品删除成功', 'goodslib'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
    }
    
    /**
     * 预览
     */
    public function preview() {
        $this->admin_priv('goodslib_manage');
        
        $goods_id = !empty($_GET['goods_id']) ? intval($_GET['goods_id']) : 0;
        if (empty($goods_id)) {
            return $this->showmessage(__('未检测到此商品', 'goodslib'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => array(array('text' => __('返回上一页', 'goodslib'), 'href' => 'javascript:history.go(-1)'))));
        }
        
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('商品库', 'goodslib'),RC_Uri::url('goodslib/admin/init')));
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('商品预览', 'goodslib')));
        
        $this->assign('ur_here', __('商品预览', 'goodslib'));
        $this->assign('action_link', array('text' => __('返回', 'goodslib'), 'href' => RC_Uri::url('goodslib/admin/init')));
        
        $GoodslibBasicInfo = new Ecjia\App\Goodslib\GoodslibBasicInfo($goods_id);
        $goods = $GoodslibBasicInfo->goodslibInfo();
        
        if (empty($goods)) {
            return $this->showmessage(__('未检测到此商品', 'goodslib'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => array(array('text'=> __('返回商品列表', 'goodslib'),'href'=>RC_Uri::url('goodslib/admin/init')))));
        }
        
        if (!empty($goods['goods_desc'])) {
            $goods['goods_desc'] = stripslashes($goods['goods_desc']);
        }
        
        if (!empty($goods['add_time'])) {
            $goods['add_time'] = RC_Time::local_date(ecjia::config('time_format'), $goods['add_time']);
        }
        if (!empty($goods['last_update'])) {
            $goods['last_update'] = RC_Time::local_date(ecjia::config('time_format'), $goods['last_update']);
        }
        $goods['format_cost_price'] = ecjia_price_format($goods['cost_price'], false);
        
        //商品重量存在，重量单位是0的情况
        if ($goods['goods_weight'] > 0) {
        	if (empty($goods['weight_unit'])) {
        		if ($goods['goods_weight'] >= 1 ) {
        			$goods['goods_weight_string'] = $goods['goods_weight'].'千克';
        		} else {
        			$goods['goods_weight_string'] = ($goods['goods_weight']*1000).'克';
        		}
        	} else {
        		if ($goods['weight_unit'] == 2 ) {
        			$goods['goods_weight_string'] = $goods['goods_weight'].'千克';
        		} else {
        			if ($goods['goods_weight'] < 1){
        				$str = '克';
        				$goods_weight = $goods['goods_weight']*1000;
        			} else {
        				$str = '克';
        				$goods_weight = $goods['goods_weight'];
        			}
        			$goods['goods_weight_string'] = $goods_weight.$str;
        		}
        	}
        }
        
        $images_url = RC_App::apps_url('statics/images', __FILE__);
        $this->assign('images_url', $images_url);
        
		//商品相册
        $goods_photo_list = $GoodslibBasicInfo->getGoodsLibGallery();
        $this->assign('goods_photo_list', $goods_photo_list);

        //商品货品
        $product_list = $GoodslibBasicInfo->goodslibProducts();
        $this->assign('product_list', $product_list);
         
        //商品参数
        $attr_group = $GoodslibBasicInfo->attrGroup();
        if (count($attr_group) > 0) {
        	$group_parameter_list = $GoodslibBasicInfo->getGoodsGroupParameter();
        	$this->assign('group_parameter_list', $group_parameter_list);
        } else {
        	$common_parameter_list = $GoodslibBasicInfo->getGoodsCommonParameter();
        	$this->assign('common_parameter_list', $common_parameter_list);
        }
        
        $this->assign('no_picture', RC_Uri::admin_url('statics/images/nopic.png'));
        $this->assign('goods', $goods);
        
        return $this->display('preview.dwt');
    }
    
    /**
     * 商品库货品预览
     */
    public function product_preview()
    {
    	$this->admin_priv('goodslib_manage');
    	
    	$product_id = !empty($_GET['product_id']) ? intval($_GET['product_id']) : 0;
		$goods_id   = !empty($_GET['goods_id']) ? intval($_GET['goods_id']) : 0;
    	if (empty($product_id)) {
    		return $this->showmessage(__('未检测到此货品', 'goodslib'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => array(array('text' => __('返回上一页', 'goodslib'), 'href' => 'javascript:history.go(-1)'))));
    	}
    	
    	ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('商品库', 'goodslib'),RC_Uri::url('goodslib/admin/init')));
    	ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('商品预览', 'goodslib'),RC_Uri::url('goodslib/admin/preview', array('goods_id' => $goods_id))));
    	ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('货品预览', 'goodslib')));
    	
    	$this->assign('ur_here', __('货品预览', 'goodslib'));
    	$this->assign('action_link', array('text' => __('返回', 'goodslib'), 'href' => RC_Uri::url('goodslib/admin/preview', array('goods_id' => $goods_id))));
    	
    	//商品库货品信息
    	$GoodslibProductsBasicInfo =  new Ecjia\App\Goodslib\GoodslibProductsBasicInfo($product_id);
        $goodslib_product = $GoodslibProductsBasicInfo->goodslibProductInfo();
        if (empty($goodslib_product)) {
        	return $this->showmessage(__('未检测到此货品', 'goodslib'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => array(array('text'=> __('返回商品预览', 'goodslib'),'href'=>RC_Uri::url('goodslib/admin/preview', array('goods_id' => $goods_id))))));
        }
       
        //商品库商品
    	$GoodslibBasicInfo = new Ecjia\App\Goodslib\GoodslibBasicInfo($goodslib_product->goods_id);
        $goods = $GoodslibBasicInfo->goodslibInfo();
    	
        //名称处理
        $goodslib_product['product_attr_value'] = '';
        if (empty($goodslib_product->product_name)) {
        	$goodslib_product['product_name'] = $goods->goods_name;
        	if ($goodslib_product->goods_attr) {
        		$goods_attr = explode('|', $goodslib_product->goods_attr);
        		if ($goods->goodslib_attr_collection) {
        			$product_attr_value = $goods->goodslib_attr_collection->whereIn('goods_attr_id', $goods_attr)->sortBy('goods_attr_id')->lists('attr_value');
        			$product_attr_value = $product_attr_value->implode('/');
        			$goodslib_product['product_attr_value'] = $product_attr_value;
        		}
        	}
        }
        
        //本店价格处理
        if ($goodslib_product->product_shop_price <= 0){
        	$goodslib_product['product_shop_price'] = ecjia_price_format($goods->shop_price, false);
        } else {
        	$goodslib_product['product_shop_price'] = ecjia_price_format($goodslib_product->product_shop_price, false);
        }
        //添加时间
        if (!empty($goods->add_time)) {
        	$goods['add_time'] = RC_Time::local_date(ecjia::config('time_format'), $goods->add_time);
        }
        
        //图文详情
        if (!empty($goodslib_product['product_desc'])) {
        	$goodslib_product['product_desc'] = stripslashes($goodslib_product->product_desc);
        } else{
        	if (!empty($goods['goods_desc'])){
        		$goodslib_product['product_desc'] = stripslashes($goods->goods_desc);
        	}
        }
        //货品相册
        $product_photo_list = $GoodslibProductsBasicInfo->getProductGallery();
        if (empty($product_photo_list)) {
        	$product_photo_list = $GoodslibBasicInfo->getGoodsLibGallery();
        }
        $this->assign('product_photo_list', $product_photo_list);
        
        //商品参数
        $attr_group = $GoodslibBasicInfo->attrGroup();
        if (count($attr_group) > 0) {
        	$group_parameter_list = $GoodslibBasicInfo->getGoodsGroupParameter();
        	$this->assign('group_parameter_list', $group_parameter_list);
        } else {
        	$common_parameter_list = $GoodslibBasicInfo->getGoodsCommonParameter();
        	$this->assign('common_parameter_list', $common_parameter_list);
        }
        
        $images_url = RC_App::apps_url('statics/images', __FILE__);
        $this->assign('images_url', $images_url);
        $this->assign('no_picture', RC_Uri::admin_url('statics/images/nopic.png'));
        $this->assign('product', $goodslib_product);
        $this->assign('goods', $goods);
        
    	return $this->display('product_preview.dwt');
    }
    
    /**
     * 批量操作
     */
    public function batch() {
        /* 取得要操作的商品编号 */
        $goods_id = !empty($_POST['checkboxes']) ? $_POST['checkboxes'] : 0;
        if (!isset($_GET['type']) || $_GET['type'] == '') {
            return $this->showmessage(__('请选择操作', 'goodslib'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        $goods_id = explode(',', $goods_id);
        $data = RC_DB::table('goodslib')->select('goods_name')->whereIn('goods_id', $goods_id)->get();
        
        if (isset($_GET['type'])) {
            /* 放入回收站 */
            if ($_GET['type'] == 'trash') {
                /* 检查权限 */
                $this->admin_priv('goodslib_update', ecjia::MSGTYPE_JSON);
                update_goodslib($goods_id, 'is_delete', '1');
                $action = 'batch_trash';
            }
            /* 上架 */
            elseif ($_GET['type'] == 'on_sale') {
                /* 检查权限 */
                $this->admin_priv('goodslib_update', ecjia::MSGTYPE_JSON);
                update_goodslib($goods_id, 'is_display', '1');
            }
            /* 下架 */
            elseif ($_GET['type'] == 'not_on_sale') {
                /* 检查权限 */
                $this->admin_priv('goodslib_update', ecjia::MSGTYPE_JSON);
                update_goodslib($goods_id, 'is_display', '0');
            }
            /* 删除 */
            elseif ($_GET['type'] == 'drop') {
                /* 检查权限 */
                $this->admin_priv('goodslib_delete', ecjia::MSGTYPE_JSON);
                delete_goods($goods_id);
                $action = 'batch_remove';
            }
        }
        
        /* 记录日志 */
        if (!empty($data) && $action) {
            foreach ($data as $k => $v) {
                ecjia_admin::admin_log($v['goods_name'], $action, 'goodslib');
            }
        }
        
        $page = empty($_GET['page']) ? '&page=1' : '&page='.$_GET['page'];
        $is_on_sale = isset($_GET['is_on_sale']) ? $_GET['is_on_sale'] : '';
        
        if ($_GET['type'] == 'drop' || $_GET['type'] == 'restore') {
            $pjaxurl = RC_Uri::url('goodslib/admin/trash', $page);
        } else {
            $pjaxurl = RC_Uri::url('goodslib/admin/init', 'is_on_sale='.$is_on_sale.$page);
        }
        
        return $this->showmessage(__('批量操作成功', 'goodslib'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $pjaxurl));
    }
    
    /**
     * 修改商品价格
     */
    public function edit_goods_price() {
        $this->admin_priv('goodslib_update', ecjia::MSGTYPE_JSON);
        
        $goods_id = intval($_POST['pk']);
        $goods_price = floatval($_POST['value']);
        $price_rate = floatval(ecjia::config('market_price_rate') * $goods_price);
        $data = array(
            'shop_price'	=> $goods_price,
            'market_price'  => $price_rate,
            'last_update'   => RC_Time::gmtime()
        );
        if ($goods_price < 0 || $goods_price == 0 && $_POST['val'] != "$goods_price") {
            return $this->showmessage(__('您输入了一个非法的市场价格。', 'goodslib'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        } else {
            RC_DB::table('goodslib')->where('goods_id', $goods_id)->update($data);
            $url = RC_Uri::url('goodslib/admin/init', array('page' => $_GET['page']));
            return $this->showmessage(__('修改成功', 'goodslib'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $url, 'content' => number_format($goods_price, 2, '.', '')));
        }
    }
    
    /**
     * 修改上架状态
     */
    public function toggle_on_sale() {
        $this->admin_priv('goodslib_update', ecjia::MSGTYPE_JSON);
        
        $goods_id = intval($_POST['id']);
        $on_sale = intval($_POST['val']);
        
        $data = array(
            'is_display' => $on_sale,
            'last_update' => RC_Time::gmtime()
        );
        RC_DB::table('goodslib')->where('goods_id', $goods_id)->update($data);
        
        return $this->showmessage(__('已成功切换上架状态', 'goodslib'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $on_sale));
    }
    
    /**
     * 修改商品排序
     */
    public function edit_sort_order() {
        $this->admin_priv('goodslib_update', ecjia::MSGTYPE_JSON);
        
        $goods_id = intval($_POST['pk']);
        $sort_order = intval($_POST['value']);
        $data = array(
            'sort_order' => $sort_order,
            'last_update' => RC_Time::gmtime()
        );
        RC_DB::table('goodslib')->where('goods_id', $goods_id)->update($data);
        
        return $this->showmessage(__('修改成功', 'goodslib'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $sort_order));
    }
    
    /**
     * 商品描述编辑页面
     */
    public function edit_goods_desc() {
        $this->admin_priv('goodslib_update');
        
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('商品库', 'goodslib'),RC_Uri::url('goodslib/admin/init')));
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('编辑商品描述', 'goodslib')));
        
        $goods_id = intval($_REQUEST['goods_id']);
        $goods = RC_DB::table('goodslib')->where('goods_id', $goods_id)->first();
        if (empty($goods) === true) {
            return $this->showmessage(sprintf(__('找不到ID为 %s 的商品！', 'goodslib'), $goods_id), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => array(array('text' => __('返回上一页', 'goodslib'), 'href' => 'javascript:history.go(-1)'))));
        }
        if($goods['goods_desc']) {
            $goods['goods_desc'] = stripslashes($goods['goods_desc']);
        }
        //设置选中状态,并分配标签导航
        $this->tags['edit_goods_desc']['active'] = 1;
        $this->assign('tags', $this->tags);
        $this->assign('action_link', array('href' => RC_Uri::url('goodslib/admin/init'), 'text' => __('商品列表', 'goodslib')));
        $this->assign('ur_here',__('编辑商品描述', 'goodslib'));
        $this->assign('goods', $goods);
        $this->assign('goods_id', $goods_id);
        $this->assign('form_action', RC_Uri::url('goodslib/admin/update_goods_desc','goods_id='.$goods_id));
        
        return $this->display('goods_desc.dwt');
    }
    /**
     * 商品描述更新
     */
    public function update_goods_desc() {
        $this->admin_priv('goodslib_update');

        $goods_id = intval($_REQUEST['goods_id']);
        
        $goods = RC_DB::table('goodslib')->where('goods_id', $goods_id)->first();
        
        if (empty($goods) === true) {
            return $this->showmessage(sprintf(__('找不到ID为%s的商品！', 'goodslib'), $goods_id), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        
        $data = array(
            'goods_desc'	=> $_POST['goods_desc'],
            'last_update'	=> RC_Time::gmtime(),
        );
        RC_DB::table('goodslib')->where('goods_id', $goods_id)->update($data);
        
        /* 记录日志 */
        ecjia_admin::admin_log($goods['goods_name'], 'edit', 'goodslib');
        
        /* 提示页面 */
        $link[] = array(
            'href' => RC_Uri::url('goodslib/admin/init'),
            'text' => __('商品列表', 'goodslib')
        );
        return $this->showmessage(__('编辑商品成功', 'goodslib'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $link, 'max_id' => $goods_id));
    }
    
    /**
     * 商品参数页面
     */
    public function edit_goods_parameter() {
    	$this->admin_priv('goodslib_update');
    	
    	$this->assign('tags', $this->tags);
    	
    	ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('商品库', 'goodslib'), RC_Uri::url('goodslib/admin/init')));
    	ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('设置商品参数', 'goodslib')));
    
    	$this->assign('ur_here', __('设置商品参数', 'goodslib'));
    	$this->assign('action_link', array('href' => RC_Uri::url('goodslib/admin/init'), 'text' => __('商品列表', 'goodslib')));
    	
    	$goods_id = intval($_GET['goods_id']);
    	$this->assign('goods_id', $goods_id);
    	
    	$goodslib_info = RC_DB::table('goodslib')->where('goods_id', $goods_id)->first();
    	if (empty($goodslib_info)) {
    		return $this->showmessage(__('未检测到此商品', 'goodslib'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => array(array('text' => __('返回商品列表', 'goodslib'), 'href' => RC_Uri::url('goodslib/admin/init')))));
    	}
    	$this->assign('goodslib_info', $goodslib_info);
    	
    	if(!empty($goodslib_info['parameter_id'])) {
    		$template_id = $goodslib_info['parameter_id'];
    	} else {
    		$template_id = Ecjia\App\Goods\GoodsAttr::get_cat_template('parameter', $goodslib_info['cat_id']);
    	}
    	$this->assign('template_id', $template_id);
    	
    	if ($template_id) {
    		$this->assign('has_template', 'has_template');
    			
    		$template_info = Ecjia\App\Goods\GoodsAttr::get_template_info($template_id);
    		$this->assign('template_info', $template_info);

    		$this->assign('goods_attr_html', Ecjia\App\Goods\GoodsAttr::goodslib_build_attr_html($template_id, $goods_id));
    	}
    	
    	$this->assign('form_action', RC_Uri::url('goodslib/admin/update_goods_parameter', array('goods_id' => $goods_id)));
    
    	return $this->display('goods_parameter.dwt');
    }
    
  	/**
	 * 更新商品参数逻辑处理
	 */
    public function update_goods_parameter() {
    	$this->admin_priv('goods_update');
    		
    	$goods_type = !empty($_POST['template_id'])	 ? intval($_POST['template_id'])  : 0;
    	$goods_id 	= !empty($_POST['goods_id'])     ? intval($_POST['goods_id'])     : 0;
    	
    	$attr_id_list = $this->request->input('attr_id_list');
    	$input_all    = $this->request->input();
    	
    	if (!empty($attr_id_list)) {
    		$attr_id_list = collect($attr_id_list)->mapWithKeys(function ($attr_id) use ($input_all) {
    			$vkey = $attr_id . '_attr_value_list';
    			$vvalue = array_get($input_all, $vkey);
    			return [$attr_id => $vvalue];
    		});
    		
			$updateGoodsAttr = function ($goods_id, $attr_id_list) {
				$collection = GoodslibAttrModel::where('cat_type', 'parameter')->where('goods_id', $goods_id)->get();
				$collection = $collection->groupBy('attr_id');
				$attr_id_list->map(function($id_values, $key) use ($collection, $goods_id) {
					$new_collection = $collection->get($key);
					if (is_null($id_values)) {
						if (!empty($new_collection)) {
							$new_collection->map(function($model){
								$model->delete();
							});
						}
					} elseif (is_array($id_values)) {
						if (!empty($new_collection)) {
							$new_collection->map(function($model) use ($id_values) {
								if (!in_array($model->attr_value, $id_values) ) {
									$model->delete();
								}
									
							});
							$old_values = $new_collection->pluck('attr_value')->all();
							$new_values = collect($id_values)->diff($old_values);
						} else {
							$new_values = $id_values;
						}
						foreach ($new_values as $v) {
							GoodslibAttrModel::insert([
    							'cat_type' => 'parameter',
    							'goods_id' => $goods_id,
    							'attr_id' => $key,
    							'attr_value' => $v,
							]);
						}
					} else {
						if (!empty($new_collection)) {
							$new_collection->map(function($model) use ($id_values) {
								$model->attr_value = $id_values;
								$model->save();
							});
						} else {
							GoodslibAttrModel::insert([
    							'cat_type' => 'parameter',
    							'goods_id' => $goods_id,
    							'attr_id' => $key,
    							'attr_value' => $id_values,
							]);
						}
					}
				});
			};
			$updateGoodsAttr($goods_id, $attr_id_list);
			$data = array(
				'parameter_id' => $goods_type,
			);
			RC_DB::table('goodslib')->where('goods_id', $goods_id)->update($data);
	
			$pjaxurl = RC_Uri::url('goodslib/admin/edit_goods_parameter', array('goods_id' => $goods_id));
			return $this->showmessage(__('编辑商品参数成功', 'goodslib'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $pjaxurl));
    	}
    	
    }
    
    /**
     * 更换参数模板需要清除数据
     */
    public function clear_parameter_data() {
    	$this->admin_priv('goods_update');
    
    	$goods_id = intval($_POST['goods_id']);
    	$count = RC_DB::TABLE('goods')->where('goodslib_id', $goods_id)->count();
    	if($count > 0) {
    		return $this->showmessage(__('该商品库商品已被导入使用，不可以随意更改参数模板', 'goodslib'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('pjaxurl' => RC_Uri::url('goodslib/admin/edit_goods_parameter', array('goods_id' => $goods_id))));
    	} else {
    		//清除商品关联的模板id为0
    		RC_DB::table('goodslib')->where('goods_id', $goods_id)->update(array('parameter_id' => 0));
    		
    		//删除关联的规格属性
    		RC_DB::table('goodslib_attr')->where(array('goods_id' => $goods_id))->where(array('cat_type' => 'parameter'))->delete();
    		return $this->showmessage(__('清除相关数据成功，您可以重新进行更换参数模板', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('goodslib/admin/edit_goods_parameter', array('goods_id' => $goods_id))));
    		
    	}
    }
    
    /**
     * 设置规格页面
     */
    public function edit_goods_specification() {
    	$this->admin_priv('goodslib_update');
    	
    	$this->assign('tags', $this->tags);
    	
    	ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('商品库', 'goodslib'), RC_Uri::url('goodslib/admin/init')));
    	ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('设置商品规格', 'goodslib')));
    	
    	$this->assign('ur_here', __('设置商品规格', 'goodslib'));
    	$this->assign('action_link', array('href' => RC_Uri::url('goodslib/admin/init'), 'text' => __('商品列表', 'goodslib')));
    	
    	$goods_id = intval($_GET['goods_id']);
    	$this->assign('goods_id', $goods_id);
    	
    	$goodslib_info = RC_DB::table('goodslib')->where('goods_id', $goods_id)->first();
    	if (empty($goodslib_info)) {
    		return $this->showmessage(__('未检测到此商品', 'goodslib'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => array(array('text' => __('返回商品列表', 'goodslib'), 'href' => RC_Uri::url('goodslib/admin/init')))));
    	}
    	$this->assign('goodslib_info', $goodslib_info);
    	
    	if(!empty($goodslib_info['specification_id'])) {
    		$template_id = $goodslib_info['specification_id'];
    	} else {
    		$template_id = Ecjia\App\Goods\GoodsAttr::get_cat_template('specification', $goodslib_info['cat_id']);
    	}
    	$this->assign('template_id', $template_id);
    	if ($template_id) {
    		$this->assign('has_template', 'has_template');
    	
    		$template_info = Ecjia\App\Goods\GoodsAttr::get_template_info($template_id);
    		$this->assign('template_info', $template_info);
    			
    		$this->assign('goods_attr_html', Ecjia\App\Goods\GoodsAttr::goodslib_build_specification_html($template_id, $goods_id));
    	}
    	
    	$count = RC_DB::table('goodslib_attr')->where('goods_id', $goods_id)->where('cat_type', 'specification')->count();
    	if ($count > 0) {
    		$this->assign('has_spec', 'has_spec');
    	}
    	
    	$product = Ecjia\App\Goods\GoodsAttr::goodslib_product_list($goods_id, '');
    	$this->assign('product_list', 		$product['product']);

    	$this->assign('form_action', RC_Uri::url('goodslib/admin/update_goods_specification', array('goods_id' => $goods_id)));
    
    	return $this->display('goods_specification.dwt');
    }
    
    /**
     * 更新商品规格逻辑处理
     */
    public function update_goods_specification() {
    	$this->admin_priv('goods_update');
    		
    	$goods_type     = !empty($_POST['template_id'])	   ? intval($_POST['template_id'])   : 0;
    	$goods_id 	    = !empty($_POST['goods_id'])       ? intval($_POST['goods_id'])      : 0;
 
    	$data = array(
    		'specification_id'  => $goods_type,
    	);
    	RC_DB::table('goodslib')->where('goods_id', $goods_id)->update($data);
    	
    	$product['product_id']         = $_POST['product_id'];
    	$product['product_bar_code']   = $_POST['product_bar_code'];
    	$product['product_shop_price'] = $_POST['product_shop_price'];
    	$product['product_number']     = $_POST['product_number'];
	    if (!empty($product['product_id'])) {
			$use_storage = ecjia::config('use_storage');
			foreach($product['product_id'] as $key => $value) {
				$product['product_bar_code'][$key]   = empty($product['product_bar_code'][$key]) ? ''   : trim($product['product_bar_code'][$key]); 
				$product['product_shop_price'][$key] = empty($product['product_shop_price'][$key]) ? null  : trim($product['product_shop_price'][$key]);
				
				$data = array(
					'product_bar_code' 	=> $product['product_bar_code'][$key],
					'product_shop_price'=> $product['product_shop_price'][$key],
				);
				RC_DB::TABLE('goodslib_products')->where('product_id', $value)->update($data);
			}
		}

		$pjaxurl = RC_Uri::url('goodslib/admin/edit_goods_specification', array('goods_id' => $goods_id));
		return $this->showmessage(__('设置商品规格成功', 'goodslib'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $pjaxurl));
	}
	


    /**
     * 选择商品属性返回值
     */
    public function select_spec_values() {
        $this->admin_priv('goods_update');
        
        $goods_id = intval($_POST['goods_id']);
        $this->assign('goods_id', $goods_id);
                
        $goods_info = RC_DB::TABLE('goodslib')->where('goods_id', $goods_id)->select('specification_id', 'cat_id')->first();    
        if(!empty($goods_info['specification_id'])) {
            $template_id = $goods_info['specification_id'];
        } else {
            $template_id = Ecjia\App\Goods\GoodsAttr::get_cat_template('specification', $goods_info['cat_id']);
        }
        if ($template_id) {
        	$this->assign('template_id', $template_id);
            $this->assign('goods_attr_html', Ecjia\App\Goods\GoodsAttr::goodslib_build_specification_html($template_id, $goods_id));
        }

        $count = RC_DB::TABLE('goodslib_products')->where('goods_id', $goods_id)->count();
        if ($count > 0) {
        	$this->assign('has_product', 'has_product');
        }
        
        $data = $this->fetch('select_spec_values.dwt');
        
        return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('data' => $data));
    }
    
    /**
     * 设置属性值处理
     */
    public function select_spec_values_insert() {
    	$this->admin_priv('goods_update');
    	
    	$goods_id 	= !empty($_POST['goods_id'])     ? intval($_POST['goods_id'])     : 0;
    	
    	$template_id = intval($_POST['template_id']);
    	RC_DB::table('goodslib')->where('goods_id', $goods_id)->update(array('specification_id'  => $template_id));
    	
    	$attr_id_list = $this->request->input('attr_id_list');
    	$input_all    = $this->request->input();
    	
    	if (!empty($attr_id_list)) {
    		$attr_id_list = collect($attr_id_list)->mapWithKeys(function ($attr_id) use ($input_all) {
    			$vkey = $attr_id . '_attr_value_list';
    			$vvalue = array_get($input_all, $vkey);
    			return [$attr_id => $vvalue];
    		});
    				
			$updateGoodsAttr = function ($goods_id, $attr_id_list) {
				$collection = GoodslibAttrModel::where('cat_type', 'specification')->where('goods_id', $goods_id)->get();
				$collection = $collection->groupBy('attr_id');
				$attr_id_list->map(function($id_values, $key) use ($collection, $goods_id) {
					$new_collection = $collection->get($key);
					if (!empty($new_collection)) {
						$new_collection->map(function($model) use ($id_values) {
							if (!in_array($model->attr_value, $id_values) ) {
								$model->delete();
							}
	
						});
						$old_values = $new_collection->pluck('attr_value')->all();
						$new_values = collect($id_values)->diff($old_values);
					}
					else {
						$new_values = $id_values;
					}
	
					//添加新增的
					foreach ($new_values as $v) {
						GoodslibAttrModel::insert([
							'cat_type'   => 'specification',
							'goods_id'   => $goods_id,
							'attr_id'    => $key,
							'attr_value' => $v,
						]);
					}
						
				});
			};
				
			$updateGoodsAttr($goods_id, $attr_id_list);
	
			return $this->showmessage(__('选择规格属性成功', 'goodslib'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('goodslib/admin/edit_goods_specification', array('goods_id' => $goods_id))));
    	}
    	
    }
    /**
     * 添加货品-规格属性 单选
     */
    public function spec_add_product() {
    	$this->admin_priv('goods_update');
    
    	$goods_id = intval($_POST['goods_id']);
    	$this->assign('goods_id', $goods_id);
    
    	$attribute = Ecjia\App\Goods\GoodsAttr::get_goodslib_spec_list($goods_id);
    	$spec_attribute_list = array();
    	if (!empty($attribute)) {
    		foreach ($attribute as $attribute_value) {
    			$spec_attribute_list[$attribute_value['attr_id']]['attr_id'] = $attribute_value['attr_id'];
    			$spec_attribute_list[$attribute_value['attr_id']]['attr_name'] = $attribute_value['attr_name'];
    			$spec_attribute_list[$attribute_value['attr_id']]['attr_values'][$attribute_value['goods_attr_id']] = $attribute_value['attr_value'];
    		}
    	}
    	$this->assign('spec_attribute_list', $spec_attribute_list);
    
    	$product_value = array();
    	foreach ($spec_attribute_list as $value) {
    		$attr_values = key($value['attr_values']);
    		array_push($product_value, $attr_values);
    	}

        asort($product_value);
    	$goods_attr = implode('|', $product_value);
    	$product_sn = RC_DB::table('goodslib_products')->where('goods_attr', $goods_attr)->pluck('product_sn');
    	$data = $this->fetch('spec_add_product.dwt');
    
    	return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('data' => $data, 'product_sn' => $product_sn));
    }
    
    /**
     * 添加货品处理
     */
    public function spec_add_product_insert() {
    	$this->admin_priv('goods_update');
    
    	$goods_id = intval($_POST['goods_id']);
    	$product_value = $_POST['radio_value_arr'];
    
    	if (empty($goods_id)) {
    		return $this->showmessage(__('找不到指定的商品', 'goodslib'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    
    	$goods = RC_DB::table('goodslib')->where('goods_id', $goods_id)->select('goods_sn', 'goods_name', 'goods_type', 'shop_price')->first();

        asort($product_value);
    	$goods_attr = implode('|', $product_value);
    	if (Ecjia\App\Goods\GoodsAttr::check_goods_attr_exist($goods_attr, $goods_id)) {
    		return $this->showmessage(__('所匹配的属性已存在相应的货品,请更换组合', 'goodslib'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	} else {
    		$data = array(
    			'goods_id' 		=> $goods_id,
    			'goods_attr'	=> $goods_attr,
    		);
    		$product_id = RC_DB::TABLE('goodslib_products')->insertGetId($data);
    		RC_DB::TABLE('goodslib_products')->where('product_id', $product_id)->update(array('product_sn' => $goods['goods_sn'] . "g_p" . $product_id));
    		$product_sn = RC_DB::TABLE('goodslib_products')->where('product_id', $product_id)->pluck('product_sn');
    		if($product_sn) {
    			return $this->showmessage(__('添加货品成功', 'goodslib'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('product_sn' => $product_sn));
    		} else {
    			return $this->showmessage(__('添加货品失败', 'goodslib'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('product_sn' => $product_sn));
    		}
    	}
    }
    
    /**
     * 移除货品处理
     */
    public function spec_del_product() {
    	$this->admin_priv('goods_update');
    
    	$goods_id = intval($_POST['goods_id']);
    	$product_value = $_POST['radio_value_arr'];
    
    	if (empty($goods_id)) {
    		return $this->showmessage(__('找不到指定的商品', 'goodslib'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
        asort($product_value);
    	$goods_attr = implode('|', $product_value);
    
    	if(RC_DB::table('goodslib_products')->where('goods_id', $goods_id)->where('goods_attr', $goods_attr)->delete()) {
    		return $this->showmessage(__('移除货品成功', 'goodslib'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
    	} else {
    		return $this->showmessage(__('移除货品失败', 'goodslib'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    }
    
    
    /**
     * 切换radio获取货号
     */
    public function ajax_select_radio() {
    	$this->admin_priv('goods_update');
    
    	$goods_id 		= intval($_POST['goods_id']);
    	$product_value  = !empty($_POST['radio_value_arr']) ? $_POST['radio_value_arr']   : '';
    
    	if (empty($goods_id)) {
    		return $this->showmessage(__('找不到指定的商品', 'goodslib'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
        asort($product_value);
    	$goods_attr = implode('|', $product_value);
    	$product_sn = RC_DB::table('goodslib_products')->where('goods_attr', $goods_attr)->pluck('product_sn');
    
    	if(!empty($product_sn)) {
    		return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('product_sn' => $product_sn));
    	}
    }
    
    /**
     * 更换模板需要清除数据（规格、货品、商品关联模板id）
     */
    public function clear_spec_data() {
    	$this->admin_priv('goods_update');
    
    	$goods_id = intval($_POST['goods_id']);
    	$count = RC_DB::TABLE('goods')->where('goodslib_id', $goods_id)->count();
    	if($count > 0) {
    		return $this->showmessage(__('该商品库商品已被导入使用，不可以随意更改规格模板', 'goodslib'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('pjaxurl' => RC_Uri::url('goodslib/admin/edit_goods_specification', array('goods_id' => $goods_id))));
    	} else {
    		//清除商品关联的模板id为0
    		RC_DB::table('goodslib')->where('goods_id', $goods_id)->update(array('specification_id' => 0));
    			
    		//删除关联的规格属性
    		RC_DB::table('goodslib_attr')->where(array('goods_id' => $goods_id))->where(array('cat_type' => 'specification'))->delete();
    			
    		//删除货品相关
    		$product_list = RC_DB::TABLE('goodslib_products')->where('goods_id', $goods_id)->lists('product_id');
    		foreach($product_list as $value) {
    			$product = Ecjia\App\Goods\GoodsAttr::get_goodslib_products_info($value, 'goods_id');
    			$image_data = new product_image_data('', '', '', 0, $value);
    			$image_data->delete_images();
    			$result = RC_DB::TABLE('goodslib_products')->where('product_id', $value)->delete();
    			if ($result) {
    				$image_data->delete_gallery();
    				RC_DB::table('goodslib_gallery')->where('product_id', $value)->delete();
    			}
    		}
    		return $this->showmessage(__('清除相关数据成功，您可以重新进行更换规格模板', 'goodslib'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('goodslib/admin/edit_goods_specification', array('goods_id' => $goods_id))));
    	}
    }
    
    /**
     * 商品属性
     */
    public function edit_goods_attr() {
        $this->admin_priv('goodslib_update');
        
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('商品库', 'goodslib'), RC_Uri::url('goodslib/admin/init')));
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('编辑商品属性', 'goodslib')));
        
        $goods_id = $_REQUEST['goods_id'];
        $goods = RC_DB::table('goodslib')->where('goods_id', $goods_id)->first();
        if (empty($goods) === true) {
            $goods = array('goods_type' => 0); 	// 商品类型
        }
        /* 获取所有属性列表 */
        $attr_list = get_goodslib_cat_attr_list($goods['goods_type'], $goods_id);
        $specifications = get_goods_type_specifications();
        
        if (isset($specifications[$goods['goods_type']])) {
            $goods['specifications_id'] = $specifications[$goods['goods_type']];
        }
        $_attribute = get_goodslib_specifications_list($goods['goods_id']);
        $goods['_attribute'] = empty($_attribute) ? '' : 1;
        
        //设置选中状态,并分配标签导航
        $this->tags['edit_goods_attr']['active'] = 1;
        $this->assign('tags', $this->tags);
        $href = RC_Uri::url('goodslib/admin/init');
        
        $this->assign('action_link', array('href' => $href, 'text' => __('商品列表', 'goodslib')));
        $this->assign('goods_type_list', goods_type_list($goods['goods_type']));
        
        $this->assign('goods_attr_html', goodslib_build_attr_html($goods['goods_type'], $goods_id));
        $this->assign('ur_here', __('编辑商品属性', 'goodslib'));
        $this->assign('goods_id', $goods_id);
        
        $this->assign('form_action', RC_Uri::url('goodslib/admin/update_goods_attr','goods_id='.$goods_id));
        
        return $this->display('goods_attr.dwt');
    }
    
    /**
     * 商品属性页面 - 切换商品类型时，返回所需的属性菜单
     */
    public function get_attr() {
        $this->admin_priv('goodslib_update', ecjia::MSGTYPE_JSON);
        
        $goods_id = empty($_GET['goods_id']) ? 0 : intval($_GET['goods_id']);
        $goods_type = empty($_GET['goods_type']) ? 0 : intval($_GET['goods_type']);
        
        $content = goodslib_build_attr_html($goods_type, $goods_id);
        return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $content));
    }
    
    /**
     * 更新商品属性
     */
    public function update_goods_attr() {
        $this->admin_priv('goodslib_update', ecjia::MSGTYPE_JSON);
        
        $goods_type = isset($_POST['goods_type']) ? $_POST['goods_type'] : 0;
        $goods_id = isset($_GET['goods_id']) ? intval($_GET['goods_id']) : 0;
        
        if ((isset($_POST['attr_id_list']) && isset($_POST['attr_value_list'])) || (empty($_POST['attr_id_list']) && empty($_POST['attr_value_list']))) {
            // 取得原有的属性值
            $goods_attr_list = array();
            
            $data = RC_DB::table('attribute')->select('attr_id', 'attr_index')->where('cat_id', $goods_type)->get();
            $attr_list = array();
            if (is_array($data)) {
                foreach ($data as $key => $row) {
                    $attr_list[$row['attr_id']] = $row['attr_index'];
                }
            }
            
            $query = RC_DB::table('goodslib_attr as ga')
                ->leftJoin('attribute as a', RC_DB::raw('ga.attr_id'), '=', RC_DB::raw('a.attr_id'))
                ->where(RC_DB::raw('ga.goods_id'), $goods_id)->get();
            
            if (is_array($query)) {
                foreach ($query as $key => $row) {
                    $goods_attr_list[$row['attr_id']][$row['attr_value']] = array('sign' => 'delete', 'goods_attr_id' => $row['goods_attr_id']);
                }
            }
            
            // 循环现有的，根据原有的做相应处理
            if (isset($_POST['attr_id_list'])) {
            	
                foreach ($_POST['attr_id_list'] AS $key => $attr_id) {
                    $attr_value = $_POST['attr_value_list'][$key];
                    $attr_price = $_POST['attr_price_list'][$key];
                    if (!empty($attr_value)) {
                        if (isset($goods_attr_list[$attr_id][$attr_value])) {
                            // 如果原来有，标记为更新
                            $goods_attr_list[$attr_id][$attr_value]['sign'] = 'update';
                            $goods_attr_list[$attr_id][$attr_value]['attr_price'] = $attr_price;
                        } else {
                            // 如果原来没有，标记为新增
                            $goods_attr_list[$attr_id][$attr_value]['sign'] = 'insert';
                            $goods_attr_list[$attr_id][$attr_value]['attr_price'] = $attr_price;
                        }
                    }
                }
            }
            $data = array(
                'goods_type'	=> $goods_type
            );
            RC_DB::table('goodslib')->where('goods_id', $goods_id)->update($data);
            
            $data_insert = array();
            $data_update = array();
            /* 插入、更新、删除数据 */
            $goods_type = isset($_POST['goods_type']) ? $_POST['goods_type'] : 0;
            foreach ($goods_attr_list as $attr_id => $attr_value_list) {
                foreach ($attr_value_list as $attr_value => $info) {
                    if ($info['sign'] == 'insert') {
                        $data_insert[] = array(
                            'attr_id'		=> $attr_id,
                            'goods_id'		=> $goods_id,
                            'attr_value'	=> $attr_value,
                            'attr_price'	=> $info['attr_price']
                        );
                    } elseif ($info['sign'] == 'update') {
                        $data = array(
                            'attr_price' => $info['attr_price']
                        );
                        if (isset($info['goods_attr_id'])) {
                            RC_DB::table('goodslib_attr')->where('goods_attr_id', $info['goods_attr_id'])->update($data);
                        }
                    } else {
                        //查询要删除的属性是否存在对应货品
                        $count = RC_DB::table('goodslib_products')->where('goods_id', $goods_id)->whereRaw(RC_DB::raw(" CONCAT('|', goods_attr, '|') like '%|".$info['goods_attr_id']."|%' "))->count();
                        if($count) {
                            return $this->showmessage(__('请先删除关联的货品再修改规格属性', 'goodslib'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                        }
                        RC_DB::table('goodslib_attr')->where('goods_attr_id', $info['goods_attr_id'])->delete();
                    }
                }
            }
            RC_DB::table('goodslib_attr')->insert($data_insert);
            //为更新用户购物车数据加标记
//             RC_Api::api('cart', 'mark_cart_goods', array('goods_id' => $goods_id));
            
            
            $pjaxurl = RC_Uri::url('goodslib/admin/edit_goods_attr', array('goods_id' => $goods_id));
            return $this->showmessage(__('编辑属性成功', 'goodslib'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $pjaxurl));
        }
    }
    
    /**
     * 货品列表
     */
    public function product_list() {
        $this->admin_priv('goodslib_manage');
        
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('商品库', 'goodslib'), RC_Uri::url('goodslib/admin/init')));
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('货品列表', 'goodslib')));
        
        $goods_id = intval($_GET['goods_id']);
        if (empty($goods_id)) {
            $links[] = array('text' => __('返回商品列表', 'goodslib'), 'href' => RC_Uri::url('goodslib/admin/init'));
            return $this->showmessage(__('缺少参数，请重试', 'goodslib'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => $links));
        }
        
        $db_goods = RC_DB::table('goodslib')->where('goods_id', $goods_id);
        //获取商品的信息
        $goods = $db_goods->select(RC_DB::raw('goods_sn, goods_name, goods_type, shop_price'))->first();
        //获得商品已经添加的规格列表
        $attribute = get_goodslib_specifications_list($goods_id);
        
        $_attribute = array();
        if (!empty($attribute)) {
            foreach ($attribute as $attribute_value) {
                $_attribute[$attribute_value['attr_id']]['attr_values'][] = $attribute_value['attr_value'];
                $_attribute[$attribute_value['attr_id']]['attr_id'] = $attribute_value['attr_id'];
                $_attribute[$attribute_value['attr_id']]['attr_name'] = $attribute_value['attr_name'];
            }
        }
        $attribute_count = count($_attribute);
        
        if (empty($attribute_count)) {
            $links[] = array('text' => __('商品属性', 'goodslib'), 'href' => RC_Uri::url('goodslib/admin/edit_goods_attr', array('goods_id' => $goods_id)));
            $links[] = array('text' => __('返回商品列表', 'goodslib'), 'href' => RC_Uri::url('goodslib/admin/init'));
            return $this->showmessage(__('请先添加库存属性，再到货品管理中设置货品库存', 'goodslib'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => $links));
        }
        
        /* 取商品的货品 */
        $product = goodslib_product_list($goods_id, '');
        
        $this->assign('tags',              	$this->tags);
        $this->assign('goods_name', 		sprintf(__('商品名称：%s', 'goodslib'), $goods['goods_name']));
        $this->assign('goods_sn', 			sprintf(__('货号：%s', 'goodslib'), $goods['goods_sn']));
        $this->assign('attribute', 			$_attribute);
        $this->assign('product_sn', 		$goods['goods_sn'] . '_');
        $this->assign('product_number', 	ecjia::config('default_storage'));
        
        $this->assign('action_link', 		array('href' => RC_Uri::url('goodslib/admin/init'), 'text' => __('商品列表', 'goodslib')));
        $this->assign('product_list', 		$product['product']);
        $this->assign('goods_id', 			$goods_id);
        $this->assign('form_action', 		RC_Uri::url('goodslib/admin/product_add_execute'));
        if (isset($_GET['step'])) {
            $this->assign('step', 8);
            $ur_here = __('添加货品（SKU）', 'goodslib');
        } else {
            $ur_here = __('编辑货品（SKU）', 'goodslib');
        }
        $this->assign('ur_here', $ur_here);
        return $this->display('product_info.dwt');
    }

    public function product_edit() {
        $this->admin_priv('goodslib_manage');

        $goods_id = intval($_GET['goods_id']);
        $product_id = intval($_GET['id']);
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('商品库', 'goodslib'), RC_Uri::url('goodslib/admin/init')));
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('货品列表', 'goodslib'), RC_Uri::url('goodslib/admin/product_list', 'goods_id='.$goods_id)));
        $ur_here = __('编辑货品（SKU）', 'goodslib');
        $this->assign('ur_here', $ur_here);

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here($ur_here));


        $db_goods = RC_DB::table('goodslib')->where('goods_id', $goods_id);

        //获取商品的信息
        $goods = $db_goods->select('goods_sn', 'goods_name', 'goods_type', 'shop_price')->first();
        if (empty($goods)) {
            return $this->showmessage(__('未检测到此商品', 'goodslib'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => array(array('text' => __('返回商品列表', 'goodslib'), 'href' => RC_Uri::url('goodslib/admin/init')))));
        }

        $info = RC_DB::table('goodslib_products')->where('product_id', $product_id)->where('goods_id', $goods_id)->first();
        /* 商品图片路径 */
        if (!empty($info['product_img'])) {
            $info['product_img'] 	= goods_imageutils::getAbsoluteUrl($info['product_img']);
            $info['product_thumb'] 	= goods_imageutils::getAbsoluteUrl($info['product_thumb']);
            $info['product_original_img'] 	= goods_imageutils::getAbsoluteUrl($info['product_original_img']);
        }

        $this->assign('action_link', array('href' => RC_Uri::url('goodslib/admin/edit_goods_specification', ['goods_id' => $goods_id]), 'text' => __('商品编辑', 'goodslib')));


        $this->assign('goods_name', 		sprintf(__('商品名称：%s', 'goodslib'), $goods['goods_name']));
        $this->assign('goods', $goods);
        $this->assign('info', $info);
        $this->assign('form_action', 		RC_Uri::url('goodslib/admin/product_update'));

        $product = goodslib_product_list($goods_id, '');
        $this->assign('product_list', $product['product']);

        return $this->display('product_edit.dwt');
    }

    public function product_update()
    {
        $this->admin_priv('goodslib_manage');

        $product_id = !empty($_POST['product_id']) ? intval($_POST['product_id']) : 0;
        $info = RC_DB::table('goodslib_products')->where('product_id', $product_id)->first();
        $goods = RC_DB::table('goodslib')->where('goods_id', $info['goods_id'])->first();

        /* 检查货号是否重复 */
        if (trim($_POST['product_sn'])) {
            $count = RC_DB::table('goodslib_products')->where('product_sn', trim($_POST['product_sn']))->where('product_id', '!=', $product_id)->count();
            if ($count > 0) {
                return $this->showmessage(__('您输入的货号已存在，请换一个', 'goodslib'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
        }

        $upload = RC_Upload::uploader('image', array('save_path' => 'images', 'auto_sub_dirs' => true));
        $upload->add_saving_callback(function ($file, $filename) {
            return true;
        });

        /* 是否处理商品图 */
        $proc_goods_img = true;
        if (isset($_FILES['goods_img']) && !$upload->check_upload_file($_FILES['goods_img'])) {
            $proc_goods_img = false;
        }
//
        /* 是否处理缩略图 */
        $proc_thumb_img = isset($_FILES['thumb_img']) ? true : false;
        if (isset($_FILES['thumb_img']) && !$upload->check_upload_file($_FILES['thumb_img'])) {
            $proc_thumb_img = false;
        }

        if ($proc_goods_img) {
            if (isset($_FILES['goods_img'])) {
                $image_info = $upload->upload($_FILES['goods_img']);
                if (empty($image_info)) {
                    return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                }
            }
        }

        if ($proc_thumb_img) {
            if (isset($_FILES['thumb_img'])) {
                $thumb_info = $upload->upload($_FILES['thumb_img']);
                if (empty($thumb_info)) {
                    return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                }
            }
        }

        /* 处理商品图片 */
        $goods_img	 	= ''; // 初始化商品图片
        $goods_thumb 	= ''; // 初始化商品缩略图
        $img_original	= ''; // 初始化原始图片

        /* 处理商品数据 */
        $product_name 	= !empty($_POST['product_name']) 		? $_POST['product_name'] 				: '';
        $shop_price 	= $_POST['product_shop_price'] != '' 	? $_POST['product_shop_price'] 				: NULL;
        $product_sn     = !empty($_POST['product_sn'])          ? trim($_POST['product_sn'])                : '';

        $product_bar_code = isset($_POST['product_bar_code']) 	? $_POST['product_bar_code'] 	: '';

        //货品号不为空
        if (!empty($product_sn)) {
            /* 检测：货品货号是否在商品表和货品表中重复 */
            if (check_goodslib_sn_exist($product_sn, $info['goods_id'])) {
                return $this->showmessage(__('货品号已存在，请修改', 'goodslib'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            if (check_goodslib_product_sn_exist($product_sn, $product_id)) {
                return $this->showmessage(__('货品号已存在，请修改', 'goodslib'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
        } else {
            //货品号为空 自动补货品号
            $product_sn = $goods['goods_sn'] . "g_p" . $product_id;
        }

        $data = array(
            'product_name'				=> rc_stripslashes($product_name),
            'product_sn'			  	=> $product_sn,
            'product_shop_price'		=> $shop_price,
            'product_bar_code'		  	=> $product_bar_code,
        );
        RC_DB::table('goodslib_products')->where('product_id', $product_id)->update($data);

        /* 记录日志 */
        $log_object = $product_name;
        if(empty($log_object)) {
            $log_object = $goods['goods_name'];
        }
        ecjia_admin::admin_log($log_object, 'edit', 'goodslib_product');

        /* 更新上传后的商品图片 */
        if ($proc_goods_img) {
            if (isset($image_info)) {
                $goods_image = new product_image_data($image_info['name'], $image_info['tmpname'], $image_info['ext'], $info['goods_id'], $product_id);
                if ($proc_thumb_img) {
                    $goods_image->set_auto_thumb(false);
                }

                $result = $goods_image->update_goods();

                if (is_ecjia_error($result)) {
                    return $this->showmessage($result->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                }
            }
        }

        /* 更新上传后的缩略图片 */
        if ($proc_thumb_img) {
            if (isset($thumb_info)) {
                $thumb_image = new product_image_data($thumb_info['name'], $thumb_info['tmpname'], $thumb_info['ext'], $info['goods_id'], $product_id);
                $result = $thumb_image->update_thumb();
                if (is_ecjia_error($result)) {
                    return $this->showmessage($result->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                }
            }
        }

        $pjaxurl = RC_Uri::url('goodslib/admin/product_edit', "id=$product_id&goods_id=".$info['goods_id']);
        return $this->showmessage(__('编辑货品成功', 'goodslib'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $pjaxurl));

    }

    /**
     * 货品编辑
     */
    public function product_desc_edit()
    {
        $this->admin_priv('goodslib_manage');

        $goods_id = intval($_GET['goods_id']);
        $product_id = intval($_GET['id']);
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('商品库', 'goodslib'), RC_Uri::url('goodslib/admin/init')));
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('货品列表', 'goodslib'), RC_Uri::url('goodslib/admin/product_list', 'goods_id='.$goods_id)));
        $ur_here = __('编辑货品（SKU）', 'goodslib');
        $this->assign('ur_here', $ur_here);

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here($ur_here));


        $db_goods = RC_DB::table('goodslib')->where('goods_id', $goods_id);

        //获取商品的信息
        $goods = $db_goods->select('goods_sn', 'goods_name', 'goods_type', 'shop_price')->first();
        if (empty($goods)) {
            return $this->showmessage(__('未检测到此商品', 'goodslib'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => array(array('text' => __('返回商品列表', 'goodslib'), 'href' => RC_Uri::url('goodslib/admin/init')))));
        }

        $info = RC_DB::table('goodslib_products')->where('product_id', $product_id)->where('goods_id', $goods_id)->first();
        if (empty($info)) {
            return $this->showmessage(__('未检测到此货品', 'goodslib'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => array(array('text' => __('返回商品列表', 'goodslib'), 'href' => RC_Uri::url('goodslib/admin/init')))));
        }

        $this->assign('action_link', array('href' => RC_Uri::url('goodslib/admin/product_list', ['goods_id' => $goods_id]), 'text' => __('商品编辑', 'goodslib')));


        $this->assign('goods_name', 		sprintf(__('商品名称：%s', 'goodslib'), $goods['goods_name']));
        $this->assign('goods', $goods);
        $this->assign('nav_tag', 'desc');


        if (!empty($info['product_desc'])) {
            $info['product_desc'] = stripslashes($info['product_desc']);
        }
        $this->assign('info', $info);
        $this->assign('goods_id', $goods_id);
        $this->assign('form_action', RC_Uri::url('goodslib/admin/product_desc_update', 'goods_id='.$goods_id.'&id='.$product_id));

        $product = goodslib_product_list($goods_id, '');
        $this->assign('product_list', $product['product']);

        return $this->display('product_desc.dwt');
    }
    /**
     * 货品描述更新
     */
    public function product_desc_update() {
        $this->admin_priv('goodslib_update', ecjia::MSGTYPE_JSON); // 检查权限


        $goods_id 	= !empty($_GET['goods_id'])		? intval($_GET['goods_id']) : 0;
        $product_id 	= !empty($_GET['id'])		? intval($_GET['id']) : 0;

        $db_goods = RC_DB::table('goodslib')->where('goods_id', $goods_id);

        //获取商品的信息
        $goods = $db_goods->select('goods_sn', 'goods_name', 'goods_type', 'shop_price')->first();
        if (empty($goods)) {
            return $this->showmessage(__('未检测到此商品', 'goodslib'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => array(array('text' => __('返回商品列表', 'goodslib'), 'href' => RC_Uri::url('goodslib/admin/init')))));
        }

        $info = RC_DB::table('goodslib_products')->where('product_id', $product_id)->where('goods_id', $goods_id)->first();
        if (empty($info)) {
            return $this->showmessage(__('未检测到此货品', 'goodslib'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => array(array('text' => __('返回商品列表', 'goodslib'), 'href' => RC_Uri::url('goodslib/admin/init')))));
        }

        $data = array(
            'product_desc'  => !empty($_POST['product_desc']) ? $_POST['product_desc'] : '',
        );
        RC_DB::table('goodslib_products')->where('product_id', $product_id)->where('goods_id', $goods_id)->update($data);

        /* 记录日志 */
        $log_object = $info['product_name'];
        if(empty($log_object)) {
            $log_object = $goods['goods_name'];
        }
        ecjia_admin::admin_log($log_object, 'edit', 'goodslib_product');

        /* 提示页面 */

        $arr['goods_id'] = $goods_id;
        $arr['id'] = $product_id;
        $message = __('编辑成功', 'goodslib');
        $url = RC_Uri::url('goodslib/admin/product_desc_edit', $arr);
        return $this->showmessage($message, ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => $url, 'goods_id' => $goods_id,'id' => $product_id));
    }
    
    /**
     * 编辑货品
     */
    public function product_add_execute() {
        $this->admin_priv('goodslib_update', ecjia::MSGTYPE_JSON);
        
        $product['goods_id'] 		= $_POST['goods_id'];
        $product['attr'] 		    = !empty($_POST['attr'])           	? $_POST['attr']          	: '';
        $product['product_sn'] 		= !empty($_POST['product_sn'])    	? $_POST['product_sn']    	: '';
        $code 						= !empty($_GET['extension_code'])	? 'virtual_card'           	: '';
        $step 						= isset($_POST['step'])  			? trim($_POST['step']) 		: '';
        
        /* 是否存在商品id */
        if (empty($product['goods_id'])) {
            return $this->showmessage(__('找不到指定的商品', 'goodslib'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        
        /* 判断是否为初次添加 */
        $insert = true;
//         if (product_number_count($product['goods_id']) > 0) {
//             $insert = false;
//         }
        /* 取出商品信息 */
        $goods = RC_DB::table('goodslib')->where('goods_id', $product['goods_id'])->select('goods_sn', 'goods_name', 'goods_type', 'shop_price')->first();
        
        if (empty($goods)) {
            return $this->showmessage(__('找不到指定的商品', 'goodslib'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        
        if (!empty($product['product_sn'])) {
            foreach($product['product_sn'] as $key => $value) {
                
                //获取规格在商品属性表中的id
                foreach($product['attr'] as $attr_key => $attr_value) {
                    /* 检测：如果当前所添加的货品规格存在空值或0 */
                    if (empty($attr_value[$key])) {
                        continue 2;
                    }
                    $is_spec_list[$attr_key] = 'true';
                    $value_price_list[$attr_key] = $attr_value[$key] . chr(9) . ''; //$key，当前
                    $id_list[$attr_key] = $attr_key;
                }
                $goods_attr_id = handle_goodslib_attr($product['goods_id'], $id_list, $is_spec_list, $value_price_list);
                
                /* 是否为重复规格的货品 */
                $goods_attr = sort_goodslib_attr_id_array($goods_attr_id);
                asort($goods_attr['sort']);
                $goods_attr = implode('|', $goods_attr['sort']);
                
                if (check_goodslib_attr_exist($goods_attr, $product['goods_id'])) {
                    continue;
                }
                //货品号不为空
                if (!empty($value)) {
                    /* 检测：货品货号是否在商品表和货品表中重复 */
                    if (check_goodslib_sn_exist($value)) {
                        continue;
                    }
                    if (check_goodslib_product_sn_exist($value)) {
                        continue;
                    }
                }
                
                /* 插入货品表 */
                $data = array(
                    'goods_id' 			=> $product['goods_id'],
                    'goods_attr'		=> $goods_attr,
                    'product_sn' 		=> $value,
                );
                $product_id = RC_DB::table('goodslib_products')->insertGetId($data);
                
                //货品号为空 自动补货品号
                if (empty($value)) {
                    $data = array('product_sn' => $goods['goods_sn'] . "g_p" . $product_id);
                    RC_DB::table('goodslib_products')->where('product_id', $product_id)->update($data);
                }
                
                /* 修改商品表库存 */
//                 $product_count = product_number_count($product['goods_id']);
//                 $goods_id = explode(',', $product['goods_id']);
//                 if (update_goods($goods_id, 'goods_number', $product_count)) {
                    //记录日志
                    ecjia_admin::admin_log($product['goods_id'], 'update', 'goodslib');
//                 }
            }
        }
        
        if ($step) {
            $message = __('添加商品成功', 'goodslib');
            if ($code) {
                $arr['pjaxurl'] = RC_Uri::url('goodslib/admin/edit', array('goods_id' => $product['goods_id'], 'extension_code' => $code));
            } else {
                $arr['pjaxurl'] = RC_Uri::url('goodslib/admin/edit', array('goods_id' => $product['goods_id']));
            }
        } else {
            if ($code) {
                $arr['pjaxurl'] = RC_Uri::url('goodslib/admin/product_list', array('goods_id' => $product['goods_id'], 'extension_code' => $code));
            } else {
                $arr['pjaxurl'] = RC_Uri::url('goodslib/admin/product_list', array('goods_id' => $product['goods_id']));
            }
            $message = __('保存货品成功', 'goodslib');
        }
        return $this->showmessage($message, ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, $arr);
    }
    
    /**
     * 货品排序、分页、查询
     */
    public function product_query() {
        $this->admin_priv('goodslib_update', ecjia::MSGTYPE_JSON);
        /* 是否存在商品id */
        if (empty($_REQUEST['goods_id'])) {
            return $this->showmessage(__('货品id为空', 'goodslib'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        } else {
            $goods_id = intval($_REQUEST['goods_id']);
        }
        
        /* 取出商品信息 */
        $goods = RC_DB::table('goodslib')->where('goods_id', $goods_id)->select('goods_sn', 'goods_name', 'goods_type', 'shop_price')->first();
        
        if (empty($goods)) {
            return $this->showmessage(__('错误', 'goodslib'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        $this->assign('sn', sprintf(__('（商品货号：%s）', 'goodslib'), $goods['goods_sn']));
        $this->assign('price', sprintf(__('（商品价格：%d）', 'goodslib'), $goods['shop_price']));
        $this->assign('goods_name', sprintf(__('商品名称：%s', 'goodslib'), $goods['goods_name']));
        $this->assign('goods_sn', sprintf(__('货号：%s', 'goodslib'), $goods['goods_sn']));
        
        /* 获取商品规格列表 */
        $attribute = get_goods_specifications_list($goods_id);
        if (empty($attribute)) {
            return $this->showmessage(__('错误', 'goodslib'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        foreach ($attribute as $attribute_value) {
            //转换成数组
            $_attribute[$attribute_value['attr_id']]['attr_values'][] = $attribute_value['attr_value'];
            $_attribute[$attribute_value['attr_id']]['attr_id'] = $attribute_value['attr_id'];
            $_attribute[$attribute_value['attr_id']]['attr_name'] = $attribute_value['attr_name'];
        }
        $attribute_count = count($_attribute);
        
        $this->assign('attribute_count', $attribute_count);
        $this->assign('attribute', $_attribute);
        $this->assign('attribute_count_3', ($attribute_count + 3));
        $this->assign('product_sn', $goods['goods_sn'] . '_');
        
        /* 取商品的货品 */
        $product = goodslib_product_list($goods_id, '');
        
        $this->assign('ur_here', __('货品列表', 'goodslib'));
        $this->assign('action_link', array('href' => RC_Uri::url('goodslib/admin/init'), 'text' => __('商品列表', 'goodslib')));
        $this->assign('product_list', $product['product']);
        $use_storage = ecjia::config('use_storage');
        $this->assign('use_storage', empty($use_storage) ? 0 : 1);
        $this->assign('goods_id', $goods_id);
        $this->assign('filter', $product['filter']);
        
        /* 排序标记 */
        return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $this->fetch('product_info')));
    }
    
    /**
     * 货品删除
     */
    public function product_remove() {
        $this->admin_priv('goodslib_update', ecjia::MSGTYPE_JSON);
        
        $product_id = !empty($_GET['id']) ? intval($_GET['id']) : 0;
        $image_data = new product_image_data('', '', '', 0, $product_id);
        $image_data->delete_images();

        $result = RC_DB::table('goodslib_products')->where('product_id', $product_id)->delete();
        if ($result) {
            $image_data->delete_gallery();
            RC_DB::table('goodslib_gallery')->where('product_id', $product_id)->delete();
            //记录日志
            ecjia_admin::admin_log('', 'trash', 'products');
        }
        return $this->showmessage(__('删除成功！', 'goodslib'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
    }
    
    /**
     * 修改货品货号
     */
    public function edit_product_sn() {
        $this->admin_priv('goodslib_update', ecjia::MSGTYPE_JSON);
        
        
        $product_id = intval($_POST['pk']);
        $product_sn = trim($_POST['value']);
        $product_sn = ('N/A' == $product_sn) ? '' : $product_sn;
        
        if (check_goodslib_product_sn_exist($product_sn, $product_id)) {
            return $this->showmessage(__('货品货号重复', 'goodslib'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        /* 修改 */
        $data = array(
            'product_sn' => $product_sn,
        );
        $result = RC_DB::table('goodslib_products')->where('product_id', $product_id)->update($data);
        if ($result) {
            return $this->showmessage(__('货品修改成功！', 'goodslib'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $product_sn));
        }
    }
    
}