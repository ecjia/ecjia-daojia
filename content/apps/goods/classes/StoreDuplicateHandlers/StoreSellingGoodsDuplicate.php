<?php

namespace Ecjia\App\Goods\StoreDuplicateHandlers;

use Ecjia\App\Goods\GoodsImage\CopyGoodsImage;
use Ecjia\App\Store\StoreDuplicate\StoreDuplicateAbstract;
use ecjia_admin;
use ecjia_error;
use RC_Api;
use RC_DB;
use RC_Loader;
use RC_Time;
use Royalcms\Component\Database\QueryException;

/**
 * 复制店铺中的在售商品
 *
 * @todo goods_attr 表的图片字段的处理 attr_img_flie attr_img_site attr_gallery_flie
 * 表的图片字段的处理 product_thumb product_img product_original_img product_desc
 *
 * Class StoreSellingGoodsDuplicate
 * @package Ecjia\App\Goods\StoreDuplicateHandlers
 */
class StoreSellingGoodsDuplicate extends StoreDuplicateAbstract
{
    /**
     * 代号标识
     * @var string
     */
    protected $code = 'store_selling_goods_duplicate';

    protected $dependents = [
        'store_goods_merchant_category_duplicate',
    ];

    /**
     * goods 表中的替换数据
     * @var array
     */
    protected $replacement_goods = [];

    /**
     * goods_attr 表中的替换数据
     * @var array
     */
    protected $replacement_goods_attr = [];

    /**
     * products 表中的替换数据
     * @var array
     */
    protected $replacement_products = [];

    /**
     * goods_gallery 表中的替换数据
     * @var array
     */
    protected $replacement_goods_gallery = [];

    /**
     * member_price 表中的替换数据
     * @var array
     */
    protected $replacement_member_price = [];

    /**
     * @var \Ecjia\App\Store\StoreDuplicate\StoreDuplicateProgressData
     */
    protected $progress_data;

    /**
     * merchant_category 表中的替换数据
     * @var array|mixed
     */
    protected $merchant_category_replacement = [];

    /**
     * bonus_type 表中的替换数据
     * @var array|mixed
     */
    protected $store_bonus_replacement = [];

    /**
     * goods_type 表中商品规格的替换数据
     * @var array|mixed
     */
    protected $goods_specification_replacement = [];

    /**
     * goods_type 表中商品参数的替换数据
     * @var array|mixed
     */
    protected $goods_parameter_duplicate_replacement = [];

    /**
     * goods_type 表中商品参数、规格合并后的替换数据
     * @var array|mixed
     */
    protected $goods_type_replacement = [];

    protected $rank_order = 4;

    protected $rank_total = 11;

    protected $sort = 14;

    public function __construct($store_id, $source_store_id, $name = '在售普通商品')
    {
        parent::__construct($store_id, $source_store_id);
        $this->name = __($name, 'goods');
    }

    public function getName()
    {
        return $this->name . sprintf('(%d/%d)', $this->rank_order, $this->rank_total);
    }

    /**
     * 设置过程数据对象
     */
    protected function setProgressData()
    {
        if (empty($this->progress_data)) {
            $this->progress_data = $this->handleDuplicateProgressData();
        }
        return $this;
    }

    /**
     * 获取源店铺数据操作对象
     * @return mixed
     */
    public function getSourceStoreDataHandler()
    {
        return RC_DB::table('goods')->where('store_id', $this->source_store_id)->where('is_on_sale', 1)->where('is_delete', 0)->where(function ($query) {
            $query->whereNull('extension_code')->orWhere('extension_code', '');
        });
    }

    /**
     * 数据描述及输出显示内容
     */
    public function handlePrintData()
    {
        $text = sprintf(__('店铺内总共有<span class="ecjiafc-red ecjiaf-fs3">%s</span>件%s', 'goods'), $this->handleCount(), $this->name);
        return <<<HTML
<span class="controls-info">{$text}</span>
HTML;
    }

    /**
     * 统计数据条数并获取
     *
     * @return mixed
     */
    public function handleCount()
    {
        static $count;
        if (is_null($count)) {
            // 统计数据条数
            try {
                $count = $this->getSourceStoreDataHandler()->count();
            } catch (QueryException $e) {
                ecjia_log_warning($e->getMessage());
            }
        }
        return $count;
    }

