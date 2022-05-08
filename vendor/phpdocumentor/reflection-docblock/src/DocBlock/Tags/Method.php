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
=======
use InvalidArgumentException;
>>>>>>> v2-test
use phpDocumentor\Reflection\DocBlock\Description;
use phpDocumentor\Reflection\DocBlock\DescriptionFactory;
use phpDocumentor\Reflection\Type;
use phpDocumentor\Reflection\TypeResolver;
use phpDocumentor\Reflection\Types\Context as TypeContext;
<<<<<<< HEAD
use phpDocumentor\Reflection\Types\Void_;
use Webmozart\Assert\Assert;
=======
use phpDocumentor\Reflection\Types\Mixed_;
use phpDocumentor\Reflection\Types\Void_;
use Webmozart\Assert\Assert;
use function array_keys;
use function explode;
use function implode;
use function is_string;
use function preg_match;
use function sort;
use function strpos;
use function substr;
use function trim;
use function var_export;
>>>>>>> v2-test

/**
 * Reflection class for an {@}method in a Docblock.
 */
final class Method extends BaseTag implements Factory\StaticMethod
{
<<<<<<< HEAD
    protected $name = 'method';

    /** @var string */
    private $methodName = '';

    /** @var string[] */
    private $arguments = [];

    /** @var bool */
    private $isStatic = false;
=======
    /** @var string */
    protected $name = 'method';

    /** @var string */
    private $methodName;

    /**
     * @phpstan-var array<int, array{name: string, type: Type}>
     * @var array<int, array<string, Type|string>>
     */
    private $arguments;

    /** @var bool */
    private $isStatic;
>>>>>>> v2-test

    /** @var Type */
    private $returnType;

<<<<<<< HEAD
    public function __construct(
        $methodName,
        array $arguments = [],
        Type $returnType = null,
        $static = false,
        Description $description = null
    ) {
        Assert::stringNotEmpty($methodName);
        Assert::boolean($static);
=======
    /**
     * @param array<int, array<string, Type|string>> $arguments
     *
     * @phpstan-param array<int, array{name: string, type: Type}|string> $arguments
     */
    public function __construct(
        string $methodName,
        array $arguments = [],
        ?Type $returnType = null,
        bool $static = false,
        ?Description $description = null
    ) {
        Assert::stringNotEmpty($methodName);
>>>>>>> v2-test

        if ($returnType === null) {
            $returnType = new Void_();
        }

        $this->methodName  = $methodName;
        $this->arguments   = $this->filterArguments($arguments);
        $this->returnType  = $returnType;
        $this->isStatic    = $static;
        $this->description = $description;
    }

<<<<<<< HEAD
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
        Assert::allNotNull([ $typeResolver, $descriptionFactory ]);
=======
    public static function create(
        string $body,
        ?TypeResolver $typeResolver = null,
        ?DescriptionFactory $descriptionFactory = null,
        ?TypeContext $context = null
    ) : ?self {
        Assert::stringNotEmpty($body);
        Assert::notNull($typeResolver);
        Assert::notNull($descriptionFactory);
>>>>>>> v2-test

        // 1. none or more whitespace
        // 2. optionally the keyword "static" followed by whitespace
        // 3. optionally a word with underscores followed by whitespace : as
        //    type for the return value
        // 4. then optionally a word with underscores followed by () and
        //    whitespace : as method name as used by phpDocumentor
        // 5. then a word with underscores, followed by ( and any character
        //    until a ) and whitespace : as method name with signature
        // 6. any remaining text : as description
        if (!preg_match(
            '/^
                # Static keyword
                # Declares a static method ONLY if type is also present
                (?:
                    (static)
                    \s+
                )?
                # Return type
                (?:
                    (
<<<<<<< HEAD
                        (?:[\w\|_\\\\]+)
                        # array notation           
                        (?:\[\])*
                    )?
                    \s+
                )?
                # Legacy method name (not captured)
                (?:
                    [\w_]+\(\)\s+
                )?
                # Method name
                ([\w\|_\\\\]+)
=======
                        (?:[\w\|_\\\\]*\$this[\w\|_\\\\]*)
                        |
                        (?:
                            (?:[\w\|_\\\\]+)
                            # array notation
                            (?:\[\])*
                        )*+
                    )
                    \s+
                )?
                # Method name
                ([\w_]+)
>>>>>>> v2-test
                # Arguments
                (?:
                    \(([^\)]*)\)
                )?
                \s*
                # Description
                (.*)
            $/sux',
            $body,
            $matches
        )) {
            return null;
        }

