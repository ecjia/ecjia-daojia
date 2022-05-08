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
 * Represents a "<selector>(::|:)<pseudoElement>" node.
 *
 * This component is a port of the Python cssselect library,
 * which is copyright Ian Bicking, @see https://github.com/SimonSapin/cssselect.
 *
 * @author Jean-François Simon <jeanfrancois.simon@sensiolabs.com>
<<<<<<< HEAD
 */
class SelectorNode extends AbstractNode
{
    /**
     * @var NodeInterface
     */
    private $tree;

    /**
     * @var null|string
     */
    private $pseudoElement;

    /**
     * @param NodeInterface $tree
     * @param null|string   $pseudoElement
     */
    public function __construct(NodeInterface $tree, $pseudoElement = null)
=======
 *
 * @internal
 */
class SelectorNode extends AbstractNode
{
    private $tree;
    private $pseudoElement;

    public function __construct(NodeInterface $tree, string $pseudoElement = null)
>>>>>>> v2-test
    {
        $this->tree = $tree;
        $this->pseudoElement = $pseudoElement ? strtolower($pseudoElement) : null;
    }

<<<<<<< HEAD
    /**
     * @return NodeInterface
     */
    public function getTree()
=======
    public function getTree(): NodeInterface
>>>>>>> v2-test
    {
        return $this->tree;
    }

<<<<<<< HEAD
    /**
     * @return null|string
     */
    public function getPseudoElement()
=======
    public function getPseudoElement(): ?string
>>>>>>> v2-test
    {
        return $this->pseudoElement;
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
        return $this->tree->getSpecificity()->plus(new Specificity(0, 0, $this->pseudoElement ? 1 : 0));
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
        return sprintf('%s[%s%s]', $this->getNodeName(), $this->tree, $this->pseudoElement ? '::'.$this->pseudoElement : '');
    }
}
