<?php

namespace Royalcms\Component\Printer\Commands;

use Royalcms\Component\Printer\Contracts\Command;
use Royalcms\Component\Printer\Request;

class PrintIndex extends Request implements Command
{
    
    /**
     * 接口名称
     * @var string
     */
    protected $method = 'yly/print/index';
    
    
    /**
     * 初始化
     */
    public function __construct()
    {
        $this->params = [
            'machine_code' => '',  // 必须 打印机终端号
            'content' => '',  // 必须 打印内容，排版指令详见打印机指令
            'origin_id' => '',  // 必须 订单号
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
     * 打印内容，排版指令详见打印机指令
     * @param string $value 打印内容
     */
    public function setContent($value)
    {
        $this->params['content'] = $value;
    
        return $this;
    }
    
    /**
     * 订单号
     * @param string $value 订单号
     */
    public function setOriginId($value)
    {
        $this->params['origin_id'] = $value;
    
        return $this;
    }
    
}
