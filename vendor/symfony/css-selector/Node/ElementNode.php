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
 * Represents a "<namespace>|<element>" node.
 *
 * This component is a port of the Python cssselect library,
 * which is copyright Ian Bicking, @see https://github.com/SimonSapin/cssselect.
 *
 * @author Jean-François Simon <jeanfrancois.simon@sensiolabs.com>
<<<<<<< HEAD
 */
class ElementNode extends AbstractNode
{
    /**
     * @var string|null
     */
    private $namespace;

    /**
     * @var string|null
     */
    private $element;

    /**
     * @param string|null $namespace
     * @param string|null $element
     */
    public function __construct($namespace = null, $element = null)
=======
 *
 * @internal
 */
class ElementNode extends AbstractNode
{
    private $namespace;
    private $element;

    public function __construct(string $namespace = null, string $element = null)
>>>>>>> v2-test
    {
        $this->namespace = $namespace;
        $this->element = $element;
    }

<<<<<<< HEAD
    /**
     * @return null|string
     */
    public function getNamespace()
=======
    public function getNamespace(): ?string
>>>>>>> v2-test
    {
        return $this->namespace;
    }

<<<<<<< HEAD
    /**
     * @return null|string
     */
    public function getElement()
=======
    public function getElement(): ?string
>>>>>>> v2-test
    {
        return $this->element;
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
        return new Specificity(0, 0, $this->element ? 1 : 0);
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
        $element = $this->element ?: '*';

        return sprintf('%s[%s]', $this->getNodeName(), $this->namespace ? $this->namespace.'|'.$element : $element);
    }
}
