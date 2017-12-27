<?php
//
//    ______         ______           __         __         ______
//   /\  ___\       /\  ___\         /\_\       /\_\       /\  __ \
//   \/\  __\       \/\ \____        \/\_\      \/\_\      \/\ \_\ \
//    \/\_____\      \/\_____\     /\_\/\_\      \/\_\      \/\_\ \_\
//     \/_____/       \/_____/     \/__\/_/       \/_/       \/_/ /_/
//
//   上海商创网络科技有限公司
//
//  ---------------------------------------------------------------------------------
//
//   一、协议的许可和权利
//
//    1. 您可以在完全遵守本协议的基础上，将本软件应用于商业用途；
//    2. 您可以在协议规定的约束和限制范围内修改本产品源代码或界面风格以适应您的要求；
//    3. 您拥有使用本产品中的全部内容资料、商品信息及其他信息的所有权，并独立承担与其内容相关的
//       法律义务；
//    4. 获得商业授权之后，您可以将本软件应用于商业用途，自授权时刻起，在技术支持期限内拥有通过
//       指定的方式获得指定范围内的技术支持服务；
//
//   二、协议的约束和限制
//
//    1. 未获商业授权之前，禁止将本软件用于商业用途（包括但不限于企业法人经营的产品、经营性产品
//       以及以盈利为目的或实现盈利产品）；
//    2. 未获商业授权之前，禁止在本产品的整体或在任何部分基础上发展任何派生版本、修改版本或第三
//       方版本用于重新开发；
//    3. 如果您未能遵守本协议的条款，您的授权将被终止，所被许可的权利将被收回并承担相应法律责任；
//
//   三、有限担保和免责声明
//
//    1. 本软件及所附带的文件是作为不提供任何明确的或隐含的赔偿或担保的形式提供的；
//    2. 用户出于自愿而使用本软件，您必须了解使用本软件的风险，在尚未获得商业授权之前，我们不承
//       诺提供任何形式的技术支持、使用担保，也不承担任何因使用本软件而产生问题的相关责任；
//    3. 上海商创网络科技有限公司不对使用本产品构建的商城中的内容信息承担责任，但在不侵犯用户隐
//       私信息的前提下，保留以任何方式获取用户信息及商品信息的权利；
//
//   有关本产品最终用户授权协议、商业授权与技术服务的详细内容，均由上海商创网络科技有限公司独家
//   提供。上海商创网络科技有限公司拥有在不事先通知的情况下，修改授权协议的权力，修改后的协议对
//   改变之日起的新授权用户生效。电子文本形式的授权协议如同双方书面签署的协议一样，具有完全的和
//   等同的法律效力。您一旦开始修改、安装或使用本产品，即被视为完全理解并接受本协议的各项条款，
//   在享有上述条款授予的权力的同时，受到相关的约束和限制。协议许可范围以外的行为，将直接违反本
//   授权协议并构成侵权，我们有权随时终止授权，责令停止损害，并保留追究相关责任的权力。
//
//  ---------------------------------------------------------------------------------
//
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