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

use phpDocumentor\Reflection\DocBlock\Description;
use phpDocumentor\Reflection\DocBlock\DescriptionFactory;
use phpDocumentor\Reflection\Fqsen;
use phpDocumentor\Reflection\FqsenResolver;
use phpDocumentor\Reflection\Types\Context as TypeContext;
<<<<<<< HEAD
use Webmozart\Assert\Assert;
=======
use phpDocumentor\Reflection\Utils;
use Webmozart\Assert\Assert;
use function array_key_exists;
use function explode;
>>>>>>> v2-test

/**
 * Reflection class for a {@}uses tag in a Docblock.
 */
final class Uses extends BaseTag implements Factory\StaticMethod
{
<<<<<<< HEAD
    protected $name = 'uses';

    /** @var Fqsen */
    protected $refers = null;

    /**
     * Initializes this tag.
     *
     * @param Fqsen       $refers
     * @param Description $description
     */
    public function __construct(Fqsen $refers, Description $description = null)
=======
    /** @var string */
    protected $name = 'uses';

    /** @var Fqsen */
    protected $refers;

    /**
     * Initializes this tag.
     */
    public function __construct(Fqsen $refers, ?Description $description = null)
>>>>>>> v2-test
    {
        $this->refers      = $refers;
        $this->description = $description;
    }

<<<<<<< HEAD
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

        $parts = preg_split('/\s+/Su', $body, 2);

        return new static(
            $resolver->resolve($parts[0], $context),
            $descriptionFactory->create(isset($parts[1]) ? $parts[1] : '', $context)
        );
    }

    /**
     * Returns the structural element this tag refers to.
     *
     * @return Fqsen
     */
    public function getReference()
=======
    public static function create(
        string $body,
        ?FqsenResolver $resolver = null,
        ?DescriptionFactory $descriptionFactory = null,
        ?TypeContext $context = null
    ) : self {
        Assert::notNull($resolver);
        Assert::notNull($descriptionFactory);

        $parts = Utils::pregSplit('/\s+/Su', $body, 2);

        return new static(
            self::resolveFqsen($parts[0], $resolver, $context),
            $descriptionFactory->create($parts[1] ?? '', $context)
        );
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
     * Returns the structural element this tag refers to.
     */
    public function getReference() : Fqsen
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
        return $this->refers . ' ' . $this->description->render();
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
