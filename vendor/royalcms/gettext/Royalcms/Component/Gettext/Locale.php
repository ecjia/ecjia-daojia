<?php

namespace Royalcms\Component\Gettext;

use RC_Hook;

class Locale
{
    private $locale;
    
    /**
     * Get the current locale.
     *
     * If the locale is set, then it will filter the locale in the 'locale' filter
     * hook and return the value.
     *
     * If the locale is not set already, then the RC_LANG constant is used if it is
     * defined. Then it is filtered through the 'locale' filter hook and the value
     * for the locale global set and the locale is returned.
     *
     * The process to get the locale should only be done once, but the locale will
     * always be filtered using the 'locale' hook.
     *
     * @since 3.2.0
     *
     * @return string The locale of the blog or from the 'locale' hook.
     */
    public function getLocale()
    {
        if (isset($this->locale)) {
            /**
             * Filter WordPress install's locale ID.
             *
             * @since 3.2.0
             *
             * @param string $locale
             *            The locale ID.
             */
            return RC_Hook::apply_filters('locale', $this->locale);
        }
    
        if (royalcms('config')->has('system.locale')) {
            $this->locale = royalcms('config')->get('system.locale');
        }
    
        if (empty($this->locale)) {
            $this->locale = 'zh_CN';
        }
    
        /**
         * This filter is documented in l10n.php
         */
        return RC_Hook::apply_filters('locale', $this->locale);
    }
    
    
    
    
    
    
}

