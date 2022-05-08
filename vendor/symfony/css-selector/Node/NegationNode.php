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
 * Represents a "<selector>:not(<identifier>)" node.
 *
 * This component is a port of the Python cssselect library,
 * which is copyright Ian Bicking, @see https://github.com/SimonSapin/cssselect.
 *
 * @author Jean-François Simon <jeanfrancois.simon@sensiolabs.com>
<<<<<<< HEAD
 */
class NegationNode extends AbstractNode
{
    /**
     * @var NodeInterface
     */
    private $selector;

    /**
     * @var NodeInterface
     */
    private $subSelector;

    /**
     * @param NodeInterface $selector
     * @param NodeInterface $subSelector
     */
=======
 *
 * @internal
 */
class NegationNode extends AbstractNode
{
    private $selector;
    private $subSelector;

>>>>>>> v2-test
    public function __construct(NodeInterface $selector, NodeInterface $subSelector)
    {
        $this->selector = $selector;
        $this->subSelector = $subSelector;
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
     * @return NodeInterface
     */
    public function getSubSelector()
=======
    public function getSubSelector(): NodeInterface
>>>>>>> v2-test
    {
        return $this->subSelector;
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
        return $this->selector->getSpecificity()->plus($this->subSelector->getSpecificity());
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
        return sprintf('%s[%s:not(%s)]', $this->getNodeName(), $this->selector, $this->subSelector);
    }
}
