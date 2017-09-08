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

namespace Ecjia\App\Push;

use Royalcms\Component\Foundation\Object;
use Ecjia\App\Push\Models\PushTemplateModel;
use Ecjia\App\Push\Models\PushMessageModel;
use ecjia_error;
use RC_Time;
use RC_Hook;

class PushManager extends Object
{
        
    protected $model;
    protected $event;
    protected $user;
    protected $content;
    
    /**
     * 设置用户对象
     * @param \Ecjia\App\Push\PushContent $content
     * @return \Ecjia\App\Push\PushManager
     */
    public function setPushContent($content)
    {
        $this->content = $content;
        
        return $this;
    }
    
    /**
     * 获取用户对象
     * @return \Ecjia\App\Push\PushContent
     */
    public function getPushContent()
    {
        return $this->content;
    }
    
    /**
     * 设置用户对象
     * @param \Ecjia\App\Mobile\User $user
     * @return \Ecjia\App\Push\PushManager
     */
    public function setPushUser($user)
    {
        $this->user = $user;

        return $this;
    }
    
    /**
     * 获取用户对象
     * @return \Ecjia\App\Mobile\User
     */
    public function getPushUser()
    {
        return $this->user;
    }
    
    /**
     * 设置模板模型对象
     * @param PushTemplateModel $model
     * @return \Ecjia\App\Push\PushManager
     */
    public function setTemplateModel(PushTemplateModel $model)
    {
        $this->model = $model;
        return $this;
    }
    
    /**
     * 获取模板模型对象
     * @return PushTemplateModel
     */
    public function getTemplateModel()
    {
        return $this->model;
    }
    
    /**
     * 设置事件对象
     * @param EventAbstract $event
     * @return \Ecjia\App\Push\PushManager
     */
    public function setEvent(EventAbstract $event)
    {
        $this->event = $event;
        return $this;
    }
    
    /**
     * 获取事件对象
     * @return EventAbstract
     */
    public function getEvent()
    {
        return $this->event;
    }
    
    /** 发送短消息
     *
     * @access  public
     * @param   string  $template_var     消息模板变量，数组格式
     * @param   string  $extended_field   消息模板扩展字段，数组格式
     */
    public function send(array $template_var = [], array $extended_field = [])
    {
        $beforeSend = true;
        $beforeSend = RC_Hook::apply_filters('push_event_send_before', $beforeSend, $template_var, $extended_field);
        if (is_ecjia_error($beforeSend))
        {
            return $beforeSend;
        }
        else 
        {
            $plugin = 'push_umeng';

            //发送
            $template = $this->model->getTemplateByCode($this->event->getCode(), $plugin);
            if (empty($template))
            {
                return new ecjia_error('push_template_not_exist', __('消息模板不存在'));
            }
            
            $content = new PushContent();
            $content->setContent($template['template_content']);
            $content->setContentByCustomVar($template_var);
            $content->setTemplateVar($template_var);
            $content->setTemplateId($template['template_id']);
            $content->setSubject($template['template_subject']);
            
            $error = new ecjia_error();
            
            $user = $this->user;
            $devices = $this->user->getDevices();
            $devices->each(function ($item) use ($content, $template, $user, $plugin, $error, $template_var, $extended_field) {

                $client = $item['device_client'];

                $push_umeng = $user->getClientOptions($item['device_code'], $plugin);
                
                if (empty($push_umeng)) {
                    $error->add('push_meng_config_not_found', 'APP推送配置信息不存在');
                    return ;
                }
                
                $debug          = $push_umeng['environment'] == 'develop' ? true : false;
                $key            = $push_umeng['app_key'];
                $secret         = $push_umeng['app_secret'];
                $device_token   = $item['device_token'];
                
                $push = new PushSend($key, $secret, $debug);
                $push->setPushContent($content);
                $push->setDeviceToken($device_token);
                $push->setClient($client);
                $push->setCustomFields($extended_field);
                $result = $push->send();

                /**
                 * 重新发送消息后做什么，过滤器
                 * @param $result   推送结果
                 * @param $item  推送的消息数据模型对象
                 * @param $template_var 模板变量
                 * @param $extended_field   扩展字段
                 * @return $result
                 */
                $result = RC_Hook::apply_filters('push_event_send_after', $result, $item, $template_var, $extended_field);
                
                $this->addRecord($item['device_code'], $item['device_client'], $item['device_token'], $template['template_subject'], $template['template_id'], $template_var, $extended_field, $content->getContent(), $plugin, $result);
                
                if (is_ecjia_error($result)) {
                    $error->add($result->get_error_code(), $result->get_error_message(), $result->get_error_data());
                }
            });
            
            if (count($error->get_error_messages()) > 0) 
            {
                return $error;
            }

            return true;
        }
    }
    
