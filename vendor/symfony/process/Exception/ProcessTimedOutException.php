<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Process\Exception;

use Symfony\Component\Process\Process;

/**
 * Exception that is thrown when a process times out.
 *
 * @author Johannes M. Schmitt <schmittjoh@gmail.com>
 */
class ProcessTimedOutException extends RuntimeException
{
<<<<<<< HEAD
    const TYPE_GENERAL = 1;
    const TYPE_IDLE = 2;
=======
    public const TYPE_GENERAL = 1;
    public const TYPE_IDLE = 2;
>>>>>>> v2-test

    private $process;
    private $timeoutType;

<<<<<<< HEAD
    public function __construct(Process $process, $timeoutType)
=======
    public function __construct(Process $process, int $timeoutType)
>>>>>>> v2-test
    {
        $this->process = $process;
        $this->timeoutType = $timeoutType;

        parent::__construct(sprintf(
            'The process "%s" exceeded the timeout of %s seconds.',
            $process->getCommandLine(),
            $this->getExceededTimeout()
        ));
    }

    public function getProcess()
    {
        return $this->process;
    }

    public function isGeneralTimeout()
    {
<<<<<<< HEAD
        return $this->timeoutType === self::TYPE_GENERAL;
=======
        return self::TYPE_GENERAL === $this->timeoutType;
>>>>>>> v2-test
    }

    public function isIdleTimeout()
    {
<<<<<<< HEAD
        return $this->timeoutType === self::TYPE_IDLE;
=======
        return self::TYPE_IDLE === $this->timeoutType;
>>>>>>> v2-test
    }

    public function getExceededTimeout()
    {
        switch ($this->timeoutType) {
            case self::TYPE_GENERAL:
                return $this->process->getTimeout();

            case self::TYPE_IDLE:
                return $this->process->getIdleTimeout();

            default:
                throw new \LogicException(sprintf('Unknown timeout type "%d".', $this->timeoutType));
        }
    }
}
