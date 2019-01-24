<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019/1/14
 * Time: 15:47
 */

namespace Ecjia\System\Console\Commands;

use Symfony\Component\Console\Input\InputArgument;
use Royalcms\Component\Console\Command;
use Ecjia\System\Admins\Gettext\Console\NotGettexted;

// run the CLI only if the file
// wasn't included
class GettextCommentCommand extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'ecjia:gettext-comment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Extracts and replaces strings, which cannot be gettexted";


    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        $not_gettexted = new NotGettexted($this);

        $cmd = $this->argument('cmd');

        if (empty($cmd) || !in_array($cmd, array_keys($not_gettexted->getCommands())) ) {
            $not_gettexted->usage();
        }

        $commands = $not_gettexted->getCommands();

        $outputfile = $this->argument('outputfile');
        $inputfiles = $this->argument('inputfiles');

        call_user_func_array(array($this, $commands[$cmd]), array($outputfile, $inputfiles));
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['cmd', InputArgument::OPTIONAL, 'The command must is <extract> or <replace>'],
            ['outputfile', InputArgument::OPTIONAL, 'POTFILE or MOFILE.'],
            ['inputfiles', InputArgument::IS_ARRAY, 'Input PHPFILES.'],
        ];
    }

}