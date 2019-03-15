<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/12/12
 * Time: 14:04
 */

namespace Ecjia\App\Store\StoreCleanHandlers;

use Ecjia\App\Store\StoreCleanAbstract;
use RC_Uri;
use RC_DB;
use RC_Api;
use ecjia_admin;
use RC_Filesystem;
use RC_Upload;

class StorePreauditClear extends StoreCleanAbstract
{

    /**
     * 代号标识
     * @var string
     */
    protected $code = 'store_preaudit_clear';

    /**
     * 名称
     * @var string
     */
    protected $name = '店铺申请资料修改';

    /**
     * 排序
     * @var int
     */
    protected $sort = 38;

    /**
     * 数据描述及输出显示内容
     */
    public function handlePrintData()
    {
        $text = __('将店铺申请资料修改记录全部删除', 'store');

        return <<<HTML
<span class="controls-info">{$text}</span>
HTML;
    }

    /**
     * 获取数据统计条数
     *
     * @return mixed
     */
    public function handleCount()
    {
        $count = RC_DB::table('store_preaudit')->where('store_id', $this->store_id)->count();

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

        $file_list = RC_DB::table('store_preaudit')->where('store_id', $this->store_id)->select('personhand_identity_pic', 'identity_pic_front', 'identity_pic_back', 'business_licence_pic')->get();
        if (!empty($file_list)) {
            $disk = RC_Filesystem::disk();
            foreach ($file_list as $k => $v) {
                $disk->delete(RC_Upload::upload_path() . $v['personhand_identity_pic']);
                $disk->delete(RC_Upload::upload_path() . $v['identity_pic_front']);
                $disk->delete(RC_Upload::upload_path() . $v['identity_pic_back']);
                $disk->delete(RC_Upload::upload_path() . $v['business_licence_pic']);
            }
        }

        $result = RC_DB::table('store_preaudit')->where('store_id', $this->store_id)->delete();

        if ($result) {
            $this->handleAdminLog();
        }

        return true;
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

        $merchants_name = !empty($store_info) ? sprintf(__('店铺名是%s', 'store'), $store_info['merchants_name']) : sprintf(__('店铺ID是%s', 'store'), $this->store_id);

        ecjia_admin::admin_log($merchants_name, 'clean', 'store_preaudit');
    }

    /**
     * 是否允许删除
     *
     * @return mixed
     */
    public function handleCanRemove()
    {
        return !empty($this->handleCount()) ? true : false;
    }


}