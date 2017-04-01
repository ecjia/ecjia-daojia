<?php namespace Royalcms\Component\Foundation\Console;

use Royalcms\Component\Console\Command;

class ClearCompiledCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'clear-compiled';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = "Remove the compiled class file";

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function fire()
	{
		if (file_exists($path = $this->royalcms['path.base'].'/bootstrap/compiled.php'))
		{
			@unlink($path);
		}

		if (file_exists($path = $this->royalcms['path.storage'].'/meta/services.json'))
		{
			@unlink($path);
		}
	}

}
