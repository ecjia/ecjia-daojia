<?php


namespace Ecjia\System\Hookers;

use ecjia;
use ecjia_utility;
use RC_Config;
use RC_DB;
use RC_ENV;
use RC_Model;
use RC_Timer;

/**
 * 获得查询时间和次数，内存占用
 * Class EcjiaEchoQueryInfoAction
 * @package Ecjia\System\Hookers
 */
class EcjiaEchoQueryInfoAction
{

    /**
     * Handle the event.
     *
     */
    public function handle()
    {

        if (! ecjia::is_debug_display()) {
            return false;
        }

        $memory_info = $gzip_enabled = '';
        $queries = RC_DB::getQueryLog();

        $sql_count = RC_Model::sql_count() + count($queries);

        /* 数据库查询情况 */
        $timer = RC_Timer::formatTimer(RC_Timer::getLoadTime());
        $query_info = sprintf(__('共执行 %d 个查询，程序运行用时 %s 秒'), $sql_count, $timer);

        /* 内存占用情况 */
        if (function_exists('memory_get_usage')) {
            $memory_info = sprintf(__('，内存占用 %0.3f MB'), memory_get_usage() / 1048576);
        }

        /* 是否启用了 gzip */
        $gzip_enabled = ecjia_utility::gzip_enabled(RC_ENV::gzip_enabled()) ? __('，Gzip 已启用') : __('，Gzip 已禁用');

        echo '<div class="main_content_bottom">' . rc_user_crlf();
        echo '<hr />' . rc_user_crlf();
        echo "{$query_info}{$gzip_enabled}{$memory_info} <br />";

        if (config('system.debug_display_query') === true && count($queries) > 0) {
            echo "<br />";
            echo "SQL查询清单 <br />";

            foreach ($queries as $key => $query) {
                ++$key;
                echo '<strong>' . $key . '</strong>. ' . vsprintf(str_replace('?', '%s', $query["query"]), $query['bindings']). " (time: " . $query['time'] ."ms)" . "<br />";
            }

            foreach (RC_Model::sql_all() as $sql) {
                echo $sql . "<br />";
            }
        }

        if (RC_Config::get('system.debug_display_included') === true) {
            /* 加载文件顺序 */
            $load_files = get_included_files();

            echo "<br />";
            echo "加载文件列表 <br />";
            foreach ($load_files as $key => $file) {
                echo $key . " " . $file . "<br />";
            }
        }

        echo '</div>' . rc_user_crlf();

    }

}