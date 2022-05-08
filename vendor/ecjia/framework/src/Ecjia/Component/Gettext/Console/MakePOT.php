<?php
/**
 * User: royalwang
 * Date: 2019/1/14
 * Time: 14:46
 */

namespace Ecjia\Component\Gettext\Console;

use Royalcms\Component\Gettext\PortableObject;
use Ecjia\Component\Gettext\StringExtractor;
use Royalcms\Component\Support\Str;

/**
 * Class to create POT files for
 *  - ECJia system
 *  - ECJia apps
 *  - ECJia plugins
 *  - ECJia themes
 */
class MakePOT extends GettextConsoleAbstract
{
    protected $max_header_lines = 30;

    public $projects = array(
        'ecjia-system',
        'ecjia-app',
        'ecjia-plugin',
        'ecjia-theme',
        'ecjia-framework',
    );

    public $rules = array(
        '_'                    => array('string'),
        '__'                   => array('string'),
        '_e'                   => array('string'),
        '_c'                   => array('string'),
        '_n'                   => array('singular', 'plural'),
        '_n_noop'              => array('singular', 'plural'),
        '_nc'                  => array('singular', 'plural'),
        '__ngettext'           => array('singular', 'plural'),
        '__ngettext_noop'      => array('singular', 'plural'),
        '_x'                   => array('string', 'context'),
        '_ex'                  => array('string', 'context'),
        '_nx'                  => array('singular', 'plural', null, 'context'),
        '_nx_noop'             => array('singular', 'plural', 'context'),
        '_n_js'                => array('singular', 'plural'),
        '_nx_js'               => array('singular', 'plural', 'context'),
        'esc_attr__'           => array('string'),
        'esc_html__'           => array('string'),
        'esc_attr_e'           => array('string'),
        'esc_html_e'           => array('string'),
        'esc_attr_x'           => array('string', 'context'),
        'esc_html_x'           => array('string', 'context'),
        'comments_number_link' => array('string', 'singular', 'plural'),
    );

    /**
     * 排除的文件
     * 规则如下，可以使用正则匹配
     * 'ms-.*'
     * '.*\/ms-.*'
     * '.*\/my-.*'
     * 'activate\.php'
     * 'admin/network\.php'
     * 'admin/network/.*\.php'
     * 'admin/includes/class-wp-ms.*'
     * @var array
     */
    protected $ms_files = array(
    );

    protected $temp_files = array();

    protected $default_meta = array(
        'from-code' => 'utf-8',
        'msgid-bugs-address' => 'https://make.ecjia.com/polyglots/',
        'language' => 'php',
        'add-comments' => 'translators',
        'comments' => "Copyright (C) {year} {package-name}\nThis file is distributed under the same license as the {package-name} package.",
    );

    protected $meta = array();

    protected $placeholders = array();

    /**
     * @var \Ecjia\System\Admins\Gettext\StringExtractor
     */
    protected $extractor;

    /**
     * @var \Royalcms\Component\Console\Command
     */
    protected $console;

    /**
     * @param $command \Royalcms\Component\Console\Command
     */
    public function __construct($console)
    {
        parent::__construct($console);

        $this->extractor = new StringExtractor($this->rules);
    }

    public function __destruct()
    {
        foreach ($this->temp_files as $temp_file) {
            unlink($temp_file);
        }
    }

    /**
     * Prints CLI usage.
     */
    public function usage()
    {
        $this->console->info('Usage: ');
        $this->console->line('  ecjia ecjia:gettext-makepot PROJECT DIRECTORY [OUTPUT]');
        $this->console->info('Generate POT file from the files in DIRECTORY [OUTPUT]');
        $this->console->info("Available projects: " . implode(', ', $this->projects));
        exit(1);
    }

    public function getProjects()
    {
        return $this->projects;
    }

    public function getProjectInstance($project)
    {
        $method = 'Make' . Str::studly($project) . 'POT';
        $class = __NAMESPACE__ . '\\'. $method;

        return new $class($this->console);
    }

