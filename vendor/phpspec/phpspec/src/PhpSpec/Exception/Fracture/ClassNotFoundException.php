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

namespace PhpSpec\Exception\Fracture;

/**
 * Class ClassNotFoundException holds information about class not found exception
 */
class ClassNotFoundException extends FractureException
{
    /**
     * @var string
     */
    private $classname;

    /**
     * @param string $message
     * @param string $classname
     */
<<<<<<< HEAD
    public function __construct($message, $classname)
=======
    public function __construct(string $message, string $classname)
>>>>>>> v2-test
    {
        parent::__construct($message);

        $this->classname = $classname;
    }

    /**
     * @return string
     */
<<<<<<< HEAD
    public function getClassname()
=======
    public function getClassname(): string
>>>>>>> v2-test
    {
        return $this->classname;
    }
}
