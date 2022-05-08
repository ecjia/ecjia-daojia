<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\CssSelector\XPath\Extension;

use Symfony\Component\CssSelector\Exception\ExpressionErrorException;
use Symfony\Component\CssSelector\XPath\XPathExpr;

/**
 * XPath expression translator pseudo-class extension.
 *
 * This component is a port of the Python cssselect library,
 * which is copyright Ian Bicking, @see https://github.com/SimonSapin/cssselect.
 *
 * @author Jean-François Simon <jeanfrancois.simon@sensiolabs.com>
<<<<<<< HEAD
=======
 *
 * @internal
>>>>>>> v2-test
 */
class PseudoClassExtension extends AbstractExtension
{
    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function getPseudoClassTranslators()
    {
        return array(
            'root' => array($this, 'translateRoot'),
            'first-child' => array($this, 'translateFirstChild'),
            'last-child' => array($this, 'translateLastChild'),
            'first-of-type' => array($this, 'translateFirstOfType'),
            'last-of-type' => array($this, 'translateLastOfType'),
            'only-child' => array($this, 'translateOnlyChild'),
            'only-of-type' => array($this, 'translateOnlyOfType'),
            'empty' => array($this, 'translateEmpty'),
        );
    }

    /**
     * @param XPathExpr $xpath
     *
     * @return XPathExpr
     */
    public function translateRoot(XPathExpr $xpath)
=======
    public function getPseudoClassTranslators(): array
    {
        return [
            'root' => [$this, 'translateRoot'],
            'first-child' => [$this, 'translateFirstChild'],
            'last-child' => [$this, 'translateLastChild'],
            'first-of-type' => [$this, 'translateFirstOfType'],
            'last-of-type' => [$this, 'translateLastOfType'],
            'only-child' => [$this, 'translateOnlyChild'],
            'only-of-type' => [$this, 'translateOnlyOfType'],
            'empty' => [$this, 'translateEmpty'],
        ];
    }

    public function translateRoot(XPathExpr $xpath): XPathExpr
>>>>>>> v2-test
    {
        return $xpath->addCondition('not(parent::*)');
    }

<<<<<<< HEAD
    /**
     * @param XPathExpr $xpath
     *
     * @return XPathExpr
     */
    public function translateFirstChild(XPathExpr $xpath)
=======
    public function translateFirstChild(XPathExpr $xpath): XPathExpr
>>>>>>> v2-test
    {
        return $xpath
            ->addStarPrefix()
            ->addNameTest()
            ->addCondition('position() = 1');
    }

<<<<<<< HEAD
    /**
     * @param XPathExpr $xpath
     *
     * @return XPathExpr
     */
    public function translateLastChild(XPathExpr $xpath)
=======
    public function translateLastChild(XPathExpr $xpath): XPathExpr
>>>>>>> v2-test
    {
        return $xpath
            ->addStarPrefix()
            ->addNameTest()
            ->addCondition('position() = last()');
    }

    /**
<<<<<<< HEAD
     * @param XPathExpr $xpath
     *
     * @return XPathExpr
     *
     * @throws ExpressionErrorException
     */
    public function translateFirstOfType(XPathExpr $xpath)
=======
     * @throws ExpressionErrorException
     */
    public function translateFirstOfType(XPathExpr $xpath): XPathExpr
>>>>>>> v2-test
    {
        if ('*' === $xpath->getElement()) {
            throw new ExpressionErrorException('"*:first-of-type" is not implemented.');
        }

        return $xpath
            ->addStarPrefix()
            ->addCondition('position() = 1');
    }

    /**
<<<<<<< HEAD
     * @param XPathExpr $xpath
     *
     * @return XPathExpr
     *
     * @throws ExpressionErrorException
     */
    public function translateLastOfType(XPathExpr $xpath)
=======
     * @throws ExpressionErrorException
     */
    public function translateLastOfType(XPathExpr $xpath): XPathExpr
>>>>>>> v2-test
    {
        if ('*' === $xpath->getElement()) {
            throw new ExpressionErrorException('"*:last-of-type" is not implemented.');
        }

        return $xpath
            ->addStarPrefix()
            ->addCondition('position() = last()');
    }

<<<<<<< HEAD
    /**
     * @param XPathExpr $xpath
     *
     * @return XPathExpr
     */
    public function translateOnlyChild(XPathExpr $xpath)
=======
    public function translateOnlyChild(XPathExpr $xpath): XPathExpr
>>>>>>> v2-test
    {
        return $xpath
            ->addStarPrefix()
            ->addNameTest()
            ->addCondition('last() = 1');
    }

<<<<<<< HEAD
    /**
     * @param XPathExpr $xpath
     *
     * @return XPathExpr
     *
     * @throws ExpressionErrorException
     */
    public function translateOnlyOfType(XPathExpr $xpath)
    {
        if ('*' === $xpath->getElement()) {
            throw new ExpressionErrorException('"*:only-of-type" is not implemented.');
        }

        return $xpath->addCondition('last() = 1');
    }

    /**
     * @param XPathExpr $xpath
     *
     * @return XPathExpr
     */
    public function translateEmpty(XPathExpr $xpath)
=======
    public function translateOnlyOfType(XPathExpr $xpath): XPathExpr
    {
        $element = $xpath->getElement();

        return $xpath->addCondition(sprintf('count(preceding-sibling::%s)=0 and count(following-sibling::%s)=0', $element, $element));
    }

    public function translateEmpty(XPathExpr $xpath): XPathExpr
>>>>>>> v2-test
    {
        return $xpath->addCondition('not(*) and not(string-length())');
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function getName()
=======
    public function getName(): string
>>>>>>> v2-test
    {
        return 'pseudo-class';
    }
}
