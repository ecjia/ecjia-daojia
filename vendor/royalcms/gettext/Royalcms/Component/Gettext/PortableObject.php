<?php

namespace Royalcms\Component\Gettext;

use Royalcms\Component\Gettext\Translations\GettextTranslations;
use Royalcms\Component\Gettext\Entry;

if ( ! defined( 'PO_MAX_LINE_LEN' ) ) {
    define('PO_MAX_LINE_LEN', 79);
}

ini_set('auto_detect_line_endings', 1);

class PortableObject extends GettextTranslations
{

    protected $comments_before_headers = '';

    /**
     * Exports headers to a PO entry
     *
     * @return string msgid/msgstr PO entry for this PO file headers, doesn't contain newline at the end
     */
    public function export_headers()
    {
        $header_string = '';
        foreach ($this->headers as $header => $value) {
            $header_string .= "$header: $value\n";
        }
        $poified = self::poify($header_string);
        if ($this->comments_before_headers) {
            $before_headers = $this->prepend_each_line(rtrim($this->comments_before_headers) . "\n", '# ');
        } else {
            $before_headers = '';
        }
        return rtrim("{$before_headers}msgid \"\"\nmsgstr $poified");
    }

    /**
     * Exports all entries to PO format
     *
     * @return string sequence of mgsgid/msgstr PO strings, doesn't containt newline at the end
     */
    public function export_entries()
    {
        // TODO sorting
        return implode("\n\n", array_map(array(
            __CLASS__,
            'export_entry'
        ), $this->entries));
    }

    /**
     * Exports the whole PO file as a string
     *
     * @param bool $include_headers
     *            whether to include the headers in the export
     * @return string ready for inclusion in PO file string for headers and all the enrtries
     */
    public function export($include_headers = true)
    {
        $res = '';
        if ($include_headers) {
            $res .= $this->export_headers();
            $res .= "\n\n";
        }
        $res .= $this->export_entries();
        return $res;
    }

    /**
     * Same as {@link export}, but writes the result to a file
     *
     * @param string $filename where to write the PO string
     * @param bool $include_headers whether to include tje headers in the export
     * @return bool true on success, false on error
     */
    public function export_to_file($filename, $include_headers = true)
    {
        $fh = fopen($filename, 'w');
        if (false === $fh) {
            return false;
        }

        $export = $this->export($include_headers);
        $res    = fwrite($fh, $export);
        if (false === $res) {
            return false;
        }
        return fclose($fh);
    }

    /**
     * Text to include as a comment before the start of the PO contents
     *
     * Doesn't need to include # in the beginning of lines, these are added automatically
     */
    public function set_comment_before_headers($text)
    {
        $this->comments_before_headers = $text;
    }

    /**
     * Formats a string in PO-style
     *
     * @static
     *
     * @param string $string the string to format
     * @return string the poified string
     */
    public static function poify($string)
    {
        $quote   = '"';
        $slash   = '\\';
        $newline = "\n";

        $replaces = array(
            "$slash" => "$slash$slash",
            "$quote" => "$slash$quote",
            "\t"     => '\t'
        );

        $string = str_replace(array_keys($replaces), array_values($replaces), $string);

        $po = $quote . implode("${slash}n$quote$newline$quote", explode($newline, $string)) . $quote;
        // add empty string on first line for readbility
        if (false !== strpos($string, $newline) && (substr_count($string, $newline) > 1 || !($newline === substr($string, -strlen($newline))))) {
            $po = "$quote$quote$newline$po";
        }
        // remove empty strings
        $po = str_replace("$newline$quote$quote", '', $po);
        return $po;
    }

    /**
     * Gives back the original string from a PO-formatted string
     *
     * @static
     *
     * @param string $string PO-formatted string
     * @return string enascaped string
     */
    public static function unpoify($string)
    {
        $escapes               = array(
            't'  => "\t",
            'n'  => "\n",
            'r'  => "\r",
            '\\' => '\\'
        );
        $lines                 = array_map('trim', explode("\n", $string));
        $lines                 = array_map(array(__CLASS__, 'trim_quotes'), $lines);
        $unpoified             = '';
        $previous_is_backslash = false;
        foreach ($lines as $line) {
            preg_match_all('/./u', $line, $chars);
            $chars = $chars[0];
            foreach ($chars as $char) {
                if (!$previous_is_backslash) {
                    if ('\\' == $char) {
                        $previous_is_backslash = true;
                    } else {
                        $unpoified .= $char;
                    }
                } else {
                    $previous_is_backslash = false;
                    $unpoified             .= isset($escapes[$char]) ? $escapes[$char] : $char;
                }
            }
        }

        // Standardise the line endings on imported content, technically PO files shouldn't contain \r
        $unpoified = str_replace( array( "\r\n", "\r" ), "\n", $unpoified );

        return $unpoified;
    }

