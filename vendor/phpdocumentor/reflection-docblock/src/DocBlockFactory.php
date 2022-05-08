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

namespace phpDocumentor\Reflection;

<<<<<<< HEAD
=======
use InvalidArgumentException;
use LogicException;
>>>>>>> v2-test
use phpDocumentor\Reflection\DocBlock\DescriptionFactory;
use phpDocumentor\Reflection\DocBlock\StandardTagFactory;
use phpDocumentor\Reflection\DocBlock\Tag;
use phpDocumentor\Reflection\DocBlock\TagFactory;
use Webmozart\Assert\Assert;
<<<<<<< HEAD
=======
use function array_shift;
use function count;
use function explode;
use function is_object;
use function method_exists;
use function preg_match;
use function preg_replace;
use function str_replace;
use function strpos;
use function substr;
use function trim;
>>>>>>> v2-test

final class DocBlockFactory implements DocBlockFactoryInterface
{
    /** @var DocBlock\DescriptionFactory */
    private $descriptionFactory;

    /** @var DocBlock\TagFactory */
    private $tagFactory;

    /**
     * Initializes this factory with the required subcontractors.
<<<<<<< HEAD
     *
     * @param DescriptionFactory $descriptionFactory
     * @param TagFactory         $tagFactory
=======
>>>>>>> v2-test
     */
    public function __construct(DescriptionFactory $descriptionFactory, TagFactory $tagFactory)
    {
        $this->descriptionFactory = $descriptionFactory;
<<<<<<< HEAD
        $this->tagFactory = $tagFactory;
=======
        $this->tagFactory         = $tagFactory;
>>>>>>> v2-test
    }

    /**
     * Factory method for easy instantiation.
     *
<<<<<<< HEAD
     * @param string[] $additionalTags
     *
     * @return DocBlockFactory
     */
    public static function createInstance(array $additionalTags = [])
    {
        $fqsenResolver = new FqsenResolver();
        $tagFactory = new StandardTagFactory($fqsenResolver);
=======
     * @param array<string, class-string<Tag>> $additionalTags
     */
    public static function createInstance(array $additionalTags = []) : self
    {
        $fqsenResolver      = new FqsenResolver();
        $tagFactory         = new StandardTagFactory($fqsenResolver);
>>>>>>> v2-test
        $descriptionFactory = new DescriptionFactory($tagFactory);

        $tagFactory->addService($descriptionFactory);
        $tagFactory->addService(new TypeResolver($fqsenResolver));

        $docBlockFactory = new self($descriptionFactory, $tagFactory);
        foreach ($additionalTags as $tagName => $tagHandler) {
            $docBlockFactory->registerTagHandler($tagName, $tagHandler);
        }

        return $docBlockFactory;
    }

    /**
     * @param object|string $docblock A string containing the DocBlock to parse or an object supporting the
     *                                getDocComment method (such as a ReflectionClass object).
<<<<<<< HEAD
     * @param Types\Context $context
     * @param Location      $location
     *
     * @return DocBlock
     */
    public function create($docblock, Types\Context $context = null, Location $location = null)
=======
     */
    public function create($docblock, ?Types\Context $context = null, ?Location $location = null) : DocBlock
>>>>>>> v2-test
    {
        if (is_object($docblock)) {
            if (!method_exists($docblock, 'getDocComment')) {
                $exceptionMessage = 'Invalid object passed; the given object must support the getDocComment method';
<<<<<<< HEAD
                throw new \InvalidArgumentException($exceptionMessage);
            }

            $docblock = $docblock->getDocComment();
=======

                throw new InvalidArgumentException($exceptionMessage);
            }

            $docblock = $docblock->getDocComment();
            Assert::string($docblock);
>>>>>>> v2-test
        }

        Assert::stringNotEmpty($docblock);

        if ($context === null) {
            $context = new Types\Context('');
        }

        $parts = $this->splitDocBlock($this->stripDocComment($docblock));
<<<<<<< HEAD
        list($templateMarker, $summary, $description, $tags) = $parts;
=======

        [$templateMarker, $summary, $description, $tags] = $parts;
>>>>>>> v2-test

        return new DocBlock(
            $summary,
            $description ? $this->descriptionFactory->create($description, $context) : null,
<<<<<<< HEAD
            array_filter($this->parseTagBlock($tags, $context), function($tag) {
                return $tag instanceof Tag;
            }),
=======
            $this->parseTagBlock($tags, $context),
>>>>>>> v2-test
            $context,
            $location,
            $templateMarker === '#@+',
            $templateMarker === '#@-'
        );
    }

<<<<<<< HEAD
    public function registerTagHandler($tagName, $handler)
=======
    /**
     * @param class-string<Tag> $handler
     */
    public function registerTagHandler(string $tagName, string $handler) : void
>>>>>>> v2-test
    {
        $this->tagFactory->registerTagHandler($tagName, $handler);
    }

