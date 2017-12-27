<?php

namespace Ecjia\App\Printer;

use RC_Uri;

class PrinterCallback
{
    
    /**
     * 打印完成推送地址
     * @var string
     */
    const PRINTER_PRINT_PUSH = 'printer/callback/print_push';
    
    /**
     * 打印机状态推送推送地址
     * @var string
     */
    const PRINTER_STATUS_PUSH = 'printer/callback/status_push';
    
    /**
     * 接单拒单推送地址
     * @var string
     */
    const PRINTER_ORDER_PUSH = 'printer/callback/order_push';
    
    /**
     * 打印完成推送地址
     * @var string
     */
    public static function getPrintPush()
    {
        return RC_Uri::url(self::PRINTER_PRINT_PUSH);
    }
    
    /**
     * 打印机状态推送推送地址
     * @var string
     */
    public static function getStatusPush()
    {
        return RC_Uri::url(self::PRINTER_STATUS_PUSH);
    }
    
    /**
     * 接单拒单推送地址
     * @var string
     */
    public static function getOrderPush()
    {
        return RC_Uri::url(self::PRINTER_ORDER_PUSH);
    }
}
