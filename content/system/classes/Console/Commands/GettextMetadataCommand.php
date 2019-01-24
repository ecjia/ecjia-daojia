<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019/1/14
 * Time: 15:50
 */

namespace Ecjia\System\Console\Commands;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Royalcms\Component\Console\Command;
use Ecjia\System\Admins\Gettext\Console\PotExtMeta;

// Run the CLI only if the file wasn't included.
class GettextMetadataCommand extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'ecjia:gettext-metadata';

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
        $potextmeta = new PotExtMeta($this);

        $ext_filename = $this->argument('ext');
        if (empty($ext_filename)) {
            $potextmeta->usage();
        }

        $pot_filename = $this->argument('pot');
        if (empty($pot_filename)) {
            $pot_filename = '-';
        }

        $headers = $this->argument('headers');

        $potextmeta->append( $ext_filename, $pot_filename, $headers );
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['ext', InputArgument::OPTIONAL, 'plugin file EXT'],
            ['pot', InputArgument::OPTIONAL, 'plugin file POT'],
            ['headers', InputArgument::IS_ARRAY, 'plugin file headers'],
        ];
    }

}