<?php

/*
 * This file is part of the Prophecy.
 * (c) Konstantin Kudryashov <ever.zet@gmail.com>
 *     Marcello Duarte <marcello.duarte@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Prophecy\Doubler\ClassPatch;

<<<<<<< HEAD
use Prophecy\Doubler\Generator\Node\ClassNode;
use Prophecy\Doubler\Generator\Node\MethodNode;
use Prophecy\Doubler\Generator\Node\ArgumentNode;
=======
use Prophecy\Doubler\Generator\Node\ArgumentTypeNode;
use Prophecy\Doubler\Generator\Node\ClassNode;
use Prophecy\Doubler\Generator\Node\MethodNode;
use Prophecy\Doubler\Generator\Node\ArgumentNode;
use Prophecy\Doubler\Generator\Node\ReturnTypeNode;
>>>>>>> v2-test

/**
 * Add Prophecy functionality to the double.
 * This is a core class patch for Prophecy.
 *
 * @author Konstantin Kudryashov <ever.zet@gmail.com>
 */
class ProphecySubjectPatch implements ClassPatchInterface
{
    /**
     * Always returns true.
     *
     * @param ClassNode $node
     *
     * @return bool
     */
    public function supports(ClassNode $node)
    {
        return true;
    }

    /**
     * Apply Prophecy functionality to class node.
     *
     * @param ClassNode $node
     */
    public function apply(ClassNode $node)
    {
        $node->addInterface('Prophecy\Prophecy\ProphecySubjectInterface');
<<<<<<< HEAD
        $node->addProperty('objectProphecy', 'private');
=======
        $node->addProperty('objectProphecyClosure', 'private');
>>>>>>> v2-test

        foreach ($node->getMethods() as $name => $method) {
            if ('__construct' === strtolower($name)) {
                continue;
            }

<<<<<<< HEAD
            $method->setCode(
                'return $this->getProphecy()->makeProphecyMethodCall(__FUNCTION__, func_get_args());'
            );
=======
            if ($method->getReturnTypeNode()->isVoid()) {
                $method->setCode(
                    '$this->getProphecy()->makeProphecyMethodCall(__FUNCTION__, func_get_args());'
                );
            } else {
                $method->setCode(
                    'return $this->getProphecy()->makeProphecyMethodCall(__FUNCTION__, func_get_args());'
                );
            }
>>>>>>> v2-test
        }

        $prophecySetter = new MethodNode('setProphecy');
        $prophecyArgument = new ArgumentNode('prophecy');
<<<<<<< HEAD
        $prophecyArgument->setTypeHint('Prophecy\Prophecy\ProphecyInterface');
        $prophecySetter->addArgument($prophecyArgument);
        $prophecySetter->setCode('$this->objectProphecy = $prophecy;');

        $prophecyGetter = new MethodNode('getProphecy');
        $prophecyGetter->setCode('return $this->objectProphecy;');
=======
        $prophecyArgument->setTypeNode(new ArgumentTypeNode('Prophecy\Prophecy\ProphecyInterface'));
        $prophecySetter->addArgument($prophecyArgument);
        $prophecySetter->setCode(<<<PHP
if (null === \$this->objectProphecyClosure) {
    \$this->objectProphecyClosure = static function () use (\$prophecy) {
        return \$prophecy;
    };
}
PHP
    );

        $prophecyGetter = new MethodNode('getProphecy');
        $prophecyGetter->setCode('return \call_user_func($this->objectProphecyClosure);');
>>>>>>> v2-test

        if ($node->hasMethod('__call')) {
            $__call = $node->getMethod('__call');
        } else {
            $__call = new MethodNode('__call');
            $__call->addArgument(new ArgumentNode('name'));
            $__call->addArgument(new ArgumentNode('arguments'));

<<<<<<< HEAD
            $node->addMethod($__call);
=======
            $node->addMethod($__call, true);
>>>>>>> v2-test
        }

        $__call->setCode(<<<PHP
throw new \Prophecy\Exception\Doubler\MethodNotFoundException(
    sprintf('Method `%s::%s()` not found.', get_class(\$this), func_get_arg(0)),
<<<<<<< HEAD
    \$this->getProphecy(), func_get_arg(0)
=======
    get_class(\$this), func_get_arg(0)
>>>>>>> v2-test
);
PHP
        );

<<<<<<< HEAD
        $node->addMethod($prophecySetter);
        $node->addMethod($prophecyGetter);
=======
        $node->addMethod($prophecySetter, true);
        $node->addMethod($prophecyGetter, true);
>>>>>>> v2-test
    }

    /**
     * Returns patch priority, which determines when patch will be applied.
     *
     * @return int Priority number (higher - earlier)
     */
    public function getPriority()
    {
        return 0;
    }
}
