<?php
//
//    ______         ______           __         __         ______
//   /\  ___\       /\  ___\         /\_\       /\_\       /\  __ \
//   \/\  __\       \/\ \____        \/\_\      \/\_\      \/\ \_\ \
//    \/\_____\      \/\_____\     /\_\/\_\      \/\_\      \/\_\ \_\
//     \/_____/       \/_____/     \/__\/_/       \/_/       \/_/ /_/
//
//   上海商创网络科技有限公司
//
//  ---------------------------------------------------------------------------------
//
//   一、协议的许可和权利
//
//    1. 您可以在完全遵守本协议的基础上，将本软件应用于商业用途；
//    2. 您可以在协议规定的约束和限制范围内修改本产品源代码或界面风格以适应您的要求；
//    3. 您拥有使用本产品中的全部内容资料、商品信息及其他信息的所有权，并独立承担与其内容相关的
//       法律义务；
//    4. 获得商业授权之后，您可以将本软件应用于商业用途，自授权时刻起，在技术支持期限内拥有通过
//       指定的方式获得指定范围内的技术支持服务；
//
//   二、协议的约束和限制
//
//    1. 未获商业授权之前，禁止将本软件用于商业用途（包括但不限于企业法人经营的产品、经营性产品
//       以及以盈利为目的或实现盈利产品）；
//    2. 未获商业授权之前，禁止在本产品的整体或在任何部分基础上发展任何派生版本、修改版本或第三
//       方版本用于重新开发；
//    3. 如果您未能遵守本协议的条款，您的授权将被终止，所被许可的权利将被收回并承担相应法律责任；
//
//   三、有限担保和免责声明
//
//    1. 本软件及所附带的文件是作为不提供任何明确的或隐含的赔偿或担保的形式提供的；
//    2. 用户出于自愿而使用本软件，您必须了解使用本软件的风险，在尚未获得商业授权之前，我们不承
//       诺提供任何形式的技术支持、使用担保，也不承担任何因使用本软件而产生问题的相关责任；
//    3. 上海商创网络科技有限公司不对使用本产品构建的商城中的内容信息承担责任，但在不侵犯用户隐
//       私信息的前提下，保留以任何方式获取用户信息及商品信息的权利；
//
//   有关本产品最终用户授权协议、商业授权与技术服务的详细内容，均由上海商创网络科技有限公司独家
//   提供。上海商创网络科技有限公司拥有在不事先通知的情况下，修改授权协议的权力，修改后的协议对
//   改变之日起的新授权用户生效。电子文本形式的授权协议如同双方书面签署的协议一样，具有完全的和
//   等同的法律效力。您一旦开始修改、安装或使用本产品，即被视为完全理解并接受本协议的各项条款，
//   在享有上述条款授予的权力的同时，受到相关的约束和限制。协议许可范围以外的行为，将直接违反本
//   授权协议并构成侵权，我们有权随时终止授权，责令停止损害，并保留追究相关责任的权力。
//
//  ---------------------------------------------------------------------------------
//

namespace Ecjia\App\Withdraw;

use Ecjia\System\Plugin\PluginModel;
use ecjia_error;
use ecjia_plugin;
use RC_Plugin;
use ecjia_admin;

/**
 * 提现方式插件管理
 * Class WithdrawPlugin
 * @package Ecjia\App\Payment
 * @method \Royalcms\Component\Database\Eloquent\Builder enabled() 限制查询只包括启动的支付渠道。
 * @method \Royalcms\Component\Database\Eloquent\Builder online() 限制查询只包括在线的支付渠道。
 */
class WithdrawPlugin extends PluginModel
{
    protected $table = 'withdraw_method';

    protected $addon_plugin_name = 'withdraw_plugins';

    /**
     * 当前插件种类的唯一标识字段名
     */
    public function codeFieldName()
    {
        return 'withdraw_code';
    }

    /**
     * 获取数据库中启用的插件列表
     */
    public function getEnableList()
    {
        $data = $this->enabled()->orderBy('withdraw_code', 'asc')->get()->toArray();
        return $data;
    }

    /**
     * 获取数据库中插件数据
     */
    public function getPluginDataById($id)
    {
        return $this->where('withdraw_id', $id)->where('enabled', 1)->first();
    }

