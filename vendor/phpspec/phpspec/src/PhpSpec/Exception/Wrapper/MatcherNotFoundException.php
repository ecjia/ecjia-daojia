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

namespace PhpSpec\Exception\Wrapper;

use PhpSpec\Exception\Exception;

/**
 * Class MatcherNotFoundException holds information about matcher not found
 * exception
 */
class MatcherNotFoundException extends Exception
{
    /**
     * @var string
     */
    private $keyword;

    /**
     * @var mixed
     */
    private $subject;

    /**
     * @var array
     */
    private $arguments;

    /**
     * @param string $message
     * @param string $keyword
     * @param mixed  $subject
     * @param array  $arguments
     */
<<<<<<< HEAD
    public function __construct($message, $keyword, $subject, array $arguments)
=======
    public function __construct(string $message, string $keyword, $subject, array $arguments)
>>>>>>> v2-test
    {
        parent::__construct($message);

        $this->keyword   = $keyword;
        $this->subject   = $subject;
        $this->arguments = $arguments;
    }

    /**
     * @return string
     */
<<<<<<< HEAD
    public function getKeyword()
=======
    public function getKeyword(): string
>>>>>>> v2-test
    {
        return $this->keyword;
    }

    /**
     * @return mixed
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @return array
     */
<<<<<<< HEAD
    public function getArguments()
=======
    public function getArguments(): array
>>>>>>> v2-test
    {
        return $this->arguments;
    }
}
