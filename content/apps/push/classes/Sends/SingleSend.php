<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-03-12
 * Time: 13:36
 */

namespace Ecjia\App\Push\Sends;

use ecjia_error;
use Ecjia\App\Push\PushSend;
use Ecjia\App\Push\PushManager;
use RC_Hook;

class SingleSend
{

    /**
     * @var PushManager
     */
    protected $push;

    protected $plugin = 'push_umeng';

    public function __construct(PushManager $push, array $args)
    {

        $this->push = $push;
        $this->args = $args;

    }


    public function send($template, $item, $content)
    {
        list($template_var, $extended_field) = $this->args;

        $item = RC_Hook::apply_filters('push_event_send_before', $item, $template_var, $extended_field);
        if (is_ecjia_error($item))
        {
            return $item;
        }

        try {
            $client = $item['device_client'];

            $push_umeng = $this->push->getPushUser()->getClientOptions($item['device_code'], $this->plugin);

            if (empty($push_umeng)) {
                return new ecjia_error('push_meng_config_not_found', __('APP推送配置信息不存在', 'push'));
            }

            $debug          = $push_umeng['environment'] == 'develop' ? true : false;
            $key            = $push_umeng['app_key'];
            $secret         = $push_umeng['app_secret'];
            $device_token   = $item['device_token'];

            $pushSend = new PushSend($key, $secret, $debug);
            $pushSend->setPushContent($content);
            $pushSend->setDeviceToken($device_token);
            $pushSend->setClient($client);
            $pushSend->setCustomFields($extended_field);
            $result = $pushSend->send();

            /**
             * 重新发送消息后做什么，过滤器
             * @param array $result   推送结果
             * @param array $item  推送的消息数据模型对象
             * @param array $template_var 模板变量
             * @param array $extended_field   扩展字段
             * @return array $result
             */
            $result = RC_Hook::apply_filters('push_event_send_after', $result, $item, $template_var, $extended_field);

            $this->push->addRecord($item['device_code'], $item['device_client'], $item['device_token'], $template['template_subject'], $template['template_id'], $template_var, $extended_field, $content->getContent(), $this->plugin, $result);

            if (is_ecjia_error($result)) {
                return $result;
            }

            return true;

        } catch (\InvalidArgumentException $e) {

            return new ecjia_error($e->getCode(), $e->getMessage(), $e);

        }

    }

}