    protected function tempnam($file)
    {
        $tempnam            = tempnam(sys_get_temp_dir(), $file);
        $this->temp_files[] = $tempnam;
        return $tempnam;
    }

    protected function realpath_missing($path)
    {
        return realpath(dirname($path)) . DIRECTORY_SEPARATOR . basename($path);
    }


    public function array_map_callback($x)
    {
        return "{".$x."}";
    }

    /**
     * @param $project
     * @param $dir
     * @param $output_file
     * @param array $placeholders
     * @param array $excludes
     * @param array $includes
     * @return bool
     */
    protected function xgettext($project, $dir, $output_file, $placeholders = array(), $excludes = array(), $includes = array())
    {
        $meta                 = array_merge($this->default_meta, $this->meta);
        $placeholders         = array_merge($meta, $placeholders);
        $meta['output']       = $this->realpath_missing($output_file);
        $placeholders['year'] = date('Y');
        $placeholder_keys     = array_map([$this, 'array_map_callback'], array_keys($placeholders));
        $placeholder_values   = array_values($placeholders);
        foreach ($meta as $key => $value) {
            $meta[$key] = str_replace($placeholder_keys, $placeholder_values, $value);
        }

        $originals    = $this->extractor->extract_from_directory($dir, $excludes, $includes);
        $pot          = new PortableObject;
        $pot->setEntries($originals->getEntries());

        $pot->set_header('Project-Id-Version', $meta['package-name'] . ' ' . $meta['package-version']);
        $pot->set_header('Report-Msgid-Bugs-To', $meta['msgid-bugs-address']);
        $pot->set_header('POT-Creation-Date', gmdate('Y-m-d H:i:s+00:00'));
        $pot->set_header('MIME-Version', '1.0');
        $pot->set_header('Content-Type', 'text/plain; charset=UTF-8');
        $pot->set_header('Content-Transfer-Encoding', '8bit');
        $pot->set_header('PO-Revision-Date', date('Y') . '-MO-DA HO:MI+ZONE');
        $pot->set_header('Last-Translator', 'FULL NAME <EMAIL@ADDRESS>');
        $pot->set_header('Language-Team', 'LANGUAGE <ecjia@ecjia.com>');
        $pot->set_comment_before_headers($meta['comments']);
        $pot->export_to_file($output_file);
        return true;
    }

    protected function getVersion()
    {
        return config('release.version');
    }

    public function get_first_lines($filename, $lines = 30)
    {
        $extf = fopen($filename, 'r');
        if (!$extf) {
            return false;
        }

        $first_lines = '';
        foreach (range(1, $lines) as $x) {
            $line = fgets($extf);
            if (feof($extf)) {
                break;
            }

            if (false === $line) {
                return false;
            }

            $first_lines .= $line;
        }

        // PHP will close file handle, but we are good citizens.
        fclose($extf);

        // Make sure we catch CR-only line endings.
        $first_lines = str_replace("\r", "\n", $first_lines);

        return $first_lines;
    }

    public function get_addon_header($header, &$source)
    {
        /*
         * A few things this needs to handle:
         * - 'Header: Value\n'
         * - '// Header: Value'
         * - '/* Header: Value * /'
         * - '<?php // Header: Value ?>'
         * - '<?php /* Header: Value * / $foo='bar'; ?>'
         */
        if (preg_match('/^(?:[ \t]*<\?php)?[ \t\/*#@]*' . preg_quote($header, '/') . ':(.*)$/mi', $source, $matches)) {
            return $this->_cleanup_header_comment($matches[1]);
        } else {
            return false;
        }
    }

    /**
     * Removes any trailing closing comment / PHP tags from the header value
     */
    protected function _cleanup_header_comment($str)
    {
        return trim(preg_replace('/\s*(?:\*\/|\?>).*/', '', $str));
    }

    public function generic($dir, $output)
    {
        $output = is_null($output) ? "generic.pot" : $output;
        return $this->xgettext('generic', $dir, $output, array());
    }

}

