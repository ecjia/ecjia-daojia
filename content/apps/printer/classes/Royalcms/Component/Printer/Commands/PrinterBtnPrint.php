<?php

namespace Royalcms\Component\Printer\Commands;

use Royalcms\Component\Printer\Contracts\Command;
use Royalcms\Component\Printer\Request;

class PrinterBtnPrint extends Request implements Command
{
    
    /**
     * 接口名称
     * @var string
     */
    protected $method = 'yly/printer/btnprint';
    
    
    /**
     * 初始化
     */
    public function __construct()
    {
        $this->params = [
            'machine_code' => '',  // 必须 打印机终端号
            'response_type' => '',  // 必须 开启:btnopen,关闭:btnclose; 按键打印
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
     * 开启:btnopen,关闭:btnclose; 按键打印
     * @param string $value 开启:btnopen,关闭:btnclose; 按键打印
     */
    public function setResponseType($value)
    {
        $this->params['response_type'] = $value;
    
        return $this;
    }
    
}
