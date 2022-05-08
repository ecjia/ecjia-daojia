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
use phpDocumentor\Reflection\Types\Context as TypeContext;
use phpDocumentor\Reflection\DocBlock\Description;
use phpDocumentor\Reflection\DocBlock\DescriptionFactory;
use Webmozart\Assert\Assert;
=======
use phpDocumentor\Reflection\DocBlock\Description;
use phpDocumentor\Reflection\DocBlock\DescriptionFactory;
use phpDocumentor\Reflection\Types\Context as TypeContext;
use Webmozart\Assert\Assert;
use function preg_match;
>>>>>>> v2-test

/**
 * Reflection class for a {@}since tag in a Docblock.
 */
final class Since extends BaseTag implements Factory\StaticMethod
{
<<<<<<< HEAD
=======
    /** @var string */
>>>>>>> v2-test
    protected $name = 'since';

    /**
     * PCRE regular expression matching a version vector.
     * Assumes the "x" modifier.
     */
<<<<<<< HEAD
    const REGEX_VECTOR = '(?:
=======
    public const REGEX_VECTOR = '(?:
>>>>>>> v2-test
        # Normal release vectors.
        \d\S*
        |
        # VCS version vectors. Per PHPCS, they are expected to
        # follow the form of the VCS name, followed by ":", followed
        # by the version vector itself.
        # By convention, popular VCSes like CVS, SVN and GIT use "$"
        # around the actual version vector.
        [^\s\:]+\:\s*\$[^\$]+\$
    )';

<<<<<<< HEAD
    /** @var string The version vector. */
    private $version = '';

    public function __construct($version = null, Description $description = null)
    {
        Assert::nullOrStringNotEmpty($version);
=======
    /** @var string|null The version vector. */
    private $version;

    public function __construct(?string $version = null, ?Description $description = null)
    {
        Assert::nullOrNotEmpty($version);
>>>>>>> v2-test

        $this->version     = $version;
        $this->description = $description;
    }

<<<<<<< HEAD
    /**
     * @return static
     */
    public static function create($body, DescriptionFactory $descriptionFactory = null, TypeContext $context = null)
    {
        Assert::nullOrString($body);
=======
    public static function create(
        ?string $body,
        ?DescriptionFactory $descriptionFactory = null,
        ?TypeContext $context = null
    ) : ?self {
>>>>>>> v2-test
        if (empty($body)) {
            return new static();
        }

        $matches = [];
<<<<<<< HEAD
        if (! preg_match('/^(' . self::REGEX_VECTOR . ')\s*(.+)?$/sux', $body, $matches)) {
            return null;
        }

        return new static(
            $matches[1],
            $descriptionFactory->create(isset($matches[2]) ? $matches[2] : '', $context)
=======
        if (!preg_match('/^(' . self::REGEX_VECTOR . ')\s*(.+)?$/sux', $body, $matches)) {
            return null;
        }

        Assert::notNull($descriptionFactory);

        return new static(
            $matches[1],
            $descriptionFactory->create($matches[2] ?? '', $context)
>>>>>>> v2-test
        );
    }

    /**
     * Gets the version section of the tag.
<<<<<<< HEAD
     *
     * @return string
     */
    public function getVersion()
=======
     */
    public function getVersion() : ?string
>>>>>>> v2-test
    {
        return $this->version;
    }

    /**
     * Returns a string representation for this tag.
<<<<<<< HEAD
     *
     * @return string
     */
    public function __toString()
    {
        return $this->version . ($this->description ? ' ' . $this->description->render() : '');
=======
     */
    public function __toString() : string
    {
        if ($this->description) {
            $description = $this->description->render();
        } else {
            $description = '';
        }

        $version = (string) $this->version;

        return $version . ($description !== '' ? ($version !== '' ? ' ' : '') . $description : '');
>>>>>>> v2-test
    }
}
