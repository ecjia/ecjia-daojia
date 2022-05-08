<?php

/*
 * This file is part of PhpSpec, A php toolset to drive emergent
 * design by specification.
 *
 * (c) Marcello Duarte <marcello.duarte@gmail.com>
 * (c) Konstantin Kudryashov <ever.zet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpSpec\Exception\Example;

/**
 * Class PendingException holds information about pending exception
 */
class PendingException extends ExampleException
{
    /**
     * @param string $text
     */
<<<<<<< HEAD
    public function __construct($text = 'write pending example')
=======
    public function __construct(string $text = 'write pending example')
>>>>>>> v2-test
    {
        parent::__construct(sprintf('todo: %s', $text));
    }
}
