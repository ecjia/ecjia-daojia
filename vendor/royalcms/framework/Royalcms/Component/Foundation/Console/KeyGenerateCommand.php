<?php namespace Royalcms\Component\Foundation\Console;

use Royalcms\Component\Support\Str;
use Royalcms\Component\Console\Command;
use Royalcms\Component\Filesystem\Filesystem;

class KeyGenerateCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'key:generate';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = "Set the application key";

	/**
	 * Create a new key generator command.
	 *
	 * @param  \Royalcms\Component\Filesystem\Filesystem  $files
	 * @return void
	 */
	public function __construct(Filesystem $files)
	{
		parent::__construct();

		$this->files = $files;
	}

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function fire()
	{
		list($path, $contents) = $this->getKeyFile();

		$key = $this->getRandomKey();

		$contents = str_replace($this->royalcms['config']['system.auth_key'], $key, $contents);

		$this->files->put($path, $contents);

		$this->royalcms['config']['system.auth_key'] = $key;

		$this->info("Application key [$key] set successfully.");
	}

	/**
	 * Get the key file and contents.
	 *
	 * @return array
	 */
	protected function getKeyFile()
	{
		$env = $this->option('env') ? $this->option('env').'/' : '';

		$contents = $this->files->get($path = $this->royalcms['path']."/config/{$env}system.php");

		return array($path, $contents);
	}

	/**
	 * Generate a random key for the application.
	 *
	 * @return string
	 */
	protected function getRandomKey()
	{
		return Str::random(32);
	}

}
