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

use Symfony\Component\CssSelector\Exception\ExpressionErrorException;
use Symfony\Component\CssSelector\Node\FunctionNode;
use Symfony\Component\CssSelector\Node\NodeInterface;
use Symfony\Component\CssSelector\Node\SelectorNode;
use Symfony\Component\CssSelector\Parser\Parser;
use Symfony\Component\CssSelector\Parser\ParserInterface;

/**
 * XPath expression translator interface.
 *
 * This component is a port of the Python cssselect library,
 * which is copyright Ian Bicking, @see https://github.com/SimonSapin/cssselect.
 *
 * @author Jean-François Simon <jeanfrancois.simon@sensiolabs.com>
<<<<<<< HEAD
 */
class Translator implements TranslatorInterface
{
    /**
     * @var ParserInterface
     */
=======
 *
 * @internal
 */
class Translator implements TranslatorInterface
{
>>>>>>> v2-test
    private $mainParser;

    /**
     * @var ParserInterface[]
     */
<<<<<<< HEAD
    private $shortcutParsers = array();

    /**
     * @var Extension\ExtensionInterface
     */
    private $extensions = array();

    /**
     * @var array
     */
    private $nodeTranslators = array();

    /**
     * @var array
     */
    private $combinationTranslators = array();

    /**
     * @var array
     */
    private $functionTranslators = array();

    /**
     * @var array
     */
    private $pseudoClassTranslators = array();

    /**
     * @var array
     */
    private $attributeMatchingTranslators = array();
=======
    private $shortcutParsers = [];

    /**
     * @var Extension\ExtensionInterface[]
     */
    private $extensions = [];

    private $nodeTranslators = [];
    private $combinationTranslators = [];
    private $functionTranslators = [];
    private $pseudoClassTranslators = [];
    private $attributeMatchingTranslators = [];
>>>>>>> v2-test

    public function __construct(ParserInterface $parser = null)
    {
        $this->mainParser = $parser ?: new Parser();

        $this
            ->registerExtension(new Extension\NodeExtension())
            ->registerExtension(new Extension\CombinationExtension())
            ->registerExtension(new Extension\FunctionExtension())
            ->registerExtension(new Extension\PseudoClassExtension())
            ->registerExtension(new Extension\AttributeMatchingExtension())
        ;
    }

<<<<<<< HEAD
    /**
     * @param string $element
     *
     * @return string
     */
    public static function getXpathLiteral($element)
=======
    public static function getXpathLiteral(string $element): string
>>>>>>> v2-test
    {
        if (false === strpos($element, "'")) {
            return "'".$element."'";
        }

        if (false === strpos($element, '"')) {
            return '"'.$element.'"';
        }

        $string = $element;
<<<<<<< HEAD
        $parts = array();
=======
        $parts = [];
>>>>>>> v2-test
        while (true) {
            if (false !== $pos = strpos($string, "'")) {
                $parts[] = sprintf("'%s'", substr($string, 0, $pos));
                $parts[] = "\"'\"";
                $string = substr($string, $pos + 1);
            } else {
                $parts[] = "'$string'";
                break;
            }
        }

<<<<<<< HEAD
        return sprintf('concat(%s)', implode($parts, ', '));
=======
        return sprintf('concat(%s)', implode(', ', $parts));
>>>>>>> v2-test
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function cssToXPath($cssExpr, $prefix = 'descendant-or-self::')
=======
    public function cssToXPath(string $cssExpr, string $prefix = 'descendant-or-self::'): string
>>>>>>> v2-test
    {
        $selectors = $this->parseSelectors($cssExpr);

        /** @var SelectorNode $selector */
        foreach ($selectors as $index => $selector) {
            if (null !== $selector->getPseudoElement()) {
                throw new ExpressionErrorException('Pseudo-elements are not supported.');
            }

            $selectors[$index] = $this->selectorToXPath($selector, $prefix);
        }

        return implode(' | ', $selectors);
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function selectorToXPath(SelectorNode $selector, $prefix = 'descendant-or-self::')
=======
    public function selectorToXPath(SelectorNode $selector, string $prefix = 'descendant-or-self::'): string
>>>>>>> v2-test
    {
        return ($prefix ?: '').$this->nodeToXPath($selector);
    }

    /**
<<<<<<< HEAD
     * Registers an extension.
     *
     * @param Extension\ExtensionInterface $extension
     *
     * @return Translator
     */
    public function registerExtension(Extension\ExtensionInterface $extension)
=======
     * @return $this
     */
    public function registerExtension(Extension\ExtensionInterface $extension): self
>>>>>>> v2-test
    {
        $this->extensions[$extension->getName()] = $extension;

        $this->nodeTranslators = array_merge($this->nodeTranslators, $extension->getNodeTranslators());
        $this->combinationTranslators = array_merge($this->combinationTranslators, $extension->getCombinationTranslators());
        $this->functionTranslators = array_merge($this->functionTranslators, $extension->getFunctionTranslators());
        $this->pseudoClassTranslators = array_merge($this->pseudoClassTranslators, $extension->getPseudoClassTranslators());
        $this->attributeMatchingTranslators = array_merge($this->attributeMatchingTranslators, $extension->getAttributeMatchingTranslators());

        return $this;
    }

    /**
<<<<<<< HEAD
     * @param string $name
     *
     * @return Extension\ExtensionInterface
     *
     * @throws ExpressionErrorException
     */
    public function getExtension($name)
=======
     * @throws ExpressionErrorException
     */
    public function getExtension(string $name): Extension\ExtensionInterface
>>>>>>> v2-test
    {
        if (!isset($this->extensions[$name])) {
            throw new ExpressionErrorException(sprintf('Extension "%s" not registered.', $name));
        }

        return $this->extensions[$name];
    }

    /**
<<<<<<< HEAD
     * Registers a shortcut parser.
     *
     * @param ParserInterface $shortcut
     *
     * @return Translator
     */
    public function registerParserShortcut(ParserInterface $shortcut)
=======
     * @return $this
     */
    public function registerParserShortcut(ParserInterface $shortcut): self
>>>>>>> v2-test
    {
        $this->shortcutParsers[] = $shortcut;

        return $this;
    }

    /**
<<<<<<< HEAD
     * @param NodeInterface $node
     *
     * @return XPathExpr
     *
     * @throws ExpressionErrorException
     */
    public function nodeToXPath(NodeInterface $node)
=======
     * @throws ExpressionErrorException
     */
    public function nodeToXPath(NodeInterface $node): XPathExpr
>>>>>>> v2-test
    {
        if (!isset($this->nodeTranslators[$node->getNodeName()])) {
            throw new ExpressionErrorException(sprintf('Node "%s" not supported.', $node->getNodeName()));
        }

<<<<<<< HEAD
        return call_user_func($this->nodeTranslators[$node->getNodeName()], $node, $this);
    }

    /**
     * @param string        $combiner
     * @param NodeInterface $xpath
     * @param NodeInterface $combinedXpath
     *
     * @return XPathExpr
     *
     * @throws ExpressionErrorException
     */
    public function addCombination($combiner, NodeInterface $xpath, NodeInterface $combinedXpath)
=======
        return $this->nodeTranslators[$node->getNodeName()]($node, $this);
    }

    /**
     * @throws ExpressionErrorException
     */
    public function addCombination(string $combiner, NodeInterface $xpath, NodeInterface $combinedXpath): XPathExpr
>>>>>>> v2-test
    {
        if (!isset($this->combinationTranslators[$combiner])) {
            throw new ExpressionErrorException(sprintf('Combiner "%s" not supported.', $combiner));
        }

<<<<<<< HEAD
        return call_user_func($this->combinationTranslators[$combiner], $this->nodeToXPath($xpath), $this->nodeToXPath($combinedXpath));
    }

    /**
     * @param XPathExpr    $xpath
     * @param FunctionNode $function
     *
     * @return XPathExpr
     *
     * @throws ExpressionErrorException
     */
    public function addFunction(XPathExpr $xpath, FunctionNode $function)
=======
        return $this->combinationTranslators[$combiner]($this->nodeToXPath($xpath), $this->nodeToXPath($combinedXpath));
    }

