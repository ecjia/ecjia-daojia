<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/12/12
 * Time: 14:04
 */

namespace Ecjia\App\Article\StoreCleanHandlers;

use Ecjia\App\Store\StoreCleanAbstract;
use RC_Uri;
use RC_DB;
use RC_Api;
use ecjia_admin;
use RC_Filesystem;
use RC_Upload;

class StoreArticleClear extends StoreCleanAbstract
{

    /**
     * 代号标识
     * @var string
     */
    protected $code = 'store_article_clear';

    /**
     * 名称
     * @var string
     */
    protected $name = '店铺文章';

    /**
     * 排序
     * @var int
     */
    protected $sort = 11;

    /**
     * 数据描述及输出显示内容
     */
    public function handlePrintData()
    {
        $store_info = RC_Api::api('store', 'store_info', array('store_id' => $this->store_id));
        $url        = RC_Uri::url('article/admin/init', array('publishby' => 'store', 'keywords' => $store_info['merchants_name']));

        $count     = $this->handleCount();
        $text      = sprintf(__('总共有<span class="ecjiafc-red ecjiaf-fs3">%s</span>篇文章', 'article'), $count);
        $text_info = __('查看全部>>>', 'article');

        return <<<HTML
<span class="controls-info w300">{$text}</span>
<span class="controls-info"><a href="{$url}" target="_blank">{$text_info}</a></span>
HTML;
    }

    /**
     * 获取数据统计条数
     *
     * @return mixed
     */
    public function handleCount()
    {
        $db_article = RC_DB::table('article as a')
            ->leftJoin('article_cat as ac', RC_DB::raw('ac.cat_id'), '=', RC_DB::raw('a.cat_id'));

        //不获取系统帮助文章的过滤
        $db_article->where(RC_DB::raw('a.cat_id'), '!=', '0')->where(RC_DB::raw('ac.cat_type'), 'article');

        $count = $db_article->where(RC_DB::raw('a.store_id'), $this->store_id)->count();

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

        $cat_list = RC_DB::table('article_cat')->where('cat_type', 'article')->lists('cat_id');

        $file_list = RC_DB::table('article')->where('store_id', $this->store_id)->whereIn('cat_id', $cat_list)->select('file_url', 'cover_image')->get();
        if (!empty($file_list)) {
            $disk = RC_Filesystem::disk();
            foreach ($file_list as $k => $v) {
                $disk->delete(RC_Upload::upload_path() . $v['file_url']);
                $disk->delete(RC_Upload::upload_path() . $v['cover_image']);
            }
        }

        $result = RC_DB::table('article')->where('store_id', $this->store_id)->whereIn('cat_id', $cat_list)->delete();

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

        $merchants_name = !empty($store_info) ? sprintf(__('店铺名是%s', 'article'), $store_info['merchants_name']) : sprintf(__('店铺ID是%s', 'article'), $this->store_id);

        ecjia_admin::admin_log($merchants_name, 'clean', 'store_article');
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