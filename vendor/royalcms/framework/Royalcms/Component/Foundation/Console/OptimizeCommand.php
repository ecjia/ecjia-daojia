<?php namespace Royalcms\Component\Foundation\Console;

use Royalcms\Component\Console\Command;
use Royalcms\Component\Foundation\Composer;
use ClassPreloader\Command\PreCompileCommand;
use Symfony\Component\Console\Input\InputOption;

class OptimizeCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'optimize';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = "Optimize the framework for better performance";

	/**
	 * The composer instance.
	 *
	 * @var \Royalcms\Component\Foundation\Composer
	 */
	protected $composer;

	/**
	 * Create a new optimize command instance.
	 *
	 * @param  \Royalcms\Component\Foundation\Composer  $composer
	 * @return void
	 */
	public function __construct(Composer $composer)
	{
		parent::__construct();

		$this->composer = $composer;
	}

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function fire()
	{
		$this->info('Generating optimized class loader');

		if ($this->option('psr'))
		{
			$this->composer->dumpAutoloads();
		}
		else
		{
			$this->composer->dumpOptimized();
		}

		if ($this->option('force') || ! $this->royalcms['config']['system.debug'])
		{
			$this->info('Compiling common classes');

			$this->compileClasses();
		}
		else
		{
			$this->call('clear-compiled');
		}
	}

	/**
	 * Generate the compiled class file.
	 *
	 * @return void
	 */
	protected function compileClasses()
	{
		$this->registerClassPreloaderCommand();

		$outputPath = $this->royalcms['path.base'].'/bootstrap/compiled.php';

		$this->callSilent('compile', array(
			'--config' => implode(',', $this->getClassFiles()),
			'--output' => $outputPath,
			'--strip_comments' => 1,
		));
		
		//更换站点绝对路径为常量SITE_ROOT
		$output = file_get_contents($outputPath);
		$output = str_replace("'".SITE_ROOT, "SITE_ROOT . '", $output);
		file_put_contents($outputPath, $output);
	}

	/**
	 * Get the classes that should be combined and compiled.
	 *
	 * @return array
	 */
	protected function getClassFiles()
	{
		$royalcms = $this->royalcms;

		$core = require __DIR__.'/Optimize/config.php';

		return array_merge($core, $this->royalcms['config']['compile']);
	}

	/**
	 * Register the pre-compiler command instance with Artisan.
	 *
	 * @return void 
	 */
	protected function registerClassPreloaderCommand()
	{
		$this->getApplication()->add(new PreCompileCommand);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			array('force', null, InputOption::VALUE_NONE, 'Force the compiled class file to be written.'),

			array('psr', null, InputOption::VALUE_NONE, 'Do not optimize Composer dump-autoload.'),
		);
	}

}
