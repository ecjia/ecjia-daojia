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
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA 短信模块 之 模型（类库）
 */
class sms_send {
    private $db;
    
    public static function make() {
        return new static();
    }
    
    /**
     * 构造函数
     *
     * @access  public
     * @return  void
     */
    public function __construct() {
        $this->db = RC_Model::model('sms/sms_sendlist_model');
    }
   
     /** 发送短消息
      *
      * @access  public
      * @param   string  $mobile         要发送到手机号码，传的值是一个正常的手机号
      * @param   string  $msg            发送的消息内容
      * @param   integer $template       短信模板ID
      * @param   integer $priority       1 优先级高，立即发送， 0 优先级低的异步发送
      */
    public function send($mobile, $msg, $template, $priority = 1) {
        $reponse = ecjia_sms::make()->setMessage($msg)->setNumber($mobile)->send();
        
        //插入数据库记录
        //手机号码、短信模板ID，短信内容，是否出错（0，1），优先级高低（0，1），最后发送时间
        $data = array(
        	'mobile'        => $mobile,
            'template_id'   => $template,
            'sms_content'   => $msg,
            'pri'           => $priority,
            'error'         => 0,
            'last_send'     => RC_Time::gmtime(),
        );
        
        if ($reponse['code'] == 2) {
            $result = true;
        } else {
            $data['error']  = 1;
            $result         = new ecjia_error('sms_send_error', $reponse['description']);
        }
        $this->db->insert($data);
        
        return $result;
    }
    
    /**
     * 当短信发送失败时，可重新发送此条短信
     */
    public function resend($smsid) {
        $row = $this->db->find(array('id' => $smsid));
        if (empty($row)) {
            return new ecjia_error('not_found_smsid', RC_Lang::get('sms::sms.not_found_smsid'));
        }
        
        $reponse = ecjia_sms::make()->setMessage($row['sms_content'])->setNumber($row['mobile'])->send();
        
        $data = array(
            'error'         => 0,
            'last_send'     => RC_Time::gmtime(),
        );
        
        if ($reponse['code'] == 2) {
            $result = true;
        } else {
            $data['error'] = $row['error'] + 1;
            $result        = new ecjia_error('sms_send_error', $reponse['description']);
        }
        
        $this->db->where(array('id' => $smsid))->update($data);
        
        return $result;
    }
    
    /**
     * 批量重新发送，需要传数组
     * @param array $smsids
     */
    public function batch_resend($smsids) {
        if (!is_array($smsids)) {
            return new ecjia_error('invalid_argument', RC_Lang::get('sms::sms.invalid_argument'));
        }
        
        $result = array();
        foreach ($smsids as $key => $smsid) {
            $result[$key] = $this->resend($smsid);
        }
        
        return $result;
    }
    

    /**
     * 检测启用短信服务需要的信息
     *
     * @access  private
     * @param   string      $account        帐号
     * @param   string      $password       密码
     * @return  boolean                     如果启用信息格式合法就返回true，否则返回false。
     */
    public function check_enable_info($account, $password) {
        if (empty($account) || empty($password)) {
            return false;
        }

        return true;
    }

    /**
     * 查询账户余额
     */
    public function check_balance() {
        $account  = ecjia::config('sms_user_name');
        $password = ecjia::config('sms_password');
        if (!$this->check_enable_info($account, $password)) {
            return new ecjia_error('invalid_account', RC_Lang::get('sms::sms.invalid_account'));
        }

        $reponse = ecjia_sms::make()->balance();
        if ($reponse['code'] == 2) {
            return $reponse['num'];
        } else {
            return new ecjia_error('sms_send_error', $reponse['description']);
        } 
    }
       
}

// end