<?php namespace Royalcms\Component\Mail;

use Royalcms\Component\Support\ServiceProvider;
use Swift_Mailer;

class MailServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = true;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$me = $this;

		$this->royalcms->bindShared('mailer', function($royalcms) use ($me)
		{
			$me->registerSwiftMailer();

			// Once we have create the mailer instance, we will set a container instance
			// on the mailer. This allows us to resolve mailer classes via containers
			// for maximum testability on said classes instead of passing Closures.
			$mailer = new Mailer($royalcms['view'], $royalcms['swift.mailer']);

			$mailer->setLogger($royalcms['log'])->setQueue($royalcms['queue']);

			$mailer->setContainer($royalcms);

			// If a "from" address is set, we will set it on the mailer so that all mail
			// messages sent by the applications will utilize the same "from" address
			// on each one, which makes the developer's life a lot more convenient.
			$from = $royalcms['config']['mail.from'];

			if (is_array($from) && isset($from['address']))
			{
				$mailer->alwaysFrom($from['address'], $from['name']);
			}

			// Here we will determine if the mailer should be in "pretend" mode for this
			// environment, which will simply write out e-mail to the logs instead of
			// sending it over the web, which is useful for local dev environments.
			$pretend = $royalcms['config']->get('mail.pretend', false);

			$mailer->pretend($pretend);

			return $mailer;
		});
	}

	/**
	 * Register the Swift Mailer instance.
	 *
	 * @return void
	 */
	public function registerSwiftMailer()
	{
	    $this->royalcms['hook']->do_action('reset_mail_config');
	    
	    $this->royalcms['swift.manager'] = $this->royalcms->share(function($royalcms)
	    {
	        return new MailManager($royalcms);
	    });
	    
		$config = $this->royalcms['config']['mail'];

		$this->registerSwiftTransport($config);

		// Once we have the transporter registered, we will register the actual Swift
		// mailer instance, passing in the transport instances, which allows us to
		// override this transporter instances during app start-up if necessary.
		$this->royalcms['swift.mailer'] = $this->royalcms->share(function($royalcms)
		{
			return new Swift_Mailer($royalcms['swift.transport']);
		});
	}

	/**
	 * Register the Swift Transport instance.
	 *
	 * @param  array  $config
	 * @return void
	 *
	 * @throws \InvalidArgumentException
	 */
	protected function registerSwiftTransport($config)
	{
	    $this->royalcms['swift.transport'] = $this->royalcms->share(function ($royalcms) {
	        return $royalcms['swift.manager']->drive();
	    });
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('mailer', 'swift.manager', 'swift.mailer', 'swift.transport');
	}

}
