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
 * ECJIA 消息应用
 */
class push_send {
    private $db;
    
    const CLIENT_ANDROID    = 'android';
    const CLIENT_IPHONE     = 'iphone';
    const CLIENT_IPAD       = 'ipad';
    
    protected $app_key;
    protected $app_secret;
    protected $client;
    protected $app_id;
    protected $custom_fields = array();
    
    public static function make($appid) {
        return new static($appid);
    }
    
    /**
     * 构造函数
     *
     * @access  public
     * @return  void
     */
    public function __construct($appid) {
        RC_Loader::load_app_class('push_notification', 'push', false);
        RC_Loader::load_app_class('mobile_manage', 'mobile', false);
        
        $app = mobile_manage::make($appid);
        
        $this->app_id       = $appid;
        $this->app_key      = $app->getAppKey();
        $this->app_secret   = $app->getAppSecret();
        $this->client       = $app->getClient();
        
        $this->db           = RC_Model::model('push/push_message_model');
    }
    
    /**
     * 设置客户端
     * @param string $client
     */
    public function set_client($client) {
        $this->client = $client;
//         if ($client == self::CLIENT_ANDROID) {
//             $this->app_key = ecjia::config('app_key_android');
//             $this->app_secret = ecjia::config('app_secret_android');
//         } elseif ($client == self::CLIENT_IPHONE) {
//             $this->app_key = ecjia::config('app_key_iphone');
//             $this->app_secret = ecjia::config('app_secret_iphone');
//         } elseif ($client == self::CLIENT_IPAD) {
//             $this->app_key = ecjia::config('app_key_ipad');
//             $this->app_secret = ecjia::config('app_secret_ipad');
//         }
        return $this;
    }
    
    public function set_field(array $field) {
        $this->custom_fields = $field;
        return $this;
    }
   
     /** 发送广播消息
      *
      * @access  public
      * @param   string  $msg            发送的消息内容
      * @param   string  $description    用于识别和查找信息使用
      * @param   integer $template       消息模板ID
      * @param   integer $priority       1 优先级高，立即发送， 0 优先级低的异步发送
      */
    public function broadcast_send($description, $msg, $template = 0, $priority = 1) {
        $notification = new push_notification($this->app_key, $this->app_secret);
        $notification->addContent($description, $msg);
        $notification->addField($this->custom_fields);
        if ($this->client == self::CLIENT_ANDROID) {
            $reponse = $notification->sendAndroidBroadcast();
        } else {
            $reponse = $notification->sendiOSBroadcast();
        }
        
        if (is_ecjia_error($reponse)) {
            return $reponse;
        }

        $reponse_data = json_decode($reponse, true);
        
        if ($this->custom_fields) {
            $extradata['extra_fields'] = $this->custom_fields;
        } else {
            $extradata = null;
        }
        
        //插入数据库记录
        //设备token、设备客户端，模板id，消息描述，消息内容，添加消息时间
        $data = array(
        	'device_token'      => 'broadcast',
        	'device_client'		=> $this->client,
            'app_id'            => $this->app_id,
            'template_id'       => $template,
            'title'             => $description,
            'content'           => $msg,
            'add_time'          => RC_Time::gmtime(),
            'extradata'         => serialize($extradata),
        );
        
        if ($priority) {
            $data['push_time'] = RC_Time::gmtime();
            $data['push_count'] = 1;
        }
        
        if ($reponse_data['ret'] == 'SUCCESS') {
            $data['in_status'] = 1;
            $result = true;
        } else {
            $data['in_status'] = 0;
            $result = new ecjia_error('push_send_error', $reponse_data['data']);
        }
        $this->db->insert($data);
        
        return $result;
    }
    
    
    /** 发送短消息
     *
     * @access  public
     * @param   string  $device_token   要发送到设备token，必须是由客户端采集上来的正确token
     * @param   string  $msg            发送的消息内容
     * @param   string  $description    用于识别和查找信息使用
     * @param   integer $template       消息模板ID
     * @param   integer $priority       1 优先级高，立即发送， 0 优先级低的异步发送
     */
    public function send($device_token, $description, $msg, $template, $priority = 1) {
        $notification = new push_notification($this->app_key, $this->app_secret);
        $notification->addContent($description, $msg);
        $notification->addDeviceToken($device_token);
        $notification->addField($this->custom_fields);
        if ($this->client == self::CLIENT_ANDROID) {
            $reponse = $notification->sendAndroidUnicast();
        } else {
            $reponse = $notification->sendiOSUnicast();
        }
        
        if (is_ecjia_error($reponse)) {
            return $reponse;
        }
    
        $reponse_data = json_decode($reponse, true);
    
        if ($this->custom_fields) {
            $extradata['extra_fields'] = $this->custom_fields;
        } else {
            $extradata = null;
        }
        
        //插入数据库记录
        //设备token、设备客户端，模板id，消息描述，消息内容，添加消息时间
        $data = array(
            'device_token'      => $device_token,
        	'device_client'		=> $this->client,
            'app_id'            => $this->app_id,
            'template_id'       => $template,
            'title'             => $description,
            'content'           => $msg,
            'add_time'          => RC_Time::gmtime(),
            'extradata'         => serialize($extradata),
        );
    
        if ($priority) {
            $data['push_time'] = RC_Time::gmtime();
            $data['push_count'] = 1;
        }
    
        if ($reponse_data['ret'] == 'SUCCESS') {
            $data['in_status'] = 1;
            $result = true;
        } else {
            $data['in_status'] = 0;
            $result = new ecjia_error('push_send_error', $reponse_data['data']);
        }
        $this->db->insert($data);
    
        return $result;
    }
    
