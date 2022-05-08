<?php

/*
 * This file is part of the Predis package.
 *
 * (c) Daniele Alessandri <suppakilla@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Predis\Command;

/**
 * @link http://redis.io/commands/hexists
 *
 * @author Daniele Alessandri <suppakilla@gmail.com>
 */
class HashExists extends Command
{
    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return 'HEXISTS';
    }
<<<<<<< HEAD

    /**
     * {@inheritdoc}
     */
    public function parseResponse($data)
    {
        return (bool) $data;
    }
=======
>>>>>>> v2-test
}
