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

/**
 * Represents a "<selector>:<identifier>" node.
 *
 * This component is a port of the Python cssselect library,
 * which is copyright Ian Bicking, @see https://github.com/SimonSapin/cssselect.
 *
 * @author Jean-François Simon <jeanfrancois.simon@sensiolabs.com>
<<<<<<< HEAD
 */
class PseudoNode extends AbstractNode
{
    /**
     * @var NodeInterface
     */
    private $selector;

    /**
     * @var string
     */
    private $identifier;

    /**
     * @param NodeInterface $selector
     * @param string        $identifier
     */
    public function __construct(NodeInterface $selector, $identifier)
=======
 *
 * @internal
 */
class PseudoNode extends AbstractNode
{
    private $selector;
    private $identifier;

    public function __construct(NodeInterface $selector, string $identifier)
>>>>>>> v2-test
    {
        $this->selector = $selector;
        $this->identifier = strtolower($identifier);
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
    public function getIdentifier()
=======
    public function getIdentifier(): string
>>>>>>> v2-test
    {
        return $this->identifier;
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
        return sprintf('%s[%s:%s]', $this->getNodeName(), $this->selector, $this->identifier);
    }
}
