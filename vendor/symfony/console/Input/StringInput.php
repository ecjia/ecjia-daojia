<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Console\Input;

use Symfony\Component\Console\Exception\InvalidArgumentException;

/**
 * StringInput represents an input provided as a string.
 *
 * Usage:
 *
 *     $input = new StringInput('foo --bar="foobar"');
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class StringInput extends ArgvInput
{
<<<<<<< HEAD
    const REGEX_STRING = '([^\s]+?)(?:\s|(?<!\\\\)"|(?<!\\\\)\'|$)';
    const REGEX_QUOTED_STRING = '(?:"([^"\\\\]*(?:\\\\.[^"\\\\]*)*)"|\'([^\'\\\\]*(?:\\\\.[^\'\\\\]*)*)\')';
=======
    public const REGEX_STRING = '([^\s]+?)(?:\s|(?<!\\\\)"|(?<!\\\\)\'|$)';
    public const REGEX_QUOTED_STRING = '(?:"([^"\\\\]*(?:\\\\.[^"\\\\]*)*)"|\'([^\'\\\\]*(?:\\\\.[^\'\\\\]*)*)\')';
>>>>>>> v2-test

    /**
     * @param string $input A string representing the parameters from the CLI
     */
<<<<<<< HEAD
    public function __construct($input)
    {
        parent::__construct(array());
=======
    public function __construct(string $input)
    {
        parent::__construct([]);
>>>>>>> v2-test

        $this->setTokens($this->tokenize($input));
    }

    /**
     * Tokenizes a string.
     *
<<<<<<< HEAD
     * @param string $input The input to tokenize
     *
     * @return array An array of tokens
     *
     * @throws InvalidArgumentException When unable to parse input (should never happen)
     */
    private function tokenize($input)
    {
        $tokens = array();
=======
     * @throws InvalidArgumentException When unable to parse input (should never happen)
     */
    private function tokenize(string $input): array
    {
        $tokens = [];
>>>>>>> v2-test
        $length = \strlen($input);
        $cursor = 0;
        while ($cursor < $length) {
            if (preg_match('/\s+/A', $input, $match, null, $cursor)) {
            } elseif (preg_match('/([^="\'\s]+?)(=?)('.self::REGEX_QUOTED_STRING.'+)/A', $input, $match, null, $cursor)) {
<<<<<<< HEAD
                $tokens[] = $match[1].$match[2].stripcslashes(str_replace(array('"\'', '\'"', '\'\'', '""'), '', substr($match[3], 1, \strlen($match[3]) - 2)));
=======
                $tokens[] = $match[1].$match[2].stripcslashes(str_replace(['"\'', '\'"', '\'\'', '""'], '', substr($match[3], 1, \strlen($match[3]) - 2)));
>>>>>>> v2-test
            } elseif (preg_match('/'.self::REGEX_QUOTED_STRING.'/A', $input, $match, null, $cursor)) {
                $tokens[] = stripcslashes(substr($match[0], 1, \strlen($match[0]) - 2));
            } elseif (preg_match('/'.self::REGEX_STRING.'/A', $input, $match, null, $cursor)) {
                $tokens[] = stripcslashes($match[1]);
            } else {
                // should never happen
<<<<<<< HEAD
                throw new InvalidArgumentException(sprintf('Unable to parse input near "... %s ..."', substr($input, $cursor, 10)));
=======
                throw new InvalidArgumentException(sprintf('Unable to parse input near "... %s ...".', substr($input, $cursor, 10)));
>>>>>>> v2-test
            }

            $cursor += \strlen($match[0]);
        }

        return $tokens;
    }
}
