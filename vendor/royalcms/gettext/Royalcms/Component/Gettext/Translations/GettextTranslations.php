<?php 

namespace Royalcms\Component\Gettext\Translations;

use Exception;
use Royalcms\Component\Gettext\PluralForms;

class GettextTranslations extends Translations
{

    /**
     * The gettext implementation of select_plural_form.
     *
     * It lives in this class, because there are more than one descendand, which will use it and
     * they can't share it effectively.
     */
    public function gettext_select_plural_form($count)
    {
        if (! isset($this->_gettext_select_plural_form) || is_null($this->_gettext_select_plural_form)) {
            list ($nplurals, $expression) = $this->nplurals_and_expression_from_header($this->get_header('Plural-Forms'));
            $this->_nplurals = $nplurals;
            $this->_gettext_select_plural_form = $this->make_plural_form_function($nplurals, $expression);
        }
        return call_user_func($this->_gettext_select_plural_form, $count);
    }

    public function nplurals_and_expression_from_header($header)
    {
        if (preg_match('/^\s*nplurals\s*=\s*(\d+)\s*;\s+plural\s*=\s*(.+)$/', $header, $matches)) {
            $nplurals = (int)$matches[1];
            $expression = trim( $matches[2] );
            return array($nplurals, $expression);
        } else {
            return array(2, 'n != 1');
        }
    }

    /**
     * Makes a function, which will return the right translation index, according to the
     * plural forms header
     * @param int    $nplurals
     * @param string $expression
     */
    public function make_plural_form_function($nplurals, $expression)
    {
        try {
            $handler = new PluralForms( rtrim( $expression, ';' ) );
            return array( $handler, 'get' );
        } catch ( Exception $e ) {
            // Fall back to default plural-form function.
            return $this->make_plural_form_function( 2, 'n != 1' );
        }
    }

    /**
     * Adds parantheses to the inner parts of ternary operators in
     * plural expressions, because PHP evaluates ternary oerators from left to right
     *
     * @param string $expression the expression without parentheses
     * @return string the expression with parentheses added
     */
    public function parenthesize_plural_exression($expression)
    {
        $expression .= ';';
        $res = '';
        $depth = 0;
        for ($i = 0; $i < strlen($expression); ++ $i) {
            $char = $expression[$i];
            switch ($char) {
                case '?':
                    $res .= ' ? (';
                    $depth ++;
                    break;
                case ':':
                    $res .= ') : (';
                    break;
                case ';':
                    $res .= str_repeat(')', $depth) . ';';
                    $depth = 0;
                    break;
                default:
                    $res .= $char;
            }
        }
        return rtrim($res, ';');
    }

    public function make_headers($translation)
    {
        $headers = array();
        // sometimes \ns are used instead of real new lines
        $translation = str_replace('\n', "\n", $translation);
        $lines = explode("\n", $translation);
        foreach ($lines as $line) {
            $parts = explode(':', $line, 2);
            if (! isset($parts[1]))
            {
                continue;
            }
            $headers[trim($parts[0])] = trim($parts[1]);
        }
        return $headers;
    }

    public function set_header($header, $value)
    {
        parent::set_header($header, $value);
        if ('Plural-Forms' == $header) {
            list ($nplurals, $expression) = $this->nplurals_and_expression_from_header($this->get_header('Plural-Forms'));
            $this->_nplurals = $nplurals;
            $this->_gettext_select_plural_form = $this->make_plural_form_function($nplurals, $expression);
        }
    }
}


// end