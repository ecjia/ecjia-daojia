<?php

namespace Royalcms\Component\Printer\Commands;

use Royalcms\Component\Printer\Contracts\Command;
use Royalcms\Component\Printer\Request;

class PrinterCancelOne extends Request implements Command
{
    
    /**
     * 接口名称
     * @var string
     */
    protected $method = 'yly/printer/cancelone';
    
    
    /**
     * 初始化
     */
    public function __construct()
    {
        $this->params = [
            'machine_code' => '',  // 必须 打印机终端号
            'order_id' => '',  // 必须 通过打印接口返回的订单号
        ];
    }
    
    /**
     * 设置打印机终端号
     * @param string $value 打印机终端号
     */
    public function setMachineCode($value)
    {
        $this->params['machine_code'] = $value;
    
        return $this;
    }
    
    /**
     * 通过打印接口返回的订单号
     * @param string $value 订单号
     */
    public function setOrderId($value)
    {
        $this->params['order_id'] = $value;
    
        return $this;
    }
    
}
