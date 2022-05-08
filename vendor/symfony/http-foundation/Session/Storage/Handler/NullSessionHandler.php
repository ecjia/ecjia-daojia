<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpFoundation\Session\Storage\Handler;

/**
<<<<<<< HEAD
 * NullSessionHandler.
 *
=======
>>>>>>> v2-test
 * Can be used in unit testing or in a situations where persisted sessions are not desired.
 *
 * @author Drak <drak@zikula.org>
 */
<<<<<<< HEAD
class NullSessionHandler implements \SessionHandlerInterface
{
    /**
     * {@inheritdoc}
     */
    public function open($savePath, $sessionName)
=======
class NullSessionHandler extends AbstractSessionHandler
{
    /**
     * @return bool
     */
    public function close()
>>>>>>> v2-test
    {
        return true;
    }

    /**
<<<<<<< HEAD
     * {@inheritdoc}
     */
    public function close()
=======
     * @return bool
     */
    public function validateId($sessionId)
>>>>>>> v2-test
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function read($sessionId)
=======
    protected function doRead(string $sessionId)
>>>>>>> v2-test
    {
        return '';
    }

    /**
<<<<<<< HEAD
     * {@inheritdoc}
     */
    public function write($sessionId, $data)
=======
     * @return bool
     */
    public function updateTimestamp($sessionId, $data)
>>>>>>> v2-test
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function destroy($sessionId)
=======
    protected function doWrite(string $sessionId, string $data)
>>>>>>> v2-test
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
=======
    protected function doDestroy(string $sessionId)
    {
        return true;
    }

    /**
     * @return bool
     */
>>>>>>> v2-test
    public function gc($maxlifetime)
    {
        return true;
    }
}
