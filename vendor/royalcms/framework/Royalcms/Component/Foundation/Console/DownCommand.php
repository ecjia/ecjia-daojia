<?php namespace Royalcms\Component\Foundation\Console;

use Royalcms\Component\Console\Command;

class DownCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'down';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = "Put the application into maintenance mode";

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function fire()
	{
		touch($this->royalcms['path.storage'].'/meta/down');

		$this->comment('Application is now in maintenance mode.');
	}

}
