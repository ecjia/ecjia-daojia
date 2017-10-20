<?php

namespace Royalcms\Component\Cron;

use Royalcms\Component\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

class KeygenCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'cron:keygen';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates a key for securing the built in Cron run route';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire() {
        
        
        $length = $this->argument('length');
        if(empty($length)) {
            $length = 32;
        }

        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
        $final_rand = "";
        for ($i = 0; $i < $length; $i++) {
            $final_rand .= $chars[rand(0, strlen($chars) - 1)];
        }
        $this->line($final_rand);
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments() {
        return array(
            array('length', InputArgument::OPTIONAL, 'Length of the security key, default is 32')
        );
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions() {
        return array();
    }

}
