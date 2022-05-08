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
=======
use PhpSpec\Process\Context\ExecutionContext;
>>>>>>> v2-test
use Symfony\Component\Process\PhpExecutableFinder;

final class ProcOpenReRunner extends PhpExecutableReRunner
{
    /**
<<<<<<< HEAD
     * @var ExecutionContextInterface
=======
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
            && (stripos(PHP_OS, "win") !== 0);
    }

<<<<<<< HEAD
    public function reRunSuite()
=======
    public function reRunSuite(): void
>>>>>>> v2-test
    {
        $args = $_SERVER['argv'];
        $command = $this->buildArgString() . escapeshellcmd($this->getExecutablePath()).' '.join(' ', array_map('escapeshellarg', $args)) . ' 2>&1';

<<<<<<< HEAD
        $desc = array(
            0 => array('file', 'php://stdin', 'r'),
            1 => array('file', 'php://stdout', 'w'),
            2 => array('file', 'php://stderr', 'w'),
        );
=======
        $desc = [
            0 => ['file', 'php://stdin', 'r'],
            1 => ['file', 'php://stdout', 'w'],
            2 => ['file', 'php://stderr', 'w'],
        ];
>>>>>>> v2-test
        $proc = proc_open( $command, $desc, $pipes );

        do {
            sleep(1);
            $status = proc_get_status($proc);
        } while ($status['running']);

        exit($status['exitcode']);
    }

<<<<<<< HEAD
    private function buildArgString()
=======
    private function buildArgString() : string
>>>>>>> v2-test
    {
        $argstring = '';

        foreach ($this->executionContext->asEnv() as $key => $value) {
            $argstring .= $key . '=' . escapeshellarg($value) . ' ';
        }

        return $argstring;
    }
}
