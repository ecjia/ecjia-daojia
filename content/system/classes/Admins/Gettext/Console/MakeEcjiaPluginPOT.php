<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019/1/15
 * Time: 15:15
 */

namespace Ecjia\System\Admins\Gettext\Console;


class MakeEcjiaPluginPOT extends MakePOT
{

    protected $meta = array(
        'description'        => 'Translation of the Ecjia plugin {name} {version} by {author}',
        'msgid-bugs-address' => 'https://www.ecjia.com/support/plugin/{slug}',
        'copyright-holder'   => '{author}',
        'package-name'       => '{name}',
        'package-version'    => '{version}',
    );

    public function make($dir, $output, $slug = null, $args = array())
    {
        $defaults     = array(
            'excludes' => array(),
            'includes' => array(),
        );
        $args         = array_merge($defaults, $args);
        $placeholders = array();
        // guess plugin slug
        if (is_null($slug)) {
            $slug = $this->guess_plugin_slug($dir);
        }

        $plugins_dir  = @opendir($dir);
        $plugin_files = array();
        if ($plugins_dir) {
            while (($file = readdir($plugins_dir)) !== false) {
                if ('.' === substr($file, 0, 1)) {
                    continue;
                }

                if ('.php' === substr($file, -4)) {
                    $plugin_files[] = $file;
                }
            }
            closedir($plugins_dir);
        }

        if (empty($plugin_files)) {
            return false;
        }

        $main_file = '';
        foreach ($plugin_files as $plugin_file) {
            if (!is_readable("$dir/$plugin_file")) {
                continue;
            }

            $source = $this->get_first_lines("$dir/$plugin_file", $this->max_header_lines);

            // Stop when we find a file with a plugin name header in it.
            if ($this->get_addon_header('Plugin Name', $source) != false) {
                $main_file = "$dir/$plugin_file";
                break;
            }
        }

        if (empty($main_file)) {
            return false;
        }

        $placeholders['version'] = $this->get_addon_header('Version', $source);
        $placeholders['author']  = $this->get_addon_header('Author', $source);
        $placeholders['name']    = $this->get_addon_header('Plugin Name', $source);
        $placeholders['slug']    = $slug;

        $output = is_null($output) ? "$slug.pot" : $output;
        $res    = $this->xgettext('wp-plugin', $dir, $output, $placeholders, $args['excludes'], $args['includes']);
        if (!$res) {
            return false;
        }

        $potextmeta = new PotExtMeta($this->console);
        $res        = $potextmeta->append($main_file, $output);
        /* Adding non-gettexted strings can repeat some phrases */
        $output_shell = escapeshellarg($output);
        system("msguniq $output_shell -o $output_shell");
        return $res;
    }


    protected function guess_plugin_slug($dir)
    {
        if ('trunk' == basename($dir)) {
            $slug = basename(dirname($dir));
        } elseif (in_array(basename(dirname($dir)), array('branches', 'tags'))) {
            $slug = basename(dirname(dirname($dir)));
        } else {
            $slug = basename($dir);
        }
        return $slug;
    }


}