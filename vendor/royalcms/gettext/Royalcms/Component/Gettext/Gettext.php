<?php

namespace Royalcms\Component\Gettext;

use RC_Hook;
use Royalcms\Component\Foundation\Royalcms;

class Gettext
{
    /**
     * The Royalcms instance.
     *
     * @var \Royalcms\Component\Foundation\Royalcms
     */
    protected $royalcms;
    
    
    protected $textdomain;
    
    /**
     * Create a new FTP instance.
     *
     * @param  \Royalcms\Component\Foundation\Royalcms  $royalcms
     * @return void
     */
    public function __construct(Royalcms $royalcms, TextdomainManager $textdomain)
    {
        $this->royalcms = $royalcms;
        $this->textdomain = $textdomain;
    }
    
    /**
     * Retrieve the translation of $text.
     *
     * If there is no translation, or the text domain isn't loaded, the original text is returned.
     *
     * <strong>Note:</strong> Don't use translate() directly, use __() or related functions.
     *
     * @since 3.2.0
     *
     * @param string $text
     *            Text to translate.
     * @param string $domain
     *            Optional. Text domain. Unique identifier for retrieving translated strings.
     * @return string Translated text
     */
    public function translate($text, $domain = 'default')
    {
        $translations = $this->textdomain->getTranslationsForDomain($domain);
        $translations = $translations->translate($text);
        /**
         * Filter text with its translation.
         *
         * @since 3.2.0
         *
         * @param string $translations
         *            Translated text.
         * @param string $text
         *            Text to translate.
         * @param string $domain
         *            Text domain. Unique identifier for retrieving translated strings.
        */
        return RC_Hook::apply_filters('gettext', $translations, $text, $domain);
    }
    
    
    /**
     * Retrieve the translation of $text in the context defined in $context.
     *
     * If there is no translation, or the text domain isn't loaded the original
     * text is returned.
     *
     * @since 3.2.0
     *
     * @param string $text
     *            Text to translate.
     * @param string $context
     *            Context information for the translators.
     * @param string $domain
     *            Optional. Text domain. Unique identifier for retrieving translated strings.
     * @return string Translated text on success, original text on failure.
     */
    public function translateWithGettextContext($text, $context, $domain = 'default')
    {
        $translations = $this->textdomain->getTranslationsForDomain($domain);
        $translations = $translations->translate($text, $context);
        /**
         * Filter text with its translation based on context information.
         *
         * @since 3.2.0
         *
         * @param string $translations
         *            Translated text.
         * @param string $text
         *            Text to translate.
         * @param string $context
         *            Context information for the translators.
         * @param string $domain
         *            Text domain. Unique identifier for retrieving translated strings.
        */
        return RC_Hook::apply_filters('gettext_with_context', $translations, $text, $context, $domain);
    }
    
    
    /**
     * Retrieve the plural or single form based on the supplied amount.
     *
     * If the text domain is not set in the $l10n list, then a comparison will be made
     * and either $plural or $single parameters returned.
     *
     * If the text domain does exist, then the parameters $single, $plural, and $number
     * will first be passed to the text domain's ngettext method. Then it will be passed
     * to the 'ngettext' filter hook along with the same parameters. The expected
     * type will be a string.
     *
     * @since 3.2.0
     *
     * @param string $single
     *            The text that will be used if $number is 1.
     * @param string $plural
     *            The text that will be used if $number is not 1.
     * @param int $number
     *            The number to compare against to use either $single or $plural.
     * @param string $domain
     *            Optional. Text domain. Unique identifier for retrieving translated strings.
     * @return string Either $single or $plural translated text.
     */
    public function _n($single, $plural, $number, $domain = 'default')
    {
        $translations = $this->textdomain->getTranslationsForDomain($domain);
        $translation = $translations->translate_plural($single, $plural, $number);
        /**
         * Filter text with its translation when plural option is available.
         *
         * @since 3.2.0
         *
         * @param string $translation
         *            Translated text.
         * @param string $single
         *            The text that will be used if $number is 1.
         * @param string $plural
         *            The text that will be used if $number is not 1.
         * @param string $number
         *            The number to compare against to use either $single or $plural.
         * @param string $domain
         *            Text domain. Unique identifier for retrieving translated strings.
        */
        return RC_Hook::apply_filters('ngettext', $translation, $single, $plural, $number, $domain);
    }
    
    
    /**
     * Retrieve the plural or single form based on the supplied amount with gettext context.
     *
     * This is a hybrid of _n() and _x(). It supports contexts and plurals.
     *
     * @since 3.2.0
     *
     * @param string $single
     *            The text that will be used if $number is 1.
     * @param string $plural
     *            The text that will be used if $number is not 1.
     * @param int $number
     *            The number to compare against to use either $single or $plural.
     * @param string $context
     *            Context information for the translators.
     * @param string $domain
     *            Optional. Text domain. Unique identifier for retrieving translated strings.
     * @return string Either $single or $plural translated text with context.
     */
    public function _nx($single, $plural, $number, $context, $domain = 'default')
    {
        $translations = $this->textdomain->getTranslationsForDomain($domain);
        $translation = $translations->translate_plural($single, $plural, $number, $context);
        /**
         * Filter text with its translation while plural option and context are available.
         *
         * @since 3.2.0
         *
         * @param string $translation
         *            Translated text.
         * @param string $single
         *            The text that will be used if $number is 1.
         * @param string $plural
         *            The text that will be used if $number is not 1.
         * @param string $number
         *            The number to compare against to use either $single or $plural.
         * @param string $context
         *            Context information for the translators.
         * @param string $domain
         *            Text domain. Unique identifier for retrieving translated strings.
        */
        return RC_Hook::apply_filters('ngettext_with_context', $translation, $single, $plural, $number, $context, $domain);
    }
    
    
    /**
     * Register plural strings in POT file, but don't translate them.
     *
     * Used when you want to keep structures with translatable plural
     * strings and use them later.
     *
     * Example:
     * <code>
     * $messages = array(
     * 'post' => _n_noop('%s post', '%s posts'),
     * 'page' => _n_noop('%s pages', '%s pages')
     * );
     * ...
     * $message = $messages[$type];
     * $usable_text = sprintf( translate_nooped_plural( $message, $count ), $count );
     * </code>
     *
     * @since 3.2.0
     *
     * @param string $singular
     *            Single form to be i18ned.
     * @param string $plural
     *            Plural form to be i18ned.
     * @param string $domain
     *            Optional. Text domain. Unique identifier for retrieving translated strings.
     * @return array array($singular, $plural)
     */
    public function _n_noop($singular, $plural, $domain = null)
    {
        return array(
            0 => $singular,
            1 => $plural,
            'singular' => $singular,
            'plural' => $plural,
            'context' => null,
            'domain' => $domain
        );
    }
    
