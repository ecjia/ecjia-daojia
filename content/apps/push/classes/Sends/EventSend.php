<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-03-12
 * Time: 09:29
 */

namespace Ecjia\App\Push\Sends;

use Ecjia\App\Push\PushContent;
use Ecjia\App\Push\PushManager;
use ecjia_error;

class EventSend
{

    /**
     * @var PushManager
     */
    protected $push;

    /**
     * @var array
     */
    protected $args;

    protected $plugin = 'push_umeng';

    public function __construct(PushManager $push, array $args)
    {
        $this->push = $push;
        $this->args = $args;
    }

    /**
     * @return ecjia_error | \Royalcms\Component\Support\Collection
     */
    public function send()
    {

        list($template_var, $extended_field) = $this->args;

        //发送
        $template = $this->push->getTemplateModel()->getTemplateByCode($this->push->getEvent()->getCode(), $this->plugin);
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
        $content->setSound($this->push->getEvent()->getSound());
        $content->setMutableContent($this->push->getEvent()->getMutableContent());

        $user = $this->push->getPushUser();
        $devices = $this->push->getPushUser()->getDevices(7);

        $result = $devices->map(function ($item) use ($content, $template, $user) {
            $data['device'] = $item;
            $data['content'] = $content;
            $data['user'] = $user;
            $data['result'] = (new SingleSend($this->push, $this->args))->send($template, $item, $content);

            if (is_ecjia_error($data['result'])) {
                ecjia_log_notice($data['result']->get_error_message(), $data, 'push');
            }

            return $data;
        });


        return $result;
    }


}