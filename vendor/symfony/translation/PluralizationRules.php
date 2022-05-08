<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Translation;

/**
 * Returns the plural rules for a given locale.
 *
 * @author Fabien Potencier <fabien@symfony.com>
<<<<<<< HEAD
 */
class PluralizationRules
{
    private static $rules = array();
=======
 *
 * @deprecated since Symfony 4.2, use IdentityTranslator instead
 */
class PluralizationRules
{
    private static $rules = [];
>>>>>>> v2-test

    /**
     * Returns the plural position to use for the given locale and number.
     *
<<<<<<< HEAD
     * @param int    $number The number
=======
     * @param float  $number The number
>>>>>>> v2-test
     * @param string $locale The locale
     *
     * @return int The plural position
     */
<<<<<<< HEAD
    public static function get($number, $locale)
    {
=======
    public static function get($number, $locale/*, bool $triggerDeprecation = true*/)
    {
        $number = abs($number);

        if (3 > \func_num_args() || func_get_arg(2)) {
            @trigger_error(sprintf('The "%s" class is deprecated since Symfony 4.2.', __CLASS__), \E_USER_DEPRECATED);
        }

>>>>>>> v2-test
        if ('pt_BR' === $locale) {
            // temporary set a locale for brazilian
            $locale = 'xbr';
        }

<<<<<<< HEAD
        if (strlen($locale) > 3) {
            $locale = substr($locale, 0, -strlen(strrchr($locale, '_')));
        }

        if (isset(self::$rules[$locale])) {
            $return = call_user_func(self::$rules[$locale], $number);

            if (!is_int($return) || $return < 0) {
=======
        if (\strlen($locale) > 3) {
            $locale = substr($locale, 0, -\strlen(strrchr($locale, '_')));
        }

        if (isset(self::$rules[$locale])) {
            $return = self::$rules[$locale]($number);

            if (!\is_int($return) || $return < 0) {
>>>>>>> v2-test
                return 0;
            }

            return $return;
        }

        /*
         * The plural rules are derived from code of the Zend Framework (2010-09-25),
         * which is subject to the new BSD license (http://framework.zend.com/license/new-bsd).
         * Copyright (c) 2005-2010 Zend Technologies USA Inc. (http://www.zend.com)
         */
        switch ($locale) {
            case 'az':
            case 'bo':
            case 'dz':
            case 'id':
            case 'ja':
            case 'jv':
            case 'ka':
            case 'km':
            case 'kn':
            case 'ko':
            case 'ms':
            case 'th':
            case 'tr':
            case 'vi':
            case 'zh':
                return 0;
<<<<<<< HEAD
                break;
=======
>>>>>>> v2-test

            case 'af':
            case 'bn':
            case 'bg':
            case 'ca':
            case 'da':
            case 'de':
            case 'el':
            case 'en':
            case 'eo':
            case 'es':
            case 'et':
            case 'eu':
            case 'fa':
            case 'fi':
            case 'fo':
            case 'fur':
            case 'fy':
            case 'gl':
            case 'gu':
            case 'ha':
            case 'he':
            case 'hu':
            case 'is':
            case 'it':
            case 'ku':
            case 'lb':
            case 'ml':
            case 'mn':
            case 'mr':
            case 'nah':
            case 'nb':
            case 'ne':
            case 'nl':
            case 'nn':
            case 'no':
<<<<<<< HEAD
=======
            case 'oc':
>>>>>>> v2-test
            case 'om':
            case 'or':
            case 'pa':
            case 'pap':
            case 'ps':
            case 'pt':
            case 'so':
            case 'sq':
            case 'sv':
            case 'sw':
            case 'ta':
            case 'te':
            case 'tk':
            case 'ur':
            case 'zu':
<<<<<<< HEAD
                return ($number == 1) ? 0 : 1;
=======
                return (1 == $number) ? 0 : 1;
>>>>>>> v2-test

            case 'am':
            case 'bh':
            case 'fil':
            case 'fr':
            case 'gun':
            case 'hi':
            case 'hy':
            case 'ln':
            case 'mg':
            case 'nso':
            case 'xbr':
            case 'ti':
            case 'wa':
<<<<<<< HEAD
                return (($number == 0) || ($number == 1)) ? 0 : 1;
=======
                return ($number < 2) ? 0 : 1;
>>>>>>> v2-test

            case 'be':
            case 'bs':
            case 'hr':
            case 'ru':
<<<<<<< HEAD
            case 'sr':
            case 'uk':
                return (($number % 10 == 1) && ($number % 100 != 11)) ? 0 : ((($number % 10 >= 2) && ($number % 10 <= 4) && (($number % 100 < 10) || ($number % 100 >= 20))) ? 1 : 2);

            case 'cs':
            case 'sk':
                return ($number == 1) ? 0 : ((($number >= 2) && ($number <= 4)) ? 1 : 2);

            case 'ga':
                return ($number == 1) ? 0 : (($number == 2) ? 1 : 2);

            case 'lt':
                return (($number % 10 == 1) && ($number % 100 != 11)) ? 0 : ((($number % 10 >= 2) && (($number % 100 < 10) || ($number % 100 >= 20))) ? 1 : 2);

            case 'sl':
                return ($number % 100 == 1) ? 0 : (($number % 100 == 2) ? 1 : ((($number % 100 == 3) || ($number % 100 == 4)) ? 2 : 3));

            case 'mk':
                return ($number % 10 == 1) ? 0 : 1;

            case 'mt':
                return ($number == 1) ? 0 : ((($number == 0) || (($number % 100 > 1) && ($number % 100 < 11))) ? 1 : ((($number % 100 > 10) && ($number % 100 < 20)) ? 2 : 3));

            case 'lv':
                return ($number == 0) ? 0 : ((($number % 10 == 1) && ($number % 100 != 11)) ? 1 : 2);

            case 'pl':
                return ($number == 1) ? 0 : ((($number % 10 >= 2) && ($number % 10 <= 4) && (($number % 100 < 12) || ($number % 100 > 14))) ? 1 : 2);

            case 'cy':
                return ($number == 1) ? 0 : (($number == 2) ? 1 : ((($number == 8) || ($number == 11)) ? 2 : 3));

            case 'ro':
                return ($number == 1) ? 0 : ((($number == 0) || (($number % 100 > 0) && ($number % 100 < 20))) ? 1 : 2);

            case 'ar':
                return ($number == 0) ? 0 : (($number == 1) ? 1 : (($number == 2) ? 2 : ((($number % 100 >= 3) && ($number % 100 <= 10)) ? 3 : ((($number % 100 >= 11) && ($number % 100 <= 99)) ? 4 : 5))));
=======
            case 'sh':
            case 'sr':
            case 'uk':
                return ((1 == $number % 10) && (11 != $number % 100)) ? 0 : ((($number % 10 >= 2) && ($number % 10 <= 4) && (($number % 100 < 10) || ($number % 100 >= 20))) ? 1 : 2);

            case 'cs':
            case 'sk':
                return (1 == $number) ? 0 : ((($number >= 2) && ($number <= 4)) ? 1 : 2);

            case 'ga':
                return (1 == $number) ? 0 : ((2 == $number) ? 1 : 2);

            case 'lt':
                return ((1 == $number % 10) && (11 != $number % 100)) ? 0 : ((($number % 10 >= 2) && (($number % 100 < 10) || ($number % 100 >= 20))) ? 1 : 2);

            case 'sl':
                return (1 == $number % 100) ? 0 : ((2 == $number % 100) ? 1 : (((3 == $number % 100) || (4 == $number % 100)) ? 2 : 3));

            case 'mk':
                return (1 == $number % 10) ? 0 : 1;

            case 'mt':
                return (1 == $number) ? 0 : (((0 == $number) || (($number % 100 > 1) && ($number % 100 < 11))) ? 1 : ((($number % 100 > 10) && ($number % 100 < 20)) ? 2 : 3));

            case 'lv':
                return (0 == $number) ? 0 : (((1 == $number % 10) && (11 != $number % 100)) ? 1 : 2);

            case 'pl':
                return (1 == $number) ? 0 : ((($number % 10 >= 2) && ($number % 10 <= 4) && (($number % 100 < 12) || ($number % 100 > 14))) ? 1 : 2);

            case 'cy':
                return (1 == $number) ? 0 : ((2 == $number) ? 1 : (((8 == $number) || (11 == $number)) ? 2 : 3));

            case 'ro':
                return (1 == $number) ? 0 : (((0 == $number) || (($number % 100 > 0) && ($number % 100 < 20))) ? 1 : 2);

            case 'ar':
                return (0 == $number) ? 0 : ((1 == $number) ? 1 : ((2 == $number) ? 2 : ((($number % 100 >= 3) && ($number % 100 <= 10)) ? 3 : ((($number % 100 >= 11) && ($number % 100 <= 99)) ? 4 : 5))));
>>>>>>> v2-test

            default:
                return 0;
        }
    }

    /**
     * Overrides the default plural rule for a given locale.
     *
     * @param callable $rule   A PHP callable
     * @param string   $locale The locale
<<<<<<< HEAD
     *
     * @throws \LogicException
     */
    public static function set($rule, $locale)
    {
=======
     */
    public static function set(callable $rule, $locale)
    {
        @trigger_error(sprintf('The "%s" class is deprecated since Symfony 4.2.', __CLASS__), \E_USER_DEPRECATED);

>>>>>>> v2-test
        if ('pt_BR' === $locale) {
            // temporary set a locale for brazilian
            $locale = 'xbr';
        }

<<<<<<< HEAD
        if (strlen($locale) > 3) {
            $locale = substr($locale, 0, -strlen(strrchr($locale, '_')));
        }

        if (!is_callable($rule)) {
            throw new \LogicException('The given rule can not be called');
=======
        if (\strlen($locale) > 3) {
            $locale = substr($locale, 0, -\strlen(strrchr($locale, '_')));
>>>>>>> v2-test
        }

        self::$rules[$locale] = $rule;
    }
}
