<?php
<<<<<<< HEAD
namespace phpDocumentor\Reflection;

=======

declare(strict_types=1);

namespace phpDocumentor\Reflection;

use phpDocumentor\Reflection\DocBlock\Tag;

// phpcs:ignore SlevomatCodingStandard.Classes.SuperfluousInterfaceNaming.SuperfluousSuffix
>>>>>>> v2-test
interface DocBlockFactoryInterface
{
    /**
     * Factory method for easy instantiation.
     *
<<<<<<< HEAD
     * @param string[] $additionalTags
     *
     * @return DocBlockFactory
     */
    public static function createInstance(array $additionalTags = []);

    /**
     * @param string $docblock
     * @param Types\Context $context
     * @param Location $location
     *
     * @return DocBlock
     */
    public function create($docblock, Types\Context $context = null, Location $location = null);
=======
     * @param array<string, class-string<Tag>> $additionalTags
     */
    public static function createInstance(array $additionalTags = []) : DocBlockFactory;

    /**
     * @param string|object $docblock
     */
    public function create($docblock, ?Types\Context $context = null, ?Location $location = null) : DocBlock;
>>>>>>> v2-test
}