    public function getPluginDataByCode($code)
    {
        return $this->where('withdraw_code', $code)->where('enabled', 1)->first();
    }

    public function getPluginDataByName($name)
    {
        return $this->where('withdraw_name', $name)->where('enabled', 1)->first();
    }

    /**
     * 插件安装方法
     */
    public function pluginInstall(array $config, $plugin_file)
    {
        if (!empty($config)) {

            $plugin_data = RC_Plugin::get_plugin_data($plugin_file);
            if (!empty($plugin_data)) {
                $format_name        = $plugin_data['Name'];
                $format_description = $plugin_data['Description'];
            } else {
                $format_name        = '';
                $format_description = '';
            }

            /* 检查输入 */
            if (empty($format_name) || empty($config['withdraw_code'])) {
                return ecjia_plugin::add_error('plugin_install_error', __('提现方式名称或withdraw_code不能为空', 'withdraw'));
            }

            /* 检测支付名称重复 */
            $data = $this->where('withdraw_name', $format_name)->where('withdraw_code', $config['withdraw_code'])->count();

            if (!$data) {
                /* 取得配置信息 */
                $withdraw_config = serialize($config['forms']);

                /* 取得和验证支付手续费 */
                $withdraw_fee = array_get($config, 'withdraw_fee', 0);

                /* 安装，检查该支付方式是否曾经安装过 */
                $count = $this->where('withdraw_code', $config['withdraw_code'])->count();

                if ($count > 0) {
                    /* 该支付方式已经安装过, 将该支付方式的状态设置为 enable */
                    $data = array(
                        'withdraw_name'   => $format_name,
                        'withdraw_desc'   => $format_description,
                        'withdraw_config' => $withdraw_config,
                        'withdraw_fee'    => $withdraw_fee,
                        'enabled'         => 1
                    );

                    $this->where('withdraw_code', $config['withdraw_code'])->update($data);

                } else {
                    /* 该支付方式没有安装过, 将该支付方式的信息添加到数据库 */
                    $data = array(
                        'withdraw_code'   => $config['withdraw_code'],
                        'withdraw_name'   => $format_name,
                        'withdraw_desc'   => $format_description,
                        'withdraw_config' => $withdraw_config,
                        'withdraw_fee'    => $withdraw_fee,
                        'enabled'         => 1,
                        'is_online'       => $config['is_online'],
                    );
                    $this->insert($data);
                }

                /* 记录日志 */
                ecjia_admin::admin_log($format_name, 'install', 'withdraw');

                return true;
            } else {
                //ecjia_plugin::add_error('plugin_install_error', __('提现方式已存在'));
                //重复插件自动确认为已经安装
                return true;
            }

        } else {
            return ecjia_plugin::add_error('plugin_install_error', __('插件配置文件未传入', 'withdraw'));
        }
    }

    /**
     * 插件卸载方法
     */
    public function pluginUninstall(array $config, $plugin_file)
    {

        if (!empty($config)) {

            $plugin_data = RC_Plugin::get_plugin_data($plugin_file);
            if (!empty($plugin_data)) {
                $format_name        = $plugin_data['Name'];
                $format_description = $plugin_data['Description'];
            } else {
                $format_name        = '';
                $format_description = '';
            }

            /* 检查输入 */
            if (empty($format_name) || empty($config['withdraw_code'])) {
                return ecjia_plugin::add_error('plugin_uninstall_error', __('提现方式名称不能为空', 'withdraw'));
            }

            /* 从数据库中删除支付方式 */
            $this->where('withdraw_code', $config['withdraw_code'])->delete();

            /* 记录日志 */
            ecjia_admin::admin_log($format_name, 'uninstall', 'withdraw');

            return true;

        } else {
            return ecjia_plugin::add_error('plugin_uninstall_error', __('插件配置文件未传入', 'withdraw'));
        }
    }

    /**
     * 获取数据中的Config配置数据，并处理
     */
    public function configData($code)
    {
        $pluginData = $this->getPluginDataByCode($code);

        $config = $this->unserializeConfig($pluginData['withdraw_config']);

        $config['withdraw_code'] = $code;
        $config['withdraw_name'] = $pluginData['withdraw_name'];

        return $config;
    }

