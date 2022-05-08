<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpFoundation\Session\Storage;

/**
 * MockFileSessionStorage is used to mock sessions for
 * functional testing when done in a single PHP process.
 *
 * No PHP session is actually started since a session can be initialized
 * and shutdown only once per PHP execution cycle and this class does
 * not pollute any session related globals, including session_*() functions
 * or session.* PHP ini directives.
 *
 * @author Drak <drak@zikula.org>
 */
class MockFileSessionStorage extends MockArraySessionStorage
{
<<<<<<< HEAD
    /**
     * @var string
     */
    private $savePath;

    /**
     * Constructor.
     *
     * @param string      $savePath Path of directory to save session files
     * @param string      $name     Session name
     * @param MetadataBag $metaBag  MetadataBag instance
     */
    public function __construct($savePath = null, $name = 'MOCKSESSID', MetadataBag $metaBag = null)
=======
    private $savePath;

    /**
     * @param string $savePath Path of directory to save session files
     */
    public function __construct(string $savePath = null, string $name = 'MOCKSESSID', MetadataBag $metaBag = null)
>>>>>>> v2-test
    {
        if (null === $savePath) {
            $savePath = sys_get_temp_dir();
        }

        if (!is_dir($savePath) && !@mkdir($savePath, 0777, true) && !is_dir($savePath)) {
<<<<<<< HEAD
            throw new \RuntimeException(sprintf('Session Storage was not able to create directory "%s"', $savePath));
=======
            throw new \RuntimeException(sprintf('Session Storage was not able to create directory "%s".', $savePath));
>>>>>>> v2-test
        }

        $this->savePath = $savePath;

        parent::__construct($name, $metaBag);
    }

    /**
     * {@inheritdoc}
     */
    public function start()
    {
        if ($this->started) {
            return true;
        }

        if (!$this->id) {
            $this->id = $this->generateId();
        }

        $this->read();

        $this->started = true;

        return true;
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function regenerate($destroy = false, $lifetime = null)
=======
    public function regenerate(bool $destroy = false, int $lifetime = null)
>>>>>>> v2-test
    {
        if (!$this->started) {
            $this->start();
        }

        if ($destroy) {
            $this->destroy();
        }

        return parent::regenerate($destroy, $lifetime);
    }

    /**
     * {@inheritdoc}
     */
    public function save()
    {
        if (!$this->started) {
<<<<<<< HEAD
            throw new \RuntimeException('Trying to save a session that was not started yet or was already closed');
        }

        file_put_contents($this->getFilePath(), serialize($this->data));
=======
            throw new \RuntimeException('Trying to save a session that was not started yet or was already closed.');
        }

        $data = $this->data;

        foreach ($this->bags as $bag) {
            if (empty($data[$key = $bag->getStorageKey()])) {
                unset($data[$key]);
            }
        }
        if ([$key = $this->metadataBag->getStorageKey()] === array_keys($data)) {
            unset($data[$key]);
        }

        try {
            if ($data) {
                $path = $this->getFilePath();
                $tmp = $path.bin2hex(random_bytes(6));
                file_put_contents($tmp, serialize($data));
                rename($tmp, $path);
            } else {
                $this->destroy();
            }
        } finally {
            $this->data = $data;
        }
>>>>>>> v2-test

        // this is needed for Silex, where the session object is re-used across requests
        // in functional tests. In Symfony, the container is rebooted, so we don't have
        // this issue
        $this->started = false;
    }

    /**
     * Deletes a session from persistent storage.
     * Deliberately leaves session data in memory intact.
     */
<<<<<<< HEAD
    private function destroy()
    {
        if (is_file($this->getFilePath())) {
            unlink($this->getFilePath());
=======
    private function destroy(): void
    {
        set_error_handler(static function () {});
        try {
            unlink($this->getFilePath());
        } finally {
            restore_error_handler();
>>>>>>> v2-test
        }
    }

    /**
     * Calculate path to file.
<<<<<<< HEAD
     *
     * @return string File path
     */
    private function getFilePath()
=======
     */
    private function getFilePath(): string
>>>>>>> v2-test
    {
        return $this->savePath.'/'.$this->id.'.mocksess';
    }

    /**
     * Reads session from storage and loads session.
     */
<<<<<<< HEAD
    private function read()
    {
        $filePath = $this->getFilePath();
        $this->data = is_readable($filePath) && is_file($filePath) ? unserialize(file_get_contents($filePath)) : array();
=======
    private function read(): void
    {
        set_error_handler(static function () {});
        try {
            $data = file_get_contents($this->getFilePath());
        } finally {
            restore_error_handler();
        }

        $this->data = $data ? unserialize($data) : [];
>>>>>>> v2-test

        $this->loadSession();
    }
}
