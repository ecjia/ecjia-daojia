<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019/1/14
 * Time: 14:47
 */

namespace Ecjia\System\Admins\Gettext\Console;

use Royalcms\Component\Gettext\Entry;
use Royalcms\Component\Gettext\PortableObject;
use Royalcms\Component\Gettext\MachineObject;

// see: https://secure.php.net/tokenizer
if (!defined('T_ML_COMMENT'))
    define('T_ML_COMMENT', T_COMMENT);
else
    define('T_DOC_COMMENT', T_ML_COMMENT);

// run the CLI only if the file
// wasn't included
class NotGettexted extends GettextConsoleAbstract
{
    protected $enable_logging = false;

    const STAGE_OUTSIDE            = 0;
    const STAGE_START_COMMENT      = 1;
    const STAGE_WHITESPACE_BEFORE  = 2;
    const STAGE_STRING             = 3;
    const STAGE_WHITESPACE_AFTER   = 4;
    const STAGE_END_COMMENT        = 4;

    protected $commands = array(
        'extract' => 'command_extract',
        'replace' => 'command_replace'
    );

    /**
     * 默认输出，使用说明
     */
    public function usage()
    {
        $this->console->info('Usage: ecjia ecjia:gettext-comment COMMAND OUTPUTFILE INPUTFILES');
        $this->console->line('Extracts and replaces strings, which cannot be gettexted');
        $this->console->line('Commands:');
        $this->console->info('	extract POTFILE PHPFILES appends the strings to POTFILE');
        $this->console->info('	replace MOFILE PHPFILES replaces strings in PHPFILES with translations from MOFILE');
        exit(1);
    }

    public function cli_die($msg)
    {
        $this->console->error($msg);
        exit(1);
    }

    public function getCommands()
    {
        return $this->commands;
    }

    /**
     * extract POTFILE PHPFILES appends the strings to POTFILE
     *
     * @param $outputfile string
     * @param $inputfiles array
     * @return bool
     */
    public function command_extract($outputfile, $inputfiles)
    {
        $pot_filename = $outputfile;
        $filenames = $inputfiles;

        $global_name           = '__entries_' . mt_rand(1, 1000);
        $GLOBALS[$global_name] = array();

        foreach ($filenames as $filename) {
            $tokens     = token_get_all(file_get_contents($filename));
            $aggregator = $this->make_string_aggregator($global_name, $filename);
            $this->walk_tokens($tokens, array($this, 'ignore_token'), array($this, 'ignore_token'), $aggregator);
        }

        $potf = '-' == $pot_filename ? STDOUT : @fopen($pot_filename, 'a');
        if (false === $potf) {
            $this->cli_die("Couldn't open pot file: $pot_filename");
        }

        foreach ($GLOBALS[$global_name] as $item) {
            @list($string, $comment_id, $filename, $line_number) = $item;
            $filename        = isset($filename) ? preg_replace('|^\./|', '', $filename) : '';
            $ref_line_number = isset($line_number) ? ":$line_number" : '';
            $args            = array(
                'singular'           => $string,
                'extracted_comments' => "Not gettexted string $comment_id",
                'references'         => array("$filename$ref_line_number"),
            );
            $entry           = new Entry($args);
            fwrite($potf, "\n" . PortableObject::export_entry($entry) . "\n");
        }

        if ('-' != $pot_filename) {
            fclose($potf);
        }

        return true;
    }

    /**
     * replace MOFILE PHPFILES replaces strings in PHPFILES with translations from MOFILE
     *
     * @param $outputfile
     * @param $inputfiles
     * @return bool
     */
    public function command_replace($outputfile, $inputfiles)
    {
        $mo_filename = $outputfile;
        $filenames = $inputfiles;

        $global_name           = '__mo_' . mt_rand(1, 1000);
        $GLOBALS[$global_name] = new MachineObject();
        $replacer              = $this->make_mo_replacer($global_name);

        $res = $GLOBALS[$global_name]->import_from_file($mo_filename);
        if (false === $res) {
            $this->cli_die("Couldn't read MO file '$mo_filename'!");
        }

        foreach ($filenames as $filename) {
            $source = file_get_contents($filename);
            if (strlen($source) > 150000) continue;
            $tokens   = token_get_all($source);
            $new_file = $this->walk_tokens($tokens, $replacer, array($this, 'unchanged_token'));
            $f        = fopen($filename, 'w');
            fwrite($f, $new_file);
            fclose($f);
        }

        return true;
    }

