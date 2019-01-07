<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/11/27
 * Time: 10:26
 */

namespace Ecjia\App\Withdraw\Transfers;

use Ecjia\App\Withdraw\WithdrawManagerAbstract;
use ecjia_error;

class TransferQueryManager extends WithdrawManagerAbstract
{

    public function transfer()
    {
        return $this->initWithdrawRecord();
    }

    /**
     * 退款插件处理
     *
     * @return array|ecjia_error
     */
    protected function doPluginHandler()
    {

        $result = $this->pluginHandler->transfersQuery($this->withdrawRecord->order_sn);

        return $result;
    }

}