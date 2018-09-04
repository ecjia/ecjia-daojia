<?php

namespace Royalcms\Component\SmartyView\Console;

use Smarty;
use Royalcms\Component\Console\Command;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class ClearCompiledCommand
 *
 */
class ClearCompiledCommand extends Command
{
    /** @var Smarty */
    protected $smarty;

    /**
     * @param Smarty $smarty
     */
    public function __construct(Smarty $smarty)
    {
        parent::__construct();
        $this->smarty = $smarty;
    }

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'smarty:clear-compiled';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove the compiled smarty file';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        $smartyExtension = $this->smarty->ext;
        $class = $smartyExtension->clearCompiledTemplate;
        if ($class->clearCompiledTemplate($this->smarty, $this->option('file'), $this->option('compile_id'))) {
            $this->info('done.');
            return;
        }
        return;
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array(
            array('file', 'f', InputOption::VALUE_OPTIONAL, 'specify file'),
            array('compile_id', 'compile', InputOption::VALUE_OPTIONAL, 'specified compile_id'),
        );
    }
}
