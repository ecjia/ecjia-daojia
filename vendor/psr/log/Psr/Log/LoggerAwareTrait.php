<?php

namespace Psr\Log;

/**
 * Basic Implementation of LoggerAwareInterface.
 */
trait LoggerAwareTrait
{
<<<<<<< HEAD
    /** @var LoggerInterface */
=======
    /**
     * The logger instance.
     *
     * @var LoggerInterface
     */
>>>>>>> v2-test
    protected $logger;

    /**
     * Sets a logger.
<<<<<<< HEAD
     * 
=======
     *
>>>>>>> v2-test
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
}
