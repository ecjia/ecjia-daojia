<?php

/*
 * This file is part of Raven.
 *
 * (c) Sentry Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Autoloads Raven classes.
 *
 * @package raven
 */
class Raven_Autoloader
{
    /**
     * Registers Raven_Autoloader as an SPL autoloader.
     */
    public static function register()
    {
<<<<<<< HEAD
        ini_set('unserialize_callback_func', 'spl_autoload_call');
=======
>>>>>>> v2-test
        spl_autoload_register(array('Raven_Autoloader', 'autoload'));
    }

    /**
     * Handles autoloading of classes.
     *
     * @param string $class A class name.
     */
    public static function autoload($class)
    {
<<<<<<< HEAD
        if (0 !== strpos($class, 'Raven')) {
            return;
        }

        if (is_file($file = dirname(__FILE__).'/../'.str_replace(array('_', "\0"), array('/', ''), $class).'.php')) {
=======
        if (substr($class, 0, 6) !== 'Raven_') {
            return;
        }

        $file = dirname(__FILE__).'/../'.str_replace(array('_', "\0"), array('/', ''), $class).'.php';
        if (is_file($file)) {
            /** @noinspection PhpIncludeInspection */
>>>>>>> v2-test
            require $file;
        }
    }
}
