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

/**
 * XPath expression translator abstract extension.
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
abstract class AbstractExtension implements ExtensionInterface
{
    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function getNodeTranslators()
    {
        return array();
=======
    public function getNodeTranslators(): array
    {
        return [];
>>>>>>> v2-test
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function getCombinationTranslators()
    {
        return array();
=======
    public function getCombinationTranslators(): array
    {
        return [];
>>>>>>> v2-test
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function getFunctionTranslators()
    {
        return array();
=======
    public function getFunctionTranslators(): array
    {
        return [];
>>>>>>> v2-test
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function getPseudoClassTranslators()
    {
        return array();
=======
    public function getPseudoClassTranslators(): array
    {
        return [];
>>>>>>> v2-test
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function getAttributeMatchingTranslators()
    {
        return array();
=======
    public function getAttributeMatchingTranslators(): array
    {
        return [];
>>>>>>> v2-test
    }
}
