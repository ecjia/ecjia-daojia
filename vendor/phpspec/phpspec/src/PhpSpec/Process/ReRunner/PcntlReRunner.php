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

class PcntlReRunner extends PhpExecutableReRunner
{
    /**
     * @var ExecutionContextInterface
=======
use PhpSpec\Process\Context\ExecutionContext;
use Symfony\Component\Process\PhpExecutableFinder;

final class PcntlReRunner extends PhpExecutableReRunner
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
     * @return bool
     */
<<<<<<< HEAD
    public function isSupported()
=======
    public function isSupported(): bool
>>>>>>> v2-test
    {
        return (php_sapi_name() == 'cli')
            && $this->getExecutablePath()
            && function_exists('pcntl_exec')
<<<<<<< HEAD
            && !defined('HHVM_VERSION');
=======
            && !\defined('HHVM_VERSION');
>>>>>>> v2-test
    }

    /**
     * Kills the current process and starts a new one
     */
<<<<<<< HEAD
    public function reRunSuite()
=======
    public function reRunSuite(): void
>>>>>>> v2-test
    {
        $args = $_SERVER['argv'];
        $env = $this->executionContext ? $this->executionContext->asEnv() : array();

<<<<<<< HEAD
        pcntl_exec($this->getExecutablePath(), $args, array_merge($env, $_SERVER));
=======
        $env = array_filter(
            array_merge($env, $_SERVER),
            function($x): bool { return !is_array($x); }
        );

        pcntl_exec($this->getExecutablePath(), $args, $env);
>>>>>>> v2-test
    }
}
