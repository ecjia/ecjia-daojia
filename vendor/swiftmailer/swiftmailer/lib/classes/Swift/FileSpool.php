<?php

/*
 * This file is part of SwiftMailer.
 * (c) 2009 Fabien Potencier <fabien.potencier@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Stores Messages on the filesystem.
 *
 * @author Fabien Potencier
 * @author Xavier De Cock <xdecock@gmail.com>
 */
class Swift_FileSpool extends Swift_ConfigurableSpool
{
    /** The spool directory */
<<<<<<< HEAD
    private $_path;
=======
    private $path;
>>>>>>> v2-test

    /**
     * File WriteRetry Limit.
     *
     * @var int
     */
<<<<<<< HEAD
    private $_retryLimit = 10;
=======
    private $retryLimit = 10;
>>>>>>> v2-test

    /**
     * Create a new FileSpool.
     *
     * @param string $path
     *
     * @throws Swift_IoException
     */
    public function __construct($path)
    {
<<<<<<< HEAD
        $this->_path = $path;

        if (!file_exists($this->_path)) {
            if (!mkdir($this->_path, 0777, true)) {
                throw new Swift_IoException(sprintf('Unable to create path "%s".', $this->_path));
=======
        $this->path = $path;

        if (!file_exists($this->path)) {
            if (!mkdir($this->path, 0777, true)) {
                throw new Swift_IoException(sprintf('Unable to create path "%s".', $this->path));
>>>>>>> v2-test
            }
        }
    }

    /**
     * Tests if this Spool mechanism has started.
     *
     * @return bool
     */
    public function isStarted()
    {
        return true;
    }

    /**
     * Starts this Spool mechanism.
     */
    public function start()
    {
    }

    /**
     * Stops this Spool mechanism.
     */
    public function stop()
    {
    }

    /**
     * Allow to manage the enqueuing retry limit.
     *
     * Default, is ten and allows over 64^20 different fileNames
     *
     * @param int $limit
     */
    public function setRetryLimit($limit)
    {
<<<<<<< HEAD
        $this->_retryLimit = $limit;
=======
        $this->retryLimit = $limit;
>>>>>>> v2-test
    }

    /**
     * Queues a message.
     *
<<<<<<< HEAD
     * @param Swift_Mime_Message $message The message to store
=======
     * @param Swift_Mime_SimpleMessage $message The message to store
>>>>>>> v2-test
     *
     * @throws Swift_IoException
     *
     * @return bool
     */
<<<<<<< HEAD
    public function queueMessage(Swift_Mime_Message $message)
    {
        $ser = serialize($message);
        $fileName = $this->_path.'/'.$this->getRandomString(10);
        for ($i = 0; $i < $this->_retryLimit; ++$i) {
            /* We try an exclusive creation of the file. This is an atomic operation, it avoid locking mechanism */
            $fp = @fopen($fileName.'.message', 'x');
=======
    public function queueMessage(Swift_Mime_SimpleMessage $message)
    {
        $ser = serialize($message);
        $fileName = $this->path.'/'.$this->getRandomString(10);
        for ($i = 0; $i < $this->retryLimit; ++$i) {
            /* We try an exclusive creation of the file. This is an atomic operation, it avoid locking mechanism */
            $fp = @fopen($fileName.'.message', 'xb');
>>>>>>> v2-test
            if (false !== $fp) {
                if (false === fwrite($fp, $ser)) {
                    return false;
                }

                return fclose($fp);
            } else {
                /* The file already exists, we try a longer fileName */
                $fileName .= $this->getRandomString(1);
            }
        }

<<<<<<< HEAD
        throw new Swift_IoException(sprintf('Unable to create a file for enqueuing Message in "%s".', $this->_path));
=======
        throw new Swift_IoException(sprintf('Unable to create a file for enqueuing Message in "%s".', $this->path));
>>>>>>> v2-test
    }

    /**
     * Execute a recovery if for any reason a process is sending for too long.
     *
     * @param int $timeout in second Defaults is for very slow smtp responses
     */
    public function recover($timeout = 900)
    {
<<<<<<< HEAD
        foreach (new DirectoryIterator($this->_path) as $file) {
            $file = $file->getRealPath();

            if (substr($file, -16) == '.message.sending') {
=======
        foreach (new DirectoryIterator($this->path) as $file) {
            $file = $file->getRealPath();

            if ('.message.sending' == substr($file, -16)) {
>>>>>>> v2-test
                $lockedtime = filectime($file);
                if ((time() - $lockedtime) > $timeout) {
                    rename($file, substr($file, 0, -8));
                }
            }
        }
    }

    /**
     * Sends messages using the given transport instance.
     *
     * @param Swift_Transport $transport        A transport instance
     * @param string[]        $failedRecipients An array of failures by-reference
     *
     * @return int The number of sent e-mail's
     */
    public function flushQueue(Swift_Transport $transport, &$failedRecipients = null)
    {
<<<<<<< HEAD
        $directoryIterator = new DirectoryIterator($this->_path);
=======
        $directoryIterator = new DirectoryIterator($this->path);
>>>>>>> v2-test

        /* Start the transport only if there are queued files to send */
        if (!$transport->isStarted()) {
            foreach ($directoryIterator as $file) {
<<<<<<< HEAD
                if (substr($file->getRealPath(), -8) == '.message') {
=======
                if ('.message' == substr($file->getRealPath(), -8)) {
>>>>>>> v2-test
                    $transport->start();
                    break;
                }
            }
        }

        $failedRecipients = (array) $failedRecipients;
        $count = 0;
        $time = time();
        foreach ($directoryIterator as $file) {
            $file = $file->getRealPath();

<<<<<<< HEAD
            if (substr($file, -8) != '.message') {
=======
            if ('.message' != substr($file, -8)) {
>>>>>>> v2-test
                continue;
            }

            /* We try a rename, it's an atomic operation, and avoid locking the file */
            if (rename($file, $file.'.sending')) {
                $message = unserialize(file_get_contents($file.'.sending'));

                $count += $transport->send($message, $failedRecipients);

                unlink($file.'.sending');
            } else {
                /* This message has just been catched by another process */
                continue;
            }

            if ($this->getMessageLimit() && $count >= $this->getMessageLimit()) {
                break;
            }

            if ($this->getTimeLimit() && (time() - $time) >= $this->getTimeLimit()) {
                break;
            }
        }

        return $count;
    }

    /**
     * Returns a random string needed to generate a fileName for the queue.
     *
     * @param int $count
     *
     * @return string
     */
    protected function getRandomString($count)
    {
        // This string MUST stay FS safe, avoid special chars
        $base = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789_-';
        $ret = '';
<<<<<<< HEAD
        $strlen = strlen($base);
        for ($i = 0; $i < $count; ++$i) {
            $ret .= $base[((int) rand(0, $strlen - 1))];
=======
        $strlen = \strlen($base);
        for ($i = 0; $i < $count; ++$i) {
            $ret .= $base[random_int(0, $strlen - 1)];
>>>>>>> v2-test
        }

        return $ret;
    }
}