<<<<<<< HEAD
        list(, $static, $returnType, $methodName, $arguments, $description) = $matches;

        $static      = $static === 'static';
        $returnType  = $typeResolver->resolve($returnType, $context);
        $description = $descriptionFactory->create($description, $context);

        if ('' !== $arguments) {
            $arguments = explode(',', $arguments);
            foreach($arguments as &$argument) {
                $argument = explode(' ', trim($argument));
                if ($argument[0][0] === '$') {
                    $argumentName = substr($argument[0], 1);
                    $argumentType = new Void_();
=======
        [, $static, $returnType, $methodName, $argumentLines, $description] = $matches;

        $static = $static === 'static';

        if ($returnType === '') {
            $returnType = 'void';
        }

        $returnType  = $typeResolver->resolve($returnType, $context);
        $description = $descriptionFactory->create($description, $context);

        /** @phpstan-var array<int, array{name: string, type: Type}> $arguments */
        $arguments = [];
        if ($argumentLines !== '') {
            $argumentsExploded = explode(',', $argumentLines);
            foreach ($argumentsExploded as $argument) {
                $argument = explode(' ', self::stripRestArg(trim($argument)), 2);
                if (strpos($argument[0], '$') === 0) {
                    $argumentName = substr($argument[0], 1);
                    $argumentType = new Mixed_();
>>>>>>> v2-test
                } else {
                    $argumentType = $typeResolver->resolve($argument[0], $context);
                    $argumentName = '';
                    if (isset($argument[1])) {
<<<<<<< HEAD
=======
                        $argument[1]  = self::stripRestArg($argument[1]);
>>>>>>> v2-test
                        $argumentName = substr($argument[1], 1);
                    }
                }

<<<<<<< HEAD
                $argument = [ 'name' => $argumentName, 'type' => $argumentType];
            }
        } else {
            $arguments = [];
=======
                $arguments[] = ['name' => $argumentName, 'type' => $argumentType];
            }
>>>>>>> v2-test
        }

        return new static($methodName, $arguments, $returnType, $static, $description);
    }

    /**
     * Retrieves the method name.
<<<<<<< HEAD
     *
     * @return string
     */
    public function getMethodName()
=======
     */
    public function getMethodName() : string
>>>>>>> v2-test
    {
        return $this->methodName;
    }

    /**
<<<<<<< HEAD
     * @return string[]
     */
    public function getArguments()
=======
     * @return array<int, array<string, Type|string>>
     *
     * @phpstan-return array<int, array{name: string, type: Type}>
     */
    public function getArguments() : array
>>>>>>> v2-test
    {
        return $this->arguments;
    }

    /**
     * Checks whether the method tag describes a static method or not.
     *
     * @return bool TRUE if the method declaration is for a static method, FALSE otherwise.
     */
<<<<<<< HEAD
    public function isStatic()
=======
    public function isStatic() : bool
>>>>>>> v2-test
    {
        return $this->isStatic;
    }

<<<<<<< HEAD
    /**
     * @return Type
     */
    public function getReturnType()
=======
    public function getReturnType() : Type
>>>>>>> v2-test
    {
        return $this->returnType;
    }

<<<<<<< HEAD
    public function __toString()
=======
    public function __toString() : string
>>>>>>> v2-test
    {
        $arguments = [];
        foreach ($this->arguments as $argument) {
            $arguments[] = $argument['type'] . ' $' . $argument['name'];
        }

<<<<<<< HEAD
        return ($this->isStatic() ? 'static ' : '')
            . (string)$this->returnType . ' '
            . $this->methodName
            . '(' . implode(', ', $arguments) . ')'
            . ($this->description ? ' ' . $this->description->render() : '');
    }

    private function filterArguments($arguments)
    {
        foreach ($arguments as &$argument) {
            if (is_string($argument)) {
                $argument = [ 'name' => $argument ];
            }
            if (! isset($argument['type'])) {
                $argument['type'] = new Void_();
            }
            $keys = array_keys($argument);
            if ($keys !== [ 'name', 'type' ]) {
                throw new \InvalidArgumentException(
                    'Arguments can only have the "name" and "type" fields, found: ' . var_export($keys, true)
                );
            }
        }

        return $arguments;
=======
        $argumentStr = '(' . implode(', ', $arguments) . ')';

        if ($this->description) {
            $description = $this->description->render();
        } else {
            $description = '';
        }

        $static = $this->isStatic ? 'static' : '';

        $returnType = (string) $this->returnType;

        $methodName = (string) $this->methodName;

        return $static
            . ($returnType !== '' ? ($static !== '' ? ' ' : '') . $returnType : '')
            . ($methodName !== '' ? ($static !== '' || $returnType !== '' ? ' ' : '') . $methodName : '')
            . $argumentStr
            . ($description !== '' ? ' ' . $description : '');
    }

    /**
     * @param mixed[][]|string[] $arguments
     *
     * @return mixed[][]
     *
     * @phpstan-param array<int, array{name: string, type: Type}|string> $arguments
     * @phpstan-return array<int, array{name: string, type: Type}>
     */
    private function filterArguments(array $arguments = []) : array
    {
        $result = [];
        foreach ($arguments as $argument) {
            if (is_string($argument)) {
                $argument = ['name' => $argument];
            }

            if (!isset($argument['type'])) {
                $argument['type'] = new Mixed_();
            }

            $keys = array_keys($argument);
            sort($keys);
            if ($keys !== ['name', 'type']) {
                throw new InvalidArgumentException(
                    'Arguments can only have the "name" and "type" fields, found: ' . var_export($keys, true)
                );
            }

            $result[] = $argument;
        }

        return $result;
    }

    private static function stripRestArg(string $argument) : string
    {
        if (strpos($argument, '...') === 0) {
            $argument = trim(substr($argument, 3));
        }

        return $argument;
>>>>>>> v2-test
    }
}
