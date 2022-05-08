<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\CssSelector\Node;

use Symfony\Component\CssSelector\Parser\Token;

/**
 * Represents a "<selector>:<name>(<arguments>)" node.
 *
 * This component is a port of the Python cssselect library,
 * which is copyright Ian Bicking, @see https://github.com/SimonSapin/cssselect.
 *
 * @author Jean-François Simon <jeanfrancois.simon@sensiolabs.com>
<<<<<<< HEAD
 */
class FunctionNode extends AbstractNode
{
    /**
     * @var NodeInterface
     */
    private $selector;

    /**
     * @var string
     */
    private $name;

    /**
     * @var Token[]
     */
    private $arguments;

    /**
     * @param NodeInterface $selector
     * @param string        $name
     * @param Token[]       $arguments
     */
    public function __construct(NodeInterface $selector, $name, array $arguments = array())
=======
 *
 * @internal
 */
class FunctionNode extends AbstractNode
{
    private $selector;
    private $name;
    private $arguments;

    /**
     * @param Token[] $arguments
     */
    public function __construct(NodeInterface $selector, string $name, array $arguments = [])
>>>>>>> v2-test
    {
        $this->selector = $selector;
        $this->name = strtolower($name);
        $this->arguments = $arguments;
    }

<<<<<<< HEAD
    /**
     * @return NodeInterface
     */
    public function getSelector()
=======
    public function getSelector(): NodeInterface
>>>>>>> v2-test
    {
        return $this->selector;
    }

<<<<<<< HEAD
    /**
     * @return string
     */
    public function getName()
=======
    public function getName(): string
>>>>>>> v2-test
    {
        return $this->name;
    }

    /**
     * @return Token[]
     */
<<<<<<< HEAD
    public function getArguments()
=======
    public function getArguments(): array
>>>>>>> v2-test
    {
        return $this->arguments;
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function getSpecificity()
=======
    public function getSpecificity(): Specificity
>>>>>>> v2-test
    {
        return $this->selector->getSpecificity()->plus(new Specificity(0, 1, 0));
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function __toString()
=======
    public function __toString(): string
>>>>>>> v2-test
    {
        $arguments = implode(', ', array_map(function (Token $token) {
            return "'".$token->getValue()."'";
        }, $this->arguments));

        return sprintf('%s[%s:%s(%s)]', $this->getNodeName(), $this->selector, $this->name, $arguments ? '['.$arguments.']' : '');
    }
}
