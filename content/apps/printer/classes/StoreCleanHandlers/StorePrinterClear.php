<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/12/12
 * Time: 14:04
 */

namespace Ecjia\App\Printer\StoreCleanHandlers;

use Ecjia\App\Store\StoreCleanAbstract;
use RC_Uri;
use RC_DB;
use RC_Api;
use ecjia_admin;
use RC_Filesystem;
use RC_Upload;

class StorePrinterClear extends StoreCleanAbstract
{

    /**
     * 代号标识
     * @var string
     */
    protected $code = 'store_printer_clear';

    /**
     * 名称
     * @var string
     */
    protected $name = '小票打印机';

    /**
     * 排序
     * @var int
     */
    protected $sort = 30;

    /**
     * 数据描述及输出显示内容
     */
    public function handlePrintData()
    {
        $text = __('店铺内添加的所有小票机全部删除', 'printer');

        return <<<HTML
<span class="controls-info w400">{$text}</span>
HTML;
    }

    /**
     * 获取数据统计条数
     *
     * @return mixed
     */
    public function handleCount()
    {
        $count = RC_DB::table('printer_machine')->where('store_id', $this->store_id)->count();

        return $count;
    }


    /**
     * 执行清除操作
     *
     * @return mixed
     */
    public function handleClean()
    {
        $count = $this->handleCount();
        if (empty($count)) {
            return true;
        }

        $file_list = RC_DB::table('printer_machine')->where('store_id', $this->store_id)->lists('machine_logo');
        if (!empty($file_list)) {
            $disk = RC_Filesystem::disk();
            foreach ($file_list as $k => $v) {
                $disk->delete(RC_Upload::upload_path() . $v);
            }
        }

        $result = RC_DB::table('printer_machine')->where('store_id', $this->store_id)->delete();

        if ($result) {
            $this->handleAdminLog();
        }

        return $result;
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

        $merchants_name = !empty($store_info) ? sprintf(__('店铺名是%s', 'printer'), $store_info['merchants_name']) : sprintf(__('店铺ID是%s', 'printer'), $this->store_id);

        ecjia_admin::admin_log($merchants_name, 'clean', 'store_printer');
    }

    /**
     * 是否允许删除
     *
     * @return mixed
     */
    public function handleCanRemove()
    {
        return $this->handleCount() != 0 ? true : false;
    }


}