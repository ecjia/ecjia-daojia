<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\CssSelector\XPath;

/**
 * XPath expression translator interface.
 *
 * This component is a port of the Python cssselect library,
 * which is copyright Ian Bicking, @see https://github.com/SimonSapin/cssselect.
 *
 * @author Jean-François Simon <jeanfrancois.simon@sensiolabs.com>
<<<<<<< HEAD
 */
class XPathExpr
{
    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $element;

    /**
     * @var string
     */
    private $condition;

    /**
     * @param string $path
     * @param string $element
     * @param string $condition
     * @param bool   $starPrefix
     */
    public function __construct($path = '', $element = '*', $condition = '', $starPrefix = false)
=======
 *
 * @internal
 */
class XPathExpr
{
    private $path;
    private $element;
    private $condition;

    public function __construct(string $path = '', string $element = '*', string $condition = '', bool $starPrefix = false)
>>>>>>> v2-test
    {
        $this->path = $path;
        $this->element = $element;
        $this->condition = $condition;

        if ($starPrefix) {
            $this->addStarPrefix();
        }
    }

<<<<<<< HEAD
    /**
     * @return string
     */
    public function getElement()
=======
    public function getElement(): string
>>>>>>> v2-test
    {
        return $this->element;
    }

<<<<<<< HEAD
    /**
     * @param $condition
     *
     * @return XPathExpr
     */
    public function addCondition($condition)
    {
        $this->condition = $this->condition ? sprintf('%s and (%s)', $this->condition, $condition) : $condition;
=======
    public function addCondition(string $condition): self
    {
        $this->condition = $this->condition ? sprintf('(%s) and (%s)', $this->condition, $condition) : $condition;
>>>>>>> v2-test

        return $this;
    }

<<<<<<< HEAD
    /**
     * @return string
     */
    public function getCondition()
=======
    public function getCondition(): string
>>>>>>> v2-test
    {
        return $this->condition;
    }

<<<<<<< HEAD
    /**
     * @return XPathExpr
     */
    public function addNameTest()
=======
    public function addNameTest(): self
>>>>>>> v2-test
    {
        if ('*' !== $this->element) {
            $this->addCondition('name() = '.Translator::getXpathLiteral($this->element));
            $this->element = '*';
        }

        return $this;
    }

<<<<<<< HEAD
    /**
     * @return XPathExpr
     */
    public function addStarPrefix()
=======
    public function addStarPrefix(): self
>>>>>>> v2-test
    {
        $this->path .= '*/';

        return $this;
    }

    /**
     * Joins another XPathExpr with a combiner.
     *
<<<<<<< HEAD
     * @param string    $combiner
     * @param XPathExpr $expr
     *
     * @return XPathExpr
     */
    public function join($combiner, XPathExpr $expr)
=======
     * @return $this
     */
    public function join(string $combiner, self $expr): self
>>>>>>> v2-test
    {
        $path = $this->__toString().$combiner;

        if ('*/' !== $expr->path) {
            $path .= $expr->path;
        }

        $this->path = $path;
        $this->element = $expr->element;
        $this->condition = $expr->condition;

        return $this;
    }

<<<<<<< HEAD
    /**
     * @return string
     */
    public function __toString()
=======
    public function __toString(): string
>>>>>>> v2-test
    {
        $path = $this->path.$this->element;
        $condition = null === $this->condition || '' === $this->condition ? '' : '['.$this->condition.']';

        return $path.$condition;
    }
}
