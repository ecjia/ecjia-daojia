<?php

namespace Royalcms\Component\Sms;

use RC_Hook;

class Factory
{
    protected $royalcms;

    public function __construct($royalcms)
    {
        $this->royalcms = $royalcms;
    }

    public function getFactories()
    {
        $agents = $this->royalcms['config']['sms::sms.agents'];

        $factories = [];

        foreach ($agents as $key => $value) {
            $factories[$key] = __NAMESPACE__ . '\Agents\\' . $value['executableFile'];
        }

        return RC_Hook::apply_filters('royalcms_sms_agent_filter', $factories);
    }
}
