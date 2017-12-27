<?php

namespace Ecjia\App\Printer;

use ecjia_config;
use ecjia_error;
use RC_DB;
use Exception;
use Royalcms\Component\Printer\HmacSign;

class PrinterManager
{
    private $appKey;
    private $appSecret;
    
    protected $printer;
    
    public function __construct($appKey = null, $appSecret = null)
    {
        $this->appKey = $appKey ?: ecjia_config::get('printer_key');
        $this->appSecret = $appSecret ?: ecjia_config::get('printer_secret');
        $this->printer = royalcms('printer');
        
        $config = [
            'app_key' => $this->appKey,
            'app_secret' => $this->appSecret,
        ];
        $this->printer->configure($config);
    }
    
    
    /**
     * 设置打印回调地址
     * @param string $finish 打印完成推送地址
     * @param string $getOrder 接单拒单推送地址
     * @param string $printStatus 打印机状态推送推送地址
     */
    public function setNotify($finish = null, $getOrder = null, $printStatus = null)
    {
        try {
            $oauth_finish = $finish ?: ecjia_config::get('printer_print_push');
            $oauth_getOrder = $getOrder ?: ecjia_config::get('printer_order_push');
            $oauth_printStatus = $printStatus ?: ecjia_config::get('printer_status_push');
            
            $resp = $this->printer->request('yly/printer/setnotify', function ($req) use ($oauth_finish, $oauth_getOrder, $oauth_printStatus) {
            	$req->setOauthFinish($oauth_finish);
            	$req->setOauthGetOrder($oauth_getOrder);
            	$req->setOauthPrintStatus($oauth_printStatus);
            });
            
            return $resp;
        } catch (Exception $e) {
            return new ecjia_error('ecjia_printer_set_notify', $e->getMessage());
        }
    }
    
    /**
     * 添加打印机
     * @param string $print_name    设置打印机终端名称
     * @param string $machine_code  设置打印机终端号
     * @param string $machine_secret设置打印机终端密钥
     * @param string $phone         设置终端内部的手机号
     */
    public function addPrinter($print_name, $machine_code, $machine_secret, $phone = '')
    {
        try {
            $resp = $this->printer->request('yly/printer/addprinter', function ($req) use ($print_name, $machine_code, $machine_secret, $phone) {
                $req->setMachineCode($machine_code);
                $req->setMsign($machine_secret);
                $req->setPhone($phone);
                $req->setPrintName($print_name);
            });
            
            return $resp;
        } catch (Exception $e) {
            return new ecjia_error('ecjia_printer_add_printer', $e->getMessage());
        }
    }
    
    /**
     * 删除打印机
     * @param string $machine_code  设置打印机终端号
     */
    public function deletePrinter($machine_code)
    {
        try {
            $resp = $this->printer->request('yly/printer/deleteprinter', function ($req) use ($machine_code) {
                $req->setMachineCode($machine_code);
            });
            
            return $resp;
        } catch (Exception $e) {
            return new ecjia_error('ecjia_printer_delete_printer', $e->getMessage());
        }
    }
    
    /**
     * 关机
     * @param string $machine_code
     */
    public function shutdown($machine_code)
    {
        try {
            $resp = $this->printer->request('yly/printer/shutdownrestart', function ($req) use ($machine_code) {
                $req->setMachineCode($machine_code);
                $req->setResponseType('shutdown');
            });
            
            return $resp;
        } catch (Exception $e) {
            return new ecjia_error('ecjia_printer_shutdown_restart', $e->getMessage());
        }
    }
    
    /**
     * 重启
     * @param string $machine_code
     */
    public function restart($machine_code)
    {
        try {
            $resp = $this->printer->request('yly/printer/shutdownrestart', function ($req) use ($machine_code) {
                $req->setMachineCode($machine_code);
                $req->setResponseType('restart');
            });
            
            return $resp;
        } catch (Exception $e) {
            return new ecjia_error('ecjia_printer_shutdown_restart', $e->getMessage());
        }
    }
    
    /**
     * 上传LOGO
     */
    public function setIcon($machine_code, $img_url)
    {
        try {
            $resp = $this->printer->request('yly/printer/seticon', function ($req) use ($machine_code, $img_url) {
                $req->setMachineCode($machine_code);
                $req->setImgUrl($img_url);
            });
            
            return $resp;
        } catch (Exception $e) {
            return new ecjia_error('ecjia_printer_set_icon', $e->getMessage());
        }
    }
    
