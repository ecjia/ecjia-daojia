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

<<<<<<< HEAD
=======
use InvalidArgumentException;
>>>>>>> v2-test
use phpDocumentor\Reflection\DocBlock\Description;
use phpDocumentor\Reflection\DocBlock\DescriptionFactory;
use phpDocumentor\Reflection\DocBlock\StandardTagFactory;
use phpDocumentor\Reflection\Types\Context as TypeContext;
use Webmozart\Assert\Assert;
<<<<<<< HEAD
=======
use function preg_match;
>>>>>>> v2-test

/**
 * Parses a tag definition for a DocBlock.
 */
<<<<<<< HEAD
class Generic extends BaseTag implements Factory\StaticMethod
=======
final class Generic extends BaseTag implements Factory\StaticMethod
>>>>>>> v2-test
{
    /**
     * Parses a tag and populates the member variables.
     *
<<<<<<< HEAD
     * @param string $name Name of the tag.
     * @param Description $description The contents of the given tag.
     */
    public function __construct($name, Description $description = null)
    {
        $this->validateTagName($name);

        $this->name = $name;
=======
     * @param string      $name        Name of the tag.
     * @param Description $description The contents of the given tag.
     */
    public function __construct(string $name, ?Description $description = null)
    {
        $this->validateTagName($name);

        $this->name        = $name;
>>>>>>> v2-test
        $this->description = $description;
    }

    /**
     * Creates a new tag that represents any unknown tag type.
     *
<<<<<<< HEAD
     * @param string             $body
     * @param string             $name
     * @param DescriptionFactory $descriptionFactory
     * @param TypeContext        $context
     *
     * @return static
     */
    public static function create(
        $body,
        $name = '',
        DescriptionFactory $descriptionFactory = null,
        TypeContext $context = null
    ) {
        Assert::string($body);
        Assert::stringNotEmpty($name);
        Assert::notNull($descriptionFactory);

        $description = $descriptionFactory && $body ? $descriptionFactory->create($body, $context) : null;
=======
     * @return static
     */
    public static function create(
        string $body,
        string $name = '',
        ?DescriptionFactory $descriptionFactory = null,
        ?TypeContext $context = null
    ) : self {
        Assert::stringNotEmpty($name);
        Assert::notNull($descriptionFactory);

        $description = $body !== '' ? $descriptionFactory->create($body, $context) : null;
>>>>>>> v2-test

        return new static($name, $description);
    }

    /**
     * Returns the tag as a serialized string
<<<<<<< HEAD
     *
     * @return string
     */
    public function __toString()
    {
        return ($this->description ? $this->description->render() : '');
=======
     */
    public function __toString() : string
    {
        if ($this->description) {
            $description = $this->description->render();
        } else {
            $description = '';
        }

        return $description;
>>>>>>> v2-test
    }

    /**
     * Validates if the tag name matches the expected format, otherwise throws an exception.
<<<<<<< HEAD
     *
     * @param string $name
     *
     * @return void
     */
    private function validateTagName($name)
    {
        if (! preg_match('/^' . StandardTagFactory::REGEX_TAGNAME . '$/u', $name)) {
            throw new \InvalidArgumentException(
=======
     */
    private function validateTagName(string $name) : void
    {
        if (!preg_match('/^' . StandardTagFactory::REGEX_TAGNAME . '$/u', $name)) {
            throw new InvalidArgumentException(
>>>>>>> v2-test
                'The tag name "' . $name . '" is not wellformed. Tags may only consist of letters, underscores, '
                . 'hyphens and backslashes.'
            );
        }
    }
}
