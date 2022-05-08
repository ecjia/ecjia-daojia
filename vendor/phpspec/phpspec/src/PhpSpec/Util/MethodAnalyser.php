<?php

/*
 * This file is part of PhpSpec, A php toolset to drive emergent
 * design by specification.
 *
 * (c) Marcello Duarte <marcello.duarte@gmail.com>
 * (c) Konstantin Kudryashov <ever.zet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpSpec\Util;

use PhpSpec\Loader\StreamWrapper;

class MethodAnalyser
{
    /**
     * @param string $class
     * @param string $method
     *
     * @return boolean
     */
<<<<<<< HEAD
    public function methodIsEmpty($class, $method)
=======
    public function methodIsEmpty(string $class, string $method): bool
>>>>>>> v2-test
    {
        return $this->reflectionMethodIsEmpty(new \ReflectionMethod($class, $method));
    }

    /**
     * @param \ReflectionMethod $method
     *
     * @return bool
     */
<<<<<<< HEAD
    public function reflectionMethodIsEmpty(\ReflectionMethod $method)
=======
    public function reflectionMethodIsEmpty(\ReflectionMethod $method): bool
>>>>>>> v2-test
    {
        if ($this->isNotImplementedInPhp($method)) {
            return false;
        }

        $code = $this->getCodeBody($method);
        $codeWithoutComments = $this->stripComments($code);

        return $this->codeIsOnlyBlocksAndWhitespace($codeWithoutComments);
    }

    /**
     * @param string $class
     * @param string $method
     *
     * @return string
     */
<<<<<<< HEAD
    public function getMethodOwnerName($class, $method)
=======
    public function getMethodOwnerName(string $class, string $method): string
>>>>>>> v2-test
    {
        $reflectionMethod = new \ReflectionMethod($class, $method);
        $startLine = $reflectionMethod->getStartLine();
        $endLine = $reflectionMethod->getEndLine();
        $reflectionClass  = $this->getMethodOwner($reflectionMethod, $startLine, $endLine);

        return $reflectionClass->getName();
    }

    /**
     * @param \ReflectionMethod $reflectionMethod
     *
     * @return string
     */
<<<<<<< HEAD
    private function getCodeBody(\ReflectionMethod $reflectionMethod)
=======
    private function getCodeBody(\ReflectionMethod $reflectionMethod): string
>>>>>>> v2-test
    {
        $endLine = $reflectionMethod->getEndLine();
        $startLine = $reflectionMethod->getStartLine();
        $reflectionClass = $this->getMethodOwner($reflectionMethod, $startLine, $endLine);

        $length = $endLine - $startLine;
        $lines = file(StreamWrapper::wrapPath($reflectionClass->getFileName()));
<<<<<<< HEAD
        $code = join(PHP_EOL, array_slice($lines, $startLine - 1, $length + 1));
=======
        $code = join(PHP_EOL, \array_slice($lines, $startLine - 1, $length + 1));
>>>>>>> v2-test

        return preg_replace('/.*function[^{]+{/s', '', $code);
    }

    /**
     * @param  \ReflectionMethod $reflectionMethod
     * @param  int $methodStartLine
     * @param  int $methodEndLine
     *
     * @return \ReflectionClass
     */
<<<<<<< HEAD
    private function getMethodOwner(\ReflectionMethod $reflectionMethod, $methodStartLine, $methodEndLine)
    {
        $reflectionClass = $reflectionMethod->getDeclaringClass();

        // PHP <=5.3 does not handle traits
        if (version_compare(PHP_VERSION, '5.4.0', '<')) {
            return $reflectionClass;
        }

=======
    private function getMethodOwner(\ReflectionMethod $reflectionMethod, int $methodStartLine, int $methodEndLine): \ReflectionClass
    {
        $reflectionClass = $reflectionMethod->getDeclaringClass();

>>>>>>> v2-test
        $fileName = $reflectionMethod->getFileName();
        $trait = $this->getDeclaringTrait($reflectionClass->getTraits(), $fileName, $methodStartLine, $methodEndLine);

        return $trait === null ? $reflectionClass : $trait;
    }

    /**
     * @param  \ReflectionClass[] $traits
     * @param  string  $file
     * @param  int $start
     * @param  int $end
     *
     * @return null|\ReflectionClass
     */
<<<<<<< HEAD
    private function getDeclaringTrait(array $traits, $file, $start, $end)
=======
    private function getDeclaringTrait(array $traits, string $file, int $start, int $end): ?\ReflectionClass
>>>>>>> v2-test
    {
        foreach ($traits as $trait) {
            if ($trait->getFileName() == $file && $trait->getStartLine() <= $start && $trait->getEndLine() >= $end) {
                return $trait;
            }
            if (null !== ( $trait = $this->getDeclaringTrait($trait->getTraits(), $file, $start, $end) )) {
                return $trait;
            }
        }

        return null;
    }

    /**
     * @param  string $code
     * @return string
     */
<<<<<<< HEAD
    private function stripComments($code)
=======
    private function stripComments(string $code): string
>>>>>>> v2-test
    {
        $tokens = token_get_all('<?php ' . $code);

        $comments = array_map(
            function ($token) {
                return $token[1];
            },
            array_filter(
                $tokens,
                function ($token) {
<<<<<<< HEAD
                    return is_array($token) && in_array($token[0], array(T_COMMENT, T_DOC_COMMENT));
=======
                    return \is_array($token) && \in_array($token[0], array(T_COMMENT, T_DOC_COMMENT));
>>>>>>> v2-test
                })
        );

        $commentless = str_replace($comments, '', $code);

        return $commentless;
    }

    /**
     * @param  string $codeWithoutComments
     * @return bool
     */
<<<<<<< HEAD
    private function codeIsOnlyBlocksAndWhitespace($codeWithoutComments)
=======
    private function codeIsOnlyBlocksAndWhitespace(string $codeWithoutComments): bool
>>>>>>> v2-test
    {
        return (bool) preg_match('/^[\s{}]*$/s', $codeWithoutComments);
    }

    /**
     * @param  \ReflectionMethod $method
     * @return bool
     */
<<<<<<< HEAD
    private function isNotImplementedInPhp(\ReflectionMethod $method)
=======
    private function isNotImplementedInPhp(\ReflectionMethod $method): bool
>>>>>>> v2-test
    {
        $filename = $method->getDeclaringClass()->getFileName();

        if (false === $filename) {
            return true;
        }

        // HHVM <=3.2.0 does not return FALSE correctly
        if (preg_match('#^/([:/]systemlib.|/$)#', $filename)) {
            return true;
        }

        return false;
    }
}
