<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-04-30
 * Time: 10:30
 */

namespace Ecjia\App\Goods\DataExport;

use Royalcms\Component\DataExport\Contracts\ExportsCustomizeData;
use Royalcms\Component\DataExport\CustomizeDataSelection;
use Royalcms\Component\Support\Collection;
//use Royalcms\Component\Support\Str;

class GoodsCollectionExport implements ExportsCustomizeData
{

    protected $collection;

    public function __construct(Collection $collection)
    {
        $this->collection = $collection;

    }

    /**
     * @param \Royalcms\Component\DataExport\CustomizeDataSelection $customizeDataSelection
     * @return void
     */
    public function selectCustomizeData(CustomizeDataSelection $customizeDataSelection)
    {

        $result = $this->collection->map(function($model) use ($customizeDataSelection) {

            return (new GoodsExport($model))->selectCustomizeData($customizeDataSelection);

        });

        ecjia_log_info('export_goods_collection', $result, 'data-exprot');
//        dd($result);
    }

    /**
     * @return string
     */
    public function customizeDataExportName()
    {
//        $name = Str::slug($this->goods_sn);
        $name = 'goods_collection';
        return "export-data-{$name}.zip";
    }

    public function getKey()
    {
//        $name = Str::slug($this->goods_sn);
        $name = 'goods_collection';

        return $name;
    }

}