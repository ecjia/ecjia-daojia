<?php

/*
 * This file is part of SwiftMailer.
 * (c) 2004-2009 Chris Corbyn
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Changes some global preference settings in Swift Mailer.
 *
 * @author Chris Corbyn
 */
class Swift_Preferences
{
    /** Singleton instance */
<<<<<<< HEAD
    private static $_instance = null;
=======
    private static $instance = null;
>>>>>>> v2-test

    /** Constructor not to be used */
    private function __construct()
    {
    }

    /**
     * Gets the instance of Preferences.
     *
<<<<<<< HEAD
     * @return Swift_Preferences
     */
    public static function getInstance()
    {
        if (!isset(self::$_instance)) {
            self::$_instance = new self();
        }

        return self::$_instance;
=======
     * @return self
     */
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
>>>>>>> v2-test
    }

    /**
     * Set the default charset used.
     *
     * @param string $charset
     *
<<<<<<< HEAD
     * @return Swift_Preferences
     */
    public function setCharset($charset)
    {
        Swift_DependencyContainer::getInstance()
            ->register('properties.charset')->asValue($charset);
=======
     * @return $this
     */
    public function setCharset($charset)
    {
        Swift_DependencyContainer::getInstance()->register('properties.charset')->asValue($charset);
>>>>>>> v2-test

        return $this;
    }

    /**
     * Set the directory where temporary files can be saved.
     *
     * @param string $dir
     *
<<<<<<< HEAD
     * @return Swift_Preferences
     */
    public function setTempDir($dir)
    {
        Swift_DependencyContainer::getInstance()
            ->register('tempdir')->asValue($dir);
=======
     * @return $this
     */
    public function setTempDir($dir)
    {
        Swift_DependencyContainer::getInstance()->register('tempdir')->asValue($dir);
>>>>>>> v2-test

        return $this;
    }

    /**
     * Set the type of cache to use (i.e. "disk" or "array").
     *
     * @param string $type
     *
<<<<<<< HEAD
     * @return Swift_Preferences
     */
    public function setCacheType($type)
    {
        Swift_DependencyContainer::getInstance()
            ->register('cache')->asAliasOf(sprintf('cache.%s', $type));
=======
     * @return $this
     */
    public function setCacheType($type)
    {
        Swift_DependencyContainer::getInstance()->register('cache')->asAliasOf(sprintf('cache.%s', $type));
>>>>>>> v2-test

        return $this;
    }

    /**
     * Set the QuotedPrintable dot escaper preference.
     *
     * @param bool $dotEscape
     *
<<<<<<< HEAD
     * @return Swift_Preferences
=======
     * @return $this
>>>>>>> v2-test
     */
    public function setQPDotEscape($dotEscape)
    {
        $dotEscape = !empty($dotEscape);
        Swift_DependencyContainer::getInstance()
            ->register('mime.qpcontentencoder')
            ->asNewInstanceOf('Swift_Mime_ContentEncoder_QpContentEncoder')
<<<<<<< HEAD
            ->withDependencies(array('mime.charstream', 'mime.bytecanonicalizer'))
=======
            ->withDependencies(['mime.charstream', 'mime.bytecanonicalizer'])
>>>>>>> v2-test
            ->addConstructorValue($dotEscape);

        return $this;
    }
}
