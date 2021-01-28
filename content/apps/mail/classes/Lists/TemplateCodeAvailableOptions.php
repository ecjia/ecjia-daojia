<?php
namespace Ecjia\App\Mail\Lists;

use Ecjia\App\Mail\EventFactory\EventFactory;
use Ecjia\App\Mail\Models\MailTemplateModel;

/**
 * 获取模板code
 * Class TemplateCodeList
 * @package Ecjia\App\Mail\Lists
 */
class TemplateCodeAvailableOptions
{

    public function __invoke()
    {
        $template_code_list = array();

        $factory = new EventFactory();

        $events  = $factory->getEvents();

        $template_codes = MailTemplateModel::mail()->select('template_code', 'template_subject')->pluck('template_code');

        foreach ($events as $event) {
            if (empty($template_codes) || ! in_array($event->getCode(), $template_codes)) {
                $template_code_list[$event->getCode()] = $event->getName() . ' [' . $event->getCode() . ']';
            }
        }

        return $template_code_list;
    }

}