    /**
     * 限制查询只包括启动的支付渠道。
     *
     * @return \Royalcms\Component\Database\Eloquent\Builder
     */
    public function scopeEnabled($query)
    {
        return $query->where('enabled', 1);
    }

    /**
     * 限制查询只包括在线的支付渠道。
     *
     * @return \Royalcms\Component\Database\Eloquent\Builder
     */
    public function scopeOnline($query)
    {
        return $query->where('is_online', 1);
    }

    /**
     * 取得已安装的支付方式(其中不包括线下支付的)
     * @param   array $available_plugins 可使用的插件，一维数组 ['withdraw_alipay', 'withdraw_bank']
     * @param   bool $include_balance 是否包含余额支付（冲值时不应包括）
     * @return  array   已安装的配送方式列表
     */
    public function getOnlinePlugins(array $available_plugins = array())
    {
        $model = $this->online();

        $data = $model->select('withdraw_id', 'withdraw_code', 'withdraw_name', 'withdraw_fee')->get();

        $withdraw_list = array();

        if (!empty($data)) {

            $withdraw_list = $data->flatMap(function ($item) use ($available_plugins) {
                if (empty($available_plugins)) {
                    $available_plugins = array_keys($this->getInstalledPlugins());
                }

                if (in_array($item['withdraw_code'], $available_plugins)) {
                    $item['format_withdraw_fee'] = strpos($item['withdraw_fee'], '%') !== false ? $item['withdraw_fee'] : ecjia_price_format($item['withdraw_fee'], false);
                    return array($item);
                } else {
                    return array();
                }
            });
        }

        return $withdraw_list;
    }

    /**
     * 取得可用的提现方式列表
     * @param   int $is_online 是否支持在线支付
     * @return  array   提现方式数组
     */
    public function getAvailablePlugins(array $available_plugins = array(), $is_online = false)
    {
        $model = $this->enabled();

        if ($is_online) {
            $model->online();
        }

        $data = $model
            ->select('withdraw_id', 'withdraw_code', 'withdraw_name', 'withdraw_fee', 'is_online')
            ->orderby('withdraw_order', 'asc')
            ->get();

        $withdraw_list = array();

        if (!empty($data)) {

            $withdraw_list = $data->flatMap(function ($item) use ($available_plugins) {
                if (empty($available_plugins)) {
                    $available_plugins = array_keys($this->getInstalledPlugins());
                }

                if (in_array($item['withdraw_code'], $available_plugins)) {
                    $item['withdraw_name']       = $this->channel($item['withdraw_code'])->getDisplayName();
                    $item['format_withdraw_fee'] = strpos($item['withdraw_fee'], '%') !== false ? $item['withdraw_fee'] : ecjia_price_format($item['withdraw_fee'], false);
                    return array($item);
                } else {
                    return array();
                }
            });
        }

        return $withdraw_list;
    }

    /**
     * 获取默认插件实例
     */
    public function defaultChannel()
    {
        $data = $this->enabled()->orderBy('withdraw_order', 'asc')->first();

        $config = $this->unserializeConfig($data->withdraw_config);

        $handler = $this->pluginInstance($data->withdraw_code, $config);

        if (!$handler) {
            return new ecjia_error('code_not_found', $data->withdraw_code . ' plugin not found!');
        }

        return $handler;
    }

    /**
     * 获取某个插件的实例对象
     * @param string|integer $code 类型为string时是withdraw_code，类型是integer时是withdraw_id
     * @return \ecjia_error|\Ecjia\System\Plugin\AbstractPlugin>|\ecjia_error|\Ecjia\System\Plugin\AbstractPlugin
     */
    public function channel($code = null)
    {
        if (is_null($code)) {
            return $this->defaultChannel();
        }

        if (is_int($code)) {
            $data = $this->getPluginDataById($code);
        } else {
            $data = $this->getPluginDataByCode($code);
        }

        if (empty($data)) {
            return new ecjia_error('withdraw_not_found', $code . ' withdraw not found!');
        }

        $config = $this->unserializeConfig($data->withdraw_config);

        $handler = $this->pluginInstance($data->withdraw_code, $config);
        if (!$handler) {
            return new ecjia_error('plugin_not_found', $data->withdraw_code . ' plugin not found!');
        }

        $handler->setPluginModel($data);

        return $handler;
    }

}

// end