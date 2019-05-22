<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/12/12
 * Time: 14:04
 */

namespace Ecjia\App\Goods\StoreDuplicateHandlers;

use Ecjia\App\Goods\Models\MerchantCategoryModel;
use Ecjia\App\Store\StoreDuplicate\StoreDuplicateAbstract;
use RC_DB;
use RC_Api;
use ecjia_admin;
use ecjia_error;
use Royalcms\Component\Support\Collection;

/**
 * 复制店铺中的商品分类（无图片字段）
 *
 * Class StoreGoodsCategoryDuplicate
 * @package Ecjia\App\Goods\StoreDuplicateHandlers
 */
class StoreGoodsMerchantCategoryDuplicate extends StoreDuplicateAbstract
{
    /**
     * 代号标识
     * @var string
     */
    protected $code = 'store_goods_merchant_category_duplicate';

    /**
     * 排序
     * @var int
     */
    protected $sort = 13;

    protected $dependents = [
        'store_goods_parameter_duplicate',
        'store_goods_specification_duplicate',
    ];

    /**
     * temp merchant category id
     * @var array
     */
    private $merchant_category_replacement = [];

    public function __construct($store_id, $source_store_id)
    {
        $this->name = __('店铺商品分类', 'goods');

        parent::__construct($store_id, $source_store_id);
    }

    /**
     * 获取源店铺数据操作对象
     */
    public function getSourceStoreDataHandler()
    {
        return RC_DB::table('merchants_category')->where('store_id', $this->source_store_id);
    }

    /**
     * 数据描述及输出显示内容
     */
    public function handlePrintData()
    {
        $count = $this->handleCount();
        $text = sprintf(__('店铺内总共有<span class="ecjiafc-red ecjiaf-fs3">%s</span>大分类', 'goods'), $count);

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
        //如果已经统计过，直接返回统计过的条数
        if ($this->count) {
            return $this->count;
        }

        // 统计数据条数
        $this->count = $this->getSourceStoreDataHandler()->count();
        return $this->count;
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

        //如果当前对象复制前仍存在依赖，则需要先复制依赖对象才能继续复制
        if (!empty($this->dependents)) { //如果设有依赖对象
            //检测依赖
            $items = $this->dependentCheck();
            if (!empty($items)) {
                return new ecjia_error('handle_duplicate_error', __('复制依赖检测失败！', 'store'), $items);
            }
        }

        //执行具体任务
        $this->startDuplicateProcedure();

        //标记处理完成
        $this->markDuplicateFinished();

        //记录日志
        $this->handleAdminLog();

        return true;
    }

    /**
     * 店铺复制操作的具体过程
     */
    protected function startDuplicateProcedure()
    {
        $progress_data = (new \Ecjia\App\Store\StoreDuplicate\ProgressDataStorage($this->store_id))->getDuplicateProgressData();

        $specification_replacement = $progress_data->getReplacementDataByCode('store_goods_specification_duplicate.goods_type');
        $parameter_replacement = $progress_data->getReplacementDataByCode('store_goods_parameter_duplicate.goods_type');


        $all_categories = MerchantCategoryModel::where('store_id', $this->source_store_id)->get();

        $top_categories = $all_categories->where('parent_id', 0);

        $this->recursiveCategroy($top_categories, $all_categories, $specification_replacement, $parameter_replacement);

        //@todo cat_image 未复制


//        $merchant_category_replacement = [];
//        $this->source_store_data_handler->orderBy('parent_id', 'asc')->chunk(50, function ($items) use (& $merchant_category_replacement, $specification_replacement, $parameter_replacement) {
//
//            //构造可用于复制的数据
//            //$this->buildDuplicateData($items);
//
//            foreach ($items as &$item) {
//                $merchant_cat_id = $item['cat_id'];
//                unset($item['cat_id']);
//
//                //将源店铺ID设为新店铺的ID
//                $item['store_id'] = $this->store_id;
//
//                //设置新店铺规则ID
//                if (isset($specification_replacement[$item['specification_id']])) {
//                    $item['specification_id'] = $specification_replacement[$item['specification_id']];
//                }
//
//                //设置新店铺参数ID
//                if (isset($parameter_replacement[$item['parameter_id']])) {
//                    $item['parameter_id'] = $parameter_replacement[$item['parameter_id']];
//                }
//
//                //插入数据到新店铺并获取主键ID
//                //$new_merchant_cat_id = $merchant_cat_id + 1;
//                $new_merchant_cat_id = RC_DB::table('merchants_category')->insertGetId($item);
//                $merchant_category_replacement[$merchant_cat_id] = $new_merchant_cat_id;
//
//                //如果该数据不是顶级分类
//                if ((int)$item['parent_id'] !== 0 && isset($merchant_category_replacement[$item['parent_id']])) {
//
//                    //用parent_id找到替换ID，将新插入的数据执行更新，完成parent_id替换
//                    RC_DB::table('merchants_category')
//                        ->where('cat_id', $new_merchant_cat_id)
//                        ->update(['parent_id' => $merchant_category_replacement[$item['parent_id']]]);
//                }
//
//
//                //图片数据的处理
//
//            }
//
//        });

        $this->setReplacementData($this->getCode(), $this->merchant_category_replacement);
    }


    /**
     * 递归分类数据
     * @param $categories \Royalcms\Component\Support\Collection
     * @param $collection \Royalcms\Component\Support\Collection
     * @param $goods_num \Royalcms\Component\Support\Collection
     * @return \Royalcms\Component\Support\Collection
     */
    protected function recursiveCategroy($categories, $collection, $specification_replacement, $parameter_replacement)
    {
        if (empty($categories)) {
            return null;
        }

        $categories = $categories->map(function ($model) use ($collection, $specification_replacement, $parameter_replacement) {


            $new_model = $model->replicate();

            $new_model->store_id = $this->store_id;
            //设置新店铺规格ID
            $new_model->specification_id = array_get($specification_replacement, $new_model->specification_id, $new_model->specification_id);
            //设置新店铺参数ID
            $new_model->parameter_id = array_get($parameter_replacement, $new_model->parameter_id, $new_model->parameter_id);

            //取出原parent_id数据
            $new_model->parent_id = array_get($this->merchant_category_replacement, $model->parent_id, $model->parent_id);

            $new_model->save();

            $this->merchant_category_replacement[$model->cat_id] = $new_model->cat_id;

            $model->childrens = $collection->where('parent_id', $model->cat_id);

            if ($model->childrens instanceof Collection) {

                $model->childrens = $this->recursiveCategroy($model->childrens, $collection, $specification_replacement, $parameter_replacement);

            }

            return $model;
        });

        return $categories;
    }


    protected function buildDuplicateData(&$items)
    {
        foreach ($items as &$item) {

            unset($item['cat_id']);

            //将源店铺ID设为新店铺的ID
            $item['store_id'] = $this->store_id;


        }


        //解决外键带来的问题数据


    }

    /**
     * 返回操作日志编写
     *
     * @return mixed
     */
    public function handleAdminLog()
    {
        \Ecjia\App\Store\Helper::assign_adminlog_content();

        $store_info = RC_Api::api('store', 'store_info', array('store_id' => $this->store_id));

        $merchants_name = !empty($store_info) ? sprintf(__('店铺名是%s', 'goods'), $store_info['merchants_name']) : sprintf(__('店铺ID是%s', 'goods'), $this->store_id);

        ecjia_admin::admin_log($merchants_name, 'duplicate', 'store_goods');
    }


}