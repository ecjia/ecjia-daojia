<?php

namespace Royalcms\Component\Printer\Commands;

use Royalcms\Component\Printer\Contracts\Command;
use Royalcms\Component\Printer\Request;

class PrintMenuAddPrintMenu extends Request implements Command
{
    
    /**
     * 接口名称
     * @var string
     */
    protected $method = 'yly/printmenu/addprintmenu';
    
    
    /**
     * 初始化
     */
    public function __construct()
    {
        $this->params = [
            'machine_code' => '',  // 必须 打印机终端号
            'content' => '',  // 必须 json格式的应用菜单（其中url和菜单名称需要urlencode)
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
     * json格式的应用菜单（其中url和菜单名称需要urlencode)
     * @param string $value json格式的应用菜单
     */
    public function setContent($value)
    {
        $this->params['content'] = $value;
    
        return $this;
    }
    
}
