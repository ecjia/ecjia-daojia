<?php

namespace Royalcms\Component\Foundation\Console;

use PhpParser\Lexer;
use PhpParser\Parser;
use Royalcms\Component\Console\Command;
use Royalcms\Component\Foundation\Optimize\ClassPreloader;
use Royalcms\Component\Foundation\Composer;
use ClassPreloader\Parser\DirVisitor;
use ClassPreloader\Parser\FileVisitor;
use ClassPreloader\Parser\NodeTraverser;
use ClassPreloader\Exceptions\SkipFileException;
use Symfony\Component\Console\Input\InputOption;
use PhpParser\PrettyPrinter\Standard as PrettyPrinter;
use ClassPreloader\Exceptions\VisitorExceptionInterface;

class OptimizeCompileCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'optimize:compile';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Optimize the framework for better performance';

    /**
     * The composer instance.
     *
     * @var \Royalcms\Component\Foundation\Composer
     */
    protected $composer;

    /**
     * The class Pre Loader instance.
     *
     * @var \Royalcms\Component\Foundation\Composer
     */
    protected $classPreLoader;

    /**
     * Create a new optimize command instance.
     *
     * @param  \Royalcms\Component\Foundation\Composer  $composer
     * @return void
     */
    public function __construct(Composer $composer, ClassPreloader $classPreLoader)
    {
        parent::__construct();

        $this->composer = $composer;

        $this->classPreLoader = $classPreLoader;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->info('Generating optimized class loader');

        if ($this->option('psr')) {
            $this->composer->dumpAutoloads();
        } else {
            $this->composer->dumpOptimized();
        }

        if ($this->option('force') || ! $this->royalcms['config']['system.debug']) {
            $this->info('Compiling common classes');
            $this->classPreLoader->compile();
        } else {
            $this->call('clear-compiled');
        }
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['force', null, InputOption::VALUE_NONE, 'Force the compiled class file to be written.'],

            ['psr', null, InputOption::VALUE_NONE, 'Do not optimize Composer dump-autoload.'],
        ];
    }
}
