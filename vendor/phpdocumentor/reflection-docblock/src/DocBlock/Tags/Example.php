<?php
<<<<<<< HEAD
=======

declare(strict_types=1);

>>>>>>> v2-test
/**
 * This file is part of phpDocumentor.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
<<<<<<< HEAD
 * @copyright 2010-2015 Mike van Riel<mike@phpdoc.org>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
=======
>>>>>>> v2-test
 * @link      http://phpdoc.org
 */

namespace phpDocumentor\Reflection\DocBlock\Tags;

use phpDocumentor\Reflection\DocBlock\Tag;
<<<<<<< HEAD
=======
use Webmozart\Assert\Assert;
use function array_key_exists;
use function preg_match;
use function rawurlencode;
use function str_replace;
use function strpos;
use function trim;
>>>>>>> v2-test

/**
 * Reflection class for a {@}example tag in a Docblock.
 */
<<<<<<< HEAD
final class Example extends BaseTag
{
    /**
     * @var string Path to a file to use as an example. May also be an absolute URI.
     */
    private $filePath = '';
=======
final class Example implements Tag, Factory\StaticMethod
{
    /** @var string Path to a file to use as an example. May also be an absolute URI. */
    private $filePath;
>>>>>>> v2-test

    /**
     * @var bool Whether the file path component represents an URI. This determines how the file portion
     *     appears at {@link getContent()}.
     */
<<<<<<< HEAD
    private $isURI = false;

    /**
     * {@inheritdoc}
     */
    public function getContent()
    {
        if (null === $this->description) {
            $filePath = '"' . $this->filePath . '"';
            if ($this->isURI) {
                $filePath = $this->isUriRelative($this->filePath)
                    ? str_replace('%2F', '/', rawurlencode($this->filePath))
                    :$this->filePath;
            }

            $this->description = $filePath . ' ' . parent::getContent();
        }

        return $this->description;
    }

