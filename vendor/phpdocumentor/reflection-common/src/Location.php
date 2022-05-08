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

namespace phpDocumentor\Reflection;

/**
 * The location where an element occurs within a file.
<<<<<<< HEAD
 */
final class Location
{
    /** @var int  */
=======
 *
 * @psalm-immutable
 */
final class Location
{
    /** @var int */
>>>>>>> v2-test
    private $lineNumber = 0;

    /** @var int */
    private $columnNumber = 0;

    /**
     * Initializes the location for an element using its line number in the file and optionally the column number.
<<<<<<< HEAD
     *
     * @param int $lineNumber
     * @param int $columnNumber
     */
    public function __construct($lineNumber, $columnNumber = 0)
    {
        $this->lineNumber   = $lineNumber;
=======
     */
    public function __construct(int $lineNumber, int $columnNumber = 0)
    {
        $this->lineNumber = $lineNumber;
>>>>>>> v2-test
        $this->columnNumber = $columnNumber;
    }

    /**
     * Returns the line number that is covered by this location.
<<<<<<< HEAD
     *
     * @return integer
     */
    public function getLineNumber()
=======
     */
    public function getLineNumber() : int
>>>>>>> v2-test
    {
        return $this->lineNumber;
    }

    /**
     * Returns the column number (character position on a line) for this location object.
<<<<<<< HEAD
     *
     * @return integer
     */
    public function getColumnNumber()
=======
     */
    public function getColumnNumber() : int
>>>>>>> v2-test
    {
        return $this->columnNumber;
    }
}