    /**
     * 当消息发送失败时，可重新发送此条消息
     */
    public function resend($messageid)
    {
        $message = PushMessageModel::find($messageid);
        if (empty($message)) {
            return new ecjia_error('not_found_messageid', '没有找到该消息ID');
        }
    
        $plugin         = $message['channel_code'];
        
        $extended_field = unserialize(array_get($message, 'extradata', serialize([])));
        $template_var   = unserialize(array_get($message, 'content_params', serialize([])));
    
        $beforeSend = true;
        $beforeSend = RC_Hook::apply_filters('push_resend_send_before', $beforeSend, $template_var, $extended_field);
        if (is_ecjia_error($beforeSend))
        {
            return $beforeSend;
        }
        else
        {
            $client = $message['device_client'];
            
            $client = with(new \Ecjia\App\Mobile\ApplicationFactory)->client($message['device_code']);
            $push_umeng = $client->getOptions($plugin);
            
            if (empty($push_umeng)) {
                return new ecjia_error('push_meng_config_not_found', 'APP推送配置信息不存在');
            }
            
            $debug          = $push_umeng['environment'] == 'develop' ? true : false;
            $key            = $push_umeng['app_key'];
            $secret         = $push_umeng['app_secret'];
            $device_token   = $message['device_token'];
            
            $content = new PushContent();
            $content->setContent($message['content']);
            $content->setTemplateVar($template_var);
            $content->setTemplateId($message['template_id']);
            $content->setSubject($message['title']);

            $push = new PushSend($key, $secret, $debug);
            $push->setPushContent($content);
            $push->setClient($message['device_client']);
            $push->setCustomFields($extended_field);

            if ($device_token == 'broadcast') {
                $result = $push->broadcastSend();
            } else {
                $push->setDeviceToken($message['device_token']);
                $result = $push->send();
            }
            
            
            /**
             * 重新发送消息后做什么，过滤器
             * @param $result   推送结果
             * @param $message  推送的消息数据模型对象
             * @param $template_var 模板变量
             * @param $extended_field   扩展字段
             * @return $result
             */
            $result = RC_Hook::apply_filters('push_resend_send_after', $result, $message, $template_var, $extended_field);
            
            $this->updateRecord($message, $result);
            
            if (is_ecjia_error($result)) {
                return $result;
            }
            
            return true;
        }
    
    }
    
    /**
     * 添加推送记录
     * @param string $device_code
     * @param string $device_client
     * @param string $device_token
     * @param string $template_subject
     * @param string $template_id
     * @param array $template_var
     * @param array $extended_field
     * @param string $msg
     * @param string $plugin
     * @param string $result
     * @param number $priority
     */
    public function addRecord($device_code, $device_client, $device_token, $template_subject, $template_id, $template_var, $extended_field, $msg, $plugin, $result, $priority = 1)
    {
        $data = array(
            'device_code'       => $device_code,
            'device_token'      => $device_token,
            'device_client'     => $device_client,
            
            'title'             => $template_subject,
            'content'           => $msg,//消息内容
            'content_params'    => serialize($template_var),//模板内的变量参数，序列化存储
            
            'add_time'          => RC_Time::gmtime(),
            'extradata'         => serialize($extended_field),

            'template_id'       => $template_id,//短信模板ID

            'priority'          => $priority,//优先级高低（0，1）
            'push_time'         => RC_Time::gmtime(),//最后发送时间
            'push_count'        => 1,

        	'channel_code'	    => $plugin//短信渠道代码
        );

        if (is_ecjia_error($result))
        {
            $data['msgid'] = '';
            $data['in_status'] = 0;
            $data['last_error_message'] = $result->get_error_message();
        }
        else
        {
            $result = json_decode($result, true);
            
            if ($result['ret'] == 'SUCCESS') {
                $status = 1;
            } else {
                $status = 0;
                $data['last_error_message'] = $result->get_error_message();
            } 
            
            $data['in_status'] = $status;
            $data['msgid'] = $result['data']['msg_id'];
        }
        
        PushMessageModel::create($data);
    }
    
