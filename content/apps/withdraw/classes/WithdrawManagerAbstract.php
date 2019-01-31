<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/11/27
 * Time: 15:46
 */

namespace Ecjia\App\Withdraw;

use Ecjia\App\Withdraw\Repositories\WithdrawRecordRepository;
use ecjia_error;

abstract class WithdrawManagerAbstract
{

    protected $withdrawCode;

    /**
     * @var \Ecjia\App\Withdraw\WithdrawAbstract
     */
    protected $pluginHandler;

    protected $withdrawRecord;

    /**
     * @var WithdrawRecordRepository
     */
    protected $withdrawRecordRepository;

    public function __construct($order_sn)
    {
        $this->withdrawRecordRepository = new WithdrawRecordRepository();

        $this->withdrawRecord = $this->withdrawRecordRepository->findBy('order_sn', $order_sn);
    }

    public function initWithdrawRecord()
    {
        if (empty($this->withdrawRecord)) {
            return new ecjia_error('withdraw_record_not_found', __('此笔交易记录未找到', 'withdraw'));
        }

        $this->withdrawCode = $this->withdrawRecord->withdraw_code;

        $withdraw_plugin     = new WithdrawPlugin();
        $this->pluginHandler = $withdraw_plugin->channel($this->withdrawCode);
        if (is_ecjia_error($this->pluginHandler)) {
            return $this->pluginHandler;
        }

        $this->pluginHandler->setWithdrawRecordRepository($this->withdrawRecordRepository);

        return $this->doPluginHandler();
    }

    /**
     * 转让插件处理
     *
     * @return mixed
     */
    abstract protected function doPluginHandler();

}