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

use Exception;
use ReflectionParameter;

class CollaboratorNotFoundException extends FractureException
{
    const CLASSNAME_REGEX = '/\\[.* (?P<classname>[_a-z0-9\\\\]+) .*\\]/i';

    /**
     * @var string
     */
    private $collaboratorName;

    /**
     * @param string $message
     * @param integer $code
     * @param Exception $previous
     * @param ReflectionParameter|null $reflectionParameter
     * @param string|null $className
     */
    public function __construct(
<<<<<<< HEAD
        $message,
        $code = 0,
        Exception $previous = null,
        ReflectionParameter $reflectionParameter = null,
        $className = null
=======
        string $message,
        int $code = 0,
        Exception $previous = null,
        ReflectionParameter $reflectionParameter = null,
        string $className = null
>>>>>>> v2-test
    ) {
        if ($reflectionParameter) {
            $this->collaboratorName = $this->extractCollaboratorName($reflectionParameter);
        }
        if ($className) {
            $this->collaboratorName = $className;
        }

        parent::__construct($message . ': ' . $this->collaboratorName, $code, $previous);
    }

    /**
     * @return string
     */
<<<<<<< HEAD
    public function getCollaboratorName()
=======
    public function getCollaboratorName(): string
>>>>>>> v2-test
    {
        return $this->collaboratorName;
    }

    /**
     * @param ReflectionParameter $parameter
     *
     * @return string
     */
<<<<<<< HEAD
    private function extractCollaboratorName(ReflectionParameter $parameter)
=======
    private function extractCollaboratorName(ReflectionParameter $parameter): string
>>>>>>> v2-test
    {
        if (preg_match(self::CLASSNAME_REGEX, (string)$parameter, $matches)) {
            return $matches['classname'];
        }

        return 'Unknown class';
    }
}
