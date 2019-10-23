<?php

use Royalcms\Component\Contracts\Encryption\Encrypter as EncrypterContract;

class RoyalcmsQueueClosure
{
    /**
     * The encrypter instance.
     *
     * @var \Royalcms\Component\Contracts\Encryption\Encrypter
     */
    protected $crypt;

    /**
     * Create a new queued Closure job.
     *
     * @param  \Royalcms\Component\Contracts\Encryption\Encrypter  $crypt
     * @return void
     */
    public function __construct(EncrypterContract $crypt)
    {
        $this->crypt = $crypt;
    }

    /**
     * Fire the Closure based queue job.
     *
     * @param  \Royalcms\Component\Contracts\Queue\Job  $job
     * @param  array  $data
     * @return void
     */
    public function fire($job, $data)
    {
        $closure = unserialize($this->crypt->decrypt($data['closure']));

        $closure($job);
    }
}
