<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-02-19
 * Time: 10:00
 */

namespace Ecjia\App\Mobile;


use Ecjia\App\Mobile\Contracts\ApplicationOptionInterface;
use Ecjia\App\Mobile\Models\MobileManageModel;
use Ecjia\App\Mobile\Models\MobileOptionModel;
use Ecjia\App\Mobile\Options\OptionTypeSerialize;
use Exception;
use Royalcms\Component\Database\Eloquent\Collection;

class ApplicationClientOption implements ApplicationOptionInterface
{

    protected $client;

    protected $device;

    /**
     * ApplicationClientOption constructor.
     * @param ApplicationClient $client
     */
    public function __construct(ApplicationClient $client)
    {
        $this->client = $client;
    }


    /**
     * 获取所有选项
     * @return array
     */
    public function getOptions()
    {
        $model = new MobileManageModel();

        $data = $model->platform($this->client->getPlatformCode())->app($this->client->getDeviceCode())->enabled()->first();

        if ($data) {
            $data = $data->options;
            $data = $this->processOptionValue($data);

            return $data;
        }

        return null;
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
                $values = unserialize($item->option_value);
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
     * @throws Exception
     * @return mixed
     */
    public function saveOption($key, $value, $hander = null)
    {
        if (is_null($hander)) {
            $hander = new OptionTypeSerialize();
        }

        $this->device = $this->client->getMobileDevice();
        if (empty($this->device)) {
            throw new Exception('当前设置未激活，请去设备管理中激活设备！');
        }

        $model = MobileOptionModel::where('platform', $this->client->getPlatformCode())
            ->where('app_id', $this->device['app_id'])->where('option_name', $key)->first();

        if (empty($model)) {
            $model = new MobileOptionModel();
            $model->platform = $this->client->getPlatformCode();
            $model->app_id = $this->device['app_id'];
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
        return MobileOptionModel::where('platform', $this->client->getPlatformCode())
            ->where('app_id', $this->client->getDeviceCode())
            ->where('option_name', $key)
            ->delete();
    }

}