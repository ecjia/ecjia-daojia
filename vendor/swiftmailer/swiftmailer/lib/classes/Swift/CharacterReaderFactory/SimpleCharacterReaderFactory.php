<?php

/*
 * This file is part of SwiftMailer.
 * (c) 2004-2009 Chris Corbyn
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Standard factory for creating CharacterReaders.
 *
 * @author Chris Corbyn
 */
class Swift_CharacterReaderFactory_SimpleCharacterReaderFactory implements Swift_CharacterReaderFactory
{
    /**
     * A map of charset patterns to their implementation classes.
     *
     * @var array
     */
<<<<<<< HEAD
    private static $_map = array();
=======
    private static $map = [];
>>>>>>> v2-test

    /**
     * Factories which have already been loaded.
     *
     * @var Swift_CharacterReaderFactory[]
     */
<<<<<<< HEAD
    private static $_loaded = array();
=======
    private static $loaded = [];
>>>>>>> v2-test

    /**
     * Creates a new CharacterReaderFactory.
     */
    public function __construct()
    {
        $this->init();
    }

    public function __wakeup()
    {
        $this->init();
    }

    public function init()
    {
<<<<<<< HEAD
        if (count(self::$_map) > 0) {
=======
        if (\count(self::$map) > 0) {
>>>>>>> v2-test
            return;
        }

        $prefix = 'Swift_CharacterReader_';

<<<<<<< HEAD
        $singleByte = array(
            'class' => $prefix.'GenericFixedWidthReader',
            'constructor' => array(1),
            );

        $doubleByte = array(
            'class' => $prefix.'GenericFixedWidthReader',
            'constructor' => array(2),
            );

        $fourBytes = array(
            'class' => $prefix.'GenericFixedWidthReader',
            'constructor' => array(4),
            );

        // Utf-8
        self::$_map['utf-?8'] = array(
            'class' => $prefix.'Utf8Reader',
            'constructor' => array(),
            );

        //7-8 bit charsets
        self::$_map['(us-)?ascii'] = $singleByte;
        self::$_map['(iso|iec)-?8859-?[0-9]+'] = $singleByte;
        self::$_map['windows-?125[0-9]'] = $singleByte;
        self::$_map['cp-?[0-9]+'] = $singleByte;
        self::$_map['ansi'] = $singleByte;
        self::$_map['macintosh'] = $singleByte;
        self::$_map['koi-?7'] = $singleByte;
        self::$_map['koi-?8-?.+'] = $singleByte;
        self::$_map['mik'] = $singleByte;
        self::$_map['(cork|t1)'] = $singleByte;
        self::$_map['v?iscii'] = $singleByte;

        //16 bits
        self::$_map['(ucs-?2|utf-?16)'] = $doubleByte;

        //32 bits
        self::$_map['(ucs-?4|utf-?32)'] = $fourBytes;

        // Fallback
        self::$_map['.*'] = $singleByte;
=======
        $singleByte = [
            'class' => $prefix.'GenericFixedWidthReader',
            'constructor' => [1],
            ];

        $doubleByte = [
            'class' => $prefix.'GenericFixedWidthReader',
            'constructor' => [2],
            ];

        $fourBytes = [
            'class' => $prefix.'GenericFixedWidthReader',
            'constructor' => [4],
            ];

        // Utf-8
        self::$map['utf-?8'] = [
            'class' => $prefix.'Utf8Reader',
            'constructor' => [],
            ];

        //7-8 bit charsets
        self::$map['(us-)?ascii'] = $singleByte;
        self::$map['(iso|iec)-?8859-?[0-9]+'] = $singleByte;
        self::$map['windows-?125[0-9]'] = $singleByte;
        self::$map['cp-?[0-9]+'] = $singleByte;
        self::$map['ansi'] = $singleByte;
        self::$map['macintosh'] = $singleByte;
        self::$map['koi-?7'] = $singleByte;
        self::$map['koi-?8-?.+'] = $singleByte;
        self::$map['mik'] = $singleByte;
        self::$map['(cork|t1)'] = $singleByte;
        self::$map['v?iscii'] = $singleByte;

        //16 bits
        self::$map['(ucs-?2|utf-?16)'] = $doubleByte;

        //32 bits
        self::$map['(ucs-?4|utf-?32)'] = $fourBytes;

        // Fallback
        self::$map['.*'] = $singleByte;
>>>>>>> v2-test
    }

    /**
     * Returns a CharacterReader suitable for the charset applied.
     *
     * @param string $charset
     *
     * @return Swift_CharacterReader
     */
    public function getReaderFor($charset)
    {
<<<<<<< HEAD
        $charset = trim(strtolower($charset));
        foreach (self::$_map as $pattern => $spec) {
            $re = '/^'.$pattern.'$/D';
            if (preg_match($re, $charset)) {
                if (!array_key_exists($pattern, self::$_loaded)) {
=======
        $charset = strtolower(trim($charset));
        foreach (self::$map as $pattern => $spec) {
            $re = '/^'.$pattern.'$/D';
            if (preg_match($re, $charset)) {
                if (!\array_key_exists($pattern, self::$loaded)) {
>>>>>>> v2-test
                    $reflector = new ReflectionClass($spec['class']);
                    if ($reflector->getConstructor()) {
                        $reader = $reflector->newInstanceArgs($spec['constructor']);
                    } else {
                        $reader = $reflector->newInstance();
                    }
<<<<<<< HEAD
                    self::$_loaded[$pattern] = $reader;
                }

                return self::$_loaded[$pattern];
=======
                    self::$loaded[$pattern] = $reader;
                }

                return self::$loaded[$pattern];
>>>>>>> v2-test
            }
        }
    }
}
