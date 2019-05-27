<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-05-15
 * Time: 18:50
 */

namespace Ecjia\App\Store\StoreDuplicate;


use Ecjia\App\Store\Models\MerchantConfigModel;

class ProgressDataStorage
{

    protected $store_id;

    protected $duplicate_progress_data;

    const STORAGE_CODE = 'duplicate_progress_data';

    static $instance;

    public function __construct($store_id, StoreDuplicateProgressData $data = NULL)
    {
        $this->store_id = $store_id;

        $this->duplicate_progress_data = $data;
    }


    public function save()
    {
        $model = MerchantConfigModel::where('store_id', $this->store_id)->where('code', self::STORAGE_CODE)->first();

        if (!empty($model)) {
            $model->value = serialize($this->duplicate_progress_data->toArray());
            $model->save();

        } else {

            $data = [
                'store_id' => $this->store_id,
                'code' => self::STORAGE_CODE,
                'value' => serialize($this->duplicate_progress_data->toArray()),
            ];

            $model = MerchantConfigModel::create($data);

        }

        return $model;
    }


    public function getDuplicateProgressData()
    {
        if (is_null($this->duplicate_progress_data)) {
            $model = MerchantConfigModel::where('store_id', $this->store_id)->where('code', self::STORAGE_CODE)->first();

            if (!empty($model) && $model->value) {
                $data = unserialize($model->value);
                if (is_array($data)) {
                    $this->duplicate_progress_data = StoreDuplicateProgressData::createStoreDuplicateProgressData($data);
                } else {
                    $this->duplicate_progress_data = StoreDuplicateProgressData::createStoreDuplicateProgressData();
                }
            } else {
                $this->duplicate_progress_data = StoreDuplicateProgressData::createStoreDuplicateProgressData();
            }

        }

        return $this->duplicate_progress_data;
    }

    public static function makeStaticInstance($store_id)
    {
        if (is_null(self::$instance)) {
            self::$instance = new static($store_id);
        }

        return self::$instance;
    }

}