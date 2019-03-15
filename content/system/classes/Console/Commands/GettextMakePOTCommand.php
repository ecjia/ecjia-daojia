<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019/1/14
 * Time: 15:34
 */

namespace Ecjia\System\Console\Commands;

use Royalcms\Component\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Ecjia\System\Admins\Gettext\Console\MakePOT;

// run the CLI only if the file
// wasn't included
class GettextMakePOTCommand extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'ecjia:gettext-makepot';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Generate POT file from the files in DIRECTORY";


    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        //忽略内存大小限制
        ini_set('memory_limit',          -1);

        $makepot = new MakePOT($this);

        if (
            empty($this->argument('project'))
            || empty($this->argument('directory'))
            || ! in_array($this->argument('project'), $makepot->getProjects())
        ) {
            $makepot->usage();
        }

        $instance = $makepot->getProjectInstance($this->argument('project'));

        $res = $instance->make(realpath($this->argument('directory')), $this->argument('output'));

        if (false === $res) {
            $this->error("Couldn't generate POT file!");
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
            ['project', InputArgument::OPTIONAL, 'Available projects'],
            ['directory', InputArgument::OPTIONAL, 'Generate POT file from the files in DIRECTORY.'],
            ['output', InputArgument::OPTIONAL, 'Output file to path.'],
        ];
    }


}