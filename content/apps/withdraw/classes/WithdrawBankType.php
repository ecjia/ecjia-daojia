<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/12/29
 * Time: 14:55
 */

namespace Ecjia\App\Withdraw;


class WithdrawBankType
{

    protected $plugins;

    public function __construct()
    {
        $WithdrawPlugin = new WithdrawPlugin();

        $this->plugins = $WithdrawPlugin->getAvailablePlugins();

    }


    public function getPlugins()
    {
        return $this->plugins;
    }

    public function getDisplayBankType()
    {
        $support_bank = false;

        $plugins = $this->plugins->map(function ($model) {
            $plugin    = $model->channel($model->withdraw_code);
            $bank_type = $plugin->getBankType();

            $data = [
                'bank_name' => $plugin->getDisplayName(),
                'bank_type' => $bank_type,
            ];

            return $data;
        })->filter(function ($item) use (& $support_bank) {
            if ($item['bank_type'] == 'bank') {
                $support_bank = true;
                return false;
            }
            if ($item['bank_type'] == 'cash') {
                return false;
            }
            return true;
        });

        if ($support_bank) {
            $plugins->push([
                'bank_name' => __('银行转账', 'withdraw'),
                'bank_type' => 'bank',
            ]);
        }

        return $plugins->all();
    }

}