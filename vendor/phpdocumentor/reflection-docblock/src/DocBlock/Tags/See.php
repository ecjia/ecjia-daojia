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
 * @link      http://phpdoc.org
=======
 * @link http://phpdoc.org
>>>>>>> v2-test
 */

namespace phpDocumentor\Reflection\DocBlock\Tags;

<<<<<<< HEAD
use phpDocumentor\Reflection\DocBlock\DescriptionFactory;
use phpDocumentor\Reflection\Fqsen;
use phpDocumentor\Reflection\FqsenResolver;
use phpDocumentor\Reflection\Types\Context as TypeContext;
use phpDocumentor\Reflection\DocBlock\Description;
use Webmozart\Assert\Assert;
=======
use phpDocumentor\Reflection\DocBlock\Description;
use phpDocumentor\Reflection\DocBlock\DescriptionFactory;
use phpDocumentor\Reflection\DocBlock\Tags\Reference\Fqsen as FqsenRef;
use phpDocumentor\Reflection\DocBlock\Tags\Reference\Reference;
use phpDocumentor\Reflection\DocBlock\Tags\Reference\Url;
use phpDocumentor\Reflection\Fqsen;
use phpDocumentor\Reflection\FqsenResolver;
use phpDocumentor\Reflection\Types\Context as TypeContext;
use phpDocumentor\Reflection\Utils;
use Webmozart\Assert\Assert;
use function array_key_exists;
use function explode;
use function preg_match;
>>>>>>> v2-test

/**
 * Reflection class for an {@}see tag in a Docblock.
 */
<<<<<<< HEAD
class See extends BaseTag implements Factory\StaticMethod
{
    protected $name = 'see';

    /** @var Fqsen */
    protected $refers = null;

    /**
     * Initializes this tag.
     *
     * @param Fqsen $refers
     * @param Description $description
     */
    public function __construct(Fqsen $refers, Description $description = null)
    {
        $this->refers = $refers;
        $this->description = $description;
    }

    /**
     * {@inheritdoc}
     */
    public static function create(
        $body,
        FqsenResolver $resolver = null,
        DescriptionFactory $descriptionFactory = null,
        TypeContext $context = null
    ) {
        Assert::string($body);
        Assert::allNotNull([$resolver, $descriptionFactory]);

        $parts       = preg_split('/\s+/Su', $body, 2);
        $description = isset($parts[1]) ? $descriptionFactory->create($parts[1], $context) : null;

        return new static($resolver->resolve($parts[0], $context), $description);
    }

    /**
     * Returns the structural element this tag refers to.
     *
     * @return Fqsen
     */
    public function getReference()
=======
final class See extends BaseTag implements Factory\StaticMethod
{
    /** @var string */
    protected $name = 'see';

    /** @var Reference */
    protected $refers;

    /**
     * Initializes this tag.
     */
    public function __construct(Reference $refers, ?Description $description = null)
    {
        $this->refers      = $refers;
        $this->description = $description;
    }

    public static function create(
        string $body,
        ?FqsenResolver $typeResolver = null,
        ?DescriptionFactory $descriptionFactory = null,
        ?TypeContext $context = null
    ) : self {
        Assert::notNull($descriptionFactory);

        $parts = Utils::pregSplit('/\s+/Su', $body, 2);
        $description = isset($parts[1]) ? $descriptionFactory->create($parts[1], $context) : null;

        // https://tools.ietf.org/html/rfc2396#section-3
        if (preg_match('/\w:\/\/\w/i', $parts[0])) {
            return new static(new Url($parts[0]), $description);
        }

        return new static(new FqsenRef(self::resolveFqsen($parts[0], $typeResolver, $context)), $description);
    }

    private static function resolveFqsen(string $parts, ?FqsenResolver $fqsenResolver, ?TypeContext $context) : Fqsen
    {
        Assert::notNull($fqsenResolver);
        $fqsenParts = explode('::', $parts);
        $resolved = $fqsenResolver->resolve($fqsenParts[0], $context);

        if (!array_key_exists(1, $fqsenParts)) {
            return $resolved;
        }

        return new Fqsen($resolved . '::' . $fqsenParts[1]);
    }

    /**
     * Returns the ref of this tag.
     */
    public function getReference() : Reference
>>>>>>> v2-test
    {
        return $this->refers;
    }

    /**
     * Returns a string representation of this tag.
<<<<<<< HEAD
     *
     * @return string
     */
    public function __toString()
    {
        return $this->refers . ($this->description ? ' ' . $this->description->render() : '');
=======
     */
    public function __toString() : string
    {
        if ($this->description) {
            $description = $this->description->render();
        } else {
            $description = '';
        }

        $refers = (string) $this->refers;

        return $refers . ($description !== '' ? ($refers !== '' ? ' ' : '') . $description : '');
>>>>>>> v2-test
    }
}