    /**
     * 更新发送记录
     * @param \Ecjia\App\Push\Models\PushMessageModel $message
     * @param array | ecjia_error $result
     */
    public function updateRecord($message, $result)
    {
        if (is_ecjia_error($result))
        {
            $message->in_status = 0;
            $message->last_error_message = $result->get_error_message();
        }
        else
        {
            if ($result['ret'] == 'SUCCESS') {
                $status = 1;
            } else {
                $status = 0;
            }
            
            $message->msgid = $result['data']['msg_id'];
            $message->in_status = 1;
        }
        
        $message->push_count = $message->push_count + 1;
        $message->priority = 1;
        $message->push_time = RC_Time::gmtime(); //最后发送时间
        
        $message->save();
    }
    
    
    /**
     * 批量重新发送，需要传数组
     * @param array $message_ids
     */
    public function batchResend(array $message_ids) {
        if (empty($message_ids)) {
            return new ecjia_error('invalid_argument', __('无效参数'));
        }
    
        $result = array();
        collect($message_ids)->each(function ($item, $key) use (& $result) {
            $result[$item] = $this->resend($item);
        });
    
        return $result;
    }

    
    /** 
     * 发送广播消息
     * @access  public
     * @param   string  $device_code    设备代号
     * @param   array   $extended_field  发送的消息内容的扩展字段信息
     * @param   integer $priority       1 优先级高，立即发送， 0 优先级低的异步发送
     */
    public function broadcastSend($device_code, array $extended_field = [], $priority = 1) {
        $beforeSend = true;
        $beforeSend = RC_Hook::apply_filters('push_broadcast_send_before', $beforeSend, $device_code, $extended_field, $priority);
        if (is_ecjia_error($beforeSend))
        {
            return $beforeSend;
        }
        else
        {
            $plugin = 'push_umeng';
            $client = with(new \Ecjia\App\Mobile\ApplicationFactory)->client($device_code);
            $push_umeng = $client->getOptions($plugin);
            
            if (empty($push_umeng)) {
                return new ecjia_error('push_meng_config_not_found', 'APP推送配置信息不存在');
            }
            
            $debug          = $push_umeng['environment'] == 'develop' ? true : false;
            $key            = $push_umeng['app_key'];
            $secret         = $push_umeng['app_secret'];
            
            $device_token   = 'broadcast';
            
            $push = new PushSend($key, $secret, $debug);
            $push->setPushContent($this->content);
            $push->setClient($client->getDeviceClient());
            $push->setCustomFields($extended_field);
            $result = $push->broadcastSend();

            $result = RC_Hook::apply_filters('push_broadcast_send_after', $result, $client, $this->content, $extended_field);
            
            $this->addRecord($device_code, $client->getDeviceClient(), $device_token, $this->content->getSubject(), '', [], $extended_field, $this->content->getContent(), $plugin, $result, $priority);
            
            if (is_ecjia_error($result)) {
                return $result;
            }
            
            return true;
        }
        
    }
    
