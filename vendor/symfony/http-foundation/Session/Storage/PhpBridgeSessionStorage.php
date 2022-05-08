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

use Symfony\Component\HttpFoundation\Session\Storage\Proxy\AbstractProxy;
<<<<<<< HEAD
use Symfony\Component\HttpFoundation\Session\Storage\Handler\NativeSessionHandler;
=======
>>>>>>> v2-test

/**
 * Allows session to be started by PHP and managed by Symfony.
 *
 * @author Drak <drak@zikula.org>
 */
class PhpBridgeSessionStorage extends NativeSessionStorage
{
    /**
<<<<<<< HEAD
     * Constructor.
     *
     * @param AbstractProxy|NativeSessionHandler|\SessionHandlerInterface|null $handler
     * @param MetadataBag                                                      $metaBag MetadataBag
     */
    public function __construct($handler = null, MetadataBag $metaBag = null)
    {
=======
     * @param AbstractProxy|\SessionHandlerInterface|null $handler
     */
    public function __construct($handler = null, MetadataBag $metaBag = null)
    {
        if (!\extension_loaded('session')) {
            throw new \LogicException('PHP extension "session" is required.');
        }

>>>>>>> v2-test
        $this->setMetadataBag($metaBag);
        $this->setSaveHandler($handler);
    }

    /**
     * {@inheritdoc}
     */
    public function start()
    {
        if ($this->started) {
            return true;
        }

        $this->loadSession();
<<<<<<< HEAD
        if (!$this->saveHandler->isWrapper() && !$this->saveHandler->isSessionHandlerInterface()) {
            // This condition matches only PHP 5.3 + internal save handlers
            $this->saveHandler->setActive(true);
        }
=======
>>>>>>> v2-test

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function clear()
    {
        // clear out the bags and nothing else that may be set
        // since the purpose of this driver is to share a handler
        foreach ($this->bags as $bag) {
            $bag->clear();
        }

        // reconnect the bags to the session
        $this->loadSession();
    }
}
