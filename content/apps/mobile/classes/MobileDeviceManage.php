<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-02-26
 * Time: 09:23
 */

namespace Ecjia\App\Mobile;


use Ecjia\App\Mobile\Models\MobileDeviceModel;
use ecjia_page;
use mysql_xdevapi\Collection;

class MobileDeviceManage
{

    protected $model;

    protected $platform_clients;

    protected $current_client;

    protected $take = 20;

    protected $page = 1;

    public function __construct($platform_clients, $current_client)
    {
        $this->platform_clients = collect($platform_clients);
        $this->current_client = $current_client;

        $this->model = new MobileDeviceModel();

    }

    /**
     * 获取所有设备
     * @param int $page
     * @return array
     */
    public function getAllDevices($page = 1, $result_callback = null, $query_callback = null)
    {

        if ($this->current_client['device_client'] == 'all') {

            $clients = $this->platform_clients->filter(function($item) {
                return $item['device_code'] > 0;
            })->pluck('device_code')->all();

            $count = $this->model
                ->where('in_status', 0)
                ->whereIn('device_code', $clients)->count();

            $page_instance = new ecjia_page($count, $this->take, $page);

            $data = $this->model
                ->where('in_status', 0)
                ->whereIn('device_code', $clients)
                ->where(function ($query) use ($query_callback) {
                    if (is_callable($query_callback)) {
                        return $query_callback($query);
                    }
                    return $query;
                })
                ->take($this->take)
                ->skip($page_instance->start_id - 1)
                ->orderBy('id', 'desc')
                ->get();

        }
        elseif ($this->current_client['device_client'] == 'recyclebin') {

            $clients = $this->platform_clients->filter(function($item) {
                return $item['device_code'] > 0;
            })->pluck('device_code')->all();

            $count = $this->model
                ->where('in_status', 1)
                ->whereIn('device_code', $clients)->count();

            $page_instance = new ecjia_page($count, $this->take, '', $page);

            $data = $this->model
                ->where('in_status', 1)
                ->whereIn('device_code', $clients)
                ->where(function ($query) use ($query_callback) {
                    if (is_callable($query_callback)) {
                        return $query_callback($query);
                    }
                    return $query;
                })
                ->take($this->take)
                ->skip($page_instance->start_id - 1)
                ->orderBy('id', 'desc')
                ->get();
        }
        else {

            $count = $this->model
                ->where('in_status', 0)
                ->where('device_code', $this->current_client['device_code'])->count();

            $page_instance = new ecjia_page($count, $this->take, $page);

            $data = $this->model
                ->where('in_status', 0)
                ->where('device_code', $this->current_client['device_code'])
                ->where(function ($query) use ($query_callback) {
                    if (is_callable($query_callback)) {
                        return $query_callback($query);
                    }
                    return $query;
                })
                ->take($this->take)
                ->skip($page_instance->start_id - 1)
                ->orderBy('id', 'desc')
                ->get();

        }

        /**
         * 处理数据
         */
        if (is_callable($result_callback)) {
            $data = $data->map(function ($model) use ($result_callback) {
                return $result_callback($model);
            });
        }

        return array($data, $page_instance);
    }

    /**
     * 获取各项分别统计
     * @return Collection
     */
    public function getAllDevicesCount()
    {
        $clients = $this->platform_clients->filter(function($item) {
            return $item['device_code'] > 0;
        })->pluck('device_code');

        $selects = $this->platform_clients->map(function($item) use ($clients) {

            if ($item['device_client'] == 'all') {

                $clients = $clients->map(function ($client) {
                    return 'device_code = ' . $client;
                })->all();
                $client_sql = implode(' or ', $clients);

                return "SUM(IF(({$client_sql}) and in_status = 0,1,0)) AS all_count";
            }
            elseif ($item['device_client'] == 'recyclebin') {
                $clients = $clients->map(function ($client) {
                    return 'device_code = ' . $client;
                })->all();
                $client_sql = implode(' or ', $clients);

                return "SUM(IF(({$client_sql}) and in_status = 1,1,0)) AS recyclebin_count";
            }
            else {
                return "SUM(IF(device_code = {$item['device_code']} and in_status = 0,1,0)) AS {$item['device_client']}_count";
            }

        })->all();

        $select = implode(', ', $selects);

        $count = $this->model->select(\RC_DB::raw($select))->first();

        return $count;
    }


    public function getDeviceClient($client)
    {


    }




}