<?php
<<<<<<< HEAD
/**
 * phpDocumentor
 *
 * PHP Version 5.3
 *
 * @author    Ben Selby <benmatselby@gmail.com>
 * @copyright 2010-2011 Mike van Riel / Naenius (http://www.naenius.com)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://phpdoc.org
=======

declare(strict_types=1);

/**
 * This file is part of phpDocumentor.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @link http://phpdoc.org
>>>>>>> v2-test
 */

namespace phpDocumentor\Reflection\DocBlock\Tags;

use phpDocumentor\Reflection\DocBlock\Description;
use phpDocumentor\Reflection\DocBlock\DescriptionFactory;
use phpDocumentor\Reflection\Types\Context as TypeContext;
<<<<<<< HEAD
use Webmozart\Assert\Assert;

/**
 * Reflection class for a @link tag in a Docblock.
 */
final class Link extends BaseTag implements Factory\StaticMethod
{
    protected $name = 'link';

    /** @var string */
    private $link = '';

    /**
     * Initializes a link to a URL.
     *
     * @param string      $link
     * @param Description $description
     */
    public function __construct($link, Description $description = null)
    {
        Assert::string($link);

        $this->link = $link;
        $this->description = $description;
    }

    /**
     * {@inheritdoc}
     */
    public static function create($body, DescriptionFactory $descriptionFactory = null, TypeContext $context = null)
    {
        Assert::string($body);
        Assert::notNull($descriptionFactory);

        $parts = preg_split('/\s+/Su', $body, 2);
=======
use phpDocumentor\Reflection\Utils;
use Webmozart\Assert\Assert;

/**
 * Reflection class for a {@}link tag in a Docblock.
 */
final class Link extends BaseTag implements Factory\StaticMethod
{
    /** @var string */
    protected $name = 'link';

    /** @var string */
    private $link;

    /**
     * Initializes a link to a URL.
     */
    public function __construct(string $link, ?Description $description = null)
    {
        $this->link        = $link;
        $this->description = $description;
    }

    public static function create(
        string $body,
        ?DescriptionFactory $descriptionFactory = null,
        ?TypeContext $context = null
    ) : self {
        Assert::notNull($descriptionFactory);

        $parts = Utils::pregSplit('/\s+/Su', $body, 2);
>>>>>>> v2-test
        $description = isset($parts[1]) ? $descriptionFactory->create($parts[1], $context) : null;

        return new static($parts[0], $description);
    }

    /**
<<<<<<< HEAD
    * Gets the link
    *
    * @return string
    */
    public function getLink()
=======
     * Gets the link
     */
    public function getLink() : string
>>>>>>> v2-test
    {
        return $this->link;
    }

    /**
     * Returns a string representation for this tag.
<<<<<<< HEAD
     *
     * @return string
     */
    public function __toString()
    {
        return $this->link . ($this->description ? ' ' . $this->description->render() : '');
=======
     */
    public function __toString() : string
    {
        if ($this->description) {
            $description = $this->description->render();
        } else {
            $description = '';
        }

        $link = (string) $this->link;

        return $link . ($description !== '' ? ($link !== '' ? ' ' : '') . $description : '');
>>>>>>> v2-test
    }
}