    public function logmsg()
    {
        $args = func_get_args();
        if ($this->enable_logging) error_log(implode(' ', $args));
    }

    public function unchanged_token($token, $s = '')
    {
        return is_array($token) ? $token[1] : $token;
    }

    public function ignore_token($token, $s = '')
    {
        return '';
    }

    public static function list_php_files($dir, $files = array())
    {
        $items = scandir($dir);
        foreach ((array)$items as $item) {
            $full_item = $dir . '/' . $item;
            if ('.' == $item || '..' == $item)
            {
                continue;
            }

            if ('.php' == substr($item, -4))
            {
                $files[] = $full_item;
            }

            if (is_dir($full_item))
            {
                $files += array_merge($files, self::list_php_files($full_item, $files));
            }
        }
        return $files;
    }

    /**
     * @param $global_array_name
     * @param $filename
     * @return string
     */
    public function make_string_aggregator($global_array_name, $filename)
    {
        $a = $global_array_name;
        return create_function('$string, $comment_id, $line_number', 'global $' . $a . '; $' . $a . '[] = array($string, $comment_id, ' . var_export($filename, true) . ', $line_number);');
    }

    /**
     * @param $global_mo_name
     * @return string
     */
    public function make_mo_replacer($global_mo_name)
    {
        $m = $global_mo_name;
        return create_function('$token, $string', 'global $' . $m . '; return var_export($' . $m . '->translate($string), true);');
    }

    /**
     * @param $tokens
     * @param $string_action
     * @param $other_action
     * @param null $register_action
     * @return string
     */
    public function walk_tokens(&$tokens, $string_action, $other_action, $register_action = null)
    {

        $current_comment_id  = '';
        $current_string      = '';
        $current_string_line = 0;

        $result = '';
        $line   = 1;

        foreach ($tokens as $token) {
            if (is_array($token)) {
                list($id, $text) = $token;
                $line += substr_count($text, "\n");
                if ((T_ML_COMMENT == $id || T_COMMENT == $id) && preg_match('|/\*\s*(/?ECJIA_I18N_[a-z_]+)\s*\*/|i', $text, $matches)) {
                    if (self::STAGE_OUTSIDE == $stage) {
                        $stage              = self::STAGE_START_COMMENT;
                        $current_comment_id = $matches[1];
                        $this->logmsg('start comment', $current_comment_id);
                        $result .= call_user_func($other_action, $token);
                        continue;
                    }
                    if (self::STAGE_START_COMMENT <= $stage && $stage <= self::STAGE_WHITESPACE_AFTER && '/' . $current_comment_id == $matches[1]) {
                        $stage = self::STAGE_END_COMMENT;
                        $this->logmsg('end comment', $current_comment_id);
                        $result .= call_user_func($other_action, $token);
                        if (!is_null($register_action)) call_user_func($register_action, $current_string, $current_comment_id, $current_string_line);
                        continue;
                    }
                } else if (T_CONSTANT_ENCAPSED_STRING == $id) {
                    if (self::STAGE_START_COMMENT <= $stage && $stage < self::STAGE_WHITESPACE_AFTER) {
                        eval('$current_string=' . $text . ';');
                        $this->logmsg('string', $current_string);
                        $current_string_line = $line;
                        $result              .= call_user_func($string_action, $token, $current_string);
                        continue;
                    }
                } else if (T_WHITESPACE == $id) {
                    if (self::STAGE_START_COMMENT <= $stage && $stage < self::STAGE_STRING) {
                        $stage = self::STAGE_WHITESPACE_BEFORE;
                        $this->logmsg('whitespace before');
                        $result .= call_user_func($other_action, $token);
                        continue;
                    }
                    if (self::STAGE_STRING < $stage && $stage < self::STAGE_END_COMMENT) {
                        $stage = self::STAGE_WHITESPACE_AFTER;
                        $this->logmsg('whitespace after');
                        $result .= call_user_func($other_action, $token);
                        continue;
                    }
                }
            }

            $result              .= call_user_func($other_action, $token);
            $stage               = self::STAGE_OUTSIDE;
            $current_comment_id  = '';
            $current_string      = '';
            $current_string_line = 0;
        }
        return $result;
    }

}
