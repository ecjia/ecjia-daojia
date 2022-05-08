<<<<<<< HEAD
<?php
/*
 * This file is part of the Comparator package.
=======
<?php declare(strict_types=1);
/*
 * This file is part of sebastian/comparator.
>>>>>>> v2-test
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
<<<<<<< HEAD

namespace SebastianBergmann\Comparator;

use DOMDocument;
use DOMNode;
=======
namespace SebastianBergmann\Comparator;

use function sprintf;
use function strtolower;
use DOMDocument;
use DOMNode;
use ValueError;
>>>>>>> v2-test

/**
 * Compares DOMNode instances for equality.
 */
class DOMNodeComparator extends ObjectComparator
{
    /**
     * Returns whether the comparator can compare two values.
     *
<<<<<<< HEAD
     * @param  mixed $expected The first value to compare
     * @param  mixed $actual   The second value to compare
=======
     * @param mixed $expected The first value to compare
     * @param mixed $actual   The second value to compare
     *
>>>>>>> v2-test
     * @return bool
     */
    public function accepts($expected, $actual)
    {
        return $expected instanceof DOMNode && $actual instanceof DOMNode;
    }

    /**
     * Asserts that two values are equal.
     *
<<<<<<< HEAD
     * @param  mixed             $expected     The first value to compare
     * @param  mixed             $actual       The second value to compare
     * @param  float             $delta        The allowed numerical distance between two values to
     *                                         consider them equal
     * @param  bool              $canonicalize If set to TRUE, arrays are sorted before
     *                                         comparison
     * @param  bool              $ignoreCase   If set to TRUE, upper- and lowercasing is
     *                                         ignored when comparing string values
     * @throws ComparisonFailure Thrown when the comparison
     *                                        fails. Contains information about the
     *                                        specific errors that lead to the failure.
     */
    public function assertEquals($expected, $actual, $delta = 0.0, $canonicalize = false, $ignoreCase = false)
=======
     * @param mixed $expected     First value to compare
     * @param mixed $actual       Second value to compare
     * @param float $delta        Allowed numerical distance between two values to consider them equal
     * @param bool  $canonicalize Arrays are sorted before comparison when set to true
     * @param bool  $ignoreCase   Case is ignored when set to true
     * @param array $processed    List of already processed elements (used to prevent infinite recursion)
     *
     * @throws ComparisonFailure
     */
    public function assertEquals($expected, $actual, $delta = 0.0, $canonicalize = false, $ignoreCase = false, array &$processed = [])/*: void*/
>>>>>>> v2-test
    {
        $expectedAsString = $this->nodeToText($expected, true, $ignoreCase);
        $actualAsString   = $this->nodeToText($actual, true, $ignoreCase);

        if ($expectedAsString !== $actualAsString) {
<<<<<<< HEAD
            if ($expected instanceof DOMDocument) {
                $type = 'documents';
            } else {
                $type = 'nodes';
            }
=======
            $type = $expected instanceof DOMDocument ? 'documents' : 'nodes';
>>>>>>> v2-test

            throw new ComparisonFailure(
                $expected,
                $actual,
                $expectedAsString,
                $actualAsString,
                false,
                sprintf("Failed asserting that two DOM %s are equal.\n", $type)
            );
        }
    }

    /**
     * Returns the normalized, whitespace-cleaned, and indented textual
     * representation of a DOMNode.
<<<<<<< HEAD
     *
     * @param  DOMNode $node
     * @param  bool    $canonicalize
     * @param  bool    $ignoreCase
     * @return string
     */
    private function nodeToText(DOMNode $node, $canonicalize, $ignoreCase)
    {
        if ($canonicalize) {
            $document = new DOMDocument;
            $document->loadXML($node->C14N());
=======
     */
    private function nodeToText(DOMNode $node, bool $canonicalize, bool $ignoreCase): string
    {
        if ($canonicalize) {
            $document = new DOMDocument;

            try {
                @$document->loadXML($node->C14N());
            } catch (ValueError $e) {
            }
>>>>>>> v2-test

            $node = $document;
        }

<<<<<<< HEAD
        if ($node instanceof DOMDocument) {
            $document = $node;
        } else {
            $document = $node->ownerDocument;
        }
=======
        $document = $node instanceof DOMDocument ? $node : $node->ownerDocument;
>>>>>>> v2-test

        $document->formatOutput = true;
        $document->normalizeDocument();

<<<<<<< HEAD
        if ($node instanceof DOMDocument) {
            $text = $node->saveXML();
        } else {
            $text = $document->saveXML($node);
        }

        if ($ignoreCase) {
            $text = strtolower($text);
        }

        return $text;
=======
        $text = $node instanceof DOMDocument ? $node->saveXML() : $document->saveXML($node);

        return $ignoreCase ? strtolower($text) : $text;
>>>>>>> v2-test
    }
}
