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

namespace Ecjia\App\Sms;

use Royalcms\Component\Foundation\Object;
use Ecjia\App\Sms\Models\SmsTemplateModel;
use Ecjia\App\Sms\Models\SmsSendlistModel;
use Ecjia\App\Sms\EventAbstract;
use ecjia_error;
use RC_Time;
use RC_Validator;
use RC_Hook;

class SmsManager extends Object
{
        
    protected $model;
    protected $event;
    protected $channel;
    
    public function setTemplateModel(SmsTemplateModel $model)
    {
        $this->model = $model;
        return $this;
    }
    
    public function getTemplateModel()
    {
        return $this->model;
    }
    
    public function setEvent(EventAbstract $event)
    {
        $this->event = $event;
        return $this;
    }
    
    public function getEvent()
    {
        return $this->event;
    }
    
    public function setChannel($channel)
    {
        $this->channel = $channel;
        
        return $this;
    }
    
    public function getChannel()
    {
        return $this->channel;
    }
    
    public function beforeSend($beforeSend, $mobile, array $template_var)
    {
        //发送前处理...
        //验证数据
        $messages = [
            'required'  => __('手机号不能为空'),
            'regex'     => __('必须输入合法的手机号'),
            ];
        $validator = RC_Validator::make(array('mobile' => $mobile), [
            'mobile'     => 'required|regex:/^1[34578][0-9]{9}$/',
        ], $messages);
        if ($validator->fails()) {
            $errors = $validator->errors();
            $error = $errors->first('mobile');
            return new ecjia_error('sms_failed_to_before_send', $error);
        }

        return true;
    }
    
    /** 发送短消息
     *
     * @access  public
     * @param   string  $mobile         要发送到手机号码，传的值是一个正常的手机号
     * @param   string  $template       短信模板code
     * @param   string  $template_var    短信模板变量，数组格式
     */
    public function send($mobile, array $template_var)
    {
        RC_Hook::add_filter('sms_event_send_before', array($this, 'beforeSend'), 10, 3);
        
        $beforeSend = true;
        $beforeSend = RC_Hook::apply_filters('sms_event_send_before', $beforeSend, $mobile, $template_var);
        if (is_ecjia_error($beforeSend))
        {
            return $beforeSend;
        }
        else 
        {
            $sms = new SmsPlugin();
            if (is_null($this->channel)) {
                $handler = $sms->defaultChannel();
            } else {
                $handler = $sms->channel($this->channel);
            }

            $plugin = $handler->getCode();
            //发送
            $template = $this->model->getTemplateByCode($this->event->getCode(), $plugin);
            if (empty($template))
            {
                return new ecjia_error('sms_template_not_exist', __('短信模板不存在'));
            }
            
            $handler->setContent($template['template_content']);
            $handler->setContentByCustomVar($template_var);
            $handler->setTemplateVar($template_var);
            $handler->setTemplateId($template['template_id']);
            $handler->setSignName($template['sign_name']);
            $result = $handler->send($mobile);
            
            /**
             * 发送消息后做什么，过滤器
             * @param $result       发送结果
             * @param $mobile       手机号
             * @param $template_var 模板变量
             * @return $result
             */
            $result = RC_Hook::apply_filters('sms_event_send_after', $result, $mobile, $template_var);
            
            $this->addRecord($mobile, $template, $template_var, $handler->getContent(), $plugin, $result);
            
            if (is_ecjia_error($result)) {
                return $result;
            }
            
            return true;
        }
    }
    
    /**
     * 当短信发送失败时，可重新发送此条短信
     */
    public function resend($smsid)
    {
        $sms = SmsSendlistModel::find($smsid);
        if (empty($sms)) {
            return new ecjia_error('not_found_smsid', RC_Lang::get('sms::sms.not_found_smsid'));
        }
    
        $mobile         = $sms->mobile;
        $template_var   = unserialize($sms->sms_params);
        $template_id    = $sms->template_id;
        $template_content    = $sms->sms_content;
        $sign_name      = $sms->sign_name;
        $plugin         = $sms->channel_code;
    
        $beforeSend = true;
        $beforeSend = RC_Hook::apply_filters('sms_resend_send_before', $beforeSend, $mobile, $template_var);
        if (is_ecjia_error($beforeSend))
        {
            return $beforeSend;
        }
        else
        {
            $handler = with(new SmsPlugin())->channel($plugin);
            
            $handler->setContent($template_content);
            $handler->setTemplateVar($template_var);
            $handler->setTemplateId($template_id);
            $handler->setSignName($sign_name);
            $result = $handler->send($mobile);
            
            /**
             * 重新发送消息后做什么，过滤器
             * @param $result       推送结果
             * @param $mobile       手机号
             * @param $template_var 模板变量
             * @return $result
             */
            $result = RC_Hook::apply_filters('sms_resend_send_after', $result, $mobile, $template_var);
            
            $this->updateRecord($sms, $result);
            
            if (is_ecjia_error($result)) {
                return $result;
            }
            
            return true;
        }
    
    }    
    
    public function addRecord($mobile, $template, $template_var, $msg, $plugin, $result, $priority = 1)
    {
    	if (is_ecjia_error($result)) 
    	{
    	    $error_data = $result->get_error_data();
    	    $msgid = $error_data->getMsgid();
    	} 
    	else 
    	{
    	    $msgid = $result->getMsgid();
    	}
    	
        $data = array(
            'mobile'        => $mobile,//手机号码
            'template_id'   => $template['template_id'],//短信模板ID
            'sms_content'   => $msg,//短信内容
            'priority'      => $priority,//优先级高低（0，1）
            'error'         => 0,//是否出错（0，1）
            'last_send'     => RC_Time::gmtime(),//最后发送时间
        	'sms_params'	=> serialize($template_var),//模板内的变量参数，序列化存储
        	'msgid'         => $msgid,//短信厂商的消息ID
        	'sign_name'		=> $template['sign_name'],//短信签名
        	'channel_code'	=> $plugin//短信渠道代码
        );
        
        if (is_ecjia_error($result)) 
        {
            $data['error']  = 1;
            $data['last_error_message'] = $result->get_error_message();
        }
        SmsSendlistModel::create($data);
    }
    
    /**
     * 更新发送记录
     * @param \Ecjia\App\Sms\Models\SmsSendlistModel $sms
     * @param array | ecjia_error $result
     */
    public function updateRecord($sms, $result)
    {
        if (is_ecjia_error($result))
        {
            $error_data = $result->get_error_data();
            $msgid = $error_data->getMsgid();

            $sms->error = 1;
            $sms->last_error_message = $result->get_error_message();
        }
        else
        {
            $msgid = $result->getMsgid();

            $sms->error = 0;
        }
        
        $sms->priority = 1;
        $sms->msgid = $msgid;
        $sms->last_send = RC_Time::gmtime(); //最后发送时间
        
        $sms->save();
    }
    
    /**
     * 查询账户余额
     */
    public function balance($channel)
    {
        $sms = new SmsPlugin();
        $handler = $sms->channel($channel);
        $result = $handler->balance();
        
        return $result;
    }

}