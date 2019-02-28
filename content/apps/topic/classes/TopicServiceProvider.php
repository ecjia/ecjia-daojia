<?php

namespace Ecjia\App\Topic;

use Royalcms\Component\App\AppParentServiceProvider;

class TopicServiceProvider extends AppParentServiceProvider
{

    public function boot()
    {
        $this->package('ecjia/app-topic');
    }

    public function register()
    {

    }

}
