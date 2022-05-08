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
 * Represents a combined node.
 *
 * This component is a port of the Python cssselect library,
 * which is copyright Ian Bicking, @see https://github.com/SimonSapin/cssselect.
 *
 * @author Jean-François Simon <jeanfrancois.simon@sensiolabs.com>
<<<<<<< HEAD
 */
class CombinedSelectorNode extends AbstractNode
{
    /**
     * @var NodeInterface
     */
    private $selector;

    /**
     * @var string
     */
    private $combinator;

    /**
     * @var NodeInterface
     */
    private $subSelector;

    /**
     * @param NodeInterface $selector
     * @param string        $combinator
     * @param NodeInterface $subSelector
     */
    public function __construct(NodeInterface $selector, $combinator, NodeInterface $subSelector)
=======
 *
 * @internal
 */
class CombinedSelectorNode extends AbstractNode
{
    private $selector;
    private $combinator;
    private $subSelector;

    public function __construct(NodeInterface $selector, string $combinator, NodeInterface $subSelector)
>>>>>>> v2-test
    {
        $this->selector = $selector;
        $this->combinator = $combinator;
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
     * @return string
     */
    public function getCombinator()
=======
    public function getCombinator(): string
>>>>>>> v2-test
    {
        return $this->combinator;
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
        $combinator = ' ' === $this->combinator ? '<followed>' : $this->combinator;

        return sprintf('%s[%s %s %s]', $this->getNodeName(), $this->selector, $combinator, $this->subSelector);
    }
}