    /**
     * @throws ExpressionErrorException
     */
    public function addFunction(XPathExpr $xpath, FunctionNode $function): XPathExpr
>>>>>>> v2-test
    {
        if (!isset($this->functionTranslators[$function->getName()])) {
            throw new ExpressionErrorException(sprintf('Function "%s" not supported.', $function->getName()));
        }

<<<<<<< HEAD
        return call_user_func($this->functionTranslators[$function->getName()], $xpath, $function);
    }

    /**
     * @param XPathExpr $xpath
     * @param string    $pseudoClass
     *
     * @return XPathExpr
     *
     * @throws ExpressionErrorException
     */
    public function addPseudoClass(XPathExpr $xpath, $pseudoClass)
=======
        return $this->functionTranslators[$function->getName()]($xpath, $function);
    }

    /**
     * @throws ExpressionErrorException
     */
    public function addPseudoClass(XPathExpr $xpath, string $pseudoClass): XPathExpr
>>>>>>> v2-test
    {
        if (!isset($this->pseudoClassTranslators[$pseudoClass])) {
            throw new ExpressionErrorException(sprintf('Pseudo-class "%s" not supported.', $pseudoClass));
        }

<<<<<<< HEAD
        return call_user_func($this->pseudoClassTranslators[$pseudoClass], $xpath);
    }

    /**
     * @param XPathExpr $xpath
     * @param string    $operator
     * @param string    $attribute
     * @param string    $value
     *
     * @return XPathExpr
     *
     * @throws ExpressionErrorException
     */
    public function addAttributeMatching(XPathExpr $xpath, $operator, $attribute, $value)
=======
        return $this->pseudoClassTranslators[$pseudoClass]($xpath);
    }

    /**
     * @throws ExpressionErrorException
     */
    public function addAttributeMatching(XPathExpr $xpath, string $operator, string $attribute, $value): XPathExpr
>>>>>>> v2-test
    {
        if (!isset($this->attributeMatchingTranslators[$operator])) {
            throw new ExpressionErrorException(sprintf('Attribute matcher operator "%s" not supported.', $operator));
        }

<<<<<<< HEAD
        return call_user_func($this->attributeMatchingTranslators[$operator], $xpath, $attribute, $value);
    }

    /**
     * @param string $css
     *
     * @return SelectorNode[]
     */
    private function parseSelectors($css)
=======
        return $this->attributeMatchingTranslators[$operator]($xpath, $attribute, $value);
    }

    /**
     * @return SelectorNode[]
     */
    private function parseSelectors(string $css): array
>>>>>>> v2-test
    {
        foreach ($this->shortcutParsers as $shortcut) {
            $tokens = $shortcut->parse($css);

            if (!empty($tokens)) {
                return $tokens;
            }
        }

        return $this->mainParser->parse($css);
    }
}
