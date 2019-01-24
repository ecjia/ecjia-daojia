<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019/1/15
 * Time: 15:15
 */

namespace Ecjia\System\Admins\Gettext\Console;


class MakeEcjiaThemePOT extends MakePOT
{

    protected $meta = array(
        'description'        => 'Translation of the Ecjia theme {name} {version} by {author}',
        'msgid-bugs-address' => 'https://www.ecjia.org/support/theme/{slug}',
        'copyright-holder'   => '{author}',
        'package-name'       => '{name}',
        'package-version'    => '{version}',
        'comments'           => 'Copyright (C) {year} {author}\nThis file is distributed under the same license as the {package-name} package.',
    );


    public function make($dir, $output, $slug = null)
    {
        $placeholders = array();
        // guess plugin slug
        if (is_null($slug)) {
            $slug = $this->guess_plugin_slug($dir);
        }

        $main_file = $dir . '/style.css';
        $source    = $this->get_first_lines($main_file, $this->max_header_lines);

        $placeholders['version'] = $this->get_addon_header('Version', $source);
        $placeholders['author']  = $this->get_addon_header('Author', $source);
        $placeholders['name']    = $this->get_addon_header('Theme Name', $source);
        $placeholders['slug']    = $slug;

        $license = $this->get_addon_header('License', $source);
        if ($license)
        {
            $this->meta['wp-theme']['comments'] = "Copyright (C) {year} {author}\nThis file is distributed under the {$license}.";
        }
        else
        {
            $this->meta['wp-theme']['comments'] = "Copyright (C) {year} {author}\nThis file is distributed under the same license as the {package-name} package.";
        }

        $output = is_null($output) ? "$slug.pot" : $output;
        $res    = $this->xgettext('wp-theme', $dir, $output, $placeholders);
        if (!$res)
        {
            return false;
        }

        $potextmeta = new PotExtMeta($this->console);
        $res        = $potextmeta->append($main_file, $output, array('Theme Name', 'Theme URI', 'Description', 'Author', 'Author URI'));
        if (!$res)
        {
            return false;
        }

        // If we're dealing with a pre-3.4 default theme, don't extract page templates before 3.4.
        $extract_templates = !in_array($slug, array('twentyten', 'twentyeleven', 'default', 'classic'));
        if (!$extract_templates) {
            $wp_dir            = dirname(dirname(dirname($dir)));
            $extract_templates = file_exists("$wp_dir/wp-admin/user/about.php") || !file_exists("$wp_dir/wp-load.php");
        }

        if ($extract_templates) {
            $res = $potextmeta->append($dir, $output, array('Template Name'));
            if (!$res)
            {
                return false;
            }

            $files = scandir($dir);
            foreach ($files as $file) {
                if ('.' == $file[0] || 'CVS' == $file)
                {
                    continue;
                }

                if (is_dir($dir . '/' . $file)) {
                    $res = $potextmeta->append($dir . '/' . $file, $output, array('Template Name'));
                    if (!$res)
                    {
                        return false;
                    }
                }
            }
        }
        /* Adding non-gettexted strings can repeat some phrases */
        $output_shell = escapeshellarg($output);
        system("msguniq $output_shell -o $output_shell");
        return $res;
    }


}