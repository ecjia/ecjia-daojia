<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019/1/14
 * Time: 14:47
 */

namespace Ecjia\System\Admins\Gettext\Console;

use Royalcms\Component\Gettext\PortableObject;
use Royalcms\Component\Gettext\Entry;

class PotExtMeta extends GettextConsoleAbstract
{

    protected $headers = array(
        'Plugin Name',
        'Template Name',
        'Plugin URI',
        'Template URI',
        'Description',
        'Author',
        'Author URI',
        'Tags',
    );

    public function usage()
    {
        $this->console->info("Usage: ");
        $this->console->line('  ecjia:gettext-metadata EXT POT');
        $this->console->line("Adds metadata from a ECJia theme or plugin file EXT to POT file");
        exit(1);
    }

    public function load_from_file($ext_filename)
    {
        $makepot = new MakePOT($this->console);
        $source = $makepot->get_first_lines($ext_filename, 80);
        $pot = '';

        $po = new PortableObject;
        foreach($this->headers as $header) {
            $string = $makepot->get_addon_header($header, $source);
            if (!$string) {
                continue;
            }

            $args = array(
                'singular' => $string,
                'extracted_comments' => $header.' of the plugin/theme',
            );
            $entry = new Entry($args);
            $pot .= "\n".$po->export_entry($entry)."\n";
        }
        return $pot;
    }

    public function append( $ext_filename, $pot_filename, $headers = null )
    {
        if ( $headers ) {
            $this->headers = (array) $headers;
        }

        if ( is_dir( $ext_filename ) ) {
            $pot = implode('', array_map(array($this, 'load_from_file'), glob("$ext_filename/*.php")));
        } else {
            $pot = $this->load_from_file($ext_filename);
        }

        $potf = '-' == $pot_filename? STDOUT : fopen($pot_filename, 'a');

        if (!$potf) {
            return false;
        }

        fwrite($potf, $pot);

        if ('-' != $pot_filename) {
            fclose($potf);
        }

        return true;
    }
}