    /**
     * {@inheritdoc}
     */
    public static function create($body)
    {
        // File component: File path in quotes or File URI / Source information
        if (! preg_match('/^(?:\"([^\"]+)\"|(\S+))(?:\s+(.*))?$/sux', $body, $matches)) {
=======
    private $isURI;

    /** @var int */
    private $startingLine;

    /** @var int */
    private $lineCount;

    /** @var string|null */
    private $content;

    public function __construct(
        string $filePath,
        bool $isURI,
        int $startingLine,
        int $lineCount,
        ?string $content
    ) {
        Assert::stringNotEmpty($filePath);
        Assert::greaterThanEq($startingLine, 1);
        Assert::greaterThanEq($lineCount, 0);

        $this->filePath     = $filePath;
        $this->startingLine = $startingLine;
        $this->lineCount    = $lineCount;
        if ($content !== null) {
            $this->content = trim($content);
        }

        $this->isURI = $isURI;
    }

    public function getContent() : string
    {
        if ($this->content === null || $this->content === '') {
            $filePath = $this->filePath;
            if ($this->isURI) {
                $filePath = $this->isUriRelative($this->filePath)
                    ? str_replace('%2F', '/', rawurlencode($this->filePath))
                    : $this->filePath;
            }

            return trim($filePath);
        }

        return $this->content;
    }

    public function getDescription() : ?string
    {
        return $this->content;
    }

    public static function create(string $body) : ?Tag
    {
        // File component: File path in quotes or File URI / Source information
        if (!preg_match('/^\s*(?:(\"[^\"]+\")|(\S+))(?:\s+(.*))?$/sux', $body, $matches)) {
>>>>>>> v2-test
            return null;
        }

        $filePath = null;
        $fileUri  = null;
<<<<<<< HEAD
        if ('' !== $matches[1]) {
=======
        if ($matches[1] !== '') {
>>>>>>> v2-test
            $filePath = $matches[1];
        } else {
            $fileUri = $matches[2];
        }

        $startingLine = 1;
<<<<<<< HEAD
        $lineCount    = null;
        $description  = null;

        // Starting line / Number of lines / Description
        if (preg_match('/^([1-9]\d*)\s*(?:((?1))\s+)?(.*)$/sux', $matches[3], $matches)) {
            $startingLine = (int)$matches[1];
            if (isset($matches[2]) && $matches[2] !== '') {
                $lineCount = (int)$matches[2];
            }
            $description = $matches[3];
        }

        return new static($filePath, $fileUri, $startingLine, $lineCount, $description);
=======
        $lineCount    = 0;
        $description  = null;

        if (array_key_exists(3, $matches)) {
            $description = $matches[3];

            // Starting line / Number of lines / Description
            if (preg_match('/^([1-9]\d*)(?:\s+((?1))\s*)?(.*)$/sux', $matches[3], $contentMatches)) {
                $startingLine = (int) $contentMatches[1];
                if (isset($contentMatches[2])) {
                    $lineCount = (int) $contentMatches[2];
                }

                if (array_key_exists(3, $contentMatches)) {
                    $description = $contentMatches[3];
                }
            }
        }

        return new static(
            $filePath ?? ($fileUri ?? ''),
            $fileUri !== null,
            $startingLine,
            $lineCount,
            $description
        );
>>>>>>> v2-test
    }

    /**
     * Returns the file path.
     *
     * @return string Path to a file to use as an example.
     *     May also be an absolute URI.
     */
<<<<<<< HEAD
    public function getFilePath()
    {
        return $this->filePath;
    }

    /**
     * Sets the file path.
     *
     * @param string $filePath The new file path to use for the example.
     *
     * @return $this
     */
    public function setFilePath($filePath)
    {
        $this->isURI = false;
        $this->filePath = trim($filePath);

        $this->description = null;
        return $this;
    }

    /**
     * Sets the file path as an URI.
     *
     * This function is equivalent to {@link setFilePath()}, except that it
     * converts an URI to a file path before that.
     *
     * There is no getFileURI(), as {@link getFilePath()} is compatible.
     *
     * @param string $uri The new file URI to use as an example.
     *
     * @return $this
     */
    public function setFileURI($uri)
    {
        $this->isURI   = true;
        $this->description = null;

        $this->filePath = $this->isUriRelative($uri)
            ? rawurldecode(str_replace(array('/', '\\'), '%2F', $uri))
            : $this->filePath = $uri;

        return $this;
    }

    /**
     * Returns a string representation for this tag.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->filePath . ($this->description ? ' ' . $this->description->render() : '');
    }

    /**
     * Returns true if the provided URI is relative or contains a complete scheme (and thus is absolute).
     *
     * @param string $uri
     *
     * @return bool
     */
    private function isUriRelative($uri)
    {
        return false === strpos($uri, ':');
=======
    public function getFilePath() : string
    {
        return trim($this->filePath, '"');
    }

    /**
     * Returns a string representation for this tag.
     */
    public function __toString() : string
    {
        $filePath = (string) $this->filePath;
        $isDefaultLine = $this->startingLine === 1 && $this->lineCount === 0;
        $startingLine = !$isDefaultLine ? (string) $this->startingLine : '';
        $lineCount = !$isDefaultLine ? (string) $this->lineCount : '';
        $content = (string) $this->content;

        return $filePath
            . ($startingLine !== ''
                ? ($filePath !== '' ? ' ' : '') . $startingLine
                : '')
            . ($lineCount !== ''
                ? ($filePath !== '' || $startingLine !== '' ? ' ' : '') . $lineCount
                : '')
            . ($content !== ''
                ? ($filePath !== '' || $startingLine !== '' || $lineCount !== '' ? ' ' : '') . $content
                : '');
    }

    /**
     * Returns true if the provided URI is relative or contains a complete scheme (and thus is absolute).
     */
    private function isUriRelative(string $uri) : bool
    {
        return strpos($uri, ':') === false;
    }

    public function getStartingLine() : int
    {
        return $this->startingLine;
    }

    public function getLineCount() : int
    {
        return $this->lineCount;
    }

    public function getName() : string
    {
        return 'example';
    }

    public function render(?Formatter $formatter = null) : string
    {
        if ($formatter === null) {
            $formatter = new Formatter\PassthroughFormatter();
        }

        return $formatter->format($this);
>>>>>>> v2-test
    }
}
