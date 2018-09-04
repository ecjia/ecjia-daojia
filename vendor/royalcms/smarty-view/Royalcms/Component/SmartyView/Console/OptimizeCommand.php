<?php

namespace Royalcms\Component\SmartyView\Console;

use Smarty;
use Royalcms\Component\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Royalcms\Component\Config\Repository as ConfigContract;

/**
 * Class OptimizeCommand
 *
 */
class OptimizeCommand extends Command
{
    /** @var Smarty */
    protected $smarty;

    /** @var ConfigContract */
    protected $config;

    /**
     * @param Smarty         $smarty
     * @param ConfigContract $config
     */
    public function __construct(Smarty $smarty, ConfigContract $config)
    {
        parent::__construct();
        $this->smarty = $smarty;
        $this->config = $config;
    }

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'smarty:optimize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'compiles all known templates';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        $configureFileExtension = $this->config->get('smarty.extension', 'tpl');
        $fileExtension = (is_null($this->option('extension')))
            ? $configureFileExtension : $this->option('extension');
        ob_start();
        $compileFiles = $this->smarty->compileAllTemplates(
            $fileExtension, $this->forceCompile()
        );
        $contents = ob_get_contents();
        ob_get_clean();
        $this->info("{$compileFiles} template files recompiled");
        $this->comment(str_replace("<br>", "\n", trim($contents)));
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
            array('extension', 'e', InputOption::VALUE_OPTIONAL, 'specified smarty file extension'),
            array('force', null, InputOption::VALUE_NONE, 'compiles template files found in views directory'),
        );
    }

    /**
     * @return bool
     */
    protected function forceCompile()
    {
        if ($this->option('force')) {
            return true;
        }
        return false;
    }
}
