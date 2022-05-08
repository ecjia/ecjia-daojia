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

use phpDocumentor\Reflection\DocBlock\Description;
use phpDocumentor\Reflection\DocBlock\DescriptionFactory;
use phpDocumentor\Reflection\Type;
use phpDocumentor\Reflection\TypeResolver;
use phpDocumentor\Reflection\Types\Context as TypeContext;
<<<<<<< HEAD
use Webmozart\Assert\Assert;
=======
use phpDocumentor\Reflection\Utils;
use Webmozart\Assert\Assert;
use function array_shift;
use function array_unshift;
use function implode;
use function strpos;
use function substr;
use const PREG_SPLIT_DELIM_CAPTURE;
>>>>>>> v2-test

/**
 * Reflection class for the {@}param tag in a Docblock.
 */
<<<<<<< HEAD
final class Param extends BaseTag implements Factory\StaticMethod
{
    /** @var string */
    protected $name = 'param';

    /** @var Type */
    private $type;

    /** @var string */
    private $variableName = '';

    /** @var bool determines whether this is a variadic argument */
    private $isVariadic = false;

    /**
     * @param string $variableName
     * @param Type $type
     * @param bool $isVariadic
     * @param Description $description
     */
    public function __construct($variableName, Type $type = null, $isVariadic = false, Description $description = null)
    {
        Assert::string($variableName);
        Assert::boolean($isVariadic);

        $this->variableName = $variableName;
        $this->type = $type;
        $this->isVariadic = $isVariadic;
        $this->description = $description;
    }

    /**
     * {@inheritdoc}
     */
    public static function create(
        $body,
        TypeResolver $typeResolver = null,
        DescriptionFactory $descriptionFactory = null,
        TypeContext $context = null
    ) {
        Assert::stringNotEmpty($body);
        Assert::allNotNull([$typeResolver, $descriptionFactory]);

        $parts = preg_split('/(\s+)/Su', $body, 3, PREG_SPLIT_DELIM_CAPTURE);
        $type = null;
        $variableName = '';
        $isVariadic = false;

        // if the first item that is encountered is not a variable; it is a type
        if (isset($parts[0]) && (strlen($parts[0]) > 0) && ($parts[0][0] !== '$')) {
            $type = $typeResolver->resolve(array_shift($parts), $context);
            array_shift($parts);
        }

        // if the next item starts with a $ or ...$ it must be the variable name
        if (isset($parts[0]) && (strlen($parts[0]) > 0) && ($parts[0][0] == '$' || substr($parts[0], 0, 4) === '...$')) {
            $variableName = array_shift($parts);
            array_shift($parts);

            if (substr($variableName, 0, 3) === '...') {
                $isVariadic = true;
                $variableName = substr($variableName, 3);
            }

            if (substr($variableName, 0, 1) === '$') {
                $variableName = substr($variableName, 1);
=======
final class Param extends TagWithType implements Factory\StaticMethod
{
    /** @var string|null */
    private $variableName;

    /** @var bool determines whether this is a variadic argument */
    private $isVariadic;

    /** @var bool determines whether this is passed by reference */
    private $isReference;

    public function __construct(
        ?string $variableName,
        ?Type $type = null,
        bool $isVariadic = false,
        ?Description $description = null,
        bool $isReference = false
    ) {
        $this->name         = 'param';
        $this->variableName = $variableName;
        $this->type         = $type;
        $this->isVariadic   = $isVariadic;
        $this->description  = $description;
        $this->isReference  = $isReference;
    }

    public static function create(
        string $body,
        ?TypeResolver $typeResolver = null,
        ?DescriptionFactory $descriptionFactory = null,
        ?TypeContext $context = null
    ) : self {
        Assert::stringNotEmpty($body);
        Assert::notNull($typeResolver);
        Assert::notNull($descriptionFactory);

        [$firstPart, $body] = self::extractTypeFromBody($body);

        $type         = null;
        $parts        = Utils::pregSplit('/(\s+)/Su', $body, 2, PREG_SPLIT_DELIM_CAPTURE);
        $variableName = '';
        $isVariadic   = false;
        $isReference   = false;

        // if the first item that is encountered is not a variable; it is a type
        if ($firstPart && !self::strStartsWithVariable($firstPart)) {
            $type = $typeResolver->resolve($firstPart, $context);
        } else {
            // first part is not a type; we should prepend it to the parts array for further processing
            array_unshift($parts, $firstPart);
        }

        // if the next item starts with a $ or ...$ or &$ or &...$ it must be the variable name
        if (isset($parts[0]) && self::strStartsWithVariable($parts[0])) {
            $variableName = array_shift($parts);
            if ($type) {
                array_shift($parts);
            }

            Assert::notNull($variableName);

            if (strpos($variableName, '$') === 0) {
                $variableName = substr($variableName, 1);
            } elseif (strpos($variableName, '&$') === 0) {
                $isReference = true;
                $variableName = substr($variableName, 2);
            } elseif (strpos($variableName, '...$') === 0) {
                $isVariadic = true;
                $variableName = substr($variableName, 4);
            } elseif (strpos($variableName, '&...$') === 0) {
                $isVariadic   = true;
                $isReference  = true;
                $variableName = substr($variableName, 5);
>>>>>>> v2-test
            }
        }

        $description = $descriptionFactory->create(implode('', $parts), $context);

<<<<<<< HEAD
        return new static($variableName, $type, $isVariadic, $description);
=======
        return new static($variableName, $type, $isVariadic, $description, $isReference);
>>>>>>> v2-test
    }

    /**
     * Returns the variable's name.
<<<<<<< HEAD
     *
     * @return string
     */
    public function getVariableName()
=======
     */
    public function getVariableName() : ?string
>>>>>>> v2-test
    {
        return $this->variableName;
    }

    /**
<<<<<<< HEAD
     * Returns the variable's type or null if unknown.
     *
     * @return Type|null
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Returns whether this tag is variadic.
     *
     * @return boolean
     */
    public function isVariadic()
    {
        return $this->isVariadic;
=======
     * Returns whether this tag is variadic.
     */
    public function isVariadic() : bool
    {
        return $this->isVariadic;
    }

    /**
     * Returns whether this tag is passed by reference.
     */
    public function isReference() : bool
    {
        return $this->isReference;
>>>>>>> v2-test
    }

    /**
     * Returns a string representation for this tag.
<<<<<<< HEAD
     *
     * @return string
     */
    public function __toString()
    {
        return ($this->type ? $this->type . ' ' : '')
        . ($this->isVariadic() ? '...' : '')
        . '$' . $this->variableName
        . ($this->description ? ' ' . $this->description : '');
=======
     */
    public function __toString() : string
    {
        if ($this->description) {
            $description = $this->description->render();
        } else {
            $description = '';
        }

        $variableName = '';
        if ($this->variableName) {
            $variableName .= ($this->isReference ? '&' : '') . ($this->isVariadic ? '...' : '');
            $variableName .= '$' . $this->variableName;
        }

        $type = (string) $this->type;

        return $type
            . ($variableName !== '' ? ($type !== '' ? ' ' : '') . $variableName : '')
            . ($description !== '' ? ($type !== '' || $variableName !== '' ? ' ' : '') . $description : '');
    }

    private static function strStartsWithVariable(string $str) : bool
    {
        return strpos($str, '$') === 0
               ||
               strpos($str, '...$') === 0
               ||
               strpos($str, '&$') === 0
               ||
               strpos($str, '&...$') === 0;
>>>>>>> v2-test
    }
}
