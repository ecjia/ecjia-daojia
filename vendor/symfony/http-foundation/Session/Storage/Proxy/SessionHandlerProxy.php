<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpFoundation\Session\Storage\Proxy;

/**
<<<<<<< HEAD
 * SessionHandler proxy.
 *
 * @author Drak <drak@zikula.org>
 */
class SessionHandlerProxy extends AbstractProxy implements \SessionHandlerInterface
{
    /**
     * @var \SessionHandlerInterface
     */
    protected $handler;

    /**
     * Constructor.
     *
     * @param \SessionHandlerInterface $handler
     */
=======
 * @author Drak <drak@zikula.org>
 */
class SessionHandlerProxy extends AbstractProxy implements \SessionHandlerInterface, \SessionUpdateTimestampHandlerInterface
{
    protected $handler;

>>>>>>> v2-test
    public function __construct(\SessionHandlerInterface $handler)
    {
        $this->handler = $handler;
        $this->wrapper = ($handler instanceof \SessionHandler);
        $this->saveHandlerName = $this->wrapper ? ini_get('session.save_handler') : 'user';
    }

<<<<<<< HEAD
    // \SessionHandlerInterface

    /**
     * {@inheritdoc}
     */
    public function open($savePath, $sessionName)
    {
        $return = (bool) $this->handler->open($savePath, $sessionName);

        if (true === $return) {
            $this->active = true;
        }

        return $return;
    }

    /**
     * {@inheritdoc}
     */
    public function close()
    {
        $this->active = false;

=======
    /**
     * @return \SessionHandlerInterface
     */
    public function getHandler()
    {
        return $this->handler;
    }

    // \SessionHandlerInterface

    /**
     * @return bool
     */
    public function open($savePath, $sessionName)
    {
        return (bool) $this->handler->open($savePath, $sessionName);
    }

    /**
     * @return bool
     */
    public function close()
    {
>>>>>>> v2-test
        return (bool) $this->handler->close();
    }

    /**
<<<<<<< HEAD
     * {@inheritdoc}
=======
     * @return string
>>>>>>> v2-test
     */
    public function read($sessionId)
    {
        return (string) $this->handler->read($sessionId);
    }

    /**
<<<<<<< HEAD
     * {@inheritdoc}
=======
     * @return bool
>>>>>>> v2-test
     */
    public function write($sessionId, $data)
    {
        return (bool) $this->handler->write($sessionId, $data);
    }

    /**
<<<<<<< HEAD
     * {@inheritdoc}
=======
     * @return bool
>>>>>>> v2-test
     */
    public function destroy($sessionId)
    {
        return (bool) $this->handler->destroy($sessionId);
    }

    /**
<<<<<<< HEAD
     * {@inheritdoc}
=======
     * @return bool
>>>>>>> v2-test
     */
    public function gc($maxlifetime)
    {
        return (bool) $this->handler->gc($maxlifetime);
    }
<<<<<<< HEAD
=======

    /**
     * @return bool
     */
    public function validateId($sessionId)
    {
        return !$this->handler instanceof \SessionUpdateTimestampHandlerInterface || $this->handler->validateId($sessionId);
    }

    /**
     * @return bool
     */
    public function updateTimestamp($sessionId, $data)
    {
        return $this->handler instanceof \SessionUpdateTimestampHandlerInterface ? $this->handler->updateTimestamp($sessionId, $data) : $this->write($sessionId, $data);
    }
>>>>>>> v2-test
}