    /**
     * Register plural strings with context in POT file, but don't translate them.
     *
     * @since 3.2.0
     */
    public function _nx_noop($singular, $plural, $context, $domain = null)
    {
        return array(
            0 => $singular,
            1 => $plural,
            2 => $context,
            'singular' => $singular,
            'plural' => $plural,
            'context' => $context,
            'domain' => $domain
        );
    }
    
    /**
     * Translate the result of _n_noop() or _nx_noop().
     *
     * @since 3.1.0
     *
     * @param array $nooped_plural
     *            Array with singular, plural and context keys, usually the result of _n_noop() or _nx_noop()
     * @param int $count
     *            Number of objects
     * @param string $domain
     *            Optional. Text domain. Unique identifier for retrieving translated strings. If $nooped_plural contains
     *            a text domain passed to _n_noop() or _nx_noop(), it will override this value.
     * @return string Either $single or $plural translated text.
     */
    public function translateNoopedPlural($nooped_plural, $count, $domain = 'default')
    {
        if ($nooped_plural['domain']) {
            $domain = $nooped_plural['domain'];
        }
    
        if ($nooped_plural['context']) {
            return self::_nx($nooped_plural['singular'], $nooped_plural['plural'], $count, $nooped_plural['context'], $domain);
        } else {
            return self::_n($nooped_plural['singular'], $nooped_plural['plural'], $count, $domain);
        }
    }
    
    
    /**
     * Dynamically pass methods to the default connection.
     *
     * @param  string  $method
     * @param  array   $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return call_user_func_array(array($this->textdomain, $method), $parameters);
    }
    
}