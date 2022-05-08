<?php
/**
 * User: royalwang
 * Date: 2019/1/15
 * Time: 15:23
 */

namespace Ecjia\Component\Gettext\Console;


class MakeEcjiaGenericPOT extends MakePOT
{

    protected $meta = array(
        'description'      => 'Translation of frontend strings in Ecjia {version}',
        'copyright-holder' => 'Ecjia',
        'package-name'     => 'Ecjia',
        'package-version'  => '{version}',
    );

    /**
     * @param $dir
     * @param $args
     * @return bool
     */
    public function generic($dir, $args)
    {
        $defaults = array(
            'project'                    => 'ecjia-generic',
            'output'                     => null,
            'default_output'             => 'generic.pot',
            'includes'                   => array(),
            'excludes'                   => array(),
            'extract_not_gettexted'      => false,
            'not_gettexted_files_filter' => false,
        );

        $args     = array_merge($defaults, $args);

        if ($ecjia_version = $this->getVersion()) {
            $this->placeholders['version'] = $ecjia_version;
        } else {
            return false;
        }

        $output = is_null($args['output']) ? $args['default_output'] : $args['output'];
        $res    = $this->xgettext($args['project'], $dir, $output, $this->placeholders, $args['excludes'], $args['includes']);
        if (! $res) {
            return false;
        }

        if ($args['extract_not_gettexted']) {
            $old_dir = getcwd();
            $output  = realpath($output);
            chdir($dir);

            $php_files     = NotGettexted::list_php_files('.');
            $php_files     = array_filter($php_files, $args['not_gettexted_files_filter']);
            $not_gettexted = new NotGettexted($this->console);
            $res           = $not_gettexted->command_extract($output, $php_files);
            chdir($old_dir);

            /* Adding non-gettexted strings can repeat some phrases */
            $output_shell = escapeshellarg($output);

            system("msguniq --use-first $output_shell -o $output_shell");
        }

        return $res;
    }


}