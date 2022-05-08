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

namespace PhpSpec\CodeGenerator\Writer;

use PhpSpec\Util\ClassFileAnalyser;

final class TokenizedCodeWriter implements CodeWriter
{
    /**
     * @var ClassFileAnalyser
     */
    private $analyser;

    /**
     * @param ClassFileAnalyser $analyser
     */
<<<<<<< HEAD
    public function __construct(ClassFileAnalyser $analyser = null)
    {
        $this->analyser = $analyser ?: new ClassFileAnalyser();
    }

    /**
     * @param string $class
     * @param string $method
     * @return string
     */
    public function insertMethodFirstInClass($class, $method)
=======
    public function __construct(ClassFileAnalyser $analyser)
    {
        $this->analyser = $analyser;
    }

    public function insertMethodFirstInClass(string $class, string $method): string
>>>>>>> v2-test
    {
        if (!$this->analyser->classHasMethods($class)) {
            return $this->writeAtEndOfClass($class, $method);
        }

        $line = $this->analyser->getStartLineOfFirstMethod($class);

        return $this->insertStringBeforeLine($class, $method, $line);
    }

<<<<<<< HEAD
    /**
     * @param string $class
     * @param string $method
     * @return string
     */
    public function insertMethodLastInClass($class, $method)
=======
    public function insertMethodLastInClass(string $class, string $method): string
>>>>>>> v2-test
    {
        if ($this->analyser->classHasMethods($class)) {
            $line = $this->analyser->getEndLineOfLastMethod($class);
            return $this->insertStringAfterLine($class, $method, $line);
        }

        return $this->writeAtEndOfClass($class, $method);
    }

<<<<<<< HEAD
    /**
     * @param string $class
     * @param string $methodName
     * @param string $method
     * @return string
     */
    public function insertAfterMethod($class, $methodName, $method)
=======
    public function insertAfterMethod(string $class, string $methodName, string $method): string
>>>>>>> v2-test
    {
        $line = $this->analyser->getEndLineOfNamedMethod($class, $methodName);

        return $this->insertStringAfterLine($class, $method, $line);
    }

<<<<<<< HEAD
    /**
     * @param string $target
     * @param string $toInsert
     * @param int $line
     * @param bool $leadingNewline
     * @return string
     */
    private function insertStringAfterLine($target, $toInsert, $line, $leadingNewline = true)
    {
        $lines = explode("\n", $target);
        $lastLines = array_slice($lines, $line);
=======
    private function insertStringAfterLine(string $target, string $toInsert, int $line, bool $leadingNewline = true): string
    {
        $lines = explode("\n", $target);
        $lastLines = \array_slice($lines, $line);
>>>>>>> v2-test
        $toInsert = trim($toInsert, "\n\r");
        if ($leadingNewline) {
            $toInsert = "\n" . $toInsert;
        }
        array_unshift($lastLines, $toInsert);
<<<<<<< HEAD
        array_splice($lines, $line, count($lines), $lastLines);
=======
        array_splice($lines, $line, \count($lines), $lastLines);
>>>>>>> v2-test

        return implode("\n", $lines);
    }

<<<<<<< HEAD
    /**
     * @param string $target
     * @param string $toInsert
     * @param int $line
     * @return string
     */
    private function insertStringBeforeLine($target, $toInsert, $line)
    {
        $line--;
        $lines = explode("\n", $target);
        $lastLines = array_slice($lines, $line);
        array_unshift($lastLines, trim($toInsert, "\n\r") . "\n");
        array_splice($lines, $line, count($lines), $lastLines);
=======
    private function insertStringBeforeLine(string $target, string $toInsert, int $line): string
    {
        $line--;
        $lines = explode("\n", $target);
        $lastLines = \array_slice($lines, $line);
        array_unshift($lastLines, trim($toInsert, "\n\r") . "\n");
        array_splice($lines, $line, \count($lines), $lastLines);
>>>>>>> v2-test

        return implode("\n", $lines);
    }

<<<<<<< HEAD
    /**
     * @param string $class
     * @param string $method
     * @param bool $prependNewLine
     * @return string
     */
    private function writeAtEndOfClass($class, $method, $prependNewLine = false)
=======
    private function writeAtEndOfClass(string $class, string $method): string
>>>>>>> v2-test
    {
        $tokens = token_get_all($class);
        $searching = false;
        $inString = false;
        $searchPattern = array();

<<<<<<< HEAD
        for ($i = count($tokens) - 1; $i >= 0; $i--) {
=======
        for ($i = \count($tokens) - 1; $i >= 0; $i--) {
>>>>>>> v2-test
            $token = $tokens[$i];

            if ($token === '}' && !$inString) {
                $searching = true;
                continue;
            }

            if (!$searching) {
                continue;
            }

            if ($token === '"') {
                $inString = !$inString;
                continue;
            }

            if ($this->isWritePoint($token)) {
                $line = $token[2];
<<<<<<< HEAD
                return $this->insertStringAfterLine($class, $method, $line, $token[0] === T_COMMENT ?: $prependNewLine);
            }

            array_unshift($searchPattern, is_array($token) ? $token[1] : $token);

            if ($token === '{') {
                $search = implode('', $searchPattern);
                $position = strpos($class, $search) + strlen($search) - 1;
=======
                $prependNewLine = $token[0] === T_COMMENT || ($i != 0 && $tokens[$i-1][0] === T_COMMENT);
                return $this->insertStringAfterLine($class, $method, $line, $prependNewLine);
            }

            array_unshift($searchPattern, \is_array($token) ? $token[1] : $token);

            if ($token === '{') {
                $search = implode('', $searchPattern);
                $position = strpos($class, $search) + \strlen($search) - 1;
>>>>>>> v2-test

                return substr_replace($class, "\n" . $method . "\n", $position, 0);
            }
        }
    }

    /**
     * @param $token
<<<<<<< HEAD
     * @return bool
     */
    private function isWritePoint($token)
    {
        return is_array($token) && ($token[1] === "\n" || $token[0] === T_COMMENT);
=======
     */
    private function isWritePoint($token): bool
    {
        return \is_array($token) && ($token[1] === "\n" || $token[0] === T_COMMENT);
>>>>>>> v2-test
    }
}
