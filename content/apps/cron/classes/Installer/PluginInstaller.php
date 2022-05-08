<?php

namespace Ecjia\App\Cron\Installer;

use DateTime;
use Ecjia\Component\Plugin\Storages\CronPluginStorage;
use ecjia_plugin;
use RC_DB;
use RC_Plugin;
use RC_Time;

class PluginInstaller extends \Ecjia\Component\Plugin\Installer\PluginInstaller
{

    /**
     * 安装插件
     */
    public function install()
    {
        $plugin_file = RC_Plugin::plugin_basename( $this->plugin_file );

        (new CronPluginStorage())->addPlugin($plugin_file);

        $code = $this->getConfigByKey('cron_code');

        /* 检查输入 */
        if (empty($code)) {
            return ecjia_plugin::add_error('plugin_install_error', __('计划任务插件CODE不能为空', 'cron'));
        }

        $this->installByCode($code);

        return true;
    }

    /**
     * @param $code
     */
    protected function installByCode($code)
    {
        $format_name        = $this->getPluginDataByKey('Name');
        $format_description = $this->getPluginDataByKey('Description');

        /* 取得配置信息 */
        $cron_config = serialize($this->getConfigByKey('forms'));
        $default_time = $this->getConfigByKey('default_time', []);
        $lock_time = $this->getConfigByKey('lock_time', false);

        $cron_expression  = array_get($default_time, 'cron_expression', '');
        $expression_alias = array_get($default_time, 'expression_alias', '');

        //判断是否有默认执行时间配置
        if ($lock_time) {
            $file_list = with(new \Ecjia\App\Cron\CronExpression)->getProvidesMultipleRunDates($cron_expression);
            foreach ($file_list as $key => $value) {
                $file_list[$key] = (array)$value;
            }
            foreach ($file_list as $key => $value) {
                $mydate = new DateTime($value['date']);
                $new_date = $mydate->format('Y-m-d H:i:s');
                $file_list[$key]['new_date'] = $new_date;
            }
            $nexttime = RC_Time::local_strtotime($file_list[0]['new_date']);
        } else {
            $nexttime = 0;
        }

        /* 执行后关闭 */
        $cron_run_once = 0;
        $allow_ip    = '';


        /* 安装，检查该支付方式是否曾经安装过 */
        $count = RC_DB::connection('ecjia')->table('crons')->where('cron_code', $code)->count();

        if ($count > 0) {
            /* 该插件已经安装过, 将该插件的状态设置为 enable */
            $data = array(
                'cron_name' 		=> $format_name,
                'cron_desc'     	=> $format_description,
                'cron_config' 		=> $cron_config,
                'cron_expression' 	=> $cron_expression,
                'expression_alias' 	=> $expression_alias,
                'nexttime' 			=> $nexttime,
                'run_once' 			=> $cron_run_once,
                'allow_ip' 			=> $allow_ip,
                'enabled' 			=> 1
            );

            RC_DB::connection('ecjia')->table('crons')->where('cron_code', $code)->update($data);
        }
        else {
            /* 该插件没有安装过, 将该插件的信息添加到数据库 */
            $data = array(
                'cron_code' 		=> $code,
                'cron_name' 		=> $format_name,
                'cron_desc' 		=> $format_description,
                'cron_config' 		=> $cron_config,
                'cron_expression' 	=> $cron_expression,
                'expression_alias' 	=> $expression_alias,
                'nexttime' 		    => $nexttime,
                'run_once' 		    => $cron_run_once,
                'allow_ip' 		    => $allow_ip,
                'enabled' 		    => 1,
            );
            RC_DB::connection('ecjia')->table('crons')->insert($data);
        }
    }

    /**
     * 卸载插件
     */
    public function uninstall()
    {
        $code = $this->getConfigByKey('cron_code');

        /* 检查输入 */
        if (empty($code)) {
            return ecjia_plugin::add_error('plugin_uninstall_error', __('计划任务插件CODE不能为空', 'cron'));
        }

        (new PluginUninstaller($code, new CronPluginStorage()))->uninstall();

        return true;
    }


}