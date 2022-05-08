<?php
<<<<<<< HEAD
/**
 * phpDocumentor
 *
 * PHP Version 5.5
 *
 * @copyright 2010-2015 Mike van Riel / Naenius (http://www.naenius.com)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
=======

declare(strict_types=1);

/**
 * phpDocumentor
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
>>>>>>> v2-test
 * @link      http://phpdoc.org
 */

namespace phpDocumentor\Reflection;

<<<<<<< HEAD
=======
use InvalidArgumentException;
use function assert;
use function end;
use function explode;
use function is_string;
use function preg_match;
use function sprintf;
use function trim;

>>>>>>> v2-test
/**
 * Value Object for Fqsen.
 *
 * @link https://github.com/phpDocumentor/fig-standards/blob/master/proposed/phpdoc-meta.md
<<<<<<< HEAD
 */
final class Fqsen
{
    /**
     * @var string full quallified class name
     */
    private $fqsen;

    /**
     * @var string name of the element without path.
     */
=======
 *
 * @psalm-immutable
 */
final class Fqsen
{
    /** @var string full quallified class name */
    private $fqsen;

    /** @var string name of the element without path. */
>>>>>>> v2-test
    private $name;

    /**
     * Initializes the object.
     *
<<<<<<< HEAD
     * @param string $fqsen
     *
     * @throws \InvalidArgumentException when $fqsen is not matching the format.
     */
    public function __construct($fqsen)
    {
        $matches = array();
        $result = preg_match('/^\\\\([\\w_\\\\]*)(?:[:]{2}\\$?([\\w_]+))?(?:\\(\\))?$/', $fqsen, $matches);

        if ($result === 0) {
            throw new \InvalidArgumentException(
=======
     * @throws InvalidArgumentException when $fqsen is not matching the format.
     */
    public function __construct(string $fqsen)
    {
        $matches = [];

        $result = preg_match(
            //phpcs:ignore Generic.Files.LineLength.TooLong
            '/^\\\\([a-zA-Z_\\x7f-\\xff][a-zA-Z0-9_\\x7f-\\xff\\\\]*)?(?:[:]{2}\\$?([a-zA-Z_\\x7f-\\xff][a-zA-Z0-9_\\x7f-\\xff]*))?(?:\\(\\))?$/',
            $fqsen,
            $matches
        );

        if ($result === 0) {
            throw new InvalidArgumentException(
>>>>>>> v2-test
                sprintf('"%s" is not a valid Fqsen.', $fqsen)
            );
        }

        $this->fqsen = $fqsen;

        if (isset($matches[2])) {
            $this->name = $matches[2];
        } else {
            $matches = explode('\\', $fqsen);
<<<<<<< HEAD
            $this->name = trim(end($matches), '()');
=======
            $name = end($matches);
            assert(is_string($name));
            $this->name = trim($name, '()');
>>>>>>> v2-test
        }
    }

    /**
     * converts this class to string.
<<<<<<< HEAD
     *
     * @return string
     */
    public function __toString()
=======
     */
    public function __toString() : string
>>>>>>> v2-test
    {
        return $this->fqsen;
    }

    /**
     * Returns the name of the element without path.
<<<<<<< HEAD
     *
     * @return string
     */
    public function getName()
=======
     */
    public function getName() : string
>>>>>>> v2-test
    {
        return $this->name;
    }
}
