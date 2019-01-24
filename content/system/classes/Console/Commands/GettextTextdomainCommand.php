<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019/1/14
 * Time: 15:07
 */

namespace Ecjia\System\Console\Commands;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Royalcms\Component\Console\Command;
use Ecjia\System\Admins\Gettext\Console\AddTextdomain;

// Run the CLI only if the file wasn't included.
class GettextTextdomainCommand extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'ecjia:gettext-textdomain';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Adds the string <domain> as a last argument to all i18n function calls";


    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        $adddomain = new AddTextdomain($this);

        $instead = $this->option('instead');
        $domain = $this->argument('domain');
        $file = $this->argument('file');

        if (!$instead || !$domain) {
            $adddomain->usage();
        }

        if (empty($instead)) {
            $inplace = false;
        } else {
            $inplace = true;
        }

        if ($inplace && empty($file)) {
            $adddomain->usage();
        }


        if ( is_dir( $file ) ) {
            $directory = new RecursiveDirectoryIterator( $file, RecursiveDirectoryIterator::SKIP_DOTS );
            $files = new RecursiveIteratorIterator( $directory );
            foreach ( $files as $file ) {
                if ( 'php' === $file->getExtension() ) {
                    $adddomain->process_file( $domain, $file->getPathname(), $inplace );
                }
            }
        } else {
            $adddomain->process_file( $domain, $file, $inplace );
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['domain', InputArgument::OPTIONAL, 'plugin file EXT'],
            ['file', InputArgument::OPTIONAL, 'plugin file POT'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['instead', 'i', InputOption::VALUE_NONE, 'Modifies the PHP file in place, instead of printing it to standard output.'],
        ];
    }

}