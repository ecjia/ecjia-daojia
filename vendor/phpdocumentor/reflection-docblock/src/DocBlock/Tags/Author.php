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
use Webmozart\Assert\Assert;
=======
use InvalidArgumentException;
use function filter_var;
use function preg_match;
use function trim;
use const FILTER_VALIDATE_EMAIL;
>>>>>>> v2-test

/**
 * Reflection class for an {@}author tag in a Docblock.
 */
final class Author extends BaseTag implements Factory\StaticMethod
{
    /** @var string register that this is the author tag. */
    protected $name = 'author';

    /** @var string The name of the author */
<<<<<<< HEAD
    private $authorName = '';

    /** @var string The email of the author */
    private $authorEmail = '';

    /**
     * Initializes this tag with the author name and e-mail.
     *
     * @param string $authorName
     * @param string $authorEmail
     */
    public function __construct($authorName, $authorEmail)
    {
        Assert::string($authorName);
        Assert::string($authorEmail);
        if ($authorEmail && !filter_var($authorEmail, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('The author tag does not have a valid e-mail address');
=======
    private $authorName;

    /** @var string The email of the author */
    private $authorEmail;

    /**
     * Initializes this tag with the author name and e-mail.
     */
    public function __construct(string $authorName, string $authorEmail)
    {
        if ($authorEmail && !filter_var($authorEmail, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('The author tag does not have a valid e-mail address');
>>>>>>> v2-test
        }

        $this->authorName  = $authorName;
        $this->authorEmail = $authorEmail;
    }

    /**
     * Gets the author's name.
     *
     * @return string The author's name.
     */
<<<<<<< HEAD
    public function getAuthorName()
=======
    public function getAuthorName() : string
>>>>>>> v2-test
    {
        return $this->authorName;
    }

    /**
     * Returns the author's email.
     *
     * @return string The author's email.
     */
<<<<<<< HEAD
    public function getEmail()
=======
    public function getEmail() : string
>>>>>>> v2-test
    {
        return $this->authorEmail;
    }

    /**
     * Returns this tag in string form.
<<<<<<< HEAD
     *
     * @return string
     */
    public function __toString()
    {
        return $this->authorName . '<' . $this->authorEmail . '>';
=======
     */
    public function __toString() : string
    {
        if ($this->authorEmail) {
            $authorEmail = '<' . $this->authorEmail . '>';
        } else {
            $authorEmail = '';
        }

        $authorName = (string) $this->authorName;

        return $authorName . ($authorEmail !== '' ? ($authorName !== '' ? ' ' : '') . $authorEmail : '');
>>>>>>> v2-test
    }

    /**
     * Attempts to create a new Author object based on †he tag body.
<<<<<<< HEAD
     *
     * @param string $body
     *
     * @return static
     */
    public static function create($body)
    {
        Assert::string($body);

=======
     */
    public static function create(string $body) : ?self
    {
>>>>>>> v2-test
        $splitTagContent = preg_match('/^([^\<]*)(?:\<([^\>]*)\>)?$/u', $body, $matches);
        if (!$splitTagContent) {
            return null;
        }

        $authorName = trim($matches[1]);
<<<<<<< HEAD
        $email = isset($matches[2]) ? trim($matches[2]) : '';
=======
        $email      = isset($matches[2]) ? trim($matches[2]) : '';
>>>>>>> v2-test

        return new static($authorName, $email);
    }
}
