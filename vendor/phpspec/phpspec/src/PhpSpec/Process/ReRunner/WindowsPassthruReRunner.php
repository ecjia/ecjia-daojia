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

namespace PhpSpec\Process\ReRunner;

<<<<<<< HEAD
use PhpSpec\Process\Context\ExecutionContextInterface;
use Symfony\Component\Process\PhpExecutableFinder;

class WindowsPassthruReRunner extends PhpExecutableReRunner
{
    /**
     * @var ExecutionContextInterface
=======
use PhpSpec\Process\Context\ExecutionContext;
use Symfony\Component\Process\PhpExecutableFinder;

final class WindowsPassthruReRunner extends PhpExecutableReRunner
{
    /**
     * @var ExecutionContext
>>>>>>> v2-test
     */
    private $executionContext;

    /**
     * @param PhpExecutableFinder $phpExecutableFinder
<<<<<<< HEAD
     * @param ExecutionContextInterface $executionContext
     * @return static
     */
    public static function withExecutionContext(PhpExecutableFinder $phpExecutableFinder, ExecutionContextInterface $executionContext)
=======
     * @param ExecutionContext $executionContext
     * @return static
     */
    public static function withExecutionContext(PhpExecutableFinder $phpExecutableFinder, ExecutionContext $executionContext)
>>>>>>> v2-test
    {
        $reRunner = new static($phpExecutableFinder);
        $reRunner->executionContext = $executionContext;

        return $reRunner;
    }

    /**
     * @return boolean
     */
<<<<<<< HEAD
    public function isSupported()
=======
    public function isSupported(): bool
>>>>>>> v2-test
    {
        return (php_sapi_name() == 'cli')
            && $this->getExecutablePath()
            && function_exists('passthru')
            && (stripos(PHP_OS, "win") === 0);
    }

<<<<<<< HEAD
    public function reRunSuite()
=======
    public function reRunSuite(): void
>>>>>>> v2-test
    {
        $args = $_SERVER['argv'];
        $command = $this->buildArgString() . escapeshellarg($this->getExecutablePath()) . ' ' . join(' ', array_map('escapeshellarg', $args));

        passthru($command, $exitCode);
        exit($exitCode);
    }

<<<<<<< HEAD
    private function buildArgString()
=======
    private function buildArgString() : string
>>>>>>> v2-test
    {
        $argstring = '';

        foreach ($this->executionContext->asEnv() as $key => $value) {
            $argstring .= 'SET ' . $key . '=' . $value . ' && ';
        }

        return $argstring;
    }
}