    /**
     * 执行复制操作
     *
     * @return mixed
     */
    public function handleDuplicate()
    {
        //检测当前对象是否已复制完成
        if ($this->isCheckFinished()) {
            return true;
        }

        if ($this->isCheckStarting()){
            return new ecjia_error('duplicate_started_error', sprintf(__('%s复制已开始，请耐心等待！', 'store'), $this->getName()));
        }

        //如果当前对象复制前仍存在依赖，则需要先复制依赖对象才能继续复制
        if (!empty($this->dependents)) { //如果设有依赖对象
            //检测依赖
            $items = $this->dependentCheck();
            if (!empty($items)) {
                return new ecjia_error('handle_duplicate_error', __('复制依赖检测失败！', 'store'), $items);
            }
        }

        //标记复制正在进行中
        $this->markStartingDuplicate();

        //执行具体任务
        $result = $this->startDuplicateProcedure();
        if (is_ecjia_error($result)) {
            return $result;
        }

        //标记处理完成
        $this->markDuplicateFinished();

        //记录日志
        $this->handleAdminLog();

        return true;
    }

    /**
     * 店铺复制操作的具体过程
     *
     * 由于该任务比较复杂，考虑到部分表处理失败会导致数据完整性受影响，是否需要事务支持？
     * 如果开启事务的话，将对部分数据进行稍长时间的锁定，怎样合理安排隔离级别？
     *
     * 目前运行代码中尚未涉及事务相关功能，执行过程都属于乐观性操作，日后还需讨论更为严谨的方案
     *
     */
    protected function startDuplicateProcedure()
    {
        //忽略内存大小限制
        ini_set('memory_limit',-1);
        set_time_limit(0);

        //用于存储替换数据的关联关系
        $replacement_data = [];

        RC_Loader::load_app_func('global', 'goods');
        try {
            //初始化过程数据中该复制操作需要用到的依赖数据
            $this->initRelationDataFromProgressData();

            //将数据复制到 goods
            $this->duplicateGoods();
            //存储 goods 相关替换数据
            $replacement_data['goods'] = $this->replacement_goods;

            //取出源店铺 goods_id
            $old_goods_id = array_keys($this->replacement_goods);

            if (!empty($old_goods_id)) {
                //获取商品规格、参数中的 attribute 替换数据
                $replacement_attribute = $this->progress_data->getReplacementDataByCode('store_goods_specification_duplicate.attribute') + $this->progress_data->getReplacementDataByCode('store_goods_parameter_duplicate.attribute');

                //将数据同步到 goods_attr
                $this->duplicateGoodsAttr($old_goods_id, $replacement_attribute);
                // 存储 goods_attr 相关替换数据
                $replacement_data['goods_attr'] = $this->replacement_goods_attr;


                //将数据同步到 products
                $this->duplicateProducts($old_goods_id);
                //存储 products 相关替换数据
                $replacement_data['products'] = $this->replacement_products;
            }

            $this->setReplacementData($this->getCode(), $replacement_data);

            return true;
        } catch (QueryException $e) {
            ecjia_log_warning($e->getMessage());
            return new ecjia_error('duplicate_data_error', $e->getMessage());
        }

    }

    /**
     * 复制 goods 数据
     */
    protected function duplicateGoods()
    {
        $this->getSourceStoreDataHandler()->chunk(50, function ($items) {
            $time = RC_Time::gmtime();

            foreach ($items as $item) {
                $goods_id = $item['goods_id'];
                unset($item['goods_id']);

                //将源店铺ID设为新店铺的ID
                $item['store_id'] = $this->store_id;

                //设置新店铺 merchat_cat_level1_id
                $item['merchat_cat_level1_id'] = array_get($this->merchant_category_replacement, $item['merchat_cat_level1_id'], $item['merchat_cat_level1_id']);

                //设置新店铺 merchat_cat_level2_id
                $item['merchat_cat_level2_id'] = array_get($this->merchant_category_replacement, $item['merchat_cat_level2_id'], $item['merchat_cat_level2_id']);

                //设置新店铺 merchant_cat_id
                $item['merchant_cat_id'] = array_get($this->merchant_category_replacement, $item['merchant_cat_id'], $item['merchant_cat_id']);

                //设置新店铺 bonus_type_id
                $item['bonus_type_id'] = array_get($this->store_bonus_replacement, $item['bonus_type_id'], $item['bonus_type_id']);

                //设置新店铺 goods_type
                $item['goods_type'] = array_get($this->goods_type_replacement, $item['goods_type'], $item['goods_type']);

                //设置新店铺 specification_id
                $item['specification_id'] = array_get($this->goods_specification_replacement, $item['specification_id'], $item['specification_id']);

                //设置新店铺 parameter_id
                $item['parameter_id'] = array_get($this->goods_parameter_duplicate_replacement, $item['parameter_id'], $item['parameter_id']);

                //click_count，商品点击数设为0
                $item['click_count'] = 0;

                //goods_number 商品库存数量设为1000
                $item['click_count'] = 1000;

                //add_time  商品添加时间设为当前时间
                $item['add_time'] = $time;

                //last_update  最近一次更新商品配置的时间设为当前时间
                $item['last_update'] = $time;

                //comments_number 评论设置为0
                $item['comments_number'] = 0;

                //sales_volume 销量设置为0
                $item['sales_volume'] = 0;

                //设置新的goods_desc
                $item['goods_desc'] = $this->copyImageForContent($item['goods_desc']);

                try {
                    //插入数据到新店铺
                    $new_goods_id = RC_DB::table('goods')->insertGetId($item);

                    //存储替换记录
                    $this->replacement_goods[$goods_id] = $new_goods_id;

                    //商品唯一货号需要重新生成
                    $goods_sn = function_exists('generate_goods_sn') ? generate_goods_sn($new_goods_id) : bin2hex(random_bytes(16));

                    //更新图片字段 goods_thumb goods_img original_img 和商品货号
                    list($new_original_path , $new_img_path, $new_thumb_path) = $this->copyGoodsImage($new_goods_id, 0, $item['original_img'] , $item['goods_img'], $item['goods_thumb']);
                    RC_DB::table('goods')->where('goods_id', $new_goods_id)->update([
                        'goods_sn' => $goods_sn,
                        'goods_thumb' => $new_thumb_path,
                        'goods_img' => $new_img_path,
                        'original_img' => $new_original_path
                    ]);
                } catch (QueryException $e) {
                    ecjia_log_warning($e->getMessage());
                }
            }
        });
    }

