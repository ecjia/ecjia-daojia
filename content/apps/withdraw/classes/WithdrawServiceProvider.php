<?php

namespace Ecjia\App\Withdraw;

use Royalcms\Component\App\AppParentServiceProvider;

class WithdrawServiceProvider extends AppParentServiceProvider
{

    public function boot()
    {
        $this->package('ecjia/app-withdraw');
    }

    public function register()
    {

    }

}
