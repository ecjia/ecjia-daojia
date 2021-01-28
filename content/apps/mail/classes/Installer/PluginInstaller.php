<?php

namespace Ecjia\App\Mail\Installer;

use Ecjia\Component\Plugin\Storages\MailPluginStorage;
use ecjia_plugin;
use RC_DB;
use RC_Plugin;

class PluginInstaller extends \Ecjia\Component\Plugin\Installer\PluginInstaller
{

    /**
     * 安装插件
     */
    public function install()
    {
        $plugin_file = RC_Plugin::plugin_basename( $this->plugin_file );

        (new MailPluginStorage())->addPlugin($plugin_file);

        $code = $this->getConfigByKey('mail_code');

        /* 检查输入 */
        if (empty($code)) {
            return ecjia_plugin::add_error('plugin_install_error', __('邮件发送方式CODE不能为空', 'mail'));
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

        $data = RC_DB::connection(config('ecjia.database_connection', 'default'))->table('notification_channels')->where('channel_type', 'mail')->where('channel_code', $code)->count();

        if (!$data) {
            /* 取得配置信息 */
            $config = serialize($this->getConfigByKey('forms'));

            //组织默认数据，将该短信的信息添加到数据库
            /* 安装，检查该短信插件是否曾经安装过 */
            $count = RC_DB::connection(config('ecjia.database_connection', 'default'))->table('notification_channels')->where('channel_type', 'mail')->where('channel_code', $code)->count();

            if ($count > 0) {
                /* 该短信插件已经安装过, 将该短信插件的状态设置为 enable */
                $data = array(
                    'channel_type'   => 'mail',
                    'channel_code'   => $code,
                    'channel_name'   => $format_name,
                    'channel_desc'   => $format_description,
                    'channel_config' => $config,
                    'enabled'        => 1,
                );

                RC_DB::connection(config('ecjia.database_connection', 'default'))->table('notification_channels')->where('channel_type', 'mail')->where('channel_code', $code)->update($data);
            } else {
                /* 该短信插件没有安装过, 将该短信插件的信息添加到数据库 */
                $data = array(
                    'channel_type'   => 'mail',
                    'channel_code'   => $code,
                    'channel_name'   => $format_name,
                    'channel_desc'   => $format_description,
                    'channel_config' => $config,
                    'enabled'        => 1,
                );
                RC_DB::connection(config('ecjia.database_connection', 'default'))->table('notification_channels')->insert($data);
            }
        }
    }

    /**
     * 卸载插件
     */
    public function uninstall()
    {
        $code = $this->getConfigByKey('mail_code');

        /* 检查输入 */
        if (empty($code)) {
            return ecjia_plugin::add_error('plugin_uninstall_error', __('邮件发送方式CODE不能为空', 'mail'));
        }

        (new PluginUninstaller($code, new MailPluginStorage()))->uninstall();

        return true;
    }


}