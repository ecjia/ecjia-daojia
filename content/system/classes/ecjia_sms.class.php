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
/**
 * ECJIA SMS
 */
defined('IN_ECJIA') or exit('No permission resources.');

/* 短信模块主类 */
class ecjia_sms {
    const HOST      = 'http://106.ihuyi.com/webservice/sms.php?';
    const SEND      = 'method=Submit';
    const BALANCE   = 'method=GetNum';
    const PASSWORD  = 'method=ChangePassword';
    
    private $_account;
    private $_password;
    private $_auth;
    private $_sender;
    private $_message;
    private $_type;
    private $_sms;
    
    protected $to = array();
    protected $response_code = array(
        '2000'  => 'SUCCESS - Message Sent.',
        '-1000' => 'UNKNOWN ERROR - Unknown error. Please contact the administrator.',
        '-1001' => 'AUTHENTICATION FAILED - Your username or password are incorrect.',
        '-1002' => 'ACCOUNT SUSPENDED / EXPIRED - Your account has been expired or suspended. Please contact the administrator.',
        '-1003' => 'IP NOT ALLOWED - Your IP is not allowed to send SMS. Please contact the administrator.',
        '-1004' => 'INSUFFICIENT CREDITS - You have run our of credits. Please reload your credits.',
        '-1005' => 'INVALID SMS TYPE - Your SMS type is not supported.',
        '-1006' => 'INVALID BODY LENGTH (1-900) - Your SMS body has exceed the length. Max = 900',
        '-1007' => 'INVALID HEX BODY - Your Hex body format is wrong.',
        '-1008' => 'MISSING PARAMETER - One or more required parameters are missing.'
    );
    
    /**
     * Create SMS instance
     *
     * @return  void
     */
    public static function make()
    {
        return new static();
    }

    public function __construct($account = null, $password = null) 
    {
        /* 直接赋值 */
        $this->_account  = $account ? $account : ecjia::config('sms_user_name');
        $this->_password = $password ? $password : ecjia::config('sms_password');
        $this->_type = 1;
        $this->_sender = '';
        $this->_auth = $this->getAuthParams();
    }
    
    public function setNumber($number) {
        $this->addAnNumber($number);
        return $this;
    }
    
    public function getNumber()
    {
        return $this->_to;
    }
    
    /**
     * 添加信息
     * 如果内容有url需要过滤，可以使用rawurlencode方法
     * @param unknown $msg
     * @return string
     */
    public function setMessage($msg)
    {
        $this->_message = $msg;
        return $this;
    }
    
    public function getMessage()
    {
        return $this->_message;
    }
    
    public function viewSMSParams()
    {
        return $this->getSMSParams();
    }
    
    public function normalize($number)
    {
        return $this->normalizeNumber($number);
    }
    
    public function send()
    {
        $response = array();
        
        $result = $this->sendSMS( is_array($this->_to) ? $this->formatNumber($this->_to) : $this->_to );
        $info = $this->getInfo($result);
        
        $response['raw'] = $result;
        $response['code'] = $info->code;
        $response['description'] = $info->msg;
        return $response;
    }
    
    private function sendSMS($mobile) {
        $url = self::HOST . self::SEND;
        $params = $this->_auth;
        $params['content']  = $this->_message;
        $params['mobile']   = $mobile;
        return $this->curl( $url, $params );
    }
    
    public function balance()
    {
        $response = array();
        
        $url = self::HOST . self::BALANCE;
        $params = $this->_auth;
        $result = $this->curl( $url, $params );
        $info = $this->getInfo($result);
        
        $response['num'] = $info->num;
        $response['code'] = $info->code;
        $response['description'] = $info->msg;
        
        return $response;
    }
    
    private function addAnNumber($number)
    {
        if (is_array($number)) {
            foreach ($number as $num)
            {
                $this->_to[] = $num;
            }
        } else {
            $this->_to[] = $number;
        }
    
    }
    
    private function normalizeNumber($number, $countryCode = 86)
    {
        if (isset($number)) {
            $number = trim($number);
            $number = str_replace("+", "", $number);
            preg_match( '/(0|\+?\d{2})(\d{8,9})/', $number, $matches);
            if ((int) $matches[1] === 0 ) {
                $number = $countryCode . $matches[2];
            }
        }
        return $number;
    }
    
    private function formatNumber($number)
    {
        $format = "";
        if (is_array($number)) {
            $format = implode(";", $number);
        }
        return $format;
    }
    
    private function getInfo($result)
    {
        $result_arr = RC_Xml::to_array($result);
        
        $info = new stdClass();
        $info->code     =  $result_arr['code'][0];
        $info->msg      = $result_arr['msg'][0];
        
        if (isset($result_arr['smsid'])) {
            $info->smsid = $result_arr['smsid'][0];
        }
        
        if (isset($result_arr['num'])) {
            $info->num   = $result_arr['num'][0];
        }
         
        return $info;
    }
    
    private function getAuthParams()
    {
        $params['account']  = $this->_account;
        $params['password'] = $this->_password;
        return $params;
    }
    
    private function getSMSParams()
    {
        $params['mobile']   = $this->formatNumber($this->_to);
        $params['content']  = $this->_message;
        return $params;
    }
    
    private function getAnswer( $code )
    {
        if ( isset( $this->response_code[$code] ) ) {
            return $this->response_code[$code];
        }
    }
    
    private function curl( $url, $params = array() )
    {
        // Use SSL: http://www.php.net/manual/en/function.curl-setopt-array.php#89850
        $ch = curl_init();
        $options = array(
            CURLOPT_RETURNTRANSFER  => TRUE,
            CURLOPT_URL             => $url,
            CURLOPT_HEADER          => false,
            CURLOPT_ENCODING        => "",
            CURLOPT_POST            => 1,
            CURLOPT_POSTFIELDS      => $params,
            CURLOPT_SSL_VERIFYHOST  => 0,
            CURLOPT_SSL_VERIFYPEER  => false,
        );
        curl_setopt_array( $ch, $options );
        $result = curl_exec( $ch );
        curl_close( $ch );
    
        return $result;
    }
    
}

// end