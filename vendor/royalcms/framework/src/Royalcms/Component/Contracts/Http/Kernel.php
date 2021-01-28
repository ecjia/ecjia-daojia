<?php

namespace Royalcms\Component\Contracts\Http;

interface Kernel extends \Illuminate\Contracts\Http\Kernel
{

    /**
     * Get the Royalcms application instance.
     *
     * @return \Royalcms\Component\Contracts\Foundation\Royalcms
     */
    public function getRoyalcms();

}
