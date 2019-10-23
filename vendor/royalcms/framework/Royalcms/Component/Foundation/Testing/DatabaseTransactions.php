<?php

namespace Royalcms\Component\Foundation\Testing;

trait DatabaseTransactions
{
    /**
     * @before
     */
    public function beginDatabaseTransaction()
    {
        $this->royalcms->make('db')->beginTransaction();

        $this->beforeApplicationDestroyed(function () {
            $this->royalcms->make('db')->rollBack();
        });
    }
}
