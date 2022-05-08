<?php

namespace PhpSpec\Listener;

<<<<<<< HEAD
use PhpSpec\Console\IO;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class BootstrapListener implements EventSubscriberInterface
{
    /**
     * @var IO
     */
    private $io;

    public function __construct(IO $io)
=======
use PhpSpec\Console\ConsoleIO;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class BootstrapListener implements EventSubscriberInterface
{
    /**
     * @var ConsoleIO
     */
    private $io;

    public function __construct(ConsoleIO $io)
>>>>>>> v2-test
    {
        $this->io = $io;
    }

    public static function getSubscribedEvents()
    {
        return array('beforeSuite' => array('beforeSuite', 1100));
    }

<<<<<<< HEAD
    public function beforeSuite()
=======
    public function beforeSuite(): void
>>>>>>> v2-test
    {
        if ($bootstrap = $this->io->getBootstrapPath()) {
            if (!is_file($bootstrap)) {
                throw new \RuntimeException(sprintf("Bootstrap file '%s' does not exist", $bootstrap));
            }

            require $bootstrap;
        }
    }
}
