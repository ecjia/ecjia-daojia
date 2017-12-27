<?php

namespace Royalcms\Component\Printer\Commands;

use Royalcms\Component\Printer\Contracts\Command;
use Royalcms\Component\Printer\Request;

class PrinterSetSound extends Request implements Command
{
    
    /**
     * 接口名称
     * @var string
     */
    protected $method = 'yly/printer/setsound';
    
    
    /**
     * 初始化
     */
    public function __construct()
    {
        $this->params = [
            'machine_code' => '',  // 必须 打印机终端号
            'response_type' => '',  // 必须 蜂鸣器:buzzer,喇叭:horn
            'voice' => '',  // 必须 [1,2,3] 3种音量设置
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
     * 蜂鸣器:buzzer,喇叭:horn
     * @param string $value 蜂鸣器:buzzer,喇叭:horn
     */
    public function setResponseType($value)
    {
        $this->params['response_type'] = $value;
    
        return $this;
    }
    
    /**
     * [0,1,2,3] 3种音量设置,0关闭音量
     * @param string $value 音量值
     */
    public function setVoice($value)
    {
        $this->params['voice'] = $value;
    
        return $this;
    }
    
}