    /**
     * 复制 goods_attr 数据
     * @param $old_goods_id
     * @param $replacement_attribute
     */
    protected function duplicateGoodsAttr($old_goods_id, $replacement_attribute)
    {
        //将数据同步到 goods_attr
        RC_DB::table('goods_attr')->whereIn('goods_id', $old_goods_id)->chunk(50, function ($items) use ($replacement_attribute) {
            foreach ($items as $item) {
                $goods_attr_id = $item['goods_attr_id'];
                unset($item['goods_attr_id']);

                //通过 goods 替换数据设置新店铺的 goods_id
                $item['goods_id'] = array_get($this->replacement_goods, $item['goods_id'], $item['goods_id']);

                //通过 attribute 替换数据设置新店铺 attr_id
                $item['attr_id'] = array_get($replacement_attribute, $item['attr_id'], $item['attr_id']);

                //@todo 图片字段的处理 attr_img_flie attr_img_site attr_gallery_flie
                //$item['attr_img_flie'] = $this->copyImage($item['attr_img_flie']);
                //$item['attr_img_site'] = $this->copyImage($item['attr_img_site']);
                //$item['attr_gallery_flie'] = $this->copyImage($item['attr_gallery_flie']);

                try {
                    //将数据插入到新店铺
                    $new_goods_attr_id = RC_DB::table('goods_attr')->insertGetId($item);

                    //存储替换记录
                    $this->replacement_goods_attr[$goods_attr_id] = $new_goods_attr_id;
                } catch (QueryException $e) {
                    ecjia_log_warning($e->getMessage());
                }
            }
        });
    }

    /**
     * 复制 products 数据
     * @param $old_goods_id
     */
    protected function duplicateProducts($old_goods_id)
    {
        RC_DB::table('products')->whereIn('goods_id', $old_goods_id)->chunk(50, function ($items) {
            foreach ($items as $item) {
                $product_id = $item['product_id'];
                unset($item['product_id']);

                //通过 goods 替换数据设置新店铺的 goods_id
                $item['goods_id'] = array_get($this->replacement_goods, $item['goods_id'], $item['goods_id']);

                //新建当前item用于存储新店铺商品属性的数组
                $new_goods_attr = [];
                foreach (explode('|', $item['goods_attr']) as $goods_attr_id) {
                    //通过 goods_attr 将新的goods_attr_id插入到新商品属性数组，在此之前检查一下该id是否存在可替换的值
                    isset($this->replacement_goods_attr[$goods_attr_id]) && $new_goods_attr[] = $this->replacement_goods_attr[$goods_attr_id];
                }

                //若新商品属性数组不为空，用其设置新店铺的 goods_attr
                if (!empty($new_goods_attr)) {
                    $item['goods_attr'] = implode('|', $new_goods_attr);
                }

                //设置唯一产品货号 product_sn，通过相关代码和数据库内容，暂未发现有何规律或规则，也无货号唯一约束，该值暂时无法确认，先生成其他唯一码用于测试
                $item['product_sn'] = $goods_sn = function_exists('generate_goods_sn') ? generate_goods_sn($item['goods_id']) : bin2hex(random_bytes(16));

                //图片字段的处理 product_desc

                $item['product_desc'] = $this->copyImageForContent($item['product_desc']);

                try {
                    //将数据插入到新店铺
                    $new_product_id = RC_DB::table('products')->insertGetId($item);

                    //建立替换数据的关联关系
                    $this->replacement_products[$product_id] = $new_product_id;

                    list($product_original_img, $product_img, $product_thumb) = $this->copyProductImage(
                        $item['goods_id'],
                        $new_product_id,
                        $item['product_original_img'],
                        $item['product_img'],
                        $item['product_thumb']
                    );

                    //更新图片字段 product_thumb product_img product_original_img
                    RC_DB::table('products')->where('product_id', $new_product_id)->update([
                        'product_thumb' => $product_thumb,
                        'product_img' => $product_img,
                        'product_original_img' => $product_original_img
                    ]);
                } catch (QueryException $e) {
                    ecjia_log_warning($e->getMessage());
                }
            }
        });
    }