    /**
     * Inserts $with in the beginning of every new line of $string and
     * returns the modified string
     *
     * @static
     *
     * @param string $string prepend lines in this string
     * @param string $with prepend lines with this string
     */
    public static function prepend_each_line($string, $with)
    {
        $lines = explode("\n", $string);
        $append = '';
        if ("\n" === substr($string, -1) && '' === end($lines)) {
            // Last line might be empty because $string was terminated
            // with a newline, remove it from the $lines array,
            // we'll restore state by re-terminating the string at the end
            array_pop($lines);
            $append = "\n";
        }

        foreach ($lines as &$line) {
            $line = $with . $line;
        }

        unset($line);
        return implode("\n", $lines) . $append;
    }

    /**
     * Prepare a text as a comment -- wraps the lines and prepends #
     * and a special character to each line
     *
     * @access private
     * @param string $text the comment text
     * @param string $char character to denote a special PO comment,
     *            like :, default is a space
     */
    public static function comment_block($text, $char = ' ')
    {
        $text = wordwrap($text, PO_MAX_LINE_LEN - 3);
        return self::prepend_each_line($text, "#$char ");
    }

    /**
     * Builds a string from the entry for inclusion in PO file
     *
     * @static
     *
     * @param \Royalcms\Component\Gettext\Entry &$entry the entry to convert to po string
     * @return string bool formatted string for the entry or
     *         false if the entry is empty
     */
    public static function export_entry(&$entry)
    {
        if (null === $entry->singular || '' === $entry->singular) {
            return false;
        }

        $po = array();
        if (!empty($entry->translator_comments)) {
            $po[] = self::comment_block($entry->translator_comments);
        }

        if (!empty($entry->extracted_comments)) {
            $po[] = self::comment_block($entry->extracted_comments, '.');
        }

        if (!empty($entry->references)) {
            $po[] = self::comment_block(implode(' ', $entry->references), ':');
        }

        if (!empty($entry->flags)) {
            $po[] = self::comment_block(implode(", ", $entry->flags), ',');
        }

        if (!is_null($entry->context)) {
            $po[] = 'msgctxt ' . self::poify($entry->context);
        }

        $po[] = 'msgid ' . self::poify($entry->singular);
        if (!$entry->is_plural) {
            $translation = empty($entry->translations) ? '' : $entry->translations[0];
            $translation = self::match_begin_and_end_newlines( $translation, $entry->singular );
            $po[]        = 'msgstr ' . self::poify($translation);
        } else {
            $po[]         = 'msgid_plural ' . self::poify($entry->plural);
            $translations = empty($entry->translations) ? array(
                '',
                ''
            ) : $entry->translations;
            foreach ($translations as $i => $translation) {
                $translation = self::match_begin_and_end_newlines( $translation, $entry->plural );
                $po[] = "msgstr[$i] " . self::poify($translation);
            }
        }
        return implode("\n", $po);
    }

    public static function match_begin_and_end_newlines( $translation, $original )
    {
        if ( '' === $translation ) {
            return $translation;
        }

        $original_begin = "\n" === substr( $original, 0, 1 );
        $original_end = "\n" === substr( $original, -1 );
        $translation_begin = "\n" === substr( $translation, 0, 1 );
        $translation_end = "\n" === substr( $translation, -1 );

        if ( $original_begin ) {
            if ( ! $translation_begin ) {
                $translation = "\n" . $translation;
            }
        } elseif ( $translation_begin ) {
            $translation = ltrim( $translation, "\n" );
        }

        if ( $original_end ) {
            if ( ! $translation_end ) {
                $translation .= "\n";
            }
        } elseif ( $translation_end ) {
            $translation = rtrim( $translation, "\n" );
        }

        return $translation;
    }

    public function import_from_file($filename)
    {
        $f = fopen($filename, 'r');
        if (!$f) {
            return false;
        }

        $lineno = 0;
        $res = null;

        while (true) {
            $res = $this->read_entry($f, $lineno);
            if (!$res) {
                break;
            }

            if ($res['entry']->singular == '') {
                $this->set_headers($this->make_headers($res['entry']->translations[0]));
            } else {
                $this->add_entry($res['entry']);
            }
        }
        self::read_line($f, 'clear');
        if (false === $res) {
            return false;
        }

        if (!$this->headers && !$this->entries) {
            return false;
        }
        return true;
    }

    /**
     * Helper function for read_entry
     * @param string $context
     * @return bool
     */
    protected static function is_final($context)
    {
        return ($context === 'msgstr') || ($context === 'msgstr_plural');
    }

