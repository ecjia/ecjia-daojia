<?php namespace Royalcms\Component\Foundation;

use Royalcms\Component\Console\Royalcmd as ConsoleApplication;

class Royalcmd {

	/**
	 * The application instance.
	 *
	 * @var \Royalcms\Component\Foundation\Royalcms
	 */
	protected $royalcms;

	/**
	 * The Artisan console instance.
	 *
	 * @var  \Royalcms\Component\Console\Royalcmd
	 */
	protected $royalcmd;

	/**
	 * Create a new Artisan command runner instance.
	 *
	 * @param  \Royalcms\Component\Foundation\Royalcms  $royalcms
	 * @return void
	 */
	public function __construct(Royalcms $royalcms)
	{
		$this->royalcms = $royalcms;
	}

	/**
	 * Get the Artisan console instance.
	 *
	 * @return \Royalcms\Component\Console\Royalcmd
	 */
	protected function getRoyalcmd()
	{
		if ( ! is_null($this->royalcmd)) return $this->royalcmd;

		$this->royalcms->loadDeferredProviders();

		$this->royalcmd = ConsoleApplication::make($this->royalcms);

		return $this->royalcmd->boot();
	}

	/**
	 * Dynamically pass all missing methods to console Artisan.
	 *
	 * @param  string  $method
	 * @param  array   $parameters
	 * @return mixed
	 */
	public function __call($method, $parameters)
	{
		return call_user_func_array(array($this->getArtisan(), $method), $parameters);
	}

}
