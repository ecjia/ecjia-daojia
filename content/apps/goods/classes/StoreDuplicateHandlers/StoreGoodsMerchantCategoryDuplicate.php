<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/12/12
 * Time: 14:04
 */

namespace Ecjia\App\Goods\StoreDuplicateHandlers;

use Ecjia\App\Goods\Models\MerchantCategoryModel;
use Ecjia\App\Store\StoreDuplicate\StoreCopyImage;
use Ecjia\App\Store\StoreDuplicate\StoreDuplicateAbstract;
use RC_DB;
use RC_Api;
use ecjia_admin;
use ecjia_error;
use Royalcms\Component\Database\QueryException;
use Royalcms\Component\Support\Collection;

/**
 * 复制店铺中的商品分类（有图片字段）
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

    protected $dependents = [
        'store_goods_parameter_duplicate',
        'store_goods_specification_duplicate',
    ];

    /**
     * temp merchant category id
     * @var array
     */
    private $merchant_category_replacement = [];

    protected $rank_order = 3;

    protected $rank_total = 11;

    protected $sort = 13;

    public function __construct($store_id, $source_store_id)
    {
        parent::__construct($store_id, $source_store_id);
        $this->name = __('店铺商品分类', 'goods');
    }

    public function getName()
    {
        return $this->name . sprintf('(%d/%d)', $this->rank_order, $this->rank_total);
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
        $text = sprintf(__('店铺内总共有<span class="ecjiafc-red ecjiaf-fs3">%s</span>大分类', 'goods'), $this->handleCount());

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
     */
    protected function startDuplicateProcedure()
    {
        $progress_data = $this->handleDuplicateProgressData();

        $specification_replacement = $progress_data->getReplacementDataByCode('store_goods_specification_duplicate.goods_type');
        $parameter_replacement = $progress_data->getReplacementDataByCode('store_goods_parameter_duplicate.goods_type');

        $all_categories = MerchantCategoryModel::where('store_id', $this->source_store_id)->get();

        $top_categories = $all_categories->where('parent_id', 0);

        $this->recursiveCategroy($top_categories, $all_categories, $specification_replacement, $parameter_replacement);

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

            //设置新店铺 cat_image
            $new_model->cat_image = $this->copyImage($new_model->cat_image);

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

    /**
     * @param $path
     * @return bool|string
     */
    protected function copyImage($path)
    {
        /**
         * 数据样式：
         * merchant/62/data/category/1497203993901325255.png
         */
        $path = (new StoreCopyImage($this->store_id, $this->source_store_id))->copyMerchantImage($path);

        return $path;
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
        $content = sprintf(__('将【%s】店铺所有的店铺商品分类复制到【%s】店铺中', 'goods'), $source_store_merchant_name, $store_merchant_name);
        ecjia_admin::admin_log($content, 'duplicate', 'store_goods');
    }

}