    public function read_entry($f, $lineno = 0)
    {
        $entry = new Entry();
        // where were we in the last step
        // can be: comment, msgctxt, msgid, msgid_plural, msgstr, msgstr_plural
        $context      = '';
        $msgstr_index = 0;
        while (true) {
            $lineno++;
            $line = self::read_line($f);
            if (!$line) {
                if (feof($f)) {
                    if (self::is_final($context))
                    {
                        break;
                    }
                    elseif (!$context) // we haven't read a line and eof came
                    {
                        return null;
                    }
                    else
                    {
                        return false;
                    }
                } else {
                    return false;
                }
            }

            if ($line == "\n") {
                continue;
            }

            $line = trim($line);
            if (preg_match('/^#/', $line, $m)) {
                // the comment is the start of a new entry
                if (self::is_final($context)) {
                    self::read_line($f, 'put-back');
                    $lineno--;
                    break;
                }
                // comments have to be at the beginning
                if ($context && $context != 'comment') {
                    return false;
                }
                // add comment
                $this->add_comment_to_entry($entry, $line);
            } elseif (preg_match('/^msgctxt\s+(".*")/', $line, $m)) {
                if (self::is_final($context)) {
                    self::read_line($f, 'put-back');
                    $lineno--;
                    break;
                }
                if ($context && $context != 'comment') {
                    return false;
                }
                $context        = 'msgctxt';
                $entry->context .= self::unpoify($m[1]);
            } elseif (preg_match('/^msgid\s+(".*")/', $line, $m)) {
                if (self::is_final($context)) {
                    self::read_line($f, 'put-back');
                    $lineno--;
                    break;
                }
                if ($context && $context != 'msgctxt' && $context != 'comment') {
                    return false;
                }
                $context         = 'msgid';
                $entry->singular .= self::unpoify($m[1]);
            } elseif (preg_match('/^msgid_plural\s+(".*")/', $line, $m)) {
                if ($context != 'msgid') {
                    return false;
                }
                $context          = 'msgid_plural';
                $entry->is_plural = true;
                $entry->plural    .= self::unpoify($m[1]);
            } elseif (preg_match('/^msgstr\s+(".*")/', $line, $m)) {
                if ($context != 'msgid') {
                    return false;
                }
                $context             = 'msgstr';
                $entry->translations = array(
                    self::unpoify($m[1])
                );
            } elseif (preg_match('/^msgstr\[(\d+)\]\s+(".*")/', $line, $m)) {
                if ($context != 'msgid_plural' && $context != 'msgstr_plural') {
                    return false;
                }
                $context                    = 'msgstr_plural';
                $msgstr_index               = $m[1];
                $entry->translations[$m[1]] = self::unpoify($m[2]);
            } elseif (preg_match('/^".*"$/', $line)) {
                $unpoified = self::unpoify($line);
                switch ($context) {
                    case 'msgid':
                        $entry->singular .= $unpoified;
                        break;
                    case 'msgctxt':
                        $entry->context .= $unpoified;
                        break;
                    case 'msgid_plural':
                        $entry->plural .= $unpoified;
                        break;
                    case 'msgstr':
                        $entry->translations[0] .= $unpoified;
                        break;
                    case 'msgstr_plural':
                        $entry->translations[$msgstr_index] .= $unpoified;
                        break;
                    default:
                        return false;
                }
            } else {
                return false;
            }
        }

        $have_translations = false;
        foreach ( $entry->translations as $t ) {
            if ( $t || ('0' === $t) ) {
                $have_translations = true;
                break;
            }
        }
        if ( false === $have_translations ) {
            $entry->translations = array();
        }

        return array(
            'entry'  => $entry,
            'lineno' => $lineno
        );
    }

    /**
     * @static
     *
     * @param $f
     * @param string $action
     * @return bool|string
     */
    public static function read_line($f, $action = 'read')
    {
        static $last_line = '';
        static $use_last_line = false;
        if ('clear' == $action) {
            $last_line = '';
            return true;
        }
        if ('put-back' == $action) {
            $use_last_line = true;
            return true;
        }
        $line          = $use_last_line ? $last_line : fgets($f);
        $line          = ("\r\n" == substr($line, -2)) ? rtrim($line, "\r\n") . "\n" : $line;
        $last_line     = $line;
        $use_last_line = false;
        return $line;
    }

    /**
     * @param \Royalcms\Component\Gettext\Entry $entry
     * @param string            $po_comment_line
     */
    public function add_comment_to_entry(&$entry, $po_comment_line)
    {
        $first_two = substr($po_comment_line, 0, 2);
        $comment   = trim(substr($po_comment_line, 2));
        if ('#:' == $first_two) {
            $entry->references = array_merge($entry->references, preg_split('/\s+/', $comment));
        } elseif ('#.' == $first_two) {
            $entry->extracted_comments = trim($entry->extracted_comments . "\n" . $comment);
        } elseif ('#,' == $first_two) {
            $entry->flags = array_merge($entry->flags, preg_split('/,\s*/', $comment));
        } else {
            $entry->translator_comments = trim($entry->translator_comments . "\n" . $comment);
        }
    }

    /**
     * @param string $s
     * @return string
     */
    public static function trim_quotes($s)
    {
        if (substr($s, 0, 1) == '"') {
            $s = substr($s, 1);
        }

        if (substr($s, -1, 1) == '"') {
            $s = substr($s, 0, -1);
        }

        return $s;
    }
}


// end