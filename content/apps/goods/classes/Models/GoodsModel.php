<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-02-19
 * Time: 18:16
 */

namespace Ecjia\App\Goods\Models;

use Royalcms\Component\Database\Eloquent\Model;
use RC_Cache;

class GoodsModel extends Model
{

    protected $table = 'goods';

    protected $primaryKey = 'goods_id';

    /**
     * 可以被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = [
        'store_id',
        'cat_id',
        'cat_level1_id',
        'cat_level2_id',
        'merchant_cat_id',
        'merchat_cat_level1_id',
        'merchat_cat_level2_id',
        'goods_sn',
        'goods_barcode',
        'goods_name',
        'goods_name_style',
        'click_count',
        'brand_id',
        'provider_name',
        'goods_number',
        'weight_stock',
        'goods_weight',
        'weight_unit',
        'default_shipping',
        'market_price',
        'shop_price',
        'cost_price',
        'generate_date',
        'expiry_date',
        'limit_days',
        'promote_price',
        'promote_start_date',
        'promote_end_date',
        'warn_number',
        'keywords',
        'goods_brief',
        'goods_desc',
        'goods_thumb',
        'goods_img',
        'original_img',
        'is_real',
        'extension_code',
        'is_on_sale',
        'is_alone_sale',
        'is_shipping',
        'integral',
        'add_time',
        'sort_order',
        'store_sort_order',
        'is_delete',
        'is_best',
        'is_new',
        'is_hot',
        'is_promote',
        'bonus_type_id',
        'last_update',
        'goods_type',
        'seller_note',
        'give_integral',
        'rank_integral',
        'suppliers_id',
        'is_check',
        'store_hot',
        'store_new',
        'store_best',
        'group_number',
        'is_xiangou',
        'xiangou_start_date',
        'xiangou_end_date',
        'xiangou_num',
        'review_status',
        'review_content',
        'goods_shipai',
        'comments_number',
        'sales_volume',
        'model_price',
        'model_inventory',
        'model_attr',
        'largest_amount',
        'pinyin_keyword',
        'goods_product_tag',
        'goodslib_id',
        'goodslib_update_time'
    ];

    /**
     * 该模型是否被自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * 一对一
     * 获取商品店铺信息
     */
    public function store_franchisee_model()
    {
        return $this->belongsTo('Ecjia\App\Goods\Models\StoreFranchiseeModel', 'store_id', 'store_id');
    }
    
    /**
     * 一对多
     * 商品会员等级价集合信息
     */
    public function member_price_collection()
    {
    	return $this->hasMany('Ecjia\App\Goods\Models\MemberPriceModel', 'goods_id', 'goods_id');
    }
    
    /**
     *  一对多
     * 商品货品集合信息
     */
    public function products_collection()
    {
    	return $this->hasMany('Ecjia\App\Goods\Models\ProductsModel', 'goods_id', 'goods_id');
    }
    
    /**
     * 一对一
     * 商品商家分类信息
     */
    public function merchants_category_model()
    {
    	return $this->belongsTo('Ecjia\App\Goods\Models\MerchantCategoryModel', 'merchant_cat_id', 'cat_id');
    }
    
    /**
     * 一对多
     * 商品规格的属性集合信息
     */
    public function goods_attr_collection()
    {
    	return $this->hasMany('Ecjia\App\Goods\Models\GoodsAttrModel', 'goods_id', 'goods_id');
    }
    
    /**
     * 一对一
     * 商品规格信息
     */
    public function goods_type_model()
    {
    	return $this->belongsTo('Ecjia\App\Goods\Models\GoodsTypeModel', 'goods_type', 'cat_id');
    }

    /**
     * 一对多 关联商品相册集合
     */
    public function goods_gallery_collection()
    {
        return $this->hasMany('Ecjia\App\Goods\Models\GoodsGalleryModel', 'goods_id', 'goods_id');
    }
    
    /**
     * 一对多 关联活动商品集合
     */
    public function goods_activity_collection()
    {
    	return $this->hasMany('Ecjia\App\Goods\Models\GoodsActivityModel', 'goods_id', 'goods_id');
    }

    /**
     * 一对多 关联活动商品集合
     */
    public function favourable_activity_collection()
    {
        return $this->hasMany('Ecjia\App\Goods\Models\FavourableActivityModel', 'act_range_ext', 'goods_id');
    }
    
    /**
     * 一对一
     * 商品平台分类模型信息
     */
    public function category_model()
    {
    	return $this->belongsTo('Ecjia\App\Goods\Models\CategoryModel', 'cat_id', 'cat_id');
    }

    /**
     * 一对一
     * 商品绑定的规格模板模型信息
     */
    public function goods_type_specification_model()
    {
        return $this->belongsTo('Ecjia\App\Goods\Models\GoodsTypeModel', 'specification_id', 'cat_id');
    }
    
    /**
     * 一对一
     * 商品绑定的参数模板模型信息
     */
    public function goods_type_parameter_model()
    {
        return $this->belongsTo('Ecjia\App\Goods\Models\GoodsTypeModel', 'parameter_id', 'cat_id');
    }
    
    /**
     * 一对一
     * 商品关联的品牌模型信息
     */
    public function brand_model()
    {
    	return $this->belongsTo('Ecjia\App\Goods\Models\BrandModel', 'brand_id', 'brand_id');
    }
    
    /**
     * 一对多
     * 商品关联商品集合
     */
    public function link_goods_collection()
    {
    	return $this->hasMany('Ecjia\App\Goods\Models\LinkGoodsModel', 'goods_id', 'goods_id');
    }
    
    /**
     * 将缓存数组添加至创建缓存数组（用于商品列表）
     * @param $cache_key
     * @param int $expiry
     * @return string
     */
    public function create_cache_key_array($cache_key, $expiry = 10080)
    {
        if (empty($cache_key)) {
            return '';
        }

        $cache_key = sprintf('%X', crc32($cache_key));
        $cache_array = RC_Cache::app_cache_get('goods_list_cache_key_array', 'goods');
        if (!in_array($cache_key, $cache_array)) {
            if (empty($cache_array)) {
                $cache_array = array();
            }
            array_push($cache_array, $cache_key);
            RC_Cache::app_cache_set('goods_list_cache_key_array', $cache_array, 'goods', $expiry);
        }
        return $cache_key;
    }

    /*
     * 获取缓存数据
     */
    public function get_cache_item($cache_key)
    {
        return RC_Cache::app_cache_get($cache_key, 'goods');
    }

    /*
     * 设置缓存数据
     */
    public function set_cache_item($cache_key, $item, $expiry = 10080)
    {
        return RC_Cache::app_cache_set($cache_key, $item, 'goods', $expiry);
    }

    /*
     * 释放缓存数据
     */
    public function delete_cache_item($cache_key)
    {
        return RC_Cache::app_cache_delete($cache_key, 'goods');
    }

}