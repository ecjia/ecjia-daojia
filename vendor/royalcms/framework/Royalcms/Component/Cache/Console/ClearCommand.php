<?php 

namespace Royalcms\Component\Cache\Console;

use Royalcms\Component\Console\Command;
use Royalcms\Component\Cache\CacheManager;
use Royalcms\Component\Filesystem\Filesystem;
use Symfony\Component\Console\Input\InputArgument;

class ClearCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'cache:clear';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = "Flush the application cache";

	/**
	 * The cache manager instance.
	 *
	 * @var \Royalcms\Component\Cache\CacheManager
	 */
	protected $cache;

	/**
	 * The file system instance.
	 *
	 * @var \Royalcms\Component\Filesystem\Filesystem
	 */
	protected $files;

	/**
	 * Create a new cache clear command instance.
	 *
	 * @param  \Royalcms\Component\Cache\CacheManager  $cache
	 * @param  \Royalcms\Component\Filesystem\Filesystem  $files
	 * @return void
	 */
	public function __construct(CacheManager $cache, Filesystem $files)
	{
		parent::__construct();

		$this->cache = $cache;
		$this->files = $files;
	}

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function fire()
	{
	    $storeName = $this->argument('store');
	    
	    $this->royalcms['events']->fire('cache:clearing', [$storeName]);
	    
	    $this->cache->store($storeName)->flush();
	    
	    $this->royalcms['events']->fire('cache:cleared', [$storeName]);
	    
        //@TODO:
		$this->files->delete($this->royalcms['config']['system.manifest'].'/services.json');

		$this->info('Application cache cleared!');
	}
	
	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
	    return [
	        ['store', InputArgument::OPTIONAL, 'The name of the store you would like to clear.'],
	    ];
	}

}
