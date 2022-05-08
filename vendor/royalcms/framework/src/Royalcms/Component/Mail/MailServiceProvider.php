<?php

namespace Royalcms\Component\Mail;


class MailServiceProvider extends \Illuminate\Mail\MailServiceProvider
{

    /**
     * The application instance.
     *
     * @var \Royalcms\Component\Contracts\Foundation\Royalcms
     */
    protected $royalcms;

    /**
     * Create a new service provider instance.
     *
     * @param  \Royalcms\Component\Contracts\Foundation\Royalcms  $royalcms
     * @return void
     */
    public function __construct($royalcms)
    {
        parent::__construct($royalcms);

        $this->royalcms = $royalcms;

    }

    /**
     * Register the Swift Transport instance.
     *
     * @return void
     */
    protected function registerIlluminateMailer()
    {
        $this->royalcms->singleton('mail.manager', function ($royalcms) {
            return new MailManager($royalcms);
        });

        $this->royalcms->bind('mailer', function ($royalcms) {
            return $royalcms->make('mail.manager')->mailer();
        });
    }

}
