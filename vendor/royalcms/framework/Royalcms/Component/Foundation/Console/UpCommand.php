<?php namespace Royalcms\Component\Foundation\Console;

use Royalcms\Component\Console\Command;

class UpCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'up';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = "Bring the application out of maintenance mode";

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function fire()
	{
		@unlink($this->royalcms['path.storage'].'/meta/down');

		$this->info('Application is now live.');
	}

}
