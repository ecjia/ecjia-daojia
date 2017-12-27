<?php

namespace Royalcms\Component\Printer\Commands;

use Royalcms\Component\Printer\Contracts\Command;
use Royalcms\Component\Printer\Request;

class PrinterSetIcon extends Request implements Command
{
    
    /**
     * 接口名称
     * @var string
     */
    protected $method = 'yly/printer/seticon';
    
    
    /**
     * 初始化
     */
    public function __construct()
    {
        $this->params = [
            'machine_code' => '',  // 必须 打印机终端号
            'img_url' => '',  // 必须 图片地址,图片宽度最大为350px,文件大小不能超过40Kb
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
     * 图片地址,图片宽度最大为350px,文件大小不能超过40Kb
     * @param string $value 图片地址
     */
    public function setImgUrl($value)
    {
        $this->params['img_url'] = $value;
    
        return $this;
    }
    
}