    /**
     * 复制单张图片
     *
     * @param $path
     *
     * @return []
     */
    private function copyGoodsImage($goods_id, $product_id, $original_path, $img_path, $thumb_path)
    {
        $copy = new CopyGoodsImage($goods_id, $product_id);

        list($new_original_path, $new_img_path, $new_thumb_path) = $copy->copyGoodsImage($original_path, $img_path, $thumb_path);

        return [$new_original_path, $new_img_path, $new_thumb_path];
    }

    private function copyProductImage($goods_id, $product_id, $original_path, $img_path, $thumb_path)
    {
        $copy = new CopyGoodsImage($goods_id, $product_id);

        list($new_original_path, $new_img_path, $new_thumb_path) = $copy->copyProductImage($original_path, $img_path, $thumb_path);

        return [$new_original_path, $new_img_path, $new_thumb_path];
    }

    /**
     * 复制缩编器内容中的图片
     *
     * @param $content
     *
     * @return string
     */
    protected function copyImageForContent($content)
    {
        $new_content = CopyGoodsImage::copyDescriptionContentImages($content);
        
        return $new_content;
    }

    /**
     * 返回操作日志编写
     *
     * @return mixed
     */
    public function handleAdminLog()
    {
        static $store_merchant_name, $source_store_merchant_name;

        if (empty($store_merchant_name)) {
            $store_info = RC_Api::api('store', 'store_info', ['store_id' => $this->store_id]);
            $store_merchant_name = array_get(empty($store_info) ? [] : $store_info, 'merchants_name');
        }

        if (empty($source_store_merchant_name)) {
            $source_store_info = RC_Api::api('store', 'store_info', ['store_id' => $this->source_store_id]);
            $source_store_merchant_name = array_get(empty($source_store_info) ? [] : $source_store_info, 'merchants_name');
        }

        \Ecjia\App\Store\Helper::assign_adminlog_content();
        $content = sprintf(__('将【%s】店铺所有在售普通商品复制到【%s】店铺中', 'goods'), $source_store_merchant_name, $store_merchant_name);
        ecjia_admin::admin_log($content, 'duplicate', 'store_goods');
    }

    /**
     * 初始化过程数据中的关联数据，赋给对应属性
     * @param bool $debug
     */
    protected function initRelationDataFromProgressData($debug = FALSE)
    {
        //设置过程数据对象
        $this->setProgressData();

        //获取商家商品分类的替换数据
        $this->merchant_category_replacement = $this->progress_data->getReplacementDataByCode('store_goods_merchant_category_duplicate');

        //获取店铺红包的替换数据 goods表中的bonus_type_id是否在商品入表的时候就要设置？还是插入以后，有需要再更新设置
        $this->store_bonus_replacement = $this->progress_data->getReplacementDataByCode('store_bonus_duplicate');

        //获取商品规格中商品类型的替换数据
        $this->goods_specification_replacement = $this->progress_data->getReplacementDataByCode('store_goods_specification_duplicate.goods_type');

        //获取商品参数中商品类型的替换数据
        $this->goods_parameter_duplicate_replacement = $this->progress_data->getReplacementDataByCode('store_goods_parameter_duplicate.goods_type');

        //获取合并商品参数、规格中的 goods_type 替换数据
        $this->goods_type_replacement = $this->goods_specification_replacement + $this->goods_parameter_duplicate_replacement;

        if ($debug) {
            $this->showValueOfAttrs();
        }
    }

    protected function showValueOfAttrs($attr_name = null)
    {
        if (is_string($attr_name)) {
            $attr_name = explode(',', $attr_name);
        }
        if (!is_array($attr_name)) {
            $attr_name = [
                //'progress_data',
                'merchant_category_replacement',
                'store_bonus_replacement',
                'goods_specification_replacement',
                'goods_parameter_duplicate_replacement',
                'goods_type_replacement',
            ];
        }
        $tmp = [];
        foreach ($attr_name as $name) {
            $tmp[$name] = $this->{$name};
        }
        dd($tmp);
    }

}