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

namespace PhpSpec\Event;

<<<<<<< HEAD
use Symfony\Component\EventDispatcher\Event;

final class FileCreationEvent extends Event implements EventInterface
=======
final class FileCreationEvent extends BaseEvent implements PhpSpecEvent
>>>>>>> v2-test
{
    /**
     * @var string
     */
    private $filepath;

    public function __construct($filepath)
    {

        $this->filepath = $filepath;
    }

    /**
     * @return string
     */
<<<<<<< HEAD
    public function getFilePath()
=======
    public function getFilePath(): string
>>>>>>> v2-test
    {
        return $this->filepath;
    }
}
