<?php

namespace Royalcms\Component\Printer\Commands;

use Royalcms\Component\Printer\Contracts\Command;
use Royalcms\Component\Printer\Request;

class PrinterSetNotify extends Request implements Command
{
    
    /**
     * 接口名称
     * @var string
     */
    protected $method = 'yly/printer/setnotify';
    
    
    /**
     * 初始化
     */
    public function __construct()
    {
        $this->params = [
            'oauth_finish' => '',  // 必须 打印完成推送
            'oauth_getOrder' => '',  // 接单拒单推送
            'oauth_printStatus' => '',  // 打印机状态推送推送
        ];
    }
    
    /**
     * 打印完成推送
     * @param string $value 推送地址
     */
    public function setOauthFinish($value)
    {
        $this->params['oauth_finish'] = $value;
    
        return $this;
    }
    
    /**
     * 接单拒单推送
     * @param string $value 推送地址
     */
    public function setOauthGetOrder($value)
    {
        $this->params['oauth_getOrder'] = $value;
    
        return $this;
    }
    
    /**
     * 打印机状态推送推送
     * @param string $value 推送地址
     */
    public function setOauthPrintStatus($value)
    {
        $this->params['oauth_printStatus'] = $value;
    
        return $this;
    }
    
}