    /**
     * 发送单播消息
     * @access  public
     * @param   string  $device_code        设备代号
     * @param   string  $device_token       设备token
     * @param   array   $extended_field     发送的消息内容的扩展字段信息
     * @param   integer $priority           1 优先级高，立即发送， 0 优先级低的异步发送
     */
    public function unicastSend($device_code, $device_token, array $extended_field = [], $priority = 1)
    {
        if (empty($device_code)) {
            return new ecjia_error('device_code_not_found', 'Device Code参数必传！');
        }
        
        if (empty($device_token)) {
            return new ecjia_error('device_token_not_found', 'Device Token参数必传！');
        }
        
        $beforeSend = true;
        $beforeSend = RC_Hook::apply_filters('push_unicast_send_before', $beforeSend, $device_code, $extended_field, $priority);
        if (is_ecjia_error($beforeSend))
        {
            return $beforeSend;
        }
        else
        {
            $plugin = 'push_umeng';
            $client = with(new \Ecjia\App\Mobile\ApplicationFactory)->client($device_code);
            $push_umeng = $client->getOptions($plugin);
        
            if (empty($push_umeng)) {
                return new ecjia_error('push_meng_config_not_found', 'APP推送配置信息不存在');
            }
        
            $debug          = $push_umeng['environment'] == 'develop' ? true : false;
            $key            = $push_umeng['app_key'];
            $secret         = $push_umeng['app_secret'];
        
            $push = new PushSend($key, $secret, $debug);
            $push->setPushContent($this->content);
            $push->setClient($client->getDeviceClient());
            $push->setCustomFields($extended_field);
            $push->setDeviceToken($device_token);
            $result = $push->send();
        
            $result = RC_Hook::apply_filters('push_unicast_send_after', $result, $client, $this->content, $extended_field);
        
            $this->addRecord($device_code, $client->getDeviceClient(), $device_token, $this->content->getSubject(), '', [], $extended_field, $this->content->getContent(), $plugin, $result, $priority);
        
            if (is_ecjia_error($result)) {
                return $result;
            }
        
            return true;
        }
    }
    
    /**
     * 发送给指定用户的消息
     * @access  public
     * @param   array   $extended_field     发送的消息内容的扩展字段信息
     * @param   integer $priority           1 优先级高，立即发送， 0 优先级低的异步发送
     */
    public function userSend(array $extended_field = [], $priority = 1)
    {
        $beforeSend = true;
        $beforeSend = RC_Hook::apply_filters('push_user_send_before', $beforeSend, $this->user, $extended_field, $priority);
        if (is_ecjia_error($beforeSend))
        {
            return $beforeSend;
        }
        else
        {
            $plugin = 'push_umeng';
            
            $error = new ecjia_error();
            
            $content = $this->content;
            $user = $this->user;
            $devices = $this->user->getDevices();
            $devices->each(function ($item) use ($content, $user, $plugin, $error, $extended_field, $priority) {
            
                $client = $item['device_client'];
            
                $push_umeng = $user->getClientOptions($item['device_code'], $plugin);
            
                if (empty($push_umeng)) {
                    $error->add('push_meng_config_not_found', 'APP推送配置信息不存在');
                    return ;
                }
            
                $debug          = $push_umeng['environment'] == 'develop' ? true : false;
                $key            = $push_umeng['app_key'];
                $secret         = $push_umeng['app_secret'];
                $device_token   = $item['device_token'];
            
                $push = new PushSend($key, $secret, $debug);
                $push->setPushContent($content);
                $push->setDeviceToken($device_token);
                $push->setClient($client);
                $push->setCustomFields($extended_field);
                $result = $push->send();
            
                /**
                 * 重新发送消息后做什么，过滤器
                 * @param $result   推送结果
                 * @param $item  推送的消息数据模型对象
                 * @param $template_var 模板变量
                 * @param $extended_field   扩展字段
                 * @return $result
                */
                $result = RC_Hook::apply_filters('push_unicast_send_after', $result, $item, $extended_field);
            
                $this->addRecord($item['device_code'], $client, $device_token, $this->content->getSubject(), '', [], $extended_field, $this->content->getContent(), $plugin, $result, $priority);
            
                if (is_ecjia_error($result)) {
                    $error->add($result->get_error_code(), $result->get_error_message(), $result->get_error_data());
                }
            });
            
            if (count($error->get_error_messages()) > 0)
            {
                return $error;
            }
        
            return true;
        }
    }
    
}