    /**
     * Strips the asterisks from the DocBlock comment.
     *
     * @param string $comment String containing the comment text.
<<<<<<< HEAD
     *
     * @return string
     */
    private function stripDocComment($comment)
    {
        $comment = trim(preg_replace('#[ \t]*(?:\/\*\*|\*\/|\*)?[ \t]{0,1}(.*)?#u', '$1', $comment));

        // reg ex above is not able to remove */ from a single line docblock
        if (substr($comment, -2) == '*/') {
            $comment = trim(substr($comment, 0, -2));
        }

        return str_replace(array("\r\n", "\r"), "\n", $comment);
    }

=======
     */
    private function stripDocComment(string $comment) : string
    {
        $comment = preg_replace('#[ \t]*(?:\/\*\*|\*\/|\*)?[ \t]?(.*)?#u', '$1', $comment);
        Assert::string($comment);
        $comment = trim($comment);

        // reg ex above is not able to remove */ from a single line docblock
        if (substr($comment, -2) === '*/') {
            $comment = trim(substr($comment, 0, -2));
        }

        return str_replace(["\r\n", "\r"], "\n", $comment);
    }

    // phpcs:disable
>>>>>>> v2-test
    /**
     * Splits the DocBlock into a template marker, summary, description and block of tags.
     *
     * @param string $comment Comment to split into the sub-parts.
     *
<<<<<<< HEAD
     * @author Richard van Velzen (@_richardJ) Special thanks to Richard for the regex responsible for the split.
     * @author Mike van Riel <me@mikevanriel.com> for extending the regex with template marker support.
     *
     * @return string[] containing the template marker (if any), summary, description and a string containing the tags.
     */
    private function splitDocBlock($comment)
    {
=======
     * @return string[] containing the template marker (if any), summary, description and a string containing the tags.
     *
     * @author Mike van Riel <me@mikevanriel.com> for extending the regex with template marker support.
     *
     * @author Richard van Velzen (@_richardJ) Special thanks to Richard for the regex responsible for the split.
     */
    private function splitDocBlock(string $comment) : array
    {
        // phpcs:enable
>>>>>>> v2-test
        // Performance improvement cheat: if the first character is an @ then only tags are in this DocBlock. This
        // method does not split tags so we return this verbatim as the fourth result (tags). This saves us the
        // performance impact of running a regular expression
        if (strpos($comment, '@') === 0) {
<<<<<<< HEAD
            return array('', '', '', $comment);
=======
            return ['', '', '', $comment];
>>>>>>> v2-test
        }

        // clears all extra horizontal whitespace from the line endings to prevent parsing issues
        $comment = preg_replace('/\h*$/Sum', '', $comment);
<<<<<<< HEAD

=======
        Assert::string($comment);
>>>>>>> v2-test
        /*
         * Splits the docblock into a template marker, summary, description and tags section.
         *
         * - The template marker is empty, #@+ or #@- if the DocBlock starts with either of those (a newline may
         *   occur after it and will be stripped).
         * - The short description is started from the first character until a dot is encountered followed by a
         *   newline OR two consecutive newlines (horizontal whitespace is taken into account to consider spacing
         *   errors). This is optional.
         * - The long description, any character until a new line is encountered followed by an @ and word
         *   characters (a tag). This is optional.
         * - Tags; the remaining characters
         *
         * Big thanks to RichardJ for contributing this Regular Expression
         */
        preg_match(
            '/
            \A
            # 1. Extract the template marker
            (?:(\#\@\+|\#\@\-)\n?)?

            # 2. Extract the summary
            (?:
              (?! @\pL ) # The summary may not start with an @
              (
                [^\n.]+
                (?:
                  (?! \. \n | \n{2} )     # End summary upon a dot followed by newline or two newlines
<<<<<<< HEAD
                  [\n.] (?! [ \t]* @\pL ) # End summary when an @ is found as first character on a new line
=======
                  [\n.]* (?! [ \t]* @\pL ) # End summary when an @ is found as first character on a new line
>>>>>>> v2-test
                  [^\n.]+                 # Include anything else
                )*
                \.?
              )?
            )

            # 3. Extract the description
            (?:
              \s*        # Some form of whitespace _must_ precede a description because a summary must be there
              (?! @\pL ) # The description may not start with an @
              (
                [^\n]+
                (?: \n+
                  (?! [ \t]* @\pL ) # End description when an @ is found as first character on a new line
                  [^\n]+            # Include anything else
                )*
              )
            )?

            # 4. Extract the tags (anything that follows)
            (\s+ [\s\S]*)? # everything that follows
            /ux',
            $comment,
            $matches
        );
        array_shift($matches);

        while (count($matches) < 4) {
            $matches[] = '';
        }

        return $matches;
    }

    /**
     * Creates the tag objects.
     *
<<<<<<< HEAD
     * @param string $tags Tag block to parse.
=======
     * @param string        $tags    Tag block to parse.
>>>>>>> v2-test
     * @param Types\Context $context Context of the parsed Tag
     *
     * @return DocBlock\Tag[]
     */
<<<<<<< HEAD
    private function parseTagBlock($tags, Types\Context $context)
    {
        $tags = $this->filterTagBlock($tags);
        if (!$tags) {
            return [];
        }

        $result = $this->splitTagBlockIntoTagLines($tags);
        foreach ($result as $key => $tagLine) {
=======
    private function parseTagBlock(string $tags, Types\Context $context) : array
    {
        $tags = $this->filterTagBlock($tags);
        if ($tags === null) {
            return [];
        }

        $result = [];
        $lines  = $this->splitTagBlockIntoTagLines($tags);
        foreach ($lines as $key => $tagLine) {
>>>>>>> v2-test
            $result[$key] = $this->tagFactory->create(trim($tagLine), $context);
        }

        return $result;
    }

    /**
<<<<<<< HEAD
     * @param string $tags
     *
     * @return string[]
     */
    private function splitTagBlockIntoTagLines($tags)
    {
        $result = array();
        foreach (explode("\n", $tags) as $tag_line) {
            if (isset($tag_line[0]) && ($tag_line[0] === '@')) {
                $result[] = $tag_line;
            } else {
                $result[count($result) - 1] .= "\n" . $tag_line;
=======
     * @return string[]
     */
    private function splitTagBlockIntoTagLines(string $tags) : array
    {
        $result = [];
        foreach (explode("\n", $tags) as $tagLine) {
            if ($tagLine !== '' && strpos($tagLine, '@') === 0) {
                $result[] = $tagLine;
            } else {
                $result[count($result) - 1] .= "\n" . $tagLine;
>>>>>>> v2-test
            }
        }

        return $result;
    }

<<<<<<< HEAD
    /**
     * @param $tags
     * @return string
     */
    private function filterTagBlock($tags)
=======
    private function filterTagBlock(string $tags) : ?string
>>>>>>> v2-test
    {
        $tags = trim($tags);
        if (!$tags) {
            return null;
        }

<<<<<<< HEAD
        if ('@' !== $tags[0]) {
            // @codeCoverageIgnoreStart
            // Can't simulate this; this only happens if there is an error with the parsing of the DocBlock that
            // we didn't foresee.
            throw new \LogicException('A tag block started with text instead of an at-sign(@): ' . $tags);
=======
        if ($tags[0] !== '@') {
            // @codeCoverageIgnoreStart
            // Can't simulate this; this only happens if there is an error with the parsing of the DocBlock that
            // we didn't foresee.

            throw new LogicException('A tag block started with text instead of an at-sign(@): ' . $tags);

>>>>>>> v2-test
            // @codeCoverageIgnoreEnd
        }

        return $tags;
    }
}