    /**
     * 当消息推送失败时，可重新推送此消息
     */
    public function resend($message_id) {
        $row = $this->db->find(array('message_id' => $message_id));
        if (empty($row)) {
            return new ecjia_error('not_found_message_id', __('没发找到此消息记录'));
        }
        if ($this->app_id != $row['app_id']) {
            return new ecjia_error('not_found_app_id', __('没发找到此消息记录'));
        }
        if ($row['extradata']) {
            $extradata = unserialize($row['extradata']);
        }

        $notification = new push_notification($this->app_key, $this->app_secret);
        $notification->addContent($row['title'], $row['content']);
        if ($extradata['extra_fields']) {
            $notification->addField($extradata['extra_fields']);
        }
        
        if ($this->client == self::CLIENT_ANDROID) {
            if ($row['device_token'] == 'broadcast') {
                $reponse = $notification->sendAndroidBroadcast();
            } else {
                $notification->addDeviceToken($row['device_token']);
                $reponse = $notification->sendAndroidUnicast();
            }
        } else {
            if ($row['device_token'] == 'broadcast') {
                $reponse = $notification->sendiOSBroadcast();
            } else {
                $notification->addDeviceToken($row['device_token']);
                $reponse = $notification->sendiOSUnicast();
            }
        }
        
        if (is_ecjia_error($reponse)) {
            return $reponse;
        }
        
        $reponse_data = json_decode($reponse, true);
        
        $data = array(
            'push_count'    => $row['push_count'] + 1,
            'push_time'     => RC_Time::gmtime(),
        );
        
        if ($reponse_data['ret'] == 'SUCCESS') {
            $data['in_status'] = 1;
            $result = true;
        } else {
            $data['in_status'] = 0;
            $result = new ecjia_error('push_send_error', $reponse['data']);
        }
        
        $this->db->where(array('message_id' => $message_id))->update($data);
        
        return $result;
    }
    
    /**
     * 批量重新发送，需要传数组
     * @param array $smsids
     */
    public function batch_resend($message_ids) {
        if (!is_array($message_ids)) {
            return new ecjia_error('invalid_argument', __('无效参数'));
        }
        
        $result = array();
        foreach ($message_ids as $key => $message_id) {
            $result[$key] = $this->resend($message_id);
        }
        
        return $result;
    }
}

// end