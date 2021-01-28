<?php

namespace Royalcms\Component\Log;


class LogServiceProvider extends \Illuminate\Log\LogServiceProvider
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
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
	    parent::register();

        $this->registerLogStore();

        $this->registerLogSetup();
	}


    protected function registerLogStore()
    {
        $this->royalcms->singleton('log.store', function($royalcms) {
            return new MultiFileLogger(
                $royalcms['files'], storage_path('logs/')
            );
        });
    }


    protected function registerLogSetup()
    {
        // If the setup Closure has been bound in the container, we will resolve it
        // and pass in the logger instance. This allows this to defer all of the
        // logger class setup until the last possible second, improving speed.
        if (isset($this->royalcms['log.setup'])) {
            call_user_func($this->royalcms['log.setup'], $this->royalcms['log']);
        }
    }

}
