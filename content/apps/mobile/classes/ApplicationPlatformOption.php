<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-02-19
 * Time: 10:00
 */

namespace Ecjia\App\Mobile;


use Ecjia\App\Mobile\Contracts\ApplicationOptionInterface;
use Ecjia\App\Mobile\Contracts\OptionStorageInterface;
use Ecjia\App\Mobile\Models\MobileOptionModel;
use Ecjia\App\Mobile\Options\OptionTypeSerialize;
use Royalcms\Component\Database\Eloquent\Collection;

class ApplicationPlatformOption implements ApplicationOptionInterface, OptionStorageInterface
{

    protected $platform;

    public function __construct(ApplicationPlatform $platform)
    {
        $this->platform = $platform;
    }


    /**
     * 获取所有选项
     * @return array
     */
    public function getOptions()
    {
        $model = new MobileOptionModel();

        $data = $model->platform($this->platform->getCode())->appid(0)->get();

        if ($data) {
            $data = $this->processOptionValue($data);
        }

        return $data;
    }

    /**
     * 获取单个选项值
     * @param $key
     * @param null $default
     * @return mixed
     */
    public function getOption($key, $default = null)
    {
        $options = $this->getOptions();

        return array_get($options, $key, $default);
    }

    /**
     *
     * @return array
     */
    protected function processOptionValue(Collection $data)
    {
        $result = $data->mapWithKeys(function ($item) {

            if ($item->option_type == 'serialize') {
                $hander = new OptionTypeSerialize();
                $values = $hander->decodeOptionVaule($item->option_value);
            } else {
                $values = $item->option_value;
            }

            return array($item->option_name => $values);
        })->all();

        return $result;
    }


    /**
     * 保存选项值
     * @param $key
     * @param $value
     * @return mixed
     */
    public function saveOption($key, $value, $hander = null)
    {
        if (is_null($hander)) {
            $hander = new OptionTypeSerialize();
        }

        $model = MobileOptionModel::where('platform', $this->platform->getCode())
            ->where('app_id', 0)->where('option_name', $key)->first();

        if (empty($model)) {
            $model = new MobileOptionModel();
            $model->platform = $this->platform->getCode();
            $model->app_id = 0;
            $model->option_type = $hander->getOptionType();
            $model->option_name = $key;
            $model->option_value = $hander->encodeOptionVaule($value);

            return $model->save();
        }

        //修改
        $model->option_value = $hander->encodeOptionVaule($value);
        return $model->save();
    }


    /**
     * 删除选项值
     * @param $key
     * @return mixed
     */
    public function deleteOption($key)
    {
        return MobileOptionModel::where('platform', $this->platform->getCode())
            ->where('app_id', 0)
            ->where('option_name', $key)
            ->delete();
    }


}