    /**
     * 删除LOGO
     */
    public function deleteIcon($machine_code)
    {
        try {
            $resp = $this->printer->request('yly/printer/deleteicon', function ($req) use ($machine_code) {
                $req->setMachineCode($machine_code);
            });
            
            return $resp;
        } catch (Exception $e) {
            return new ecjia_error('ecjia_printer_delete_icon', $e->getMessage());
        }
    }
    
    
    /**
     * 获取机型软硬件版本
     */
    public function getVersion($machine_code)
    {
        try {
            $resp = $this->printer->request('yly/printer/getversion', function ($req) use ($machine_code) {
                $req->setMachineCode($machine_code);
            });
        
            return $resp;
        } catch (Exception $e) {
            return new ecjia_error('ecjia_printer_get_version', $e->getMessage());
        }
    }
    
    
    /**
     * 取消所有未打印订单
     */
    public function cancelAll($machine_code)
    {
        try {
            $resp = $this->printer->request('yly/printer/cancelall', function ($req) use ($machine_code) {
                $req->setMachineCode($machine_code);
            });
        
            return $resp;
        } catch (Exception $e) {
            return new ecjia_error('ecjia_printer_cancel_all', $e->getMessage());
        }
    }
    
    
    /**
     * 取消单条未打印订单
     */
    public function cancelOne($machine_code, $order_id)
    {
        try {
            $resp = $this->printer->request('yly/printer/cancelone', function ($req) use ($machine_code, $order_id) {
                $req->setMachineCode($machine_code);
                $req->setOrderId($order_id);
            });
        
            return $resp;
        } catch (Exception $e) {
            return new ecjia_error('ecjia_printer_cancel_one', $e->getMessage());
        }
    }
    
    
    /**
     * 开启接单拒单
     * @param string $machine_code
     */
    public function openGetOrder($machine_code)
    {
        try {
            $resp = $this->printer->request('yly/printer/getorder', function ($req) use ($machine_code) {
                $req->setMachineCode($machine_code);
                $req->setResponseType('open');
            });
        
            return $resp;
        } catch (Exception $e) {
            return new ecjia_error('ecjia_printer_get_order', $e->getMessage());
        }
    }
    
    
    /**
     * 关闭接单拒单
     * @param string $machine_code
     */
    public function closeGetOrder($machine_code)
    {
        try {
            $resp = $this->printer->request('yly/printer/getorder', function ($req) use ($machine_code) {
                $req->setMachineCode($machine_code);
                $req->setResponseType('close');
            });
        
            return $resp;
        } catch (Exception $e) {
            return new ecjia_error('ecjia_printer_get_order', $e->getMessage());
        }
    }
    
    
    /**
     * 开启按键打印
     * @param string $machine_code
     */
    public function openBtnPrint($machine_code)
    {
        try {
            $resp = $this->printer->request('yly/printer/btnprint', function ($req) use ($machine_code) {
                $req->setMachineCode($machine_code);
                $req->setResponseType('btnopen');
            });
    
                return $resp;
        } catch (Exception $e) {
            return new ecjia_error('ecjia_printer_get_order', $e->getMessage());
        }
    }
    
    
    /**
     * 关闭按键打印
     * @param string $machine_code
     */
    public function closeBtnPrint($machine_code)
    {
        try {
            $resp = $this->printer->request('yly/printer/btnprint', function ($req) use ($machine_code) {
                $req->setMachineCode($machine_code);
                $req->setResponseType('btnclose');
            });
    
                return $resp;
        } catch (Exception $e) {
            return new ecjia_error('ecjia_printer_get_order', $e->getMessage());
        }
    }
    
    /**
     * 获取机型打印宽度接口
     * @param string $machine_code
     */
    public function getPrintInfo($machine_code)
    {
        try {
            $resp = $this->printer->request('yly/printer/printinfo', function ($req) use ($machine_code) {
                $req->setMachineCode($machine_code);
            });
        
            return $resp;
        } catch (Exception $e) {
            return new ecjia_error('ecjia_printer_print_info', $e->getMessage());
        }
    }
    
    
    /**
     * 获取机型状态信息
     * @param string $machine_code
     */
    public function getPrintStatus($machine_code)
    {
        try {
            $resp = $this->printer->request('yly/printer/printstatus', function ($req) use ($machine_code) {
                $req->setMachineCode($machine_code);
            });
    
                return $resp;
        } catch (Exception $e) {
            return new ecjia_error('ecjia_printer_print_status', $e->getMessage());
        }
    }
    
    /**
     * 音量调节接口
     * @param string $machine_code
     * @param string $response_type 蜂鸣器:buzzer,喇叭:horn
     * @param string $voice [0,1,2,3] 3种音量设置,0关闭音量
     */
    public function setSound($machine_code, $response_type, $voice)
    {
        try {
            $resp = $this->printer->request('yly/printer/setsound', function ($req) use ($machine_code, $response_type, $voice) {
                $req->setMachineCode($machine_code);
                $req->setResponseType($response_type);
                $req->setVoice($voice);
            });
        
            return $resp;
        } catch (Exception $e) {
            return new ecjia_error('ecjia_printer_set_sound', $e->getMessage());
        }
    }
    
    /**
     * 打印接口
     * @param string $machine_code
     * @param string $content 打印内容，排版指令详见打印机指令
     * @param string $origin_id 订单号
     */
    public function printSend($machine_code, $content, $origin_id)
    {
        try {
            $resp = $this->printer->request('yly/print/index', function ($req) use ($machine_code, $content, $origin_id) {
                $req->setMachineCode($machine_code);
                $req->setContent($content);
                $req->setOriginId($origin_id);
            });
        
            return $resp;
        } catch (Exception $e) {
            return new ecjia_error('ecjia_printer_print_send', $e->getMessage());
        }
    }
    
    
    /**
     * 打印机状态推送更新
     * @param string $machine_code
     * @param integer $online
     * @param string $push_time
     */
    public function statusPush($machine_code, $online)
    {
        return RC_DB::table('printer_machine')->where('machine_code', $machine_code)->update(['online_status' => $online, 'online_update_time' => \RC_Time::gmtime()]);
    }
    
    /**
     * 打印机打印完成推送更新
     * @param string $machine_code
     * @param string $print_order_id
     * @param string $order_sn
     * @param integer $state
     * @param integer $print_time
     */
    public function printPush($machine_code, $print_order_id, $order_sn, $state, $print_time)
    {
        $print_time = \RC_Time::local_strtotime(date('Y-m-d H:i:s', $print_time));
        return RC_DB::table('printer_printlist')->where('machine_code', $machine_code)->where('print_order_id', $print_order_id)
                    ->update(['status' => $state, 'print_time' => $print_time]);
    }
    
    /**
     * 验证签名
     * @param string $sign
     */
    public function verifySign(array $params, $sign)
    {
        $params['app_key'] = $this->appKey;
        $mysign = HmacSign::generateSign($params, $this->appSecret);
        if ($mysign === $sign) {
            return true;
        } else {
            return false;
        }
    }
    
}

// end