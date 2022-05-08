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

namespace PhpSpec\Runner;

use PhpSpec\Exception\Wrapper\CollaboratorException;
<<<<<<< HEAD
use PhpSpec\Formatter\Presenter\PresenterInterface;
=======
use PhpSpec\Formatter\Presenter\Presenter;
>>>>>>> v2-test
use PhpSpec\Wrapper\Collaborator;
use ReflectionFunctionAbstract;

class CollaboratorManager
{
    /**
<<<<<<< HEAD
     * @var PresenterInterface
=======
     * @var Presenter
>>>>>>> v2-test
     */
    private $presenter;
    /**
     * @var Collaborator[]
     */
    private $collaborators = array();

    /**
<<<<<<< HEAD
     * @param PresenterInterface $presenter
     */
    public function __construct(PresenterInterface $presenter)
=======
     * @param Presenter $presenter
     */
    public function __construct(Presenter $presenter)
>>>>>>> v2-test
    {
        $this->presenter = $presenter;
    }

    /**
     * @param string       $name
<<<<<<< HEAD
     * @param Collaborator $collaborator
     */
    public function set($name, $collaborator)
=======
     * @param object $collaborator
     */
    public function set(string $name, $collaborator): void
>>>>>>> v2-test
    {
        $this->collaborators[$name] = $collaborator;
    }

    /**
     * @param string $name
     *
     * @return bool
     */
<<<<<<< HEAD
    public function has($name)
=======
    public function has(string $name): bool
>>>>>>> v2-test
    {
        return isset($this->collaborators[$name]);
    }

    /**
     * @param string $name
     *
<<<<<<< HEAD
     * @return Collaborator
     *
     * @throws \PhpSpec\Exception\Wrapper\CollaboratorException
     */
    public function get($name)
=======
     * @return object
     *
     * @throws \PhpSpec\Exception\Wrapper\CollaboratorException
     */
    public function get(string $name)
>>>>>>> v2-test
    {
        if (!$this->has($name)) {
            throw new CollaboratorException(
                sprintf('Collaborator %s not found.', $this->presenter->presentString($name))
            );
        }

        return $this->collaborators[$name];
    }

    /**
     * @param ReflectionFunctionAbstract $function
     *
     * @return array
     */
<<<<<<< HEAD
    public function getArgumentsFor(ReflectionFunctionAbstract $function)
=======
    public function getArgumentsFor(ReflectionFunctionAbstract $function): array
>>>>>>> v2-test
    {
        $parameters = array();
        foreach ($function->getParameters() as $parameter) {
            if ($this->has($parameter->getName())) {
                $parameters[] = $this->get($parameter->getName());
            } else {
                $parameters[] = null;
            }
        }

        return $parameters;
    }
}
